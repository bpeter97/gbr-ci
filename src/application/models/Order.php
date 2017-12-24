<?php

if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

class Order extends CI_Model
{
    private $id,
            $quote_id,
            $customer,
            $customer_id,
            $date,
            $time,
            $type,
            $job_name,
            $job_city,
            $job_address,
            $job_zipcode,
            $ordered_by,
            $onsite_contact,
            $onsite_contact_phone,
            $tax_rate,
            $cost_before_tax,
            $total_cost,
            $sales_tax,
            $monthly_total,
            $stage,
            $driver,
            $driver_notes,
            $delivered,
            $date_delivered,
            $container,
            $delivery_total;
    private $products = array();

    public function get_id() { return $this->id; }
    public function get_quote_id() { return $this->quote_id; }
    public function get_customer() { return $this->customer; }
    public function get_customer_id() { return $this->customer_id; }
    public function get_date() { return $this->date; }
    public function get_time() { return $this->time; }
    public function get_type() { return $this->type; }
    public function get_job_name() { return $this->job_name; }
    public function get_job_city() { return $this->job_city; }
    public function get_job_address() { return $this->job_address; }
    public function get_job_zipcode() { return $this->job_zipcode; }
    public function get_ordered_by() { return $this->ordered_by; }
    public function get_onsite_contact() { return $this->onsite_contact; }
    public function get_onsite_contact_phone() { return $this->onsite_contact_phone; }
    public function get_tax_rate() { return $this->tax_rate; }
    public function get_cost_before_tax() { return $this->cost_before_tax; }
    public function get_total_cost() { return $this->total_cost; }
    public function get_sales_tax() { return $this->sales_tax; }
    public function get_monthly_total() { return $this->monthly_total; }
    public function get_stage() { return $this->stage; }
    public function get_driver() { return $this->driver; }
    public function get_driver_notes() { return $this->driver_notes; }
    public function get_delivered() { return $this->delivered; }
    public function get_date_delivered() { return $this->date_delivered; }
    public function get_container() { return $this->container; }
    public function get_delivery_total() { return $this->delivery_total; }
    public function get_products() { return $this->products; }

    public function set_id($id) { $this->id = $id; return $this; }
    public function set_quote_id($id) { $this->quote_id = $id; return $this; }
    public function set_customer($string) { $this->customer = $string; return $this; }
    public function set_customer_id($id) { $this->customer_id = $id; return $this; }
    public function set_date($date) { $this->date = $date; return $this; }
    public function set_time($time) { $this->time = $time; return $this; }
    public function set_type($string) { $this->type = $string; return $this; }
    public function set_job_name($string) { $this->job_name = $string; return $this; }
    public function set_job_city($string) { $this->job_city = $string; return $this; }
    public function set_job_address($string) { $this->job_address = $string; return $this; }
    public function set_job_zipcode($int) { $this->job_zipcode = $int; return $this; }
    public function set_ordered_by($string) { $this->ordered_by = $string; return $this; }
    public function set_onsite_contact($string) { $this->onsite_contact = $string; return $this; }
    public function set_onsite_contact_phone($string) { $this->onsite_contact_phone = $string; return $this; }
    public function set_tax_rate($double) { $this->tax_rate = $double; return $this; }
    public function set_cost_before_tax($double) { $this->cost_before_tax = $double; return $this; }
    public function set_total_cost($double) { $this->total_cost = $double; return $this; }
    public function set_sales_tax($double) { $this->sales_tax = $double; return $this; }
    public function set_monthly_total($double) { $this->monthly_total = $double; return $this; }
    public function set_stage($int) { $this->stage = $int; return $this; }
    public function set_driver($int) { $this->driver = $int; return $this; }
    public function set_driver_notes($string) { $this->driver_notes = $string; return $this; }
    public function set_delivered($bool) { $this->delivered = $bool; return $this; }
    public function set_date_delivered($date) { $this->date_delivered = $date; return $this; }
    public function set_container($id) { $this->container = $id; return $this; }
    public function set_delivery_total($double) { $this->delivery_total = $double; return $this; }

    public function __construct($id = NULL)
    {
        parent::__contruct();

        if( ! $id === NULL )
        {
            $this->set_order_data($id);
        }
    }

    public function get_order_data($id = NULL)
    {
        if( ! $id === NULL )
        {
            return $this->db->get_where('orders', ['id'=>$id])->result();
        }
        else
        {
            return $this->db->get_where('orders', ['id'=>$this->get_id()])->result();
        }
    }

