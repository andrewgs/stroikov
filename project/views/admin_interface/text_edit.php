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
					<a href="<?=$baseurl;?>admin/<?=$text['txt_type'];?>view">&laquo; Вернуться назад</a>
				</div>
				<div class="clear"></div>
				<div class="grid_10 omega">
					<div class="formmailer">
				<?=form_open('admin/textupdate',array('id'=>'formtext'));?>
						<?=form_hidden('type',$text['txt_type']);?>
						<strong>Редактирование содержания:</strong>
						<div class="dd">
							<?=form_textarea(array('name'=>'txtbody','id'=>'txtbody','value'=>$text['txt_body']));?>
						</div>
						<div id="bt_submit"><input name="submit" id="btsubmit" value="Сохранить" class="senden" type="submit"></div>
				<?=form_close();?>	
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="push"></div>	 
	</div>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script>!window.jQuery && document.write('<script src="<?=$baseurl;?>js/libs/jquery-1.6.2.min.js"><\/script>')</script>
	<script type="text/javascript" src="<?=$baseurl;?>js/redactor/redactor.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#txtbody').redactor({toolbar:'mini',css:['blank.css']});
			$("#btsubmit").click(function(){
				if(!confirm("Сохранить информацию?")) return false;
				$("#formtext").submit();
			});
		});
	</script>
</body>
</html>