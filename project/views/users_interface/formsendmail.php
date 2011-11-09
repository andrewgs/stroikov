<div class="grid_8">
	<div class="formmailer" id="kontakt">
		<p>Используйте данную контактную форму, чтобы связаться с нами. Вы также можете написать нам напрямую по электронной почте. Для этого нажмите на ссылку:
		<?=safe_mailto('info@sk-stroikov.ru','info@sk-stroikov.ru');?>
		<br/><br/>
		</p>
		<?php
			$attr = array('name' => 'form','id' => 'formsendmail');
			echo form_open('send-mail',$attr);
				echo form_error('your_name').'<div class="clear"></div>';
				$attr = array('for'=>'your_name');									
				echo form_label('Ваше имя','your_name',$attr);
				$attr = array('name'=>'your_name','id'=>'your_name','class'=>'y_name inpval','value'=>set_value('your_name'),'maxlength'=> '50','size' => '45');
				echo '<div class="dd_name">'.form_input($attr).'</div>';
				echo form_error('email').'<div class="clear"></div>';
				$attr = array('for'=>'email');
				echo form_label('E-Mail','email',$attr);
				$attr = array('name'=>'email','id'=>'email','class'=>'y_email inpval','value'=>set_value('email'),'maxlength'=>'50','size' => '45');
				echo '<div class="dd_mail">'.form_input($attr).'</div>';
				echo form_error('msg').'<div class="clear"></div>';
				$attr = array('for'=>'msg');
				echo form_label('Сообщение','msg',$attr);
				$attr =array('name'=>'msg','id' =>'msg','class'=>'y_msg inpval','value'=> set_value('msg'),'cols'=>'40','rows'=>'5');
				echo '<div class="dd_msg">'.form_textarea($attr).'</div>';
				$attr =array('name'=>'Submit','class'=>'senden','id'=>'btn','value'=>'Отправить','border'=>'0');
				echo form_submit($attr);
			echo form_close(); ?>
		<p>&nbsp;</p>					
	</div>					
</div>