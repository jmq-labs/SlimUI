var WHid = 1; var activeUsr = ""; var CurrentFrame = 0; var _safeMode; var _key; var _confirmCallback = false; var cookie_data = ""; 
var loginFrame = "<iframe id='MAIN0' class='MAIN MAIN_DIV' pid='0' onload='ShowDOM(this)' src='config/system/master.php?page=login.php&auth=true' ></iframe>";

$(function(){
	$("body").append(loginFrame);			
	$("#MAIN_MENU").show().animate({ display: "block", opacity: 1, marginLeft: "+=25" }, 200);
	$(window).bind('hashchange', function(){ parent.window.location(WWWROOT); });
	if(THEME=="x-mas"){$.getScript( "content/themes/x-mas/snow.js");}
	
	var BrowserLogo = "<p><a href='http://www.google.com/intl/en/chrome/browser/'><img  style='border:none;' src='content/img/chromelogo.png' /></a></p>";
	if(browserName.indexOf("Chrome") == -1 && browserName.indexOf("Safari") == -1 && browserName.indexOf("Mobile") == -1){ 
		SlimAlert(LANG_LOGIN_BROWSER_COMP + BrowserLogo);
		_safeMode = true; 
	}
	if(window.navigator.standalone) {    
    	$('body').css("padding-top","20px");
	}
	
	/************************* AJAX CACHE SETUP *************************/
	
	$.ajaxSetup ({ cache: (AJAX_CACHE === true) ? true : false });
	
	/************************* DYNAMIC EVENT HANDLERS *************************/
	
	$(document).ajaxStart(function(e,x,s){		
		if($("#PROGRESS").length<1){
			$("body").prepend("<div id='PROGRESS'></div>");		
			$("#PROGRESS").delay(1000).show("fade");
		}
	});
		
	$(document).ajaxSuccess(function(e,x,s){	
		$("#PROGRESS").remove();		
		$("#MENU_CONTAINER").SlimMenu();					
	});
	
	$(document).ajaxError(function(e,m,x){
		
	});	
	
	$("img, div, label, xmp").click(function(e){
    	var a = $(e.target);
    	if( !a.hasClass("_VOID") && !a.hasClass("METAEDITABLE") ){			
			parent.$(".MENU_LIST").hide("fade",100);
    		parent.$("#WIDGET_MENU").hide("blind",150);			
			$(".TASKWIDGET").remove();			  							
    	}
    });	
	
	window.onbeforeunload = closingCode;
    function closingCode(){ 	
		parent.eLog("Window event","Close");		
    }
});

/************************* FUNCTIONS  *************************/

function go(url){
	$.when($(".MENU_LIST").hide("fade",100)).done(function(){ 
    	var appfolder = "";
    	var source_url = "config/system/master.php?page=../";
    	if($("#MAIN"+CurrentFrame).attr("folder")){ appfolder = $("#MAIN"+CurrentFrame).attr("folder"); }
    	var app_dir = source_url + appfolder;
    	if($("#MAIN"+CurrentFrame).attr("isasp")){ url += "&asp=true"; }
    	if($("#MAIN"+CurrentFrame).attr("safeMode") && $("#MAIN"+CurrentFrame).attr("isasp")){			  
			$("#MAIN"+CurrentFrame).attr("src",appfolder.substr(3) + url.replace("&asp=true",""));
		}else{			
			$("#MAIN"+CurrentFrame).attr("src",app_dir + url);
		}
    	parent.eLog("Menu navigation handler", "URL : "+url);
	});
}

