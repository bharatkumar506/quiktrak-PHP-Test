<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class templates extends REST_Controller  {
	
	 public function __construct() {
       parent::__construct();
	   $this->load->database();
	   $this->load->model('templates_model');
	   $this->load->model('Common_functions');
	}	
	
   public function index_get()
   {     
		$input['token'] = $this->head('token');    
        $response = $this->templates_model->templatesList($input);       
		$this->response($response, $response['status']);		
   }
}
