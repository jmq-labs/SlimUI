var msg1 = "Se modificara el estado de la tarea. ¿Esta seguro que desea continuar?";
var tabSelected = 1;
var autoSearch = "";

$(document).ready(function(){    
	$(userTasks.getUserTasks(true));
	$("#SEARCH_INPUT").keydown(function(){ clearInterval(autoSearch); autoSearch = setTimeout("showTicketAll(true)",300); });
	$(".FRAME").SlimFrame();	
	$("#TABBT1").click(function(){ $(".TASK_MANAGER .TAB").removeClass("SELECTED"); $(this).addClass( "SELECTED" ); tabSelected = 1; showTicketAll(false); });
	$("#TABBT2").click(function(){ $(".TASK_MANAGER .TAB").removeClass("SELECTED"); $(this).addClass( "SELECTED" ); tabSelected = 2; showTicketAll(false); });
	$("#TABBT3").click(function(){ $(".TASK_MANAGER .TAB").removeClass("SELECTED"); $(this).addClass( "SELECTED" ); if(tabSelected != 3){ $("#SEARCH_DIV").show(); } tabSelected = 3; showTicketAll(false); });	
	$("#TABBT4").click(function(){ $(".TASK_MANAGER .TAB").removeClass("SELECTED"); $(this).addClass( "SELECTED" ); tabSelected = 4; showTicketAll(false); });
	$("#TABBT5").click(function(){ $(".TASK_MANAGER .TAB").removeClass("SELECTED"); $(this).addClass( "SELECTED" ); tabSelected = 5; showTicketAll(false); });
	
	$("#OR_DELETE").droppable({		  
          drop: function( event, ui ) {          
			var id = ui.draggable.attr("taskid");
			var pid = ui.draggable.attr("pid");				
			var admin = ui.draggable.attr("admin");		
			
			var data = $(userTasks.getUserTasks());
			task = getObject(data, "id", id);					
														
			if( id && ( !pid && !task.projectid && task.isevent == 0 ) ){
				var tname = ui.draggable.find(".TD4").html();
				Confirm("Esta seguro que desea eliminar la tarea '" + tname + "'", function(){ 
					SlimLockScr(true);
					$.ajax({
                      type: 'POST',
                      url: WKDIR + "manager/process.php",
                      data: { get: "DELETE_TICKET", ticket_id: id },
                      success: function(){ clearTasksForm(); showTicketAll(); },                      
                      async:false
                    });					
				});
			}
			
			if( id && ( !pid && task.projectid ) ){
				var tname = ui.draggable.find(".TD4").html();
				Confirm("La tarea '" + tname + "' actualmente pertenece a un proyecto, si la elimina también se excluirá del mismo, desea continuar?", function(){ 
					SlimLockScr(true);
					$.ajax({
                      type: 'POST',
                      url: WKDIR + "manager/process.php",
                      data: { get: "DELETE_TICKET", ticket_id: id },
                      success: function(){ clearTasksForm(); showTicketAll(); },                      
                      async:false
                    });					
				});				
			}
			
			if( pid && ( !id ) ){ 
				if($(userInfo.getUserInfo())[0]['userid'] == admin){
    				var pname = ui.draggable.find(".TDP3").html();
    				Confirm("Esta seguro que desea eliminar el proyecto '" + pname + "'", function(){  
    					SlimLockScr(true);
						$.ajax({
                          type: 'POST',
                          url: WKDIR + "manager/process.php",
                          data: { get: "DELETE_PROJECT", ticket_id: pid },
                          success: function(){ clearTasksForm(); showTicketAll(); },                      
                          async:false
                        });			
    				});
				}else{
				    var pname = ui.draggable.find(".TDP3").html();
					Alert("No es posible eliminar el proyecto '" + pname + "', otro usuario es el administrador.");
				}
			}
			
			if(!pid && task.isevent == 1 && task.taskowner == $(userInfo.getUserInfo())[0]['userid'] ){
				var tname = ui.draggable.find(".TD4").html();
				Confirm("Esta seguro que desea eliminar el evento '" + tname + "'", function(){ 
					SlimLockScr(true);
					$.ajax({
                      type: 'POST',
                      url: WKDIR + "manager/process.php",
                      data: { get: "DELETE_TICKET", ticket_id: id },
                      success: function(){ clearTasksForm(); showTicketAll(); },                      
                      async:false
                    });					
				});		 
			}else{
				if(task.isevent == 1){
    				var tname = ui.draggable.find(".TD4").html();
    				Alert("No es posible eliminar el evento '" + tname + "', otro usuario es el administrador.");
				}
			}								
         }
    });
	
	$("#OR_EXCLUDE").droppable({		  
          drop: function( event, ui ) {   
			var id = ui.draggable.attr("taskid");			
			var data = $(userTasks.getUserTasks());
			task = getObject(data, "id", id);					
														
			if( id && ( task.projectid ) ){
				var tname = ui.draggable.find(".TD4").html();
				Confirm("Esta seguro que desea excluir la tarea '" + tname + "'", function(){ 
					SlimLockScr(true);
					$.ajax({
                      type: 'POST',
                      url: WKDIR + "manager/process.php",
                      data: { get: "EXCLUDE_TICKET", ticket_id: id },
                      success: function(){ clearTasksForm(); showTicketAll(); },                      
                      async:false
                    });					
				});
			}else{
				Alert("La tarea ya no esta disponible o ya fue excluida del proyecto!");
				showTicketAll();
			}					
         }
    });
	
	showTicketAll(false);		
});

