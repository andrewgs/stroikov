<?= form_open($this->uri->uri_string(),array('id'=>'formlogin')); ?>
	<strong>Логин:</strong>
	<div class="dd"><input class="inpval" type="text" name="login-name" value="" id="usrlogin" /></div>
	<div class="clear"></div>
	<strong>Пароль:</strong>
	<div class="dd"><input class="inpval" type="password" name="login-pass" id="usrpassword" value="" /></div>
	<div class="clear"></div>
	<div id="bt_submit"><input name="submit" id="btsubmit" value="Авторизация" class="senden" type="submit"></div>
<?= form_close(); ?>