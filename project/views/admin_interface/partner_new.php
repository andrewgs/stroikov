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
					<a href="<?=$baseurl;?>admin/partnersview">&laquo; Вернуться к списку партнеров</a>
				</div>
				<div class="clear"></div>
				<div class="grid_10 omega">
					<div class="formmailer" style="width:300px;">
					<?=form_open('admin/partnerinsert',array('id'=>'formpartner'));?>
						<strong>Название партнера:</strong>
						<div class="dd">
							<?=form_input(array('name'=>'partnername','class'=>'inpval','value'=>set_value('partnername')));?>
						</div>
						<strong>Web-адрес партнера:</strong>
						<div class="dd">
							<?=form_input(array('name'=>'partnerhref','value'=>set_value('partnerhref')));?>
						</div>
						<div id="bt_submit"><input name="submit" id="btsubmit" value="Добавить" class="senden" type="submit"></div>
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
	<script defer src="<?=$baseurl;?>js/jgrowl/jquery.jgrowl.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			
			$("#btsubmit").click(function(event){
				var err = false;
				$(".empty").remove();
				$(".inpval").each(function(i,element){
					if($(this).val()===''){
						err = true;
						$(this).after('<img class="empty" src="<?=$baseurl;?>images/tick-red.png" title="Поле не может быть пустым"/>');
					}
				});
				if(err){
					$.jGrowl("Пропущены обязательные поля!",{header:'Форма добавления партнера'});
					event.preventDefault();
				}else{
					if(!confirm("Добавить партнера?")) return false;
					$("#formpartner").submit();
				}
			});
		});
	</script>
</body>
</html>