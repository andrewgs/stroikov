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
					<a href="<?=$baseurl.$backpath;?>">&laquo; Вернуться назад</a>
				</div>
				<div class="clear"></div>
				<div class="grid_10 omega">
					<div class="formmailer">
						<?php
							$attr = array('name' => 'formsubsectionnew','id' => 'formsubsection');
							echo form_open_multipart('admin/subsectioninsert',$attr);
							echo form_hidden('cmpid',$this->uri->segment(3));
							echo form_hidden('backpath',$backpath);
							echo form_error('sbstitle').'<div class="clear"></div>';
							echo form_label('Название подраздела','sbslabel');
								$attr = array('name'=>'sbstitle','class'=>'inpval','value'=>set_value('sbstitle'));
							echo '<div class="dd">'.form_input($attr).'</div>';
							echo '<hr>';
							echo form_label('Фото подраздела (поддерживаемые форматы: jpeg, png, gif)','sbslabel');
							$attr = array('type'=>'file','name'=>'userfile','class'=>'inpval','accept'=>'image/jpeg,png,gif','size'=>'30');
							echo '<div>'.form_input($attr).'</div>';
							echo form_label('Подпись к фото','sbslabel');
							$attr = array('name'=>'sbsimgalt','class'=>'inpval','value'=>'','maxlength'=>'70','size'=>'40');
							echo '<div class="dd">'.form_input($attr).'</div>';
							echo '<hr>';
							echo form_error('sbstext').'<div class="clear"></div>';
							echo form_label('Описание подраздела','companylabel');
							$attr =array('name'=>'sbstext','id'=>'sbstext','class'=>'inpval','value'=>set_value('sbstext'));
							echo '<div class="dd">'.form_textarea($attr).'</div>';
							$attr =array('name' => 'btsabmit','id' =>'btnsubmit','value'=>'Добавить','class'=>'senden');
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
	<script type="text/javascript" src="<?=$baseurl;?>js/redactor/redactor.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			
			$('#sbstext').redactor({toolbar:'mini',css:['blank.css']});
			
			<?php if($msg):?>
				$.jGrowl(<?=$msg;?>,{header:'Сообщение'});
			<?php endif;?>
			
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
					$.jGrowl("Пропущены обязательные поля!",{header:'Форма добавления подраздела'});
					event.preventDefault();
				}else{
					if(!confirm("Добавить подраздел?")) return false;
					$("#formsubsection").submit();
				}
			});
		});
	</script>
</body>
</html>