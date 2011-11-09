<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Cache-Control" content="no-cache"/>
    <meta http-equiv="Expires" content="1 Jan 2000 0:00:00 GMT"/>
	<meta name="language" content="ru" />
    <meta name="description" content=<?=$description;?>/>
    <meta name="keywords" content=<?=$keywords;?>/>
    <title><?=$title;?></title>
	<link rel="shortcut icon" type="image/x-icon" href="<?=$baseurl;?>favicon.ico"/>
	<link rel="stylesheet" href="<?=$baseurl;?>css/reset.css" type="text/css" media="screen"/>
	<link rel="stylesheet" href="<?=$baseurl;?>css/960.css" type="text/css" media="screen"/>
	<link rel="stylesheet" href="<?=$baseurl;?>css/style.css" type="text/css" media="screen"/>
<?php if($this->uri->segment(1)=='price'):?>
	<link rel="stylesheet" href="<?=$baseurl;?>css/reset.css" type="text/css" media="print"/>
	<link rel="stylesheet" href="<?=$baseurl;?>css/960.css" type="text/css" media="print"/>
	<link rel="stylesheet" href="<?=$baseurl;?>css/style.css" type="text/css" media="print"/>
	<link rel="stylesheet" href="<?=$baseurl;?>css/print.css" type="text/css" media="print"/>
<?php endif;?>
	<link rel="stylesheet" href="<?=$baseurl;?>css/jquery.jgrowl.css" type="text/css" media="screen"/>
	<link rel="stylesheet" href="<?=$baseurl;?>css/pirobox.css" class="piro_style" title="white" type="text/css" media="screen"/>
	<!--[if lt IE 7.]>
	<script defer type="text/javascript" src="<?=$baseurl;?>js/png.fix.js"></script>
	<link rel="stylesheet" href="<?=$baseurl;?>css/ie6.css" type="text/css" media="screen"/>
	<![endif]-->
	<script type="text/javascript" src="<?=$baseurl;?>js/libs/modernizr-2.0.6.min.js"></script>
</head>