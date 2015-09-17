<head>
<?php include('header.php'); ?>
</head>
<div class="CONTENT">
<div class="BODY_CONTAINER">
<div class="FRAME">
<div class="FRAME" title="Registro de actividades.">
<p><span>Lista de usuarios que poseen registro de actividades.</span></p>
<div id="DIVSEARCH">	 
	 <input type="button" class="_INPUT_BUTTON" onclick="showLogs()" value="Refrescar" style="float:left;" />	 
	 <label class="INPUT_LABEL">Buscar &nbsp; </label><input type="text" id="LISTSEARCH" class="INPUT_TEXT" />	 	 
</div>
<hr />
<p><div class="_CHECKBOX" style="float:left;"><input type="checkbox" id="SHOWONLINE" /><label for="SHOWONLINE">Mostrar solo conectados</label></div></p>
<p><div id="CONTAINER"></div></p>
 	 	
</div>	   
</div>	   
</div>
</div>
