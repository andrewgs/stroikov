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
					<a href="<?=$baseurl;?>admin/investmentview">&laquo; Вернуться к списку объектов</a>
				</div>
				<div class="clear"></div>
				<div class="grid_10 omega">
					<div class="formmailer">
					<?=form_open('admin/investmeninsert',array('id'=>'forminvestmen'));?>
						<strong>Название объекта инвестиции</strong>
						<div class="dd">
						<?=form_input(array('name'=>'objectname','class'=>'inpval','value'=>set_value('objectname'),'style'=>'width:455px;'));?>
						</div>
						<strong>Информация о инвестиционном проекте</strong>
						<div class="dd">
				<?=form_textarea(array('name'=>'investmentext','class'=>'inpval','id'=>'investmentext','value'=>set_value('investmentext')));?>
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
	<script type="text/javascript" src="<?=$baseurl;?>js/redactor/redactor.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#investmentext').redactor({toolbar:'mini',css:['blank.css']});
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
					$.jGrowl("Пропущены обязательные поля!",{header:'Форма добавления проекта'});
					event.preventDefault();
				}else{
					if(!confirm("Добавить проект?")) return false;
					$("#forminvestmen").submit();
				}
			});
		});
	</script>
</body>
</html>