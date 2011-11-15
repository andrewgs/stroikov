<style type="text/css">
	.phone { height: 20px; left: 794px; position: relative; top: 10px; width: 160px; }
	.phone .code { color: #454037; font-size: 16px; left: -70px; position: absolute; text-align: right; width: 65px; }								
	.phone ins { color: #454037; font-size: 30px; font-weight: bold; padding: 0; }
	.phone a { color: #454037; display: block; font: 12px trebuchet MS, serif; margin-top: -3px; text-decoration: underline; }
</style>

<div id="header">
	<div class="container_12">
		<div class="grid_12">
			<div class="phone">
				<div class="code">+7 (863)</div>
				<ins>295-51-10</ins>
				<?=anchor('contacts','контактная информация');?>
			</div>
		</div>
		<div class="clear"></div>
		<div id="logo" class="grid_3">
			<?=anchor('','<img src="'.$baseurl.'images/logo.png" alt="Строительная компания Стройковъ"/>');?> 
		</div>
		<div class="grid_9">
			<ul id="header-menu">
				<li><?=anchor('contacts','Контакты');?></li>
				<li><?=anchor('investment','Инвестиции');?><img src="<?=$baseurl;?>images/menu_separator.png" alt="" /></li>		
				<li><?=anchor('partners','Партнеры');?><img src="<?=$baseurl;?>images/menu_separator.png" alt="" /></li>
				<li><?=anchor('units','Объекты');?><img src="<?=$baseurl;?>images/menu_separator.png" alt="" /></li>
				<li><?=anchor('about','О компании');?><img src="<?=$baseurl;?>images/menu_separator.png" alt="" /></li>		
			</ul>
		</div>	
	</div>
	<div class="clear"></div>
</div>