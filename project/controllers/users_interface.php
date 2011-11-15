<?php
class Users_interface extends CI_Controller{
	
	var $admin = array('status'=>FALSE);
	var $months = array("01"=>"января","02"=>"февраля","03"=>"марта","04"=>"апреля","05"=>"мая","06"=>"июня","07"=>"июля",
					"08"=>"августа","09"=>"сентября","10"=>"октября","11"=>"ноября","12"=>"декабря");
		
	function __construct(){
	
		parent::__construct();
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
		if($this->session->userdata('logon') == '76f1847d0a99a57987156534634a1acf') $this->admin['status'] = TRUE;
	}
	
	function index(){

		$pagevar = array(
						'title' 		=> "СК Стройковъ | Строительная компания Стройковъ",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'news' 			=> $this->newsmodel->get_news_in_main_page(),
						'company'		=> $this->companymodel->get_all_company(),
						'contacts'		=> $this->contactsmodel->get_all_contacts()
					);
		for($i=0;$i<count($pagevar['news']);$i++):
			$pagevar['news'][$i]['nws_header'] = strip_tags($pagevar['news'][$i]['nws_header'],'<img>, <a>');
			$pagevar['news'][$i]['nws_header'] = preg_replace('/w\d{2,3}/','w90',$pagevar['news'][$i]['nws_header']);
			$pagevar['news'][$i]['nws_header'] = preg_replace('/news_id/',$pagevar['news'][$i]['nws_id'],$pagevar['news'][$i]['nws_header']);
			$pagevar['news'][$i]['nws_body'] = strip_tags($pagevar['news'][$i]['nws_body']);
			
			$pagevar['news'][$i]['full_body'] = $pagevar['news'][$i]['nws_body'];
			if(mb_strlen($pagevar['news'][$i]['nws_body'],'UTF-8') > 500):									
				$pagevar['news'][$i]['nws_body'] = mb_substr($pagevar['news'][$i]['nws_body'],0,500,'UTF-8');	
				$pos = mb_strrpos($pagevar['news'][$i]['nws_body'],' ',0,'UTF-8');
				$pagevar['news'][$i]['nws_body'] = mb_substr($pagevar['news'][$i]['nws_body'],0,$pos,'UTF-8');
				$pagevar['news'][$i]['nws_body'] .= ' ... ';
			endif;
		endfor;
		$this->load->view('users_interface/index',$pagevar);
	}
	
