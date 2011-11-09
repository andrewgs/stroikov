<!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru"> 
<?php $this->load->view('admin_interface/head');?>
<body>
    <div id="main-wrap">
		<?php $this->load->view('admin_interface/admin-panel');?>
		<?php $this->load->view('admin_interface/header');?>
		<div id="content">
			<div class="container_12">
				<hr size="2"/>
				<div class="grid_6 omega">
					<a class="admin-chapter" href="<?=$baseurl;?>admin/company">Список групп компаний &rarr;</a>
					<a class="admin-chapter" href="<?=$baseurl;?>admin/unitsview">Список объектов &rarr;</a>
					<a class="admin-chapter" href="<?=$baseurl;?>admin/partnersview">Список партнеров &rarr;</a>
					<a class="admin-chapter" href="<?=$baseurl;?>admin/investmentview">Инвестиции &rarr;</a>
					<a class="admin-chapter" href="<?=$baseurl;?>admin/uploadimage">Интерфейс загрузки фотографий &rarr;</a>
				</div>
				<div class="grid_6 omega">
					<a class="admin-chapter" href="<?=$baseurl;?>admin/aboutedit">О компании &rarr;</a>
					<a class="admin-chapter" href="<?=$baseurl;?>admin/newsview">Новости компании &rarr;</a>
					<a class="admin-chapter" href="<?=$baseurl;?>admin/priceview">Прайс-листа &rarr;</a>
					<a class="admin-chapter" href="<?=$baseurl;?>admin/contactsview">Контакты &rarr;</a>
					<a class="admin-chapter" href="<?=$baseurl;?>admin/profile">Смена пароля администратора</a>
				</div>
				<div class="clear"></div>
				<hr size="2"/>
				<?php if(count($messages)):?>
					<a class="admin-chapter" id="msg" href="" title="Нажмите для просмотра">Есть входящие сообщения</a>
					<?php $this->load->view('admin_interface/emails_view');?>
				<?php endif;?>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script>!window.jQuery && document.write('<script src="<?=$baseurl;?>js/libs/jquery-1.6.2.min.js"><\/script>')</script>
<?php if(count($messages)):?>
	<script defer src="<?=$baseurl;?>js/jgrowl/jquery.jgrowl.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#msg").click(function(){$("#messeges").fadeToggle();return false});
			$(".MsgDel").click(function(){
				if(!confirm("Удалить сообщение?")) return false;
				var curID = $(this).attr("line");
				var msgID = $("#msg"+curID).attr("mail");
				$.post(
					"<?=$baseurl;?>admin/delete-message",
					{'id':msgID},
					function(data){
						if(data.status){
							$("#msg"+curID).fadeOut("slow",function(){$("#msg"+curID).remove();});
							$.jGrowl("Сообщение удалено",{header:'Сообщения от пользователей'});
						}else
							$.jGrowl(data.message,{header:'Сообщения от пользователей'});
					},"json");
			});
		});
	</script>
<?php endif;?>
 </body>
</html>