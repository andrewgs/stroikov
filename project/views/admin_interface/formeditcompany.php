<div class="grid_10 omega">
	<div class="formmailer">
	<?php echo validation_errors(); ?>
	<?=form_open_multipart('admin/companyupdate',array('id'=>'formcompany'));?>
		<?=form_hidden('id',$company['cmp_id']);?>
		<?=form_hidden('oldphoto',$company['cmp_img_src']);?>
		<strong>Название компании:</strong>
		<div class="dd"><input class="inpval" type="text" name="companyname" value="<?=$company['cmp_name'];?>"/></div>
		<strong>Текст сслыки:</strong>
		<div class="dd"><input class="inpval" type="text" name="textlink" value="<?=$company['cmp_text_link'];?>"/></div>
		<hr size="2"/>
		<strong>Фото компании (поддерживаемые форматы: jpeg, png, gif):</strong>
		<input type="file" name="userfile" value="" accept="image/jpeg,png,gif" size="30"/>
	<?php if(isset($company['cmp_img_src']) && !empty($company['cmp_img_src'])):?>
		<div>
			<input type="checkbox" name="companyimgdel" value="delete" id="companyimgdel" style="margin: 10px 0;"/>
			<strong>Удалить фото</strong>
		</div>
	<?php endif;?>
		<strong>Подпись к фото:</strong>
		<div class="dd"><input class="inpval" type="text" name="companyimgalt" value="<?=$company['cmp_img_alt'];?>"/></div>
		<hr size="2"/>
		<strong>О компании:</strong>
		<div class="dd">
			<textarea class="inpval" id="companydescr" name="companydescr" cols="60" rows="4"><?=$company['cmp_descr'];?></textarea>
		</div>
		<strong>Раcширенная информация:</strong>
		<div class="dd">
			<textarea class="inpval" id="companytext" name="companytext" cols="60" rows="4"><?=$company['cmp_text'];?></textarea>
		</div>
		<div id="bt_submit">
			<input name="submit" id="btsabmit" value="Сохранить" class="senden" type="submit">
			<input id="btcancel" value="Отменить" class="senden" type="button">
		</div>						
	<?=form_close();?>	
	</div>
</div>
<div class="clear"></div>