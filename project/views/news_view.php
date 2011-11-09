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
		echo '<script type="text/javascript" src="'.$data1['baseurl'].'js/jquery.confirm.js"></script>'.CRLT;
		?>
		<script type="text/javascript">
			$(document).ready(function() {	
				$('a.delnews').confirm();
				
				$('a.delimage').confirm();
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
					Раздел "Новости"
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div id="content">
			<div class="container_12">
				<div class="grid_6 omega admin-menu">
					<a href="<?php echo $data1['baseurl'].'admin/'; ?>">&laquo; Вернуться на главную</a>
					<a href="<?php echo $data1['baseurl'].'admin/newsnew'; ?>">Добавить новость &raquo;</a>
				</div>
				<div class="clear"></div>
				<div class="grid_10 omega">
				<?php
				foreach ($data2['query'] as $news){
					echo '
					<div class="news-item cp-item">
						<div class="news-date">'.$news->nws_date.'</div>
						<div class="news-header">
							<a name="news_'.$news->nws_id.'"></a>';
							if(isset($news->nws_img_src) and !empty($news->nws_img_src))
								echo '<img class="plain-image left w240" alt="'.$news->nws_img_alt.'" src="'.$data1['baseurl'].$news->nws_img_src.'"/>';
						echo $news->nws_header.		
						'</div>
						<div class = "plain-text">'.$news->nws_body.'</div>';
					$text = 'Редактировать';
					$str_uri = '/admin/newsedit/'.$news->nws_id;
					echo '<div class="ctrl news-controls">'.anchor($str_uri,$text);
					$text = 'Удалить';
					$attr = array('class'=>'delnews');
					$str_uri = '/admin/newsdestroy/'.$news->nws_id;
					echo anchor($str_uri,$text,$attr).'</div>';
					echo '</div><div class="clear"></div>';
				}
				?>					
				</div>
				<div class="clear"></div>
				<div class="grid_3 omega">
					<?php echo  '<div class="pager"> '.$data2['pager'].'</div>';  ?>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="push"></div>	 
	</div>