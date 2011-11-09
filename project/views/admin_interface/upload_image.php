<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">
<?php $this->load->view('admin_interface/head');?>
<body>
    <div id="main-wrap">
		<?php $this->load->view('admin_interface/admin-panel');?>
		<?php $this->load->view('admin_interface/header');?>
		<div id="content">
		<div class="container_12">
				<div class="grid_8 omega admin-menu">
					<a href="<?=$baseurl.$backpath;?>">&laquo; Вернуться назад</a>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
			<div class="container_12">
				<div class="grid_7">
					<div class="message">
						Выбирите картинку и нажмите кнопку "Загрузить".<br />(Поддерживаемые форматы: jpeg, png, gif)
					</div>
					<div class="clear"></div>
				</div>
				<div class="grid_10 omega">
					<div class="formmailer">
					<?php
						echo form_open_multipart($settings['form'],array('id' => 'formunits'));
						echo form_hidden('path',$settings['path']);
						echo form_hidden('type',$settings['type']);
						echo '<p>'.$settings['msg'].'</p>';
						echo '<hr>';
						echo form_label('Описание фото','partnerlabel');
						$attr = array('name'=>'imagetitle','id'=>'imagetitle','value'=>'');
						echo '<div class="dd">'.form_input($attr).'</div>';
						$attr = array('type'=>'file','name'=>'userfile','class'=>'inpval','accept'=>'image/jpeg,png,gif','size'=>'30');
						echo '<div>'.form_input($attr).'</div>';
						echo '<hr>';
						$attr =array('name'=>'btsabmit','id'=>'btnsubmit','value'=>'Загрузить','class'=>'senden');
						echo '<div id="bt_submit">'.form_submit($attr).'</div>';							
						echo form_close();?>
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
			$("#btnsubmit").click(function(event){
				var err = false;
				$(".empty").remove();
				$(".inpval").each(function(i,element){
					if($(this).val()===''){
						err = true;
						$(this).after('<img class="empty" src="<?=$baseurl;?>images/tick-red.png" title="Поле не может быть пустым"/>');
					}
				});
				if(err){
					$.jGrowl("Пропущены обязательные поля!",{header:'Форма загрузки картинок'});
					event.preventDefault();
				}else{
					if(!confirm("Добавить картинку?")) return false;
					$("#formunits").submit();
				}
			});
			<?php if($msg):?>
				$.jGrowl(<?=$msg;?>,{header:'Сообщение'});
			<?php endif;?>
		});
	</script>
</body>
</html>