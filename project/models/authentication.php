<?php
class Authentication extends CI_Model{
	
	var $usr_id = 0;
	var $usr_login = '';
	var $usr_first_name = '';
	var $usr_second_name = '';
	var $usr_email = '';
	var $usr_password = '';
	var $usr_pass_crypt = '';
	
	function __construct(){

		parent::__construct();
	}
	
	function get_users_info($id){
		$this->db->where('usr_id',$id);
		$query = $this->db->get('users',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return FALSE;
	}
	
	function users_info($login){
		$this->db->where('usr_login',$login);
		$query = $this->db->get('users',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return FALSE;
	}
	
	function changepassword($data){
		
		$pass = md5($data['newpass']);
		$pass_crypt = $data['pass_crypt'];
		$this->db->set('usr_password',$pass);
		$this->db->set('usr_pass_crypt',$pass_crypt);
		$this->db->where('usr_id',$data['id']);
		$this->db->update('users'); 
	}
}
?>