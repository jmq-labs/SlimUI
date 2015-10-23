<?php error_reporting(0); ?>
<script>
$(function(){
	$("#LABEL_CURVER").html(parent.VERSION);
	$("#UProc").hide();
});
function Update(){
	$("#Start").hide("fade",300,function(){ 
		$("#UProc").show("fade",300,function(){
			$("#LOG").append("downloading <?php print $_GET['package']; ?>...<br />");	
			Step(1,"<?php print UPDATE_SERVER.'/'.$_GET['package']; ?>",function(){ 
				$("#LOG").append("download completed! <br />");	
				$("#STEP1").css("font-weight","bold");  
    			/*******************************************/
				$("#LOG").append("extracting files... <br />");	
    			Step(2,"<?php print $_GET['build']; ?>",function(){ 
    				$("#LOG").append("extraction completed! <br />");
    				$("#STEP2").css("font-weight","bold");
					/*******************************************/
    				$("#LOG").append("backup settings... <br />");	
        			Step(3,"<?php print BUILD; ?>",function(){
						$("#LOG").append("backup completed! <br />");	
						$("#STEP3").css("font-weight","bold");        				
						/*******************************************/
          				$("#LOG").append("updating files... <br />");	
              			Step(4,"<?php print $_GET['build']; ?>",function(){
							$("#LOG").append("update completed! <br />");	
							$("#STEP4").css("font-weight","bold");             				
							/*******************************************/
              				$("#LOG").append("erasing temporary files... <br />");	
                  			Step(5,false,function(){
								$("#LOG").append("erase completed! <br />");	
								$("#STEP5").css("font-weight","bold");                 				
								/*******************************************/
                  				$("#LOG").append("updating settings... <br />");	
                      			Step(6,"<?php print $_GET['build'].';'.BUILD.';'.$_GET['newver']; ?>",function(){
									$("#LOG").append("software update completed! <br />");	
									$("#STEP6").css("font-weight","bold");
									parent.SlimAlert("<?php print LANG_SOFT_UPDATE_MSG_COMPLETE; ?>");
                      			});
                  			}); 
              			}); 
        			});
    			});
			});			
		}); 
	});
}
function Step(i,param,fn){
    $.ajax({
	  async: true,
      url: "update/process.php?step=" + i + "&param=" + param,
    }).done(function(data){
	  if(fn){ fn(); }
    }).fail(function(jqXHR, textStatus){
	  $("#LOG").append(textStatus +"<br>");
	  parent.SlimAlert("<?php print LANG_SOFT_UPDATE_MSG_ERROR; ?>");
	});
 }
</script>     
<div class="CONTENT">
	 <div class="BODY_CONTAINER">
	 	<div class="FRAME">
       	    <div class="FRAME" title="<?php print LANG_SOFT_UPDATE_SWUTITLE; ?>">
				<br />
				<?php if($DEVICE_TYPE != "MOBILE"){ ?>
    			<div class="NAV" style="float:left;">
    				 <p><label id="STEP1"><?php print LANG_SOFT_UPDATE_STEP1; ?></label></p>
    				 <p><label id="STEP2"><?php print LANG_SOFT_UPDATE_STEP2; ?></label></p>
    				 <p><label id="STEP3"><?php print LANG_SOFT_UPDATE_STEP3; ?></label></p>
    				 <p><label id="STEP4"><?php print LANG_SOFT_UPDATE_STEP4; ?></label></p>
    				 <p><label id="STEP5"><?php print LANG_SOFT_UPDATE_STEP5; ?></label></p>
    				 <p><label id="STEP6"><?php print LANG_SOFT_UPDATE_STEP6; ?></label></p>
    			</div>
				<?php } ?>
        		<div class="PROCESS" style="<?php if($DEVICE_TYPE != "MOBILE"){ ?> float:right; border-left:1px #ccc solid; padding:0px 30px 30px; height:250px; <?php } ?>" >
					 <div id="Start" style="text-align:center; <?php if($DEVICE_TYPE != "MOBILE"){ ?> width: 400px; height:200px; padding:10px 20px 20px; <?php } ?>">
					 	  <label><?php print LANG_SOFT_UPDATE_LABEL1; ?></label><br />
						  <label><?php print LANG_SOFT_UPDATE_LABEL2; ?>: </label><b><label id="LABEL_CURVER"></label></b><label> <?php print LANG_SOFT_UPDATE_LABEL3; ?>: </label><b><label><?php print $_GET['newver']; ?></label></b>
						  <br />
						  <input type="button" class="INPUT_BUTTON" onclick="Update()" value="<?php print LANG_SOFT_UPDATE_BT1; ?>" style="margin-top:10px;"/>
					 </div>
					 <div id="UProc">
    					 <label><?php print LANG_SOFT_UPDATE_UPROC_TITLE; ?></label>
    					 <hr />
    					 <div style="height: 200px; <?php if($DEVICE_TYPE != "MOBILE"){ ?> width: 400px; <?php } ?> overflow-y: scroll; padding:10px 20px 0px; background-color: #eee;"><code id="LOG"></code></div>
					 </div>					 
				</div>
			</div>
		</div>            
	</div>        
</div>
