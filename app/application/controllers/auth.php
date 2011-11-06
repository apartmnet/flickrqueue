<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

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
	
	/*
		session_start();
		$params = array();
		if($_SERVER['DEPLOYED_ENVIRONMENT'] == "local") {
			$params['api_key']                 = "955fca735e5786ff004677fd6a912b70";
			$params['secret']              = "27dc9c6fa3937a49";	
			//$params['api_sig']				   = "e3c29d7ec0b8b525487759cd75db0a53";
		} elseif($_SERVER['DEPLOYED_ENVIRONMENT'] == "pagoda") {
			$params['api_key']                 = "2347f081c76968c43df0183cce464c3e";
			$params['secret']              = "17098355f61296ac";		
		}	
	

		$this->load->library('phpflickr', $params);


		 
		$default_redirect        = "/app/index.php/auth";
		$permissions             = "write";
		//$path_to_phpFlickr_class = "./";
	
		ob_start();
		//require_once($path_to_phpFlickr_class . "phpFlickr.php");
		if(isset($_SESSION['phpFlickr_auth_token'])) {
			unset($_SESSION['phpFlickr_auth_token']);
		}
		 
		if ( isset($_SESSION['phpFlickr_auth_redirect']) && !empty($_SESSION['phpFlickr_auth_redirect']) ) {
			$redirect = $_SESSION['phpFlickr_auth_redirect'];
			unset($_SESSION['phpFlickr_auth_redirect']);
		}
		
		//$f = new phpFlickr($api_key, $api_secret);
	 
		if (empty($_GET['frob'])) {
			$this->phpflickr->auth($permissions, false);
		} else {
			$this->phpflickr->auth_getToken($_GET['frob']);
		}
		
		
		if (empty($redirect)) {
			header("Location: " . $default_redirect);
		} else {
		
			header("Location: " . $redirect);
		}
		*/
	}
	
	public function test() {

		session_start();

		$params = array();
		$params['api_key'] 	= $_SERVER['FLICKR_API_KEY'];
		$params['secret']	= $_SERVER['FLICKR_SECRET'];
		$params['token'] = isset($_SESSION['phpFlickr_auth_token']) ? $_SESSION['phpFlickr_auth_token'] : "";

		$this->load->library('phpflickr', $params);
		
		
		
		print_r($this->phpflickr->test_login());
		
	}

}

/* End of file flickr.php */
/* Location: ./application/controllers/flickr.php */