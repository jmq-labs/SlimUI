
var logDates = new Array();

$(document).ready(function(){	
	if(!parent.activeUsr){ parent.SlimAlert("No se pudo identificar el usuario, por favor cierre la sesión y vuelva a ingresar al sistema."); }
	$(".FRAME").SlimFrame();
    $(".INPUT_BUTTON").SlimButton();
	$("#LISTSEARCH").keyup(function(){
		$(".DIVOPTIONS").hide();
		$(".TABLE .ROW").each(function(){ 
			if(($(this).children(":eq(1)").html().toLowerCase().indexOf($("#LISTSEARCH").val().toLowerCase()) < 0) && ($("#LISTSEARCH").val() != "")){
				$(this).hide();
				$(this).next().hide();
			}else{ 
				$(this).show();
				$(this).next().show();
			}
		});
	});
	showLogs();
});

function showLogs(){
  $("#LISTSEARCH").val("");
  $.ajax({
  	  async: false,
        url: "../../content/apps/logs/explore.php",
  	  type: "POST",      
  	  data: { get: "SHOW_LOGS" }
  }).done(function(data){     
	  $("#CONTAINER").html(data);
	  $(".DIVOPTIONS").hide();
	  $(".LOG_LINK").each(function(){ 
	  		$(this).click(function(){					
					var myWindow = window.open(encodeURI($(this).attr('log')), '_blank', "width=950, height=600");				
			});
	  }); 
	  $(".LOGBT").each(function(){ 
	  		$(this).click(function(){					
				$("#ROW"+$(this).attr("logId")).toggle("blind","fast");
				id = $(this).attr("logId");
				ip = $("#LOC"+id).attr("ip");			
				url = "http://freegeoip.net/json/"+ip;
				if(ip != "No disponible"){
    				$.getJSON(url, function(data){
    					var loc = data.city;
						if(!loc){ loc = "No disponible"; }
						$("#LOC"+id).html(loc);   									 
    				});
				}else{ 
					   	loc = "No disponible";
						$("#LOC"+id).html(loc);				   
				}				
			});
	  });
	  
	  $(".datepicker").datepicker({	  	 
      	beforeShowDay: function(date) {
		   var d = (date.getDate() < 10 ? '0' : '') + date.getDate();
           var m =  ((date.getMonth() + 1) < 10 ? '0' : '') + (date.getMonth() + 1);
           
           var y = date.getFullYear().toString().substring(2);           
           var x = d + "-" + m + "-" + y;
		   var Highlight =  logDates[$(this).attr("logId")][x];
           if (Highlight) {
           	  return [true, "Highlighted"];
           } else {
              return [true, '', ''];
		   }
		},
        dateFormat: "dd-mm-y",
        onSelect: function(dateText) {		  
		  if(logDates[$(this).attr("logId")][$(this).val()]){			
			var myWindow = window.open("../../content/apps/logs/"+logDates[$(this).attr("logId")][$(this).val()], '_blank', "width=950, height=600");
		  }	
        }
      });  
	  
  }).fail(function(){ 
  	  parent.SlimAlert("Hubo un error al solicitar la informacion, porfavor intente de nuevo.");
  });
}
