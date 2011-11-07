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

	function exists($flickrUserID) {

		$select_query = "SELECT flickrUserID FROM users WHERE flickrUserID = '$flickrUserID' LIMIT 1";

		$results = $this->db->query($select_query);

		if($results->num_rows > 0) {
			$result = $results->result();
			return (int)$result[0]->flickrUserID;
		} else {
			return FALSE;
		}
	
	}

	function set_user($token, $flickrUserID) {
		

		if($flickrUserID == $this->exists($flickrUserID)) {

			return $flickrUserID;
			
		} elseif($token && $flickrUserID) {

			$insert_query = "INSERT INTO users (token, flickrUserID) VALUES ('$token', '$flickrUserID')";
			$this->db->query($insert_query);
						
			return $this->db->insert_id();
			
		} else {
			//massive error
		}

	}
	

}