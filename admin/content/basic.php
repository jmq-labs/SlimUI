<?php include("../../config/config.php"); require("../../config/language/".LANG.".php"); ?>
<div class="CONTENT">
<div class="BODY_CONTAINER">
<div class="FRAME">
<form id="Form" action="content/themes.php" >
<div class="FRAME" title="Basic settings">
<br />
<label class="INPUT_LABEL">Site name: </label><div class="_INPUT_TEXT"><input  value="<?php print SITE_NAME; ?>" /></div><br />
<label class="INPUT_LABEL">Language: </label><div class="SEARCH_LIST" icon="../content/themes/<?php print THEME; ?>/icons/dropdown.png" value="<?php print LANG; ?>" READONLY >
    		<span class="INPUT_BUTTON">English</span>
    		<span class="INPUT_BUTTON">Español</span>			
</div>
</div>
<p><input type="submit" ID="SUBMIT_F1" class="_INPUT_BUTTON" value="<?php echo LANG_BT_APPLY; ?>" style="float:right; margin-right:22px" /></p>
</form>
</div>
</div>
</div>