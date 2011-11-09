<?php
class Newsmodel extends CI_Model{
	
	var $nws_id 		= 0;
	var $nws_header 	= '';
	var $nws_body 		= '';
	var $nws_date 		= '';
	var $nws_img_src 	= '';
	var $nws_img_alt 	= '';

	function __construct(){
        
		parent::__construct();
    }
	
	function get_all_news(){
	
		$this->db->order_by('nws_id desc');
		$query = $this->db->get('news');
		$data = $query->result_array();
		if(count($data)) return $data;
		return FALSE;
	}
	
	function get_news($id){
		
		$this->db->where('nws_id',$id);
		$query = $this->db->get('news',1);
		return $query->result();
	}
	
	function get_image_data($id){
		
		$this->db->select('nws_img_src');
		$this->db->where('nws_id',$id);
		$query = $this->db->get('news',1);
		
		$data = $query->result_array();
		return $data[0]['nws_img_src'];
	}
	
	function get_news_in_main_page(){
	
		$this->db->order_by('nws_date desc, nws_id desc');
		$query = $this->db->get('news',3);
		$data = $query->result_array();
		if(count($data)) return $data;
		return FALSE;
	}

	function get_news_limit_records($count,$from){
		
	//	$this->db->select('nws_id,nws_header,nws_body,DATE_FORMAT(nws_date,"%d %m %Y") as nws_date',FALSE);
		$this->db->order_by('nws_date desc, nws_id desc');
		$this->db->limit($count,$from);
		$query = $this->db->get('news');
		return $query->result();
	} 

	function count_records(){
	
		return $this->db->count_all('news');
	}
	
	function delete_record_to_news($id){
		
		$this->db->delete('news', array('nws_id' => $id));
	}
	
	function insert_record_to_news($data){
	 
		$this->nws_header = $data['newsheader'];
		$this->nws_body =  $data['newsbody'];
		$this->nws_date = $data['date'];
		$this->nws_img_src = $data['userfile'];
		$this->nws_img_alt = $data['newsimgalt'];
		
		$this->db->insert('news', $this);
	}
	
	function update_record_to_news($data){
		
		$this->nws_id = $data['id'];
		$this->nws_header = $data['newsheader'];
		$this->nws_body = $data['newsbody'];
		$this->nws_date = $data['date'];
		$this->nws_img_src = $data['userfile'];
		$this->nws_img_alt = $data['newsimgalt'];
		
		$this->db->where('nws_id', $this->nws_id);
		$this->db->update('news', $this);
	}
	
}
?>