<?php include("../../config/config.php"); require("../../config/language/".LANG.".php"); ?>
<div class="CONTENT">
<div class="BODY_CONTAINER">
<div class="FRAME">
<form id="Form" action="content/themes.php" >
<div class="FRAME" title="Active Directory integration settings">
<br />
<label class="INPUT_LABEL">Feature: </label>
 			<div id="RADIO1" name="RADIO_A" class="RADIO CHECKED" title="On" ></div>
         	<div id="RADIO2" name="RADIO_A" class="RADIO" title="Off" ></div>
<br />
<label class="INPUT_LABEL">Domain name: </label><div class="_INPUT_TEXT"><input value="<?php print LDAP_DN; ?>" /></div><br />
<label class="INPUT_LABEL">Server name/address: </label><div class="_INPUT_TEXT"><input value="<?php print AD_SERVER_ADDRESS; ?>" /></div><br />
<label class="INPUT_LABEL">Ldap DC name: </label><div class="_INPUT_TEXT"><input value="<?php print DC_1; ?>" /></div><br /> 
<label class="INPUT_LABEL">Ldap DC suffix: </label><div class="_INPUT_TEXT"><input value="<?php print DC_2; ?>" /></div><br />
</div>
<br />
<div class="FRAME" title="Email integration settings">
<br />
<label class="INPUT_LABEL">Feature: </label>
 			<div id="RADIO3" name="RADIO_B" class="RADIO" title="On" ></div>
         	<div id="RADIO4" name="RADIO_B" class="RADIO CHECKED" title="Off" ></div>
<br />
<label class="INPUT_LABEL">Server name/address: </label><div class="_INPUT_TEXT"><input value="<?php print LDAP_MAIL_SN; ?>" /></div><br />
<label class="INPUT_LABEL">Domain name: </label><div class="_INPUT_TEXT"><input value="<?php print LDAP_MAIL_DN; ?>" /></div><br />
<label class="INPUT_LABEL">System account: </label><div class="_INPUT_TEXT"><input value="<?php print LDAP_MAIL_SYSACC; ?>" /></div><br />
<label class="INPUT_LABEL">Account password: </label><div class="_INPUT_TEXT"><input value="<?php print LDAP_MAIL_SYSACCPW; ?>" type="password" /></div><br />
<label class="INPUT_LABEL">Repeat password: </label><div class="_INPUT_TEXT"><input value="" type="password" /></div><br />
</div>
<p><input type="submit" ID="SUBMIT_F1" class="_INPUT_BUTTON" value="<?php print LANG_BT_APPLY; ?>" style="float:right; margin-right:22px" /></p>
</form>
</div>
</div>
</div>