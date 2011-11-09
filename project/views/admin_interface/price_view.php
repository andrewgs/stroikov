<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">
<?php $this->load->view('admin_interface/head');?>
<body>
	<div id="main-wrap">
		<?php $this->load->view('admin_interface/admin-panel');?>
		<?php $this->load->view('admin_interface/header');?>
		<div id="content">
			<div class="container_12">
				<div class="grid_6 omega admin-menu">
					<a href="<?=$baseurl;?>admin/control-panel">&laquo; Панель управления</a>
				<?php if(isset($price) && !empty($price)):?>
					<a href="<?=$baseurl;?>admin/textedit/price">Редактировать прайс-лист &raquo;</a>
				<?php endif;?>
				</div>
				<div class="clear"></div>
			</div>
			<div class="container_12">
				<div class="grid_10 omega">
				<?php if(isset($price) && !empty($price)):?>
					<div id="price" style="margin: 20px 0"><?=$price;?></div>
				<?php endif;?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="push"></div>
	</div>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script>!window.jQuery && document.write('<script src="<?=$baseurl;?>js/libs/jquery-1.6.2.min.js"><\/script>')</script>
	<script defer src="<?=$baseurl;?>js/jgrowl/jquery.jgrowl.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			<?php if($msg):?>
				$.jGrowl(<?=$msg;?>,{header:'Сообщение'});
			<?php endif;?>
		});
	</script>
</body>
</html>