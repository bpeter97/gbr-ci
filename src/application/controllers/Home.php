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
        // Load the main view.
        $data['main_view'] = 'home/index';
        $this->load->view('layout/main', $data);
    }

}