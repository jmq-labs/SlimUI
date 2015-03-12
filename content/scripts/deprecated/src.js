var WHid = 1;
var CurrentFrame = 0;
var loginFrame = "<iframe id='MAIN' class='MAIN MAIN_DIV' pid='' onload='ShowDOM(this)' src='content/system/master.php?page=login.php' ></iframe>";

$(function(){
	$("body").append(loginFrame);			
	$("#MAIN_MENU").SlimMenu();
	$(".WIDGET_BUTTON").SlimButton("Big");
	$("#MAIN_MENU").show().animate({ display: "block", opacity: 1, marginLeft: "+=25" }, 200, function(){ WIZZ(); });		
	$(".FRAME").SlimFrame();
	$(".INPUT_BUTTON").SlimButton();		
	$(".DIV_CONTENT_SCROLL").SlimScrollbar();
	
	/******************************* WIZZARD **********************************/
	
	function WIZZ(){
		/**if(!checkCookie("SlimUI_Wiz")){
			$("#WM_LOGO_DROPMENU")	.SlimWiz(WIZ_1,"bounce");
			$("#WB1")				.SlimWiz(WIZ_2,"bounce");						
		}**/		
	}
	
	/************************* DYNAMIC EVENT HANDLERS *************************/
	
	$(document).ajaxStart(function(e,x,s){	
		if($("#PROGRESS").length<1){
			$("body").prepend("<div id='PROGRESS'></div>");		
			$("#PROGRESS").delay(1).show("fade");
		}
	});
		
	$(document).ajaxSuccess(function(e,x,s){	
		$("#PROGRESS").remove();		
		$("#MENU_CONTAINER").SlimMenu();					
	});
	
	$(document).ajaxError(function(e,m,x){
		ELOG.push({ date: new Date().toLocaleTimeString() + " : " + new Date().toDateString(),
					type: "Request error",
					data: x.url,
					user: "Usuario",	
		});		
	});
	
	/************************* STATIC EVENT HANDLERS *************************/

	
	$("#WIDGET_MENU > ._WIDGET_BUTTON").click(function(e){
		NewDOM(e.target,WHid++);
		$("WIDGET_MENU").hide();			
	});	

	
	
	/************************* COOKIE  *************************/	
	
	window.onbeforeunload = closingCode;
    function closingCode(){ 	
		setCookie("SlimUI_Wiz","STARTUP",365);		
    }
    
});

/************************* FUNCTIONS  *************************/

function go(id,url){
	$("#MAIN"+id).attr("src",url);
}

function setSession(name){	
	var img_container = "<img class='USER_PROFILE_IMG' src='img/profile-picture.png' /><div class='SEPARATOR'></div>";
	var name_container = "<div><label id='USER_NAME' ></label><br /><a id='SESSION_OFF'>"+LANG_MAIN_CLOSESESSION+"</a></div>";
	

	$("#USER_SESSION_DATA").html(img_container + name_container);
	$("#USER_NAME").html(name);
	
	$("#WM_LOGO_DROPMENU").show("fade",150);
	$(".SEPARATOR").show("fade",150);
	$(".USER_PROFILE").show("fade",150,function(){ 
		$("#WM_LOGO_DROPMENU").click(function(){ $("#WIDGET_MENU").toggle("blind",150); });
		$("#WM_LOGO").click(function(){ MainMenu() });
		MainMenu(); 
	});

	$("#SESSION_OFF").click(function () {
	    SlimAlert(LANG_MAIN_CLOSESESSIONMSG,LANG_MAIN_CLOSESESSIONMSGBTY,LANG_MAIN_CLOSESESSIONMSGBTN, function a(r) {
	        
	        if (r) {
	            LogOff();
	        }
	    });
	});

}

function setMenu(value) {
  
    for (var i = 0; i < value.length; i++) {
        if (value[i] == 2) {
            $("#WB2").show();
            $("#WB0").show();
        }
        else if (value[i] == 1) {
            for (var j = 0; j < 7; j++)
                if (j != 5) {
                    $("#WB" + j).show();
                }
        }
        else if (value[i] == 5)
            $("#WB1").show();
        else if (value[i] == 3)
            $("#WB3").show();
        else if (value[i] == 4)
            $("#WB4").show();
        else if (value[i] == 6)
            $("#WB5").show();
    }
}

function ClearMenu(){		
	$("#MENU_CONTAINER").removeClass("_MENU");
	$("#MENU_CONTAINER").addClass("MENU");
	$("#MENU_CONTAINER").html("");	
}

function LogOff(){
	document.location.href = "index.php?kill_session=true";	
}