    public function set_order_data($mixed = NULL)
    {
        if( ! is_int($mixed) )
        {
            $data = $this->get_order_data($mixed);
        }
        else
        {
            $data = $mixed;
        }

        if( is_array($data) )
        {
            // Set data using an array.
            $this->set_id($data['id'])
                 ->set_quote_id($data['quote_id'])
                 ->set_customer($data['customer'])
                 ->set_customer_id($data['customer_id'])
                 ->set_date($data['date'])
                 ->set_time($data['time'])
                 ->set_type($data['type'])
                 ->set_job_name($data['job_name'])
                 ->set_job_city($data['job_city'])
                 ->set_job_address($data['job_address'])
                 ->set_job_zipcode($data['job_zipcode'])
                 ->set_ordered_by($data['ordered_by'])
                 ->set_onsite_contact($data['onsite_contact'])
                 ->set_onsite_contact_phone($data['onsite_contact_phone'])
                 ->set_tax_rate($data['tax_rate'])
                 ->set_cost_before_tax($data['cost_before_tax'])
                 ->set_total_cost($data['total_cost'])
                 ->set_sales_tax($data['sales_tax'])
                 ->set_monthly_total($data['monthly_total'])
                 ->set_stage($data['stage'])
                 ->set_driver($data['driver'])
                 ->set_driver_notes($data['driver_notes'])
                 ->set_delivered($data['delivered'])
                 ->set_date_delivered($data['date_delivered'])
                 ->set_container($data['container'])
                 ->set_delivery_total($data['delivery_total'])
                 ->get_order_products();
        }
        elseif( is_object($data) )
        {
            // set data using an object.
            $this->set_id($data->id)
                 ->set_quote_id($data->quote_id)
                 ->set_customer($data->customer)
                 ->set_customer_id($data->customer_id)
                 ->set_date($data->date)
                 ->set_time($data->time)
                 ->set_type($data->type)
                 ->set_job_name($data->job_name)
                 ->set_job_city($data->job_city)
                 ->set_job_address($data->job_address)
                 ->set_job_zipcode($data->job_zipcode)
                 ->set_ordered_by($data->ordered_by)
                 ->set_onsite_contact($data->onsite_contact)
                 ->set_onsite_contact_phone($data->onsite_contact_phone)
                 ->set_tax_rate($data->tax_rate)
                 ->set_cost_before_tax($data->cost_before_tax)
                 ->set_total_cost($data->total_cost)
                 ->set_sales_tax($data->sales_tax)
                 ->set_monthly_total($data->monthly_total)
                 ->set_stage($data->stage)
                 ->set_driver($data->driver)
                 ->set_driver_notes($data->driver_notes)
                 ->set_delivered($data->delivered)
                 ->set_date_delivered($data->date_delivered)
                 ->set_container($data->container)
                 ->set_delivery_total($data->delivery_total)
                 ->get_order_products();
        }

        return $this;

    }

    public function count_orders($where = NULL)
    {
        if( ! $where === NULL )
        {
            return $this->db->get('orders')->num_rows();
        }
        else
        {
            // $where must be an array!
            return $this->db->get_where('orders', $where)->num_rows();
        }
    }

    public function get_orders($where = NULL, $limit = NULL, $start = NULL)
    {
        // If limit is not null then check where
        if( ! $limit === NULL )
        {
            // If where is not null do limit with where
            if( ! $where === NULL )
            {
                $order_array = $this->db->get_where('orders', $where, $limit, $start)->result_array();
            }
            // else do limit with no where
            else
            {
                $order_array = $this->db->get_where('orders', $limit, $start)->result_array();
            }
        }
        // else if where is not null do where
        elseif( ! $where === NULL )    
        {
            $order_array = $this->db->get_where('orders', $where)->result_array();
        }
        // else get all of the orders
        else
        {
            $order_array = $this->db->get('orders')->result_array();
        }

        if($order_array)
        {
            $orders = array();

            foreach($order_array as $o)
            {
                $order = new Order($o['id']);
                array_push($orders, $order);
            }

            return $orders;
        }
        else
        {
            throw new Exception('There was no orders returned.');
        }
    }

    public function get_order_products()
    {
        $ordered_products = $this->db->get_where('product_orders', ['order_id'=>$this->get_id()])->result_array();

        foreach($ordered_products as $prod)
        {
            $product = new Product($prod['id']);
            $product->set_product_cost($prod['product_cost'])->set_product_quantity($prod['product_qty'])->set_product_type($prod['product_type']);

            array_push($this->products, $product);
        }
    }

