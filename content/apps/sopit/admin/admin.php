<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('header.php'); ?>
</head>
<body>
<div class="CONTENT">
<div class="BODY_CONTAINER">
<div class="FRAME">
<div class="FRAME" title="Administración de Tickets">
<div id="MENU_CONTAINER">	 
	<label class="INPUT_LABEL" >Resultados: </label>
		<select id="ITEMS" class="_COMBO_BOX" style="margin-left:10px" onchange="showTicketAll()" >			
			<option>10</option>
			<option>30</option>
			<option>50</option>
			<option>100</option>
			<option>250</option>
			<option>Todos</option>
		</select>
	<label class="INPUT_LABEL" >Ordenar por: </label>
		<select id="ORDBY" class="_COMBO_BOX" style="margin-left:10px" onchange="showTicketAll()" >
			<option>Prioridad</option>
			<option>Estado</option>
			<option>Asunto</option>
			<option>De</option>
			<option>Recibido</option>
			<option>Id</option>		
		</select>
		<select id="AZ" class="_COMBO_BOX" onchange="showTicketAll()" >			
			<option>ASC</option>
			<option>DESC</option>			
		</select>
		<input class="_INPUT_BUTTON" type="button" value="Refrescar" onclick="showTicketAll()"  />
</div>
<hr />
	<div class="TABLIST">
	<input id="TABBT1" class="TAB _INPUT_BUTTON CORNER_TOP SELECTED" type="button" value="Pendiente"  />
	<input id="TABBT2" class="TAB _INPUT_BUTTON CORNER_TOP" type="button" value="Archivado"  />
	<input id="TABBT3" class="TAB _INPUT_BUTTON CORNER_TOP" type="button" value="Busqueda"  />
	</div>
	
	<div class="TABFRAME">
  	   <div id="SEARCH_DIV">
    	   <label class="INPUT_LABEL" >Busqueda: </label>
      	   <input id="SEARCH_INPUT" type="text" class="_INPUT_TEXT" />
		   <hr />		   
	   </div>
	   <div id="CONTAINER"></div>
	</div>
</div>
</div>	   
</div>
</div>
</body>
</html>