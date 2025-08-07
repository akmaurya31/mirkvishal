<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */


if ( ! function_exists('get_phrase'))
{
	function get_phrase($phrase = '') {
		$CI	=&	get_instance();
		$CI->load->database();
		$current_language	=	$CI->db->get_where('settings' , array('type' => 'language'))->row()->description;
		
		if ( $current_language	==	'') {
			$current_language	=	'english';
			$CI->session->set_userdata('current_language' , $current_language);
		}


		/** insert blank phrases initially and populating the language db ***/
		$check_phrase	=	$CI->db->get_where('language' , array('phrase' => $phrase))->row()->phrase;
		if ( $check_phrase	!=		$phrase)
			$CI->db->insert('language' , array('phrase' => $phrase));
			
		
		// query for finding the phrase from `language` table
		$query	=	$CI->db->get_where('language' , array('phrase' => $phrase));
		$row   	=	$query->row();	
		
		// return the current sessioned language field of according phrase, else return uppercase spaced word
		if (isset($row->$current_language) && $row->$current_language !="")
			return $row->$current_language;
		else 
			return ucwords(str_replace('_',' ',$phrase));
	}
}

function getClassName($id) {
	// die("Sdf");
	$CI	=&	get_instance();
	$CI->load->database();
    $CI->db->where('class_id', $id);
    $query = $CI->db->get('class');
    if ($query->num_rows() > 0) {
        $row = $query->row();
        return $row->name;  // assuming 'name' is the column holding class name
    } else {
        return null;
    }
}

 function getFeeByClassid($class_id) {
    $CI =& get_instance();
    $CI->load->database();

    // Use correct foreign key (probably class_id or fee_class_id)
    $CI->db->where('fee_name', $class_id); 
    $query = $CI->db->get('fee');

    $fees = [];

    if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
            $fees[] = array(
                'id'        => $row->fee_id,
                'monthly'   => $row->monthly,
                'admission' => $row->admission,
                'examination' => $row->examination,
            );
        }
        return $fees; // return if data exists
    } else {
        return null; // return null if no records
    }
}



function getStudentNames($class_id) {
    $CI =& get_instance();
    $CI->load->database();

    $CI->db->where('class_id', $class_id);
    $query = $CI->db->get('student');

    $students = [];

    if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
            $students[] = array(
                'id'   => $row->student_id,
                'name' => $row->name . ' - Roll ' . $row->roll
            );
        }
    }

    header('Content-Type: application/json');
    echo json_encode($students);
    exit;
}

// ------------------------------------------------------------------------
/* End of file language_helper.php */
/* Location: ./system/helpers/language_helper.php */