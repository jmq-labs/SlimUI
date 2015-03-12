<?php include("../../config/config.php"); require("../../config/language/".LANG.".php"); ?>
<div class="CONTENT">
<div class="BODY_CONTAINER">
<div class="FRAME">
<form id="Form" action="content/database.php" >
<div class="FRAME" title="SlimUI database">
<br />
<label class="INPUT_LABEL">Server name/address: </label><div class="_INPUT_TEXT"><input value="<?php print DBSERVER; ?>" /></div><br />
<label class="INPUT_LABEL">Database: </label><div class="_INPUT_TEXT"><input value="<?php print DBNAME; ?>" /></div><br />
<label class="INPUT_LABEL">Username: </label><div class="_INPUT_TEXT"><input value="<?php print DBUSER; ?>" /></div><br />
<label class="INPUT_LABEL">Password: </label><div class="_INPUT_TEXT"><input type="password" value="<?php print DBPASS; ?>" /></div><br />
</div>
<br />
<div class="FRAME" title="Apps database connectors">
<label class="INPUT_LABEL">DBMS Engine: </label><div class="SEARCH_LIST" icon="../content/themes/<?php print THEME; ?>/icons/dropdown.png" value="MySQL" READONLY >
    		<span class="INPUT_BUTTON">MySQL</span>
    		<span class="INPUT_BUTTON">MsSQL</span>						
</div>
<input type="submit" ID="SUBMIT_F1" class="_INPUT_BUTTON" value="<?php print LANG_BT_PLUS; ?>" />
</div>
<p><input type="submit" ID="SUBMIT_F1" class="_INPUT_BUTTON" value="<?php print LANG_BT_APPLY; ?>" style="float:right; margin-right:22px" /></p>
</form>
</div>
</div>
</div>