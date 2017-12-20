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

    }

    public function edit()
    {

    }

    public function delete()
    {

    }

    public function create()
    {

    }
}