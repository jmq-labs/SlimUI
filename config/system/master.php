<?PHP session_start();
	if(@$_GET['getheaders']){  ?>	
	<?php require("../../config/config.php"); require("../../config/language/".LANG.".php"); ?>
	<?php if(isset($DEVICE_TYPE) AND $DEVICE_TYPE=="MOBILE" AND MOBILE_ENABLED=="true"){ ?>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>	
	<link rel="stylesheet" type="text/css" href="<?php echo WWWROOT; ?>content/css/_fonts/opensans.css" />	
	<link rel="stylesheet" type="text/css" href="<?php echo WWWROOT; ?>content/themes/<?php echo THEME; ?>/css/style.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo WWWROOT; ?>content/css/jquery-ui-1.10.0.custom.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo WWWROOT; ?>content/css/_mobile/slim-ui.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo WWWROOT; ?>content/css/_mobile/iframe.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo WWWROOT; ?>content/plugins/timepicker/jquery-ui-timepicker.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo WWWROOT; ?>content/plugins/mask/qunit-1.11.0.css" />	
	<?php }else{ ?>
	<link rel="stylesheet" type="text/css" href="<?php echo WWWROOT; ?>content/css/_fonts/opensans.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo WWWROOT; ?>content/themes/<?php echo THEME; ?>/css/style.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo WWWROOT; ?>content/css/jquery-ui-1.10.0.custom.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo WWWROOT; ?>content/css/slim-ui.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo WWWROOT; ?>content/css/iframe.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo WWWROOT; ?>content/plugins/timepicker/jquery-ui-timepicker.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo WWWROOT; ?>content/plugins/mask/qunit-1.11.0.css" />
	<?php } ?>
<?php exit; } ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    
	<?php require("../../config/config.php"); require("../../config/language/".LANG.".php"); ?>
	<link rel="stylesheet" type="text/css" href="../../content/css/_fonts/opensans.css" />
	<link rel="stylesheet" type="text/css" href="../../content/themes/<?php echo THEME; ?>/css/style.css" />
    <link rel="stylesheet" type="text/css" href="../../content/css/jquery-ui-1.10.0.custom.min.css" />	
    <?php if(isset($DEVICE_TYPE) AND $DEVICE_TYPE=="MOBILE" AND MOBILE_ENABLED=="true"){ ?>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
	<link rel="stylesheet" type="text/css" href="../../content/css/_mobile/slim-ui.css" />
	<link rel="stylesheet" type="text/css" href="../../content/css/_mobile/iframe.css" />
	<?php }else{ ?>
	<link rel="stylesheet" type="text/css" href="../../content/css/slim-ui.css" />
	<link rel="stylesheet" type="text/css" href="../../content/css/iframe.css" />
	<?php } ?>
	
	<script>		 
		var code = "<?php if(isset($_GET['code'])){ print $_GET['code']; } ?>"; 
		var isAsp = "<?php if(isset($_GET['asp'])){ print $_GET['asp']; } ?>";
		var postback = "<?php if(isset($_GET['postback'])){ print $_GET['postback']; } ?>";
		var url = "<?php if(isset($_GET['page'])){ print $_GET['page']; } ?>";
		var safeMode = parent.$("#" + window.frameElement.id).attr("safemode");
		var WKDIR = "<?php if(isset($_GET['page'])){ print dirname($_GET['page'])."/"; } ?>";		
	</script>
	
    <script type="text/javascript" src="../../content/scripts/jquery/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="../../content/scripts/jquery/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../../content/scripts/slim-ui.min.js"></script>
	<script type="text/javascript" src="../../content/scripts/slim-ui-api.js" ></script>
	<script type="text/javascript" src="../../content/scripts/iframe-min.js" ></script>
	
	<!-------------------------------------- Plugins ------------------------------------------->
	
	<link rel="stylesheet" type="text/css" href="../../content/plugins/timepicker/jquery-ui-timepicker.css" />
	<link rel="stylesheet" type="text/css" href="../../content/plugins/mask/qunit-1.11.0.css" />
	<script type="text/javascript" src="../../content/plugins/timepicker/jquery-ui-timepicker.js" ></script>
	<script type="text/javascript" src="../../content/plugins/mask/qunit-1.11.0.js" ></script>
	<script type="text/javascript" src="../../content/plugins/mask/jquery.mask.js" ></script>		
	
</head>
<body>    
	<?php if(@$_GET['auth']==true){ ?>
	<form id="form1" action="../../config/auth.php?uqid=<?php print @$UQID; ?>" method="post" ><?php } ?>	
      <div id="INCLUDE_FRAME">
  		<?php if(!@$_GET['asp']){ include(@$_GET['page']); }?>
      </div>
	<?php if(@$_GET['auth']==true){ ?>    
	</form><?php } ?>
</body>
</html>
