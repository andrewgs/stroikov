<?php
class Partnersmodel extends CI_Model{
	
	var $prt_id = 0;
	var $prt_href = '';
	var $prt_name = '';
	var $prt_note = '';
	
	function __construct(){
        
		parent::__construct();
    }
	
	function get_all_partners(){
		
		$this->db->order_by('prt_id asc');
		$query = $this->db->get('partners');
		return $query->result();
	}
	function get_arr_partners(){
		
		$this->db->order_by('prt_id asc');
		$query = $this->db->get('partners');
		$data = $query->result_array();
		if(count($data)) return $data;
		return FALSE;
	}
	
	function count_records(){
	
		return $this->db->count_all('partners');
	}
	
	function get_limit_partners($count,$from){
		
		$this->db->order_by('prt_id asc');
		$this->db->limit($count,$from);
		$query = $this->db->get('partners');
		return $query->result();
	}
	
	function insert_partner($data){
		
		$this->prt_href = $data['partnerhref'];
		$this->prt_name =  $data['partnername'];
		$this->prt_note = '';
		
		$this->db->insert('partners', $this);
	}
	
	function get_partner($id){
		
		$this->db->where('prt_id',$id);
		$query = $this->db->get('partners',1);
		return $query->result();
	}
	
	function delete_partner($id){
		
		$this->db->delete('partners', array('prt_id' => $id));
	}
	
	function update_partner($data){
		
		$this->prt_id = $data['id'];
		$this->prt_href = $data['partnerhref'];
		$this->prt_name = $data['partnername'];
		$this->prt_note = '';
		
		$this->db->where('prt_id', $this->prt_id);
		$this->db->update('partners', $this);
	}
}
?>