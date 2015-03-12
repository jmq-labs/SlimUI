<?php 
session_start();
if(isset($_SESSION['token'])){ 
	if($_SESSION['token'] != md5(utf8_encode(TOKENSTR)+$_SESSION['uid'])){
		unset($_SESSION['token']);
		header('Location: master.php?page=login.php&code=e0Token', true, 302);
		exit;
	}
}else{
    session_destroy();
    header('Location: master.php?page=login.php&code=e1Token', true, 302);
    exit;
}

?>
<script>
parent.setSession("<?php print $_SESSION['user_displayname']; ?>","<?php print $_SESSION['token']; ?>"); 
</script>
<div class="CONTENT">
    <div class="BODY_CONTAINER">	    
        <div class="_FRAME" title="">                          
           <div class="_FRAME" title="" style="margin-top: 10px;"><label class="CONTENT_TITLE"><?php echo LANG_TOKEN_TITLE; ?></label>		  
        </div>       
   </div>        
</div>