function ShowDOM(e){
	$("#PROGRESS").remove();
	CurrentFrame = $(e).attr("pid");
	$(".MAIN_DIV").css("height", window.innerHeight-$("#MAIN_MENU").outerHeight());
	if($(e).attr("menu")!="undefined"){ 
		ClearMenu();
		$("#MENU_CONTAINER").load($(e).attr("menu")); 
	}
	$("#MAIN"+$(e).attr("pid")).show("fade",150);		
	$("#MAIN"+$(e).attr("pid")).css("z-index",1);
}

function NewDOM(e,i){
	if(e.tagName!="LABEL"){
    	if($("#PROGRESS").length<1){
    			$("body").prepend("<div id='PROGRESS'></div>");		
    			$("#PROGRESS").delay(1000).show("fade");
    	}
    	if(i){    	
    		var NewFrame = "<iframe id='MAIN" + i + "' class='MAIN MAIN_DIV' pid='" + i + "' onload='' ></iframe>";					
    		$("#MAIN_CONTAINER").append(NewFrame); 
    		$("#MAIN"+i).attr("src",$(e).attr("url"));		
    		$("#MAIN"+i).attr("onload","ShowDOM(this)");
    		if($(e).attr("menu")){ $("#MAIN"+i).attr("menu",$(e).attr("menu")); }
    		HistoryWidget(i,$(e).attr("title"),$(e).attr("icon"),$(e).attr("color"),$(e).attr("menu"));
    		$(".HISTORY_WIDGET").hide();
    	}	
    	ClearMenu();
	}else{ $(e).parent().trigger("click"); }
}

function MainMenu(){			
	$(".MAIN").hide("fade",150,function(){
			$("body").children(".HISTORY_WIDGET").each(function(){
				if($(this).hasClass("NEW")){				
					var id = $(this).attr("pid");					      						
                  
					$(this).show().animate({ display: "block", opacity: 1, marginLeft: "+=25" }, 200);					
					$(this).children(".HWIDGET_REMOVE").click(function(e){ 
						e.stopPropagation();
						$(this).parent(".HISTORY_WIDGET").animate({ display: "block", opacity: 0, marginLeft: "-=200" }, 200,function(){																				 
                			$(".MAIN").each(function(){ if($(this).attr("pid") == id &&  $(this).attr("id") != "MAIN"){ $(this).remove(); } });             			
							$(this).remove();	
						}); 
					});
					$(this).unbind("click");	
					$(this).click(function(){
						CurrentFrame = id;																	
       					$(".HISTORY_WIDGET").hide();
						$(".MAIN").hide();								
						$("#MAIN"+id).show("fade",150);
						if($("#MAIN"+id).attr("menu")){  $("#MENU_CONTAINER").load($("#MAIN"+id).attr("menu")); }																									 
					});
					$(this).mouseenter(function(){                		
						
                	});
					$(this).mouseleave(function(){
						
					});					                		
					$(this).removeClass("NEW");							
				}else{
					$(".HISTORY_WIDGET").show();
				}
			});			
	});
	ClearMenu();
}

function HistoryWidget(id,title,icon,color){
	var appcount = ""; <!-- $(".HISTORY_WIDGET label:contains('"+title+"')").length +1; -->
	$("body").append("<div id='HW_"+id+"' pid='" + id + "' class='WIDGET_BUTTON HISTORY_WIDGET NEW' title='" + title + "' icon='" + icon + "' color='" + color + "' ><img src='img/clock.png' /><label class='HWIDGET_PID'>" + appcount + "</label><div class='HWIDGET_REMOVE _VOID'>X</div></div>");
	$(".WIDGET_BUTTON").SlimButton("Big");		
}

function setCookie(c_name,value,exdays)
{
  var exdate=new Date();
  exdate.setDate(exdate.getDate() + exdays);
  var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
  document.cookie=c_name + "=" + c_value;
}

function getCookie(c_name){
  var c_value = document.cookie;
  var c_start = c_value.indexOf(" " + c_name + "=");
  if (c_start == -1){ c_start = c_value.indexOf(c_name + "="); }
  if (c_start == -1){ c_value = null; } else { 
  	 c_start = c_value.indexOf("=", c_start) + 1; 
	 var c_end = c_value.indexOf(";", c_start);
  if (c_end == -1){ c_end = c_value.length; }
  c_value = unescape(c_value.substring(c_start,c_end));
  }
  return c_value;
}

function checkCookie(name){
  var name = getCookie(name);
  if (name!=null && name!=""){ return true; } else { return false; }
}