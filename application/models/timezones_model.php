<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class timezones_model extends CI_Model {

		function __construct(){
			parent::__construct();
			$this->load->library('email');
			$this->load->library('session');
			$this->load->model('common_functions');
	   }

	public function timezonesList($input)
    {
		
		$token = $input['token'];
		$getUserId = $this->common_functions->getUserIdByToken($token,'admin');
		if($getUserId != '0' && $token!=""){

		
		$sql = 'SELECT t.timeZoneId as timeZoneId,t.timeZoneName as timeZoneName,t.timeZone as timeZone,t.status as status,t.createdDate as createdDate FROM timezones t order by t.timeZoneId desc';
		$query = $this->db->query($sql);
		$data = $query->result();
		$toalCount=$query->num_rows(); 
		if($query->num_rows()>0){
			for($x = '0'; $x <$toalCount; $x++){

				$arr[$x]['timeZoneId'] = $data[$x]->timeZoneId;
				$arr[$x]['timeZoneName'] = $data[$x]->timeZoneName;
				$arr[$x]['timeZone'] = $data[$x]->timeZone;
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
}