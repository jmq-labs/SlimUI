<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('header.php'); ?>
</head>
<body bgcolor="transparent" onload="setfocus()">
<div class="CONTENT">
<div id="MAIN_CONTENT" class="BODY_CONTAINER">
<div class="FRAME">
<table class="main" align="center">
	<tr>
		<td class="TASK_MANAGER">
			<div id="OBJECT_RECEIVERS">
				 <div id="OR_DELETE"><label>- Eliminar -</label></div>
				 <div id="OR_EXCLUDE"><label>- Excluir -</label></div>
			</div>
			<?php include('manager/index.php'); ?>	
        </td>
	</tr>
</table>
        	<div class="SEND_TASK"> <div id="ARROWHOLDER"><img id="WIDGET_ARROW" class="TURN_LEFT" src="../../content/img/arrowright.png" /></div>		
			<div class="TABLIST">
          	<input id="TABBTA" class="TAB _INPUT_BUTTON CORNER_TOP SELECTED" type="button" value="Nueva tarea/evento" />
          	<input id="TABBTB" class="TAB _INPUT_BUTTON CORNER_TOP" type="button" value="Nuevo proyecto" />  	
          	</div>
			
			<div class="TABFRAME">
			<div id="NEWTASK" >
			<form id="taskform" name="taskform" class="CONTENT" action="javascript:SendTicket()" >			
				  <br />
				  <input id="nombre" name="nombre" type="hidden" value="" />
				
				  <label class="title1">Asunto:</label><br />
        		  <div class="_INPUT_TEXT"><input id="asunto" class="field REQUIRED" name="asunto" type="text" maxlength="45" /></div><br />				  
				  <label class="title1">Invitar a:</label><br />
        		  <div class="_INPUT_TEXT"><input id="invitar" class="field" size="32" name="invitar" type="text" /></div>				  
				  <div id="CONTAINER_INVITADOS"></div>
				
				  <label class="title1">Descripción:</label><br />
        		  <textarea class="desc _TEXT_AREA REQUIRED" name="descripcion"></textarea><br />	 
				  
				  <span class="_CHECKBOX">					  
					  <input type="checkbox" id="isevent" name="isevent">
					  <label for="isevent">Evento</label>			   
				  </span>
				  
				  <span class="_CHECKBOX">					  
					  <input type="checkbox" id="allday" name="allday" onclick="toggleElement('TIMECONFIG',this.checked)" checked >
					  <label for="allday" >Todo el día</label>					   
				  </span><br />
				  
				  <table><tr><td>
				  		<label class="title1">Del:</label>        		  
				  </td><td>
				  		<input id="fechain" class="REQUIRED" size="10" name="fechain" type="text" />
				  </td><td>			  
				  		<label class="title1">Al:</label>
				  </td><td>    		  
				  		<input id="fechafin" class="REQUIRED" size="10" name="fechafin" type="text" />				  
				  </td></tr><tr id="TIMECONFIG"><td>
				  	  	<label class="title1">De:</label>        		  
    			  </td><td>
						<input id="timestart" class="REQUIRED" size="10" name="timestart" type="text" READONLY />
    			  </td><td>    			
    				  	<label class="title1">A:</label>        		  
    			  </td><td>	  	
						<input id="timeend" class="REQUIRED" size="10" name="timeend" type="text" READONLY />				  
				  </td></tr>
				  </table>
				  
				  <p><input type="file" name="file" id="file"></p>				  

				<p>
				<span class="FORM_BUTTONS">
				  <input type="button" class="_INPUT_BUTTON" onclick="clearTicketForm()" value="Borrar">
				  <input type="submit" class="_INPUT_BUTTON" value="Crear">
				</span>
				</p>				
			</form>
			</div><br />
			
			<div id="NEWPROJECT">
			<form id="projectform" name="projectform" class="CONTENT" action="javascript:sendProject()" >				
				   <label class="title1">Nombre:</label><br />
        		   <div class="_INPUT_TEXT"><input id="nomproyecto" class="field REQUIRED" name="nomproyecto" type="text" maxlength="30" /></div><br />
				   <p>				    
				   <div id="DROPTASKS"><label class="title1 DROPLABEL">Arrastre las tareas aquí</label></div>
				   <input id="project_tasks" name="project_tasks" type="hidden" />
				   </p>
				   <p class="FORM_BUTTONS">
				   	  <input type="button" class="_INPUT_BUTTON" onclick="clearTasksForm()" value="Borrar">
				  	  <input type="submit" class="_INPUT_BUTTON" onclick="" value="Crear Proyecto">
				   </p>								
			</div>
			</form>
			</div>
		</div>
	</p>
</div>	   
</div>	   
</div>
</body>
</html>