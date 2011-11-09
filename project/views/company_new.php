<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="Pragma" content="no-cache"/>
        <meta http-equiv="Cache-Control" content="no-cache"/>
        <meta http-equiv="Expires" content="1 Jan 2000 0:00:00 GMT"/>
		<meta name="language" content="ru" />
        <meta name="description" content=<?php echo $data['desc'] ?>/>
        <meta name="keywords" content=<?php echo $data['keyword'] ?>/>
        <title><?php echo $data['title'] ?></title>
		<?php        	
		define("CRLT", "\n");
		echo '<link rel="shortcut icon" type="image/x-icon" href="http://sk-stroikov.ru/favicon.ico"/>'.CRLT;
		echo '<link rel="stylesheet" href="'.$data['baseurl'].'css/reset.css" type="text/css" media="screen"/>'.CRLT;
		echo '<link rel="stylesheet" href="'.$data['baseurl'].'css/960.css" type="text/css" media="screen"/>'.CRLT;
		echo '<link rel="stylesheet" href="'.$data['baseurl'].'css/style.css" type="text/css" media="screen"/>'.CRLT;
		
		echo '<!--[if lt IE 7.]>'.CRLT;
		echo '<script defer type="text/javascript" src="'.$data['baseurl'].'js/png.fix.js"></script>'.CRLT;
		echo '<link rel="stylesheet" href="'.$data['baseurl'].'css/ie6.css" type="text/css" media="screen"/>'.CRLT;
		echo '<![endif]-->'.CRLT;
		echo '<script type="text/javascript" src="'.$data['baseurl'].'js/jquery.min.js"></script>'.CRLT;
		?>
    </head>
    <body>
    <div id="main-wrap">
		<div id="admin-panel">
		<?php
			echo '<span>Вы вошли как Администратор</span> <a class="logout" href="'.$data['baseurl'].'admin/logoff">Завершить сеанс</a>';
		?>
		</div>
		<div id="header">
			<div class="container_12">
				<div id="logo" class="grid_3">
					<?php echo anchor('','<img src="'.$data['baseurl'].'images/logo.png" alt="Строительная компания Стройковъ"/>');  ?>
				</div>	
				<div class="grid_9 admin-path">
					/ <a href="<?php echo $data['baseurl'].'admin/'; ?>">Администрирование</a> &rarr; 
					<a href="<?php echo $data['baseurl'].'admin/companyview'; ?>">Раздел "Компании"</a> &rarr; 
					Новая
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div id="content">
			<div class="container_12">
				<div class="grid_4 omega admin-menu">
					<a href="<?php echo $data['baseurl'].'admin/companyview'; ?>">&laquo; Вернуться к списку компаний</a>
				</div>
				<div class="clear"></div>
				<div class="grid_10 omega">
					<div class="formmailer">
						<?php
							$attr = array('name' => 'formcompanynew','id' => 'formcompany');
							echo form_open_multipart('admin/companyinsert',$attr);
							echo form_error('companyname').'<div class="clear"></div>';
							echo form_label('Название компании','companylabel');
								$attr = array(
									'name'     => 'companyname',
									'id'       => 'companyname',
									'value'    => set_value('companyname'),
									'maxlength'=> '200',
									'size'     => '7'
							);
							echo '<div class="dd">'.form_input($attr).'</div>';
							echo form_error('textlink').'<div class="clear"></div>';
							echo form_label('Текст сслыки','companylabel');
							$attr = array(
									'name' => 'textlink',
									'id'   => 'textlink',
									'value'=> set_value('textlink'),
									'maxlength'=> '200',
									'size' => '60'
									);
							echo '<div class="dd">'.form_input($attr).'</div>';
							echo '<hr>';
							echo form_label('Фото к новости (поддерживаемые форматы: jpeg, png, gif)','companylabel');
							$attr = array(
								'type' 	   => 'file',
								'name' 	   => 'userfile',
              					'id'  	   => 'companysimage',
								'accept'   => 'image/jpeg,png,gif',
              					'maxlength'=> '250',
              					'size'	   => '15'
									);
							echo '<div>'.form_input($attr).'</div>';
							echo form_label('Подпись к фото','companylabel');
							$attr = array(
								'name'		 => 'companyimgalt',
								'id'  		 => 'companyimgalt',
								'value'		 => '',
								'maxlength'	 => '70',
              					'size' 		 => '40'
								);
							echo '<div class="dd">'.form_input($attr).'</div>';
							echo '<hr>';
							echo form_error('companydescr').'<div class="clear"></div>';
							echo form_label('О компании','companylabel');
							$attr =array(
									'name'	 => 'companydescr',
									'id'  	 => 'companydescr',
									'value'	 => set_value('companydescr'),
									'cols' 	 => '60',
									'rows' 	 => '4'
									);
							echo '<div class="dd">'.form_textarea($attr).'</div>';
							echo form_error('companytext').'<div class="clear"></div>';
							echo form_label('Разширенная информация','companylabel');
							$attr =array(
									'name' 	=> 'companytext',
									'id'   	=> 'companytext',
									'value'	=> set_value('companytext'),
									'cols' 	=> '60',
									'rows' 	=> '7'
									);
							echo '<div class="dd">'.form_textarea($attr).'</div>';
					
							$attr =array(
									'name' => 'btsabmit',
									'id'   => 'btnsabmit',
									'value'=> 'Добавить',
									'class'	=> 'senden'
								);
							echo '<div id="bt_submit">'.form_submit($attr).'</div>';													echo form_close();
						?>	
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="push"></div>	 
	</div>