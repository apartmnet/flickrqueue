<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flickr extends CI_Controller {

	public function index()
	{
		session_start();
		$this->load->view('welcome_message');
		print_r($_SESSION);
	}
	
	public function cron() {
		
		$condition = TRUE;
		
		/*
		$headers = getallheaders();
		
		if($headers['User-Agent'] == "flickrqueue-cron") {
			$condition = TRUE;
		}*/
		
		if($condition == TRUE) {
			$this->load->model("user_model", "user");
			$this->load->model("flickr_model", "flickr");
			
			$users = $this->user->get_all_users();
	
			if(count($users) > 0) {
	
				foreach($users as $user) {
					
					$token = $user->token;
					$flickrUserID = $user->flickrUserID;
									
					$photo = $this->flickr->get_private_queued_photo($token, $flickrUserID);
	
					//update the privacy on that photo!
	
					if($this->flickr->publicize($photo)) {
						echo "Photo " . $photo['id'] . " updated for user $flickrUserID";				
					} else {
						echo "Failed to update photo" . $photo['id'] . "for user $flickrUserID";
					}
				}	
			} else {
				echo "No users";
			}
		} else {
			echo "Access forbidden.";
		}
	}
}

/* End of file flickr.php */
/* Location: ./application/controllers/flickr.php */