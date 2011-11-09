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
					<a href="<?=$baseurl;?>admin/unitsnew">Добавить объект &raquo;</a>
				</div>
				<div class="clear"></div>
			</div>
			<hr size="2"/>
			<?php if($units): ?>
				<div class="container_12">
					<div class="grid_12 omega">
						<ol>
					<?php for($i=0;$i<count($units);$i++):?>
							<li>
								<?=anchor('unitsinfo/'.$units[$i]['unt_id'],$units[$i]['unt_client'],array('target'=>'_blank'));?>
								<div style="float:right;">
				<input type="image" title="Редактировать" class="uEdit" unit="<?=$units[$i]['unt_id'];?>" src="<?=$baseurl;?>images/edit.png" />
				<input type="image" title="Удалить" class="uDel" unit="<?=$units[$i]['unt_id'];?>" src="<?=$baseurl;?>images/delete.png" />
								</div>
								<br class="clear"/>
							</li>
					<?php endfor;?>
						</ol>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
				<hr size="2"/>
			<?php endif; ?>
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
			$(".uEdit").click(function(){
				if(!confirm("Редактировать объект?")) return false;
				var uID = $(this).attr("unit");
				window.setTimeout("window.location='<?=$baseurl;?>admin/unitsedit/"+uID+"'",500);
			});
			$(".uDel").click(function(){
				if(!confirm("Удалить объект?")) return false;
				var uID = $(this).attr("unit");
				window.setTimeout("window.location='<?=$baseurl;?>admin/unitsdestroy/"+uID+"'",500);
			});
		});
	</script>
</body>
</html>