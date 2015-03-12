<script>
var code = "<?php print $_GET['code']; ?>";
var LANG_LOGIN_ERRCODEAUTH0 = "<?php print LANG_LOGIN_ERRCODEAUTH0; ?>";
var LANG_LOGIN_ERRCODEAUTH1 = "<?php print LANG_LOGIN_ERRCODEAUTH1; ?>";
var LANG_LOGIN_ERRCODECONN0 = "<?php print LANG_LOGIN_ERRCODECONN0; ?>";
var LANG_TOKEN_E0 = "<?php print LANG_TOKEN_E0; ?>";
var LANG_TOKEN_E1 = "<?php print LANG_TOKEN_E1; ?>";

$(function () {        
    $(".FRAME").SlimFrame();
	$(".CHECKBOX").SlimCheckbox();
    $(".INPUT_BUTTON").SlimButton();   
	
	switch(code){
      case "e0Auth":
        SlimAlert(LANG_LOGIN_ERRCODEAUTH0);
        break;
	  case "e1Auth":
        SlimAlert(LANG_LOGIN_ERRCODEAUTH1);
        break;
      case "e0Conn":
        SlimAlert(LANG_LOGIN_ERRCODECONN0);
        break;
	  case "e0Token":
        SlimAlert(LANG_TOKEN_E0);
        break;
	  case "e1Token":
        SlimAlert(LANG_TOKEN_E1);
        break;			
      default:
    }
});
</script>
<input type="hidden" name="redirectFail" value="index.php" />
<input type="hidden" name="redirectPass" value="admin.php" />
<div class="CONTENT">
    <div class="BODY_CONTAINER">	    
        <div class="_FRAME _LOGINFRAME" title="">
             <div style="float: right;width: 399px;">
                <div>
                <p><font size="5"><?php echo LANG_ADMIN_LOGIN_TITLE; ?></font></p>
                <br/>
                </div>
                <div class="_FRAME" title="" style="margin-top: 10px;"><label class="CONTENT_TITLE"><?php echo LANG_LOGIN_TITLE; ?></label>
	            	 	
                        <label class="INPUT_LABEL"><?php echo LANG_LOGIN_USER; ?>:</label>
                        <div class="_INPUT_TEXT">
                        <input id="username" name="username" />
	                    </div><br>
	                    
                        <label class="INPUT_LABEL"><?php echo LANG_LOGIN_PASSWORD; ?>:</label>
                        <div class="_INPUT_TEXT">
                        <input type="password" id="password" name="password"  />
                        </div>

                        <div style=" margin-top: 10px; ">
                             <div class="CHECKBOX">
							 	  <label for="keepsession"><?php echo LANG_LOGIN_KEEPSESSION; ?></label>
								  <input type="checkbox" id="keepsession" name="keepsession" />								  
							 </div> 
                        </div>                

                </div>
					  <p><input type="submit" ID="SUBMIT_F1" class="_INPUT_BUTTON" value="<?php echo LANG_LOGIN_BT1; ?>" style="float:right; margin-right:22px" /></p>
             </div>
                                
       <div style="width:300px; height:300px; float:left; background-repeat:no-repeat;  background-image:url('img/300x300.jpg');float: left;">
		 <div style="width:100%; height:200px;"></div>		
		     <div class="_BKGSTYLE1" style="width:100%; height:50px; padding-top:10px;">
                  <div class="_FRAME _BKGSTYLE1" style="margin-top: 10px;" title="">
                      <label class="CONTENT_TITLE"><?php echo LANG_ADMIN_LOGIN_ACCT1; ?></label><?php echo LANG_ADMIN_LOGIN_ACCT2; ?>                     
		          </div>		
		    </div>
       	</div>
   	  </div>            
   </div>        
</div>
