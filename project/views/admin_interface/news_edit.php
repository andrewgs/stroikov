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
					<a href="<?=$baseurl;?>admin/newsview">&laquo; Вернуться к списку новостей</a>
				</div>
				<div class="clear"></div>
				<div class="grid_10 omega">
					<div class="formmailer">
				<?php foreach ($news as $news):?>
					<?=form_open_multipart('admin/newsupdate',array('id'=>'formnews'));?>
						<?=form_hidden('id',$this->uri->segment(3));?>
						<?=form_hidden('oldphoto',$news->nws_img_src);?>
						<strong>Дата новости</strong>
						<div class="dd">
<?=form_input(array('name'=>'date','id'=>'datepicker','class'=>'inpval','readonly'=>'readonly','style'=>'width:100px;','value'=>$news->nws_date));?>
						</div>
						<hr size="2"/>
						<div>
							<strong>Фото объекта (поддерживаемые форматы: jpeg, png, gif)</strong>
					<?=form_input(array('type'=>'file','name'=>'userfile','accept'=>'image/jpeg,png,gif','size'=>'30'));?>
						</div>
						<strong>Подпись к фото:</strong>
						<div class="dd">
							<?=form_input(array('name'=>'newsimgalt','value'=>set_value('newsimgalt')));?>
						</div>
						<hr size="2"/>
					<?php if(isset($news->nws_img_src) && !empty($news->nws_img_src)):?>
						<div>
				<?=form_checkbox(array('name'=>'newsimgdel','id'=>'newsimgdel','value'=>'delete','cheched'=>FALSE,'style'=>'margin: 10px 0'));?>
							<strong> Удалить фото</strong>
						</div>
					<?php endif;?>
						<strong>Подпись к фото:</strong>
						<div class="dd">
							<?=form_input(array('name'=>'newsimgalt','value'=>$news->nws_img_alt));?>
						</div>
						<hr size="2"/>
						<strong>Аннотация</strong>
						<div class="dd">
						<?=form_textarea(array('name'=>'newsheader','id'=>'newsheader','class'=>'inpval','value'=>$news->nws_header));?>
						</div>
						<strong>Текст новости</strong>
						<div class="dd">
						<?=form_textarea(array('name'=>'newsbody','id'=>'newsbody','class'=>'inpval','value'=>$news->nws_body));?>
						</div>
						<div id="bt_submit"><input name="submit" id="btsubmit" value="Добавить" class="senden" type="submit"></div>
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
	<script type="text/javascript" src="<?=$baseurl;?>js/datepicker/jquery.ui.core.js"></script>
	<script type="text/javascript" src="<?=$baseurl;?>js/datepicker/jquery.ui.datepicker-ru.js"></script>
	<script type="text/javascript" src="<?=$baseurl;?>js/datepicker/jquery.ui.datepicker.js"></script>
	<script type="text/javascript" src="<?=$baseurl;?>js/datepicker/jquery.ui.widget.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#newsheader").redactor({toolbar:'mini',css:['blank.css']});
			$("#newsbody").redactor({toolbar:'mini',css:['blank.css']});
			$("#datepicker").datepicker($.datepicker.regional['ru']);
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
					$.jGrowl("Пропущены обязательные поля!",{header:'Форма добавления новости'});
					event.preventDefault();
				}else{
					if(!confirm("Добавить новость?")) return false;
					$("#formnews").submit();
				}
			});
		});
	</script>
</body>
</html>