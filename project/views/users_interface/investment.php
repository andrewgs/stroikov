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
						<li>
							<?=anchor('investment','Инвестиции',array('class'=>'active'));?>
							<img src="<?=$baseurl;?>images/menu_separator.png" alt="" />
						</li>
						<li><?=anchor('partners','Партнеры');?><img src="<?=$baseurl;?>images/menu_separator.png" alt="" /></li>
						<li><?=anchor('units','Объекты');?><img src="<?=$baseurl;?>images/menu_separator.png" alt="" /></li>
						<li><?=anchor('about','О компании');?><img src="<?=$baseurl;?>images/menu_separator.png" alt="" /></li>		
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
			<div class="clear"></div>		
			<div class="container_12">
			<?php $i = 0; $pbclass = 1; ?>
			<?php foreach($investment as $inv): ?>
				<div class="grid_12">
					<div class="plain-text">
						<h2 class="indent"><?=$investment[$i]['inv_object_name'];?></h2>
						<?=$investment[$i]['inv_text'];?>
					<?php if(isset($investment[$i]['image']) and !empty($investment[$i]['image'])):?>
						<a class="pirobox_investment_'<?=$pbclass;?> slideshow-view" href="<?=$investment[$i]['image']?>" title="<?=$investment[$i]['title']?>">Фотографии объекта &rarr;</a>
					<?php endif; ?>	
					<?php if(isset($images) and !empty($images)):?>
						<?php $nom=2;?>
						<div style="display:none;">
						<?php for($j=0;$j<$investment[$i]['index'];$j++):?>
							<?php if(isset($images[$i][$j]['id'])): ?>
								<a class="pirobox_investment_'<?=$pbclass;?>" href="<?=$images[$i][$j]['image'];?>" title="<?=$images[$i][$j]['title'];?>">Фотография №<?=$nom;?></a>
								<?php $nom++; ?>
							<?php endif; ?>
						<?php endfor;?>
						</div>
					<?php endif;?>
					<?php $i++;	$pbclass++; ?>		
					</div>
				</div>
				<div class="clear"></div>
			<?php endforeach;?>
			</div>
			<div class="clear"></div>
		</div>
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