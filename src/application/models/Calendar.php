<?php

if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

class Calendar extends CI_Model
{

    private $events = array();

    public function get_events()
    {
        $event_array = $this->db->get('events')->result_array();

        foreach($event_array as $event)
        {
            array_push($this->events, new Event($event['id']));
        }

        return $this->events;
    }

    // TODO: This should also be only ran through the event model.
    public function delete_event($id)
    {
        $event = new Event();
        return $event->delete($id);   
    }

    // TODO: See if all of these parameters are necessary.
    // TODO: This function should only be ran through the event model, so this needs to be changed.
    public function edit_event($id, $color = NULL, $title = NULL, $start = NULL, $end = NULL, $order_id = NULL)
    {
        $event = new Event($id);

        $data = array(
            'id'        => $id,
            'title'     => $title,
            'color'     => $color,
            'start'     => $start,
            'end'       => $end,
            'order_id'  => $order_id
        );

        return $event->set_event_data($data)->update();
    }

}

