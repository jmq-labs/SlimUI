<?php session_start(); if(isset($_GET['kill_session'])){ session_destroy(); }else{ if(isset($_SESSION['_keepsession'])){ header('location: admin.php'); }} ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" >

    <title>SlimUI</title>
	<?php include("../config/config.php"); include("../config/language/".LANG.".php"); ?>
	<link rel='stylesheet' type='text/css' href='../content/themes/<?php print SYS_THEME; ?>/css/style.css' />    
    <link rel="stylesheet" type="text/css" href="../content/css/slim-ui-1.0.css" />
	<link rel="stylesheet" type="text/css"  href="css/style.css" /> 
 
    <script>	
	var LANG_MAIN_CLOSESESSION = "<?php print LANG_MAIN_CLOSESESSION; ?>";
	var LANG_MAIN_CLOSESESSIONMSG = "<?php print LANG_MAIN_CLOSESESSIONMSG; ?>";	
	var LANG_MAIN_CLOSESESSIONMSGBTY = "<?php print LANG_MAIN_CLOSESESSIONMSGBTY; ?>";
	var LANG_MAIN_CLOSESESSIONMSGBTN = "<?php print LANG_MAIN_CLOSESESSIONMSGBTN; ?>";	
	</script>
	   
	<script type="text/javascript" src="../content/scripts/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="../content/scripts/jquery-ui.min.js"></script>	
    <script type="text/javascript" src="../content/scripts/slim-ui-1.0.min.js"></script>

</head>
<body class="_BODY">
	<form id="form1" action="auth.php" method="post" >	
      	<div>
		<?php require('login.php'); ?>
		</div>
	</form>
</body>
</html>