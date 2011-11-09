<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">
<?php $this->load->view('users_interface/head');?>
<body>
    <div id="main-wrap">
	<?php $this->load->view('users_interface/admin-panel');?>
		<?php $this->load->view('users_interface/header');?>
		<div id="content">
			<div id="company-news">
			<?=anchor('news','<h2>Новости компании</h2>');?>
			<?php for($i=0;$i<count($news);$i++):?>
				<div class="news-item">
					<div class="news-header">
				<?php if(isset($news[$i]['nws_img_src']) && !empty($news[$i]['nws_img_src'])): ?>
					<a href="<?=$baseurl;?>newsview/<?=$news[$i]['nws_id'];?>">
					<img class="plain-image left w90" alt="<?=$news[$i]['nws_img_alt'];?>" src="<?=$baseurl.$news[$i]['nws_img_src'];?>"/></a>	
				<?php endif;?>
						<?=$news[$i]['nws_header'];?>
					</div>				
					<div class="news-body"><?=$news[$i]['nws_body'];?></div>
					<div class="clear"></div>
					<div class="news-link">
						<?=anchor('newsview/'.$news[$i]['nws_id'],'Читать далее &raquo;');?>
					</div>
				</div>
			<?php endfor; ?>
			</div>
			<div id="company-list">
				<h2>Группа компаний</h2>
			<?php for($i=0;$i<count($company);$i++):?>
				<div class="company-item">
					<div class="company-name plain-link">
						<?=anchor('company/'.$company[$i]['cmp_id'],$company[$i]['cmp_name']);?>
					</div>
					<div class="company-descr">
				<?php if(isset($company[$i]['cmp_img_src']) && !empty($company[$i]['cmp_img_src'])): ?>
					<img class="plain-image left w150" alt="<?=$company[$i]['cmp_img_alt'];?>" src="<?=$baseurl.$company[$i]['cmp_img_src']?>"/>
				<?php endif;?>
						<?=$company[$i]['cmp_descr'];?>
					</div>
					<div class="clear"></div>
					<div class="company-link">
						<?=anchor($company[$i]['cmp_url'],$company[$i]['cmp_text_link'].' &raquo');?>
					</div>
				</div>
			<?php endfor; ?>				
			</div>
			<div class="clear"></div>
		</div>
		<div class="push"></div>	 
	</div>
	<?php $this->load->view('users_interface/footer');?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script>!window.jQuery && document.write('<script src="<?=$baseurl;?>js/libs/jquery-1.6.2.min.js"><\/script>')</script>
</body>
</html>