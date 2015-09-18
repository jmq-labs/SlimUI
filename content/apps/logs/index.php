<head>
<?php include('header.php'); include('language/'.LANG.'.php'); ?>
</head>
<div class="CONTENT">
<div class="BODY_CONTAINER">
<div class="FRAME">
<div class="FRAME" title="<?php echo APPLANG_LOGS_HEADER; ?>">
<p><span><?php echo APPLANG_LOGS_DESCRIPTION; ?></span></p>
<div id="DIVSEARCH">	 
	 <input type="button" class="_INPUT_BUTTON" onclick="showLogs()" value="<?php echo APPLANG_LOGS_REFRESHBT; ?>" style="float:left;" />	 
	 <input type="text" placeholder="<?php echo APPLANG_LOGS_SEARCHBT; ?>" id="LISTSEARCH" class="INPUT_TEXT" />	 	 
</div>
<hr />
<p><div class="_CHECKBOX" style="float:left;"><input type="checkbox" id="SHOWONLINE" /><label for="SHOWONLINE"><?php echo APPLANG_LOGS_SHOWONLINECHKBX; ?></label></div></p>
<p><div id="CONTAINER"></div></p>

</table><hr /><p><label><b><?php echo APPLANG_LOGS_ARCHIVESIZE; ?>: </b><span id="archivesize"></span> Mb</label>
<label style='float:right'><b><?php echo APPLANG_LOGS_USERSONLINE; ?>: </b><span id="onlinecount"></span></label></p>
 	 	
</div>	   
</div>	   
</div>
</div>
