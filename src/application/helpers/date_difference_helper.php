<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('date_difference'))
{
    function date_difference($start, $end, $format = '%a')
    {
        $datetime1 = date_create($start);
        $datetime2 = date_create($end);
    
        $interval = date_diff($datetime1, $datetime2);
        $formatted = $interval->format($format);
        $num_months = $interval->m;

        $result = [$formatted, $num_months];

        return $result;
    }   
}