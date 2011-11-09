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
				<div class="grid_10 omega">
					<div class="formmailer" style="width:300px;">
					<?=form_open('admin/profileupdate',array('id'=>'formprofile'));?>
						<?=form_hidden('id',$users['usr_id']);?>
						<strong>Старый пароль</strong>
						<div class="dd">
							<?=form_input(array('type'=>'password','name'=>'oldpass','class'=>'inpval','value'=>''));?>
						</div>
						<strong>Новый пароль</strong>
						<div class="dd">
							<?=form_input(array('type'=>'password','name'=>'newpass','class'=>'inpval','value'=>''));?>
						</div>
						<strong>Подтверждение пароля</strong>
						<div class="dd">
							<?=form_input(array('type'=>'password','name'=>'confirmpass','class'=>'inpval','value'=>''));?>
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
	<script defer src="<?=$baseurl;?>js/jgrowl/jquery.jgrowl.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			<?php if($msg):?>
				$.jGrowl(<?=$msg;?>,{header:'Сообщение'});
			<?php endif;?>
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
					$.jGrowl("Пропущены обязательные поля!",{header:'Форма изменения пароля'});
					event.preventDefault();
				}else{
					if(!confirm("Сменить пароль?")) return false;
					$("#formprofile").submit();
				}
			});
		});
	</script>
</body>
</html>