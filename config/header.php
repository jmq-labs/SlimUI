<?php session_start();  ?>
<?php if(isset($DEVICE_TYPE) AND $DEVICE_TYPE=="MOBILE" AND MOBILE_ENABLED=="true"){   
   $_SESSION['_ISMOBILE']="true"; ?>
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
   <link rel="stylesheet" type="text/css" href="content/css/_mobile/slim-ui-1.0.css" />
   <link rel="stylesheet" type="text/css" href="content/css/_mobile/style.css" />
<?php }else{
   $_SESSION['_ISMOBILE']=NULL; ?>
   <link rel="stylesheet" type="text/css" href="content/css/slim-ui-1.0.css" />
   <link rel="stylesheet" type="text/css" href="content/css/style.css" />
   <?php    
} ?>