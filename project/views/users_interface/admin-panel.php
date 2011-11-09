<?php if($admin['status']): ?>
	<div id="admin-panel">
		<span>Вы вошли как Администратор</span>
		<a class="logout" href="<?=$baseurl;?>admin/control-panel">Управление</a>
		<a class="logout" href="<?=$baseurl;?>admin/logoff">Завершить сеанс</a>
	</div>
<?php endif; ?>