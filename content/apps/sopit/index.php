<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('header.php'); ?>
</head>
<body bgcolor="transparent" onload="setfocus()">
<div class="CONTENT">
<div class="BODY_CONTAINER">
<div class="FRAME">
<div class="FRAME" title="Reportar un fallo del sistema">
<hr />  	 	
<p><table class="main" align="center">
	<tr>
		<td class="SEARCH_TICKET _BKGSTYLE1">
			<div>				
				<form id="ticket_find" name="ticket_find" onsubmit="SearchTicket(); return(false)">
    				<p>
    				  <label class="title2">Ya envié un ticket.</label><br />
            		  <input id="ticket_id" class="verify_txtbox" name="ticket_id" type="text" />
    				</p>
    				<p>
    				  <input type="button" class="_INPUT_BUTTON" onclick="SearchTicket()" value="Buscar">					  
    				</p>
				</form>
				</div>			
        	</td>
        	<td class="SEND_TICKET">						
			<div id="TICKET_INFO"></div>
			<div id="TICKET_INPUT">
			<form id="ticketform" name="ticketform" >			
				<input id="nombre" name="nombre" type="hidden" value="" />
				<p>
				  <label class="title1">Asunto:</label><br />
        		  <input id="asunto" class="field INPUT_TEXT" name="asunto" type="text" maxlength="45" /><br />
				  <label class="title1">Correo:</label><br />
        		  <input id="correo" class="field INPUT_TEXT" name="correo" type="text" />
				</p>
				<p>
				  <label class="title1">Descripción del Problema:</label><br />
        		  <textarea class="desc" name="descripcion"></textarea><br /><br />
				  <label class="title1">Adjuntar archivo [ jpeg, gif, png, doc, rar, zip, pdf ] *opcional</label><br />
				  <input type="file" name="file" id="file">
				</p>
				<p>
				  <input type="button" class="_INPUT_BUTTON" onclick="ticketform.reset()" value="Borrar">
				  <input type="button" class="_INPUT_BUTTON" onclick="SendTicket()" value="Enviar Ticket">
				</p>
			</form>
			</div>
		</td>
	</tr>
</table></p>
</div>	   
</div>	   
</div>
</div>
</body>
</html>