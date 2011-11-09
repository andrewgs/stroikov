<?php
class Companymodel extends CI_Model{
	
	var $cmp_id = 0;
	var $cmp_name = '';
	var $cmp_descr = '';
	var $cmp_text = '';
	var $cmp_text_link = '';
	var $cmp_img_src = '';
	var $cmp_img_alt = '';
	var $cmp_url = '';
	
	function __construct(){
    
		parent::__construct();
 	}
	
	function get_all_company(){
		
		$this->db->order_by('cmp_id asc');
		$query = $this->db->get('company');
		$data = $query->result_array();
		if(count($data)) return $data;
		return FALSE;
	}
	
	function get_cmp_by_url($url){
		$this->db->where('cmp_url',$url);
		$query = $this->db->get('company',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return FALSE;
	}
	
	function insert_company($data){
		
		$this->cmp_name = $data['companyname'];
		$this->cmp_descr =  $data['companydescr'];
		$this->cmp_text = $data['companytext'];
		$this->cmp_text_link = $data['textlink'];
		$this->cmp_img_src = $data['userfile'];
		$this->cmp_img_alt = $data['companyimgalt'];
		$this->cmp_url = $data['url'];
		$this->db->insert('company', $this);
		return $this->db->insert_id();
	}
	
	function delete_company($id){
	
		$this->db->where('cmp_id',$id);
		$this->db->delete('company');
		return $this->db->affected_rows();
	}
	
	function get_company($id){
		
		$this->db->where('cmp_id',$id);
		$query = $this->db->get('company',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return FALSE;
	}
	
	
	function update_company($data){
		
		$this->db->set('cmp_name',$data['companyname']);
		$this->db->set('cmp_descr',$data['companydescr']);
		$this->db->set('cmp_text',$data['companytext']);
		$this->db->set('cmp_text_link',$data['textlink']);
		$this->db->set('cmp_img_src',$data['userfile']);
		$this->db->set('cmp_img_alt',$data['companyimgalt']);
		$this->db->where('cmp_id',$data['id']);
		$this->db->update('company');
		return $this->db->affected_rows();
	}
	
	function get_image_data($id){
		
		$this->db->select('cmp_img_src');
		$this->db->where('cmp_id',$id);
		$query = $this->db->get('company',1);
		
		$data = $query->result_array();
		return $data[0]['cmp_img_src'];
	}
}
?>