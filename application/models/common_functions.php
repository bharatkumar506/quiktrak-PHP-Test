<?php
class Common_functions extends CI_Model{

function __construct(){
	parent::__construct();
}

function timestampDate(){
    return date('Y-m-d H:i:sP');
}
function currentDate(){
    return date('Y-m-d');
}

function sanatize_post($input){
    foreach ($input as $key => $val){
		if(is_array($val)){
				foreach ($val as $key1 => $val1){
							if(is_array($val1)){
								$input[$key][$key1] = $val1;
							}else{
								$input[$key][$key1] = trim($val1);
							}
						
				}
		}else{
			$input[$key] = trim($val);
		}
	}
	return $input;
}
function isValidEmail($email){ 
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
public function getUserIdByToken($token){
			$this->db->select('u.userId as id');
			$this->db->from('users u');	
			$this->db->where('u.token',$token);
			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			if($query->num_rows()>0){
				$data = $query->row_array();
				$id = $data['id'];
				
			}else{
				$id = '0';
			}
			return $id;

	}
function randomPassword() {
$digits    = array_flip(range('0', '9'));
$lowercase = array_flip(range('a', 'z'));
$uppercase = array_flip(range('A', 'Z')); 
$special   = array_flip(str_split('!@#$%^&*()_+=-}{[}]\|;:<>?/'));
$combined  = array_merge($digits, $lowercase, $uppercase, $special);
$password  = str_shuffle(array_rand($digits) .
                         array_rand($lowercase) .
                         array_rand($uppercase) . 
                         array_rand($special) . 
                         implode(array_rand($combined, rand(4, 8))));
    return $password; //turn the array into a string
}	
}