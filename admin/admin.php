<?php session_start(); if(!isset($_SESSION['_token'])){ header('location: index.php'); } ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" >

    <title>SlimUI</title>
	<?php session_start(); include("../config/config.php"); include("../config/language/".LANG.".php"); ?> 
	<link rel='stylesheet' type='text/css' href='../content/themes/<?php print SYS_THEME; ?>/css/style.css' />  
	<link rel="stylesheet" type="text/css" href="../content/css/slim-ui-1.0.css" />
	<link rel="stylesheet" type="text/css"  href="css/style.css" /> 
 
    <script>
	var code = "<?php print $_GET['code']; ?>";
	var AUTH_USERFIRSTNAME = "<?php print $_SESSION['_firstname']; ?>";
	
	var LANG_MAIN_WELCOME = "<?php print LANG_MAIN_WELCOME; ?>";
	var LANG_MAIN_CLOSESESSION = "<?php print LANG_MAIN_CLOSESESSION; ?>";
	var LANG_MAIN_CLOSESESSIONMSG = "<?php print LANG_MAIN_CLOSESESSIONMSG; ?>";	
	var LANG_MAIN_CLOSESESSIONMSGBTY = "<?php print LANG_MAIN_CLOSESESSIONMSGBTY; ?>";
	var LANG_MAIN_CLOSESESSIONMSGBTN = "<?php print LANG_MAIN_CLOSESESSIONMSGBTN; ?>";	
	</script>
	   
	<script type="text/javascript" src="../content/scripts/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="../content/scripts/jquery-ui.min.js"></script>
	<script type="text/javascript" src="../content/scripts/md5.js"></script>
	
    <script type="text/javascript" src="../content/scripts/slim-ui-1.0.min.js"></script>
	<script type="text/javascript" src="scripts/src-min.js"></script>
	
</head>
<body>
<?php require('menu-top.php'); ?>
<div class="BODY_CONTAINER FULL_WIDTH INNER_CONTAINER">
  <?php require('menu-left.php'); ?>
  <div class="MAIN_PANE_CONTAINER">
    <div id="MAIN_PANE">
    </div>  
  </div>    
</div>
<div id="FOOTER"></div>
</body>
</html>