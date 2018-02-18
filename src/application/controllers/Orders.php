<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller 
{
    private $pagination_config = array(
        'per_page'      => 49,
        'num_links'     => 1,
        'full_tag_open' => '<div class="btn-group" role="group" aria-label="Pagination">',
        'full_tag_close'=> '</div>',
        'attributes'    => array('class' => 'btn btn-gbr', 'role' => 'button'),
        'cur_tag_open' => '<a href="" role="button" class="btn btn-gbr active">',
        'cur_tag_close' => '</a>',
        'last_link'     => 'Last',
        'first_link'    => 'First'
    );

    public function __construct()
    {
        parent::__construct();

        // Check to see if user is logged in.
        if( ! $this->session->logged_in )
        {
            redirect('users/login');
        }
    }

    public function index()
    {
        $this->pagination_config['base_url'] = '/orders/index/';
        $this->pagination_config['total_rows'] = $this->order->count_orders();

        $this->pagination->initialize($this->pagination_config);

        $data['orders'] = $this->order->get_orders(NULL, $this->pagination_config['per_page'], $this->uri->segment(3));
        $data['paginator'] = $this->pagination->create_links();

        // Load the main view.
        $data['main_view'] = 'orders/index';
        $this->load->view('layout/main', $data);
    }

    public function create($type, $customer_id = NULL)
    {
        // TODO: create validation for the create form.
        $this->form_validation->set_rules('customer_id', 'Customer', 'required');
        $this->form_validation->set_rules('date', 'Date', 'required');
        $this->form_validation->set_rules('time', 'Time', 'required');
        $this->form_validation->set_rules('tax_rate', 'Tax Rate', 'required');
        $this->form_validation->set_rules('job_name', 'Job Name', 'required');
        $this->form_validation->set_rules('job_city', 'Job City', 'required');
        $this->form_validation->set_rules('job_address', 'Job Address', 'required');
        $this->form_validation->set_rules('job_zipcode', 'Job Zipcode', 'required');
        $this->form_validation->set_rules('ordered_by', 'Ordered By', 'required');
        $this->form_validation->set_rules('onsite_contact', 'On-Site Contact', 'required');
        $this->form_validation->set_rules('onsite_contact_phone', 'On-Site Contact Phone Number', 'required');

        if( ! $this->form_validation->run() )
        {
            $return_id = '';

            if( ! is_null($customer_id) )
            {
                $this->customer->set_customer_data((int)$customer_id);
                $return_id = $customer_id;
            }

            $shipping_products = $this->product->get_products([['item_type ='=>'pickup'],['item_type'=>'delivery']], NULL, NULL, TRUE);

            if( $type == 'rental' )
            {
                $container_products = $this->product->get_products(['item_type =' => 'container', 'rental_type =' => 'Rental']);
                $modification_products = $this->product->get_products("item_type <> 'container' AND item_type <> 'pickup' AND item_type <> 'delivery' AND rental_type = 'Rental'");
            }
            elseif( $type == 'sales' )
            {
                $container_products = $this->product->get_products(['item_type' => 'container', 'rental_type =' => 'Nonrental']);
                $modification_products = $this->product->get_products("item_type <> 'container' AND item_type <> 'pickup' AND item_type <> 'delivery' AND rental_type = 'Nonrental'");
            }

            $data = array(
                'customers'             => $this->customer->get_customers(),
                'customer'              => $this->customer,
                'shipping_products'     => $shipping_products,
                'container_products'    => $container_products,
                'modification_products' => $modification_products,
                'type'                  => $type,
                'rental_array'          => $this->product->get_rental_array(),
                'pud_array'             => $this->product->get_pud_array(),
                'main_view'             => 'orders/create'
            );

            $this->load->view('layout/main', $data);
        }
        else
        {
            if( $this->input->post('quote_id') )
            {
                // if quote_id is posted, we are converting a quote to an order
                $this->order->set_quote_id((int)$this->input->post('quote_id'))->get_quote_products();
            }

            $this->customer->set_customer_data((int)$this->input->post('customer_id'));

            $post_date = $this->input->post('date');
            $date_exploded = explode('-',$post_date);
            $temp_date = new DateTime($date_exploded[1] . '-' . $date_exploded[0] . '-' . $date_exploded[2]);
            $date = date_format($temp_date, 'Y-m-d');

            $this->order->set_customer($this->customer->get_name())
                        ->set_customer_id((int)$this->customer->get_id())
                        ->set_date($date)
                        ->set_time($this->input->post('time'))
                        ->set_type($this->input->post('type'))
                        ->set_job_name($this->input->post('job_name'))
                        ->set_job_city($this->input->post('job_city'))
                        ->set_job_address($this->input->post('job_address'))
                        ->set_job_zipcode($this->input->post('job_zipcode'))
                        ->set_ordered_by($this->input->post('ordered_by'))
                        ->set_onsite_contact($this->input->post('onsite_contact'))
                        ->set_onsite_contact_phone($this->input->post('onsite_contact_phone'))
                        ->set_tax_rate((float)$this->input->post('tax_rate'))
                        ->set_cost_before_tax($this->input->post('cost_before_tax'))
                        ->set_total_cost($this->input->post('total_cost'))
                        ->set_sales_tax($this->input->post('sales_tax'))
                        ->set_monthly_total($this->input->post('monthly_total'))
                        ->set_delivery_total($this->input->post('delivery_total'))
                        ->set_stage(1);

            if( $new_id = $this->order->create() )
            {
                $item_count = (int)$this->input->post('itemCount');

                // create an event
                if( $this->event->create( (int)$new_id ) )
                {
                    // converting a quoted products to ordered products
                    if( $this->input->post('quote_id') )
                    {
                        if( $this->order->insert_ordered_products((int)$item_count, (int)$new_id, (int)$quote_id) )
                        {
                            $_SESSION['success_msg'] = 'The order was created successfully.';
                            redirect('orders/view/'. $new_id);
                        }
                        else
                        {
                            $_SESSION['error_msg'] = 'The ordered products were not inserted properly.';
                            redirect('orders/create/'.$order->get_type() .'/'. $return_id);
                        }
                    }
                    // otherwise create new ordered products.
                    else
                    {
                        if( $this->order->insert_ordered_products((int)$item_count, (int)$new_id) )

                        {
                            $_SESSION['success_msg'] = 'The order was created successfully.';
                            redirect('orders/view/'. $new_id);
                        }
                        else
                        {
                            $_SESSION['error_msg'] = 'The ordered products were not inserted properly.';
                            redirect('orders/create/'.$this->order->get_type() .'/'. $return_id);
                        }
                    }
                }
                else
                {
                    $_SESSION['error_msg'] = 'The order was created, but the event couldnt be created, the ordered products were not recorded either.';
                    redirect('orders/create/'.$order->get_type() .'/'. $return_id);
                }
                
            }
            else
            {
                $_SESSION['error_msg'] = 'The order was not created properly.';
                redirect('orders/create/'.$order->get_type() .'/'. $return_id);
            }
        }
    }

    // previously called edit()
    public function view($id)
    {
        
        // TODO: create validation for the form.

        if( ! $this->form_validation->run() )
        {
            $this->order->set_order_data((int)$id)->get_order_products();
        
            $this->customer->set_customer_data($this->order->get_customer());

            if( $this->order->get_delivered() )
            {
                $driver = $this->user->set_user_data($this->order->get_driver());
            }
            else
            {
                $driver = NULL;
            }

            $shipping_products = $this->product->get_products(['item_type'=>'pickup', 'item_type'=>'delivery'], NULL, NULL, TRUE);

            if( $type == 'rental')
            {
                $container_products = $this->product->get_products(['item_type' => 'container', 'monthly <>' => 0]);
                $modification_products = $this->product->get_products([
                                    'item_type <>' => 'container', 
                                    'item_type <>' => 'pickup', 
                                    'item_type <>' => 'delivery', 
                                    'monthly <>' => 0]);
            }
            elseif( $type == 'sales' )
            {
                $container_products = $this->product->get_products(['item_type' => 'container', 'monthly' => 0]);
                $modification_products = $this->product->get_products([
                                    'item_type <>' => 'container', 
                                    'item_type <>' => 'pickup', 
                                    'item_type <>' => 'delivery', 
                                    'monthly' => 0]);
            }

            $data = array(
                'order'                 => $this->order,
                'ordered_products'      => $this->order->get_products(),
                'customer'              => $this->customer,
                'driver'                => $driver,
                'type'                  => $this->order->get_type(),
                'shipping_products'     => $shipping_products,
                'container_products'    => $container_products,
                'modification_products' => $modification_products,
                'rental_array'          => $this->product->get_rental_array(),
                'pud_array'             => $this->product->get_pud_array(),
                'main_view'             => 'orders/view'
            );

            $this->load->view('layout/main', $data);
        }
        else
        {
            $this->order->set_order_data($id)->get_ordered_products();

            foreach($this->order->get_products() as $old_product)
            {
                $old_product->delete_requested_product($this->order->get_id(), 'order');
            }

            $this->set_stage($this->input->post('stage'))
                 ->set_date($this->input->post('date'))
                 ->set_time($this->input->post('time'))
                 ->set_ordered_by($this->input->post('ordered_by'))
                 ->set_job_name($this->input->post('job_name'))
                 ->set_job_address($this->input->post('job_address'))
                 ->set_job_city($this->input->post('job_city'))
                 ->set_job_zipcode($this->input->post('job_zipcode'))
                 ->set_tax_rate((float)$this->input->post('tax_rate'))
                 ->set_onsite_contact($this->input->post('onsite_contact'))
                 ->set_onsite_contact_phone($this->input->post('onsite_contact_phone'))
                 ->set_total_cost($this->input->post('total_cost'))
                 ->set_sales_tax($this->input->post('sales_tax'))
                 ->set_cost_before_tax($this->input->post('cost_before_tax'))
                 ->set_monthly_total($this->input->post('monthly_total'))
                 ->set_delivery_total($this->input->post('delivery_total'));

            if( $this->order->update() )
            {
                $item_count = $this->input->post('item_count');

                if( $this->order->insert_ordered_products($item_count) )
                {
                    $this->session->set_flashdata('success_msg', 'The order was successfully updated.');
                    redirect('orders/view'. $this->order->get_id());
                }
                else
                {
                    $this->session->set_flashdata('error_msg', 'The order was updated, however, the new products were not properly stored in the database. Error has been logged.');
                    redirect('orders/view'. $this->order->get_id());
                }
            }
            else
            {
                $this->session->set_flashdata('error_msg', 'The order was not successfully updated in the database, the error has been logged.');
                redirect('orders/view'. $this->order->get_id());
            }
        }   
    }

    public function delete($id)
    {
        if( $this->event->get_event_by_order_id($id)->delete() )
        {
            if ( $this->order->set_order_data($id)->delete() )
            {
                $this->session->set_flashdata('success_msg', 'The order and the any events related to the order have been deleted.');
                redirect('orders/index');
            }
            else
            {
                $this->session->set_flashdata('error_msg', 'The order was not able to be deleted.');
                redirect('orders/index');
            }
        }
        else
        {
            $this->session->set_flashdata('error_msg', 'The events related to the order were unable to be deleted.');
            redirect('orders/index');
        }
        
    }

    public function upgrade($id, $stage)
    {

        $this->order->set_order_data($id)->get_ordered_products();

        switch ($switch) {

            case '2':

                // TODO: create validation for the driver form.

                if( ! $this->form_validation->run() )
                {
                    $containers = array();

                    // create a containers array for the order products
                    foreach($this->order->get_products() as $product)
                    {
                        if( in_array($product->get_mod_short_name(), $product->get_container_array()) )
                        {
                            $con_array = $this->container->get_containers([
                                                            'is_rented' => "FALSE", 
                                                            'rental_resale' => 'Rental', 
                                                            'container_short_name'=> $product->get_mod_short_name()
                                                            ]);
                            
                            foreach($con_array as $con)
                            {
                                array_push($containers, $con);
                            }
                        }
                    }

                    // get driver list
                    $drivers = $this->user->get_users(['type' => 'Driver']);

                    // create view
                    $data = array(
                        'order' => $this->order,
                        'drivers' => $drivers,
                        'containers' => $containers,
                        'main_view' => 'orders/deliver'
                    );

                    $this->load->view('layout/main', $data);
                }
                else
                {
                    $customer = $this->customer->set_customer_data($this->order->get_customer_id());

                    // deliver the container(s)
                    if( $this->input->post('productcount') == 1 )
                    {
                        // create contianer object
                        $container = $this->container->set_container_data($this->input->post('frmcontainer1'));

                        // change the address to the new job address.
                        $container->deliver($this->order->get_job_address(), 'TRUE');

                        // update the container
                        if ( $container->update() )
                        {
                            // create a rental history entry
                            $this->create_rental_history($container->get_id());
                        }
                    }
                    else
                    {
                        $count = 1;

                        while( $count < $this->input->post('productcount')+1 )
                        {
                            // create contianer object
                            $container = $this->container->set_container_data($this->input->post('frmcontainer1'));

                            // change the address to the new job address.
                            $container->deliver($this->order->get_job_address(), 'TRUE');

                            // update the container
                            if ( $container->update() )
                            {
                                // create a rental history entry
                                $this->create_rental_history($container->get_id());
                            }

                            $count++;
                        }
                    }

                    $this->order->set_stage(2)
                                ->set_delivered('TRUE')
                                ->set_date($this->input->post('date'))
                                ->set_driver($this->input->post('driver'))
                                ->set_driver_notes($this->input->post('driver_notes'));

                    if( $this->order->update() )
                    {
                        // delete the old event for the delivery ---- THIS MAY CHANGE (TODO: CHECK BACK WITH COMPANY)
                        $this->event->get_event_by_order_id($this->order->get_id());
                        if( $this->event->delete() )
                        {
                            $this->session->set_flashdata('success_msg', 'The order was upgraded to stage 2 successfully.');
                            reidrect('orders/index');
                        }
                        else
                        {
                            $this->session->set_flashdata('error_msg', 'The order was upgraded to stage 2 successfully, however the delivery event was unable to be deleted.');
                            reidrect('orders/index');
                        }
                    }
                    else
                    {
                        $this->session->set_flashdata('error_msg', 'The order was unsuccessfully updated in the database, error has been logged.');
                        reidrect('orders/index');
                    }
                }

                break;

            case '3':

                break;

            default:
        }
    }

    // TODO: Come back to finish the functionality of downgrading an order.
    public function downgrade()
    {

    }

    public function order($id)
    {
        
        $data = array(
            'order'           => $this->order->set_order_data($id),
            'customer'        => $this->customer->set_customer_data($order->get_customer_id()),
            'container_array' => $this->product->get_container_array(),
            'pud_array'       => $this->product->get_pud_array(),
            'main_view'       => 'orders/rentalorder'
        );

        $this->load->view('layout/main', $data);

    }

    // previously called rentalagreement
    public function agreement($id)
    {
        $data = array(
            'order'           => $this->order->set_order_data($id),
            'customer'        => $this->customer->set_customer_data($order->get_customer_id()),
            'container_array' => $this->product->get_container_array(),
            'pud_array'       => $this->product->get_pud_array(),
            'main_view'       => 'orders/rentalagreement'
        );

        $this->load->view('layout/main', $data);
    }

    public function test()
    {
        $post_date = '02-23-2016';
        $date_exploded = explode('-',$post_date);
        $date = new DateTime($date_exploded[1] . '-' . $date_exploded[0] . '-' . $date_exploded[2]);
        echo date_format($date, 'Y-m-d');
    }
}