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
		echo '<link rel="stylesheet" href="'.$data1['baseurl'].'css/reset.css" type="text/css" media="screen"/>'.CRLT;
		echo '<link rel="stylesheet" href="'.$data1['baseurl'].'css/960.css" type="text/css" media="screen"/>'.CRLT;
		echo '<link rel="stylesheet" href="'.$data1['baseurl'].'css/style.css" type="text/css" media="screen"/>'.CRLT;
		
		echo '<!--[if lt IE 7.]>'.CRLT;
		echo '<script defer type="text/javascript" src="'.$data1['baseurl'].'js/png.fix.js"></script>'.CRLT;
		echo '<link rel="stylesheet" href="'.$data1['baseurl'].'css/ie6.css" type="text/css" media="screen"/>'.CRLT;
		echo '<![endif]-->'.CRLT;
		echo '<script type="text/javascript" src="'.$data1['baseurl'].'js/jquery.min.js"></script>'.CRLT;
		?>
    </head>
    <body>
    <div id="main-wrap">
		<div id="admin-panel">
		<?php
			echo '<span>Вы вошли как Администратор</span> <a class="logout" href="'.$data1['baseurl'].'admin/logoff">Завершить сеанс</a>';
		?>
		</div>
		<div id="header">
			<div class="container_12">
				<div id="logo" class="grid_3">
					<?php echo anchor('','<img src="'.$data1['baseurl'].'images/logo.png" alt="Строительная компания Стройковъ"/>');  ?>
				</div>	
				<div class="grid_9 admin-path">
					/ <a href="<?php echo $data1['baseurl'].'admin/'; ?>">Администрирование</a> &rarr; 
					  <a href="<?php echo $data1['baseurl'].'admin/contactsview'; ?>">Раздел "Контактная информация"</a> &rarr; Новая
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div id="content">
			<div class="container_12">
				<div class="grid_10 omega">
					<div class="formmailer">
			<?php
				$attr = array('name' => 'formcontactnew','id' => 'formcontact');
				echo form_open('admin/contactinsert',$attr);
				echo form_label('Почтовый индекс','contactlabel');
				$attr = array(
							'name' => 'postindex',
							'id'   => 'postindex',
							'value'=> '',
						'maxlength'=> '30',
							'size' => '15'
						);
				echo '<div class="dd">'.form_input($attr).'</div>';
				echo form_label('Населенный пункт','contactlabel');
				$attr =array(
							'name' => 'city',
							'id'   => 'city',
							'value'=> '',
						'maxlength'=> '200',
							'size' => '30'
							);
				echo '<div class="dd">'.form_input($attr).'</div>';
				echo form_label('Улица','contactlabel');
				$attr =array(
							'name' => 'street',
							'id'   => 'street',
							'value'=> '',
						'maxlength'=> '200',
							'size' => '30'
							);
				echo '<div class="dd">'.form_input($attr).'</div>';
				echo form_label('Дом','contactlabel');
				$attr =array(
							'name' => 'house',
							'id'   => 'house',
							'value'=> '',
						'maxlength'=> '30',
							'size' => '10'
							);
				echo '<div class="dd">'.form_input($attr).'</div>';
				echo form_label('Тел./Факс','contactlabel');
				$attr =array(
							'name' => 'telfax',
							'id'   => 'telfax',
							'value'=> '',
						'maxlength'=> '50',
							'size' => '20'
							);
				echo '<div>'.form_input($attr).'</div>';
				echo form_label('E-mail','contactlabel');
				$attr =array(
							'name' 		=> 'email',
							'id'   		=> 'email',
							'value'		=> '',
							'maxlength'	=> '200',
							'size' 		=> '20'
							'class'		=> 'dd'
							);
				echo '<div class="dd">'.form_input($attr).'</div>';
				
				$attr =array(
							'name' => 'btsabmit',
							'id'   => 'btnsabmit',
							'value'=> 'Добавить контакт',
							'class'=> 'senden'
				);
				echo '<div id="bt_submit">'.form_submit($attr).'</div>';							
				echo form_close();
			?>	
		
	
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="push"></div>	 
	</div>