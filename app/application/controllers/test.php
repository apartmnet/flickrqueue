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
	
	public function evaluation() {
	
		$this->load->library('unit_test');
	
		$test = 1 + 1;
		
		$expected_result = 2;
		
		$test_name = 'Adds one plus one';
		
		$this->unit->run($test, $expected_result, $test_name);
	
		echo $this->unit->report();
	
	}

	public function array_test() {
	
		$this->load->library('unit_test');
	
		$array = array(1,3,4);
	
		$test = is_array($array);
		
		$expected_result = TRUE;
		
		$test_name = 'Test for something to be an array';
		
		$this->unit->run($test, $expected_result, $test_name);
	
		echo $this->unit->report();
	
	}
	
	public function database_test() {
		$this->load->library('unit_test');
		$this->load->database();
		
		$tables = $this->db->list_tables();
		$tables_expected_results = array('history','log','opinions','users','votes');
		$expected_result = TRUE;

		foreach($tables_expected_results as $result) {

			$test_name = "Testing if $result table exists";
			$test = in_array($result, $tables) ? TRUE : FALSE;
			$this->unit->run($test, $expected_result, $test_name);
		
		}
		
		echo $this->unit->report();
	
	}
}

/* End of file test.php */
/* Location: ./application/controllers/test.php */