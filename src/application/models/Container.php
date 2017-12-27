<?php

if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

// TODO: Change column names in database to match this model!!!!!

class Container extends CI_Model
{
    private $id,
            $release_number,
            $size,
            $serial_number,
            $number,
            $shelves,
            $paint,
            $onbox_numbers,
            $signs,
            $rental_resale,
            $is_rented,
            $address,
            $latitude,
            $longitude,
            $type,
            $flag,
            $flag_reason,
            $size_code,
            $short_name;

    public function get_id() { return $this->id; }
    public function get_release_number() { return $this->release_number; }
    public function get_size() { return $this->size; }
    public function get_serial_number() { return $this->serial_number; }
    public function get_number() { return $this->number; }
    public function get_shelves() { return $this->shelves; }
    public function get_paint() { return $this->paint; }
    public function get_onbox_numbers() { return $this->onbox_numbers; }
    public function get_signs() { return $this->signs; }
    public function get_rental_resale() { return $this->rental_resale; }
    public function get_is_rented() { return $this->is_rented; }
    public function get_address() { return $this->address; }
    public function get_latitude() { return $this->latitude; }
    public function get_longitude() { return $this->longitude; }
    public function get_type() { return $this->type; }
    public function get_flag() { return $this->flag; }
    public function get_flag_reason() { return $this->flag_reason; }
    public function get_size_code() { return $this->size_code; }
    public function get_short_name() { return $this->short_name; }

    public function set_id($id) { $this->id = $id; return $this; }
    public function set_release_number($num) { $this->release_number = $num; return $this; }
    public function set_size($size) { $this->size = $size; return $this; }
    public function set_serial_number($num) { $this->serial_number = $num; return $this; }
    public function set_number($num) { $this->number = $num; return $this; }
    public function set_shelves($bool) { $this->shelves = $bool; return $this; }
    public function set_paint($bool) { $this->paint = $bool; return $this; }
    public function set_onbox_numbers($bool) { $this->onbox_numbers = $bool; return $this; }
    public function set_signs($bool) { $this->signs = $bool; return $this; }
    public function set_rental_resale($rental_resale) { $this->rental_resale = $rental_resale; return $this; }
    public function set_is_rented($bool) { $this->is_rented = $bool; return $this; }
    public function set_address($address) { $this->address = $address; return $this; }
    public function set_latitude($lat) { $this->latitude = $lat; return $this; }
    public function set_longitude($lon) { $this->longitude = $lon; return $this; }
    public function set_type($type) { $this->type = $type; return $this; }
    public function set_flag($bool) { $this->flag = $bool; return $this; }
    public function set_flag_reason($reason) { $this->flag_reason = $reason; return $this; }
    public function set_size_code($code) { $this->size_code = $code; return $this; }
    public function set_short_name($name) { $this->short_name = $name; return $this; }

    public function __construct($id = NULL)
    {
        parent::__construct();

        // If ID is passed in, set the data!
        if( $id !== NULL )
        {
            $this->set_container_data($id);
        }
    }

    public function get_container_data($id = NULL)
    {
        if( $id !== NULL )
        {
            return $this->db->get_where('containers', ['id' => $id])->result();
        }
        else
        {
            return $this->db->get_where('containers', ['id' => $this->get_id()])->result();
        }
    }

