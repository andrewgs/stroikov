<?php
class Textmodel extends CI_Model{
	
	var $txt_id = 0;
	var $txt_type = '';
	var $txt_body = '';
		
	function __construct(){
        
		parent::__construct();
    }
		
	function get_data($type){
		
		$this->db->where('txt_type',$type);
		$query = $this->db->get('text',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0]['txt_body'];
		return FALSE;
	}
	function get_record($type){
		
		$this->db->where('txt_type',$type);
		$query = $this->db->get('text',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return FALSE;
	}
	
	function insert_data($data){
		
		$this->txt_body = $data['txtbody'];
		$this->txt_type = $data['txttype'];
		
		$this->db->insert('text', $this);
	}
	
	function update_data($data){
		
		$this->db->set('txt_body',$data['txtbody']);
		
		$this->db->where('txt_type',$data['type']);
		$this->db->update('text');
	}
}
?>