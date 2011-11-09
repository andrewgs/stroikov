<!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru"> 
<?php $this->load->view('admin_interface/head');?>
<body>
	<div id="main-wrap">
		<?php $this->load->view('admin_interface/header');?>
		<div id="content">
			<div class="container_12">
				<div class="grid_7">
					<div class="formmailer" style="width:300px;">
				<?php $this->load->view('admin_interface/formlogin');?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="push"></div>	 
	</div>
	<?php $this->load->view('users_interface/footer');?>
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
					$.jGrowl("Пропущены обязательные поля!",{header:'Форма обратной связи'});
					event.preventDefault();
				}else
					$("#formlogin").submit();
			});
		});
	</script>
</body>
</html>