function setSession(name,token){
	if(token){   	
    	var api_session = (function(){    
            var json = new Array();
            $.ajax({
                type: "GET",
                url: "config/api.php",
                dataType: "json",
				cache: false,
          	  	data: { userinfo: "true" },
          	  	async: false,
                success : function(data) {
                          json[0] = data;
                       }
            });
			$.ajax({
                type: "GET",
                url: "config/api.php",
                dataType: "json",
				cache: false,
          	  	data: { cookiedata: "true" },
          	  	async: false,
                success : function(data) {
                          json[1] = data;
                       }
            });
        	return {
				getUserInfo : function(){ if (json[0]){ return json[0] }else{ return false }},
				getCookieOptions : function(){ if (json[1]){ return json[1] }else{ return false }},
			};
        })();
		
		activeUsr = name; displayName = activeUsr;
		_key = $(api_session.getUserInfo())[0][FILTER_BY];
		var img_container = "<img class='USER_PROFILE_IMG' src='content/themes/"+THEME+"/img/profile-picture.png' /><div class='SEPARATOR'></div>";
    	var name_container = "<div><label id='USER_NAME' ></label><br /><a id='SESSION_OFF'>"+LANG_MAIN_CLOSESESSION+"</a></div>";
		if(DEVICE_TYPE=="MOBILE"){ 
			if(activeUsr.length > 20){ displayName = displayName.substr(0,20) + "...";  }
		}else{
		   	if(activeUsr.length > 35){ displayName = displayName.substr(0,35) + "...";  }
		}		
		
		$("#USER_SESSION_DATA").html(img_container + name_container);
    	$("#USER_NAME").html(displayName);
		$("#WM_LOGO").attr("src","content/img/home.png");
    	
    	$("#WM_LOGO_DROPMENU").show("fade",150);
    	$(".SEPARATOR").show("fade",150);
    	$(".USER_PROFILE").show("fade",150,function(){ 
    		$("#WM_LOGO_DROPMENU").click(function(){ $("#WIDGET_MENU").toggle("blind",150); });
    		$("#WM_LOGO").click(function(){ MainMenu(); });
    		MainMenu(); 
    	});
    
    	$("#SESSION_OFF").click(function () {
    	    SlimAlert(LANG_MAIN_CLOSESESSIONMSG,function a(){       
    	        LogOff();
    	    });
    	});
		
		$("#WIDGET_MENU").load("config/appsmenu.php",function(){
    		$("#MAIN_MENU").SlimMenu();
    		$(".WIDGET_BUTTON").SlimButton("Big");    				
    		$(".FRAME").SlimFrame();
    		$(".INPUT_BUTTON").SlimButton();
			$("#WIDGET_MENU ._WIDGET_BUTTON").click(function(e){
				e.stopPropagation();
				$("#WIDGET_MENU").hide("blind",150);
				$("#WIDGET_MENU").promise().done(function(){ NewDOM(e.target,WHid++); });        		        								
        	});
		});		
		
		for(i=0; i<$(api_session.getCookieOptions()).length; i++){
		   cookie_data += $(api_session.getUserInfo())[0][$(api_session.getCookieOptions())[i][0]]+";";		   
		}		
		
		setCookie("slimtoken",cookie_data.slice(0,-1),1);
		parent.eLog("Login event","Navegador: "+browserName+" Ver. "+majorVersion);	
		$.get('http://ipinfo.io', function(data) { parent.eLog("Client Ip address", data.ip); }, "jsonp");
	}else{
		  window.location = "index.php";
	}
}

function ClearMenu(){		
	$("#MENU_CONTAINER").removeClass("_MENU");
	$("#MENU_CONTAINER").addClass("MENU");
	$("#MENU_CONTAINER").html("");	
}

function LogOff(){
	document.location.href = WWWROOT + "?kill_session=true";	
}

function ShowDOM(e,safeMode){
	if(DEVICE_TYPE=="MOBILE"){ $(".MAIN").hide(); }
	CurrentFrame = $(e).attr("pid");
	$(".MAIN_DIV").css("height", window.innerHeight-$("#MAIN_MENU").outerHeight());	
	if(safeMode==true && $(e).attr("isasp")){	                                                                 
       $.get("config/system/master.php?getheaders=true", function(data){  $("#MAIN" + CurrentFrame).contents().find("head").append(data); });	   	   
	   $("#MAIN" + CurrentFrame).contents().find('body').hide();
	   function loadScript(url, callback){
            var script = document.createElement("script")
            script.type = "text/javascript";        
            if (script.readyState){  //IE
                script.onreadystatechange = function(){
                    if (script.readyState == "loaded" ||
                            script.readyState == "complete"){
                        script.onreadystatechange = null;
                        callback();
                    }
                };
            } else {  //Others
                script.onload = function(){
                    callback();
                };
            }        
            script.src = url;
            $("#MAIN" + CurrentFrame).contents().find('head')[0].appendChild(script);
        }		
		loadScript(WWWROOT+"content/scripts/jquery/jquery-1.11.2.min.js",function(){
			loadScript(WWWROOT+"content/scripts/jquery/jquery-ui.min.js",function(){
				loadScript(WWWROOT+"content/scripts/slim-ui-1.0.min.js",function(){
					loadScript(WWWROOT+"content/plugins/timepicker/jquery-ui-timepicker.js",function(){
						loadScript(WWWROOT+"content/plugins/mask/qunit-1.11.0.js",function(){
							loadScript(WWWROOT+"content/plugins/mask/jquery.mask.js",function(){
								loadScript(WWWROOT+"content/scripts/safemode.js",function(){									
									$("#MAIN" + CurrentFrame).contents().find('body').show();															
								});
							});
						});
					});				
				});	
			});
		});
	}
	if($(e).attr("appmenu") && $("#MENU_CONTAINER").is(":empty")){ 
		ClearMenu();
		$("#MENU_CONTAINER").load($(e).attr("appmenu"),function(){			
			$.ajax({
                 type: "GET",
                 url: WWWROOT+$(e).attr("folder").substr(3)+"appid.xml",
                 dataType: "xml",
				 cache: false,
                 success: function(xml){
					var count = $("display_menu_filters", xml).children().length;
					var obj = $("display_menu_filters", xml).children();										
					for(i=0; i < count; i++){						
						var keys = obj[i].childNodes[0].data.split(",");
						if(keys.indexOf(_key)==-1){
							$("#"+obj.get(i).tagName).remove();
						}else{
							$("#"+obj.get(i).tagName).show();
						}
					}						                    	
     			}
            });			
		}); 
	}	
	$(e).show("fade",150);		
	$(e).css("z-index",1);	
}

