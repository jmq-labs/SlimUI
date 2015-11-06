<?php 
if(isset($_SESSION[$UQID.'token'])){ 
	if($_SESSION[$UQID.'token'] != md5(TOKENSTR + $_SESSION[$UQID.'uid'])){
		unset($_SESSION[$UQID.'token']);
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
parent.setSession("<?php print $_SESSION[$UQID.'user_displayname']; ?>","<?php print $_SESSION[$UQID.'token']; ?>"); 
</script>
<div class="CONTENT">
    <div class="BODY_CONTAINER">	    
        <div class="_FRAME" title="">                          
           <div class="_FRAME" title="" style="margin-top: 10px;"><label class="CONTENT_TITLE"><?php echo LANG_TOKEN_TITLE; ?></label>		  
        </div>       
   </div>        
</div>