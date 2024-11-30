<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class job_model extends CI_Model {

		function __construct(){
			parent::__construct();
			$this->load->library('email');
			$this->load->library('session');
			$this->load->model('common_functions');
	   }

	
	
	
	public function jobsList($input)
    {
		
		$token = $input['token'];
		$getUserId = $this->common_functions->getUserIdByToken($token,'admin');
		if($getUserId != '0' && $token!=""){
		$sql = 'SELECT j.jobId as jobId,j.title as title,(CASE WHEN j.type=1 THEN "Collateral" ELSE (CASE WHEN j.type=2 THEN "Equipment" ELSE "Property" END) END) as type,j.address as address,j.scheduledDateTime as scheduledDateTime,t.timeZone as timeZone,j.assignedTo as assignedTo,u.name as assignedToName,(CASE WHEN j.workstatus=1 THEN "Not Started" ELSE (CASE WHEN j.workstatus=2 THEN "Inprogess" ELSE "Completed" END) END) as workStatus,j.status as status,j.createdDate as createdDate FROM jobs j left JOIN timeZones t ON t.timeZoneId = j.timeZoneId left JOIN users u ON u.userId = j.assignedTo order by j.jobId desc';
		$query = $this->db->query($sql);
		$data = $query->result();
		$toalCount=$query->num_rows(); 
		if($query->num_rows()>0){
			for($x = '0'; $x <$toalCount; $x++){
				$arr[$x]['jobId'] = $data[$x]->jobId;
				$arr[$x]['title'] = $data[$x]->title;
				$arr[$x]['type'] = $data[$x]->type;
				$arr[$x]['address'] = $data[$x]->address;
				$arr[$x]['scheduledDateTime'] = $data[$x]->scheduledDateTime;
				$arr[$x]['timeZone'] = $data[$x]->timeZone;
				$arr[$x]['assignedTo'] = $data[$x]->assignedTo;
				$arr[$x]['assignedToName'] = $data[$x]->assignedToName;
				$arr[$x]['workStatus'] = $data[$x]->workStatus;
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
	public function addJob($input)
    {
		$token = $input['token'];
		$getUserId = $this->common_functions->getUserIdByToken($token,'admin');
		if($getUserId != '0' && $token!=""){
			$input['createdBy']=$getUserId;
		if($input['title']!="" && ($input['type']==1 || $input['type']==2 || $input['type']==3) && $input['address']!="" && $input['timezone']>0 && $input['scheduledDateTime']!=""){	
			$jobDetails = array(		
			"title"=>$input['title'],
			"type"=>$input['type'],
			"address"=>$input['address'],
			"scheduledDateTime"=>$input['scheduledDateTime'],
			"timezoneId"=>$input['timezone'],			
			"status" => "1",
			"createdDate"=>$this->common_functions->timestampDate(),
			"createdBy"=>$input['createdBy'],
			"lastModifiedDate"=>$this->common_functions->timestampDate(),
			"lastModifiedBy"=>$input['createdBy']
			);			
			$this->db->insert('jobs',$jobDetails);			
			$insert_id = $this->db->insert_id();
			return array('status' => REST_Controller::HTTP_OK,'msg' => 'Job added Succesffuly');				
	
		}else{
			return array('status' => REST_Controller::HTTP_BAD_REQUEST,'msg' => 'Bad Request');
		}
	}else{
			return array('status' => REST_Controller::HTTP_BAD_REQUEST,'msg' => 'Token Id not exist');
	}
	}
	public function updateJob($input)
    {
		$token = $input['token'];
		$getUserId = $this->common_functions->getUserIdByToken($token,'admin');
		if($getUserId != '0' && $token!=""){
			$input['lastModifiedBy']=$getUserId;
		if($input['title']!="" && ($input['type']==1 || $input['type']==2 || $input['type']==3) && $input['address']!="" && $input['timezone']>0 && $input['scheduledDateTime']!=""){	
			
			$jobId=$input['jobId'];		
			$checkJob = $this->getJobById($jobId,$input);
	
			if(@count($checkJob)>0){				
				$jobDetails = array(		
				"title"=>$input['title'],
				"type"=>$input['type'],
				"address"=>$input['address'],
				"scheduledDateTime"=>$input['scheduledDateTime'],
				"timezoneId"=>$input['timezone'],	
				"lastModifiedDate"=>$this->common_functions->timestampDate(),
				"lastModifiedBy"=>$input['lastModifiedBy']
				);
				$this->db->update('jobs', $jobDetails, array('jobId'=>$jobId));

				return array('status' => REST_Controller::HTTP_OK,'msg' => 'Success');
			}else{
				return array('status' => REST_Controller::HTTP_NOT_FOUND,'msg' => 'Job id not found');
			}
		}else{
			return array('status' => REST_Controller::HTTP_BAD_REQUEST,'msg' => 'Bad Request');
		}
	}else{
			return array('status' => REST_Controller::HTTP_BAD_REQUEST,'msg' => 'Token Id not exist');
	}
	}
	

	public function getJobById($jobId,$input)
    {	
		$token = $input['token'];
		$getUserId = $this->common_functions->getUserIdByToken($token,'admin');
		if($getUserId != '0' && $token!=""){
		
		$sql = 'SELECT j.jobId as jobId,j.title as title,(CASE WHEN j.type=1 THEN "Collateral" ELSE (CASE WHEN j.type=2 THEN "Equipment" ELSE "Property" END) END) as type,j.address as address,j.scheduledDateTime as scheduledDateTime,t.timeZone as timeZone,j.assignedTo as assignedTo,u.name as assignedToName,(CASE WHEN j.workstatus=1 THEN "Not Started" ELSE (CASE WHEN j.workstatus=2 THEN "Inprogess" ELSE "Completed" END) END) as workStatus,j.status as status,j.createdDate as createdDate FROM jobs j left JOIN timeZones t ON t.timeZoneId = j.timeZoneId left JOIN users u ON u.userId = j.assignedTo  where j.jobId = '.$jobId.' order by j.jobId desc';
		

		 $query = $this->db->query($sql);
		 $data = $query->result();
		 $toalCount=$query->num_rows();
		if($query->num_rows()>0){
			for($x = '0'; $x <$toalCount; $x++){
				$arr[$x]['jobId'] = $data[$x]->jobId;
				$arr[$x]['title'] = $data[$x]->title;
				$arr[$x]['type'] = $data[$x]->type;
				$arr[$x]['address'] = $data[$x]->address;
				$arr[$x]['scheduledDateTime'] = $data[$x]->scheduledDateTime;
				$arr[$x]['timeZone'] = $data[$x]->timeZone;
				$arr[$x]['assignedTo'] = $data[$x]->assignedTo;
				$arr[$x]['assignedToName'] = $data[$x]->assignedToName;
				$arr[$x]['workstatus'] = $data[$x]->workStatus;
				$arr[$x]['status'] = $data[$x]->status;
				$arr[$x]['createdDate'] =$data[$x]->createdDate;
				
				}
			return array('status' => REST_Controller::HTTP_OK,'msg' => 'Success','data' => $arr);
		}else{
			return array('status' => REST_Controller::HTTP_NOT_FOUND,'msg' => 'Job id not found','data' => '');
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
		if(($input['jobId']>'0') && ($input['status']=='0' || $input['status']=='1')){
			$jobId=$input['jobId'];
			$this->db->select('j.jobId as jobId');
		$this->db->from('jobs j');
		$this->db->where('j.jobId',$jobId);
		$query = $this->db->get();
			if($query->num_rows()>0){	
				$jobstatus = array(		
				"status"=>$input['status'],
				"lastModifiedDate"=>$this->common_functions->timestampDate(),
				"lastModifiedBy"=>$input['lastModifiedBy']
				);
				$this->db->update('jobs', $jobstatus, array('jobId'=>$jobId));
				return array('status' => REST_Controller::HTTP_OK,'msg' => 'Success');
			}else{
				return array('status' => REST_Controller::HTTP_NOT_FOUND,'msg' => 'Job id not found');
			}
		}else{
			return array('status' => REST_Controller::HTTP_BAD_REQUEST,'msg' => 'Bad Request');
		}
	}else{
			return array('status' => REST_Controller::HTTP_BAD_REQUEST,'msg' => 'Token Id not exist');
	}
	}
	public function getJobTimezoneToYourTime($job_id,$yourTimezone_id,$input)
    {	
		$token = $input['token'];
		$getUserId = $this->common_functions->getUserIdByToken($token,'admin');
		if($getUserId != '0' && $token!=""){
		
		$sql = 'SELECT t.timeZoneId as timeZoneId, t.timeZone as timeZone  FROM timeZones t where t.timeZoneId = '.$yourTimezone_id.'';
		 $query = $this->db->query($sql);
		 $data = $query->result();
		 $toalCount=$query->num_rows();
		if($query->num_rows()>0){
			$toTimezone=$data['0']->timeZone;
		$sql = 'SELECT j.scheduledDateTime as scheduledDateTime,t.timeZone as timeZone FROM jobs j left JOIN timeZones t ON t.timeZoneId = j.timeZoneId where j.jobId = '.$job_id.'';
		 $query = $this->db->query($sql);
		 $data = $query->result();
		 $toalCount=$query->num_rows();
		if($query->num_rows()>0){
			$fromTimezone=$data['0']->timeZone;
			$fromScheduledTime=$data['0']->scheduledDateTime;
			for($x = '0'; $x <$toalCount; $x++){
				
				$date = new DateTime($fromScheduledTime, new DateTimeZone($fromTimezone));
				$date->format('Y-m-d H:i:sP') . "\n";

				$date->setTimezone(new DateTimeZone($toTimezone));
				$toTime= $date->format('Y-m-d H:i:s');
		
				$arr[$x]['scheduledDateTime'] = $toTime;				
				}
			return array('status' => REST_Controller::HTTP_OK,'msg' => 'Success','data' => $arr);
		}else{
			return array('status' => REST_Controller::HTTP_NOT_FOUND,'msg' => 'Job id not found','data' => '');
		}
		}else{
			return array('status' => REST_Controller::HTTP_NOT_FOUND,'msg' => 'TomeZone id not found','data' => '');
		}
	}else{
			return array('status' => REST_Controller::HTTP_BAD_REQUEST,'msg' => 'Token Id not exist');
	}
	}
	public function assignjob($input)
    {
		$token = $input['token'];
		$getUserId = $this->common_functions->getUserIdByToken($token,'admin');
		if($getUserId != '0' && $token!=""){
			$input['lastModifiedBy'] = $getUserId;
		if($input['jobId']>'0' && $input['assignedTo']>'0'){
			$jobId=$input['jobId'];
			$this->db->select('j.jobId as jobId');
			$this->db->from('jobs j');
			$this->db->where('j.jobId',$jobId);
			$query = $this->db->get();
			if($query->num_rows()>0){	
				$assignedTo=$input['assignedTo'];
				$this->db->select('u.userId as userId');
				$this->db->from('users u');
				$this->db->where('u.userId',$assignedTo);
				$query = $this->db->get();
				if($query->num_rows()>0){
					$jobstatus = array(		
					"assignedTo"=>$input['assignedTo'],
					"lastModifiedDate"=>$this->common_functions->timestampDate(),
					"lastModifiedBy"=>$input['lastModifiedBy']
					);
					$this->db->update('jobs', $jobstatus, array('jobId'=>$jobId));
					return array('status' => REST_Controller::HTTP_OK,'msg' => 'Success');
				}else{
					return array('status' => REST_Controller::HTTP_NOT_FOUND,'msg' => 'Assigned id not found');
				}
			}else{
				return array('status' => REST_Controller::HTTP_NOT_FOUND,'msg' => 'Job id not found');
			}
		}else{
			return array('status' => REST_Controller::HTTP_BAD_REQUEST,'msg' => 'Bad Request');
		}
	}else{
			return array('status' => REST_Controller::HTTP_BAD_REQUEST,'msg' => 'Token Id not exist');
	}
	}
	
	public function submitinspection($input)
    {
		$token = $input['token'];
		$getUserId = $this->common_functions->getUserIdByToken($token,'admin');
		if($getUserId != '0' && $token!=""){
			$input['lastModifiedBy'] = $getUserId;
			$createdBy = $getUserId;
		if($input['jobId']>'0' && ($input['workstatus']=="2" || $input['workstatus']=="3")){
			$jobId=$input['jobId'];
			$this->db->select('j.jobId as jobId');
			$this->db->from('jobs j');
			$this->db->where('j.jobId',$jobId);
			$query = $this->db->get();
			if($query->num_rows()>0){	
				foreach($input['questionandanswers'] as $questionandanswersLoop){
					$questionandanswers = array(		
                    "jobId"=>$jobId,
                    "temGroupQueId"=>$questionandanswersLoop['questionid'],
                    "temGroupQueOptionId"=>$questionandanswersLoop['answerid'],
                    "commentsIfAny"=>$questionandanswersLoop['commentsifany'],
                    "status" => '1',
                    "createdDate"=>$this->common_functions->timestampDate(),
                    "createdBy"=>$createdBy,
                    "lastModifiedDate"=>$this->common_functions->timestampDate(),
                    "lastModifiedBy"=>$createdBy
                    );
                    
                    $this->db->insert('jobinspectionanswers',$questionandanswers);
				}
				
				$othernotes = array(		
                    "jobId"=>$jobId,
                    "description"=>$input['othernotes'],
                    "status" => '1',
                    "createdDate"=>$this->common_functions->timestampDate(),
                    "createdBy"=>$createdBy,
                    "lastModifiedDate"=>$this->common_functions->timestampDate(),
                    "lastModifiedBy"=>$createdBy
                    );
                    
                    $this->db->insert('jobInspectionothersdetails',$othernotes);
					
					 $jobworkstatus = array(		
                    "workStatus"=>$input['workstatus'],
					"lastModifiedDate"=>$this->common_functions->timestampDate(),
                    "lastModifiedBy"=>$createdBy
                    );
            
                    $this->db->update('jobs',$jobworkstatus, array('jobId'=>$jobId));
				return array('status' => REST_Controller::HTTP_OK,'msg' => 'Inspection Submitted successfully', 'othermessage' => 'Here we can integrate email functionality');
			}else{
				return array('status' => REST_Controller::HTTP_NOT_FOUND,'msg' => 'Job id not found');
			}
		}else{
			return array('status' => REST_Controller::HTTP_BAD_REQUEST,'msg' => 'Bad Request');
		}
	}else{
			return array('status' => REST_Controller::HTTP_BAD_REQUEST,'msg' => 'Token Id not exist');
	}
	}
}