function NewDOM(e,i,safeMode){
	var _url = $(e).attr("url");
	if(!safeMode){ if(_safeMode){ safeMode = true; } if($(e).attr("safemode")){ safeMode = true; } }
	if(safeMode == true && $(e).attr("isasp")){ _url = $(e).attr("url").substr("36").replace("&asp=true",""); }	
	if(e.tagName!="LABEL"){    	
    	if(i){			    		
			var NewFrame = $("<iframe/>", {                    
               id:		   "MAIN" + i,
			   Class:	   "MAIN MAIN_DIV",
			   pid:		   i,
			   appname:	   $(e).attr("appname"),
			   src:		   _url,
			   onload_src: $(e).attr("onload_src"),
			   isasp:	   $(e).attr("isasp"),
			   folder:	   $(e).attr("folder"),
			   safemode:   safeMode,
			   appmenu:	   $(e).attr("appmenu"),
               style:	   'display:none',
               load:	   function(){ ShowDOM(this,safeMode); }
            });		
    		$("#MAIN_CONTAINER").append(NewFrame);    		
			HistoryWidget(i,$(e).attr("title"),$(e).attr("icon"),$(e).attr("color"),$(e).attr("appmenu"));
    		$(".HISTORY_WIDGET").hide();
    	}	
    	ClearMenu();
	}else{ $(e).parent().trigger("click"); }
}

function MainMenu(){			
	$(".MAIN").hide("fade",150,function(){
			$(".HISTORY_WIDGET").each(function(){
				if($(this).hasClass("NEW")){				
					var id = $(this).attr("pid");
					$(this).show().animate({ display: "inline-block", opacity: 1, marginLeft: "+=25" }, 200);					
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
						if($("#MAIN"+id).attr("appmenu")){  $("#MENU_CONTAINER").load($("#MAIN"+id).attr("appmenu"),function(){
							$.ajax({
                               type: "GET",
                               url: WWWROOT+$("#MAIN"+id).attr("folder").substr(3)+"appid.xml",
                               dataType: "xml",
                               success: function(xml){
              						var count = $("display_menu_filters", xml).children().length;
              						var obj = $("display_menu_filters", xml).children();					
              						for(i=0; i < count; i++){
                						var keys = obj[i].childNodes[0].data.split(",");
                						if(keys.indexOf(_key)==-1){
                							$("#"+obj.get(i).tagName).remove();
                						}else{
                							$("#"+obj.get(i).tagName).show();
                						}
              						}						                    	
                   				}
                          	}); 
						});}
						parent.eLog("Interface handler", "Open widget : " + $(this).attr("title"));																									 
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
	parent.eLog("Interface handler", "Show desktop");
	ClearMenu();
}

function HistoryWidget(id,title,icon,color){
	var appcount = ""; <!-- $(".HISTORY_WIDGET label:contains('"+title+"')").length +1; -->
	$("#HISTORY_WIDGETS").append("<div id='HW_"+id+"' pid='" + id + "' class='WIDGET_BUTTON HISTORY_WIDGET NEW' title='" + title + "' icon='" + icon + "' color='" + color + "' ><img src='content/img/clock.png' /><label class='HWIDGET_PID'>" + appcount + "</label><div class='HWIDGET_REMOVE _VOID'><img src='content/img/widget-close.png' /></div></div>");
	$(".WIDGET_BUTTON").SlimButton("Big");		
}

<!------------------------ Cookies ------------------------>

function setCookie(c_name,value,exdays)
{
  eraseCookie(c_name);
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

function eraseCookie(name) {
    document.cookie = name + '=; Max-Age=0'
}

<!------------------------ Cookies END ------------------------>

function HideMenu(m){
 $("#"+m).hide();
}

function ShowMenu(m){
 $("#"+m).show();
}

function ConfirmAsp(m, b){	
    if(_confirmCallback == false){		
		parent.SlimAlert(m, function a(){	  
    	  _confirmCallback = true;		    	  
		  $.when($(b).trigger("click")).then(function(){ _confirmCallback = false; });  		  
		});		
	}
    return _confirmCallback;
}