    public function set_container_data($mixed = NULL)
    {
        if( is_int($mixed) )
        {
            $data = $this->get_container_data($mixed);
        }
        else
        {
            $data = $mixed;
        }

        if( is_array($data) )
        {
            $this->set_id($data['id'])
                 ->set_release_number($data['num'])
                 ->set_size($data['size'])
                 ->set_serial_number($data['num'])
                 ->set_number($data['num'])
                 ->set_shelves($data['bool'])
                 ->set_paint($data['bool'])
                 ->set_onbox_numbers($data['bool'])
                 ->set_signs($data['bool'])
                 ->set_rental_resale($data['rental_resale'])
                 ->set_is_rented($data['bool'])
                 ->set_address($data['address'])
                 ->set_latitude($data['lat'])
                 ->set_longitude($data['lon'])
                 ->set_type($data['type'])
                 ->set_flag($data['bool'])
                 ->set_flag_reason($data['reason'])
                 ->set_size_code($data['code'])
                 ->set_short_name($data['name']);
        }
        elseif( is_object($data) )
        {
            $this->set_id($data->id)
                 ->set_release_number($data->num)
                 ->set_size($data->size)
                 ->set_serial_number($data->num)
                 ->set_number($data->num)
                 ->set_shelves($data->bool)
                 ->set_paint($data->bool)
                 ->set_onbox_numbers($data->bool)
                 ->set_signs($data->bool)
                 ->set_rental_resale($data->rental_resale)
                 ->set_is_rented($data->bool)
                 ->set_address($data->address)
                 ->set_latitude($data->lat)
                 ->set_longitude($data->lon)
                 ->set_type($data->type)
                 ->set_flag($data->bool)
                 ->set_flag_reason($data->reason)
                 ->set_size_code($data->code)
                 ->set_short_name($data->name);
        }
        else
        {
            throw new Exception('The data passed in was not an array, integer, or object. Therefore the data could not be set.');
        }

        return $this;
    }

    // TODO: Removed getPost() function!!!!!!!!!

    public function get_sizes()
    {
        return $this->db->distinct()->select('size')->from('containers')->get()->result_array();
    }

    public function update()
    {
        $this->get_lat_lon($this->get_address());

        $data = array(
            'release_number' => $this->get_release_number(), 
            'size'           => $this->get_size(),
            'serial_number'  => $this->get_serial_number(),
            'number'         => $this->get_number(),
            'shelves'        => $this->get_shelves(),
            'paint'          => $this->get_paint(),
            'onbox_numbers'  => $this->get_onbox_numbers(),
            'signs'          => $this->get_signs(),
            'rental_resale'  => $this->get_rental_resale(),
            'is_rented'      => $this->get_is_rented(),
            'address'        => $this->get_address(),
            'latitude'       => $this->get_latitude(),
            'longitude'      => $this->get_longitude(),
            'type'           => $this->get_type(),
            'flag'           => $this->get_flag(),
            'flag_reason'    => $this->get_flag_reason(),
            'size_code'      => $this->get_size_code(),
            'short_name'     => $this->get_short_name()
        );

        return $this->db->update('containers', $data, ['id'=>$this->get_id()]);
    }

    public function delete($id = NULL)
    {
        if( $id !== NULL )
        {
            return $this->db->delete('containers', ['id'=>$this->get_id()]);
        }
        else
        {
            return $this->db->delete('containers', ['id'=>$id]);
        }
    }

    public function create()
    {
        if( $this->db->insert('containers', array(
                    'release_number' => $this->get_release_number(), 
                    'size'           => $this->get_size(),
                    'serial_number'  => $this->get_serial_number(),
                    'number'         => $this->get_number(),
                    'shelves'        => $this->get_shelves(),
                    'paint'          => $this->get_paint(),
                    'onbox_numbers'  => $this->get_onbox_numbers(),
                    'signs'          => $this->get_signs(),
                    'rental_resale'  => $this->get_rental_resale(),
                    'is_rented'      => $this->get_is_rented(),
                    'address'        => $this->get_address(),
                    'latitude'       => $this->get_latitude(),
                    'longitude'      => $this->get_longitude(),
                    'type'           => $this->get_type(),
                    'flag'           => $this->get_flag(),
                    'flag_reason'    => $this->get_flag_reason(),
                    'size_code'      => $this->get_size_code(),
                    'short_name'     => $this->get_short_name()
        )))
        {
            return $this->db->insert_id();
        }
        else
        {
            return FALSE;
        }
    }

