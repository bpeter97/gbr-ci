<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Containers extends CI_Controller 
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
        // Load the libraries
        $this->load->library('pagination');

        $config = array(
            'base_url'      => 'containers/index/',
            'total_rows'    => $this->container->count_containers(),
            'per_page'      => 50,
            'num_links'     => 5
        );

        $this->pagination->initialize($config);

        $data = array(
            'containers' => $this->container->get_containers(NULL, $config['per_page'], $this->uri->segment(3))
        );

        // Load the main view.
        $data['main_view'] = 'containers/index';
        $this->load->view('layout/main', $data);
    }

    // previously called rentalcontainers()
    public function rentals()
    {
        // Load the libraries
        $this->load->library('pagination');

        $config = array(
            'base_url'      => 'containers/rentals/',
            'total_rows'    => $this->container->count_containers(['rental_resale' => 'Rental']),
            'per_page'      => 50,
            'num_links'     => 5
        );

        $this->pagination->initialize($config);

        $data = array(
            'containers' => $this->container->get_containers(['rental_resale' => 'Rental'], $config['per_page'], $this->uri->segment(3))
        );

        // Load the main view.
        $data['main_view'] = 'containers/index';
        $this->load->view('layout/main', $data);
    }

    // previously called resalecontainers()
    public function resales()
    {
        // Load the libraries
        $this->load->library('pagination');

        $config = array(
            'base_url'      => 'containers/resales/',
            'total_rows'    => $this->container->count_containers(['rental_resale' => 'Resale']),
            'per_page'      => 50,
            'num_links'     => 5
        );

        $this->pagination->initialize($config);

        $data = array(
            'containers' => $this->container->get_containers(['rental_resale' => 'Resale'], $config['per_page'], $this->uri->segment(3))
        );

        // Load the main view.
        $data['main_view'] = 'containers/index';
        $this->load->view('layout/main', $data);
    }

    // previously called currentrentals()
    public function rented()
    {
        // Load the libraries
        $this->load->library('pagination');

        $config = array(
            'base_url'      => 'containers/rented/',
            'total_rows'    => $this->container->count_containers(['is_rented' => 'TRUE']),
            'per_page'      => 50,
            'num_links'     => 5
        );

        $this->pagination->initialize($config);

        $data = array(
            'containers' => $this->container->get_containers(['is_rented' => 'TRUE'], $config['per_page'], $this->uri->segment(3))
        );

        // Load the main view.
        $data['main_view'] = 'containers/index';
        $this->load->view('layout/main', $data);
    }

    public function create()
    {
        // TODO: create validation for the form.

        if( ! $this->form_validation->run() )
        {
            $data['main_view'] = 'containers/create';
            $this->load->view('layout/main', $data);
        }
        else
        {
            $this->container->set_address('6988 Ave 304, Visalia, CA 93291');
            $this->container->get_lat_lon($this->container->get_address());
            $this->container->set_size($this->input->post('frmcontainersize'));
            $this->container->find_size_and_short_name();

            $data = array(
                'rental_resale'     => $this->input->post('frmrentalresale'),
                'size'              => $this->container->get_size(),
                'release_number'    => $this->input->post('frmcontainerrelease'),
                'shelves'           => $this->container->check_boxes($this->input->post('containershelves')),
                'paint'             => $this->container->check_boxes($this->input->post('containerpainted')),
                'onbox_numbers'     => $this->container->check_boxes($this->input->post('containergbrnumbers')),
                'signs'             => $this->container->check_boxes($this->input->post('containersigns')),
                'serial_number'     => $this->input->post('frmcontainerserial'),
                'number'            => $this->input->post('frmcontainernumber'),
                'is_rented'         => FALSE,
                'address'           => $this->container->get_address(),
                'latitude'          => $this->container->get_lat(),
                'longitutde'        => $this->container->get_lon(),
                'size_code'         => $this->container->get_size_code(),
                'short_name'        => $this->container->get_short_name(),
            );

            if( $new_id = $this->container->set_container_data($data)->create() )
            {
                $this->session->set_flashdata('success_msg', 'The container was successfully created.');
                redirect('containers/view/'. $new_id);
            }
            else
            {
                $this->session->set_flashdata('error_msg', 'There was an error creating the new container, the error was logged.');
                redirect('containers/index');
            }
            
			
        }
    }
    
    // previously called id($id)
    public function view($id)
    {
        $this->container->set_container_data($id);

        // TODO: create validation for the form.

        if( ! $this->form_validation->run() )
        {
            $data['container'] = $this->container;
            $data['container_sizes'] = $this->container->get_sizes();
            $data['order_history'] = $this->container->get_order_history();

            $data['main_view'] = 'containers/view';
            $this->load->view('layout/main', $data);
        }
        else
        {
            $this->container->get_lat_lon($this->input->post('container_address'));
            $this->container->set_size($this->input->post('container_size'));
            $this->container->find_size_and_short_name($this->container->get_size());

            // post data
            $data = array(
                'release_number'            => $this->input->post('release_number'),
                'size'                      => $this->container->get_size(),
                'serial_number'             => $this->input->post('container_serial_number'),
                'container_number'          => $this->input->post('container_number'),
                'rental_resale'             => $this->input->post('rental_resale'),
                'is_rented'                 => $this->input->post('is_rented'),
                'container_address'         => $this->input->post('container_address'),
                'type'                      => $this->input->post('container'),
                'flag'                      => $this->input->post('flag'),
                'flag_reason'               => $this->input->post('flag_reason'),
                'container_shelves'         => $this->input->post('container_shelves'),
                'container_paint'           => $this->input->post('container_paint'),
                'container_onbox_numbers'   => $this->input->post('container_onbox_numbers'),
                'container_signs'           => $this->input->post('container_signs'),
                'latitude'                  => $this->container->get_lat(),
                'longitude'                 => $this->container->get_lon(),
                'id'                        => $this->container->get_id(),
                'size_code'                 => $this->container->get_size_code(),
                'short_name'                => $this->container->get_short_name()
            );

            if( $this->container->set_container_data($data)->update() )
            {
                $this->session->set_flashdata('success_msg', 'The container has been successfully updated.');
                
                $data['container'] = $this->container;
                $data['container_sizes'] = $this->container->get_sizes();
                $data['order_history'] = $this->container->get_order_history();

                $data['main_view'] = 'containers/view';
                $this->load->view('layout/main', $data);
            }
            else
            {
                $this->session->set_flashdata('error_msg', 'The container has failed to update.');
                
                $data['container'] = $this->container;
                $data['container_sizes'] = $this->container->get_sizes();
                $data['order_history'] = $this->container->get_order_history();

                $data['main_view'] = 'containers/view';
                $this->load->view('layout/main', $data);
            }
        }
    }

    public function delete($id)
    {
        // delete the container.
        if( $this->container->delete($id) )
        {
            $this->session->set_flashdata('success_msg', 'The container was successfully deleted.');
        }
        else
        {
            $this->session->set_flashdata('error_msg', 'There was an error deleting the container, the error has been logged.');
        }
        redirect('containers/index');
    }

}