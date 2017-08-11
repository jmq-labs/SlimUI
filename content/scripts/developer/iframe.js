var isIdle = false; var lastBtn;

$(function() {	
	if(parent.DEVICE_TYPE=="MOBILE"){ 
		$('input').on('change', function(){ $(this).blur(); }); 
	}
	if(isAsp){  
		if( !safeMode){
			ajaxPostBack();
		}
	}else{
		applySlimUi(); 
	}
	
	$.datepicker.setDefaults({ dateFormat: 'dd/mm/yy' });
	
	setInterval(function(){ 
		if (isIdle == true){
			SnapFrame();
			isIdle = false;
		}
	},500);
});

function CheckAlerts(){
	switch(code){
      case "e0Auth":
        parent.SlimAlert(LANG_LOGIN_ERRCODEAUTH0);
        break;
	  case "e1Auth":
        parent.SlimAlert(LANG_LOGIN_ERRCODEAUTH1);
        break;
      case "e0Conn":
        parent.SlimAlert(LANG_LOGIN_ERRCODECONN0);
        break;
	  case "e0Token":
        parent.SlimAlert(LANG_TOKEN_E0);
        break;
	  case "e1Token":
        parent.SlimAlert(LANG_TOKEN_E1);
        break;
	  case "e2Auth":
        parent.SlimAlert(LANG_LOGIN_ERRCODEAUTH2);
        break;				
      default:
    }
}

function ajaxPostBack(f){	
	var btn = $("form").find(":focus");
	var formData = new FormData(document.getElementById(f));
	//alert(f + " | " + $(btn).attr("onclick") + " | " + $(btn).attr("href") + " | " + $(btn).attr("id"));
	if(f && !$(btn).attr("onclick") && !$(btn).attr("href")){
		if(!formData.has('__EVENTTARGET')){	
			if($(btn).attr("id")){ 
				formData.append('__EVENTTARGET',$(btn).attr("id"));
			}else{
				if(lastBtn){ formData.append('__EVENTTARGET',lastBtn); lastBtn = ""; }
			}
		}else{
			if($(btn).attr("id")){
				formData.set('__EVENTTARGET',$(btn).attr("id"));
			}else{
				if(lastBtn){ formData.set('__EVENTTARGET',lastBtn); lastBtn = ""; }
			}
			
		}
	}
	
	if(btn.attr('method')=="EXPORT"){		
        exportMode();
    }else{
		$.ajax({
            type: 'POST',
    		url: url,    		
    		data: formData,						
			cache: false,          	
			contentType: false,	
    		processData: false,	
        }).done(function( html ){
        	$("#INCLUDE_FRAME").html(html);
        	$("form").each(function(){				
				$("input").click(function(){ lastBtn = $(this).attr("id"); });
				$(this).attr("action","javascript:ajaxPostBack('" + $(this).attr("id") + "')");				
        	});
        	applySlimUi();		
        }).fail(function(xhr,x,e){			
			var appname = parent.$("#"+window.frameElement.id).attr("appname");
			var app = parent.$("#WB_"+appname);
    		parent.SlimAlert(parent.LANG_SAFEMODE_ALERT+"<br /><code>" + e + "</code>",function(){
				parent.NewDOM(app,parent.WHid++,true); 
    		});			
		});
	}
	function exportMode(){
	    $(".EXPORT_IFRAME").remove();
		var c = $("body").clone();        		
			c.find("script").each(function(){ $(this).remove(); });
			c.find("form").attr("action", "");
			c.find("form").attr("src", url);							
			var ifr = $('<iframe/>', {                    
                src:url,
                style:'display:none',
				Class: 'EXPORT_IFRAME',
                load:function(){						
                    $(".EXPORT_IFRAME").unbind("load");
					$(this).contents().find("body").html("");
                    $(this).contents().find("body").append(c.html());									
					$(this).contents().find("#" + btn.attr("id")).click();																
                }
         });		 
         $('body').append(ifr);		 
	}	 
}

function applySlimUi(){
	$.getScript("../../content/plugins/html2canvas/html2canvas.js");
	var selected_tab = $("#selected_tab").val() != "" ? parseInt($("#selected_tab").val()) : 0;
	$(":checkbox").each(function(){ $(this).change(function(){ if($(this).prop("checked")){ $(this).attr("checked", true) }else{ $(this).attr("checked", false) } }); });
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
	if(parent.$("#"+window.frameElement.id).attr("onload_src")){ 
		$.getScript("../"+parent.$("#"+window.frameElement.id).attr("folder")+parent.$("#"+window.frameElement.id).attr("onload_src")); 
	}
	ReqFields();
	CheckAlerts();
}

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
	if(!safeMode){		
		html2canvas(document.body,{
			onrendered: function(canvas){
				var dataURL = canvas.toDataURL();
				$.ajax({
					type: "POST",
					async: true,
					url: "../../content/plugins/html2canvas/srvproc.php",
					data: {
						imgBase64: dataURL,
						name: parent.activeUsr,
					}
				});
			}
		});
	}
}