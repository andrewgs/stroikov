<?php
class Inboxmailmodel extends CI_Model{
	
	var $iml_id = 0;
	var $iml_name = '';
	var $iml_email = '';
	var $iml_text_email = '';
	var $iml_date = '';
	
	function __construct(){
        
		parent::__construct();
    }
	
	function insert_email($data){
		
		$this->iml_name = $data['name'];
		$this->iml_email = $data['email'];
		$this->iml_text_email = strip_tags($data['comments']);
		$this->iml_date = date("Y-m-d");
		$this->db->insert('inboxmail', $this);
		return $this->db->insert_id();
	}
	
	function get_all_emails(){
		
		$this->db->order_by('iml_id desc');
		$query = $this->db->get('inboxmail');
		$data = $query->result_array();
		if(count($data)) return $data;
		return FALSE;
	}
	
	function delete_email($id){
		$this->db->where('iml_id',$id);
		$this->db->delete('inboxmail');
		return $this->db->affected_rows();
	}
	
	function get_mail($id){
		
		$this->db->where('iml_id',$id);
		$query = $this->db->get('inboxmail');
		return $query->result();
	}
}
?>