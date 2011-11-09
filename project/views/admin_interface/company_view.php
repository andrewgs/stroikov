<!DOCTYPE html>	
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">
<?php $this->load->view('admin_interface/head');?>
<body>
    <div id="main-wrap">
		<?php $this->load->view('admin_interface/admin-panel');?>
		<?php $this->load->view('admin_interface/header');?>
		<div id="content">
			<div class="container_12">
				<div class="grid_7 omega admin-menu">
					<a href="<?=$baseurl;?>admin/control-panel">&laquo; Панель управления</a>
					<a href="" id="insCmp">Добавить компанию</a>
				</div>
				<div class="clear"></div>
				<div id="frmInsCmp" style="display:none;">
					<?php $this->load->view('admin_interface/forminscompany');?>
				</div>
				<div class="grid_12">
					<div id="cp-company-list">
						<div class="user_message">
							<hr size="2"/>
					<?php for($i=0;$i<count($company);$i++):?>
							<div class="company-name" id="cmp<?=$i;?>" cmp="<?=$company[$i]['cmp_id']?>">
								<?=anchor($company[$i]['cmp_url'],$company[$i]['cmp_name'],array('target'=>'_blank'));?>
								<div style="float:right;">
								<input type="image" title="Редактировать" class="CmpEdit" line="<?=$i;?>" src="<?=$baseurl;?>images/edit.png" />
								<input type="image" title="Удалить" class="CmpDel" line="<?=$i;?>" src="<?=$baseurl;?>images/delete.png" />
								</div>
								<hr size="2"/>
							</div>
					<?php endfor;?>
						</div>
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
			
			$("#insCmp").click(function(event){
				event.preventDefault();
				$("#validError").text('');
				if($("#frmInsCmp").is(":hidden")){
					$("#insCmp").text("Отменить добавление");
					$("#frmInsCmp").slideDown("slow");
					$("html, body").animate({scrollTop:170+'px'},"slow");
				}else{
					$("#frmInsCmp").slideUp("slow",function(){
						$("#frmInsCmp").hide();
						$("#insCmp").text("Добавить компанию");
						$(".inpval").val('');
						$("#companytext").val('');
						$(".empty").remove();
					 });
				}
			});
			
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
					$.jGrowl("Пропущены обязательные поля!",{header:'Форма добавления компании'});
					event.preventDefault();
				}else{
					if(!confirm("Добавить компанию?")) return false;
					$("#formcompany").submit();
				}
			});
			
			$("#btcancel").click(function(){
				$("#frmInsCmp").slideUp("slow",function(){
					$("#frmInsCmp").hide();
					$("#insCmp").text("Добавить компанию");
					$(".inpval").val('');
					$("#companytext").val('');
					$(".empty").remove();
				 });
			});
			$(".CmpEdit").click(function(){
				if(!confirm("Редактировать компанию?")) return false;
				var curID = $(this).attr("line");
				var cmpID = $("#cmp"+curID).attr("cmp");
				window.setTimeout("window.location='<?=$baseurl;?>admin/companyedit/"+cmpID+"'",500);
			});
			$(".CmpDel").click(function(){
				if(!confirm("Удалить компанию?")) return false;
				var curID = $(this).attr("line");
				var cmpID = $("#cmp"+curID).attr("cmp");
				$.post(
					"<?=$baseurl;?>admin/delete-company",
					{'id':cmpID},
					function(data){
						if(data.status){
							$("#cmp"+curID).fadeOut("slow",function(){$("#cmp"+curID).remove();});
							$.jGrowl("Компания удалена",{header:'Список компаний'});
						}else
							$.jGrowl(data.message,{header:'Список компаний'});
					},"json");
			});
		});
	</script>
</body>
</html>