<?php

class User_model extends CI_Model {

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
    }


	function test() {

	}
	

	function exists($flickrUserID) {

		$select_query = "SELECT id FROM users WHERE flickrUserID = '$flickrUserID' LIMIT 1";

		$token = $this->db->query($select_query);

		if($token->num_rows > 0) {
			$token = $token->result();
			return (int)$token[0]->id;
		} else {
			return FALSE;
		}
	
	}
	

	
	
	function set_opinion($label, $url) {
		

		if($opinionID = $this->exists($url)) {

			return $opinionID;
			
		} elseif($label && $url) {

			$insert_query = "INSERT INTO opinions (label, url) VALUES ('$label', '$url')";
			$this->db->query($insert_query);
						
			return $this->db->insert_id();
			
		} else {
			//massive error
		}

	}
	

}