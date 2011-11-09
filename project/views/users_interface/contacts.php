<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">
<?php $this->load->view('users_interface/head');?>
<body>
	<div id="main-wrap">
		<?php $this->load->view('users_interface/admin-panel');?>
		<div id="header">
			<div class="container_12">
				<div id="logo" class="grid_3">
					<?=anchor('','<img src="'.$baseurl.'images/logo.png" alt="Строительная компания Стройковъ"/>');?> 
				</div>
				<div class="grid_9">
					<ul id="header-menu">
						<li><?=anchor('contacts','Контакты',array('class'=>'active'));?></li>
						<li><?=anchor('investment','Инвестиции');?><img src="<?=$baseurl;?>images/menu_separator.png" alt="" /></li>		
						<li><?=anchor('partners','Партнеры');?><img src="<?=$baseurl;?>images/menu_separator.png" alt="" /></li>
						<li><?=anchor('units','Объекты');?><img src="<?=$baseurl;?>images/menu_separator.png" alt="" /></li>
						<li><?=anchor('about','О компании');?><img src="<?=$baseurl;?>images/menu_separator.png" alt="" /></li>		
					</ul>
				</div>	
			</div>
			<div class="clear"></div>
		</div>
		<div id="content">
			<div class="container_12">
				<div class="grid_4 omega admin-menu">
					<a href="<?=$baseurl;?>">&laquo; Вернуться на главную</a>
				</div>
				<div class="clear"></div>
			</div>		
			<div class="container_12">
				<?php $this->load->view('users_interface/formsendmail');?>
				<div class="visit-card grid_4">
					<h3 class="mb20">Прямые контакты</h3>
					<p><?=$contacts['cnt_post_index'];?><br/>
					<?=$contacts['cnt_city'];?><br/>
					<?=$contacts['cnt_street'].', '.$contacts['cnt_house'];?><br/><br/>
					Тел/факс: <?=$contacts['cnt_telfax'];?><br/>
					E-mail: <?=safe_mailto($contacts['cnt_email'],$contacts['cnt_email'])?></p>
				</div>
				<div class="clear"></div>					
			</div>
			<div class="clear"></div>
		</div>
		<!-- content finish -->
		<div class="push"></div>
	</div>
	<?php $this->load->view('users_interface/footer');?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script>!window.jQuery && document.write('<script src="<?=$baseurl;?>js/libs/jquery-1.6.2.min.js"><\/script>')</script>
	<script defer src="<?=$baseurl;?>js/jgrowl/jquery.jgrowl.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#btn").click(function(event){
				event.preventDefault();
				var err = false;
				$(".empty").remove();
				var name = $("#your_name").val();
			 	var email = $("#email").val();
			 	var comments = $("#msg").val();
				$(".inpval").each(function(i,element){
					if($(this).val()===''){
						err = true;
						$(this).after('<img class="empty" src="<?=$baseurl;?>images/tick-red.png" title="Поле не может быть пустым"/>');
					}
				});
				if(err){
					$.jGrowl("Пропущены обязательные поля!",{header:'Форма обратной связи'});
				}else if(!isValidEmailAddress(email)){
					$("#email").after('<img class="empty" src="<?=$baseurl;?>images/tick-red.png" title="Не верный адрес E-Mail"/>');
					$.jGrowl("Не верный адрес E-Mail",{header:'Форма обратной связи'});
				}else{
					$.post("<?=$baseurl;?>send-mail",
						{'name':name,'email':email,'comments':comments},
						function(data){
							if(data.status){
								$.jGrowl("Сообщение отправлено!",{header:'Форма обратной связи',beforeClose: function(e,m){$(".inpval").css('border-color','#C0C0C0 #D9D9D9 #D9D9D9');$(".inpval").val(''); $(".empty").remove();}});
							}else $.jGrowl("Сообщение не отправлено!",{header:'Форма обратной связи'});
						},"json");
				}
			});
			function isValidEmailAddress(emailAddress){
				var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
				return pattern.test(emailAddress);
			};
		});
	</script>
</body>
</html>