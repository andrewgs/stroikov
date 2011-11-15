<?php
class Admin_interface extends CI_Controller{
	
	var $admin = array('status'=>FALSE);
	var $months = array("01"=>"января","02"=>"февраля","03"=>"марта","04"=>"апреля","05"=>"мая","06"=>"июня","07"=>"июля",
						"08"=>"августа","09"=>"сентября","10"=>"октября","11"=>"ноября","12"=>"декабря");
	var $message = array('error'=>'','saccessfull'=>'','message'=>'','status'=>0);
							
	function __construct(){
	
		parent::__construct();
		$this->load->model('authentication');
		$this->load->model('newsmodel');
		$this->load->model('companymodel');
		$this->load->model('unitsmodel');
		$this->load->model('partnersmodel');
		$this->load->model('inboxmailmodel');
		$this->load->model('contactsmodel');
		$this->load->model('aboutmodel');
		$this->load->model('investmentmodel');
		$this->load->model('imagesmodel');
		$this->load->model('textmodel');
		$this->load->model('subsectionmodel');
		if($this->session->userdata('logon') == '76f1847d0a99a57987156534634a1acf'):
			$this->admin['status'] = TRUE;
			return TRUE;
		endif;
		if($this->uri->segment(2)==='login') return;
		redirect('admin/login');
	}
	
	/**************************************************************************************************************/
	
