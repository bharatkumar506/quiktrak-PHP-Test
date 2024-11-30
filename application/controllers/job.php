<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class job extends REST_Controller  {
	
	 public function __construct() {
       parent::__construct();
	   $this->load->database();
	   $this->load->model('job_model');
	   $this->load->model('Common_functions');
	}	
	
   public function index_get()
   {     
		$input['token'] = $this->head('token');    
        $response = $this->job_model->jobsList($input);       
		$this->response($response, $response['status']);		
   }
   public function index_post()
    {
        $input = $this->post();
		$input['token'] = $this->head('token');
		$input=$this->common_functions->sanatize_post($input);
		$data = $this->job_model->addJob($input);
		$this->response($data, $data['status']);
	}
	public function getJobById_get($job_id)
	{
		$input['token'] = $this->head('token'); 		
		$data = $this->job_model->getJobById($job_id,$input);
		$this->response($data, $data['status']);
	}
	public function index_put()
    {
        $input = $this->put();
		$input['token'] = $this->head('token');
		$input=$this->common_functions->sanatize_post($input);
		$data = $this->job_model->updateJob($input);
		$this->response($data, $data['status']);
	}
	public function updateStatus_post()
    {
        $input = $this->post();
		$input['token'] = $this->head('token');
		$input=$this->common_functions->sanatize_post($input);
		$data = $this->job_model->updateStatus($input);
		$this->response($data, $data['status']);
	} 
	public function getJobTimezoneToYourTime_get($job_id,$yourTimezone_id)
	{
		$input['token'] = $this->head('token'); 		
		$data = $this->job_model->getJobTimezoneToYourTime($job_id,$yourTimezone_id,$input);
		$this->response($data, $data['status']);
	}
	public function assignjob_post()
    {
        $input = $this->post();
		$input['token'] = $this->head('token');
		$input=$this->common_functions->sanatize_post($input);
		$data = $this->job_model->assignjob($input);
		$this->response($data, $data['status']);
	} 
	public function submitinspection_post()
    {
        $input = $this->post();
		$input['token'] = $this->head('token');
		$input=$this->common_functions->sanatize_post($input);
		$data = $this->job_model->submitinspection($input);
		$this->response($data, $data['status']);
	} 
}