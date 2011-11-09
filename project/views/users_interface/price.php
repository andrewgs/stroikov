<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">
<?php $this->load->view('users_interface/head');?>
<body>
	<div id="main-wrap">
	<?php $this->load->view('users_interface/admin-panel');?>
		<?php $this->load->view('users_interface/header');?>
		<div id="content">
			<div class="container_12"><?=$text;?></div>
			<div class="clear"></div>
		</div>
	</div>
	<?php $this->load->view('users_interface/footer');?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script>!window.jQuery && document.write('<script src="<?=$baseurl;?>js/libs/jquery-1.6.2.min.js"><\/script>')</script>
</body>
</html>