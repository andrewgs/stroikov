<div class="grid_12 omega" id="messeges" style="display:none;">
<?php for($i=0;$i<count($messages);$i++):?>
	<div class="user_message" id="msg<?=$i;?>" mail="<?=$messages[$i]['iml_id']?>">
		<p>
		<?=$messages[$i]['iml_name'];?> | <?=mailto($messages[$i]['iml_email'],$messages[$i]['iml_email']);?> | <?=$messages[$i]['iml_date'];?>
		</p>
		<p><?=$messages[$i]['iml_text_email'];?></p>
		
		<hr size="2"/>
		<div style="text-align:right;">
			<input type="image" title="Удалить сообщение" class="MsgDel" id="dl<?=$i?>" line="<?=$i;?>" src="<?=$baseurl;?>images/delete.png" />
		</div>
	</div>
<?php endfor;?>
</div>
<div class="clear"></div>
