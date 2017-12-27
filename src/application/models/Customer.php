<?php

if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

class Customer extends CI_Model
{
    private $id,
            $name,
            $address1,
            $address2,
            $city,
            $zipcode,
            $state,
            $phone,
            $ext,
            $fax,
            $email,
            $rdp,
            $notes,
            $flag,
            $flag_reason;

    public function get_id() { return $this->id; }
    public function get_name() { return $this->name; }
    public function get_address1() { return $this->address1; }
    public function get_address2() { return $this->address2; }
    public function get_city() { return $this->city; }
    public function get_zipcode() { return $this->zipcode; }
    public function get_state() { return $this->state; }
    public function get_phone() { return $this->phone; }
    public function get_ext() { return $this->ext; }
    public function get_fax() { return $this->fax; }
    public function get_email() { return $this->email; }
    public function get_rdp() { return $this->rdp; }
    public function get_notes() { return $this->notes; }
    public function get_flag() { return $this->flag; }
    public function get_flag_reason() { return $this->flag_reason; }

    public function set_id($int) { $this->id = $int; return $this; }
    public function set_name($string) { $this->name = $string; return $this; }
    public function set_address1($string) { $this->address1 = $string; return $this; }
    public function set_address2($string) { $this->address2 = $string; return $this; }
    public function set_city($string) { $this->city = $string; return $this; }
    public function set_zipcode($int) { $this->zipcode = $int; return $this; }
    public function set_state($string) { $this->state = $string; return $this; }
    public function set_phone($string) { $this->phone = $string; return $this; }
    public function set_ext($int) { $this->ext = $int; return $this; }
    public function set_fax($string) { $this->fax = $string; return $this; }
    public function set_email($string) { $this->email = $string; return $this; }
    public function set_rdp($string) { $this->rdp = $string; return $this; }
    public function set_notes($string) { $this->notes = $string; return $this; }
    public function set_flag($bool) { $this->flag = $bool; return $this; }
    public function set_flag_reason($string) { $this->flag_reason = $string; return $this; }

    // Removed $use_name out of constructor, need to check if $id is_string in set_customer_data()
    public function __construct($id = NULL)
    {
        parent::__construct();

        if( $id !== NULL )
        {
            $this->set_customer_data($id);
        }

    }

    public function get_customer_data($id = NULL)
    {
        if( $id !== NULL )
        {
            if( is_int($id) )
            {
                return $this->db->get_where('customers',['id'=>$id])->result();
            }
            elseif( is_string($id) )
            {
                return $this->db->get_where('customers',['name'=>$id])->result();
            }
        }
        else
        {
            return $this->db->get_where('customers',['id'=>$this->get_id()])->result();
        }
    }

    public function set_customer_data($mixed = NULL)
    {
        if( is_int($mixed) || is_string($mixed) )
        {
            $data = $this->get_customer_data($mixed);
        }
        else
        {
            $data = $mixed;
        }

        if( is_array($data) )
        {
            $this->set_id($data['id'])
                 ->set_name($data['name'])
                 ->set_address1($data['address1'])
                 ->set_address2($data['address2'])
                 ->set_city($data['city'])
                 ->set_zipcode($data['zipcode'])
                 ->set_state($data['state'])
                 ->set_phone($data['phone'])
                 ->set_ext($data['ext'])
                 ->set_fax($data['fax'])
                 ->set_email($data['email'])
                 ->set_rdp($data['rdp'])
                 ->set_notes($data['notes'])
                 ->set_flag($data['flag'])
                 ->set_flag_reason($data['flag_reason']);
        }
        elseif( is_object($data) )
        {
            $this->set_id($data->id)
                 ->set_name($data->name)
                 ->set_address1($data->address1)
                 ->set_address2($data->address2)
                 ->set_city($data->city)
                 ->set_zipcode($data->zipcode)
                 ->set_state($data->state)
                 ->set_phone($data->phone)
                 ->set_ext($data->ext)
                 ->set_fax($data->fax)
                 ->set_email($data->email)
                 ->set_rdp($data->rdp)
                 ->set_notes($data->notes)
                 ->set_flag($data->flag)
                 ->set_flag_reason($data->flag_reason);
        }
        else
        {
            throw new Exception('The parameter passed in is not a name, id, object, or array.');
        }
    }

    public function count_customers()
    {
        if( $where !== NULL )
        {
            return $this->db->get('customers')->num_rows();
        }
        else
        {
            // $where must be an array!
            return $this->db->get_where('customers', $where)->num_rows();
        }
    }

