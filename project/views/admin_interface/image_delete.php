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
					<a href="<?=$baseurl.$backpath;?>">&laquo; Вернуться назад</a>
				</div>
				<div class="clear"></div>
			</div>
			<div class="container_12">
		<?php if(!empty($images)): ?>
			<?php for($i=0;$i<count($images);$i++): ?>
				<div class="grid_2 diploma">
					<img class="plain-image left w120" alt="<?=$images[$i]['img_title'];?>" src="<?=$baseurl.$images[$i]['img_src'];?>"/>
					<div class="mt10">
						<?=anchor('admin/imagedestroy/'.$images[$i]['img_id'].'/'.$backpath,'Удалить фото',array('class'=>'delimage'));?>
					</div>
				</div>
			<?php endfor;?>
		<?php endif; ?>
				<div class="clear"></div>
			</div>
		</div>
		<div class="push"></div>
	</div>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script>!window.jQuery && document.write('<script src="<?=$baseurl;?>js/libs/jquery-1.6.2.min.js"><\/script>')</script>
	<script defer src="<?=$baseurl;?>js/jgrowl/jquery.jgrowl.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".delimage").click(function(){
				if(!confirm("Удалить фотографию?")) return false;
			});
			<?php if($msg):?>
				$.jGrowl(<?=$msg;?>,{header:'Сообщение'});
			<?php endif;?>
		});
	</script>
</body>
</html>