<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">
<?php $this->load->view('admin_interface/head');?>
<body>
    <div id="main-wrap">
		<?php $this->load->view('admin_interface/admin-panel');?>
		<?php $this->load->view('admin_interface/header');?>
		<div id="content">
			<div class="container_12">
				<div class="grid_12 omega admin-menu">
					<a href="<?=$baseurl;?>admin/company">&laquo; Вернуться к списку компаний</a>
					<a href="<?=$baseurl;?>admin/companyedit/<?=$this->uri->segment(3);?>/upload">Загрузить фото &raquo;</a>
					<a href="<?=$baseurl;?>admin/companyedit/<?=$this->uri->segment(3);?>/imagedelete">Удалить фото &raquo;</a>
				<?php if(!$subsection):?>
					<a href="<?=$baseurl;?>admin/companyedit/<?=$this->uri->segment(3);?>/subsection/create">Создать подраздел &raquo;</a>
				<?php else:?>
					<a href="<?=$baseurl;?>admin/companyedit/<?=$this->uri->segment(3);?>/subsections">Подразделы &raquo;</a>
				<?php endif;?>
				</div>
				<div class="clear"></div>
				<?php $this->load->view('admin_interface/formeditcompany');?>
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
			
			$('#companytext').redactor({toolbar:'mini',css:['blank.css']});
			$('#companydescr').redactor({toolbar:'mini',css:['blank.css']});
			
			<?php if($msg):?>
				$.jGrowl(<?=$msg;?>,{header:'Сообщение'});
			<?php endif;?>
			
			$(".literal").keypress(function(e){
				if(e.which!=8 && e.which!=0 && e.which!=45 && (e.which<97 || e.which>122)){return false;}
			});
			
			$("#btsabmit").click(function(event){
				var err = false;
				$(".empty").remove();
				$(".inpval").each(function(i,element){
					if($(this).val()===''){
						err = true;
						$(this).after('<img class="empty" src="<?=$baseurl;?>images/tick-red.png" title="Поле не может быть пустым"/>');
					}
				});
				if(err){
					$.jGrowl("Пропущены обязательные поля!",{header:'Форма редактирования компании'});
					event.preventDefault();
				}else{
					if(!confirm("Сохранить информацию?")) return false;
					$("#formcompany").submit();
				}
			});
			
			$("#btcancel").click(function(){window.setTimeout("window.location='<?=$baseurl;?>admin/company'",500);});
		});
	</script>
</body>
</html>