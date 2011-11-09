<?php
class Investmentmodel extends CI_Model{
	
	var $inv_id = 0;
	var $inv_object_name = '';
	var $inv_text = '';
	
	function __construct(){
        
		parent::__construct();
    }
	
	function get_all_data(){
		
		$this->db->order_by('inv_id desc');
		$query = $this->db->get('investment');
		return $query->result();
	}
	
	function get_object_data($id){
		
		$this->db->where('inv_id',$id);
		$query = $this->db->get('investment',1);
		return $query->result();
	}
	
	function update_data($data){
		
		$this->inv_id = $data['id'];
		$this->inv_object_name = $data['objectname'];
		$this->inv_text = $data['investmenttext'];
		
		$this->db->where('inv_id', $this->inv_id);
		$this->db->update('investment', $this);
	}
	
	function insert_object_investment($data){
	 
		$this->inv_object_name = $data['objectname'];
		$this->inv_text = $data['investmentext'];
		$this->db->insert('investment', $this);
	}
	
	function delete_object($id){
		
		$this->db->delete('investment', array('inv_id' => $id));
	}
}