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
		echo '<link rel="stylesheet" href="'.$data['baseurl'].'css/reset.css" type="text/css" media="screen"/>';
		echo '<link rel="stylesheet" href="'.$data['baseurl'].'css/960.css" type="text/css" media="screen"/>';
		echo '<link rel="stylesheet" href="'.$data['baseurl'].'css/style.css" type="text/css" media="screen"/>';
		
		echo '<script type="text/javascript" src="'.$data['baseurl'].'js/jquery.min.js"></script>';
		echo '<script type="text/javascript" src="'.$data['baseurl'].'js/swfobject.js"></script>';
		?>
    </head>
    <body>
    <div id="main-wrap">
		<?php
			if($data['admin']){
				echo '<div id="admin-panel">';
					echo '<span>Вы вошли как Администратор</span> <a class="logout" href="'.$data['baseurl'].'admin/logoff">Завершить сеанс</a>';
				echo '</div>';
			}
		?>
		<div id="header">
			<div class="container_12">
				<div id="inaccessible" class="prefix_2 grid_6 omega">
					<?php
					echo '<img alt="Строительная компания Стройковъ" src="'.$data['baseurl'].'images/404.png" />';
					?>
				</div>
			</div>
			<div class="clear"></div>
			<div class="container_12">
				<div id="credits" class="prefix_5 grid_5">
					<span class="separated"><a href="http://realitygroup.ru" target="_blank" title="Мы принимаем реальность такой, какой нам ее преподносят.">Проект разработан Творческой группой Реальность</a></span><br/>
					<span class="separated">Все права защищены © Стройковъ 2007-2010</span>					
				</div>
			</div>
			<div class="clear"></div>			
		</div>
	</div>
    </body>
</html>