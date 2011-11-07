<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}
	/*
	public function database_test() {
		$this->load->library('unit_test');
		$this->load->database();
		
		$tables = $this->db->list_tables();
		$tables_expected_results = array('users');
		$expected_result = TRUE;

		foreach($tables_expected_results as $result) {

			$test_name = "Testing if $result table exists";
			$test = in_array($result, $tables) ? TRUE : FALSE;
			$this->unit->run($test, $expected_result, $test_name);
		
		}
		
		echo $this->unit->report();
	
	}
	
	public function debug() {
		echo "<pre>";
		print_r($_SERVER);
		echo "</pre>";
	}
	*/
}

/* End of file test.php */
/* Location: ./application/controllers/test.php */