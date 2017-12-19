<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home Controller Class
 * 
 * @method index() Loads the home veiw of the product.
 */
class Home extends CI_Controller 
{
    /**
     * index function
     *
     * Loads the home view of the project.
     * 
     * @return void
     */
    public function index()
    {
        // Check to see if user is logged in.
        if( ! $this->session->logged_in )
        {
            redirect('users/login');
        }
        else
        {
            // Load the main view.
            $data['main_view'] = 'home/index';
            $this->load->view('layout/main', $data);
        }
    }


    /**
     * login function
     *
     * Loads the login page, validates the users info, and logs the user in.
     * 
     * @uses User model.
     * @return void
     */
    public function login()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[12]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        
        if( $this->form_validation->run() )
        {
            if( $id = $this->user->check_login($this->input->post('username'), $this->input->post('password')) )
            {
                $this->user->set_user_data($this->user->get_user_info($id))->create_user_session();
            }
            else
            {
                // TODO: Create better error message
                $this->session->set_flashdata('error logging in');
                redirect('home/login');
            }
        }
        else
        {
            // Load the main view.
            $data['main_view'] = 'home/login';
            $this->load->view('layout/main', $data);
        }
    }

}