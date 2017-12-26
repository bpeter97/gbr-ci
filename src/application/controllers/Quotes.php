<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Quotes extends CI_Controller 
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
            'base_url'      => 'quotes/index/',
            'total_rows'    => $this->quote->count_quotes(),
            'per_page'      => 50,
            'num_links'     => 5
        );

        $this->pagination->initialize($config);

        $data['quotes'] = $this->quote->get_quotes(NULL, $config['per_page'], $this->uri->segment(3));

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
            $this->quote->set_quote_data($id)->get_quote_products();

            $this->customer->set_customer_data($this->quote->get_customer_id());
    
            $data = array(
                'quote'           => $this->quote,
                'customer'        => $this->customer,
                'rental_products' => $this->product->get_rental_array(),
                'main_view'       => 'quotes/view'
            );
    
            $this->load->view('layout/main', $data);
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

    public function create($type, $customer = NULL) // url/type/customer
    {

        // TODO: create data validation

        if( ! $this->form_validation->run() )
        {
            $customers = $this->customer->get_customers();

            if( ! $customer === NULL )
            {
                $this->customer->set_customer_data($customer);
            }
            else
            {
                $this->customer = NULL;
            }

            $rental_array = $this->product->get_rental_array();
            $pud_array = $this->product->get_pud_array();

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
                'customers'             => $customers,
                'customer'              => $this->customer,
                'shipping_products'     => $shipping_products,
                'container_products'    => $container_products,
                'modification_products' => $modification_products,
                'type'                  => $type,
                'rental_array'          => $rental_array,
                'pud_array'             => $pud_array,
                'main_view'             => 'quotes/create'
            );

            $this->load->view('layout/main', $data);
        }
        else
        {
            $this->customer->set_customer_object($this->input->post('customer_id'));

            $data = array(
                'customer'          => $this->customer->get_customer_name(),
                'customer_id'       => $this->customer->get_customer_id(),
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
                'hidden'            => FALSE
            );

            if( $new_id = $this->quote->set_quote_data($data)->create() )
            {
                $item_count = $this->input->post('item_count');

                if( $this->quote->insert_quoted_products($item_count) )

                {
                    $this->session->set_flashdata('success_msg', 'The quote was created successfully.');
                    redirect('quotes/view/'. $new_id);
                }
                else
                {
                    $this->session->set_flashdata('error_msg', 'The quoted products were not inserted properly.');
                    redirect('quotes/view/'. $new_id);
                }
            }
            else
            {
                $this->session->set_flashdata('error_msg', 'The quote was not created properly.');
                redirect('quotes/view/'. $new_id);
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