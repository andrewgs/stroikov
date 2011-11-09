<div class="grid_10 omega">
	<div class="formmailer">
	<?=form_open_multipart($this->uri->uri_string(),array('id'=>'formcompany'));?>
		<strong>Название компании:</strong>
		<div class="dd"><input class="inpval" type="text" name="companyname" value="<?=set_value('companyname');?>" id="companyname" /></div>
		<strong>Текст сслыки:</strong>
		<div class="dd"><input class="inpval" type="text" name="textlink" value="<?=set_value('textlink');?>" id="textlink" /></div>
		<strong>Псевдоним:</strong>
		<div class="dd"><input class="inpval literal" type="text" name="url" value="<?=set_value('url');?>" id="url" /></div>
		<hr size="2"/>
		<strong>Фото компании (поддерживаемые форматы: jpeg, png, gif):</strong>
		<input class="inpval" type="file" name="userfile" value="" id="companysimage" accept="image/jpeg,png,gif" size="30"/>
		<div class="clear"></div>
		<strong>Подпись к фото:</strong>
		<div class="dd">
			<input class="inpval" type="text" name="companyimgalt" value="<?=set_value('companyimgalt');?>" id="companyimgalt"/>
		</div>
		<hr size="2"/>
		<strong>О компании:</strong>
		<div class="dd">
			<textarea class="inpval" name="companydescr" id="companydescr" cols="60" rows="4"><?=set_value('companydescr');?></textarea>
		</div>
		<strong>Разширенная информация:</strong>
		<div class="dd">
			<textarea name="companytext" id="companytext" cols="60" rows="7"><?=set_value('companytext');?></textarea>
		</div>
		<div id="bt_submit">
			<input name="submit" id="btsabmit" value="Добавить" class="senden" type="submit">
			<input id="btcancel" value="Отменить" class="senden" type="button">
		</div>
	<?=form_close();?>
	</div>
</div>
<div class="clear"></div>