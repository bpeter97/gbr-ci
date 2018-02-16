<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller 
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
        $this->pagination_config['base_url'] = '/customers/index/';
        $this->pagination_config['total_rows'] = $this->customer->count_customers();

        $this->pagination->initialize($this->pagination_config);

        $data['customers'] = $this->customer->get_customers(NULL, $this->pagination_config['per_page'], $this->uri->segment(3));
        $data['paginator'] = $this->pagination->create_links();

        // Load the main view.
        $data['main_view'] = 'customers/index';
        $this->load->view('layout/main', $data);
    }

    public function create()
    {
        // Form validation for the create customer form.
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('address1', 'Address', 'required');
        $this->form_validation->set_rules('address2', 'Address2', 'differs[address1]');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('zipcode', 'Zipcode', 'required|numeric');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        $this->form_validation->set_rules('email', 'Email', 'valid_email');

        // Check to see if validation was successful.
        if( ! $this->form_validation->run() )
        {
            // If not, return to the create customer form with validation errors.
            $data['main_view'] = 'customers/create';
            $this->load->view('layout/main', $data);
        }
        else
        {
            // Set the data in the customer object.
            $this->customer->set_name($this->input->post('name'))
                           ->set_address1($this->input->post('address1'))
                           ->set_address2($this->input->post('address2'))
                           ->set_city($this->input->post('city'))
                           ->set_zipcode($this->input->post('zipcode'))
                           ->set_state($this->input->post('state'))
                           ->set_phone($this->input->post('phone'))
                           ->set_ext($this->input->post('ext'))
                           ->set_fax($this->input->post('fax'))
                           ->set_email($this->input->post('email'))
                           ->set_rdp($this->input->post('rdp'))
                           ->set_notes($this->input->post('notes'))
                           ->set_flag($this->input->post('flag'))
                           ->set_flag_reason($this->input->post('flag_reason'));

            // check if customer was successfully created in database.
            if( $new_id = $this->customer->create() )
            {
                // send a success message.
                $_SESSION['success_msg'] = 'The customer was successfully created.';

                // TODO: Set the redirect to the customer view page of the new ID once the view page is made.
                redirect('customers/index');
            }
            else
            {
                // else send an error message.
                $_SESSION['error_msg'] = 'There was an error creating the new customer, the error was logged.';
                redirect('customers/index');
            }
        }
    }

    public function view($id)
    {     
        // Form validation for the customer form.
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('address1', 'Address', 'required');
        $this->form_validation->set_rules('address2', 'Address2', 'differs[address1]');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('zipcode', 'Zipcode', 'required|numeric');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        $this->form_validation->set_rules('email', 'Email', 'valid_email');

        // check to see if validation successfully ran.
        if( ! $this->form_validation->run() )
        {
            // If not, send user to view page with validation errors (if any).
            $data['customer'] = $this->customer->set_customer_data((int)$id);            
            
            $data['quote_history'] = $this->customer->get_history('quotes');
            $data['purchase_history'] = $this->customer->get_history('orders');
            $data['rental_history'] = $this->customer->get_history('rentals');

            if( $this->customer->get_flag() == 'Yes') {
                $data['botjs'] = ['customers/alert_js'];
            }

            $data['main_view'] = 'customers/view';
            $this->load->view('layout/main', $data);
        }
        else
        {
            // Set customer object
            $this->customer->set_customer_data((int)$id);

            // Else, set the data array
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

            $this->customer->set_customer_data($data);

            // Update the customer in the database.
            if( $this->customer->update() )
            {
                $_SESSION['success_msg'] = 'The customer was successfully updated.';
                redirect('customers/view/'. $this->customer->get_id());
            }
            else
            {
                $_SESSION['error_msg'] = 'There was an error updating the customer, the error was logged.';
                redirect('customers/index');
            }
        }
    }

    public function delete($id)
    {
        if( $this->customer->delete((int)$id) )
        {
            $_SESSION['success_msg'] = 'The customer was successfully deleted.';
        }
        else
        {
            $_SESSION['error_msg'] = 'There was an issue deleting the customer, the error has been logged.';
        }

        redirect('customers/index');
    }

}