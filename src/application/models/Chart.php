<?php

if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

class Chart extends CI_Model
{
    private $cur_month = 1,
            $beg_month = 1,
            $quotes = array(),
            $orders = array(),
            $rentals = array(),
            $resales = array(),
            $con_array = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16);

    // Getters. Setters are not being used in this model since they are all arrays, we used array_push()
    public function get_quotes() { return $this->quotes; }
    public function get_orders() { return $this->orders; }
    public function get_rentals() { return $this->rentals; }
    public function get_resales() { return $this->resales; }
    public function get_con_array() { return $this->con_array; }

    public function __construct()
    {
        parent::__construct();

        $this->get_all_quotes();
        $this->get_all_orders();
        $this->get_rental_containers();
        $this->get_resale_containers();
    }

    public function get_all_quotes()
    {
        for($i = 1; $i != 13; $i++)
        {
            $num = $this->db->get_where('quotes',['MONTH(quote_date)' => $i, ['YEAR(quote_date)'=> date('Y')]])->num_rows();
            
            array_push($this->quotes, $num);
        }
    }

    public function get_all_orders()
    {
        for($i = 1; $i != 13; $i++)
        {
            $num = $this->db->get_where('orders',['MONTH(order_date)' => $i, ['YEAR(order_date)'=> date('Y')]])->num_rows();
            
            array_push($this->orders, $num);
        }
    }

    public function get_rental_containers()
    {
        for($x = 0; $x < 16; $x++)
        {
            // If this does not work, put quotes around FALSE.
            $num = $this->db->get_where('containers', ['container_size_code' => $this->con_array[$x], 'rental_resale'=> 'Rental', 'is_rented' => 'FALSE']);

            array_push($this->rentals, $num);
        }
    }

    public function get_resale_containers()
    {
        for($x = 0; $x < 16; $x++)
        {
            // If this does not work, put quotes around FALSE.
            $num = $this->db->get_where('containers', ['container_size_code' => $this->con_array[$x], 'rental_resale'=> 'Resale', 'is_rented' => 'FALSE']);

            array_push($this->rentals, $num);
        }
    }

}