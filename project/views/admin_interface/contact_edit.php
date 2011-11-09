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
					<a href="<?=$baseurl;?>admin/contactsview">&laquo; Вернуться назад</a>
				</div>
				<div class="clear"></div>
				<div class="grid_10 omega">
					<div class="formmailer">
				<?=form_open('admin/contactupdate',array('id'=>'formcontact'));?>
					<?=form_hidden('id',$this->uri->segment(3));?>
					<strong>Почтовый индекс</strong>
					<div class="dd">
						<?=form_input(array('name'=>'postindex','class'=>'inpval','value'=>$contacts['cnt_post_index']));?>
					</div>
					<strong>Населенный пункт</strong>
					<div class="dd">
						<?=form_input(array('name'=>'city','class'=>'inpval','value'=>$contacts['cnt_city']));?>
					</div>
					<strong>Улица</strong>
					<div class="dd">
						<?=form_input(array('name'=>'street','class'=>'inpval','value'=>$contacts['cnt_street']));?>
					</div>
					<strong>Дом</strong>
					<div class="dd">
						<?=form_input(array('name'=>'house','class'=>'inpval','value'=>$contacts['cnt_house']));?>
					</div>
					<strong>Тел./Факс</strong>
					<div class="dd">
						<?=form_input(array('name'=>'telfax','class'=>'inpval','value'=>$contacts['cnt_telfax']));?>
					</div>
					<strong>E-mail</strong>
					<div class="dd">
						<?=form_input(array('name'=>'email','class'=>'inpval','value'=>$contacts['cnt_telfax']));?>
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
					$.jGrowl("Пропущены обязательные поля!",{header:'Форма редактирования контактов'});
					event.preventDefault();
				}else{
					if(!confirm("Сохранить информацию?")) return false;
					$("#formnews").submit();
				}
			});
		});
	</script>
</body>
</html>