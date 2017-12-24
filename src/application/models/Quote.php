<?php

if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

class Quote extends CI_Model
{
    private $id,
            $customer,
            $customer_id,
            $type,
            $date,
            $status,
            $job_name,
            $job_address,
            $job_city,
            $job_zipcode,
            $attn,
            $tax_rate,
            $cost_before_tax,
            $total_cost,
            $sales_tax,
            $monthly_total,
            $delivery_total;
    private $products = array();
    private $hidden = 0;

    public function get_id() { return $this->id; }
    public function get_customer() { return $this->customer; }
    public function get_customer_id() { return $this->customer_id; }
    public function get_type() { return $this->type; }
    public function get_date() { return $this->date; }
    public function get_status() { return $this->status; }
    public function get_job_name() { return $this->job_name; }
    public function get_job_address() { return $this->job_address; }
    public function get_job_city() { return $this->job_city; }
    public function get_job_zipcode() { return $this->job_zipcode; }
    public function get_attn() { return $this->attn; }
    public function get_tax_rate() { return $this->tax_rate; }
    public function get_cost_before_tax() { return $this->cost_before_tax; }
    public function get_total_cost() { return $this->total_cost; }
    public function get_sales_tax() { return $this->sales_tax; }
    public function get_monthly_total() { return $this->monthly_total; }
    public function get_delivery_total() { return $this->delivery_total; }
    public function get_hidden() { return $this->hidden; }

    public function set_id($int) { $this->id = $int; return $this; }
    public function set_customer($string) { $this->customer = $string; return $this; }
    public function set_customer_id($int) { $this->customer_id = $int; return $this; }
    public function set_type($string) { $this->type = $string; return $this; }
    public function set_date($date) { $this->date = $date; return $this; }
    public function set_status($string) { $this->status = $string; return $this; }
    public function set_job_name($string) { $this->job_name = $string; return $this; }
    public function set_job_address($string) { $this->job_address = $string; return $this; }
    public function set_job_city($string) { $this->job_city = $string; return $this; }
    public function set_job_zipcode($string) { $this->job_zipcode = $string; return $this; }
    public function set_attn($string) { $this->attn = $string; return $this; }
    public function set_tax_rate($float) { $this->tax_rate = $float; return $this; }
    public function set_cost_before_tax($float) { $this->cost_before_tax = $float; return $this; }
    public function set_total_cost($float) { $this->total_cost = $float; return $this; }
    public function set_sales_tax($float) { $this->sales_tax = $float; return $this; }
    public function set_monthly_total($float) { $this->monthly_total = $float; return $this; }
    public function set_delivery_total($float) { $this->delivery_total = $float; return $this; }
    public function set_hidden($hidden) { $this->hidden = $hidden; return $this; }

    public function __construct()
    {
        parent::__construct();

        if( ! $id === NULL )
        {
            $this->set_quote_data($id);
        }
    }

    public function get_quote_data($id = NULL)
    {
        if( ! $id === NULL )
        {
            return $this->db->get_where('quotes', ['id'=>$id])->result();
        }
        else
        {
            return $this->db->get_where('quotes', ['id'=>$this->get_id()])->result();
        }
    }

    public function set_quote_data($mixed = NULL)
    {
        if( is_int($mixed) )
        {
            $data = $this->get_quote_data($mixed);
        }
        else
        {
            $data = $mixed;
        }

        if( is_array($data) )
        {
            $this->set_id($data['id'])
                 ->set_customer($data['quote_customer'])
                 ->set_customer_id($data['quote_customer_id'])
                 ->set_type($data['quote_type'])
                 ->set_date($data['quote_date'])
                 ->set_status($data['quote_status'])
                 ->set_job_name($data['job_name'])
                 ->set_job_address($data['job_address'])
                 ->set_job_city($data['job_city'])
                 ->set_job_zipcode($data['job_zipcode'])
                 ->set_attn($data['attn'])
                 ->set_tax_rate($data['tax_rate'])
                 ->set_cost_before_tax($data['cost_before_tax'])
                 ->set_total_cost($data['total_cost'])
                 ->set_sales_tax($data['sales_tax'])
                 ->set_monthly_total($data['monthly_total'])
                 ->set_delivery_total($data['delivery_total'])
                 ->set_hidden($data['hidden']);
        }
        elseif( is_object($data) )
        {
            $this->set_id($data->id)
                 ->set_customer($data->quote_customer)
                 ->set_customer_id($data->quote_customer_id)
                 ->set_type($data->quote_type)
                 ->set_date($data->quote_date)
                 ->set_status($data->quote_status)
                 ->set_job_name($data->job_name)
                 ->set_job_address($data->job_address)
                 ->set_job_city($data->job_city)
                 ->set_job_zipcode($data->job_zipcode)
                 ->set_attn($data->attn)
                 ->set_tax_rate($data->tax_rate)
                 ->set_cost_before_tax($data->cost_before_tax)
                 ->set_total_cost($data->total_cost)
                 ->set_sales_tax($data->sales_tax)
                 ->set_monthly_total($data->monthly_total)
                 ->set_delivery_total($data->delivery_total)
                 ->set_hidden($data->hidden);
        }
        else
        {
            throw new Exception('The data passed into the parameter was not an integer, array, or object.');
        }    
	
        return $this;

    }

