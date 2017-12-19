<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home Controller Class
 * 
 * @method index() Loads the home veiw of the product.
 */
class Home extends CI_Controller 
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

    /**
     * index function
     *
     * Loads the home view of the project.
     * 
     * @return void
     */
    public function index()
    {
        // Load the libraries
        $this->load->library('pagination');

        $config = array(
            'base_url'      => '/users/index/',
            'total_rows'    => $this->User->count_users(),
            'per_page'      => 20,
            'num_links'     => 5
        );

        $this->pagination->initialize($config);

        $data = array(
            'users'         => $this->User->get_limited_users($config['per_page'], $this->uri->segment(3))
        );

        // Load the main view.
        $data['main_view'] = 'users/index';
        $this->load->view('layout/main', $data);
    }

    public function edit($id)
    {
        //TODO Need to add validation here for the update form.

        if( ! $this->form_validation->run() )
        {
            $this->user->set_user_data($id);
            $data['user'] = $this->user;
    
            $data['main_view'] = 'users/edit';
            $this->load->view('layout/main', $data);
        }
        else
        {
            $user_data = array(
                'id'        =>  $id,
                'username'  =>  $this->input->post('username'),
                'password'  =>  $this->input->post('password'),
                'firstname' =>  $this->input->post('firstname'),
                'lastname'  =>  $this->input->post('lastname'),
                'phone'     =>  $this->input->post('phone'),
                'title'     =>  $this->input->post('title'),
                'type'      =>  $this->input->post('type')
            );

            if( $this->user->set_user_data($user_data)->update() )
            {
                $this->session->set_flashdata('success_msg', 'You successfully edited a the user!');
                redirect('users/index');
            }
            else
            {
                $this->session->set_flashdata('error_msg', 'There was an error creating the user, the error has been logged.');
                redirect('users/index');
            }
        }

        
    }

    public function delete($id)
    {
        $this->user->set_user_data($id);
        $this->user->delete();
        
        $this->session->set_flashdata('success_msg','You have successfully deleted the user.');
        redirect('users/index');
    }

    public function create()
    {
        //TODO Need to add validation here for the create form.

        if( ! $this->form_validation->run() )
        {
            // Redirect with errors.
            $this->session->set_flashdata('error_msg', $this->form_validation->error_array());
            
            // Go back to home page and display errors.
            $data['main_view'] = 'users/create';
            $this->load->view('layout/main', $data);
        }
        else
        {
            $user_data = array(
                'username'  =>  $this->input->post('username'),
                'password'  =>  $this->input->post('password'),
                'firstname' =>  $this->input->post('firstname'),
                'lastname'  =>  $this->input->post('lastname'),
                'phone'     =>  $this->input->post('phone'),
                'title'     =>  $this->input->post('title'),
                'type'      =>  $this->input->post('type')
            );

            if( $this->user->set_user_data($user_data)->create() )
            {
                $this->session->set_flashdata('success_msg', 'You successfully created a new user!');
                redirect('users/index');
            }
            else
            {
                $this->session->set_flashdata('error_msg', 'There was an error creating the user, the error has been logged.');
                redirect('users/index');
            }
            
        }
    }

}