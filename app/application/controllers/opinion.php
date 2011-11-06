<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Opinion extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 */
	 
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->model('opinion_model', 'opinion');
    }
	 
	public function index()
	{
	
		echo "opinion";
		$this->load->model('opinion_model', 'opinion');
		
		if($asdf = $this->opinion->exists("http://en.wikipedia.org/wiki/Cat")) {
			echo "found";
		} else {
			echo "not found";
		}
		
	}
	
	public function api($method = FALSE) {
		
		
		try {
			
			if(($params = $this->input->get()) && (isset($params['api_key'])) && ($key = $params['api_key'])) {
				unset($params['api_key']);							
			} else {
				throw new Exception("No API Key Set");
			}
			
			if(!$this->valid_api_key($key)) {
				throw new Exception("invalid api key");
			}
			
			if($this->method_available($method)) {
				
				if(is_array($params)) {
				
					$params = array_values($params);
				
					if(count($params) == '1') {
						$this->output_data($this->opinion->$method($params[0]));
					} elseif (count($params) == '2') {
						$this->output_data($this->opinion->$method($params[0],$params[1]));
					} elseif (count($params) == '3') {
						$this->output_data($this->opinion->$method($params[0],$params[1],$params[2]));
					}
				} 

			} else {
				throw new Exception("invalid method");
			}
			
		} catch (Exception $e) {
			
			$errorObj = new stdclass;
			$errorObj->error = "API Method Error";
			$errorObj->message = $e->getMessage();
			

			if(strstr(strtolower($errorObj->message), "invalid method")) {

				$errorObj->valid_methods = $this->public_methods();

			}
			
			$this->output_data($errorObj);
		
		}
			
	}
	
	protected function output_data($data) {
		
		header("Content-type: application/json");
		echo json_encode($data);
		
	}
	
	protected function method_available($method) {
	
	
		if(method_exists($this->opinion, $method) && in_array($method, $this->public_methods())) {
			return TRUE;
		} else {
			return FALSE;
			//return implode(",\r\n", $public_methods);
		}
	
	}
	
	protected function public_methods() {
		return array('exists','get_recent_opinions','get_users_opinion','get_user_opinions','set_opinion');
	}
	
	protected function valid_api_key($key) {
		
		if($key) {
			return TRUE;
		} else {
			return FALSE;
		}
		
	}
	
	public function test() {
		$this->load->library('unit_test');
		$this->load->helper('file');
		$this->load->model('opinion_model', 'opinion');

		
		$config = read_file('tests/opinion.json');
		$tests = json_decode($config);
		//$this->unit->set_test_items(array('test_name','test_datatype','res_datatype','result','file'));


		foreach($tests as $test) {

			$function_to_run = $test->function_to_run->name;
			$params = isset($test->function_to_run->params) ? $test->function_to_run->params : "";
			
			if(method_exists($this->opinion, $function_to_run)) {
				if(is_array($params)) {
					if(count($params) == '1') {
						$this->unit->run($this->opinion->$function_to_run($params[0]), $test->expectation, $test->test, "function referenced: $function_to_run()");				
					} elseif (count($params) == '2') {
						$this->unit->run($this->opinion->$function_to_run($params[0],$params[1]), $test->expectation, $test->test);								
					} elseif (count($params) == '3') {
						$this->unit->run($this->opinion->$function_to_run($params[0],$params[1],$params[2]), $test->expectation, $test->test);								
					}
				} else {
					$this->unit->run($this->opinion->$function_to_run($params), $test->expectation, $test->test);
				}
			} else {
				//function does not exist
				//echo "$function_to_run is not a valid function";
				$this->unit->run("", $test->expectation, $test->test, "Invalid function referenced: $function_to_run");				
			}
		}
		echo $this->unit->report();		
		//echo $this->db->last_query();
		
	}
	
}

/* End of file opinion.php */
/* Location: ./application/controllers/opinion.php */