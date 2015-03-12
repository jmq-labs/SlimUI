var msg1 = "Se modificara el estado del ticket. ¿Esta seguro que desea continuar?";
var tabSelected = 1;
var autoSearch = "";
var WKDIR = "../content/apps/sopit/admin/";

$(document).ready(function(){		    
	$("#SEARCH_INPUT").keydown(function(){ clearInterval(autoSearch); autoSearch = setTimeout("showTicketAll(true)",300); });
	$(".FRAME").SlimFrame();
	$("#TABBT1").click(function(){ $(".TAB").removeClass("SELECTED"); $(this).addClass( "SELECTED" ); tabSelected = 1; showTicketAll(false); });
	$("#TABBT2").click(function(){ $(".TAB").removeClass("SELECTED"); $(this).addClass( "SELECTED" ); tabSelected = 2; showTicketAll(false); });
	$("#TABBT3").click(function(){ $(".TAB").removeClass("SELECTED"); $(this).addClass( "SELECTED" ); if(tabSelected != 3){ $("#SEARCH_DIV").show(); } tabSelected = 3; showTicketAll(false); });	
	showTicketAll(false);		
});

function showTicketAll(sync){	
	var o = $("#ORDBY option:selected").text();
	var a = $("#AZ option:selected").text();
	var r = $("#ITEMS option:selected").text();	
	if(tabSelected != 3){ $("#SEARCH_DIV").hide(); }	
	 
	switch (o){
    	case "Estado":
			 o = "estado";
			 break;
		case "Asunto":
			 o = "asunto";
			 break;
		case "De":
			 o = "nombre";
			 break;
		case "Recibido":
			 o = "fecha";
			 break;
		case "Id":
			 o = "id";
			 break;
		case "Prioridad":
			 o = "prioridad";
			 break;
	}
	
	$.ajax({
      async: sync,
	  url: WKDIR + "process.php",
	  type: "POST",      
	  data: { get: "TICKETS_ALL", order: o, az : a, items: r, tab: tabSelected, search: $("#SEARCH_INPUT").val() }
    }).done(function(data){	   
	   $("#CONTAINER").html(data);	   
	   $(".DIVOPTIONS").hide();
	   $(".RDIVDATA").hide();	      
	   $(".INPUT_BUTTON").SlimButton();
	   $(".TICKETBTN").each(function(){
    	   $(this).click(function(){	   		
    			var TID = $(this).attr("ticketid");
    			var TST = $(this).attr("ticketstat");
    			 
    			switch (TST){
    			case "En cola":
        			Confirm(msg1,function(){					
        				setTicket(TID,"Abierto");
        				$("#TDIV"+TID).toggle("blind","fast");		
        			});
    				break;
    			case "Abierto":				
        			$("#TDIV"+TID).toggle("blind","fast");
    				break;
    			case "Cerrado":				
        			$("#TDIV"+TID).toggle("blind","fast");					
    				break;			
    			}		
    	   });
	   });
	   
	   $(".BTR1").each(function(){
    	    $(this).click(function(){	   		
    			var TID = $(this).attr("ticketId");			
        		$(".RDIV"+TID).toggle("blind","fast");
				if($(this).val()=="Responder"){					
					$(this).val("Cancelar") 
				}else{ 
					$("#DIAG"+TID).val("1");
					$("#OBS"+TID).val("");					
					$(this).val("Responder");					
				}
    	   });
	   });	   
	   	   
	   $(".BTR2").each(function(){
    	    $(this).click(function(){	   		
    			var TID = $(this).attr("ticketId");			
        		Confirm(msg1,function(){					
        			setTicket(TID,"Cerrado");        									
        		});			
    	   });
	   });	   
	   
	   $(".PRIORITY_OPT").each(function(){
    	    $(this).change(function(){	   		
    			var TID = $(this).attr("ticketId");        							
        		setPriority(TID,$("option:selected",this).text());       					
    	   });
	   });	
	   
	   $(".TICKETS_TABLE td").each(function(){ if( !$(this).children().length > 0 ){ $(this).attr("title",$(this).html()); }})	   
	   	   
    }).fail(function(){ parent.SlimAlert("Hubo un error de conexión, intente nuevamente."); });
}

function setTicket(id,stat){    
	var info = new Array();
	info[1] = $("#OBS"+id).val();
	info[5] = $("#DIAG"+id+" option:selected").text();		
	var data = JSON.stringify(info);	
	
	$.ajax({
	  async: false,
      url: WKDIR + "process.php",
	  type: "POST",      
	  data: { get: "SET_TICKET", ticket_id: id, status: stat, info: data }
    }).done(function(data){ 	   
       if(!data){
    	   switch (stat){
    			case "Abierto":
    				 $("#BT"+id).attr("value","Editar");
    				 $("#BT"+id).attr("ticketStat",stat);
    				 break;
    			case "Cerrado":
    				 showTicketAll(false);
    				 break;
    	   }	   
    	   $("#STAT"+id).html(stat);	   
    	   setTimeout(function(){ SlimAlert("El ticket #"+id+" se edito correctamente!")}, 600);
	   }else{
	   	   setTimeout(function(){ SlimAlert(data); showTicketAll(false);}, 600);
	   }
    }).fail(function(){ SlimAlert("Hubo un error al enviar la informacion, porfavor revise los campos e intente de nuevo."); });
}

function SearchTicket(){
    $.ajax({
      url: WKDIR + "process.php",
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

function Confirm(m,f){
  parent.SlimAlert(m, function a(r) { f(); });
}

function setPriority(id,n){
 	
	switch (n){
    	case "1":
			 $("#PRIORITY_TD"+id).css("background-color","#FF4200");
			 break;
			 
		case "2":
			 $("#PRIORITY_TD"+id).css("background-color","#FFB700");
			 break;
			 
		case "3":
			 $("#PRIORITY_TD"+id).css("background-color","#4DAC00");
			 break;
			 
	}
	
	$.ajax({
      url: WKDIR + "process.php",
	  type: "POST",      
	  data: { get: "SET_PRIORITY", ticket_id: id, priority: n }
    }).done(function(data){
	  parent.SlimAlert("Se cambio la prioridad del ticket!");
    }).fail(function(){ parent.SlimAlert("Hubo un error en la conexión, intente de nuevo."); });
}

function Alert(m){ parent.SlimAlert(m); }