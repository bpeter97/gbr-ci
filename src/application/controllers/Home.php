<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home Controller Class
 * 
 * Testing the push.
 * 
 * @method index() Loads the home veiw.
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
            redirect('home/login');
        }
        else
        {
            // Load the main view.
            $data['main_view'] = 'home/index';
            $this->load->view('layout/main', $data);
        }
    }

    public function create()
    {
        $data = array(
            'id'            =>   NULL,
            'username'      =>  'blpeter',
            'password'      =>  'password',
            'first_name'    =>  'Brian',
            'last_name'     =>  'Peter',
            'phone'         =>  '555-555-5555',
            'title'         =>  'Web Developer',
            'type'          =>  'Admin'
        );

        $this->user->set_user_data($data);
        $this->user->create();

        redirect('home/index');
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
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]');
        
        if( $this->form_validation->run() )
        {
            $result = $this->user->check_login($this->input->post('username'), $this->input->post('password'));

            if( is_int($result) )
            {
                $this->user->set_user_data($result)->create_user_session();
                redirect('home/index');
            }
            else
            {
                $this->session->set_flashdata('error_msg', array($result));
                redirect('home/login');
            }
        }
        else
        {
            $this->load->view('login/index');
        }
    }

}