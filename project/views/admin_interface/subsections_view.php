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
					<a href="<?=$baseurl;?>admin/companyedit/<?=$this->uri->segment(3);?>">&laquo; Вернуться назад</a>
					<a href="<?=$baseurl;?>admin/companyedit/<?=$this->uri->segment(3);?>/subsection/create">Создать подраздел &raquo;</a>
				</div>
				<div class="clear"></div>
			</div>
			<hr size="2"/>
			<?php if($subsections): ?>
				<div class="container_12">
					<div class="grid_12 omega">
						<ol>
					<?php for($i=0;$i<count($subsections);$i++):?>
							<li>
								<?=$subsections[$i]['sbs_title'];?>
								<div style="float:right;">
<input type="image" title="Загрузить фото" class="pUp" unit="<?=$subsections[$i]['sbs_id'];?>" src="<?=$baseurl;?>images/picture-plus.png" />
<input type="image" title="Удалить фото" class="pDown" unit="<?=$subsections[$i]['sbs_id'];?>" src="<?=$baseurl;?>images/picture-minus.png" />
<input type="image" title="Редактировать" class="sEdit" unit="<?=$subsections[$i]['sbs_id'];?>" src="<?=$baseurl;?>images/edit.png" />
<input type="image" title="Удалить" class="sDel" unit="<?=$subsections[$i]['sbs_id'];?>" src="<?=$baseurl;?>images/delete.png" />
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
			
			var company = <?=$this->uri->segment(3);?>
			
			$(".sEdit").click(function(){
				if(!confirm("Редактировать подраздел?")) return false;
				var uID = $(this).attr("unit");
				window.setTimeout("window.location='<?=$baseurl;?>admin/companyedit/"+company+"/subsection/edit/"+uID+"'",500);
			});
			$(".sDel").click(function(){
				if(!confirm("Удалить подраздел?")) return false;
				var uID = $(this).attr("unit");
				window.setTimeout("window.location='<?=$baseurl;?>admin/companyedit/"+company+"/subsection/destroy/"+uID+"'",500);
			});
			$(".pUp").click(function(){
				if(!confirm("Добавить картинки к подразделу?")) return false;
				var uID = $(this).attr("unit");
				window.setTimeout("window.location='<?=$baseurl;?>admin/companyedit/"+company+"/subsection/edit/"+uID+"/upload'",500);
			});
			$(".pDown").click(function(){
				if(!confirm("Удалить картинки с подраздела?")) return false;
				var uID = $(this).attr("unit");
				window.setTimeout("window.location='<?=$baseurl;?>admin/companyedit/"+company+"/subsection/edit/"+uID+"/imagedelete/'",500);
			});
		});
	</script>
</body>
</html>