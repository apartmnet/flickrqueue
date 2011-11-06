<?php

class Opinion_model extends CI_Model {

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

	

	/**
		Description:
		function exists(string $url)
		Test to see if a given url is in the database.
		Returns TRUE if the url is found, FALSE if not.
		
		Example Usage:
		$result = exists('http://en.wikipedia.org/wiki/Cat');
	**/
	function exists($url) {

		$select_query = "SELECT opinionID FROM opinions WHERE url = '$url' LIMIT 1";

		$opinions = $this->db->query($select_query);

		if($opinions->num_rows > 0) {
			$opinion = $opinions->result();
			return (int)$opinion[0]->opinionID;
		} else {
			return FALSE;
		}
	
	}
	
	function get_recent_opinions() {
		$select_query = "select opinions.*, votes.vote, users.screen_name, users.userID from users, opinions, votes where opinions.opinionID = votes.opinionID and votes.userID = users.userID ORDER BY votes.voteTime DESC LIMIT 20";

		$opinions = $this->db->query($select_query);

		if($opinions->result()) {
					
			//this should be done in sql, but 'group by' isn't liking me today.
			//removes duplicate items, leaving only the first instance of each.
			$filtered_opinions = array();
			$filtered_keys = array();
			foreach($opinions->result() as $opinion) {
				
				 if(!in_array($opinion->opinionID, $filtered_keys)) {
					$filtered_opinions[] = $opinion;
					$filtered_keys[] = $opinion->opinionID;
				 }
				
			}
			
			$this->opinion_count = count($filtered_opinions);
		
			return $filtered_opinions;
			
		} else {
			return FALSE;
		}
	}
	
	/**
		Description:
		Get either 'up' or 'down' as a response to a specific user / opinion pairing.
	**/
	function get_users_opinion($screen_name, $opinionID) {
		$select_query = "select votes.vote from users, votes where votes.opinionID = $opinionID and votes.userID = users.userID and users.screen_name = '$screen_name' LIMIT 1";
		$opinions = $this->db->query($select_query);
		
		if($opinion = $opinions->result()) {
			$vote = $opinion[0]->vote;
			return $vote;
			
		} else {
			return FALSE;
		}
	}
	
	/**
		Description:
		Get all opinions for a user
	**/	
	function get_user_opinions($screen_name) {
		$select_query = "select opinions.*, votes.vote from users, opinions, votes where opinions.opinionID = votes.opinionID and votes.userID = users.userID and users.screen_name = '$screen_name' ORDER BY votes.voteTime DESC";

		$opinions = $this->db->query($select_query);

		if($opinions->result()) {
		
			//this should be done in sql, but 'group by' isn't liking me today.
			//removes duplicate items, leaving only the first instance of each.
			$filtered_opinions = array();
			$filtered_keys = array();
			foreach($opinions->result() as $opinion) {
				
				 if(!in_array($opinion->opinionID, $filtered_keys)) {
					$filtered_opinions[] = $opinion;
					$filtered_keys[] = $opinion->opinionID;
				 }
				
			}
			
			$this->opinion_count = count($filtered_opinions);
			return $filtered_opinions;
			
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
	
	function compare_opinions($primary, $secondary) {
		//requires that both $primary and $secondary 
		//are returned results from get_user_opinions()

		if(($primary != NULL) && ($secondary != NULL)) {

			$primary_index = array();
			$secondary_index = array();
				
			foreach($primary as $item) {
				$primary_index[$item->opinionID] = $item->vote;
			}
	
			foreach($secondary as $item) {
				$secondary_index[$item->opinionID] = $item->vote;
			}
			
			//reversed, as we want the comparative user to be the primary index
			$results = array_intersect_key($secondary_index, $primary_index);
			
			return $results;
		} else {
			return FALSE;
		}
		
	}
	/*
    function get_last_ten_entries()
    {
        $query = $this->db->get('entries', 10);
        return $query->result();
    }

    function insert_entry()
    {
        $this->title   = $_POST['title']; // please read the below note
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->insert('entries', $this);
    }

    function update_entry()
    {
        $this->title   = $_POST['title'];
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->update('entries', $this, array('id' => $_POST['id']));
    }*/

}