    // $where must be an array.
    public function get_customers($where, $limit, $start)
    {
        // If limit is not null then check where
        if( $limit !== NULL )
        {
            // If where is not null do limit with where
            if( $where !== NULL )
            {
                $customer_array = $this->db->get_where('customers', $where, $limit, $start)->result_array();
            }
            // else do limit with no where
            else
            {
                $customer_array = $this->db->get_where('customers', $limit, $start)->result_array();
            }
        }
        // else if where is not null do where
        elseif( $where !== NULL )    
        {
            $customer_array = $this->db->get_where('customers', $where)->result_array();
        }
        // else get all of the products
        else
        {
            $customer_array = $this->db->get('customers')->result_array();
        }

        if($customer_array)
        {
            $customers = array();

            foreach($customer_array as $cust)
            {
                $customer = new Customer($cust['id']);
                array_push($customers, $customer);
            }

            return $customers;
        }
        else
        {
            throw new Exception('There was no customers returned.');
        }
    }

    public function update()
    {
        $data = array(
            'name'          => $this->get_name(), 
            'address1'      => $this->get_address1(),
            'address2'      => $this->get_address2(),
            'city'          => $this->get_city(),
            'zipcode'       => $this->get_zipcode(),
            'state'         => $this->get_state(),
            'phone'         => $this->get_phone(),
            'ext'           => $this->get_ext(),
            'fax'           => $this->get_fax(),
            'email'         => $this->get_email(),
            'rdp'           => $this->get_rdp(),
            'notes'         => $this->get_notes(),
            'flag'          => $this->get_flag(),
            'flag_reason'   => $this->get_flag_reason()
        );

        return $this->db->update('customers', $data, ['id'=>$this->get_id()]);
    }

    public function create()
    {
        if( $this->db->insert('customers', array(
                    'name'      => $this->get_name(), 
                    'address1'  => $this->get_address1(),
                    'address2'  => $this->get_address2(),
                    'city'      => $this->get_city(),
                    'zipcode'   => $this->get_zipcode(),
                    'state'     => $this->get_state(),
                    'phone'     => $this->get_phone(),
                    'ext'       => $this->get_ext(),
                    'fax'       => $this->get_fax(),
                    'email'     => $this->get_email(),
                    'rdp'       => $this->get_rdp(),
                    'notes'     => $this->get_notes()
        )))
        {
            return $this->db->insert_id();
        }
        else
        {
            return FALSE;
        }
    }
    
    // TODO: correct the use of customer name for these queries, this should be a join statement using the customer ID.
    // previously called fetchRentalHistory(), fetchQuoteHistory(), and fetchOrderHistory()
    public function get_history($type)
    {

        switch ($type) {

            case 'quote':

                if( $quote_array = $this->db->get_where('quotes',['quote_customer' => $this->get_name()])->result_array() )
                {
                    $quotes = array();
        
                    foreach($quote_array as $q)
                    {
                        $quote = new Quote($q);
                        array_push($quotes, $quote);
                    }
        
                    return $quotes;
                }
                else
                {
                    return FALSE;
                }

                break;

            case 'order':

                // SELECT * FROM orders WHERE order_customer = name AND order_type = Sales OR order_customer = name AND order_type = Resale.
                if( $order_array = $this->db->get_where('orders',['order_customer' => $this->get_name(), 'order_type'=>'Sales'])
                                            ->or_where(['order_customer' => $this->get_name(), 'order_type'=>'Resale'])
                                            ->result_array() )
                {
                    $orders = array();
        
                    foreach($order_array as $o)
                    {
                        $order = new Order($o);
                        array_push($orders, $order);
                    }
        
                    return $orders;
                }
                else
                {
                    return FALSE;
                }

                break;

            case 'rental':

                if( $order_array = $this->db->get_where('orders',['order_customer' => $this->get_name(), 'order_type'=>'Rental'])->result_array() )
                {
                    $orders = array();

                    foreach($order_array as $o)
                    {
                        $order = new Order($o);
                        array_push($orders, $order);
                    }

                    return $orders;
                }
                else
                {
                    return FALSE;
                }

                break;

            default:

                throw new Exception('The parameter passed in was not "Sales", "Rental", or "Resale".');

                break;
        }

    }

    public function search($string)
    {
        // Return an array of the products that match the search.
        return $this->db->select('*')
                        ->from('customers')
                        ->like('name', $string)
                        ->like('address1', $string)
                        ->like('address2', $string)
                        ->like('city', $string)
                        ->like('state', $string)
                        ->like('phone', $string)
                        ->like('ext', $string)
                        ->like('fax', $string)
                        ->like('email', $string)
                        ->like('rdp', $string)
                        ->like('notes', $string)
                        ->get()
                        ->result_array();
    }

    public function delete($id = NULL)
    {
        if( $id !== NULL )
        {
            return $this->db->delete('customers',['id'=>$id]);
        }
        else
        {
            return $this->db->delete('customers',['id'=>$this->get_id()]);
        }
    }
}