	function control_panel(){
		
		if($this->uri->uri_string() == "admin"):
			redirect('admin/control-panel');
		endif;
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Панель управления",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'messages'		=> $this->inboxmailmodel->get_all_emails(),
						'pagename'		=> 'Панель управления'
					);
		for($i=0;$i<count($pagevar['messages']);$i++):
			$pagevar['messages'][$i]['iml_date'] = $this->operation_date($pagevar['messages'][$i]['iml_date']);
		endfor;
		$this->session->unset_userdata('img_alt');
		$this->load->view('admin_interface/cpanel',$pagevar);
	}
	
	function login(){
		
		if($this->admin['status']):
			redirect('admin/control-panel');
		endif;
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Авторизация",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'contacts'		=> $this->contactsmodel->get_all_contacts(),
						'pagename'		=> 'Авторизация'
					);
		if($this->input->post('submit')):
			$this->form_validation->set_rules('login-name',' ','required|trim');
			$this->form_validation->set_rules('login-pass',' ','required');
			if(!$this->form_validation->run()):
				$_POST['submit'] = NULL;
				$this->login();
				return FALSE;
			else:
				$_POST['submit'] = NULL;
				$user = $this->authentication->users_info($_POST['login-name']);
				if($user):
					if($user['usr_password'] === md5($_POST['login-pass'])):
	                	$this->session->set_userdata('logon','76f1847d0a99a57987156534634a1acf');
	                	$this->session->set_userdata('login',$user['usr_id']);
	                	redirect('admin/control-panel');
					endif;
				else:
					redirect('admin/login');
				endif;
			endif;
		endif;
		$this->load->view('admin_interface/login',$pagevar);
	}
	
	function logoff(){
	
    	$this->session->sess_destroy();
        redirect('');
    }
	
	function delete_message(){
	
		$statusval = array('status'=>FALSE,'message'=>'Ошибка при удалении');
		$msgid = trim($this->input->post('id'));
		if(!$msgid) show_404();
		$success = $this->inboxmailmodel->delete_email($msgid);
		if($success) $statusval['status'] = TRUE;
		echo json_encode($statusval);
	}
	
	/**************************************************************************************************************/
	
	function newsview(){
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Администрирование | Новости компании",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'pagename'		=> 'Новости компании',
						'news'			=> $this->newsmodel->get_all_news(),
						'msg'			=> $this->session->userdata('msg')
					);
		$this->session->unset_userdata('msg');
		for($i=0;$i<count($pagevar['news']);$i++):
			$pagevar['news'][$i]['nws_date'] = $this->operation_date($pagevar['news'][$i]['nws_date']);
		endfor;
		$this->load->view('admin_interface/news_view',$pagevar);
	}
	
	function newsdestroy(){
	
		$id = $this->uri->segment(3);
		$data = $this->newsmodel->get_news($id);
		if(!isset($data) or empty($data)) redirect('404');
		$this->otherimagedelete($id,'newsmodel');
		$this->newsmodel->delete_record_to_news($id);
		$this->session->set_userdata('msg','"Новость удалена успешно"');
		redirect('admin/newsview');
	}
	
	function newsupdate(){
	
		if(empty($_POST['newsbody']) or empty($_POST['newsheader'])):
			redirect('admin/newsedit/'.$_POST['id']);
			return FALSE;
		endif;
		if(isset($_POST['newsimgdel']) and !empty($_POST['newsimgdel'])):
			$this->otherimagedelete($_POST['id'],'newsmodel');
			$_POST['userfile'] = '';
			$_POST['newsimgalt'] = '';
		else:
			$config['upload_path'] = getcwd().'/images';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['remove_spaces'] = TRUE;
			$config['overwrite'] = TRUE;			
			$this->upload->initialize($config);
			if($this->upload->do_upload()):
				$upload_data = $this->upload->data();			
				$_POST['userfile'] = 'images/'.$upload_data['file_name'];
				if($_POST['oldphoto']!=$_POST['userfile'] and !empty($_POST['oldphoto'])):
					$photopath = getcwd().'/'.$_POST['oldphoto'];
					if(file_exists($photopath)):
						unlink($photopath);
					endif;
				endif;
				$_POST['userfile'] = $this->createimage($_POST['userfile'],240,160);
				if(!$_POST['userfile'] or empty($_POST['userfile'])):
					$_POST['userfile'] = $_POST['oldphoto'];
				endif;
			else:
				$_POST['userfile'] = $_POST['oldphoto'];
			endif;
		endif;
		$pattern = "/(\d+)\/(\w+)\/(\d+)/i";
		$replacement = "\$3-\$2-\$1";
		$_POST['date'] = preg_replace($pattern, $replacement, $_POST['date']);
		$this->session->set_userdata('msg','"Информация сохранена"');
		$this->newsmodel->update_record_to_news($_POST);
		redirect('admin/newsview'); 
		
	}
	
	function newsedit(){
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Администрирование | Редактирование новости",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'pagename'		=> 'Редактирование новости',
						'news'			=> $this->newsmodel->get_news($this->uri->segment(3)),
						'msg'			=> $this->session->userdata('msg')
					);
		if(!isset($pagevar['news']) || empty($pagevar['news'])) show_404();
		foreach ($pagevar['news'] as $date):
			$date->nws_date = $this->operation_date_slash($date->nws_date);				 
		endforeach;
		$this->load->view('admin_interface/news_edit',$pagevar);
	}
	
	function newsinsert(){

		$this->form_validation->set_rules('newsheader', '"Аннотация"', 'required');
		$this->form_validation->set_rules('newsbody', '"Текст новости"', 'required');
		if(!$this->form_validation->run()):
			$this->newsnew();
		else:
			$config['upload_path'] = getcwd().'/images';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['remove_spaces'] = TRUE;
			$config['overwrite'] = FALSE;			
			$this->upload->initialize($config);
			if($this->upload->do_upload()):
				$upload_data = $this->upload->data();			
				$_POST['userfile'] = 'images/'.$upload_data['file_name'];
				$_POST['userfile'] = $this->createimage($_POST['userfile'],240,160);
				if(!$_POST['userfile'] or empty($_POST['userfile'])):
					$_POST['userfile'] = '';
					$_POST['newsimgalt'] = '';
				endif;
			else:
				$_POST['userfile'] = '';
				$_POST['newsimgalt'] = '';	
			endif;
			$pattern = "/(\d+)\/(\w+)\/(\d+)/i";
			$replacement = "\$3-\$2-\$1";
			$_POST['date'] = preg_replace($pattern,$replacement,$_POST['date']);
			$this->session->set_userdata('msg','"Новсть создана успешно"');
			$this->newsmodel->insert_record_to_news($_POST);
			redirect('admin/newsview');
		endif;
	}
	
	function newsnew(){
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Администрирование | Добавление новости",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'pagename'		=> 'Добавление новости',
						'news'			=> $this->newsmodel->get_all_news(),
						'msg'			=> $this->session->userdata('msg')
					);
		$this->load->view('admin_interface/news_new',$pagevar);
	}
	
	/**************************************************************************************************************/
	
	function company_edit(){
		
		$cmpid = $this->uri->segment(3);
		if(!$cmpid) show_404();
		$cmp_data = $this->companymodel->get_company($cmpid);
		if(!$cmp_data) show_404();
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Редактирование компании",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'company'		=> $this->companymodel->get_company($cmpid),
						'pagename'		=> 'Редактирование компании',
						'subsection'	=> $this->subsectionmodel->record_exist($cmpid)
					);
		$this->load->view('admin_interface/company_edit',$pagevar);
	}
	
	function delete_company(){
	
		$statusval = array('status'=>FALSE,'message'=>'Ошибка при удалении');
		$cmpid = trim($this->input->post('id'));
		if(!$cmpid) show_404();
		$cmp_data = $this->companymodel->get_company($cmpid);
		if(!$cmp_data) show_404();
		$imglist = $this->imagesmodel->get_data('company',$cmpid);
		if($imglist):
			for($i=0;$i<count($imglist);$i++):
				$photopath = getcwd().'/'.$imglist[$i]['img_src'];
				if(file_exists($photopath)):
					unlink($photopath);
				endif;
			endfor;
			$this->imagesmodel->image_type_delete('company',$cmpid);
		endif;
		$sbs = $this->subsectionmodel->get_cmp_data($cmpid);
		for($i=0;$i<count($sbs);$i++):
			$imglist = $this->imagesmodel->get_data('subsection',$sbs[$i]['sbs_id']);
			if($imglist):
				for($i=0;$i<count($imglist);$i++):
					$photopath = getcwd().'/'.$list->img_src;
						$photopath = getcwd().'/'.$imglist[$i]['img_src'];
					if(file_exists($photopath)):
						unlink($photopath);
					endif;
				endfor;
			endif;
			$this->imagesmodel->image_type_delete('subsection',$sbs[$i]['sbs_id']);
			$this->otherimagedelete($sbs[$i]['sbs_id'],'subsectionmodel');
			$this->subsectionmodel->delete_record($sbs[$i]['sbs_id']);
		endfor;
		$this->otherimagedelete($cmpid,'companymodel');
		$success = $this->companymodel->delete_company($cmpid);
		if($success) $statusval['status'] = TRUE;
		echo json_encode($statusval);
	}
	
	function companylist(){
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Список групп компаний",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'company'		=> $this->companymodel->get_all_company(),
						'pagename'		=> 'Список групп компаний',
						'msg'			=> $this->session->userdata('msg')
					);
		$this->session->unset_userdata('msg');
		if($this->input->post('submit')):
			$this->form_validation->set_rules('companyname',' ','required|trim');
			$this->form_validation->set_rules('companydescr',' ','required|trim');
			$this->form_validation->set_rules('url',' ','required|callback_url_check|trim');
			$this->form_validation->set_rules('companytext',' ','trim');
			$this->form_validation->set_rules('companyimgalt',' ','required|trim');
			$this->form_validation->set_rules('userfile','','callback_userfile_check');
			$this->form_validation->set_rules('textlink',' ','required|trim');
			if(!$this->form_validation->run()):
				$_POST['submit'] = NULL;
				$this->companylist();
				return FALSE;
			else:
				$_POST['submit'] = NULL;
				if($_FILES['userfile']['error'] != 4):
					$config['upload_path'] = getcwd().'/images';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['remove_spaces'] = TRUE;
					$config['overwrite'] = FALSE;
					$this->upload->initialize($config);
					if($this->upload->do_upload()):
						$upload_data = $this->upload->data();			
						$_POST['userfile'] = 'images/'.$upload_data['file_name'];
						$_POST['userfile'] = $this->createimage($_POST['userfile'],240,160);
					endif;
				endif;
				$this->companymodel->insert_company($_POST);
				$this->session->set_userdata('msg','"Добавлена новая компания"');
				redirect($this->uri->uri_string());
			endif;
		endif;
		
		$this->load->view('admin_interface/company_view',$pagevar);
	}
	
	function companyview(){
		
		$data1 = array(
						'title' => "СК Стройковъ | Администрирование | Список дочерних компаний",
						'desc' => "\"\"",
						'keyword' => "\"\"",
						'baseurl' => base_url()
					);
							
		$data2 = $this->companymodel->get_all_company();

		$this->load->view('company_view',array('data1'=>$data1,'data2'=>$data2));
	}

	function companynew(){
		
		$data = array(
						'title' => "СК Стройковъ | Администрирование | Добавление дочерней компании",
						'desc' => "\"\"",
						'keyword' => "\"\"",
						'baseurl' => base_url()
					);
		$this->load->view('company_new',array('data'=>$data));
	}
	
	function companydestroy(){
		
		$id = $this->uri->segment(3);
		$cmp_data = $this->companymodel->get_company($id);
		if(!isset($cmp_data) or empty($cmp_data)) redirect('404'); 
		
		$imglist = $this->imagesmodel->get_data('company',$id);
		if(isset($imglist) and !empty($imglist)){
			
			foreach($imglist as $list){
				$photopath = getcwd().'/'.$list->img_src;
				if (file_exists($photopath))
					if(!unlink($photopath)){
					//обработка события если не удалился файл						
				}
			}
			$this->imagesmodel->image_type_delete('company',$id);
		}
		
		$sbs = $this->subsectionmodel->get_cmp_data($id);
		
		for($i = 0; $i < count($sbs); $i++){
			
			$imglist = $this->imagesmodel->get_data('subsection',$sbs[$i]['sbs_id']);
			if(isset($imglist) and !empty($imglist))
				foreach($imglist as $list){
					$photopath = getcwd().'/'.$list->img_src;
					if (file_exists($photopath))
						if(!unlink($photopath)){
						//обработка события если не удалился файл						
					}
				}
			$this->imagesmodel->image_type_delete('subsection',$sbs[$i]['sbs_id']);
			$this->otherimagedelete($sbs[$i]['sbs_id'],'subsectionmodel');
			$this->subsectionmodel->delete_record($sbs[$i]['sbs_id']);
		}
		
		$this->otherimagedelete($id,'companymodel');
		$this->companymodel->delete_company($id);
		redirect('admin/companyview');
	}
	
	function companyinsert(){
	
		$this->form_validation->set_rules('companyname', '"Название компании"', 'required');
		$this->form_validation->set_rules('companydescr', '"О компании"', 'required');
	//	$this->form_validation->set_rules('companytext', '"Разширенная информация"', 'required');
		$this->form_validation->set_rules('textlink', '"Текст ссылки"', 'required');
		
		$this->form_validation->set_error_delimiters('<div class="message">','</div>');
		if ($this->form_validation->run() == FALSE){
		
			$this->companynew();
		}else{
			
			$config['upload_path'] = getcwd().'/images';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['remove_spaces'] = TRUE;
			$config['overwrite'] = FALSE;			
						
			$this->upload->initialize($config);
			
			if ($this->upload->do_upload()){    
			
				$upload_data = $this->upload->data();			
				$_POST['userfile'] = 'images/'.$upload_data['file_name'];
			
				$_POST['userfile'] = $this->createimage($_POST['userfile'],240,160);
			
				if(!$_POST['userfile'] or empty($_POST['userfile'])){
				
					$_POST['userfile'] = '';
					$_POST['companyimgalt'] = '';
				}
				
			}else{
				// обработка ошибки загрузки или не указан
				$_POST['userfile'] = '';
				$_POST['companyimgalt'] = '';	
			}
			$this->companymodel->insert_company($_POST);
			redirect('admin/companyview');
		}
	}
	
	function companyupdate(){
		
		if(empty($_POST['companyname']) or empty($_POST['companydescr'])){
			redirect('admin/companyedit/'.$_POST['id']);
			return FALSE;
		}
		if(isset($_POST['companyimgdel']) and !empty($_POST['companyimgdel'])){
			$this->otherimagedelete($_POST['id'],'companymodel');
			$_POST['userfile'] = '';
			$_POST['companyimgalt'] = '';
		}else{
			$config['upload_path'] = getcwd().'/images';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['remove_spaces'] = TRUE;
			$config['overwrite'] = TRUE;			
			$this->upload->initialize($config);
			if ($this->upload->do_upload()){
				$upload_data = $this->upload->data();			
				$_POST['userfile'] = 'images/'.$upload_data['file_name'];
				if($_POST['oldphoto']!=$_POST['userfile'] and !empty($_POST['oldphoto'])){
					$photopath = getcwd().'/'.$_POST['oldphoto'];
					if (file_exists($photopath)) !unlink($photopath);
				}
				$_POST['userfile'] = $this->createimage($_POST['userfile'],240,160);
				if(!$_POST['userfile'] or empty($_POST['userfile'])){
					$_POST['userfile'] = $_POST['oldphoto'];
				}
			}else
				$_POST['userfile'] = $_POST['oldphoto'];
		}
		$this->companymodel->update_company($_POST);
		$this->session->set_userdata('msg','"Информация сохранена"');
		redirect('admin/company');
	}

	/**************************************************************************************************************/

	function unitsview(){
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Администрирование | Список объектов",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'units'			=> array(),
						'count'			=> 0,
						'pagename'		=> 'Список объектов',
						'msg'			=> $this->session->userdata('msg')
					);
		$this->session->unset_userdata('msg');
		$pagevar['count'] = $this->unitsmodel->count_records();
		$pagevar['units'] = $this->unitsmodel->get_all_units();
		$this->load->view('admin_interface/units_view',$pagevar);
	}
			
	function unitsnew(){
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Администрирование | Добавление объекта",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'pagename'		=> 'Добавление объекта',
						'msg'			=> $this->session->userdata('msg')
					);
		$this->load->view('admin_interface/units_new',$pagevar);
	}

	function unitsinsert(){
		$this->form_validation->set_rules('unitstitle', '"Юрид.адрес объекта"', 'required');
		$this->form_validation->set_rules('unitsclient', '"Название объекта"', 'required');
		$this->form_validation->set_rules('unitsbody', '"Описание объекта"', 'required');
		$this->form_validation->set_error_delimiters('<div class="message">','</div>');
		if(!$this->form_validation->run()):
			$this->unitsnew();
			return FALSE;
		endif;
		$config['upload_path'] = getcwd().'/images';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['remove_spaces'] = TRUE;
		$config['overwrite'] = FALSE;			
		$this->upload->initialize($config);
		if($this->upload->do_upload()):
			$upload_data = $this->upload->data();			
			$_POST['userfile'] = 'images/'.$upload_data['file_name'];
			$_POST['smallimage'] = 'images/'.$upload_data['raw_name'].'_small'.$upload_data['file_ext'];
			$this->image_lib->clear();
			$conf['image_library'] 	= 'gd2';
			$conf['source_image']	= $_POST['userfile']; 
			$conf['create_thumb'] 	= FALSE;
			$conf['maintain_ratio'] = TRUE;
			$conf['new_image'] 		= $_POST['smallimage'];
			$conf['width']	 		= 240;
			$conf['height']			= 160;
			$this->image_lib->initialize($conf); 
			$this->image_lib->resize();
			$this->image_lib->clear();
			$_POST['userfile'] = $this->createdoubleimage($_POST['userfile'],434,194);
			if(!$_POST['userfile'] or empty($_POST['userfile'])):
				$_POST['userfile'] = 'images/unitsempty.png';
				$_POST['smallimage'] = '';
			endif;
		else:
			$_POST['userfile'] = 'images/unitsempty.png';
			$_POST['smallimage'] = '';	
		endif;
		$this->unitsmodel->insert_units($_POST);
		$this->session->set_userdata('msg','"Объект создан успешно"');
		redirect('admin/unitsview');
	}
	
	function unitsinfo(){
		
		$data1 = array(
						'title' => "СК Стройковъ | Администрирование | Информация о объекте",
						'desc' => "\"\"",
						'keyword' => "\"\"",
						'baseurl' => base_url()
					);
		$id = $this->uri->segment(3);	
		$unit_data = $this->unitsmodel->get_units($id);
		if(!isset($unit_data) or empty($unit_data)) redirect('admin');
		
		$data2 = array();
		$data3 = array();
		
		foreach($unit_data as $units){
			
			$data2['id'] = $units->unt_id;
			$data2['title'] = $units->unt_title;
			$data2['client'] = $units->unt_client;
			$data2['body'] = $units->unt_body;
			$data2['small_image'] = $units->unt_small_image;
			$data2['img_alt'] = $units->unt_img_alt;
			
			$img_data = $this->imagesmodel->get_type_ones_image('units',$units->unt_id);
			foreach($img_data as $img){
				$data2['img_id'] = $img->img_id;
				$data2['img_src'] = $data1['baseurl'].$img->img_src;
				$data2['img_title'] = $img->img_title;
			}
			if(isset($data2['img_id']) and !empty($data2['img_id'])){
				$imglist = $this->imagesmodel->get_image_all_data('units',$units->unt_id,$data2['img_id']);
			}else{
				$imglist = $this->imagesmodel->get_image_all_data('units',$units->unt_id,-1);
			}
			
			$j = 0;
			foreach($imglist as $list){
				$data3[$j]['id'] = $list->img_id;
				$data3[$j]['image'] = $data1['baseurl'].$list->img_src;
				$data3[$j]['title'] = $list->img_title;
				$j++;
			}
			$data2['index'] = $j;
		}
		$this->load->view('units_info',array('data1'=>$data1,'data2'=>$data2,'data3'=>$data3));
	}

	function unitsedit(){
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Администрирование | Редактирование объекта",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'unit'			=> $this->unitsmodel->get_units($this->uri->segment(3)),
						'pagename'		=> 'Редактирование объекта',
						'msg'			=> $this->session->userdata('msg')
					);
		if(!isset($pagevar['unit']) || empty($pagevar['unit'])) show_404();
		
		foreach($pagevar['unit'] as $unt):
			$this->session->set_userdata('img_alt',$unt->unt_title);
		endforeach;
		
    	$this->load->view('admin_interface/units_edit',$pagevar);
	}
	
	function unitsdestroy(){
		
		$id = $this->uri->segment(3);			
		$data1 = $this->unitsmodel->get_units($id);
		if(!isset($data1) or empty($data1)) show_404();
		foreach ($data1 as $units){
			if ($units->unt_image != 'images/unitsempty.png') 
				if(!empty($units->unt_image) and file_exists(getcwd().'/'.$units->unt_image))
					if(!unlink(getcwd().'/'.$units->unt_image)){							
					//обработка ошибки удаления файла						
					}
				if(!empty($units->unt_small_image) and file_exists(getcwd().'/'.$units->unt_small_image))
					if(!unlink(getcwd().'/'.$units->unt_small_image)){							
					//обработка ошибки удаления файла						
					}								
		}
		$data2 = $this->imagesmodel->get_image_all_data('units',$id,-1);
		foreach($data2 as $img){
			$photopath = getcwd().'/'.$img->img_src;
			if (file_exists($photopath))
				if(!unlink($photopath)){
			//обработка события если не удалился файл						
			}
		}
		$this->imagesmodel->image_type_delete('units',$id);
		$this->unitsmodel->delete_units($id);
		$this->session->set_userdata('msg','"Объект успешно удален"');
		redirect('admin/unitsview');
	}

	function unitsupdate(){
		
		if(empty($_POST['unitstitle']) or empty($_POST['unitsclient'])):
			redirect('admin/unitsedit'.$_POST['id']);
			return FALSE;
		endif;
		$config['upload_path'] = getcwd().'/images';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['remove_spaces'] = TRUE;
		$config['overwrite'] = TRUE;			
		$this->upload->initialize($config);
		if ($this->upload->do_upload()):
			$upload_data = $this->upload->data();			
			$_POST['userfile'] = 'images/'.$upload_data['file_name'];
			$_POST['smallimage'] = 'images/'.$upload_data['raw_name'].'_small'.$upload_data['file_ext'];
			if($_POST['oldphoto']!='images/unitsempty.png')
				if($_POST['oldphoto']!=$_POST['userfile'] and !empty($_POST['oldphoto'])):
					$photopath = getcwd().'/'.$_POST['oldphoto'];
					if(file_exists($photopath)) unlink($photopath);
					$photopath = getcwd().'/'.$_POST['oldsmallphoto'];
					if(file_exists($photopath)) unlink($photopath);
				endif;
			$this->image_lib->clear();
			$conf['image_library'] 	= 'gd2';
			$conf['source_image']	= $_POST['userfile']; 
			$conf['create_thumb'] 	= FALSE;
			$conf['maintain_ratio'] = TRUE;
			$conf['new_image'] 		= $_POST['smallimage'];
			$conf['width']	 		= 240;
			$conf['height']			= 160;
			$this->image_lib->initialize($conf); 
			$this->image_lib->resize();
			$this->image_lib->clear();
			$_POST['userfile'] = $this->createdoubleimage($_POST['userfile'],434,194);
			if(!$_POST['userfile'] or empty($_POST['userfile'])):
				$_POST['userfile'] = 'images/unitsempty.png';
				$_POST['smallimage'] = '';
			endif;
		else:
			$_POST['userfile'] = $_POST['oldphoto'];
			$_POST['smallimage'] = $_POST['oldsmallphoto'];
		endif;
		$this->session->set_userdata('msg','"Информация сохранена"');
		$this->unitsmodel->update_units($_POST);
		redirect('admin/unitsview');
	}
	
	/**************************************************************************************************************/
	
	function partnersview(){
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Администрирование | Список партнеров",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'partners'		=> $this->partnersmodel->get_arr_partners(),
						'pagename'		=> 'Список партнеров',
						'text'			=> $this->textmodel->get_data('partners'),
						'msg'			=> $this->session->userdata('msg')
					);
		$this->session->unset_userdata('msg');
		$this->load->view('admin_interface/partners_view',$pagevar);
	}
	
	function partnernew(){
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Администрирование | Добавление партнера",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'pagename'		=> 'Добавление партнера'
					);
		$this->load->view('admin_interface/partner_new',$pagevar);
	}
	
	function partnerinsert(){
		
		$this->form_validation->set_rules('partnername',' ','required|trim');
		$this->form_validation->set_rules('partnerhref',' ','trim');
		if(!$this->form_validation->run()):
			$this->partnernew();
			return FALSE;
		else:
			if(strncmp($_POST['partnerhref'],'#',1) != 0)
				if(strncmp(strtolower($_POST['partnerhref']),'http://',7) != 0)
					$_POST['partnerhref'] = 'http://'.$_POST['partnerhref'];
			$this->session->set_userdata('msg','"Партнер создан успашно"');
			$this->partnersmodel->insert_partner($_POST);
			redirect('admin/partnersview');
		endif;
	}
	
	function partnerinfo(){
		
		$data1 = array(
						'title' => "СК Стройковъ | Администрирование | Информация о партнере",
						'desc' => "\"\"",
						'keyword' => "\"\"",
						'baseurl' => base_url()
					);
		$id = $this->uri->segment(3);	
		$data2 = $this->partnersmodel->get_partner($id);
		if(!isset($data2) or empty($data2)) redirect('404');
		
		$this->load->view('partner_info',array('data1'=>$data1,'data2'=>$data2));
	}
	
	function partneredit(){
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Администрирование | Редактирование партнера",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'partner'		=>	$this->partnersmodel->get_partner($this->uri->segment(3)),
						'pagename'		=> 'Редактирование партнера'
					);
		if(!isset($pagevar['partner']) or empty($pagevar['partner'])) show_404();
    	$this->load->view('admin_interface/partner_edit',$pagevar);
	}
	
	function partnerdestroy(){
		
		$id = $this->uri->segment(3);
		$data2 = $this->partnersmodel->get_partner($id);
		if(!isset($data2) or empty($data2)) show_404();
		$this->session->set_userdata('msg','"Партнер удален успешно"');
		$this->partnersmodel->delete_partner($id);
		redirect('admin/partnersview');
	}

	function partnerupdate(){
		
		$this->partnersmodel->update_partner($_POST);
		$this->session->set_userdata('msg','"Информация сохранена"');
		redirect('admin/partnersview');
	}
	
	/**************************************************************************************************************/
	
	function emailsview(){
		
		$data1 = array(
						'title' => "СК Стройковъ | Администрирование | Просмотр писем",
						'desc' => "\"\"",
						'keyword' => "\"\"",
						'baseurl' => base_url()
					);
							
		$data2 = $this->inboxmailmodel->get_all_emails();
		
		foreach ($data2 as $data){
			
			$data->iml_date = $this->operation_date($data->iml_date);
		}
		
		$this->load->view('admin/imterface/emails_view',array('data1'=>$data1,'data2'=>$data2));
	}
	
	function emaildestroy(){
		
		$id = $this->uri->segment(3);
		$mail = $this->inboxmailmodel->get_mail($id);
		if(!isset($mail) or empty($mail)) redirect('404');
		
		$this->inboxmailmodel->delete_email($id);
		redirect('admin/emailsview');
	}

	/**************************************************************************************************************/

	function contactsview(){
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Администрирование | Контакты",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'contacts'		=> $this->contactsmodel->get_all_contacts(),
						'pagename'		=> 'Контакты',
						'msg'			=> $this->session->userdata('msg')
					);
		$this->session->unset_userdata('msg');
    	$this->load->view('admin_interface/contacts_view',$pagevar);
	}
	
	function contactedit(){
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Администрирование | Редактирование контактной информации",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'contacts'		=> $this->contactsmodel->get_contact($this->uri->segment(3)),
						'pagename'		=> 'Редактирование контактной информации'
					);
		if(!$pagevar['contacts']) show_404();
    	$this->load->view('admin_interface/contact_edit',$pagevar);
	}
	
	function contactdestroy(){
		
		redirect('404');
		return FALSE;
		//$id = $this->uri->segment(3);
		//$this->contactsmodel->delete_contact($id);
		//redirect('admin/contactsview');
	}
	
	function contactnew(){
	
		redirect('404');
		return FALSE;
		
	}
	
	function contactinsert(){
		
		redirect('404');
		return FALSE;
		
	}
	
	function contactupdate(){
		
		$this->contactsmodel->update_contact($_POST);
		$this->session->set_userdata('msg','"Информация сохранена"');
		redirect('admin/contactsview');
	}

	/**************************************************************************************************************/

	function profile(){
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Администрирование | Смена пароля",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'users'			=>  $this->authentication->get_users_info($this->session->userdata('login')),
						'pagename'		=> 'Контакты',
						'msg'			=> $this->session->userdata('msg')
					);
		$this->session->unset_userdata('msg');
    	$this->load->view('admin_interface/profile',$pagevar);
	}
	
	function profileupdate(){
		
		$this->form_validation->set_rules('oldpass','"Старый пароль"','required|callback_oldpass_check');
		$this->form_validation->set_rules('newpass','"Новый пароль"','required|matches[confirmpass]');
		$this->form_validation->set_rules('confirmpass','"Подтверждение пароля"','required');
		
		if(!$this->form_validation->run()):
			$this->profile();
			return FALSE;
		else:
			$_POST['pass_crypt'] = $this->encrypt->encode($_POST['newpass']);
			$this->authentication->changepassword($_POST);
			$this->session->set_userdata('msg','"Пароль изменен успешно"');
			redirect('admin/profile');
		endif;
	}
	
	/**************************************************************************************************************/
	
	function aboutedit(){
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Администрирование | О Компании",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'partners'		=> $this->partnersmodel->get_arr_partners(),
						'pagename'		=> 'О Компании',
						'text'			=> $this->aboutmodel->get_data(),
						'msg'			=> $this->session->userdata('msg')
					);
		$this->session->unset_userdata('msg');
		$this->session->set_userdata('img_alt','Строительная компания ООО Стройковъ');

    	$this->load->view('admin_interface/about_edit',$pagevar);
	}
	
	function aboutupdate(){
		
		$this->aboutmodel->update_data($_POST);
		$this->session->set_userdata('msg','"Информация сохранена"');
		redirect('admin/aboutedit');
	}
	
	/**************************************************************************************************************/
	
	function investmentview(){
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Администрирование | Проекты инвистиций",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'units'			=> array(),
						'pagename'		=> 'Проекты инвистиций',
						'text'			=> $this->textmodel->get_data('partners'),
						'msg'			=> $this->session->userdata('msg')
					);
		$this->session->unset_userdata('msg');
		$inv_data = $this->investmentmodel->get_all_data();
		$i = 0;
		foreach($inv_data as $inv):
			$pagevar['units'][$i]['id'] = $inv->inv_id;
			$pagevar['units'][$i]['name'] = $inv->inv_object_name;
			$i++;
		endforeach;
    	$this->load->view('admin_interface/investment_view',$pagevar);
	}
	
	function investmentedit(){
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Администрирование | Редактирование проекта",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'unit'			=> $this->investmentmodel->get_object_data($this->uri->segment(3)),
						'pagename'		=> 'Редактирование проекта'
					);
		if(!isset($pagevar['unit']) or empty($pagevar['unit'])) show_404();
		foreach($pagevar['unit'] as $inv):
			$this->session->set_userdata('img_alt',$inv->inv_object_name);
		endforeach;
    	$this->load->view('admin_interface/investment_edit',$pagevar);
	}
	
	function investmentupdate(){
		
		$this->investmentmodel->update_data($_POST);
		$this->session->set_userdata('msg','"Информация сохранена"');
		redirect('admin/investmentview');
	}
	
	function investmentnew(){
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Администрирование | Добавление проекта",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'pagename'		=> 'Добавление проекта'
					);
    	$this->load->view('admin_interface/investment_new',$pagevar);
	}
	
	function investmeninsert(){
		
		$this->form_validation->set_rules('objectname','"Название объекта инвестиции"','required');
		$this->form_validation->set_rules('investmentext','"Информация о инвестиционном проекте"','required');
		if(!$this->form_validation->run()):
			$this->investmentnew();
			return FALSE;
		else:
			$this->investmentmodel->insert_object_investment($_POST);
			$this->session->set_userdata('msg','"Объект создан успешно"');
			redirect('admin/investmentview');
		endif;
	}
	
	function investmentdestroy(){
		
		$id = $this->uri->segment(3);
		$inv = $this->investmentmodel->get_object_data($id);
		if(!isset($inv) or empty($inv)) show_404();
		
		$data3 = $this->imagesmodel->get_image_all_data('investment',$id,-1);
		foreach($data3 as $img):
			$photopath = getcwd().'/'.$img->img_src;
			if(file_exists($photopath)) !unlink($photopath);
		endforeach;
		$this->session->set_userdata('msg','"Объект удален успешно"');
		$this->imagesmodel->image_type_delete('investment',$id);
		$this->investmentmodel->delete_object($id);
		redirect('admin/investmentview');
	}
	
	/**************************************************************************************************************/
	
	function imagedelete($backpath){
		
		$pagevar = array(
							'title' 		=> "СК Стройковъ | Удаление картинок",
							'description' 	=> "\"Веб-сайт компания Стройковъ\"",
							'keywords' 		=> "\"Строительная компания Стройковъ\"",
							'baseurl' 		=> base_url(),
							'admin' 		=> $this->admin,
							'pagename'		=> 'Удаление картинок',
							'msg'			=> $this->session->userdata('msg')
					);
		$this->session->unset_userdata('msg');
		$path = '';			
		if(isset($_POST['path']))
			$path = $_POST['path'];
		
		if(!isset($backpath) or empty($backpath))$backpath = 'admin/'.$path;
		else $backpath = 'admin/'.$backpath;
		switch($backpath){
			case 'admin/aboutedit':$type = 'about';$object = 0;break;
			case 'admin/investmentedit':$backpath = $backpath.'/'.$this->uri->segment(3);$type = 'investment';
								$object = $this->uri->segment(3); break;
			case 'admin/unitsedit':$backpath = $backpath.'/'.$this->uri->segment(3);$type = 'units';$object = $this->uri->segment(3);break;
			case 'admin/subsectionedit':$backpath = 'admin/companyedit/'.$this->uri->segment(3).'/subsections';
								$type = 'subsection';$object = $this->uri->segment(6); break;
			case 'admin/companyedit':$backpath = $backpath.'/'.$this->uri->segment(3);
					$type = 'company';$object = $this->uri->segment(3); break;
			default: $type = 'default';$object = 0; break;
		}
		$data3 = $this->imagesmodel->get_data($type,$object);
		$pagevar['backpath'] = $backpath;
		$pagevar['images'] = $data3;
		$pagevar['type'] = $type;
		$this->load->view('admin_interface/image_delete',$pagevar);
	}
	
	function imagedestroy(){
		
		$id = $this->uri->segment(3);
		if($this->uri->total_segments()<=6){
			$back_metod = $this->uri->segment(5);
			$back_id = $this->uri->segment(6);
			$redirect = 'admin/'.$back_metod.'/imagedelete';
			if (!empty($back_id))
			$redirect = 'admin/'.$back_metod.'/'.$back_id.'/imagedelete';
		}
		if($this->uri->total_segments() == 9){
			$back_metod = $this->uri->segment(5);
			$back_id = $this->uri->segment(6);
			$extend = $this->uri->segment(7).'/'.$this->uri->segment(8).'/'.$this->uri->segment(9);;
			$redirect = 'admin/'.$back_metod.'/'.$extend.'/imagedelete';
			if (!empty($back_id))
			$redirect = 'admin/'.$back_metod.'/'.$back_id.'/'.$extend.'/imagedelete';
		}
		$photoinfo = $this->imagesmodel->get_image($id);
		foreach($photoinfo as $photo){
			$photopath = getcwd().'/'.$photo->img_src;
		}
		$this->imagesmodel->image_delete($id);
		if (file_exists($photopath))
			if(!unlink($photopath)){
			//обработка события если не удалился файл						
		}
		$this->session->set_userdata('msg','"Фотография удалена успешно!"');
		redirect($redirect);
	}

	function otherimagedelete($id,$model){
		
		$img = $this->{$model}->get_image_data($id);

		if(isset($img) and !empty($img)){
			$photopath = getcwd().'/'.$img;
			if (file_exists($photopath))
				if(!unlink($photopath)){
				//обработка события если не удалился файл						
			}
		}
	}
	
	/**************************************************************************************************************/
	
	function textedit(){
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Администрирование | Редактирование текста",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'pagename'		=> 'Редактирование текста',
						'text'			=> $this->textmodel->get_record($this->uri->segment(3))
					);
		$this->load->view('admin_interface/text_edit',$pagevar);
	}
	
	function textupdate(){
		
		$redirect = 'admin/'.$_POST['type'].'view';
		$this->textmodel->update_data($_POST);
		$this->session->set_userdata('msg','"Информация сохранена"');
		redirect($redirect);
	}
	
	/**************************************************************************************************************/
	
	function priceview(){
		
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Администрирование | Просмотр прайс-листа",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'pagename'		=> 'Редактирование текста',
						'price'			=> $this->textmodel->get_data('price'),
						'msg'			=> $this->session->userdata('msg')
					);
		$this->session->unset_userdata('msg');
		$this->load->view('admin_interface/price_view',$pagevar);
	}
	
	/**************************************************************************************************************/
	
	function subsection_create($backpath){
		
		if(!isset($backpath) or empty($backpath))
			$backpath = $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);	
		
		$pagevar = array(
						'title' => "СК Стройковъ | Добавление подраздела",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'backpath' 		=> $backpath,
						'pagename'		=> 'Добавление подраздела'
					);
		$this->load->view('admin_interface/subsection_new',$pagevar);
	}
	
	function subsectioninsert(){
		
		$this->form_validation->set_rules('sbstitle', '"Название подраздела"', 'required');
		$this->form_validation->set_rules('sbstext', '"Описание подраздела"', 'required');
		if(!$this->form_validation->run()):
			$this->subsection_create($_POST['backpath']);
		else:
			$config['upload_path'] = getcwd().'/images';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['remove_spaces'] = TRUE;
			$config['overwrite'] = FALSE;			
			$this->upload->initialize($config);
			if($this->upload->do_upload()):
				$upload_data = $this->upload->data();			
				$_POST['userfile'] = 'images/'.$upload_data['file_name'];
				$_POST['userfile'] = $this->createimage($_POST['userfile'],240,160);
				if(!$_POST['userfile'] or empty($_POST['userfile'])):
					$_POST['userfile'] = '';
					$_POST['sbsimgalt'] = '';
				endif;
			else:
				$_POST['userfile'] = '';
				$_POST['sbsimgalt'] = '';	
			endif;
			$this->subsectionmodel->insert_record($_POST);
			$this->session->set_userdata('msg','"Подраздел создан успешно"');
			redirect('admin/companyedit/'.$_POST['cmpid'].'/subsections');
		endif;
	}

	function subsection_edit($backpath){
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Редактирование подраздела",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'subsections'	=> $this->subsectionmodel->get_id_data($this->uri->segment(6)),
						'pagename'		=> 'Редактирование подраздела'
					);
		if(!$pagevar['subsections']) show_404();
		
		$this->session->set_userdata('img_alt',$pagevar['subsections']['sbs_title']);
		$this->load->view('admin_interface/subsection_edit',$pagevar);
	}
	
	function subsection_destroy(){
		
		$sbs_id = $this->uri->segment(6);
		$sbs = $this->subsectionmodel->get_id_data($sbs_id);
		if(!isset($sbs) or empty($sbs)) show_404();
		$sbsimg = $this->imagesmodel->get_image_all_data('subsection',$sbs_id,-1);
		foreach($sbsimg as $img):
			$photopath = getcwd().'/'.$img->img_src;
			if (file_exists($photopath)):
				unlink($photopath);
			endif;
		endforeach;
		$this->imagesmodel->image_type_delete('subsection',$sbs_id);
		$this->otherimagedelete($sbs_id,'subsectionmodel');
		$this->subsectionmodel->delete_record($sbs_id);
		$this->session->set_userdata('msg','"Подраздел удален успешно"');
		redirect('admin/companyedit/'.$this->uri->segment(3).'/subsections');
	}
	
	function subsectionupdate(){
		
		if(isset($_POST['sbsimgdel']) and !empty($_POST['sbsimgdel'])):
			$this->otherimagedelete($_POST['id'],'subsectionmodel');
			$_POST['userfile'] = '';
			$_POST['sbsimgalt'] = '';
		else:
			$config['upload_path'] = getcwd().'/images';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['remove_spaces'] = TRUE;
			$config['overwrite'] = TRUE;			
			$this->upload->initialize($config);
			if($this->upload->do_upload()):
				$upload_data = $this->upload->data();			
				$_POST['userfile'] = 'images/'.$upload_data['file_name'];
				if($_POST['oldphoto']!=$_POST['userfile'] and !empty($_POST['oldphoto'])):
					$photopath = getcwd().'/'.$_POST['oldphoto'];
					if (file_exists($photopath)):
						unlink($photopath);
					endif;
				endif;
				$_POST['userfile'] = $this->createimage($_POST['userfile'],240,160);
				if(!$_POST['userfile'] or empty($_POST['userfile'])):
					$_POST['userfile'] = $_POST['oldphoto'];
				endif;
			else:
				$_POST['userfile'] = $_POST['oldphoto'];
			endif;
		endif;
		$this->subsectionmodel->update_record($_POST);
		$this->session->set_userdata('msg','"Информация сохранена"');
		redirect('admin/companyedit/'.$_POST['cmpid'].'/subsections'); 
	}

	function subsections(){
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Список подразделов",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'subsections'	=> $this->subsectionmodel->get_cmp_data($this->uri->segment(3)),
						'pagename'		=> 'Список подразделов',
						'msg'			=> $this->session->userdata('msg')
					);
		$this->session->unset_userdata('msg');
		$this->load->view('admin_interface/subsections_view',$pagevar);
	}
	
	/**************************************************************************************************************/

	function operation_date($field){
		
		$list = preg_split("/-/",$field);
		$nmonth = $this->months[$list[1]];
		$pattern = "/(\d+)(-)(\w+)(-)(\d+)/i";
		$replacement = "\$5 $nmonth \$1 г."; 
		return preg_replace($pattern, $replacement,$field);
	}
	
	function change_extension_png($filepath){
	
		return preg_replace("/(.+)\.([^\.]+)$/", "$1.png",$filepath);
	}

	function change_ext_delete($filepath){
	
		if(!empty($filepath) and file_exists(getcwd().'/'.$filepath))
			if(!unlink(getcwd().'/'.$filepath)){							
				return FALSE;						
			}
		return preg_replace("/(.+)\.([^\.]+)$/", "$1.png",$filepath);
	}

	function operation_date_slash($field){
		
		$list = preg_split("/-/",$field);
		$nmonth = $this->months[$list[1]];
		$pattern = "/(\d+)(-)(\w+)(-)(\d+)/i";
		$replacement = "\$5/\$3/\$1"; 
		return preg_replace($pattern, $replacement,$field);
	}
	
	function operation_date_dot($field){
		
		$list = preg_split("/-/",$field);
		$nmonth = $this->months[$list[1]];
		$pattern = "/(\d+)(-)(\w+)(-)(\d+)/i";
		$replacement = "\$5.\$3.\$1"; 
		return preg_replace($pattern, $replacement,$field);
	}
	
	function url_check($url){
	
		$cmp = $this->companymodel->get_cmp_by_url($url);
		if($cmp):
			$this->form_validation->set_message('url_check','Псевдонним существует');
			$this->session->set_userdata('msg','"Псевдонним существует"');
			return FALSE;
		endif;
		return TRUE;
	}
	
	function userfile_check($file){
		
		$tmpName = $_FILES['userfile']['tmp_name'];
		
		if($_FILES['userfile']['error'] != 4):
			if(!$this->case_image($tmpName)):
				$this->form_validation->set_message('userfile_check','Формат не поддерживается');
				$this->session->set_userdata('msg','"Формат не поддерживается"');
				return FALSE;
			endif;
		endif;
		if($_FILES['userfile']['error'] == 1):
			$this->form_validation->set_message('userfile_check','Размер более 5 Мб!');
			$this->session->set_userdata('msg','"Размер более 5 Мб!"');
			return FALSE;
		endif;
		return TRUE;
	}
	
	function case_image($file){
			
		$info = getimagesize($file);
		switch ($info[2]):
			case 1	: return TRUE;
			case 2	: return TRUE;
			case 3	: return TRUE;
			default	: return FALSE;	
		endswitch;
	}
	
	function oldpass_check($pass){
		
		$login = $this->session->userdata('login');
		$userinfo = $this->authentication->get_users_info($login);
		if(md5($pass) == $userinfo['usr_password']):
			return TRUE;
		else:
			$this->form_validation->set_message('oldpass_check', 'Введен не верный пароль!');
			$this->session->set_userdata('msg','"Введен не верный пароль!"');
			return FALSE;
		endif;
	}
	
	function cropimage_to_png($image,$image_src,$size_x,$size_y,$retwight,$retheight){
		
		$wight = $retwight;
		$height = $retheight; 

		if($size_x >= $size_y){
			
			$this->image_lib->clear();
			$config['image_library'] = 'gd2';
			$config['source_image']	= $image; 
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 450;
			$config['height'] = 350;
						
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			
			$image_src = $this->open_image($image);
		
			$size_x = imageSX($image_src);
			$size_y = imageSY($image_src);

			if($size_x < $retwight){
				
				$this->resize_img($image,450,$size_y,FALSE);
				
				imagedestroy($image_src);
				$image_src = $this->open_image($image);
				
				$size_x = imageSX($image_src);
				$size_y = imageSY($image_src);
				
			}elseif($size_y < $retheight){
			
				$this->resize_img($image,$retwight,$retheight,FALSE);
				
				imagedestroy($image_src);
				$image_src = $this->open_image($image);
				
				$size_x = imageSX($image_src);
				$size_y = imageSY($image_src);
			}
			
			$x = ($size_x/2)-($retwight/2);
			$y = ($size_y/2)-($retheight/2);
			
			if($x < 0 ){
				$x =0;	$wight = $size_x;
			}
			if($y < 0 ){
				 $y =0; $height = $size_y;
			}
			
		}elseif($size_y >= $size_x){
			
			$this->image_lib->clear();
			$config['image_library'] = 'gd2';
			$config['source_image']	= $image; 
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 450;
			$config['height'] = 350;
						
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			
			$image_src = $this->open_image($image);
			
			$size_x = imageSX($image_src);
			$size_y = imageSY($image_src);

			if($size_x < $retwight){
				
				$this->resize_img($image,$retwight,$size_y,FALSE);
				
				imagedestroy($image_src);
				$image_src = $this->open_image($image);
				
				$size_x = imageSX($image_src);
				$size_y = imageSY($image_src);
				
			}elseif($size_y < $retheight){
			
				$this->resize_img($image,$retwight,$retheight,FALSE);
				
				imagedestroy($image_src);
				$image_src = $this->open_image($image);
				
				$size_x = imageSX($image_src);
				$size_y = imageSY($image_src);
			}
			
			$x = ($size_x/2)-($retwight/2);
			$y = ($size_y/2)-($retheight/2);
			
			if($x < 0 ){
				$x =0;	$wight = $size_x;
			}
			if($y < 0 ){
				 $y =0; $height = $size_y;
			}
		}
		
		$image = $this->change_ext_delete($image);
		
		$image_dst = ImageCreateTrueColor($wight,$height);
		imageCopy($image_dst,$image_src,0,0,$x,$y,$size_x,$size_y);
		imagePNG($image_dst,$image);
		imagedestroy($image_dst);
		imagedestroy($image_src);
		
		return $image;
	}
	
	function createdoubleimage($image,$retwight,$retheight){
		
		if(!isset($image) or empty($image)){
		
			$this->msg = 'файл не определен или передан пустой параметр!';
			return FALSE;
		}
		
		if(!$image_src = $this->open_image($image)){
			$this->msg = 'не пойму изображение';
			return FALSE;
		}				
		$size_x = imageSX($image_src);
		$size_y = imageSY($image_src);
		
		$ratio = 0;
		
		if ($size_x > $size_y){
			if ($size_x / $size_y >=2.1 and $size_x / $size_y <=2.3){
				
				$ratio = 1;
				$this->resize_img($image,$retwight,$retheight,FALSE);
			}
		}
		if($ratio == 0)		
			if ($size_x >= $retwight or $size_y >= $retheight){
				$image = $this->cropimage_to_png($image,$image_src,$size_x,$size_y,$retwight,$retheight);
				
			}else{
				$this->resize_img($image,$retwight,$retheight,FALSE);
			}
		
		imagedestroy($image_src);
		$image_src = $this->open_image($image);
		$size_x = imageSX($image_src);
		$size_y = imageSY($image_src);
		
		$image_dst = ImageCreateTrueColor($retwight,$retheight*2);
		imageCopy($image_dst,$image_src,0,$size_y,0,0,$size_x,$size_y);
		
		$bwimage= imagecreate($size_x,$size_y);
		for ($i = 0; $i < 256; $i++){
			$palette[$i] = imagecolorallocate($bwimage,$i,$i,$i);
		}
		
		for ($y = 0; $y < $size_y; $y++){
			for ($x = 0; $x < $size_x; $x++){
				
				$rgb = imagecolorat($image_src,$x,$y);
				$r = ($rgb >> 16) & 0xFF;
				$g = ($rgb >> 8) & 0xFF;
				$b = $rgb & 0xFF;
				$gs = $this->yiq($r,$g,$b);
				imagesetpixel($bwimage,$x,$y,$palette[$gs]);
			}
		}
						
		imageCopy($image_dst,$bwimage,0,0,0,0,$size_x,$size_y);
		imagePNG($image_dst,$image);
		imagedestroy($image_dst);
		imagedestroy($image_src);
		imagedestroy($bwimage);
			
		return $image; 
	}
	
	function resize_img($image,$wgt,$hgt,$ratio){
		
		$this->image_lib->clear();
		$config['image_library'] = 'gd2';
		$config['source_image']	= $image; 
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = $ratio;
		$config['width'] = $wgt;
		$config['height'] = $hgt;
				
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
	}
	
	function yiq($r,$g,$b){
	
		return (($r*0.299)+($g*0.587)+($b*0.114));
	}
	
	function open_image($file){
		
		$info = getimagesize($file);
		
		switch ($info[2]){
			case 1: $im = imagecreatefromgif($file); break;
			case 2: $im = imagecreatefromjpeg($file); break;
			case 3:	$im = imagecreatefrompng($file); break;
			default: return FALSE;	
		}
		
		return $im;
	}

	function createimage($image,$retwight,$retheight){
		
		if(!isset($image) or empty($image)){
		
			$this->msg = 'файл не определен или передан пустой параметр!';
			return FALSE;
		}
		
		if(!$image_src = $this->open_image($image)){
			$this->msg = 'не пойму изображение';
			return FALSE;
		}				
		$size_x = imageSX($image_src);
		$size_y = imageSY($image_src);
		
		if ($size_x > $size_y){
			$this->resize_img($image,$retwight,$retheight,TRUE);
		}else{
			$this->resize_img($image,$retheight,$retwight,TRUE);
		}
		imagedestroy($image_src);
			
		return $image;
	}
	
	function uploadimage($backpath){
			
			$pagevar = array(
							'title' 		=> "СК Стройковъ | Загрузка картинок",
							'description' 	=> "\"Веб-сайт компания Стройковъ\"",
							'keywords' 		=> "\"Строительная компания Стройковъ\"",
							'baseurl' 		=> base_url(),
							'admin' 		=> $this->admin,
							'pagename'		=> 'Загрузка картинок',
							'msg'			=> $this->session->userdata('msg')
					);
			$this->session->unset_userdata('msg');
			$path = '';			
			if(isset($_POST['path'])) $path = $_POST['path'];
			if(!isset($backpath) or empty($backpath)) $backpath = 'admin/'.$path;
			else $backpath = 'admin/'.$backpath;
			$data3 = array('msg' => '','type' => '');
			switch($backpath){
				case 'admin/aboutedit': {
						$data3['msg'] = 'Диплом, грамота, письмо. (Цвет. 120x160)';
						$data3['path'] = 'aboutedit';
						$data3['type'] = 'about';
						$data3['form'] = 'admin/aboutedit/upload';
						} break;
				case 'admin/investmentedit': {
							$data3['msg'] = 'Фото инвестиционного проекта (Цвет. 640x480|480x640)';
							$data3['path'] = 'investmentedit';
							$data3['type'] = 'investment';
							$data3['form'] = 'admin/investmentedit/'.$this->uri->segment(3).'/upload';
							$backpath = $backpath.'/'.$this->uri->segment(3);
							} break;
				case 'admin/unitsedit': {
							$data3['msg'] = 'Фото объекта (Цвет. 640x480|480x640)';
							$data3['path'] = 'unitsedit';
							$data3['type'] = 'units';
							$data3['form'] = 'admin/unitsedit/'.$this->uri->segment(3).'/upload';
							$backpath = $backpath.'/'.$this->uri->segment(3);
							} break;
				case 'admin/subsectionedit':{
							$data3['msg'] = 'Фото подраздела (Цвет. 640x480|480x640)';
							$data3['path'] = 'subsectionedit';
							$data3['type'] = 'subsection';
							$data3['form'] = 'admin/companyedit/'.$this->uri->segment(3).'/subsection/edit/'.$this->uri->segment(6).'/upload';
							$backpath = 'admin/companyedit/'.$this->uri->segment(3).'/subsections';
						}break;
				case 'admin/companyedit': {
							$data3['msg'] = 'Фото компании (Цвет. 640x480|480x640)';
							$data3['path'] = 'companyedit';
							$data3['type'] = 'company';
							$data3['form'] = 'admin/companyedit/'.$this->uri->segment(3).'/upload';
							$backpath = $backpath.'/'.$this->uri->segment(3);
							} break;
				default: {
						$data3['msg'] = '(Цвет.+ч/б. 434x194|194x434)';
						$data3['path'] = '';
						$data3['type'] = 'default';
						$data3['form'] = 'admin/uploadimage';
						}
						break;
			}
			if(isset($_POST['btsabmit'])){
				$_POST['btsabmit'] = NULL;
				$config['upload_path'] = getcwd().'/images/upload/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['remove_spaces'] = TRUE;
				$config['overwrite'] = FALSE;			
				$this->upload->initialize($config);
				if ($this->upload->do_upload()){    
					$upload_data = $this->upload->data();			
					$userfile = 'images/upload/'.$upload_data['file_name'];
					if(!isset($_POST['imagetitle']) or empty($_POST['imagetitle']))
						$_POST['imagetitle'] = $this->session->userdata('img_alt');
					switch($data3['path']){
							case '':{
									$_POST['file'] = $this->createdoubleimage($userfile,434,194);
									$_POST['object'] = 0;
									$_POST['imagetitle'] = 'Строительная компания ООО Стройковъ';
									}; break;
						case 'aboutedit':{
									 $_POST['file'] = $this->createimage($userfile,160,120);
									 $_POST['object'] = 0;
									 }; break;
						case 'investmentedit':{
									 $_POST['file'] = $this->createimage($userfile,640,480);
									 $_POST['object'] = $this->uri->segment(3);
									 } break;
						case 'unitsedit':{
									 $_POST['file'] = $this->createimage($userfile,640,480);
									 $_POST['object'] = $this->uri->segment(3);
									 } break;
			  case 'subsectionedit': {
			  					     $_POST['file'] = $this->createimage($userfile,640,480);
									 $_POST['object'] = $this->uri->segment(6);
									 } break;
				case 'companyedit': {
			  					     $_POST['file'] = $this->createimage($userfile,640,480);
									 $_POST['object'] = $this->uri->segment(3);
									 } break;
					}
					$this->imagesmodel->insert_record($_POST);
					$imgname = $this->change_extension_png($upload_data['file_name']);
					$this->session->set_userdata('msg','"Загрузка выполнилась успешно!"');
					redirect($this->uri->uri_string());
				}
			}
			$pagevar['backpath'] = $backpath;
			$pagevar['settings'] = $data3;
			$this->load->view('admin_interface/upload_image',$pagevar);
		}
}
?>