<?php include("../../config/config.php"); require("../../config/language/".LANG.".php"); ?>
<div class="CONTENT">
<div class="BODY_CONTAINER">
<div class="FRAME">
<form id="Form" action="content/appnew.php" >
<div class="FRAME" title="Create new application">
<br />
<label class="INPUT_LABEL">App name: </label>	  <div class="_INPUT_TEXT"><input /></div><br />
<label class="INPUT_LABEL">Description: </label>  <div class="_TEXT_AREA"><textarea></textarea></div><br />
<label class="INPUT_LABEL">URL: </label>		  <div class="_INPUT_TEXT"><input value="apps/myapp/index.php" /></div><br />
<label class="INPUT_LABEL">Icon: </label>		  <div class="_INPUT_TEXT"><input value="apps/myapp/app-icon.png" /></div><br />
<label class="INPUT_LABEL">Database connector: </label> <div class="SEARCH_LIST" icon="../content/themes/<?php print THEME; ?>/icons/dropdown.png" value="None" READONLY >
                                               		<span class="INPUT_BUTTON">None</span>                                               					
                                           		  </div><br />
<br />
<label class="INPUT_LABEL">Widget color: </label> <div class="COLOR_PICKER">
	   							  		 		  	<div class="COLOR_BOX" style="background-color:#3553A5"></div>
	   							  		 		    <div class="COLOR_BOX" style="background-color:#008080"></div>
													<div class="COLOR_BOX" style="background-color:#0080C0"></div>													
													<div class="COLOR_BOX" style="background-color:#8080FF"></div>													
													<div class="COLOR_BOX" style="background-color:#CE2222"></div>
													<div class="COLOR_BOX" style="background-color:#B33D3D"></div>
													<div class="COLOR_BOX" style="background-color:#A45858"></div>
													<div class="COLOR_BOX" style="background-color:#BE357A"></div>
													<div class="COLOR_BOX" style="background-color:#86357A"></div>
													
													<div class="COLOR_BOX" style="background-color:#0144F0"></div>													
													<div class="COLOR_BOX" style="background-color:#6A44F4"></div>
													<div class="COLOR_BOX" style="background-color:#6A05F0"></div>
													<div class="COLOR_BOX" style="background-color:#5D0C8D"></div>
													<div class="COLOR_BOX" style="background-color:#A119FD"></div>
													<div class="COLOR_BOX" style="background-color:#A148F0"></div>
													<div class="COLOR_BOX" style="background-color:#F14AF0"></div>
													<div class="COLOR_BOX" style="background-color:#566430"></div>																																							
													<div class="COLOR_BOX" style="background-color:#8E8F40"></div>
													
													<div class="COLOR_BOX" style="background-color:#FF691D"></div>
													<div class="COLOR_BOX" style="background-color:#FF9840"></div>
													<div class="COLOR_BOX" style="background-color:#F0DA00"></div>													
													<div class="COLOR_BOX" style="background-color:#008000"></div>
													<div class="COLOR_BOX" style="background-color:#00A400"></div>
													<div class="COLOR_BOX" style="background-color:#549C5D"></div>
													<div class="COLOR_BOX" style="background-color:#646464"></div>
													<div class="COLOR_BOX" style="background-color:#2F2F2F"></div>
													<div class="COLOR_BOX" style="background-color:#000000"></div>		
												  </div>
												  <br />
</div><br />
<p><input type="submit" ID="SUBMIT_F1" class="_INPUT_BUTTON" value="<?php echo LANG_BT_CREATE; ?>" style="float:right; margin-right:22px" /></p>
</form>
</div>
</div>
</div>