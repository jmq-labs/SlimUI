
$(document).ready(function(){
	if(!parent.activeUsr){ parent.SlimAlert("No se pudo identificar el usuario, por favor cierre la sesión y vuelva a ingresar al sistema."); }	
	$("#TABBTA").click(function(){ $(".SEND_TASK .TAB").removeClass("SELECTED"); $(this).addClass( "SELECTED" ); $("#NEWTASK").show(); $("#NEWPROJECT").hide(); });
	$("#TABBTB").click(function(){ $(".SEND_TASK .TAB").removeClass("SELECTED"); $(this).addClass( "SELECTED" ); $("#NEWTASK").hide(); $("#NEWPROJECT").show(); });
	$("#TIMECONFIG").hide();
	$("#timestart").timepicker({
		defaultValue: "00:00",
        hourMin: 1,
        hourMax: 23,
        stepMinute: 5,
        timeFormat: 'hh:mm tt'
    });
	$("#timeend").timepicker({
		defaultValue: "00:00",
        hourMin: 1,
        hourMax: 23,
        stepMinute: 5,
        timeFormat: 'hh:mm tt'
    });
	$("#NEWPROJECT").hide();
	$("#invitar").autocomplete({       
	  source: function( request, response ) {
        $.ajax({
          url: WKDIR + "dmu.php",
          dataType: "json",
          data: {
            q: request.term
          },
          success: function( data ) {
            response( data );
          }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
         if(checkInvites(ui.item.mail)){
		    $("#CONTAINER_INVITADOS").append("<div class='DIV_INVITADO' mail='"+ ui.item.mail +"'>" + ui.item.value + "<label class='LABEL_ELIMINAR LE_PROTO'>x</label></div>");
		    $(".LE_PROTO").each(function(){ $(this).click(function(){ $(this).parent().remove(); }); $(this).removeClass("LE_PROTO"); });
		 }else{
		    Alert("No esposible invitar a esta persona, su correo electrónico no está disponible.");
		 }
		 $(this).val("");
		 event.preventDefault();	    
      }
    });
	
	$("#fechain").datepicker().datepicker('option', {
		  dateFormat: 'dd-mm-yy', 
		  onSelect: function(){ DP_endDate($("#fechain"),$("#fechafin")); }
	});
	
	$("#fechafin").datepicker("setDate", 'today');
	DP_endDate($("#fechain"),$("#fechafin"));
	
	$("#ARROWHOLDER").click( function(){ 		
		if($(this).children("#WIDGET_ARROW").hasClass("TURN_LEFT")){		  
    		$(this).children("#WIDGET_ARROW").removeClass("TURN_LEFT");
			$(this).children("#WIDGET_ARROW").addClass("TURN_RIGHT");			
			$(".SEND_TASK").animate({"right": "-5px"}, 100);
			$("#MAIN_CONTENT").animate({"margin-right": "20%"}, 100);					  		  
    	}else{					  
    		$(this).children("#WIDGET_ARROW").removeClass("TURN_RIGHT");
			$(this).children("#WIDGET_ARROW").addClass("TURN_LEFT");			
			$(".SEND_TASK").animate({"right": "-343px"}, 100);
			$("#MAIN_CONTENT").animate({"margin-right": ""}, 100);			
    	}    	 
    });
	$("#ARROWHOLDER").click();	
});

<!-------------------------------------------------------------------------------------->

function SendTicket(){
if(checkempty()){
	SlimLockScr(true);
	$("#nombre").val(parent.activeUsr);
	$.ajax({
      url: WKDIR + "response.php",
	  type: "POST",      
	  enctype: 'multipart/form-data',
	  data: new FormData(document.getElementById("taskform")),
	  processData: false,
      contentType: false
    }).done(function(response){
	   clearTicketForm();
	   if(response){ parent.SlimAlert(response); }
	   showTicketAll();   
    }).fail(function(){ parent.SlimAlert("Hubo un error al enviar la informacion, porfavor revise los campos e intente de nuevo."); });
  }
}

function sendProject(){
  if(checkemptyproject()){	
	SlimLockScr(true);
	$.ajax({
      url: WKDIR + "response.php",
	  type: "POST",      
	  enctype: 'multipart/form-data',
	  data: new FormData(document.getElementById("projectform")),
	  processData: false,
      contentType: false
    }).done(function(response){
	   clearTasksForm();
	   $(userTasks.getUserTasks(true));
	   parent.SlimAlert("El proyecto se creo correctamente!");       
	   showTicketAll();   
    }).fail(function(){ parent.SlimAlert("Hubo un error al enviar la informacion, porfavor revise los campos e intente de nuevo."); });
  }
}

function setfocus(){ taskform.asunto.focus(); }

function checkInvites(m){
  var user_email = $(userInfo.getUserInfo())[0]['user_email'];  
  var mails = "";
  var invitados = $("#taskform .DIV_INVITADO").length;  
  $("#taskform .DIV_INVITADO").each(function(){ mails += $(this).attr("mail") + "; "; });
  if(mails.indexOf(m)>-1 || m == user_email || m === null){ return false; }else{ return true; }
}

function clearTicketForm(){
  taskform.reset();
  $("#fechain").datepicker("setDate", 'today');
  $(".DIV_INVITADO").remove();
  $("#TIMECONFIG").hide();
  $(userTasks.getUserTasks(true));
  DP_endDate($("#fechain"),$("#fechafin"));
}

function clearTasksForm(){
  projectform.reset();
  $(".TASKHOLDER").remove();
}

function checkempty(){
  taskform.invitar.value = "";
  var invitados = $("#taskform .DIV_INVITADO").length; 
  var mails = "";
  $("#taskform .DIV_INVITADO").each(function(){ mails += $(this).attr("mail") + "; "; });
  if(invitados > 0){ taskform.invitar.value = mails; }
  return true;  
}

function checkemptyproject(){  
  var taskholders = $("#projectform .TASKHOLDER").length;
  var tasks = "";
  $("#DROPTASKS .TASKHOLDER table").each(function(){ tasks += $(this).attr("taskid") + ";"; });  
  if ( projectform.nomproyecto.value == '' || taskholders < 1 )
        {
            parent.SlimAlert('Debe llenar los datos obligatorios para poder continuar.');                
			return false;				
        }else{				
			projectform.project_tasks.value = tasks;
			return true;
		}  
}	