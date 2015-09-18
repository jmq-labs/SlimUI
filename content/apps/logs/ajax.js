
var logDates = new Array();
var logStats = new Array();

$(document).ready(function(){	
	if(!parent.activeUsr){ parent.SlimAlert("No se pudo identificar el usuario, por favor cierre la sesión y vuelva a ingresar al sistema."); }
	$(".FRAME").SlimFrame();
    $(".INPUT_BUTTON").SlimButton();
	$("#LISTSEARCH").keyup(function(){
		$("#SHOWONLINE").attr("CHECKED",false);
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
	$("#SHOWONLINE").change(function(){
		if($(this).attr("CHECKED")){
			$(".TABLE .ROW").each(function(){
    			if(($(this).children("td:eq(1)").html().toLowerCase().indexOf("25d41c") < 0)){
    				$(this).hide();
    				$(this).next().hide();
    			}
			});
		}else{
			$(".TABLE .ROW").each(function(){ 
    			$(this).show();
    			$(this).next().show();    			
			});
		}
	});
	showLogs();
});

function showLogs(){
  $("#LISTSEARCH").val("");
  $("#SHOWONLINE").attr("CHECKED",false);
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
				if(ip != "N/A"){
    				$.getJSON(url, function(data){
    					var loc = data.city;
						if(!loc){ loc = "N/A"; }
						$("#LOC"+id).html(loc);   									 
    				});
				}else{ 
					   	loc = "N/A";
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
	  $("#archivesize").html(logStats['filesize']);
	  $("#onlinecount").html(logStats['usonline']);
	  $(".LOGBT").SlimButton();
  }).fail(function(){ 
  	  parent.SlimAlert("Hubo un error al solicitar la informacion, porfavor intente de nuevo.");
  });
}
