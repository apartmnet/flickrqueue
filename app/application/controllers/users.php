<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function add() {
		session_start();
		if(!isset($_SESSION['phpFlickr_auth_token'])) {
			//kick the user out if they're not logged in
			$this->load->helper('url');
			$base_url = base_url();
			header("Location: /auth");
		} else {
		
			//user has come from flickr
			$this->load->model("user_model", "user");
			$this->load->model("flickr_model", "flickr");
	
			$user = $this->flickr->user_info();
			$username = $user['username'];
			$this->load->view("header");
			
			$flickrUserID = $user['id'];

			if($this->user->exists($user['id'])) {
				
				$token = $_SESSION['phpFlickr_auth_token'];

				$data = array();
				$data['message'] = "<p>$username, you're all set. Wait until midnight, then your photos will automatically start updating.</p>";
				$data['message'] .= "<p>Anti-climactic, right? That's how background services work. Patience will reward you, if you've
				tagged your photos correctly with 'flickrqueue', and set them to private. Each day, the oldest photo in the flickrqueue will be set to public.</p>";

			} else {
				
				$token = $_SESSION['phpFlickr_auth_token'];
				if($newUserID = $this->user->set_user($token, $flickrUserID)) {
					$flickrUserID = $newUserID;

					$data['message'] = "<p>$username, congratulations! You have been entered into the db. Your photos will reveal themselves daily now.</p>";
					$data['message'] .= "<p>Anti-climactic, right? That's how background services work. Patience will reward you, if you've
					tagged your photos correctly with 'flickrqueue', and set them to private. Each day, the oldest photo in the flickrqueue will be set to public.</p>";
					
				}
				
			}
			
			
			$this->load->model('flickr_model', 'flickr');
			if($photos = $this->flickr->get_private_queued_photos($token, $flickrUserID)) {
				$data['photolist'] = $photos;			
			}


			
			$this->load->view("body", $data);			
			$this->load->view("footer");
			
		}
	
	}
	
	public function logout() {
		session_start();
		unset($_SESSION['phpFlickr_auth_token']);
		session_destroy();
		
		$this->load->helper('url');
		header("Location: /");
	}

}

/* End of file users.php */
/* Location: ./application/controllers/users.php */