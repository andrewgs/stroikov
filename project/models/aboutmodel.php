<?php
class Aboutmodel extends CI_Model{
	
	var $abt_id = 0;
	var $abt_text = '';
	
	function __construct(){

		parent::__construct();
	}
	
	function get_data(){
		
		$query = $this->db->get('about',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return FALSE;
	}
	
	function update_data($data){
		
		$this->db->set('abt_id',$data['id']);
		$this->db->set('abt_text',$data['abouttext']);
		
		$this->db->where('abt_id',$data['id']);
		$this->db->update('about');
		return $this->db->affected_rows();
	}
}