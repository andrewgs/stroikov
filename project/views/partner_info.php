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
		echo '<script type="text/javascript" src="'.$data1['baseurl'].'js/jquery.confirm.js"></script>';
		?>
		<script type="text/javascript">
			$(document).ready(function() {	
				$('a.delpartner').confirm();
			});
		</script>
    </head>
    <body>
		<div id="main-wrap">
		<div id="header">
			<div class="container_12">
				<?php
					echo '<div id="logo" class="grid_6">';					
					echo '<a href="'.$data1['baseurl'].'admin">Администрирование</a>';
					echo '</div>';
					echo '<div class="grid_6">';
					echo '<a class="logout" href="'.$data1['baseurl'].'admin/logoff">Завершить сеанс</a>';
					echo '</div>';
				?>		
			</div>
			<div class="clear"></div>
		</div>
		<div id="content">
			<?php
				echo '<a href="'.$data1['baseurl'].'admin/partnersview">&laquo; Вернуться к списку партнеров</a>';
				echo '<br/><br/>';
				
				foreach ($data2 as $partner){
					if(!empty($partner->prt_href)){
						$text = $partner->prt_name;
						$str_uri = $partner->prt_href;
						$attr = array('target'=>'_blank');
						echo '<div>'.anchor($str_uri,$text,$attr).'</div>';		
					}else{
						echo '<div>'.$partner->prt_name.'</div>';
					}
					echo '<div>'.$partner->prt_note.'</div>';
					$text = 'Редактировать';
					$str_uri = '/admin/partneredit/'.$partner->prt_id;
					echo '<div>'.anchor($str_uri,$text).' | ';
					$text = 'Удалить';
					$attr = array('class'=>'delpartner');
					$str_uri = '/admin/partnerdestroy/'.$partner->prt_id;
					echo anchor($str_uri,$text,$attr).'</div>';
				}
			?>					
				
			<div class="clear"></div>
		</div>
		<div class="push"></div>	 
	</div>