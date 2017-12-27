<?php

if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

class Event extends CI_Model
{
    private $id,
            $title,
            $color,
            $start,
            $end,
            $order_id,
            $order;

    public function get_id() { return $this->id; }
    public function get_title() { return $this->title; }
    public function get_color() { return $this->color; }
    public function get_start() { return $this->start; }
    public function get_end() { return $this->end; }
    public function get_order_id() { return $this->order_id; }
    public function get_order() { return $this->order; }

    public function set_id($id) { $this->id = $id; return $this; }
    public function set_title($title) { $this->title = $title; return $this; }
    public function set_color($color) { $this->color = $color; return $this; }
    public function set_start($datetime) { $this->start = $datetime; return $this; }
    public function set_end($datetime) { $this->end = $datetime; return $this; }
    public function set_order_id($id) { $this->order_id = $id; return $this; }
    public function set_order($obj) { $this->order = $obj; return $this; }	

    public function __construct($id = NULL)
    {
        parent::__construct();
        
        if( $id !== NULL )
        {
            $this->set_event_data($id);
            if( $this->get_order_id() !== NULL )
            {
                $this->get_event_order_info();
            }
        }
    }

    // previously called getDetails()
    public function get_event_info($id = NULL)
    {
        if( $id !== NULL )
        {
            // Return user info based on supplied ID.
            return $this->db->get_where('events', ['id' => $id])->result();
        }
        else
        {
            // Return user info based on user model ID.
            return $this->db->get_where('events', ['id' => $this->get_id()])->result();
        }
    }

    public function get_event_by_order_id($id)
    {
        if( $id !== NULL )
        {
            // Return user info based on supplied ID.
            $this->set_event_data($this->db->get_where('events', ['order_id' => $id])->result());
        }
        else
        {
            // Return user info based on user model ID.
            $this->set_event_data($this->db->get_where('events', ['order_id' => $this->get_id()])->result());
        }
    }

    public function get_event_order_info()
    {
        if( $this->get_order_id() !== NULL )
        {
            $this->set_order(new Order($this->get_order_id()));
        }
    }

    public function set_event_data($id = NULL)
    {
        if(is_int($id))
        {
            $event = $this->get_event_info($id);
        }
        else
        {
            $event = $id;
        }

        // Use setters to setup this objects properties using the object passed in.
        if(is_array($event))
        {
            $this->set_id($event['id'])
                 ->set_title($event['title'])
                 ->set_color($event['color'])
                 ->set_start($event['datetime'])
                 ->set_end($event['datetime'])
                 ->set_order_id($event['order_id'])
                 ->get_event_order_info();
        } 
        elseif(is_object($event))
        {
            $this->set_id($event->id)
                ->set_title($event->title)
                ->set_color($event->color)
                ->set_start($event->datetime)
                ->set_end($event->datetime)
                ->set_order_id($event->order_id)
                ->get_event_order_info();
        }
        else
        {
            // Throw an error
            throw new Exception('The variable passed in is not an object or an array.');
        }

        return $this;
    }

    // This may not be needed.
    public function count_events($where = NULL)
    {
        if( $where !== NULL )
        {
            return $this->db->get('events')->num_rows();
        }
        else
        {
            // $where must be an array!
            return $this->db->get_where('events', $where)->num_rows();
        }
    }

    // $where must be an array. If $limit is used, there must be an offset set as $start.
    public function get_events($where = NULL, $limit = NULL, $start = NULL)
    {
        // If limit is not null then check where
        if( $limit !== NULL )
        {
            // If where is not null do limit with where
            if( $where !== NULL )
            {
                $event_array = $this->db->get_where('events', $where, $limit, $start)->result_array();
            }
            // else do limit with no where
            else
            {
                $event_array = $this->db->get_where('events', $limit, $start)->result_array();
            }
        }
        // else if where is not null do where
        elseif( $where !== NULL )    
        {
            $event_array = $this->db->get_where('events', $where)->result_array();
        }
        // else get all of the events
        else
        {
            $event_array = $this->db->get('events')->result_array();
        }
    }

    // Previously called addEvent()
    public function create($id = NULL)
    {
        if( $id !== NULL )
        {
            $this->set_order_id($id);
        }

        $this->get_event_order_info();

        $start_time = $this->order->order_date.' '.$this->order->order_time;

        $data = array(
            'title' => $this->order->order_customer,
            'color' => '#FF1493',
            'start' => $start_time,
            'end'   => date('Y/m/d H:i:s', strtotime($start_time) + 60*60)
        );

        $this->set_event_data($data);

        // insert the object into the database
        if($this->db->insert('events', array(
            'title'      =>  $this->get_title(),
            'color'      =>  $this->get_color(),
            'start'      =>  $this->get_start(),
            'end'        =>  $this->get_end(),
            'order_id'   =>  $this->get_order_id()
            ))) 
        {
            // Return the ID
            return $this->db->insert_id();
        } 
        else 
        {
            // log error
            db_elogger($this->db->error());   

            // return FALSE
            return FALSE;
        }
    }

    // Previously called addCustomEvent()
    public function create_custom()
    {
        // TODO create validation

        $data = array(
            'title'     => $this->input->post('title'),
            'color'     => $this->input->post('color'),
            'start'     => $this->input->post('start'),
            'end'       => $this->input->post('end'),
            'order_id'  => NULL
        );

        $this->set_event_data($data);

        // insert the object into the database
        if($this->db->insert('events', array(
            'title'      =>  $this->get_title(),
            'color'      =>  $this->get_color(),
            'start'      =>  $this->get_start(),
            'end'        =>  $this->get_end(),
            'order_id'   =>  $this->get_order_id()
            ))) 
        {
            // Return the ID
            return $this->db->insert_id();
        } 
        else 
        {
            // log error
            db_elogger($this->db->error());   

            // return FALSE
            return FALSE;
        }
    }

    // Got rid of editEvent as it equats to running $this->set_event_data($data)->update();
    public function update()
    {
        $data = array(
            'title'      =>  $this->get_title(),
            'color'      =>  $this->get_color(),
            'start'      =>  $this->get_start(),
            'end'        =>  $this->get_end(),
            'order_id'   =>  $this->get_order_id(),
            'order'      =>  $this->get_order()
        );

        // Update this product object in the database.
        return $this->db->update('events', $data, ['id' => $this->get_id()]);
    }

    public function delete($id = NULL)
    {
        // Delete the events by using an ID.
        if(is_null($id))
        {
            // Delete the events by using object's id property.
            return $this->db->delete('events', ['id'=>$this->get_id()]);
        } 
        else 
        {
            // Delete the events by using parameter id.
            return $this->db->delete('events', ['id'=>$id]);
        }
    }
}