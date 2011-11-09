<?php
class Contactsmodel extends CI_Model{
	
	var $cnt_id = 0;
	var $cnt_post_index = '';
	var $cnt_city = '';
	var $cnt_street = '';
	var $cnt_house = '';
	var $cnt_telfax = '';
	var $cnt_email = '';
	
	function __construct(){
        
		parent::__construct();
    }
	
	function insert_contact($data){
		
		$this->cnt_post_index = $data['postindex'];
		$this->cnt_city = $data['city'];
		$this->cnt_street = $data['street'];
		$this->cnt_house = $data['house'];
		$this->cnt_telfax = $data['telfax'];
		$this->cnt_email = $data['email'];
		$this->db->insert('contacts', $this);
		return $this->db->insert_id();
	}
	
	function get_contact($id){
		
		$this->db->where('cnt_id',$id);
		$query = $this->db->get('contacts',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return FALSE;
	}
	
	function update_contact($data){
		
		$this->cnt_id = $data['id'];
		$this->cnt_post_index = $data['postindex'];
		$this->cnt_city = $data['city'];
		$this->cnt_street = $data['street'];
		$this->cnt_house = $data['house'];
		$this->cnt_telfax = $data['telfax'];
		$this->cnt_email = $data['email'];
		
		$this->db->where('cnt_id', $this->cnt_id);
		$this->db->update('contacts', $this);
	}
	
	function get_all_contacts(){
		
		$this->db->order_by('cnt_id desc');
		$query = $this->db->get('contacts',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return FALSE;
	}
	
	function delete_contact($id){
	
		$this->db->where('cnt_id',$id);
		$this->db->delete('contacts');
		return $this->db->affected_rows();
	}
}
?>