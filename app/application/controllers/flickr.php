<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flickr extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		session_start();
		$this->load->view('welcome_message');
		print_r($_SESSION);
	}
	
	public function user() {
		session_start();
		if(isset($_SESSION['phpFlickr_auth_token'])) {
		
		
			//attempt to store the token
			echo $_SESSION['phpFlickr_auth_token'];
		
		} 
	
	}
}

/* End of file flickr.php */
/* Location: ./application/controllers/flickr.php */