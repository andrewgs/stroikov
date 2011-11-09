<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">
<?php $this->load->view('admin_interface/head');?>
    <body>
    <div id="main-wrap">
		<?php $this->load->view('admin_interface/admin-panel');?>
		<?php $this->load->view('admin_interface/header');?>
		<div id="content">
			<div class="container_12">
				<div class="grid_4 omega admin-menu">
					<a href="<?=$baseurl;?>admin/control-panel">&laquo; Панель управления</a>
				</div>
				<div class="clear"></div>
			</div>
			<div class="container_12">
				<div class="visit-card grid_8">
					<p><?=$contacts['cnt_post_index'];?><br/>
					<?=$contacts['cnt_city'];?><br/>
					<?=$contacts['cnt_street'].', '.$contacts['cnt_house'];?><br/><br/>
					Тел/факс: <?=$contacts['cnt_telfax'];?><br/>
					E-mail: <?=safe_mailto($contacts['cnt_email'],$contacts['cnt_email']);?></p>
					<div class="mt10"><?=anchor('admin/contactedit/'.$contacts['cnt_id'],'Редактировать');?></div>
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