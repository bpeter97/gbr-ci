<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Quotes extends CI_Controller 
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
        $this->pagination_config['base_url'] = '/quotes/index/';
        $this->pagination_config['total_rows'] = $this->quote->count_quotes();

        $this->pagination->initialize($this->pagination_config);

        $data['quotes'] = $this->quote->get_quotes(NULL, $this->pagination_config['per_page'], $this->uri->segment(3));
        $data['paginator'] = $this->pagination->create_links();

        // Load the main view.
        $data['main_view'] = 'quotes/index';
        $this->load->view('layout/main', $data);
    }

    public function view($id)
    {
        // TODO: create validation

        if( ! $this->form_validation->run() )
        {
            // return the user to view form with validation errors
            $this->quote->set_quote_data((int)$id)->get_quote_products();

            $this->customer->set_customer_data((int)$this->quote->get_customer_id());
    
            $data = array(
                'quote'           => $this->quote,
                'products'        => $this->quote->get_products(),
                'type'            => $this->quote->get_type(),
                'customer'        => $this->customer,
                'rental_products' => $this->product->get_rental_array(),
                'main_view'       => 'quotes/view'
            );
    
            $this->load->view('layout/printouts', $data);
        }
        else
        {
            $this->quote->set_quote_data($id);

            // submit data (update the quote in the database) TODO: Ensure that the post names match the input names.
            $data = array(
                'id'                => $id,
                'customer'          => $this->input->post('customer_name'),
                'customer_id'       => $this->input->post('customer_id'),
                'type'              => $this->input->post('type'),
                'date'              => $this->input->post('date'),
                'status'            => $this->input->post('status'),
                'job_name'          => $this->input->post('job_name'),
                'job_address'       => $this->input->post('job_address'),
                'job_city'          => $this->input->post('job_city'),
                'job_zipcode'       => $this->input->post('job_zipcode'),
                'attn'              => $this->input->post('attn'),
                'tax_rate'          => $this->input->post('tax_rate'),
                'cost_before_tax'   => $this->input->post('cost_before_tax'),
                'total_cost'        => $this->input->post('total_cost'),
                'sales_tax'         => $this->input->post('sales_tax'),
                'monthly_total'     => $this->input->post('monthly_total'),
                'delivery_total'    => $this->input->post('delivery_total'),
                'hidden'            => $this->input->post('hidden')
            );

            if( $this->quote->set_quote_data($data)->update() )
            {
                $this->session->set_flashdata('success_msg', 'The quote was successfully updated!');
                redirect('quotes/view'. $this->quote->get_id());
            }
            else
            {
                $this->session->set_flashdata('error_msg', 'The quote was not updated successfully.');
                redirect('quotes/view'. $this->quote->get_id());
            }
        }

    }

    public function create($type, $customer_id = NULL) // url/type/customer
    {

        // TODO: create data validation
        $this->form_validation->set_rules('customer_id', 'Customer', 'required');
        $this->form_validation->set_rules('date', 'Date', 'required');
        $this->form_validation->set_rules('tax_rate', 'Tax Rate', 'required');
        $this->form_validation->set_rules('job_name', 'Job Name', 'required');
        $this->form_validation->set_rules('job_city', 'Job City', 'required');
        $this->form_validation->set_rules('job_address', 'Job Address', 'required');
        $this->form_validation->set_rules('job_zipcode', 'Job Zipcode', 'required');

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
                'main_view'             => 'quotes/create'
            );

            $this->load->view('layout/main', $data);
        }
        else
        {
            $this->customer->set_customer_data((int)$this->input->post('customer_id'));

            $post_date = $this->input->post('date');
            $date_exploded = explode('-',$post_date);
            $temp_date = new DateTime($date_exploded[1] . '-' . $date_exploded[0] . '-' . $date_exploded[2]);
            $date = date_format($temp_date, 'Y-m-d');

            $this->quote->set_customer($this->customer->get_name())
                        ->set_customer_id((int)$this->customer->get_id())
                        ->set_type($this->input->post('type'))
                        ->set_date($date)
                        ->set_status('Open')
                        ->set_job_name($this->input->post('job_name'))
                        ->set_job_address($this->input->post('job_address'))
                        ->set_job_city($this->input->post('job_city'))
                        ->set_job_zipcode($this->input->post('job_zipcode'))
                        ->set_attn($this->input->post('attn'))
                        ->set_tax_rate((float)$this->input->post('tax_rate'))
                        ->set_cost_before_tax($this->input->post('cost_before_tax'))
                        ->set_total_cost($this->input->post('total_cost'))
                        ->set_sales_tax($this->input->post('sales_tax'))
                        ->set_monthly_total($this->input->post('monthly_total'))
                        ->set_delivery_total($this->input->post('delivery_total'))
                        ->set_hidden(FALSE);
            
            if( $new_id = $this->quote->create() )
            {
                $item_count = (int)$this->input->post('itemCount');

                if( $this->quote->insert_quoted_products((int)$item_count, (int)$new_id) )
                {
                    $_SESSION['success_msg'] = 'The quote was created successfully.';
                    redirect('quotes/view/'. $new_id);
                }
                else
                {
                    $_SESSION['error_msg'] = 'The quoted products were not inserted properly.';
                    redirect('quotes/create/' . $this->quote->get_type() . '/' . $return_id);
                }
            }
            else
            {
                $_SESSION['error_msg'] = 'The quote was not created properly.';
                redirect('quotes/create/' . $this->quote->get_type() . '/' . $return_id);
            }
        }
    }

    public function delete($id)
    {
        if( $this->quote->delete($id) )
        {
            $this->session->set_flashdata('success_msg', 'The quote was successfully deleted!');
            redirect('quotes/index');
        }
        else
        {
            $this->session->set_flashdata('error_msg', 'The quote failed to delete.');
            redirect('quotes/index');
        }
    }

    public function convert($id)
    {
        // set quote
        $this->quote->set_quote_data($id)->get_quote_products();

        // set the customer.
        $this->customer->set_customer_data($this->quote->get_customer_id());

        // get a full list of the customers
        $customers = $this->customer->get_customers();

        // create the rental array and pud array
        $rental_array = $this->product->get_rental_array();
        $pud_array = $this->product->get_pud_array();

        // get the shipping products
        $shipping_products = $this->product->get_products(['item_type'=>'pickup', 'item_type'=>'delivery'], NULL, NULL, TRUE);

        // get the list of products based on the type of quote.
        if( $this->quote->get_type() == 'rental' || $this->quote->get_type() == 'Rental' )
        {
            $container_products = $this->product->get_products(['item_type' => 'container', 'monthly <>' => 0]);
            $modification_products = $this->product->get_products([
                                'item_type <>' => 'container', 
                                'item_type <>' => 'pickup', 
                                'item_type <>' => 'delivery', 
                                'monthly <>' => 0]);
        }
        elseif( $this->quote->get_type() == 'sales' || $this->quote->get_type() == 'Sales' )
        {
            $container_products = $this->product->get_products(['item_type' => 'container', 'monthly' => 0]);
            $modification_products = $this->product->get_products([
                                'item_type <>' => 'container', 
                                'item_type <>' => 'pickup', 
                                'item_type <>' => 'delivery', 
                                'monthly' => 0]);
        }

        // create the order view.
        $data = array(
            'customers'             => $customers,
            'customer'              => $this->customer,
            'shipping_products'     => $shipping_products,
            'container_products'    => $container_products,
            'modification_products' => $modification_products,
            'type'                  => $this->quote->get_type(),
            'rental_array'          => $rental_array,
            'pud_array'             => $pud_array,
            'main_view'             => 'orders/create'
        );

        $this->load->view('layout/main', $data);

    }

    public function hide($id)
    {
        if( $this->quote->set_quote_data($id)->set_hidden(1)->update() )
        {
            $this->session->set_flashdata('success_msg', 'The quote was successfully hidden!');
            redirect('quotes/index');
        }
        else
        {
            $this->session->set_flashdata('error_msg', 'The quote failed to be hidden!');
            redirect('quotes/index');
        }
    }
}