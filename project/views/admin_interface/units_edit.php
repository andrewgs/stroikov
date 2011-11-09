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
					<a href="<?=$baseurl;?>admin/unitsview">&laquo; Вернуться к списку объектов</a>
					<a href="<?=$baseurl;?>admin/unitsedit/<?=$this->uri->segment(3);?>/upload">Загрузить фото &raquo;</a>
					<a href="<?=$baseurl;?>admin/unitsedit/<?=$this->uri->segment(3);?>/imagedelete">Удалить фото &raquo;</a>
				</div>
				<div class="clear"></div>
				<div class="grid_10 omega">
					<div class="formmailer">
				<?php foreach($unit as $unit):?>
					<?=form_open_multipart('admin/unitsupdate',array('id' => 'formunits'));?>
						<?=form_hidden('id',$this->uri->segment(3));?>
						<?=form_hidden('oldphoto',$unit->unt_image);?>
						<?=form_hidden('oldsmallphoto',$unit->unt_small_image);?>
						<strong>Юрид.адрес объекта:</strong>
						<div class="dd">
							<?=form_input(array('name'=>'unitstitle','class'=>'inpval','value'=>$unit->unt_title));?>
						</div>
						<strong>Название объекта:</strong>
						<div class="dd">
							<?=form_input(array('name'=>'unitsclient','class'=>'inpval','value'=>$unit->unt_client));?>
						</div>
						<hr size="2"/>
						<div>
							<strong>Фото объекта (поддерживаемые форматы: jpeg, png, gif)</strong>
						<?=form_input(array('type'=>'file','name'=>'userfile','accept'=>'image/jpeg,png,gif','size'=>'30'));?>
						</div>
						<strong>Подпись к фото:</strong>
						<div class="dd">
							<?=form_input(array('name'=>'unitsimgalt','value'=>$unit->unt_img_alt));?>
						</div>
						<hr size="2"/>
						<strong>Описание объекта:</strong>
						<div class="dd">
						<?=form_textarea(array('name'=>'unitsbody','id'=>'unitsbody','class'=>'inpval','value'=>$unit->unt_body));?>
						</div>
						<div id="bt_submit"><input name="submit" id="btsubmit" value="Сохранить" class="senden" type="submit"></div>
					<?=form_close();?>
				<?php endforeach;?>
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
			$("#unitsbody").redactor({toolbar:'mini',css:['blank.css']});
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
					$.jGrowl("Пропущены обязательные поля!",{header:'Форма редактирования объекта'});
					event.preventDefault();
				}else{
					if(!confirm("Сохранить информацию?")) return false;
					$("#formunits").submit();
				}
			});
		});
	</script>
</body>
</html>