<?php

class Flickr_model extends CI_Model {

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

	//get only the specifically next photo. Optimized for fast returns.
	function get_private_queued_photo($token, $flickrUserID) {

		//token has to be set on each request, as each user's private photos only come back with their specific auth key
		$this->phpflickr->setToken($token);

		$result = $this->phpflickr->photos_search(array("user_id"=>$flickrUserID, 
														"privacy_filter"=>5, 
														"tags"=>"flickrqueue", 
														"per_page"=>1, 
														"sort"=>"date-posted-asc"));
		if($result['total'] > 0) {
			//throw away the metadata, just return the photos		
			$photos = $result['photo'];
			return $photos[0];
		} else {
			return false;
		}
	}
	
	//get the next 10 photos in a queue
	function get_private_queued_photos($token, $flickrUserID, $limit = '10') {
	
		//token has to be set on each request, as each user's private photos only come back with their specific auth key
		$this->phpflickr->setToken($token);

		$result = $this->phpflickr->photos_search(array("user_id"=>$flickrUserID, 
														"privacy_filter"=>5, 
														"tags"=>"flickrqueue", 
														"per_page"=>$limit, 
														"sort"=>"date-posted-asc"));
		if($result['total'] > 0) {
			//throw away the metadata, just return the photos		
			$photos = $result['photo'];
			
			//get thumbnails
			foreach($photos as $key => $photo) {
				$thumbs = $this->phpflickr->photos_getSizes($photo['id']);
				$photos[$key]['thumb'] = $thumbs[0]['source'];
			}

			return $photos;
		} else {
			return false;
		}
	}
	
	
	function publicize($photo) {
	
		if($this->phpflickr->photos_setPerms($photo['id'],1,$photo['isfriend'],$photo['isfamily'], 3,3)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
		
}