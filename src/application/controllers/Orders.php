<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller 
{
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
        $config = array(
            'base_url'      => 'orders/index/',
            'total_rows'    => $this->orders->count_orders(),
            'per_page'      => 50,
            'num_links'     => 5
        );

        $this->pagination->initialize($config);

        $data['orders'] = $this->order->get_orders(NULL, $config['per_page'], $this->uri->segment(3));

        // Load the main view.
        $data['main_view'] = 'orders/index';
        $this->load->view('layout/main', $data);
    }

    public function create($type, $customer = NULL)
    {
        // TODO: create validation for the create form.

        if( ! $this->form_validation->run() )
        {
            if( is_int($customer) )
            {
                $this->customer->set_customer_data($customer);
            }
            else
            {
                $this->customer = NULL;
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
                $this->quote->set_quote_date($this->input->post('quote_id'))->get_quote_products();
            }

            $this->customer->set_customer_object($this->input->post('customer_id'));

            $data = array(
                'customer'          => $this->customer->get_customer_name(),
                'customer_id'       => $this->input->post('customer_id'),
                'date'              => $this->input->post('date'),
                'time'              => $this->input->post('time'),
                'type'              => $this->input->post('type'),
                'job_name'          => $this->input->post('job_name'),
                'job_city'          => $this->input->post('job_city'),
                'job_address'       => $this->input->post('job_address'),
                'job_zipcode'       => $this->input->post('job_zipcode'),
                'ordered_by'        => $this->input->post('ordered_by'),
                'tax_rate'          => (float)$this->input->post('tax_rate'),
                'cost_before_tax'   => $this->input->post('cost_before_tax'),
                'total_cost'        => $this->input->post('total_cost'),
                'sales_tax'         => $this->input->post('sales_tax'),
                'monthly_total'     => $this->input->post('monthly_total'),
                'delivery_total'    => $this->input->post('delivery_total'),
                'stage'             => 1
            );

            if( $new_id = $this->order->set_order_data($data)->create() )
            {
                $item_count = $this->input->post('item_count');

                // converting a quoted products to ordered products
                if( $this->input->post('quote_id') )
                {
                    if( $this->order->insert_ordered_products($item_count, $quote_id) )
                    {
                        $this->session->set_flashdata('success_msg', 'The order was created successfully.');
                        redirect('orders/view/'. $new_id);
                    }
                    else
                    {
                        $this->session->set_flashdata('error_msg', 'The ordered products were not inserted properly.');
                        redirect('orders/view/'. $new_id);
                    }
                }
                // otherwise create new ordered products.
                else
                {
                    if( $this->order->insert_ordered_products($item_count) )

                    {
                        $this->session->set_flashdata('success_msg', 'The order was created successfully.');
                        redirect('orders/view/'. $new_id);
                    }
                    else
                    {
                        $this->session->set_flashdata('error_msg', 'The ordered products were not inserted properly.');
                        redirect('orders/view/'. $new_id);
                    }
                }
            }
            else
            {
                $this->session->set_flashdata('error_msg', 'The order was not created properly.');
                redirect('orders/view/'. $new_id);
            }
        }
    }

    // previously called edit()
    public function view($id)
    {
        
        // TODO: create validation for the form.

        if( ! $this->form_validation->run() )
        {
            $this->order->set_order_data($id)->get_order_products();
        
            $this->customer->set_customer_data($order->get_customer());

            if( $order->get_delivered() )
            {
                $driver = $this->user->set_user_data($order->get_driver());
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
}