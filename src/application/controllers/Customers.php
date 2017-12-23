<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller 
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
            'base_url'      => 'customers/index/',
            'total_rows'    => $this->customer->count_customers(),
            'per_page'      => 50,
            'num_links'     => 5
        );

        $this->pagination->initialize($config);

        $data['customers'] = $this->customer->get_customers(NULL, $config['per_page'], $this->uri->segment(3));

        // Load the main view.
        $data['main_view'] = 'customers/index';
        $this->load->view('layout/main', $data);
    }

    public function create()
    {
        // TODO: create validation for form.

        if( ! $this->form_validation->run() )
        {
            $data['main_view'] = 'customers/create';
            $this->load->view('layout/main', $data);
        }
        else
        {
            $data = array(
                'name'      =>  $this->input->post('name'),
                'address1'  =>  $this->input->post('address1'),
                'address2'  =>  $this->input->post('address2'),
                'city'      =>  $this->input->post('city'),
                'zipcode'   =>  $this->input->post('zipcode'),
                'state'     =>  $this->input->post('state'),
                'phone'     =>  $this->input->post('phone'),
                'ext'       =>  $this->input->post('ext'),
                'fax'       =>  $this->input->post('fax'),
                'email'     =>  $this->input->post('email'),
                'rdp'       =>  $this->input->post('rdp'),
                'notes'     =>  $this->input->post('notes')
            );

            if( $new_id = $this->customer->set_customer_data($data)->create() )
            {
                $this->session->set_flashdata('success_msg', 'The customer was successfully created.');
                redirect('customers/view/'. $new_id);
            }
            else
            {
                $this->session->set_flashdata('error_msg', 'There was an error creating the new customer, the error was logged.');
                redirect('customers/index');
            }
        }
    }

    public function view($id)
    {
        $this->customer->set_customer_data($id);
     
        // TODO: create validation for form.

        if( ! $this->form_validation->run() )
        {
            $data['customer'] = $this->customer;
            $data['main_view'] = 'customers/view';

            $this->load->view('layout/main', $data);
        }
        else
        {
            $data = array(
                'id'          => $this->customer->get_id(),
                'name'        => $this->input->post('name'),
                'address1'    => $this->input->post('address1'),
                'address2'    => $this->input->post('address2'),
                'city'        => $this->input->post('city'),
                'zipcode'     => $this->input->post('zipcode'),
                'state'       => $this->input->post('state'),
                'phone'       => $this->input->post('phone'),
                'ext'         => $this->input->post('ext'),
                'fax'         => $this->input->post('fax'),
                'email'       => $this->input->post('email'),
                'rdp'         => $this->input->post('rdp'),
                'notes'       => $this->input->post('notes'),
                'flag'        => $this->input->post('flag'),
                'flag_reason' => $this->input->post('flag_reason')
            );

            if( $this->customer->set_customer_data($data)->update() )
            {
                $this->session->set_flashdata('success_msg', 'The customer was successfully updated.');
                redirect('customers/view/'. $this->customer->get_id());
            }
            else
            {
                $this->session->set_flashdata('error_msg', 'There was an error updating the customer, the error was logged.');
                redirect('customers/view/'. $this->customer->get_id());
            }
        }
    }

    public function delete($id)
    {
        if( $this->customer->delete($id) )
        {
            $this->session->set_flashdata('success_msg', 'The customer was successfully deleted.');
        }
        else
        {
            $this->session->set_flashdata('error_msg', 'There was an issue deleting the customer, the error has been logged.');
        }

        redirect('customers/index');
    }

}