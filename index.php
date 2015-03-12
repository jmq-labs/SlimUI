<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  	<?php session_start(); if(isset($_GET['kill_session'])){ session_destroy(); } require("config/config.php"); require("config/language/".LANG.".php"); ?>
	<?php if ((strpos($_SERVER['HTTP_HOST'],'www.')===false)) { header('Location: '.WWWROOT); exit(); } ?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title><?php print SITE_NAME; ?></title>
	<link href="content/img/<?php print FAVICON; ?>" rel="shortcut icon">
	<link rel='stylesheet' type='text/css' href='content/themes/<?php print THEME; ?>/css/style.css' />	    
    <?php include('config/header.php'); ?>
 
    <script>
  	var IMG_DIR = "<?php print IMG_DIR; ?>";
	var THEME = "<?php print THEME; ?>";
	var WWWROOT = "<?php print WWWROOT; ?>";
	var ELOGS = "<?php print ELOGS; ?>";
	var FILTER_BY = "<?php print FILTER_BY; ?>";
	var DEVICE_TYPE = "<?php print @$DEVICE_TYPE; ?>";
	var AJAX_CACHE = "<?php print AJAX_CACHE; ?>";
  	var LANG_MAIN_CLOSESESSION = "<?php print LANG_MAIN_CLOSESESSION; ?>";
  	var LANG_MAIN_CLOSESESSIONMSG = "<?php print LANG_MAIN_CLOSESESSIONMSG; ?>";	
  	var LANG_MAIN_CLOSESESSIONMSGBTY = "<?php print LANG_MAIN_CLOSESESSIONMSGBTY; ?>";
  	var LANG_MAIN_CLOSESESSIONMSGBTN = "<?php print LANG_MAIN_CLOSESESSIONMSGBTN; ?>";		
	</script>
	   
	<script type="text/javascript" src="content/scripts/jquery/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="content/scripts/jquery/jquery-ui.min.js"></script>
    <script type="text/javascript" src="content/scripts/slim-ui-1.0.min.js"></script>
	<script type="text/javascript" src="content/scripts/browserversion.js"></script>
    <script type="text/javascript" src="content/scripts/src.min.js"></script>

</head>
<body class="_BODY">
    <div>
        <div id="MAIN_MENU" class="DIV_WIDGET">	    
	    <img id="WM_LOGO" class="IMG_LOGO" src="<?php print IMG_DIR.START_MENU_IMG; ?>" />
            <div class="SEPARATOR" style="top:0px; height:40px; border-left:1px solid rgba(255, 255, 255, 0.33);"></div>
            <img id="WM_LOGO_DROPMENU" class="IMG_LOGO_SELECTOR _VOID" src="<?php print IMG_DIR; ?>arrowdown.png" />
	       <div id="USER_SESSION_DATA" class="USER_PROFILE"></div>
	       <div id="MENU_CONTAINER"></div>
        </div>        
        <div id="WIDGET_MENU" class="WIDGET_CONTAINER" ></div>  
    </div>
	<div id="MAIN_CONTAINER"></div>
	<div id="HISTORY_WIDGETS"></div>
	<canvas id='RENDERS'></canvas> 
</body>
</html>
