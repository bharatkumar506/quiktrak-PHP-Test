<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class templates_model extends CI_Model {

		function __construct(){
			parent::__construct();
			$this->load->library('email');
			$this->load->library('session');
			$this->load->model('common_functions');
	   }

	public function templatesList($input)
    {
		
		$token = $input['token'];
		$getUserId = $this->common_functions->getUserIdByToken($token,'admin');
		if($getUserId != '0' && $token!=""){

		
		$sql = 'SELECT t.templateId as templateId,(CASE WHEN t.type=1 THEN "Collateral" ELSE (CASE WHEN t.type=2 THEN "Equipment" ELSE "Property" END) END) as type,t.templateTitle as templateTitle,t.status as status,t.createdDate as createdDate FROM template t order by t.templateId desc';
		$query = $this->db->query($sql);
		$data1 = $query->result_array();
		$a=1;
		foreach($data1 as $dat1){
			$templateid=$dat1['templateId'];
			$arr['templateDetails'][$a]=$dat1;
			
			$sql = "SELECT tg.temGroupId as temGroupId,tg.groupName as groupName,tg.displayOrder as displayOrder,tg.status as status,tg.createdDate as createdDate FROM templategroup tg where tg.templateId='$templateid' order by tg.displayOrder ASC";
				$query = $this->db->query($sql);
				$data2 = $query->result_array();
				$b=1;
				foreach($data2 as $dat2){
					$templateGroupId=$dat2['temGroupId'];
                    $arr['templateDetails'][$a]['groups'][$b] = $dat2;
					
					$sql = "SELECT tgq.temGroupQueId as temGroupQueId,tgq.question as question,tgq.displayOrder as displayOrder,tgq.status as status,tgq.createdDate as createdDate FROM templategroupquestions tgq where tgq.templateGroupId='$templateGroupId' order by tgq.displayOrder ASC";
					$query = $this->db->query($sql);
					$data3 = $query->result_array();
					$c=1;
					foreach($data3 as $dat3){
						$temGroupQueId=$dat3['temGroupQueId'];
						$arr['templateDetails'][$a]['groups'][$b]['questions'][$c] = $dat3;
							$sql = "SELECT tgo.temGroupQueOptionId as temGroupQueOptionId,tgo.optionValue as optionValue,tgo.displayOrder as displayOrder,tgo.status as status,tgo.createdDate as createdDate FROM templategroupquestionoptions tgo where tgo.temGroupQueId='$temGroupQueId' order by tgo.displayOrder ASC";
							$query = $this->db->query($sql);
							$data4 = $query->result_array();
							$d=1;
							foreach($data4 as $dat4){
								$arr['templateDetails'][$a]['groups'][$b]['questions'][$c]['questionOptions'][$d] = $dat4;
							$d++;
							}
					$c++;
					}
				$b++;
				}
		$a++;
		}
			return array('status' => REST_Controller::HTTP_OK,'msg' => 'Success','data' => $arr);

	}else{
			return array('status' => REST_Controller::HTTP_BAD_REQUEST,'msg' => 'Token Id not exist');
	}
	}

}