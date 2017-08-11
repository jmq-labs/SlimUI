var isIdle = false;

$(function(){
	var selected_tab = $("#selected_tab").val() != "" ? parseInt($("#selected_tab").val()) : 0;
	$.getScript("../../../../content/plugins/html2canvas/html2canvas.js");
	$.datepicker.setDefaults({ dateFormat: 'dd/mm/yy'});
	$("img, div, label, xmp").click(function(e){
    	var a = $(e.target);
    	if( !a.hasClass("_VOID") && !a.hasClass("METAEDITABLE") ){			
			parent.$(".MENU_LIST").hide("fade",100);
    		parent.$("#WIDGET_MENU").hide("blind",150);			
			$(".TASKWIDGET").remove();			  							
    	}
    });	
	$(".FRAME").SlimFrame();
	$(".CHECKBOX").SlimCheckbox();
    $(".INPUT_BUTTON, :button, :submit").SlimButton();
	$(".INPUT_TEXT, :text").SlimTextbox();
	$(".COMBO_BOX").SlimComboBox();
	$(".TEXT_AREA, textarea").SlimTextArea();
	$(".DATEPICKER").datepicker({
      	changeMonth: true,
      	changeYear: true	  	
    });
	$(".DATEPICKER").click(function(){ $(this).val(""); });
	$(".DATEPICKER").attr("READONLY","READONLY");
	$(".TIMEPICKER").timepicker();
	$(".EXPORT_IFRAME").remove();
	if(parent.DEVICE_TYPE!="MOBILE"){ 
    	$(".TABS").tabs();	
        $(".TABS").tabs("option", "active", selected_tab);		
	}else{
		$(".TABS").tabs();
        $(".TABS").tabs("option", "active", selected_tab);
		$(".TABS" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
    	$(".TABS li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
		$("table").parent("div").addClass("MGRID_CONTAINER");
	}
	ReqFields();
	if(parent.$("#MAIN"+parent.CurrentFrame).attr("onload_src")){
		$.getScript(parent.WWWROOT+parent.$("#MAIN"+parent.CurrentFrame).attr("folder").substr(3)+parent.$("#MAIN"+parent.CurrentFrame).attr("onload_src")); 
	}
	
	setInterval(function(){ 
		if (isIdle == true){
			SnapFrame();
			isIdle = false;
		}
	},500);
});

function SetIndexTab(i){
    if (i != null) {
        selected_tab = i;
        $("#selected_tab").val(selected_tab);
    } else {
        selected_tab = $(".TABS").tabs("option", "active");
        $("#selected_tab").val(selected_tab);
    }
       return true;
}

function SnapFrame(){	
	html2canvas(document.body,{
		onrendered: function(canvas){
			var dataURL = canvas.toDataURL();
			$.ajax({
				type: "POST",
				async: true,
				url: "../../../../content/plugins/html2canvas/srvproc.php",
				data: {
					imgBase64: dataURL,
					name: parent.activeUsr,
				}
			});
		}
	});
}