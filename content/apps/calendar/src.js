$(document).ready(function() {		
		$('#calendar').fullCalendar({		
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		editable: false,
    	events: {
            url: '../../config/api.php',
			dataType: "json",
            type: 'POST',
			data: { usertasks: "true" },
            error: function(e,x) {
                parent.SlimAlert('Hubo un error en la conexión! <br /><code>Error: ' + x + '</code>');
            },				            
        },
		axisFormat: 'h a',
		timeFormat: 'h(:mm) a',
		eventRender: function(event, element) {
           	if(event.taskstat == "Completada"){ $(element).css("opacity", "0.6"); }			
			var title = 
				"De: " + event.taskname + 
				"\nEstado: " + event.taskstat + 
				"\nDescripción: " + decodeURIComponent(escape(event.description)) +
				"\nInicia: " + event.rawstart +
				"\nVence: " + event.rawend;
		    $(element).attr("title", title);
			$(".fc-title", element).html(decodeURIComponent(escape(event.title)));			
        },
		firstDay: 0,
		nextDayThreshold: '00:00:00',
		eventLimit: true,						
	});	
});