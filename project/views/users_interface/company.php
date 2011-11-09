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
			<div class="clear"></div>
			<div class="container_12">			
				<div class="grid_12">
				 	<div class="company-item">
						<div class="company-name">
							<?=$company['cmp_name']; ?>
						</div>
						<div class="plain-text">
						<?php if(isset($company['cmp_img_src']) and !empty($company['cmp_img_src'])): ?>
						<img class="plain-image left w220" alt="<?=$company['cmp_img_alt']; ?>" src="<?=$baseurl.$company['cmp_img_src'];?>"/>
						<?php endif; ?>
							<?=$company['cmp_descr'];?>
						</div>
						<div class="clear"></div>
						<div class="plain-text"><?=$company['cmp_text']?></div>
					</div>
					<div class="clear"></div>
					<?php
					if(isset($company['slideshow_img_src']) and !empty($company['slideshow_img_src']))
						echo '<a class="pirobox_company slideshow-view" href="'.$baseurl.$company['slideshow_img_src'].'" title="'.$company['slideshow_img_title'].'">Просмотреть  фотографии&rarr;</a>';
								
					if(isset($images) and !empty($images)){
						$nom = 2; 
						echo '<div style="display:none;">';
						for($i = 0; $i < $company['index']; $i++){
							if(isset($images[$i]['id'])){
								echo '<a class="pirobox_company" href="'.$baseurl.$images[$i]['image'].'" title="'.$images[$i]['title'].'">Фотография #'.$nom.'</a>';
								$nom++;	
								}
							}
						echo '</div>';
					}
					echo '<div class="clear"></div>';
					?>	
					
				</div>
				<div class="clear"></div>
				<div class="grid_12">
				<?
				if(isset($subsection) and !empty($subsection)){
					for($i = 0; $i < count($subsection); $i++){
						echo '<div class="plain-text">'.
							'<h4>'.$subsection[$i]['sbs_title'].'</h4>';
						if(isset($subsection[$i]['sbs_img']) and !empty($subsection[$i]['sbs_img']))
							echo '<img class="plain-image left w220" alt="'.$subsection[$i]['sbs_alt'].'" src="'.$baseurl.$subsection[$i]['sbs_img'].'"/>';
						echo $subsection[$i]['sbs_text'].'</div><div class="clear"></div>';
						
						if(isset($subsection[$i]['slideshow_img_src']) and !empty($subsection[$i]['slideshow_img_src']))
							echo '<a class="pirobox_'.$i.' slideshow-view" href="'.$baseurl.$subsection[$i]['slideshow_img_src'].'" title="'.$subsection[$i]['slideshow_img_title'].'">Просмотреть  фотографии&rarr;</a>';
								
						if(isset($sbsimages) and !empty($sbsimages)){
							$nom = 2; 
							echo '<div style="display:none;">';
							for($j = 0; $j < $subsection[$i]['index']; $j++)
								if(isset($sbsimages[$i][$j]['id'])){
									echo '<a class="pirobox_'.$i.'" href="'.$baseurl.$sbsimages[$i][$j]['image'].'" title="'.$sbsimages[$i][$j]['title'].'">Работа #'.$nom.'</a>';
								$nom++;	
								}
							echo '</div><div class="clear"></div>';
						}
					}
				}
				?>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="push"></div>	 
	</div>
	<?php $this->load->view('users_interface/footer');?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script>!window.jQuery && document.write('<script src="<?=$baseurl;?>js/libs/jquery-1.6.2.min.js"><\/script>')</script>
	<script type="text/javascript" src="<?=$baseurl;?>js/pirobox.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$().piroBox({my_speed: 400,bg_alpha: 0.1,slideShow : true,slideSpeed : 6,close_all : '.piro_close, .piro_overlay'});
		});
	</script>
 </body>
</html>