<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">
<?php $this->load->view('users_interface/head');?>
<body>
	<div id="main-wrap">
	<?php $this->load->view('users_interface/admin-panel');?>
		<div id="header">
			<div class="container_12">
				<div id="logo" class="grid_3">
					<?=anchor('','<img src="'.$baseurl.'images/logo.png" alt="Строительная компания Стройковъ"/>');?> 
				</div>
				<div class="grid_9">
					<ul id="header-menu">
						<li><?=anchor('contacts','Контакты');?></li>
						<li><?=anchor('investment','Инвестиции');?><img src="<?=$baseurl;?>images/menu_separator.png" alt="" /></li>		
						<li><?=anchor('partners','Партнеры');?><img src="<?=$baseurl;?>images/menu_separator.png" alt="" /></li>
						<li>
							<?=anchor('units','Объекты',array('class'=>'active'));?>
							<img src="<?=$baseurl;?>images/menu_separator.png" alt="" />
						</li>
						<li><?=anchor('about','О компании');?><img src="<?=$baseurl;?>images/menu_separator.png" alt="" /></li>		
					</ul>
				</div>	
			</div>
			<div class="clear"></div>
		</div>
		<div id="content">
			<div class="container_12">
				<div class="grid_4 omega admin-menu">
					<a href="<?=$baseurl;?>">&laquo; Вернуться на главную</a>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>		
			<div class="container_12">
			<?php $count = 1; ?>
			<?php foreach ($units as $mainunits):?>
				<?php if($count==1 || $count%3 == 0):?>
					<div class="units container_12">
				<?php endif;?>
					<div class="grid_6">
						<a class="thumb" target="_parent" href="<?=$baseurl;?>unitsinfo/<?=$mainunits->unt_id;?>">
							<div class="thumb_labels">
								<h1 class="title"><?=$mainunits->unt_title;?></h1>
								<h1 class="client"><?=$mainunits->unt_client;?></h1>
							</div>
						<?php if(!empty($mainunits->unt_image)):?>
							<div class="thumbimg" style="background: url("<?=$baseurl.$mainunits->unt_image;?>") no-repeat scroll center bottom transparent;">
							<span style="opacity: 1; display: block;"><img alt="" src="<?=$baseurl.$mainunits->unt_image;?>"></span></div>
						<?php endif;?>
							</a>
						</div>
					<?php if($ucount==1 || $count%2==0 || $count==$ucount): ?>
						</div>
						<div class="clear"></div>
					<?php endif;?>
				<?php $count+=1;?>
			<?php endforeach; ?>
			</div>
			<div class="clear"></div>
		<?php if(isset($list) and !empty($list)):?>
			<div class="container_12">
				<div class="grid_12">
					<h1 class="page_header">Полный список объектов ООО СК Стройковъ</h1>
				</div>
				<div class="clear"></div>
			<?php $cntrow = $ucntrow; $k = 0;?>
			<?php for($i=0;$i<3;$i++): ?>
				<?php if(isset($list[$i][0]['id']) && !empty($list[$i][0]['id'])):?>
					<div class="units_list grid_4 omega">
						<ol>
						<?php for($j=0;$j<$cntrow; $j++): 
							if($k>$ucount-1) break;
							$text = $list[$i][$j]['unt_client'];
							$str_uri = $baseurl.'unitsinfo/'.$list[$i][$j]['id']; ?>
							<li><?=anchor($str_uri,$text);?></li>
							<?php $k++; ?>
						<?php endfor;?>
						</ol>
					</div>
				<?php endif;?>
			<?php endfor;?>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		<?php endif; ?>
		</div>
		<div class="push"></div>	 
	</div>
	<?php $this->load->view('users_interface/footer');?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script>!window.jQuery && document.write('<script src="<?=$baseurl;?>js/libs/jquery-1.6.2.min.js"><\/script>')</script>
	<script type="text/javascript" src="<?=$baseurl;?>js/pirobox.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("a.thumb").hover(function(){
				var thumbOver = $(this).find("img").attr("src");
				$(this).find("div.thumbimg").css({'background' : 'url(' + thumbOver + ') no-repeat center bottom'});
				$(this).find("span").stop().fadeTo('fast',0,function(){$(this).hide()}); 
			},function() {$(this).find("span").stop().fadeTo('slow', 1).show();});

			$("a.thumb").hover(
				function(){$(this).find("h1.title , h1.client").animate({ bottom:"0px", opacity: 0 }, 150 );
			}, function() {
				$(this).find("h1.title").animate({ bottom:"57px", opacity: 1 }, 150 );
				$(this).find("h1.client").animate({ bottom:"30px", opacity: 1 }, 150 );
			});
			
			$("a.thumb").hover(
				function(){$(this).find("h1.open").animate({ bottom:"30px", opacity: 1 }, 150 );}, 
				function() {$(this).find("h1.open").animate({ bottom:"10px", opacity: 0	}, 150 );}
			);
		});				
	</script>
 </body>
</html>