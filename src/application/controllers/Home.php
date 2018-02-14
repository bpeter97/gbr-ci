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
            $data['events'] = $this->calendar->get_events();
            
            $data['months'] = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

			// TODO: Need to come up with a better way to create this array.
			$data['con_list'] = [
			            "10' Containers",
			            "20' Containers",
			            "20' Combos",
			            "20' Full Offices",
			            "20' Double Door",
			            "20' Containers w/ Shelves",
			            "20' High Cube",
			            "22' DD/HC",
			            "22' High Cube",
			            "24' Containers",
			            "24' High Cube",
			            "40' Containers",
			            "40' Combos",
			            "40' Double Doors",
			            "40' Full Offices",
			            "40' High Cubes"
                        ];

            // Get chart data - Containers in stock.
            $data['rentals'] = $this->chart->get_rentals();
            $data['resales'] = $this->chart->get_resales();

            // Get chart data - orders/quotes in current year.
            $data['quotes'] = $this->chart->get_quotes();
            $data['orders'] = $this->chart->get_orders();

            // bottom js includes specific to home page.
            $data['externaljs'] = [
                'https://maps.googleapis.com/maps/api/js?key=AIzaSyDmAJNXfLD_-32yOSheQ-xo4gySGStag9U&v=3.exp&libraries=places'
            ];

            // JS includes (these are php pages that have JS written inside of it, loaded as views).
            $data['botjs'] = ['home/map_js', 'home/calendar_js', 'home/charts_js'];

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