    public function count_quotes($where = NULL)
    {
        if( ! $where === NULL )
        {
            return $this->db->get('quotes')->num_rows();
        }
        else
        {
            // $where must be an array!
            return $this->db->get_where('quotes', $where)->num_rows();
        }
    }

    // $where must be an array!
    public function get_quotes($where = NULL, $limit = NULL, $start = NULL)
    {
        // If limit is not null then check where
        if( ! $limit === NULL )
        {
            // If where is not null do limit with where
            if( ! $where === NULL )
            {
                $quote_array = $this->db->get_where('quotes', $where, $limit, $start)->result_array();
            }
            // else do limit with no where
            else
            {
                $quote_array = $this->db->get_where('quotes', $limit, $start)->result_array();
            }
        }
        // else if where is not null do where
        elseif( ! $where === NULL )    
        {
            $quote_array = $this->db->get_where('quotes', $where)->result_array();
        }
        // else get all of the quotes
        else
        {
            $quote_array = $this->db->get('quotes')->result_array();
        }

        if($quote_array)
        {
            $quotes = array();

            foreach($quote_array as $q)
            {
                $quote = new Quote($q['id']);
                array_push($quotes, $quote);
            }

            return $quotes;
        }
        else
        {
            throw new Exception('There was no quotes returned.');
        }
    }

    // previously called fetchQuoteProducts()
    public function get_quote_products()
    {
        $quoted_products = $this->db->get_where('product_orders', ['quote_id'=>$this->get_id()])->result_array();

        foreach($quoted_products as $prod)
        {
            $product = new Product($prod['id']);
            $product->set_product_cost($prod['product_cost'])->set_product_quantity($prod['product_qty'])->set_product_type($prod['product_type']);

            array_push($this->products, $product);
        }
    }

    // previously called createQuote()
    public function create()
    {

        if( $this->db->insert('quotes', array(
            'customer'          => $this->get_customer(),
            'customer_id'       => $this->get_customer_id(),
            'date'              => $this->get_date(),
            'status'            => $this->get_status(),
            'type'              => $this->get_type(),
            'job_name'          => $this->get_job_name(),
            'job_city'          => $this->get_job_city(),
            'job_address'       => $this->get_job_address(),
            'job_zipcode'       => $this->get_job_zipcode(),
            'attn'              => $this->get_attn(),
            'tax_rate'          => $this->get_tax_rate(),
            'cost_before_tax'   => $this->get_cost_before_tax(),
            'total_cost'        => $this->get_total_cost(),
            'sales_tax'         => $this->get_sales_tax(),
            'monthly_total'     => $this->get_monthly_total(),
            'delivery_total'    => $this->get_delivery_total(),
            'hidden'            => NULL
        )))
        {
            return $this->db->insert_id();    
        }
        else
        {
            return FALSE;
        }

    }

    // $posted_products = json_decode($_post['product'.$i], true)
    public function insert_quoted_products($item_count, $posted_products)
    {
        $i = 0;
		while ($i < $item_count)
		{
			/*
			 * Here we will decode the json and create each product and insert it into the
			 * product orders database.
			 */
            $posted_product = json_decode($_post['product'.$i], true);
            $product = new Product($posted_product['id']);
			$product->set_product_quantity($posted_product['qty']);
            $product->set_product_cost($posted_product['cost']);
            
			$i++;

            // Insert the data into the database.
            
            $data = array(
                'quote_id' => $this->get_id(),
                'product_type'=>$product->get_item_type(),
                'product_msn'=>$product->get_mod_short_name(),
                'product_cost'=>$product->get_product_cost(),
                'product_qty'=>$product->get_product_quantity(),
                'product_name'=>$product->get_product_name(),
                'product_id'=>$product->get_id()
            );

            if( ! $this->db->insert('product_orders', $data) )
            {
                throw new Exception('The quoted products were not inserted into the database correctly.');
            }
            else
            {
                return TRUE;
            }
		}
    }

    public function update()
    {
        return $this->db->update('quotes', $this, ['id' => $this->get_id()]);
    }

    public function delete($id = NULL)
    {
        // Delete the modification by using an ID.
        if($id === NULL)
        {
            // Delete the modification by using object's id property.
            return $this->db->delete('quotes', ['id'=>$this->get_id()]);
        } 
        else 
        {
            // Delete the modification by using parameter id.
            return $this->db->delete('quotes', ['id'=>$id]);
        }
    }

    public function search($string)
    {
        // Return an array of the quotes that match the search.
        return $this->db->select('*')
                        ->from('quotes')
                        ->like('quote_customer', $string)
                        ->like('quote_type', $string)
                        ->like('quote_date', $string)
                        ->like('quote_status', $string)
                        ->like('job_name', $string)
                        ->like('job_address', $string)
                        ->like('job_city', $string)
                        ->like('job_zipcode', $string)
                        ->like('attn', $string)
                        ->like('tax_rate', $string)
                        ->like('cost_before_tax', $string)
                        ->like('total_cost', $string)
                        ->like('sales_tax', $string)
                        ->like('monthly_total', $string)
                        ->like('delivery_total', $string)
                        ->get()
                        ->result_array();
    }

    public function update_quote_products_with_order_id($id)
    {
        return $this->db->update('product_orders', ['order_id' => $id], ['quote_id' => $this->get_id()]);
    }
}