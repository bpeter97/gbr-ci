<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Containers extends CI_Controller 
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
        $this->pagination_config['base_url'] = '/containers/index/';
        $this->pagination_config['total_rows'] = $this->container->count_containers();

        $this->pagination->initialize($this->pagination_config);

        $data = array(
            'containers' => $this->container->get_containers(NULL, $this->pagination_config['per_page'], $this->uri->segment(3)),
            'paginator'  => $this->pagination->create_links()
        );

        // Load the main view.
        $data['main_view'] = 'containers/index';
        $this->load->view('layout/main', $data);
    }

    // previously called rentalcontainers()
    public function rentals()
    {
        $this->pagination_config['base_url'] = '/containers/rentals/';
        $this->pagination_config['total_rows'] = $this->container->count_containers(['rental_resale' => 'Rental']);

        $this->pagination->initialize($this->pagination_config);

        $data = array(
            'containers' => $this->container->get_containers(['rental_resale' => 'Rental'], $this->pagination_config['per_page'], $this->uri->segment(3)),
            'paginator'  => $this->pagination->create_links()
        );

        // Load the main view.
        $data['main_view'] = 'containers/rentals';
        $this->load->view('layout/main', $data);
    }

    // previously called resalecontainers()
    public function resales()
    {
        $this->pagination_config['base_url'] = '/containers/resales/';
        $this->pagination_config['total_rows'] = $this->container->count_containers(['rental_resale' => 'Resale']);

        $this->pagination->initialize($this->pagination_config);

        $data = array(
            'containers' => $this->container->get_containers(['rental_resale' => 'Resale'], $this->pagination_config['per_page'], $this->uri->segment(3)),
            'paginator'  => $this->pagination->create_links()
        );

        // Load the main view.
        $data['main_view'] = 'containers/resales';
        $this->load->view('layout/main', $data);
    }

    // previously called currentrentals()
    public function rented()
    {
        $this->pagination_config['base_url'] = '/containers/rented/';
        $this->pagination_config['total_rows'] = $this->container->count_containers(['is_rented' => 'TRUE']);

        $this->pagination->initialize($this->pagination_config);

        $data = array(
            'containers' => $this->container->get_containers(['is_rented' => 'TRUE'], $this->pagination_config['per_page'], $this->uri->segment(3)),
            'paginator'  => $this->pagination->create_links()
        );

        // Load the main view.
        $data['main_view'] = 'containers/rented';
        $this->load->view('layout/main', $data);
    }

    public function create()
    {
        // validation for the form.
        $this->form_validation->set_rules('container_number', 'Number', 'required');
        $this->form_validation->set_rules('container_serial_number', 'Serial Number', 'required');
        $this->form_validation->set_rules('container_size', 'Size', 'required');
        $this->form_validation->set_rules('rental_resale', 'Rental Type', 'required');

        if( ! $this->form_validation->run() )
        {
            $data['main_view'] = 'containers/create';
            $this->load->view('layout/main', $data);
        }
        else
        {
            $this->container->set_address('6988 Ave 304, Visalia, CA 93291');
            $this->container->set_latitude('36.3419904');
            $this->container->set_longitude('-119.4177963');
            $this->container->set_size($this->input->post('container_size'));
            $this->container->find_size_and_short_name();
            $this->container->set_rental_resale($this->input->post('rental_resale'));
            $this->container->set_release_number($this->input->post('release_number'));
            $this->container->set_shelves($this->container->check_boxes($this->input->post('container_shelves')));
            $this->container->set_paint($this->container->check_boxes($this->input->post('container_painted')));
            $this->container->set_onbox_numbers($this->container->check_boxes($this->input->post('container_onbox_numbers')));
            $this->container->set_signs($this->container->check_boxes($this->input->post('container_signs')));
            $this->container->set_serial_number($this->input->post('container_serial_number'));
            $this->container->set_number($this->input->post('container_number'));
            $this->container->set_is_rented('FALSE');
            $this->container->set_type('container');
            $this->container->set_flag('No');

            if( $new_id = $this->container->create() )
            {
                $_SESSION['success_msg'] = 'The container was successfully created.';
                // TODO: Redirect to the container view after the page is created.
                redirect('containers/index');
            }
            else
            {
                $_SESSION['error_msg'] = 'There was an error creating the new container, the error was logged.';
                redirect('containers/index');
            }
            
        }
    }
    
    // previously called id($id)
    public function view($id)
    {
        // validation for the form.
        $this->form_validation->set_rules('container_number', 'Number', 'required');
        $this->form_validation->set_rules('container_serial_number', 'Serial Number', 'required');
        $this->form_validation->set_rules('container_size', 'Size', 'required');
        $this->form_validation->set_rules('rental_resale', 'Rental Type', 'required');

        if( ! $this->form_validation->run() )
        {
            $data['container'] = $this->container->set_container_data((int)$id);
            $data['container_sizes'] = $this->container->get_sizes();
            $data['order_history'] = $this->container->get_order_history();

            if( $this->container->get_flag() == 'Yes') {
                $data['botjs'] = ['containers/alert_js'];
            }

            $data['main_view'] = 'containers/view';
            $this->load->view('layout/main', $data);
        }
        else
        {
            $this->container->set_container_data((int)$id);
            $this->container->get_lat_lon($this->input->post('container_address'));
            $this->container->set_size($this->input->post('container_size'));
            $this->container->find_size_and_short_name($this->container->get_size());

            // post data
            $data = array(
                'release_number'            => $this->input->post('release_number'),
                'size'                      => $this->container->get_size(),
                'serial_number'             => $this->input->post('container_serial_number'),
                'number'                    => $this->input->post('container_number'),
                'rental_resale'             => $this->input->post('rental_resale'),
                'is_rented'                 => $this->input->post('is_rented'),
                'address'                   => $this->input->post('address'),
                'type'                      => $this->input->post('container'),
                'flag'                      => $this->input->post('flag'),
                'flag_reason'               => $this->input->post('flag_reason'),
                'shelves'                   => $this->container->check_boxes($this->input->post('container_shelves')),
                'paint'                     => $this->container->check_boxes($this->input->post('container_painted')),
                'onbox_numbers'             => $this->container->check_boxes($this->input->post('container_onbox_numbers')),
                'signs'                     => $this->container->check_boxes($this->input->post('container_signs')),
                'latitude'                  => $this->container->get_latitude(),
                'longitude'                 => $this->container->get_longitude(),
                'id'                        => $this->container->get_id(),
                'size_code'                 => $this->container->get_size_code(),
                'short_name'                => $this->container->get_short_name()
            );

            if( $this->container->set_container_data($data)->update() )
            {
                $_SESSION['success_msg'] = 'The container has been successfully updated.';
                
                $data['container'] = $this->container;
                $data['container_sizes'] = $this->container->get_sizes();
                $data['order_history'] = $this->container->get_order_history();

                $data['main_view'] = 'containers/view';
                $this->load->view('layout/main', $data);
            }
            else
            {
                $_SESSION['error_msg'] = 'The container has failed to update.';
                
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
        if( $this->container->delete((int)$id) )
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