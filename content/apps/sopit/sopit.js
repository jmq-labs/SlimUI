
$(document).ajaxStart(function(){	
	SlimLockScr(true);
});

$(document).ajaxStop(function(e,x,s){
	SlimLockScr(false);
});

$(document).ready(function(){	
	$("#correo").val($(userInfo.getUserInfo())[0]['user_email']);	
});

function SendTicket(){
if(checkempty()){
	$("#nombre").val(parent.activeUsr);
    $.ajax({
      url: WKDIR + "response.php",
	  type: "POST",      
	  enctype: 'multipart/form-data',
	  data: new FormData(document.getElementById("ticketform")),
	  processData: false,
      contentType: false
    }).done(function(response){
	   ticketform.reset();
       parent.SlimAlert(response);
    }).fail(function(){ parent.SlimAlert("Hubo un error al enviar la informacion, porfavor revise los campos e intente de nuevo."); });
  }
}

function SearchTicket(){
    $.ajax({
      url: WKDIR + "response.php",
	  type: "POST",      
	  data: $("#ticket_find").serialize()
    }).done(function(data){
	   if(data){
    	   ticket_find.reset();
           $("#TICKET_INPUT").hide();
    	   $("#TICKET_INFO").show().html(data);
	   }else{
	   	   $("#ticket_id").blur(); 
	   	   parent.SlimAlert("No se encontro ningun resultado.");
	   }
    }).fail(function(){ parent.SlimAlert("La información ingresada no es valida!"); });
}

function setfocus(){ ticketform.asunto.focus(); }

function checkempty(){
  if ( ticketform.asunto.value == '' || ticketform.descripcion.value == ''  )
        {
                parent.SlimAlert('Debe llenar todos los datos solicitados para poder continuar.')
				
                return false;
        }else{
		
			  	return true;
		
		}  
}
