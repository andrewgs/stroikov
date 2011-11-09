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
						<li>
							<?=anchor('partners','Партнеры',array('class'=>'active'));?>
							<img src="<?=$baseurl;?>images/menu_separator.png" alt="" />
						</li>
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
			<div class="container_12">
			<?php if(isset($text) and !empty($text)):?>
				<div class="grid_12">
					<div class="plain-text indent"><?=$text;?></div>
			<?php endif; ?>
				<div class="grid_12">
					<h1 class="page_header">Список партнеров ООО СК Стройковъ</h1>
				</div>
				<div class="clear"></div>
		<?php for($i=0;$i<$count/10;$i++):?>
			<?php if($i==0 or $i%4==0): ?>
				<div class="grid_3">
			<?php else: ?>
				<div class="grid_3 omega">
			<?php endif; ?>
					<ol>
			<?php foreach($partners[$i] as $partner): ?>
				<?php $text = $partner->prt_name; ?>
				<?php if(!empty($partner->prt_href)): ?>
					<?php $str_uri = $partner->prt_href; ?>
					<?php $attr = array('target'=>'_blank'); ?>
				<?php else: ?>
					<?php $str_uri = 'partners/#'; ?>
					<?php $attr = array('target'=>'_parent');?>
				<?php endif; ?>
				<li><?=anchor($str_uri,$text,$attr)?></li>
			<?php endforeach; ?>
					</ol>
			<?php if($i%3==0 && $i>0): ?>
				</div>
				<div class="clear"></div>
			<?php else: ?>
				</div>
			<?php endif; ?>
		<?php endfor;?>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<?php $this->load->view('users_interface/footer');?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script>!window.jQuery && document.write('<script src="<?=$baseurl;?>js/libs/jquery-1.6.2.min.js"><\/script>')</script>
 </body>
</html>