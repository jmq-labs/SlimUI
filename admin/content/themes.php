<?php include("../../config/config.php"); require("../../config/language/".LANG.".php"); ?>
<div class="CONTENT">
<div class="BODY_CONTAINER">
<div class="FRAME">
<form id="Form" action="content/themes.php" >
<div class="FRAME" title="Select default theme for client UI">
	 <div style="float:left;">	 	
		<span>Choose a color scheme for the client user interface.</span><br /><br />		
		<div class="SEARCH_LIST" icon="../content/themes/<?php print THEME; ?>/icons/dropdown.png" value="<?php print THEME; ?>" READONLY >
    		<span class="INPUT_BUTTON">default</span>
    		<span class="INPUT_BUTTON">slim-blue</span>			
		</div>
		
	 </div>
</div>
<br />
<div class="FRAME" title="Select default theme for admin UI">
	 <div style="float:left;">
	 	<span>Choose a color scheme for the administration panel user interface.</span><br /><br />		
		<div class="SEARCH_LIST" icon="../content/themes/<?php print THEME; ?>/icons/dropdown.png" value="<?php print SYS_THEME; ?>" READONLY >
    		<span class="INPUT_BUTTON">default</span>
    		<span class="INPUT_BUTTON">slim-blue</span>			
		</div>				  
	 </div>
</div>
<p><input type="submit" ID="SUBMIT_F1" class="_INPUT_BUTTON" value="<?php echo LANG_BT_APPLY; ?>" style="float:right; margin-right:22px" /></p>
</form>
</div>
</div>
</div>
