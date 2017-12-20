<?php

if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

class Product extends CI_Model
{
    private $_id,
            $_mod_name,
            $_mod_cost,
            $_mod_short_name,
            $_monthly,
            $_item_type,
            $_rental_type,
            $_order_id,
            $_product_qty,
            $_product_cost,
            $_product_type;

    public function get_id() { return $this->_id; }
    public function get_mod_name() { return $this->_mod_name; }
    public function get_mod_cost() { return $this->_mod_cost; }
    public function get_mod_short_name() { return $this->mod_short_name; }
    public function get_monthly() { return $this->monthly; }
    public function get_item_type() { return $this->item_type; }
    public function get_rental_type() { return $this->rental_type; }
    public function get_order_id() { return $this->order_id; }
    public function get_product_quantity() { return $this->product_qty; }
    public function get_product_cost() { return $this->product_cost; }
    public function get_product_type() { return $this->product_type; }
    
    public function set_id($id) { $this->_id = $id; return $this; }
    public function set_mod_name($name) { $this->mod_name = $name; return $this; }
    public function set_mod_cost($cost) { $this->mod_cost = $cost; return $this; }
    public function set_mod_short_name($name) { $this->mod_short_name = $name; return $this; }
    public function set_monthly($cost) { $this->monthly = $cost; return $this; }
    public function set_item_type($type) { $this->item_type = $type; return $this; }
    public function set_rental_type($type) { $this->rental_type = $type; return $this; }
    public function set_order_id($id) { $this->order_id = $id; return $this; }
    public function set_product_quantity($qty) { $this->product_qty = $qty; return $this; }
    public function set_product_cost($cost) { $this->product_cost = $cost; return $this; }
    public function set_product_type($type) { $this->product_type = $type; return $this; }

    public function __construct($id = NULL)
    {
        parent::__construct();
        
        if( ! $id === NULL )
        {
            $this->set_user_data($id);
        }
    }

    // previously called getDetails()
    public function get_product_info($id = NULL)
    {
        if( ! $id === NULL )
        {
            // Return user info based on supplied ID.
            return $this->db->get_where('modifications', ['id' => $id])->result();
        }
        else
        {
            // Return user info based on user model ID.
            return $this->db->get_where('modifications', ['id' => $this->get_id()])->result();
        }
    }

    public function set_product_data($id = NULL)
    {
        if(is_int($id))
        {
            $product = $this->get_product_info($id);
        }
        else
        {
            $product = $id;
        }

        // Use setters to setup this objects properties using the object passed in.
        if(is_array($product))
        {
            $this->set_id($product['id'])
                 ->set_mod_name($product['mod_name'])
                 ->set_mod_cost($product['mod_cost'])
                 ->set_mod_short_name($product['mod_short_name'])
                 ->set_monthly($product['monthly'])
                 ->set_item_type($product['item_type'])
                 ->set_rental_type($product['rental_type'])
                 ->set_order_id($product['order_id'])
                 ->set_product_quantity($product['product_qty'])
                 ->set_product_cost($product['product_cost'])
                 ->set_product_type($product['product_type']);
        } 
        elseif(is_object($product))
        {
            // Use object parameters.
            $this->set_id($product->id)
                 ->set_mod_name($product->mod_name)
                 ->set_mod_cost($product->mod_cost)
                 ->set_mod_short_name($product->mod_short_name)
                 ->set_monthly($product->monthly)
                 ->set_item_type($product->item_type)
                 ->set_rental_type($product->rental_type)
                 ->set_order_id($product->order_id)
                 ->set_product_quantity($product->product_qty)
                 ->set_product_cost($product->product_cost)
                 ->set_product_type($product->product_type);
        }
        else
        {
            // Throw an error
            throw new Exception('The variable passed in is not an object or an array.');
        }

        return $this;
    }

    public function count_products($where = NULL)
    {
        if( ! $where === NULL )
        {
            return $this->db->get('modifications')->num_rows();
        }
        else
        {
            // $where must be an array!
            return $this->db->get_where('modifications', $where)->num_rows();
        }
    }

    // previously called getProducts
    // $where must be an array. If $limit is used, there must be an offset set as $start.
    public function get_products($where = NULL, $limit = NULL, $start = NULL)
    {
        // If limit is not null then check where
        if( ! $limit === NULL )
        {
            // If where is not null do limit with where
            if( ! $where === NULL )
            {
                $product_array = $this->db->get_where('modifications', $where, $limit, $start)->result_array();
            }
            // else do limit with no where
            else
            {
                $product_array = $this->db->get_where('modifications', $limit, $start)->result_array();
            }
        }
        // else if where is not null do where
        elseif( ! $where === NULL )    
        {
            $product_array = $this->db->get_where('modifications', $where)->result_array();
        }
        // else get all of the products
        else
        {
            $product_array = $this->db->get('modifications')->result_array();
        }
    }

    public function delete_requested_product()
    {

    }

    public function search()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }

    public function create()
    {

    }

    public function get_rental_array()
    {
        $rental_array = array();

        $res = $this->db->where('modifications',['rental_type'=>'Rental'])->result_array();

        foreach($res as $mod)
        {
            array_push($rental_array, $mod['mod_short_name']);
        }

        return $rental_array;
    }

    // pud = pickup/delivery
    public function get_pud_array()
    {
        $pud_array = array();
        
        $res = $this->db->select('*')
                        ->from('modifications')
                        ->where('item_type', 'pickup')
                        ->or_where('item_type', "delivery")
                        ->get()
                        ->result_array();

        foreach($res as $mod)
        {
            array_push($pud_array, $mod['mod_short_name']);
        }

        return $pud_array;
    }

    public function get_container_array()
    {
        $container_array = array();
        
        $res = $this->db->get_where('modifications', ['item_type'=>'container']);

        foreach($res as $mod)
        {
            array_push($container_array, $mod['mod_short_name']);
        }

        return $container_array;
    }
}