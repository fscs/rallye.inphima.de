<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jd_lib {

	function Jd_lib() 
	{
		$this->CI =& get_instance();
	}
	
	function _flash_message($message, $class, $redirect_location = FALSE)
	{
		$this->CI->session->set_flashdata('flash_message',$message);
		$this->CI->session->set_flashdata('flash_message_class',$class);
		if ($redirect_location !== FALSE) {
			redirect($redirect_location);
		}
	}
}
