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
					<a href="<?=$baseurl;?>admin/companyedit/<?=$this->uri->segment(3);?>/subsections">&laquo; Вернуться назад</a>
				</div>
				<div class="clear"></div>
				<div class="grid_10 omega">
					<div class="formmailer">
					<?=form_open_multipart('admin/subsectionupdate',array('id'=>'formsubsection'));?>
						<?=form_hidden('id',$subsections['sbs_id']);?>
						<?=form_hidden('cmpid',$subsections['sbs_cmp_id']);?>
						<?=form_hidden('oldphoto',$subsections['sbs_img']);?>
						<strong>Название подраздела</strong>
						<div class="dd">
							<?=form_input(array('name'=>'sbstitle','class'=>'inpval','value'=>$subsections['sbs_title']));?>
						</div>
						<hr size="2"/>
						<div>
							<strong>Фото объекта (поддерживаемые форматы: jpeg, png, gif)</strong>
						<?=form_input(array('type'=>'file','name'=>'userfile','accept'=>'image/jpeg,png,gif','size'=>'30'));?>
						</div>
						<strong>Подпись к фото:</strong>
						<div class="dd">
							<?=form_input(array('name'=>'unitsimgalt','value'=>$subsections['sbs_alt']));?>
						</div>
						<hr size="2"/>
						<?php if($subsections['sbs_img']):?>
						<div>
				<?=form_checkbox(array('name'=>'sbsimgdel','id'=>'newsimgdel','value'=>'delete','cheched'=>FALSE,'style'=>'margin: 10px 0'));?>
							<strong> Удалить фото</strong>
						</div>
					<?php endif;?>
						<strong>Подпись к фото:</strong>
						<div class="dd">
							<?=form_input(array('name'=>'sbsimgalt','value'=>$subsections['sbs_alt']));?>
						</div>
						<hr size="2"/>
						<strong>Описание подраздела</strong>
						<div class="dd">
						<?=form_textarea(array('name'=>'sbstext','id'=>'sbstext','class'=>'inpval','value'=>$subsections['sbs_text']));?>
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
	<script type="text/javascript" src="<?=$baseurl;?>js/redactor/redactor.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#sbstext").redactor({toolbar:'mini',css:['blank.css']});
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
					$.jGrowl("Пропущены обязательные поля!",{header:'Форма редактирования подраздела'});
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