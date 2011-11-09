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
		
		echo '<!--[if lt IE 7.]>'.CRLT;
		echo '<script defer type="text/javascript" src="'.$data1['baseurl'].'js/png.fix.js"></script>'.CRLT;
		echo '<link rel="stylesheet" href="'.$data1['baseurl'].'css/ie6.css" type="text/css" media="screen"/>'.CRLT;
		echo '<![endif]-->'.CRLT;
		echo '<script type="text/javascript" src="'.$data1['baseurl'].'js/jquery.min.js"></script>'.CRLT;
		echo '<script type="text/javascript" src="'.$data1['baseurl'].'js/pirobox.min.js"></script>'.CRLT;
		?>
		<script type="text/javascript">
			// Thumb Desturate Effect
			$(document).ready(function() {

				$("a.thumb").hover(function() { //On hover...
					
					var thumbOver = $(this).find("img").attr("src"); //Get image url and assign it to 'thumbOver'
					
					//Set a background image(thumbOver) on the &lt;a&gt; tag 
					$(this).find("div.thumbimg").css({'background' : 'url(' + thumbOver + ') no-repeat center bottom'});
					//Fade the image to 0 
					$(this).find("span").stop().fadeTo('fast', 0 , function() {
						$(this).hide() //Hide the image after fade
					}); 
				} , function() { //on hover out...
					//Fade the image to 1 
					$(this).find("span").stop().fadeTo('slow', 1).show();
				});

				$("a.thumb").hover(
					function(){
						$(this).find("h1.title , h1.client").animate({ bottom:"0px", opacity: 0 }, 150 );
				}, function() {
					$(this).find("h1.title").animate({ bottom:"57px", opacity: 1 }, 150 );
					$(this).find("h1.client").animate({ bottom:"30px", opacity: 1 }, 150 );
				});
				
				$("a.thumb").hover(
					function(){
						$(this).find("h1.open").animate({ bottom:"30px", opacity: 1 }, 150 );
					}, 
					function() {
						$(this).find("h1.open").animate({ bottom:"10px", opacity: 0	}, 150 );
					}
				);
				
			});				
		</script>
    </head>
    <body>
	<div id="main-wrap">
		<?php
			if($data1['admin']){
				echo '<div id="admin-panel">';
					echo '<span>Вы вошли как Администратор</span> <a class="logout" href="'.$data1['baseurl'].'admin/logoff">Завершить сеанс</a>';
				echo '</div>';
			}
		?>
		<div id="header">
			<div class="container_12">
				<div id="logo" class="grid_3">
					<?php
					echo anchor('','<img src="'.$data1['baseurl'].'images/logo.png" alt="sk-stroikov.ru"/>'); 
					?>
				</div>
				<div class="grid_9">
					<ul id="header-menu">
						<?php
							echo "<li>".anchor('contacts','Контакты')."</li>";
							echo "<li>".anchor('investment','Инвестиции').'<img src="'.$data1['baseurl'].'images/menu_separator.png" alt="" />'."</li>";		
							echo "<li>".anchor('partners','Партнеры').'<img src="'.$data1['baseurl'].'images/menu_separator.png" alt="" />'."</li>";
							echo "<li>".anchor('units','Объекты',array('class'=>'active')).'<img src="'.$data1['baseurl'].'images/menu_separator.png" alt="" />'."</li>";
							echo "<li>".anchor('about','О компании').'<img src="'.$data1['baseurl'].'images/menu_separator.png" alt="" />'."</li>";		
						?>
						</ul>
				</div>	
			</div>
			<div class="clear"></div>
		</div>
		<div id="content">
			<div class="container_12">
				<div class="grid_4 omega admin-menu">
					<a href="<?php echo $data1['baseurl']; ?>">&laquo; Вернуться на главную</a>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>		
			<div class="container_12">
			<?php
			$count = 1;
				foreach ($data2 as $mainunits){
					if($count == 1 or $count % 3 == 0) echo '<div class="units container_12">';
						echo '<div class="grid_6">';
							echo '<a class="thumb" target="_parent" href="'.$data1['baseurl'].'unitsinfo/'.$mainunits->unt_id.'">';
								echo '<div class="thumb_labels">';
									echo '<h1 class="title">'.$mainunits->unt_title.'</h1>';
									echo '<h1 class="client">'.$mainunits->unt_client.'</h1>';
								echo '</div>';
								if (!empty($mainunits->unt_image)){
								
									echo '<div class="thumbimg" style="background: url("'.$data1['baseurl'].$mainunits->unt_image.'") no-repeat scroll center bottom transparent;">';
										echo '<span style="opacity: 1; display: block;"><img alt="" src="'.$data1['baseurl'].$mainunits->unt_image.'"></span></div>';
								}
							echo '</a>';
						echo '</div>';
				
					if($data3 == 1 or $count % 2 == 0 or $count == $data3){
						echo '</div>';
						echo '<div class="clear"></div>';
					}
					$count+=1;
				}
				?>
			</div>
			<div class="clear"></div>
			<?php
			if (isset($units) and !empty($units)){
			?>
				<div class="container_12">
					<div class="grid_12">
						<h1 class="page_header">Полный список объектов ООО СК Стройковъ</h1>
					</div>
					<div class="clear"></div>
					<?php
						$cntrow = $data5; $k = 0;
						for($i = 0; $i < 3; $i++){
							if(isset($units[$i][0]['id']) and !empty($units[$i][0]['id'])){
								echo '<div class="units_list grid_4 omega"><ol>';
								for($j = 0; $j < $cntrow; $j++){
									if($k > $data3-1) break;
									$text = $units[$i][$j]['unt_client'];
									$str_uri = $data1['baseurl'].'unitsinfo/'.$units[$i][$j]['id'];
									echo '<li>'.anchor($str_uri,$text).'</li>';
									$k++;
								}
								echo '</ol></div>';
							}
						}
						echo '<div class="clear"></div>';
					?>
				</div>
				<div class="clear"></div>
			<?php
			}
			?>
		</div>
		<div class="push"></div>	 
	</div>