<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Products Controller Class
 * 
 * @method index() Loads the home veiw of the product.
 */
class Products extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();

        // Check to see if user is logged in.
        if( ! $this->session->logged_in )
        {
            redirect('users/login');
        }
        else
        {
            // TODO Check to see what the user types are in the database.
            if( ! check_perm($id, 'Admin') )
            {
                $this->session->set_flashdata('error_msg','You do not have proper access to access this page.');
                redirect('home/index');
            }
        }
    }

    public function index()
    {
        // Load the libraries
        $this->load->library('pagination');

        $config = array(
            'base_url'      => 'products/index/',
            'total_rows'    => $this->product->count_products(),
            'per_page'      => 20,
            'num_links'     => 5
        );

        $this->pagination->initialize($config);

        $data = array(
            'products' => $this->product->get_products(NULL, $config['per_page'], $this->uri->segment(3))
        );

        // Load the main view.
        $data['main_view'] = 'products/index';
        $this->load->view('layout/main', $data);
    }

    public function edit($id)
    {
        //TODO: create some form validation here!

        // If the form fails to validate or doesn't validate, send to edit page.
        if( ! $this->form_validation->run() )
        {
            $data['product'] = $this->product->set_product_data($id);
            $data['main_view'] = 'products/edit';
            $this->load->view('layout/main', $data);
        }
        // else if the form does validate, process the update.
        else
        {
            $data = array(
                'id'            =>  $id,  
                'mod_name'      =>  $this->input->post('mod_name'),
                'mod_cost'      =>  $this->input->post('mod_cost'),
                'mod_short_name'=>  $this->input->post('mod_short_name'),
                'monthly'       =>  $this->input->post('monthly'),
                'item_type'     =>  $this->input->post('item_type'),
                'rental_type'   =>  $this->input->post('rental_type')
            );

            if( $this->product->set_product_data($data)->update() )
            {
                $this->session->set_flashdata('success_msg', 'You successfully edited a the product!');
                redirect('products/index/');
            }
            else
            {
                $this->session->set_flashdata('error_msg', 'There was an error creating the product, the error has been logged.');
                redirect('products/index');
            }
        }
    }

    public function delete($id)
    {
        if( $this->product->set_product_data($id)->delete() )
        {
            $this->session->set_flashdata('success_msg', 'You successfully deleted a the product!');
            redirect('products/index/');
        }
        else
        {
            $this->session->set_flashdata('error_msg', 'There was an error deleting the product, the error has been logged.');
            redirect('products/index');
        }
    }

    public function create()
    {
        //TODO: create some form validation here!

        // If the form fails to validate or doesn't validate, send to create page.
        if( ! $this->form_validation->run() )
        {
            $data['main_view'] = 'products/create';
            $this->load->view('layout/main', $data);
        }
        else
        {
            // else if the form does validate, process the creation.
            if( $this->product->set_mod_name($this->input->post('mod_name'))
                              ->set_mod_short_name($this->input->post('mod_short_name'))
                              ->set_mod_cost($this->input->post('mod_cost'))
                              ->set_monthly($this->input->post('monthly'))
                              ->set_item_type($this->input->post('item_type'))
                              ->set_rental_type($this->input->post('rental_type'))
                              ->create() )
            {
                $this->session->set_flashdata('success_msg', 'You successfully created a the product!');
                redirect('products/index');
            }
            else
            {
                $this->session->set_flashdata('error_msg', 'There was an error creating the product, the error has been logged.');
                redirect('products/index');
            }
        }
    }
}