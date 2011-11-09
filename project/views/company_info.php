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
		echo '<script type="text/javascript" src="'.$data1['baseurl'].'js/jquery.confirm.js"></script>'.CRLT;
		echo '<script type="text/javascript" src="'.$data1['baseurl'].'js/pirobox.min.js"></script>'.CRLT;
		?>
		<script type="text/javascript">
			$(document).ready(function() {	
				$('a.delcompany').confirm();
				
				$().piroBox({
					my_speed: 400,
					bg_alpha: 0.1, 
					slideShow : true, 
					slideSpeed : 6, 
					close_all : '.piro_close, .piro_overlay'

				});
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
					<a href="<?php echo $data1['baseurl'].'admin/companyview'; ?>">Раздел "Компании"</a> &rarr;
					Просмотр
				</div>
			</div>
			<div class="clear"></div>
		</div>		
		<div id="content">
			<div class="container_12">
				<div class="grid_4 omega admin-menu">
					<a href="<?php echo $data1['baseurl'].'admin/companyview'; ?>">&laquo; Вернуться к списку компаний</a>
				</div>
				<div class="clear"></div>
				<div class="grid_12">
					<div class="company-item">
						<div class="company-name">
							<?php echo $data2['cmp_name']; ?>
						</div>
						<div class="plain-text">
						<?php
							if(isset($data2['cmp_img_src']) and !empty($data2['cmp_img_src']))
								echo '<img class="plain-image left w220" alt="'.$data2['cmp_img_alt'].'" src="'.$data1['baseurl'].$data2['cmp_img_src'].'"/>';
							echo $data2['cmp_descr'];
							?>
						</div>
						<div class="clear"></div>
						<?
						echo '<div class="plain-text">'.$data2['cmp_text'].'</div>';
						?>
					</div>
					<div class="clear"></div>
					<?php
					if(isset($data2['slideshow_img_src']) and !empty($data2['slideshow_img_src']))
						echo '<a class="pirobox_company slideshow-view" href="'.$data1['baseurl'].$data2['slideshow_img_src'].'" title="'.$data2['slideshow_img_title'].'">Просмотреть  фотографии&rarr;</a>';
								
					if(isset($data5) and !empty($data5)){
						$nom = 2; 
						echo '<div style="display:none;">';
						for($i = 0; $i < $data2['index']; $i++){
							if(isset($data5[$i]['id'])){
								echo '<a class="pirobox_company" href="'.$data1['baseurl'].$data5[$i]['image'].'" title="'.$data5[$i]['title'].'">Фотография #'.$nom.'</a>';
								$nom++;	
							}
						}
						echo '</div>';
					}
					echo '<div class="clear"></div>';
					$text = 'Редактировать';
					$str_uri = '/admin/companyedit/'.$data2['cmp_id'];
					echo '<div>'.anchor($str_uri,$text).' | ';
					$text = 'Удалить';
					$attr = array('class'=>'delcompany');
					$str_uri = '/admin/companydestroy/'.$data2['cmp_id'];
					echo anchor($str_uri,$text,$attr).'</div>';
				?>
				</div>
				<div class="clear"></div>
				<div class="grid_12">
				<?
					if(isset($data3) and !empty($data3)){
						for($i = 0; $i < count($data3); $i++){
							echo '<div class="plain-text">'.
								'<h4>'.$data3[$i]['sbs_title'].'</h4>';
							if(isset($data3[$i]['sbs_img']) and !empty($data3[$i]['sbs_img']))
								echo '<img class="plain-image left w220" alt="'.$data3[$i]['sbs_alt'].'" src="'.$data1['baseurl'].$data3[$i]['sbs_img'].'"/>';
							echo $data3[$i]['sbs_text'].'<div class="clear"></div>';
							
							if(isset($data3[$i]['slideshow_img_src']) and !empty($data3[$i]['slideshow_img_src']))
								echo '<a class="pirobox_'.$i.' slideshow-view" href="'.$data1['baseurl'].$data3[$i]['slideshow_img_src'].'" title="'.$data3[$i]['slideshow_img_title'].'">Просмотреть  фотографии&rarr;</a>';
								
							if(isset($units) and !empty($units)){
								$nom = 2; 
								echo '<div style="display:none;">';
								for($j = 0; $j < $data3[$i]['index']; $j++){
									if(isset($units[$i][$j]['id'])){
										echo '<a class="pirobox_'.$i.'" href="'.$data1['baseurl'].$units[$i][$j]['image'].'" title="'.$units[$i][$j]['title'].'">Фотография #'.$nom.'</a>';
									$nom++;	
									}
								}
								echo '</div>';
							}
							echo '</div>';
							echo '<div class="clear"></div>';
							$text = 'Редактировать';
							$str_uri = $this->uri->uri_string().'/subsection/edit/'.$data3[$i]['sbs_id'];
							echo '<div>'.anchor($str_uri,$text).' | ';
							$text = 'Удалить';
							$attr = array('class'=>'delcompany');
							$str_uri = $this->uri->uri_string().'/subsection/destroy/'.$data3[$i]['sbs_id'];
							echo anchor($str_uri,$text,$attr).'</div>';
						}
					}
				?>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="push"></div>	 
	</div>