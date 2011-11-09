<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="Pragma" content="no-cache"/>
        <meta http-equiv="Cache-Control" content="no-cache"/>
        <meta http-equiv="Expires" content="1 Jan 2000 0:00:00 GMT"/>
		<meta name="language" content="ru" />
        <meta name="description" content=<?php echo $data1['desc'] ?>/>
        <meta name="keywords" content=<?php echo $data1['keyword'] ?>/>
        <title><?php echo $data1['title'] ?></title>
		<?php        	
		define("CRLT", "\n");
		echo '<link rel="shortcut icon" type="image/x-icon" href="http://sk-stroikov.ru/favicon.ico"/>'.CRLT;
		echo '<link rel="stylesheet" href="'.$data1['baseurl'].'css/reset.css" type="text/css" media="screen"/>'.CRLT;
		echo '<link rel="stylesheet" href="'.$data1['baseurl'].'css/960.css" type="text/css" media="screen"/>'.CRLT;
		echo '<link rel="stylesheet" href="'.$data1['baseurl'].'css/style.css" type="text/css" media="screen"/>'.CRLT;
		echo '<link rel="stylesheet" href="'.$data1['baseurl'].'css/pirobox.css" class="piro_style" title="white" type="text/css" media="screen"/>'.CRLT;
		
		echo '<!--[if lt IE 7.]>'.CRLT;
		echo '<script defer type="text/javascript" src="'.$data1['baseurl'].'js/png.fix.js"></script>'.CRLT;
		echo '<link rel="stylesheet" href="'.$data1['baseurl'].'css/ie6.css" type="text/css" media="screen"/>'.CRLT;
		echo '<![endif]-->'.CRLT;
		echo '<script type="text/javascript" src="'.$data1['baseurl'].'js/jquery.min.js"></script>'.CRLT;
		echo '<script type="text/javascript" src="'.$data1['baseurl'].'js/pirobox.min.js"></script>'.CRLT;
		echo '<script type="text/javascript" src="'.$data1['baseurl'].'js/jquery.confirm.js"></script>'.CRLT;
		?>
		<script type="text/javascript">
		$(document).ready(function() {
			$().piroBox({
				my_speed: 400,
				bg_alpha: 0.1, 
				slideShow : true, 
				slideSpeed : 6, 
				close_all : '.piro_close, .piro_overlay'

			});
		});
		</script>		
		<script type="text/javascript">
			$(document).ready(function() {	
				$('a.delunits').confirm();
			});
		</script>
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
					<a href="<?php echo $data1['baseurl'].'admin/unitsview'; ?>">Раздел "Объекты"</a> &rarr;
					Просмотр
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div id="content">
			<div class="container_12">
				<div class="grid_4 omega admin-menu">
					<a href="<?php echo $data1['baseurl'].'admin/unitsview'; ?>">&laquo; Вернуться к списку объектов</a>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
			
			<div class="units container_12">
				<div class="grid_11 omega">
				<?php
					echo '<div class="plain-text">';
					if(isset($data2['small_image']) and !empty($data2['small_image']))
						echo '<img class="plain-image left w220" alt="'.$data2['img_alt'].'" src="'.$data1['baseurl'].$data2['small_image'].'"/>';
						//echo $data2['title'].'<br/>';
						echo $data2['body'].'</div>';
						echo '<div class="clear"></div>';
					
					if(isset($data2['img_src']) and !empty($data2['img_src']))
						echo '<a class="pirobox_objects slideshow-view" href="'.
							$data2['img_src'].'" title="'.$data2['img_title'].
							'">Фотографии объекта &rarr;</a><div class="clear"></div>';
					
					if(isset($data3) and !empty($data3)){
						$nom = 2; 
						echo '<div style="display:none;">';
						for($j = 0; $j < $data2['index']; $j++){
							if(isset($data3[$j]['id'])){
								echo '<a class="pirobox_objects" href="'.
								$data3[$j]['image'].'" title="'.
								$data3[$j]['title'].'">Работа #'.$nom.'</a>'; 
								$nom++;
							}
						}
						echo '</div>';
						echo '<div class="clear"></div>';
					}
					
					$text = 'Редактировать';
					$str_uri = '/admin/unitsedit/'.$data2['id'];
					echo '<div class="mt10">'.anchor($str_uri,$text).' | ';
					$text = 'Удалить';
					$attr = array('class'=>'delunits');
					$str_uri = '/admin/unitsdestroy/'.$data2['id'];
					echo anchor($str_uri,$text,$attr).'</div>';
				?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	<div class="push"></div>	 
	</div>