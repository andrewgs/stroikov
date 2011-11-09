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
					<a href="<?=$baseurl;?>admin/partnernew">Добавить партнера &raquo;</a>
				</div>
				<div class="clear"></div>
			</div>
			<div class="container_12">
			<?php if(isset($text) && !empty($text)):?>
				<div class="grid_12">
					<div class="plain-text indent"><?=$text;?></div>
					<span class="ctrl-partners"><?=anchor('admin/textedit/partners','Редактировать текст');?></span>
				</div>
				<div class="clear"></div>
			<?php endif;?>
				<h1>Список партнеров ООО СК Стройковъ</h1>
				<div class="clear"></div>
				<hr size="2"/>
			<?php if($partners): ?>
				<div class="container_12">
					<div class="grid_12 omega">
						<ol>
					<?php for($i=0;$i<count($partners);$i++):?>
							<li>
								<?=$partners[$i]['prt_name'];?>
								<div style="float:right;">
		<input type="image" title="Редактировать: <?=$partners[$i]['prt_name'];?>" class="pEdit" partner="<?=$partners[$i]['prt_id'];?>" src="<?=$baseurl;?>images/edit.png" />
		<input type="image" title="Удалить: <?=$partners[$i]['prt_name'];?>" class="pDel" partner="<?=$partners[$i]['prt_id'];?>" src="<?=$baseurl;?>images/delete.png" />
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
				<div class="clear"></div>
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
			$(".pEdit").click(function(){
				if(!confirm("Редактировать партнера?")) return false;
				var pID = $(this).attr("partner");
				window.setTimeout("window.location='<?=$baseurl;?>/admin/partneredit/"+pID+"'",500);
			});
			$(".pDel").click(function(){
				if(!confirm("Удалить партнера?")) return false;
				var pID = $(this).attr("partner");
				window.setTimeout("window.location='<?=$baseurl;?>admin/partnerdestroy/"+pID+"'",500);
			});
		});
	</script>
</body>
</html>	