function showTicketAll(sync){	
	var o = $("#ORDBY option:selected").text();
	var a = $("#AZ option:selected").text();
	var r = $("#ITEMS option:selected").text();
	var d = $("#DEPT option:selected").text();	
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
		case "Creada":
			 o = "fecha";
			 break;		
		case "Prioridad":
			 o = "prioridad";
			 break;
	}
	
	switch (d){
		case "Todos":
		d = "";
		break;
	}	
	
	$.ajax({
      async: sync,
	  url: WKDIR + "manager/process.php",
	  type: "POST",      
	  data: { get: "TICKETS_ALL", order: o, az : a, items: r, tab: tabSelected, search: $("#SEARCH_INPUT").val(), dept: d }
    }).done(function(data){	   
	   $("#CONTAINER").html(data);	   
	   $(".DIVOPTIONS").hide();
	   $(".RDIVDATA").hide();	      
	   $(".INPUT_BUTTON").SlimButton();
	   $(".TICKETDATA").SlimTask();
	   $(".TICKETBTN").each(function(){
    	   $(this).click(function(){	   		
    			var TID = $(this).attr("ticketid");
    			var TST = $(this).attr("ticketstat");
    			 
    			switch (TST){
    			case "No comenzada":
        			Confirm(msg1,function(){					
        				setTicket(TID,"En curso");
        				$("#TDIV"+TID).toggle("blind","fast");		
        			});
    				break;
    			case "En curso":				
        			$("#TDIV"+TID).toggle("blind","fast");
    				break;
    			case "Completada":				
        			$("#TDIV"+TID).toggle("blind","fast");					
    				break;				
				case "Visible":				
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
        			setTicket(TID,"Completada");        									
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
	   
	   $(".TICKET_CONTAINER .PRIORITY_TD").each(function(){	   		
    		$(this).parent("tr").draggable({
    			cursor: "move", 
    			cursorAt: { top: 20, left: 180 } ,
    			helper: "clone",
    			snap: "#DROPTASKS", 
    			snapMode: "inner",
				start: function( event, ui ) { 
					   var id = $(ui.helper).attr("taskid");					   
					   var data = $(userTasks.getUserTasks(true)); 
					   task = getObject(data, "id", id);
					   if(task.projectid<1){
					    	$("#OR_DELETE").css("width","100%"); 
							$("#OR_EXCLUDE").hide(); 
					   }else{ 
					   		$("#OR_DELETE").css("width","50%");							 
							$("#OR_EXCLUDE").show(); 
					   }
					   $("#OBJECT_RECEIVERS").animate({"top": "0px"}, 100);					   		   
					   $(ui.helper).find("td").each(function(){ if($(this).hasClass("TD6")){ $(this).remove(); }});
					   $(ui.helper).find("td").each(function(){ if($(this).hasClass("TD5")){ $(this).remove(); }});
					   $(ui.helper).find("td").each(function(){ if($(this).hasClass("TD3")){ $(this).remove(); }});
					   $(ui.helper).find("td").each(function(){ $(this).css("height","40px");});
					   $(ui.helper).css("box-shadow","rgba(34, 34, 34, 0.5) 0px 0px 10px");
					   $(ui.helper).css("border-radius","8px");
					   $(ui.helper).css("background-color","white");
				},
				stop: function( event, ui ) { $("#OBJECT_RECEIVERS").animate({"top": "-92px"}, 100); },				
    		});			
	   });
	   
	   $("#DROPTASKS").droppable({
          activeClass: "ui-state-default",
          hoverClass: "ui-state-hover",
		  accept: ".TICKET",          
          drop: function( event, ui ) {  	            
			var hasid = 0;
			var id = ui.draggable.attr("taskid");
			var dragged = ui.draggable.clone();			
			dragged.find("td").each(function(){ if($(this).hasClass("TD1")){ $(this).remove(); } });
			dragged.find("td").each(function(){ if($(this).hasClass("TD2")){ $(this).remove(); } });
			dragged.find("td").each(function(){ if($(this).hasClass("TD3")){ $(this).remove(); } });
			dragged.find("td").each(function(){ if($(this).hasClass("TD5")){ $(this).remove(); } });
			dragged.find("td").each(function(){ if($(this).hasClass("TD6")){ $(this).remove(); } });
			$("#DROPTASKS table").each(function(){ if(id==$(this).attr("taskid")){ hasid++; }});
			
			var data = $(userTasks.getUserTasks());
			task = getObject(data, "id", id);
														
			if( hasid < 1 && ui.draggable.text().indexOf("Completada") < 1 && (task.projectid === null || task.projectid === undefined) && task.isevent != 1 ){
				var data = dragged.html();
    			var item = "<div class='TASKHOLDER'><table taskid='"+id+"'>" + data + "<td><input type='button' class='_INPUT_BUTTON REMOVEITEM' value='Excluir' /></td></table></div>";			
                $(this).append(item);
    			$(".REMOVEITEM").each(function(){ $(this).click(function(){ $(this).parent().parent().parent().parent().parent().remove(); }) });
				$(".TASKHOLDER table[taskid='"+id+"']").parent().effect("highlight");
			}else{
				if(task.isevent == 1){
					Alert("No es posible agregar un evento a un proyecto.");
				}else{
					Alert("No es posible agregar esta tarea a un proyecto.");
				}
			}
						
          }
      });
	  
	  $(".TICKETDATA .DIV_INVITADO").each(function(){ 
	  		var data = $(dmUsers.getDmUsers());
			profile = getObject(data, "mail", $(this).html());			
			$(this).html(profile.value); 
	  });
	  
	  if(tabSelected==4){ 
	  	if($(".TICKET_CONTAINER").length > 0){    		
			var pid = $.unique($(".TICKET_CONTAINER").map(function(){ return $(this).attr("projectid"); }).get().join().split(","));		
						
			for(i=0; i<pid.length; i++){
				var stat = $(".TICKET_CONTAINER[projectid='"+pid[i]+"'][stat='Completada']").length;
				var tickets = $(".TICKET_CONTAINER[projectid='"+pid[i]+"']").length;
				var progress = Math.floor(((stat/tickets)*100));
				var pfe = $(".TICKET_CONTAINER[projectid='"+pid[i]+"']").attr("created");
				var pno = $(".TICKET_CONTAINER[projectid='"+pid[i]+"']").attr("projectname");
				var adm = $(".TICKET_CONTAINER[projectid='"+pid[i]+"']").attr("admin");
				$(".TICKET_CONTAINER[projectid='"+pid[i]+"']").wrapAll("<table class='PROJECT_CONTAINER' pid='"+pid[i]+"' projectname='"+pno+"' created='"+pfe+"'  progress='"+progress+"' admin='"+adm+"' ><tr class='TICKETSHOLDER'></tr></table>");
			}
			groupProjects();		
		}
	  }
	   
    }).fail(function(){ parent.SlimAlert("Hubo un error de conexión, intente nuevamente."); });
}

function setTicket(id,stat){    
	var info = new Array();
	info[1] = $("#OBS"+id).val();
	info[5] = $("#DIAG"+id+" option:selected").text();		
	var data = JSON.stringify(info);	
	
	$.ajax({
	  async: false,
      url: WKDIR + "manager/process.php",
	  type: "POST",      
	  data: { get: "SET_TICKET", ticket_id: id, status: stat, info: data }
    }).done(function(data){ 	   
       clearTasksForm();
	   if(!data){
    	   switch (stat){
    			case "En curso":
    				 $("#BT"+id).attr("value","Editar");
    				 $("#BT"+id).attr("ticketStat",stat);
    				 break;
    			case "Completada":
    				 showTicketAll(false);
    				 break;
    	   }	   
    	   $("#STAT"+id).html(stat);    	   
	   }else{
	   	   setTimeout(function(){ parent.SlimAlert(data); showTicketAll(false);}, 600);
	   }
    }).fail(function(){ parent.SlimAlert("Hubo un error al enviar la informacion, porfavor revise los campos e intente de nuevo."); });
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
      url: WKDIR + "manager/process.php",
	  type: "POST",      
	  data: { get: "SET_PRIORITY", ticket_id: id, priority: n }
    }).done(function(data){
	  parent.SlimAlert("Se cambio la prioridad de la tarea!");
    }).fail(function(){ parent.SlimAlert("Hubo un error en la conexión, intente de nuevo."); });
}

function groupProjects(){
	$(".PROJECT_CONTAINER").each(function(){		
		var pname = $(this).attr("projectname");
		var pdate = $(this).attr("created");
		var progress = $(this).attr("progress");
		var admin = $(this).attr("admin");
		var pid = $(this).attr("pid");		
		var data = $(dmUsers.getDmUsers());
		profile = getObject(data, "uid", admin);
		
		$(this).prepend("<tr  pid='"+pid+"' admin='"+admin+"' class='TRTITLE'><td class='PRIORITY_TD' ></td><td class='TDP1'>"+pdate+"</td><td class='TDP2'>"+profile.value+"</td><td class='TDP3'>"+pname+"</td><td class='TDP4'><div style='width:"+progress+"%' class='PROJECT_PROGRESS'>"+progress+"%</div></td></tr>");				

		$(".TICKETSHOLDER").hide();
		
	});
	$(".PROJECT_CONTAINER .TRTITLE").click(function(){ $(this).parent().children(".TICKETSHOLDER").toggle(); });
	$(".PROJECT_CONTAINER .TRTITLE").draggable({
        	cursor: "move", 
        	cursorAt: { top: 20, left: 200 } ,
        	helper: "clone",
        	snap: "#OR_DELETE", 
        	snapMode: "inner",
    		start: function( event, ui ) {				   
				   $("#OR_EXCLUDE").hide();
				   $("#OR_DELETE").css("width","100%");				   
				   $("#OBJECT_RECEIVERS").animate({"top": "0px"}, 100);
				   $(ui.helper).find("td").each(function(){ if($(this).hasClass("TDP1")){ $(this).remove(); }});
				   $(ui.helper).find("td").each(function(){ if($(this).hasClass("TDP2")){ $(this).remove(); }});
				   $(ui.helper).find("td").each(function(){ if($(this).hasClass("TDP4")){ $(this).remove(); }});
				   $(ui.helper).find("td").each(function(){ $(this).css("height","40px");});
				   $(ui.helper).css("box-shadow","rgba(34, 34, 34, 0.5) 0px 0px 10px");
				   $(ui.helper).css("border-radius","8px");
				   $(ui.helper).css("text-align","center");
				   $(ui.helper).css("background-color","white");
				   $(ui.helper).css("border","2px #bbb solid"); 
			},
    		stop: function( event, ui ) { $("#OBJECT_RECEIVERS").animate({"top": "-92px"}, 100); },				
 	});		
}

function Alert(m){ parent.SlimAlert(m); }