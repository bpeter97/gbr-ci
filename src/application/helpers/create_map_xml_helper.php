<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('create_map_xml'))
{
    function create_map_xml()
    {
        // Get instance of CI.
        $CI =& get_instance();
        
        // Set file location
        $map_file = $_SERVER['DOCUMENT_ROOT'] . 'assets/xml/genmapxml.php';
        
        // Create the file.
        $handle = fopen($map_file, 'w') or die('Cannot open file: ' . $map_file);

        // Write opener tags and header content type.
        fwrite($handle, '<?php');
        fwrite($handle, ' header("Content-type: text/xml") ');
        fwrite($handle, '?>');
        fwrite($handle, '<markers>');

        // Get the containers
        $coninfo = $CI->db->select('*')->from('containers')->where('address !=', '')->get()->result_array();

        // Iterate containers and create markers
        foreach($coninfo as $con)
        {
            fwrite($handle, "\n");
            fwrite($handle, '<marker name="'. parseToXML($con['number']) .'" address="'. parseToXML($con['address']) .'" lat="'. $con['latitude'] .'" lng="'. $con['longitude'] .'" type="'. $con['type'] .'"/>');
        }
        fwrite($handle, '</markers>');

        fclose($handle);

    }   

    // Parse symbols in text for XML formatting.
    function parseToXML($htmlStr) {
        $xmlStr=str_replace('<','&lt;',$htmlStr);
        $xmlStr=str_replace('>','&gt;',$xmlStr);
        $xmlStr=str_replace('"','&quot;',$xmlStr);
        $xmlStr=str_replace("'",'&#39;',$xmlStr);
        $xmlStr=str_replace("&",'&amp;',$xmlStr);
        return $xmlStr;
    }
}