    public function deliver($address, $is_rented)
    {
        // Set the new address.
        $this->set_address($address)->set_is_rented($is_rented)->get_lat_lon($address);

        if( $this->get_rental_resale() == 'Resale' )
        {
            // TODO: Verify that when a resale container is delivered, that means it was sold.
            $this->set_rental_resale('Sold');
        }

        $data = array(
            'rental_resale'  => $this->get_rental_resale(),
            'is_rented'      => $this->get_is_rented(),
            'address'        => $this->get_address(),
            'latitude'       => $this->get_latitude(),
            'longitude'      => $this->get_longitude()
        );

        // Update the container.
        return $this->db->update('containers', $data, ['id'=>$this->get_id()]);
    }

    public function get_lat_lon($addy)
    {
        $address = urlencode($addy);

        if( strlen($address) > 0 )
        {
            $request_url = 'http://maps.googleapis.com/maps/api/geocode/xml?address='. $address . '&sensor=true';
            $xml = simplexml_load_file($request_url);
            $status = $xml->status;

            if($status == 'OK')
            {
                $this->set_longitude($xml->result->geometry->location->lng);
                $this->set_latitude($xml->result->geometry->location->lat);
            }
        }
    }

    public function count_containers($where = NULL)
    {
        if( $where !== NULL )
        {
            return $this->db->get('containers')->num_rows();
        }
        else
        {
            // $where must be an array!
            return $this->db->get_where('containers', $where)->num_rows();
        }
    }

    // $where must be an array!
    // Previously called fetchContainers()
    public function get_containers($where = NULL, $limit = NULL, $start = NULL)
    {
        // If limit is not null then check where
        if( $limit !== NULL )
        {
            // If where is not null do limit with where
            if( $where !== NULL )
            {
                $container_array = $this->db->get_where('containers', $where, $limit, $start)->result_array();
            }
            // else do limit with no where
            else
            {
                $container_array = $this->db->get_where('containers', $limit, $start)->result_array();
            }
        }
        // else if where is not null do where
        elseif( $where !== NULL )    
        {
            $container_array = $this->db->get_where('containers', $where)->result_array();
        }
        // else get all of the products
        else
        {
            $container_array = $this->db->get('containers')->result_array();
        }

        if($container_array)
        {
            $containers = array();

            foreach($container_array as $con)
            {
                $container = new Container($con['id']);
                array_push($containers, $container);
            }

            return $containers;
        }
        else
        {
            throw new Exception('There was no containers returned.');
        }
    }

    // Previously called fetchOrderHistory()
    public function get_order_history()
    {
        return $this->db->get_where('rental_history', ['container_id' => $this->get_id()])->result_array();
    }

    public function check_boxes($check)
    {
        if($check == 1)
        {
			return "Yes";
        }
        else
        {
			return "No";
		}
    }

    // TODO: Removed post data.

    public function search($string)
    {
        // Return an array of the products that match the search.
        return $this->db->select('*')
                ->from('containers')
                ->like('release_number', $string)
                ->like('size', $string)
                ->like('serial_number', $string)
                ->like('number', $string)
                ->like('shelves', $string)
                ->like('paint', $string)
                ->like('onbox_numbers', $string)
                ->like('signs', $string)
                ->like('rental_resale', $string)
                ->like('address', $string)
                ->like('short_name', $string)
                ->like('type', $string)
                ->get()
                ->result_array();
    }

    public function find_size_and_short_name()
    {
        
        if( $res = $this->db->distinct()->select('size, container_size_code, container_short_name')->from('containers')->get()->result_array() )
        {       
            foreach ($res as $r){
                if($this->get_size() == $r['container_size']){
                    $this->set_size_code($r['container_size_code']);
                    $this->set_short_name($r['container_short_name']);
                }
            }
        }
        else
        {
            // Log the database error.
            log_message('error', $this->db->error());

            throw new Exception('Could not find the proper size code or short name.');
        }  
    }
}