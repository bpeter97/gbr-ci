<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller 
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

        // TODO: create validation on the search input and the cateogry input

        if( ! $this->form_validation->run() )
        {
            redirect('home/index');
        }
        else
        {
            $containers = null;
            $customers = null;
            $quotes = null;
            $orders = null;
            $products = null;
            $selected = null;
            $string = $this->input->post('search');
    
            switch ( $this->input->post('category') ) {
                case 'containers':
                        
                        $containers = $this->container->search($string);
                        $selected = "containers";
    
                    break;
    
                case 'customers':
                        
                        $customers = $this->customer->search($string);
                        $selected = "customers";
    
                    break;
    
                case 'quotes':
    
                        $quotes = $this->quote->search($string);
                        $selected = "quotes";
    
                    break;
    
                case 'orders':
                
                        $orders = $this->order->search($string);
                        $selected = "orders";
    
                        break;
                    
                case 'products':
    
                        $products = $this->product->search($string);
                        $selected = "products";
                
                    break;
    
                default:
                    break;
            }
            
            $data = array(
                'containers'  =>  $containers, 
                'customers'   =>  $customers, 
                'quotes'      =>  $quotes, 
                'orders'      =>  $orders, 
                'products'    =>  $products,
                'selected'    =>  $selected,
                'main_view'   =>  'search/results'
            );

            $this->load->view('layout/main', $data);
        }
    }
}