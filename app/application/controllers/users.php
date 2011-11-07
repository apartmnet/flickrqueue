<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function add() {
		session_start();
		if(!isset($_SESSION['phpFlickr_auth_token'])) {
		
			$this->load->helper('url');
			$base_url = base_url();
			header("Location: $base_url");
			//attempt to store the token
			//echo $_SESSION['phpFlickr_auth_token'];
		
		} else {
			//print_r($_SESSION);
		}	
		
		
		
		$this->load->model("user_model", "user");
		$this->load->model("flickr_model", "flickr");


		$user = $this->flickr->user_info();

		if($this->user->exists($user['id'])) {
			echo "You are already stored in the system. Don't rush it.";
		} else {
			
			$flickrUserID = $user['id'];
			$token = $_SESSION['phpFlickr_auth_token'];
			if($newUserID = $this->user->set_user($token, $flickrUserID)) {
				echo "Congratulations, you have been entered into the db. Your photos will reveal themselves daily now.";
			}
		}
	
	}

	
}

/* End of file users.php */
/* Location: ./application/controllers/users.php */