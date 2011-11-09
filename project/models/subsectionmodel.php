<?php
class Subsectionmodel extends CI_Model{
	
	var $sbs_id = 0;
	var $sbs_cmp_id = 0;
	var $sbs_title = '';
	var $sbs_text = '';
	var $sbs_img = '';
	var $sbs_alt = '';
	
	function __construct(){
        
		parent::__construct();
    }
	
	function insert_record($data){
		
		$this->sbs_cmp_id = $data['cmpid'];
		$this->sbs_title = $data['sbstitle'];
		$this->sbs_text = $data['sbstext'];
		$this->sbs_img = $data['userfile'];
		$this->sbs_alt = $data['sbsimgalt'];
		
		$this->db->insert('subsection',$this);
	}
	
	function get_cmp_data($cmpid){
		
		$this->db->where('sbs_cmp_id',$cmpid);
		$query = $this->db->get('subsection');
		$data = $query->result_array();
		if(count($data)) return $data;
		return FALSE;
		
	}
	
	function get_id_data($id){
		
		$this->db->where('sbs_id',$id);
		$query = $this->db->get('subsection',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return FALSE;
	}
	
	function get_image_data($id){
		
		$this->db->select('sbs_img');
		$this->db->where('sbs_id',$id);
		$query = $this->db->get('subsection',1);
		
		$data = $query->result_array();
		return $data[0]['sbs_img'];
	}
	
	function update_record($data){
		
		$this->sbs_id = $data['id'];
		$this->sbs_cmp_id = $data['cmpid'];
		$this->sbs_title = $data['sbstitle'];
		$this->sbs_text = $data['sbstext'];
		$this->sbs_img = $data['userfile'];
		$this->sbs_alt = $data['sbsimgalt'];
		
		$this->db->where('sbs_id',$data['id']);
		$this->db->update('subsection',$this);
	}
	
	function delete_record($id){
		
		$this->db->delete('subsection', array('sbs_id' => $id));
	}
	
	function record_exist($cmpid){
		
		$this->db->where('sbs_cmp_id',$cmpid);
		$query = $this->db->get('subsection');
		$data = $query->result_array();
		if(count($data)) return TRUE;
		return FALSE;
	}
}
?>