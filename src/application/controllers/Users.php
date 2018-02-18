<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Users Controller Class
 * 
 * @method index() Loads the master list veiw of the product.
 * @method edit() Loads the edit user page.
 * @method delete() Used to delete user and return message.
 * @method create() Loads the create user page.
 * 
 */
class Users extends CI_Controller 
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
        else
        {
            if( check_perm((int)$this->session->user_id, 'Admin') || check_perm((int)$this->session->user_id, 'Web Developer') )
            {
                return;
            }
            else
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

        $this->pagination_config['base_url'] = '/users/index/';
        $this->pagination_config['total_rows'] = $this->user->count_users();

        $this->pagination->initialize($this->pagination_config);

        $data['users'] = $this->user->get_users(NULL, $this->pagination_config['per_page'], $this->uri->segment(3));
        $data['paginator'] = $this->pagination->create_links();

        // Load the main view.
        $data['main_view'] = 'users/index';
        $this->load->view('layout/main', $data);
        
    }

    /**
     * edit function
     *
     * @return void
     */
    public function edit($id)
    {
        //TODO: Need to add validation here for the update form.

        if( ! $this->form_validation->run() )
        {
            $this->user->set_user_data((int)$id);
            $data['botjs'] = ['users/check_password'];
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

    /**
     * delete function
     *
     * @return void
     */
    public function delete($id)
    {
        $this->user->set_user_data($id);

        if( $this->user->delete() )
        {
            $this->session->set_flashdata('success_msg','You have successfully deleted the user.');
            redirect('users/index');
        }
        else
        {
            $this->session->set_flashdata('error_msg', 'There was an error creating the user, the error has been logged.');
            redirect('users/index');
        }
    }

    /**
     * create function
     *
     * @return void
     */
    public function create()
    {
        //TODO: Need to add validation here for the create form.
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('password_verify', 'Password Verification', 'trim|required|min_length[3]|matches[password]', array('matches' => 'The passwords do not match!'));
        $this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('type', 'Type', 'trim|required');

        if( ! $this->form_validation->run() )
        {
            $data['botjs'] = ['users/check_password'];

            // Go back to home page and display errors.
            $data['main_view'] = 'users/create';
            $this->load->view('layout/main', $data);
        }
        else
        {
            $this->user->set_username($this->input->post('username'))
                       ->set_password($this->input->post('password'))
                       ->set_first_name($this->input->post('firstname'))
                       ->set_last_name($this->input->post('lastname'))
                       ->set_phone($this->input->post('phone'))
                       ->set_title($this->input->post('title'))
                       ->set_type($this->input->post('type'));

            if( $this->user->create() )
            {
                $_SESSION['success_msg'] = 'You successfully created a new user!';
                redirect('users/index');
            }
            else
            {
                $_SESSION['error_msg'] = 'There was an error creating the user, the error has been logged.';
                redirect('users/index');
            }
        }
    }

    public function logout()
    {
        $this->user->destroy_user_session();
        redirect('home/login');
    }

}