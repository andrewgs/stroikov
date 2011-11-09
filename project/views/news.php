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
		?>
    </head>
    <body>
    <div id="main-wrap">
		<div id="header">
			<div class="container_12">
				<div id="logo" class="grid_3">
					<?php
					echo anchor('','<img src="'.$data1['baseurl'].'images/logo.png" alt="Строительная компания Стройковъ"/>'); 
					?>
				</div>
				<div class="grid_9">
					<ul id="header-menu">
						<?php
							echo "<li>".anchor('contacts','Контакты')."</li>";
							echo "<li>".anchor('investment','Инвестиции').'<img src="'.$data1['baseurl'].'images/menu_separator.png" alt="" />'."</li>";		
							echo "<li>".anchor('partners','Партнеры').'<img src="'.$data1['baseurl'].'images/menu_separator.png" alt="" />'."</li>";
							echo "<li>".anchor('units','Объекты').'<img src="'.$data1['baseurl'].'images/menu_separator.png" alt="" />'."</li>";
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
			<div class="container_12">
			<?php
				foreach ($data2['query'] as $news){
				
					echo '<div class="news-item">';
						echo '<div class="news-date">'.$news->nws_date.'</div>';
						echo '<div class="news-header"><a name="news_'.$news->nws_id.'"></a>';
							if(isset($news->nws_img_src) and !empty($news->nws_img_src)){
								echo '<img class="plain-image left w90" alt="'.$news->nws_img_alt.'" src="'.$data1['baseurl'].$news->nws_img_src.'"/>';	
								}
							echo $news->nws_header;
						
						echo '</div><div class="clear"></div>';
						echo '<div class="plain-text">'.$news->nws_body.'</div>';
					echo '</div>';
					echo '<div class="clear"></div>';
					}
				echo '<div class="pager"> '.$data2['pager'].'</div>'; 
				?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="push"></div>	 
	</div>
