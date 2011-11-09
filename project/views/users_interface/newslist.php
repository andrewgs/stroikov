<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">
<?php $this->load->view('users_interface/head');?>
<body>
    <div id="main-wrap">
	<?php $this->load->view('users_interface/admin-panel');?>
		<?php $this->load->view('users_interface/header');?>
		<div id="content">
			<div class="container_12">
				<div class="grid_4 omega admin-menu">
					<a href="<?=$baseurl;?>">&laquo; Вернуться на главную</a>
				</div>
				<div class="clear"></div>
			</div>		
			<div class="container_12">
				<div class="grid_12 omega">
			<?php foreach ($news['query'] as $news):?>
					<div class="news-item">
						<div class="news-date"><?=$news->nws_date;?></div>
						<div class="news-header"><a name="news_<?=$news->nws_id;?>"></a>
						<?php if(isset($news->nws_img_src) and !empty($news->nws_img_src)):?>
							<img class="plain-image left w240" alt="<?=$news->nws_img_alt;?>" src="<?=$baseurl.$news->nws_img_src;?>"/>
						<?php endif;?>
							<?=$news->nws_header;?>
						</div>
						<div class="plain-text" style="text-align:justify;"><?=$news->nws_body;?></div>
					</div>
					<div class="clear"></div>
				<?php endforeach;?>
				<?php if($pages):?>
					<div class="pager">
						<?=$pages;?>
					</div> 
				<?php endif;?>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="push"></div>	 
	</div>
	<?php $this->load->view('users_interface/footer');?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script>!window.jQuery && document.write('<script src="<?=$baseurl;?>js/libs/jquery-1.6.2.min.js"><\/script>')</script>
</body>
</html>