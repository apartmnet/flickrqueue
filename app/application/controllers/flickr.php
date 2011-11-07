<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flickr extends CI_Controller {

	public function index()
	{
		session_start();
		$this->load->view('welcome_message');
		print_r($_SESSION);
	}
	
	public function cron() {
		
		$this->load->model("user_model", "user");
		$this->load->model("flickr_model", "flickr");
		
		$users = $this->user->get_all_users();
		
		//print_r($users);
		//Array ( [0] => stdClass Object ( [token] => 72157628069256914-5d47b8b9a14261be [flickrUserID] => 59663818@N00 ) ) 
		
		foreach($users as $user) {
			
			$token = $user->token;
			$flickrUserID = $user->flickrUserID;
			
			
			$photo = $this->flickr->get_private_queued_photo($token, $flickrUserID);
			
			//print_r($photos);	
			//Array ( [id] => 6320355488 [owner] => 59663818@N00 [secret] => 77db86885a [server] => 6098 [farm] => 7 [title] => 1 [ispublic] => 0 [isfriend] => 0 [isfamily] => 0 )
			
			//update the privacy on that photo!
			if($this->phpflickr->photos_setPerms($photo['id'],1,$photo['isfriend'],$photo['isfamily'], 3,3)) {
				echo "Photo " . $photo['id'] . " updated for user $flickrUserID";
			}	
		}	
	}
}

/* End of file flickr.php */
/* Location: ./application/controllers/flickr.php */