<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">
<?php $this->load->view('users_interface/head');?>
<body>
	<div id="main-wrap">
		<?php $this->load->view('users_interface/admin-panel');?>
		<div id="header">
			<div class="container_12">
				<div id="logo" class="grid_3">
					<?=anchor('','<img src="'.$baseurl.'images/logo.png" alt="Строительная компания Стройковъ"/>');?> 
				</div>
				<div class="grid_9">
					<ul id="header-menu">
						<li><?=anchor('contacts','Контакты');?></li>
						<li><?=anchor('investment','Инвестиции');?><img src="<?=$baseurl;?>images/menu_separator.png" alt="" /></li>		
						<li><?=anchor('partners','Партнеры');?><img src="<?=$baseurl;?>images/menu_separator.png" alt="" /></li>
						<li><?=anchor('units','Объекты');?><img src="<?=$baseurl;?>images/menu_separator.png" alt="" /></li>
						<li>
							<?=anchor('about','О компании',array('class'=>'active'));?>
							<img src="<?=$baseurl;?>images/menu_separator.png" alt=""/>
						</li>		
					</ul>
				</div>	
			</div>
			<div class="clear"></div>
		</div>
		<div id="content">
			<div class="container_12">
				<div class="grid_4 omega admin-menu">
					<a href="<?=$baseurl;?>">&laquo; Вернуться на главную</a>
				</div>
				<div class="clear"></div>
			</div>
			<div class="container_16">
				<div class="grid_15 omega">
					<div class="plain-text"><?=$about['abt_text'];?></div>
				</div>
				<div class="clear"></div>
				<?php for($i=0;$i<count($images);$i++): ?>
					<div class="grid_3 omega diploma">
						<img class="plain-image left w120" alt="<?=$images[$i]['img_title'];?>" src="<?=$baseurl.$images[$i]['img_src'];?>"/>
					</div>
				<?php endfor;?>
				<div class="clear"></div>
			</div>
		</div>
		<div class="push"></div>
	</div>
	<?php $this->load->view('users_interface/footer');?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script>!window.jQuery && document.write('<script src="<?=$baseurl;?>js/libs/jquery-1.6.2.min.js"><\/script>')</script>
 </body>
</html>