    public function create()
    {
        $data = array(
            'customer'			        =>	$this->get_customer(),
            'customer_id'			    =>	$this->get_customer_id(),
            'date'				        =>	$this->get_date(),
            'time'				        =>	$this->get_time(),
            'type'				        =>	$this->get_type(),
            'job_name'					=>	$this->get_job_name(),
            'job_city'					=>	$this->get_job_city(),
            'job_address'				=>	$this->get_job_address(),
            'job_zipcode'				=>	$this->get_job_zipcode(),
            'ordered_by'				=>	$this->get_ordered_by(),
            'onsite_contact'			=>	$this->get_onsite_contact(),
            'onsite_contact_phone'		=>	$this->get_onsite_contact_phone(),
            'tax_rate'					=>	$this->get_tax_rate(),
            'cost_before_tax'			=>	$this->get_cost_before_tax(),
            'total_cost'				=>	$this->get_total_cost(),
            'monthly_total'				=>	$this->get_monthly_total(),
            'sales_tax'					=>	$this->get_sales_tax(),
            'delivery_total'			=>	$this->get_delivery_total(),
            'stage'						=>	1
        );

        if( $this->db->insert('orders', $data) )
        {
            return $this->db->insert_id();
        }
        else
        {
            return FALSE;
        }
    }

    public function insert_ordered_products($quote_id = NULL)
    {
        if( ! $quote_id === NULL )
        {
            $i = 0;
            while ($i < $this->input->post('item_count'))
            {
                /*
                 * Here we will decode the json and create each product and insert it into the
                 * product orders database.
                 */
                $posted_product = json_decode($this->input->post('product'.$i), true);
                $product = new Product($posted_product['id']);
                $product->set_product_quantity($posted_product['qty']);
                $product->set_product_cost($posted_product['cost']);
                
                $i++;
    
                // Insert the data into the database.
                
                $data = array(
                    'quote_id' => $quote_id,
                    'order_id' => $this->get_id(),
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
        else
        {
            $i = 0;
            while ($i < $this->input->post('item_count'))
            {
                /*
                 * Here we will decode the json and create each product and insert it into the
                 * product orders database.
                 */
                $posted_product = json_decode($this->input->post('product'.$i), true);
                $product = new Product($posted_product['id']);
                $product->set_product_quantity($posted_product['qty']);
                $product->set_product_cost($posted_product['cost']);
                
                $i++;
    
                // Insert the data into the database.
                
                $data = array(
                    'order_id' => $this->get_id(),
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
    }

    public function search($string)
    {
        // Return an array of the orders that match the search.
        return $this->db->select('*')
                        ->from('orders')
                        ->like('customer', $string)
                        ->like('date', $string)
                        ->like('time', $string)
                        ->like('type', $string)
                        ->like('job_name', $string)
                        ->like('job_city', $string)
                        ->like('job_address', $string)
                        ->like('job_zipcode', $string)
                        ->like('ordered_by', $string)
                        ->like('onsite_contact', $string)
                        ->like('onsite_contact_phone', $string)
                        ->like('cost_before_tax', $string)
                        ->like('total_cost', $string)
                        ->like('sales_tax', $string)
                        ->like('monthly_total', $string)
                        ->like('stage', $string)
                        ->like('driver', $string)
                        ->like('driver_notes', $string)
                        ->like('date_delivered', $string)
                        ->like('container', $string)
                        ->like('delivery_total', $string)
                        ->get()
                        ->result_array();

    }

    public function update()
    {
        return $this->db->update('orders', $this, ['id' => $this->get_id()]);
    }

    public function delete($id = NULL)
    {
        // Delete the order by using an ID.
        if($id === NULL)
        {
            // Delete the order by using object's id property.
            return $this->db->delete('quotes', ['id'=>$this->get_id()]);
        } 
        else 
        {
            // Delete the order by using parameter id.
            return $this->db->delete('quotes', ['id'=>$id]);
        }
    }

    // previously called rentalHistoryEntry()
    public function create_rental_history($container_id)
    {
        $this->container->set_container_data($container_id);

        $item_cost = 0;

        foreach($this->get_products() as $product)
        {
            if( $product->get_mod_short_name() == $container->get_short_name() )
            {
                $item_cost = $product->get_product_cost();
            }
        }

        $data = array(
            'container_id'  => $container_id,
            'start_date'    => $this->get_date(),
            'customer'      => $this->get_customer(),
            'order_id'      => $this->get_id(),
            'cost'          => $item_cost
        );

        if( $this->db->insert('rental_history', $data) )
        {
            return $this->db->insert_id();
        }
        else
        {
            return FALSE;
        }
    }
}