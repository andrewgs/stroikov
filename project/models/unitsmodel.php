<?php
class Unitsmodel extends CI_Model{
	
	var $unt_id = 0;
	var $unt_title = '';
	var $unt_body = '';
	var $unt_image = '';
	var $unt_client = '';
	var $unt_small_image = '';
	var $unt_img_alt = '';
		
	function __construct(){
        
		parent::__construct();
    }
		
	function get_limit_units($count,$from){
		
		if($count >= 0){			
			$this->db->order_by('unt_id desc');
			$this->db->limit($count,$from);
			$query = $this->db->get('units');
		}else{
			$countrec = $this->count_records();
			$this->db->order_by('unt_id desc');
			$this->db->limit($countrec+$count,$from);
			$query = $this->db->get('units');
		}			
		return $query->result();
	}
	
	function count_records(){
		
		return $this->db->count_all_results('units');
	}
	
	function insert_units($data){
		
		$this->unt_title = $data['unitstitle'];
		$this->unt_body = $data['unitsbody'];
		$this->unt_image = $data['userfile'];
		$this->unt_client = $data['unitsclient'];
		$this->unt_small_image = $data['smallimage'];
		$this->unt_img_alt = $data['unitsimgalt'];
		
		$this->db->insert('units', $this);
	}
	function get_units($id){
		
		$this->db->where('unt_id',$id);
		$query = $this->db->get('units',1);
		return $query->result();
	}
	
	function get_all_units(){
		
		$this->db->order_by('unt_id desc');
		$query = $this->db->get('units');
		return $query->result_array();
	}
	
	function update_units($data){
	
		$this->unt_id = $data['id'];
		$this->unt_title = $data['unitstitle'];
		$this->unt_body = $data['unitsbody'];
		$this->unt_image = $data['userfile'];
		$this->unt_client = $data['unitsclient'];
		$this->unt_small_image = $data['smallimage'];
		$this->unt_img_alt = $data['unitsimgalt'];
		
		$this->db->where('unt_id', $this->unt_id);
		$this->db->update('units', $this);
	}
	
	function delete_units($id){
		
		$this->db->delete('units', array('unt_id' => $id));
	}
}
?>