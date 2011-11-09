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
					<a href="<?=$baseurl;?>admin/newsnew">Добавить новость &raquo;</a>
				</div>
				<div class="clear"></div>
				<hr size="2"/>
			<?php if($news): ?>
				<div class="container_12">
					<div class="grid_12 omega">
						<ol>
					<?php for($i=0;$i<count($news);$i++):?>
							<li style="margin-top:15px;">
								<div class="grid_9">
									<?=$news[$i]['nws_date'];?><br/>
									<?=anchor('newsview/'.$news[$i]['nws_id'],$news[$i]['nws_header'],array('target'=>'_blank'));?>
								</div>
								<div class="grid_1" style="float:right;"><br/>
				<input type="image" title="Редактировать" class="nEdit" news="<?=$news[$i]['nws_id'];?>" src="<?=$baseurl;?>images/edit.png" />
				<input type="image" title="Удалить" class="nDel" news="<?=$news[$i]['nws_id'];?>" src="<?=$baseurl;?>images/delete.png" />
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
			$(".nEdit").click(function(){
				if(!confirm("Редактировать объект?")) return false;
				var uID = $(this).attr("news");
				window.setTimeout("window.location='<?=$baseurl;?>admin/newsedit/"+uID+"'",500);
			});
			$(".nDel").click(function(){
				if(!confirm("Удалить новость?")) return false;
				var uID = $(this).attr("news");
				window.setTimeout("window.location='<?=$baseurl;?>admin/newsdestroy/"+uID+"'",500);
			});
		});
	</script>
</body>
</html>