	function about(){
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | О компании Стройковъ",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'about'			=> $this->aboutmodel->get_data(),
						'images'		=> $this->imagesmodel->get_data('about',0),
						'contacts'		=> $this->contactsmodel->get_all_contacts()
					);
		$this->load->view('users_interface/about',$pagevar);
	}
	
	function price(){
	
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Прайс-лист",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'text'			=> $this->textmodel->get_data('price'),
						'contacts'		=> $this->contactsmodel->get_all_contacts()
					);
		$this->load->view('users_interface/price',$pagevar);
	}
	
	function partners(){
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Прайс-лист",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'text'			=> $this->textmodel->get_data('partners'),
						'partners'		=> array(),
						'count'			=> 0,
						'contacts'		=> $this->contactsmodel->get_all_contacts()
					);
		
		$pagevar['count'] = $this->partnersmodel->count_records();
		$from = 0;
		for($i=0;$i<$pagevar['count']/10;$i++):
			$pagevar['partners'][$i] = $this->partnersmodel->get_limit_partners(10,$from);
			$from+=10;
		endfor;
		$this->load->view('users_interface/partners',$pagevar);			
	}
	
	function investment(){
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Инвестиции",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'investment'	=> array(),
						'images'		=> array(),
						'contacts'		=> $this->contactsmodel->get_all_contacts()
					);
		$inv_data = $this->investmentmodel->get_all_data();
		$i = 0;
		foreach($inv_data as $inv):
			$pagevar['investment'][$i]['inv_id'] = $inv->inv_id;
			$pagevar['investment'][$i]['inv_object_name'] = $inv->inv_object_name;
			$pagevar['investment'][$i]['inv_text'] = $inv->inv_text;
			
			$inv_img_data = $this->imagesmodel->get_type_ones_image('investment',$inv->inv_id);
			foreach($inv_img_data as $inv_img){
				$pagevar['investment'][$i]['id'] = $inv_img->img_id;
				$pagevar['investment'][$i]['image'] = $pagevar['baseurl'].$inv_img->img_src;
				$pagevar['investment'][$i]['title'] = $inv_img->img_title;
			}
			if(isset($pagevar['investment'][$i]['id']) and !empty($pagevar['investment'][$i]['id'])):
				$inv_obj_img = $this->imagesmodel->get_image_all_data('investment',$inv->inv_id,$pagevar['investment'][$i]['id']);
			else:
				$inv_obj_img = $this->imagesmodel->get_image_all_data('investment',$inv->inv_id,-1);
			endif;
			$j = 0;
			foreach($inv_obj_img as $obj_img):
				$pagevar['images'][$i][$j]['id'] = $obj_img->img_id;
				$pagevar['images'][$i][$j]['image'] = $pagevar['baseurl'].$obj_img->img_src;
				$pagevar['images'][$i][$j]['title'] = $obj_img->img_title;
				$j++;
			endforeach;
			$pagevar['investment'][$i]['index'] = $j;
			$i++;
		endforeach;
    	$this->load->view('users_interface/investment',$pagevar);
	}
	
	function units(){
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Объекты",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'units'			=> $this->unitsmodel->get_limit_units(4,0),
						'ucount'		=> $this->unitsmodel->count_records(),
						'ucntrow'		=> 0,
						'contacts'		=> $this->contactsmodel->get_all_contacts(),
						'list'			=> array()
					);
		
		$listunits = $this->unitsmodel->get_all_units();
		
		($pagevar['ucount']%3==1)? $pagevar['ucntrow']=round($pagevar['ucount']/3)+1 : $pagevar['ucntrow']=round($pagevar['ucount']/3);
		if($pagevar['ucount'] <= 3) $pagevar['ucntrow'] = 1;
		
		$k=0;
		for($i=0;$i<3;$i++):
			for($j=0;$j<$pagevar['ucntrow'];$j++):
				if($k>$pagevar['ucount']-1) break;
				$pagevar['list'][$i][$j]['id'] = $listunits[$k]['unt_id'];
				$pagevar['list'][$i][$j]['unt_client'] = $listunits[$k]['unt_client'];
				$k++;
			endfor;
		endfor;	
		$this->load->view('users_interface/units',$pagevar);
	}
	
	function contacts(){
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Контакты",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'contacts'		=> $this->contactsmodel->get_all_contacts()
					);
		$this->load->view('users_interface/contacts',$pagevar);
	}

	function newsviewslist(){
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Новости",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'news'			=> array(),
						'count'			=> $this->newsmodel->count_records(),
						'contacts'		=> $this->contactsmodel->get_all_contacts(),
						'pages'			=> array()
					);
					
		$config['base_url'] = base_url().'/news';
    	$config['total_rows'] = $pagevar['count'];
    	$config['per_page'] =  5;
    	$config['num_links'] = 2;
    	$config['uri_segment'] = 2;
		$config['first_link'] = 'В начало';
		$config['last_link'] = 'В конец';
		$config['next_link'] = 'Далее &raquo;';
		$config['prev_link'] = '&laquo; Назад';
		$config['cur_tag_open'] = '<b>';
		$config['cur_tag_close'] = '</b>';
					
		$from = intval($this->uri->segment(2));			
		$pagevar['news']['query'] = $this->newsmodel->get_news_limit_records(5,$from);
		
		foreach ($pagevar['news']['query'] as $data):
			$data->nws_date = $this->operation_date($data->nws_date);
		endforeach;			
		$this->pagination->initialize($config);
		$pagevar['pages'] = $this->pagination->create_links();
			
		$this->load->view('users_interface/newslist',$pagevar);
	}
	
	function operation_date($field){
		
		$list = preg_split("/-/",$field);
		$nmonth = $this->months[$list[1]];
		$pattern = "/(\d+)(-)(\w+)(-)(\d+)/i";
		$replacement = "\$5 $nmonth \$1"; 
		return preg_replace($pattern, $replacement,$field);
	}
	
	function viewonesnews(){
		
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Новости",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'news'			=> $this->newsmodel->get_news($this->uri->segment(2)),
						'contacts'		=> $this->contactsmodel->get_all_contacts()
					);
								
		if(!$pagevar['news']) show_404();
		
		foreach ($pagevar['news'] as $news):							
			$news->nws_date = $this->operation_date($news->nws_date);
		endforeach;
						
		$this->load->view('users_interface/news_ones_view',$pagevar);
	}
	
	function companyinfo(){
		
		$pagevar = array(
						'title' 		=> "Дизайн интерьеров | Ремонт квартир и офисов в Ростове-на-Дону | Все виды строительных и отделочных работ",
						'description' 	=> "Дизайн интерьера квартир, ремонт и отделка квартир и офисов в Ростове-на-Дону: косметический, капитальный, элитный ремонт. Капительное и жилищное строительство. Все виды строительных работ.",
						'keywords' 		=> "ремонт, ремонт квартир, ремонт офисов, дизайн интерьеров, отделочные работы, строительство, отделка помещений",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'company'		=> $this->companymodel->get_cmp_by_url($this->uri->segment(1)),
						'contacts'		=> $this->contactsmodel->get_all_contacts(),
						'images'		=> array(),
						'subsection'	=> array(),
						'sbsimages'		=> array()
					);
		if(!isset($pagevar['company']['cmp_id'])) show_404();
		 
		$sbs_img = $this->imagesmodel->get_type_ones_image('company',$pagevar['company']['cmp_id']);
		foreach($sbs_img as $img):
			$pagevar['company']['slideshow_img_src'] = $img->img_src;
			$pagevar['company']['slideshow_img_title'] = $img->img_title;
			$pagevar['company']['slideshow_img_id'] = $img->img_id;
		endforeach;
		$i = 0;
		if(isset($pagevar['company']['slideshow_img_id']) and !empty($pagevar['company']['slideshow_img_id'])):
			$imglist = $this->imagesmodel->get_image_all_data('company',$pagevar['company']['cmp_id'],$pagevar['company']['slideshow_img_id']);
			foreach($imglist as $list):
				$pagevar['images'][$i]['id'] = $list->img_id;
				$pagevar['images'][$i]['image'] = $list->img_src;
				$pagevar['images'][$i]['title'] = $list->img_title;
				$i++;
			endforeach;
		endif;
		$pagevar['company']['index'] = $i;
	/* ------------------------------------------------------------------------ */	
		$pagevar['subsection'] = $this->subsectionmodel->get_cmp_data($pagevar['company']['cmp_id']);
		if($pagevar['subsection']):
			for($i = 0; $i < count($pagevar['subsection']); $i++){
				$sbs_img[$i] = $this->imagesmodel->get_type_ones_image('subsection',$pagevar['subsection'][$i]['sbs_id']);
				foreach($sbs_img[$i] as $img){
					$pagevar['subsection'][$i]['slideshow_img_src'] = $img->img_src;
					$pagevar['subsection'][$i]['slideshow_img_title'] = $img->img_title;
					$pagevar['subsection'][$i]['slideshow_img_id'] = $img->img_id;
				}
				$j = 0;
				if(isset($pagevar['subsection'][$i]['slideshow_img_id']) and !empty($pagevar['subsection'][$i]['slideshow_img_id'])){
					$imglist = $this->imagesmodel->get_image_all_data('subsection',$pagevar['subsection'][$i]['sbs_id'],$pagevar['subsection'][$i]['slideshow_img_id']);			
	
					foreach($imglist as $list){
						$pagevar['sbsimages'][$i][$j]['id'] = $list->img_id;
						$pagevar['sbsimages'][$i][$j]['image'] = $list->img_src;
						$pagevar['sbsimages'][$i][$j]['title'] = $list->img_title;
						$j++;
					}
				}
				$pagevar['subsection'][$i]['index'] = $j;
			}
		endif;
		$this->load->view('users_interface/company',$pagevar);
	}

	function unitsinfo(){
	
		$id = $this->uri->segment(2);
		$pagevar = array(
						'title' 		=> "СК Стройковъ | Объекты",
						'description' 	=> "\"Веб-сайт компания Стройковъ\"",
						'keywords' 		=> "\"Строительная компания Стройковъ\"",
						'baseurl' 		=> base_url(),
						'admin' 		=> $this->admin,
						'unit'			=> $this->unitsmodel->get_units($id),	
						'images'		=> array(),
						'contacts'		=> $this->contactsmodel->get_all_contacts()
					);
		if(!$pagevar['unit']) show_404();
		$unit_data = $this->unitsmodel->get_units($id);
		foreach($unit_data as $units):
			$pagevar['unit']['id'] = $units->unt_id;
			$pagevar['unit']['title'] = $units->unt_title;
			$pagevar['unit']['client'] = $units->unt_client;
			$pagevar['unit']['body'] = $units->unt_body;
			$pagevar['unit']['small_image'] = $units->unt_small_image;
			$pagevar['unit']['img_alt'] = $units->unt_img_alt;
			$img_data = $this->imagesmodel->get_type_ones_image('units',$units->unt_id);
			foreach($img_data as $img):
				$pagevar['unit']['img_id'] = $img->img_id;
				$pagevar['unit']['img_src'] = $pagevar['baseurl'].$img->img_src;
				$pagevar['unit']['img_title'] = $img->img_title;
			endforeach;
			if(isset($pagevar['unit']['img_id']) and !empty($pagevar['unit']['img_id'])):
				$imglist = $this->imagesmodel->get_image_all_data('units',$units->unt_id,$pagevar['unit']['img_id']);
			else:
				$imglist = $this->imagesmodel->get_image_all_data('units',$units->unt_id,-1);
			endif;
			$j = 0;
			foreach($imglist as $list):
				$pagevar['images'][$j]['id'] = $list->img_id;
				$pagevar['images'][$j]['image'] = $pagevar['baseurl'].$list->img_src;
				$pagevar['images'][$j]['title'] = $list->img_title;
				$j++;
			endforeach;
			$pagevar['unit']['index'] = $j;
		endforeach;
		$this->load->view('users_interface/unitsinfo',$pagevar);
	}
	
	function formsendmail(){
		
		$statusval = array('status'=>FALSE);
		
		if($this->input->post('email')):
			$this->form_validation->set_rules('name','','required|htmlspecialchars|trim');
			$this->form_validation->set_rules('email','','valid_email|trim');
			$this->form_validation->set_rules('comments','','strip_tags|trim');
			if($this->form_validation->run()):
				$message = "Имя: ".$_POST['name']."\nПочта: ".$_POST['email']."\nСообщение: ".$_POST['comments'];
				if($this->sendmail('kv@sk-stroikov.ru',$message,"Сообщение от ".$_POST['name'],$_POST['email'])):
					$statusval['status'] = TRUE;
					$this->inboxmailmodel->insert_email($_POST);
				endif;
			endif;
		else:
			show_404();
		endif;
		echo json_encode($statusval);
	}
	
	function sendmail($email,$msg,$subject,$from){
		
		$this->email->clear(TRUE);
		$config['smtp_host'] = 'localhost';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);
		$this->email->from($from,$email);
		$this->email->to('kv@sk-stroikov.ru');
		$this->email->bcc('admin@sk-stroikov.ru');
		$this->email->subject('Сообщение от пользователя SK-STROIKOV.RU');
		
		$this->email->message(strip_tags($msg));
		if (!$this->email->send()):
			return FALSE;
		endif;
		return TRUE;
	}
}
?>