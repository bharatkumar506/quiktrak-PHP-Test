<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class user_model extends CI_Model {

		function __construct(){
			parent::__construct();
			$this->load->library('email');
			$this->load->library('session');
			$this->load->model('common_functions');
	   }

	
	
	
	public function usersList($input)
    {
		
		$token = $input['token'];
		$getUserId = $this->common_functions->getUserIdByToken($token,'admin');
		if($getUserId != '0' && $token!=""){

		
		$sql = 'SELECT u.userId as userId,u.name as userName,u.email as userEmail,u.status as status,u.createdDate as createdDate FROM users u order by u.userId desc';
		$query = $this->db->query($sql);
		$data = $query->result();
		$toalCount=$query->num_rows(); 
		if($query->num_rows()>0){
			for($x = '0'; $x <$toalCount; $x++){

				$arr[$x]['userId'] = $data[$x]->userId;
				$arr[$x]['userName'] = $data[$x]->userName;
				$arr[$x]['userEmail'] = $data[$x]->userEmail;
				$arr[$x]['status'] = $data[$x]->status;
				$arr[$x]['createdDate'] = $data[$x]->createdDate;			
				}
			return array('status' => REST_Controller::HTTP_OK,'msg' => 'Success','data' => $arr);
		}else{
			return array('status' => REST_Controller::HTTP_NO_CONTENT,'msg' => 'Empty','data' => '');
		}
	}else{
			return array('status' => REST_Controller::HTTP_BAD_REQUEST,'msg' => 'Token Id not exist');
	}
	}
	public function addUser($input)
    {
		$token = $input['token'];
		$getUserId = $this->common_functions->getUserIdByToken($token,'admin');
		if($getUserId != '0' && $token!=""){
			$input['createdBy']=$getUserId;
		if($input['Name'] && $input['Email']){
			if($this->common_functions->isValidEmail(strtolower($input['Email'])) ) {  

				//if($this->common_functions->isValidMobile($input['userMobileNo']) ) {  
			
			$checkUserEmail = $this->getUserByInput($input);

			$password = $this->common_functions->randomPassword();		
			if(@count($checkUserEmail) == 0){			
			$userDetails = array(		
			"name"=>$input['Name'],
			"email"=>strtolower($input['Email']),
			"password"=>md5($password),			
			"status" => "1",
			"createdDate"=>$this->common_functions->timestampDate(),
			"createdBy"=>$input['createdBy'],
			"lastModifiedDate"=>$this->common_functions->timestampDate(),
			"lastModifiedBy"=>$input['createdBy']
			);			
			$this->db->insert('users',$userDetails);			
			$insert_id = $this->db->insert_id();
			return array('status' => REST_Controller::HTTP_OK,'msg' => 'User added Succesffuly');				
		}else{
			return array('status' => REST_Controller::HTTP_BAD_REQUEST, 'msg' => 'Email already exist');	
		}
	}else{
			return array('status' => REST_Controller::HTTP_BAD_REQUEST,'msg' => 'Please enter valid Email');
	}				
		}else{
			return array('status' => REST_Controller::HTTP_BAD_REQUEST,'msg' => 'Bad Request');
		}
	}else{
			return array('status' => REST_Controller::HTTP_BAD_REQUEST,'msg' => 'Token Id not exist');
	}
	}
	public function updateUser($input)
    {
		$token = $input['token'];
		$getUserId = $this->common_functions->getUserIdByToken($token,'admin');
		if($getUserId != '0' && $token!=""){
			$input['lastModifiedBy']=$getUserId;
		if($input['Name']){
			
			$userId=$input['userId'];		
			$checkUserEmail = $this->getUserById($userId,$input);
	
			if(@count($checkUserEmail)>0){				
				$user = array(		
				"name"=>$input['Name'],
				"lastModifiedDate"=>$this->common_functions->timestampDate(),
				"lastModifiedBy"=>$input['lastModifiedBy']
				);
				$this->db->update('users', $user, array('userId'=>$userId));

				return array('status' => REST_Controller::HTTP_OK,'msg' => 'Success');
			}else{
				return array('status' => REST_Controller::HTTP_NOT_FOUND,'msg' => 'User id not found');
			}
		}else{
			return array('status' => REST_Controller::HTTP_BAD_REQUEST,'msg' => 'Bad Request');
		}
	}else{
			return array('status' => REST_Controller::HTTP_BAD_REQUEST,'msg' => 'Token Id not exist');
	}
	}
	

	public function getUserById($userId,$input)
    {	
		$token = $input['token'];
		$getUserId = $this->common_functions->getUserIdByToken($token,'admin');
		if($getUserId != '0' && $token!=""){

		 $sql = 'SELECT  u.userId as userId,u.name as userName,u.email as userEmail,u.status as status,u.createdDate as createdDate FROM users u where u.userId = \''.$userId.'\' group by u.userId';
		 $query = $this->db->query($sql);
		 $data = $query->result();
		 $toalCount=$query->num_rows();
		if($query->num_rows()>0){
			for($x = '0'; $x <$toalCount; $x++){
				$arr[$x]['userId'] = $data[$x]->userId;
				$arr[$x]['userName'] = $data[$x]->userName;
				$arr[$x]['userEmail'] = $data[$x]->userEmail;
				$arr[$x]['status'] = $data[$x]->status;
				$arr[$x]['createdDate'] =$data[$x]->createdDate;
				
				}
			return array('status' => REST_Controller::HTTP_OK,'msg' => 'Success','data' => $arr);
		}else{
			return array('status' => REST_Controller::HTTP_NOT_FOUND,'msg' => 'User id not found','data' => '');
		}
	}else{
			return array('status' => REST_Controller::HTTP_BAD_REQUEST,'msg' => 'Token Id not exist');
	}
	}
	public function updateStatus($input)
    {
		$token = $input['token'];
		$getUserId = $this->common_functions->getUserIdByToken($token,'admin');
		if($getUserId != '0' && $token!=""){
			$input['lastModifiedBy'] = $getUserId;
		if(($input['userId']>'0') && ($input['status']=='0' || $input['status']=='1')){
			$userId=$input['userId'];
			$this->db->select('u.userId as userId,u.name as userName,u.email as userEmail,u.status as status,u.createdDate as createdDate,u.createdBy as createdBy,u.lastModifiedDate as lastModifiedDate,u.lastModifiedBy as lastModifiedBy');
		$this->db->from('users u');
		$this->db->where('u.userId',$userId);
		$query = $this->db->get();
			if($query->num_rows()>0){	
				$userstatus = array(		
				"status"=>$input['status'],
				"lastModifiedDate"=>$this->common_functions->timestampDate(),
				"lastModifiedBy"=>$input['lastModifiedBy']
				);
				$this->db->update('users', $userstatus, array('userId'=>$userId));
				return array('status' => REST_Controller::HTTP_OK,'msg' => 'Success');
			}else{
				return array('status' => REST_Controller::HTTP_NOT_FOUND,'msg' => 'User id not found');
			}
		}else{
			return array('status' => REST_Controller::HTTP_BAD_REQUEST,'msg' => 'Bad Request');
		}
	}else{
			return array('status' => REST_Controller::HTTP_BAD_REQUEST,'msg' => 'Token Id not exist');
	}
	}
	public function getUserByInput($inputs = array()){
		$this->db->select('userId,name,email,status');
			$this->db->from('users');
			if(isset($inputs['Email'])){					
				$this->db->where('email',strtolower($inputs['Email']));
			}
			$query = $this->db->get();
			return $query->row_array();		
	}
}