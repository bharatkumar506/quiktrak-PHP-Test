<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class user extends REST_Controller  {
	
	 public function __construct() {
       parent::__construct();
	   $this->load->database();
	   $this->load->model('user_model');
	   $this->load->model('Common_functions');
	}	
	
   public function index_get()
   {     
		$input['token'] = $this->head('token');    
        $response = $this->user_model->usersList($input);       
		$this->response($response, $response['status']);		
   }
   public function index_post()
    {
        $input = $this->post();
		$input['token'] = $this->head('token');
		$input=$this->common_functions->sanatize_post($input);
		$data = $this->user_model->addUser($input);
		$this->response($data, $data['status']);
	}
	public function getUserById_get($user_id)
	{
		$input['token'] = $this->head('token');    
		$data = $this->user_model->getUserById($user_id,$input);
		$this->response($data, $data['status']);
	}
	public function index_put()
    {
        $input = $this->put();
		$input['token'] = $this->head('token');
		$input=$this->common_functions->sanatize_post($input);
		$data = $this->user_model->updateUser($input);
		$this->response($data, $data['status']);
	}
	public function updateStatus_post()
    {
        $input = $this->post();
		$input['token'] = $this->head('token');
		$input=$this->common_functions->sanatize_post($input);
		$data = $this->user_model->updateStatus($input);
		$this->response($data, $data['status']);
	}  
}
