<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class timezones extends REST_Controller  {
	
	 public function __construct() {
       parent::__construct();
	   $this->load->database();
	   $this->load->model('timezones_model');
	   $this->load->model('Common_functions');
	}	
	
   public function index_get()
   {     
		$input['token'] = $this->head('token');    
        $response = $this->timezones_model->timezonesList($input);       
		$this->response($response, $response['status']);		
   }
}
