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
						<li>
							<?=anchor('units','Объекты',array('class'=>'active'));?>
							<img src="<?=$baseurl;?>images/menu_separator.png" alt="" />
						</li>
						<li><?=anchor('about','О компании');?><img src="<?=$baseurl;?>images/menu_separator.png" alt="" /></li>		
					</ul>
				</div>	
			</div>
			<div class="clear"></div>
		</div>
		<div id="content">
			<div class="grid_4 omega admin-menu">
				<a href="<?=$baseurl;?>units">&laquo; Вернуться к списку объектов</a>
			</div>
			<div class="clear"></div>
			<div class="units container_12">
				<div class="grid_11">
					<div class="plain-text">
				<?php if(isset($unit['small_image']) and !empty($unit['small_image'])):?>
						<img class="plain-image left w220" alt="<?=$unit['img_alt'];?>" src="<?=$baseurl.$unit['small_image'];?>"/>
				<?php endif;?>
						<?=$unit['body'];?>
					</div>
					<div class="clear"></div>
					
				<?php if(isset($unit['img_src']) and !empty($unit['img_src'])):?>
			<a class="pirobox_objects slideshow-view" href="<?=$unit['img_src'];?>" title="<?=$unit['img_title']?>">Фотографии объекта &rarr;</a>
					<div class="clear"></div>
				<?php endif;?>	
				<?php if(isset($images) and !empty($images)):?>
					<?php $nom = 2; ?>
					<div style="display:none;">
				<?php for($j=0;$j<$unit['index'];$j++):?>
					<?php if(isset($images[$j]['id'])):?>
						<a class="pirobox_objects" href="<?=$images[$j]['image'];?>" title="<?=$images[$j]['title'];?>">Работа №<?=$nom;?></a>
						<?php $nom++;?>
					<?php endif;?>
				<?php endfor;?>
					</div>
					<div class="clear"></div>
					<?php endif;?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="push"></div>	 
	</div>
	<?php $this->load->view('users_interface/footer');?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script>!window.jQuery && document.write('<script src="<?=$baseurl;?>js/libs/jquery-1.6.2.min.js"><\/script>')</script>
	<script type="text/javascript" src="<?=$baseurl;?>js/pirobox.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$().piroBox({my_speed: 400,bg_alpha: 0.1,slideShow : true,slideSpeed : 6,close_all : '.piro_close, .piro_overlay'});
		});
	</script>
 </body>
</html>