<?php

class Flickr_model extends CI_Model {

	/* example variables
    var $title   = '';
    var $content = '';
    var $date    = '';
	*/
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
       	$this->load->database();

		$params = array();
		$params['api_key'] 	= $_SERVER['FLICKR_API_KEY'];
		$params['secret']	= $_SERVER['FLICKR_SECRET'];
		$params['token'] = isset($_SESSION['phpFlickr_auth_token']) ? $_SESSION['phpFlickr_auth_token'] : "";

		$this->load->library('phpflickr', $params);
    }
    
    function user_info() {
    	return $this->phpflickr->test_login();		
    }


}