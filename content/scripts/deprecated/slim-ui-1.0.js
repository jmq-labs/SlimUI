/*********************************************************************/
/*                                                                   */
/*                           Slim UI 1.0                             */
/*                        by Jose M. Quiroz                          */
/*                            2013-05-09                             */
/*                                                                   */
/*                   Dependencies:   jQuery 1.9.1                    */
/*                                   jQuery UI 1.10                  */
/*                                                                   */
/*                     ...Here, take my code!                        */
/*                Comments to: josemq2000@gmail.com                  */
/*                                                                   */
/*********************************************************************/

var ELOG = new Array;
var WIZZ = new Array;
var WIZZin = new Array;

$.fn.SlimMenu = function(o,s){
	$(this).each(function(){
      $(this).children(".INPUT_BUTTON").SlimButton();
      $(this).children().each(function(){ 
      $(this).children(".INPUT_BUTTON").SlimButton(); 
      });
      if(!o){
       if(!$(this).hasClass("_MENU")){
    	$(this).children(".INPUT_MENU").each(function(){
    		$(this).append("<div class='MENU_LIST'></div>");
    		$(this).children(".MENU_LIST").append($(this).children("span, hr"));
    		$(this).click(function(e){
    		$(".MENU_LIST").hide("fade",100); 
    			if(e.target.nodeName!="SPAN"){ 
    		 		if($(this).children(".MENU_LIST").children().length > 0){ 
						$(this).children(".MENU_LIST").toggle("fade",100);
					} 
    			} 
    		});			 
    		if($(this).parent().attr('id')=="MAIN_MENU"){
        		$(this).children(".MENU_LIST").each(function(){
        			$(this).click(function(){ $(".MAIN").hide(); });
        		});
    		}			
    		$(this).parent().addClass("_MENU");
			$(this).parent().removeClass("MENU");
			if(!$(this).hasClass("_VOID")){ $(this).addClass("_VOID"); }							 
    	});		
       }
      }
      if(o=="SearchList"){
       if(!$(this).hasClass("_CONTEXT_MENU")){
	    $(this).SlimTextbox();
    	$(this).append("<div class='MENU_LIST'></div>");
		$(this).children(".MENU_LIST").append($(this).children("span"));
    	$(this).children(".MENU_LIST").children("span").each(function(){
    		$(this).click(function(){ 
    			$(this).parent().parent().children("input").val($(this).html()); 
    		});    		
    		if($(this).children().length>0){
        		$(this).children("span").each(function(){ 
        			$(this).parent("span").append("<div class='MENU_LIST'></div>");
        	 		$(this).parent().children(".MENU_LIST").append($(this).parent().children("span"));      				
        		});
        		$(this).children(".MENU_LIST").children("span").click(function(){ 
        			$(this).parent().parent().parent().parent().children("input").val($(this).html());
        		});
    		}
    		$(this).hover(function(){					
    			$(this).children(".MENU_LIST").show(); 				 									
    		});	
    		$(this).mouseout(function(e){
    			var borderLimit = 3;			
    			var x = e.pageX - $(this).parent().position().left;					
    			var y = e.pageY - $(this).parent().position().top;					
    			var w = $(this).parent().outerWidth()+$(this).outerWidth();										
    			
    			var h = $(this).outerHeight() - borderLimit;
    			var hm = $(this).children(".MENU_LIST").outerHeight() - borderLimit;
    			var wm = $(this).parent().outerWidth();
    			var t = $(this).position().top + borderLimit;					
    				
    			if( x < wm && ( y < t || y > t + h ) || x < borderLimit ){						
    				$(this).children(".MENU_LIST").hide(); 
    			}
    			if( x > wm  && ( y < t || y > t + hm ) || x < borderLimit ){						
    				$(this).children(".MENU_LIST").hide(); 
    			}
    			if( x > w ){						
    				$(this).children(".MENU_LIST").hide(); 
    			}
    											
    		});		
    	});
    	$(this).children("input").click(function(){ 
    	 	$(".MENU_LIST").hide();
			$(this).parent().children(".MENU_LIST").show();
    		$(this).parent().children(".MENU_LIST").children("span").each(function(){
    		    $(this).show();
    		});
    	});
    	$(this).children("input").keydown(function(e){
    	 	$(this).parent().children(".MENU_LIST").show();			 	     	    
    		$(this).parent().children(".MENU_LIST").children("span").each(function(){ 		
       		 	var i = $(this).parent().parent().children("input").val().toUpperCase();
       			var j = $(this).html().toUpperCase();
       			if(j.indexOf(i)==-1){ 
       				$(this).hide(); 
       			}else{ 
    				$(this).show(); 
    			}
       		});
    	    if(e.which == 40){					
    		}
    		if(e.which == 38){ 
    		}
       	});    	
    	$(this).addClass("_CONTEXT_MENU");
		if(!$(this).hasClass("_VOID")){ $(this).addClass("_VOID"); }			 		 
      }
     }
  });  
}

$(document).ready(function(){
    $("img, div, label, xmp").click(function(e){
    	var a = $(e.target);
    	if( a.hasClass("_VOID")!=true ){			
			parent.$(".MENU_LIST").hide("fade",100);
    		parent.$("#WIDGET_MENU").hide("blind",150);			  							
    	}
    });
    $("input, textarea").focusin(function(){ $(".MENU_LIST").hide("fade",100); });  
});
/**************************** INPUTS CONSTRUCTOR ****************************/


$.fn.SlimButton = function(o){
  $(this).each(function(){  
      if(o=="Big"){
     	 if(!$(this).hasClass("_WIDGET_BUTTON")){
         	$(this).css("background-image","url('"+$(this).attr('icon')+"')");
         	$(this).append("<br /><label>"+$(this).attr("title")+"</label>");
         	$(this).css("background-color",$(this).attr("color"));
         	$(this).addClass("_WIDGET_BUTTON");
         	$(this).removeClass("WIDGET_BUTTON");
         	$(this).click(function(e){				
         		ELOG.push({ date: new Date().toLocaleTimeString() + " : " + new Date().toDateString(),
         			type: "Click handler",
         			data: $(e.target).attr("id"),
         			user: "Usuario",
         		});				     		
         	});			
     	 }
      }
      if(!o){
    	  if(!$(this).hasClass("_INPUT_BUTTON")){
            $(this).each(function(){						
        		if($(this).attr("icon")){ 
        			$(this).css("background-image","url('"+$(this).attr("icon")+"')");
        		}
        		$(this).click(function(e){		
        			ELOG.push({ date: new Date().toLocaleTimeString() + " : " + new Date().toDateString(),
        			  type: "Click handler",
        			  data: $(e.target).attr("id"),
        			  user: "Usuario",
        			});
        		});
        		$(this).addClass("_INPUT_BUTTON"); 
        		$(this).removeClass("INPUT_BUTTON");		 
        	});
    	 }
     }
  });
}

$.fn.SlimTextbox = function(){	 
  $(this).each(function(){
	 if($(this).attr("icon")){
	 	$(this).prepend("<img />"); 
		$(this).children("img").attr("src",$(this).attr("icon")); 
		$(this).children("img").click(function(){ 
			$(this).parent().children("input").trigger("click"); 
		});
	 }
	 	 
	 if($(this).attr("value")){	INPUT_VALUE = $(this).attr("value")}else{ INPUT_VALUE="" }
	 if($(this).children("input").length < 1){
	 	var READONLY = "";
	    if($(this).attr("READONLY")){ READONLY = "READONLY" }
		$(this).prepend("<input id='"+"INPUT_"+$(this).prop("id")+"' name='"+"INPUT_"+$(this).prop("id")+"' value='"+INPUT_VALUE+"' type='text' autocomplete='off' "+READONLY+" />");		
	 }	  	
	 $(this).addClass("_INPUT_TEXT");
	 $(this).removeClass("INPUT_TEXT");
	 if(!$(this).children("input, img").hasClass("_VOID")){ $(this).children("input, img").addClass("_VOID"); }
  });
}

$.fn.SlimTextArea = function(){
$(this).each(function(){
	if(!$(this).hasClass("_TEXT_AREA")){
    	$(this).each(function(){ 
    		$(this).html("<textarea id='"+"INPUT_"+$(this).prop("id")+"' name='"+"INPUT_"+$(this).prop("id")+"' ></textarea>");
    		$(this).addClass("_TEXT_AREA");
    	});
	}
});
}

$.fn.SlimCheckbox = function(){
$(this).each(function(){
	if(!$(this).hasClass("_CHECKBOX")){
		$(this).each(function(){ 
			if($(this).children("input").length < 1){    			
				var _CHECKED = "";
				if($(this).hasClass("CHECKED")){ _CHECKED = "&nbsp;checked&nbsp;"; }
				$(this).html("<label for='"+"INPUT_"+$(this).prop("id")+"'>"+$(this).prop("title")+"</label><input "+_CHECKED+" id='"+"INPUT_"+$(this).prop("id")+"' name='"+"INPUT_"+$(this).prop("id")+"' type='checkbox' />");				    			
			}
			$(this).addClass("_CHECKBOX");
    		$(this).removeClass("CHECKBOX");
		});	
	}
});
}

$.fn.SlimRadio = function(){
$(this).each(function(){
	if(!$(this).hasClass("_RADIO")){
		$(".RADIO").each(function(){ 
		    if($(this).children("input").length < 1){
				var _CHECKED = "";
				if($(this).hasClass("CHECKED")){ _CHECKED = "checked"; }
    			$(this).html("<input  "+_CHECKED+" id='"+"INPUT_"+$(this).prop("id")+"' name='"+"INPUT_"+$(this).attr("name")+"' value='"+$(this).attr("value")+"' type='radio' /><label for='"+"INPUT_"+$(this).prop("id")+"'>"+$(this).prop("title")+"</label>");
    			$(this).addClass("_RADIO");
    			$(this).removeClass("RADIO");
			}
		});
	}
});
}

$.fn.SlimContentLoad = function(){
$(this).each(function(){
	if(!$(this).hasClass("_CONTENT")){
    	$(this).each(function(){
    		if($(this).attr("SRC")){
        		$(this).load($(this).attr("SRC"));        		        		
    		}			
			$(this).addClass("_CONTENT");
    	});
	}
});
}

$.fn.SlimFrame = function(){
$(this).each(function(){
	if(!$(this).hasClass("_CONTENT")){
		$(this).each(function(){ 
			if($(this).prop("title")){ 
				$(this).prepend("<label class='CONTENT_TITLE'>"+$(this).prop("title")+"</label>"); 
				$(this).css("margin-top",10);
			} 
			$(this).attr("title","");
			$(this).addClass("_FRAME");
    		$(this).removeClass("FRAME");  
		});
	}
});	
}

$.fn.SlimColorPicker = function(){
$(this).each(function(){
	if(!$(this).hasClass("_COLOR_PICKER")){
	    var c = $("._COLOR_PICKER").length;
    	if($(this).children("input").lenght == 0){
		    $(this).append("<input type='hidden' id='COLORPICKER"+c+"' name='COLORPICKER"+c+"' ></input> ");
		}
		$(this).children(".COLOR_BOX").each(function(){ 
    		$(this).click(function(){ 
				$(this).parent().children(".COLOR_BOX").removeClass("COLOR_SELECTED");
				$(this).parent().children("input").val($(this).css("background-color"));
				$(this).animate({opacity: 0},50).toggleClass("COLOR_SELECTED").animate({opacity: 1},50); 
			});    	
		});		
		$(this).addClass("_COLOR_PICKER");
   		$(this).removeClass("COLOR_PICKER");
	}
});	
}

/************************* ALERT WINDOW CONSTRUCTOR *************************/

function SlimAlert(m,bY,bN,o){
    if(!m){ m = "- Mensaje no definido!"; } 
	if(!bY) { bY = "Ok"; }
	if(!bN) { bN = "Cancel"; }
	var BKS = "<div class='BLOCK_SCREEN'></div><div class='MSG_WINDOW'></div>"
	var BT_OPTION1 = "<br /><input type='button' id='MSG_CONFIRM_BT' class='_INPUT_BUTTON' value='"+bY+"' />"; 
	var BT_OPTION2 = "<br /><input type='button' id='MSG_CONFIRM_BT' class='_INPUT_BUTTON' value='"+bY+"' /><input type='button' id='MSG_CANCEL_BT' class='_INPUT_BUTTON' value='"+bN+"' />";
	
	if($(".BLOCK_SCREEN").length == 0){ $('body').append(BKS); }				
	$(".MSG_WINDOW").html("<p><label>"+m+"</label></p>");
	
	if(!o){ 
		$(".MSG_WINDOW").append(BT_OPTION1);
		$("#MSG_CONFIRM_BT").click(function(){
			$(".BLOCK_SCREEN").hide("fade","fast",function(){ $(".BLOCK_SCREEN").remove(); }); 
			$(".MSG_WINDOW").hide("fade","fast",function(){ $(".MSG_WINDOW").remove(); }); 
		}); 
	}else{ 
		$(".MSG_WINDOW").append(BT_OPTION2);
		$("#MSG_CANCEL_BT").click(function(){ o(false); 
			$(".BLOCK_SCREEN").hide("fade","fast",function(){ $(".BLOCK_SCREEN").remove(); }); 
			$(".MSG_WINDOW").hide("fade","fast",function(){ $(".MSG_WINDOW").remove(); }); 
		});
		$("#MSG_CONFIRM_BT").click(function(){ o(true); 
			$(".BLOCK_SCREEN").hide("fade","fast",function(){ $(".BLOCK_SCREEN").remove(); }); 
			$(".MSG_WINDOW").hide("fade","fast",function(){ $(".MSG_WINDOW").remove(); }); 
		});	
	}	
			
	ELOG.push({ date: new Date().toLocaleTimeString() + " : " + new Date().toDateString(),
		type: "Alert",
		data: m,
		user: "Usuario",
	});
	$("#MSG_CONFIRM_BT, #MSG_CANCEL_BT").click(function(e){		
		ELOG.push({ date: new Date().toLocaleTimeString() + " : " + new Date().toDateString(),
		  type: "Alert Callback",
		  data: $(this).attr("id"),
		  user: "Usuario",
		});
	});
	
	$(".BLOCK_SCREEN").show("fade","fast");
	$(".MSG_WINDOW").show("fade","fast",function(){ $("#MSG_CONFIRM_BT").focus(); });	
}

/************************* SlimWiz *************************/

$.fn.SlimWiz = function(content,fx,trigger){	
	if(trigger){
		 WIZZ = []; $(".WIZZ").removeClass("WIZZ");
	}
	if($(this).length){
		WIZZ.push({ 
    		object: $(this),
       		content: content,
			effect: fx, 				
       	});	
        $(this).addClass("WIZZ");
	}
	if(trigger){		
		clearInterval(WIZZin);
		WIZZin = setInterval(function(){ WizzPreload(0,trigger) },500);		 
	}
}

function WizzStart(i,trigger){
	next = parseInt(i) + 1;
	var x = WIZZ[i]["object"].outerWidth()+WIZZ[i]["object"].offset().left;
	var y = WIZZ[i]["object"].outerHeight()+WIZZ[i]["object"].offset().top;
		
	WIZZ[i]["object"].one("click",function(e){
	   $(".SLIMWIZ").remove();	   	   
       if($(this).hasClass("WIZZ-READY")){   
       	 $(this).removeClass("WIZZ-READY");		 
		 $(this).unbind("click", WIZZ_click);		 
		 WIZZin = setInterval(function(){WizzPreload(next)},500);		         		 
       } 
	});	
	
	$("body").append("<div class='SLIMWIZ'><div class='WIZ_CONTENT'><span>"+WIZZ[i]["content"]+"</span><hr /><label id='WIZ_CANCEL'>Omitir tutorial</label></div></div>");    
	$("#WIZ_CANCEL").click(function(){ $(".SLIMWIZ").hide("fade",function(){ $(".SLIMWIZ").remove(); }); WIZZ = []; });
	$(".SLIMWIZ").css("left",x);
    $(".SLIMWIZ").css("top",y);
    $(".SLIMWIZ").show("fade","fast");
	WIZZ[i]["object"].effect(WIZZ[i]["effect"],900);		
	WIZZ[i]["object"].addClass("WIZZ-READY");
}

function WizzPreload(i,trigger){
	var c = $(".WIZZ").length;
	var doubles = 0; 
	for(var j=0; j<WIZZ.length; j++){
		for(var k=0; k<WIZZ.length; k++){		
    		if( j != k && WIZZ[j]["object"].attr("id") == WIZZ[k]["object"].attr("id")){
    			doubles++; 
    		}
		}
	}
	if(c == (WIZZ.length-Math.round(Math.sqrt(doubles)))){		
		WizzStart(i);		
		clearInterval(WIZZin,trigger);				
	}
}
/**var WIZZin = setInterval(function(){ WizzPreload(0) },1500);**/

/************************* SCROLLBAR CONSTRUCTOR *************************/

$.fn.SlimScrollbar = function(e){
$(".CONTENT").SlimContentLoad();
$(".MAIN_DIV").css("height", window.innerHeight-$("#MAIN_MENU").outerHeight());
	$(this).each(function(){
				
		if(navigator.userAgent.indexOf("Chrome")>-1){ 
		var yAxis = 0;
		var ScrollFactor = 0.1;
		        
		var canvasWrapperHeight = $(this).height(); 
        var canvasHeight = $(this).children("._CONTENT").height();
        var vbarHeight = canvasWrapperHeight * canvasWrapperHeight / canvasHeight;
				
		if(canvasHeight>=vbarHeight){ 
			$(this).children("._CONTENT").css("margin-right","20px");
    	    if($(this).children(".VSCROLL").length == 0){ 
			   $(this).prepend("<div class='VSCROLL' ><div class='VBAR'></div></div>"); 
			}
    		
			canvasHeight = parseInt($(this).children("._CONTENT").css("height"),10);
			vbarHeight = canvasWrapperHeight * canvasWrapperHeight / canvasHeight;
			
			$(this).children(".VSCROLL").children(".VBAR").css("height",vbarHeight);	
    		$(this).children(".VSCROLL").children(".VBAR").draggable({ containment: "parent" });    		

    		if(!e){
				$(this).children("._CONTENT").css("margin-top",yAxis=0);
				$(".VBAR").css("top",0);
			}
			
			$(this).children(".VSCROLL").children(".VBAR").unbind("drag");
			$(this).children(".VSCROLL").children(".VBAR").on("drag", function (event, ui) {
                var ctop = (-ui.position.top * canvasHeight / canvasWrapperHeight);
                $(this).parent().parent().children("._CONTENT").css("margin-top",ctop);
				yAxis = -ui.position.top; $(".MENU_LIST").hide("fade",100);       	
            });			
			
			$(this).children(".VSCROLL").unbind("click");
			$(this).children(".VSCROLL").click(function(e){									
				if( (e.pageY - this.offsetTop) < parseInt($(this).parent().children(".VSCROLL").children(".VBAR").css("top")) + $(this).parent().children(".VSCROLL").children(".VBAR").height() ){
    				yAxis = yAxis + (($(this).parent().children(".VSCROLL").height()-$(this).parent().children(".VSCROLL").children(".VBAR").height())*ScrollFactor);
					$(this).parent().children("._CONTENT").css("margin-top",yAxis*(canvasHeight / canvasWrapperHeight));
    				$(this).parent().children(".VSCROLL").children(".VBAR").css("top",-(yAxis));
				}
				if((e.pageY - this.offsetTop) > parseInt($(this).parent().children(".VSCROLL").children(".VBAR").css("top"))){
					yAxis = yAxis - (($(this).parent().children(".VSCROLL").height()-$(this).parent().children(".VSCROLL").children(".VBAR").height())*ScrollFactor);
					$(this).parent().children("._CONTENT").css("margin-top",yAxis*(canvasHeight / canvasWrapperHeight));
    				$(this).parent().children(".VSCROLL").children(".VBAR").css("top",-(yAxis));					
				}
			});
			
			$(this).children("._CONTENT").unbind('mousewheel');
			$(this).children("._CONTENT").bind('mousewheel',function(e){				
			 	e.stopPropagation();      	
   				var vBarTop = parseInt($(this).parent().children(".VSCROLL").children(".VBAR").css("top"),10);				
				if(e.originalEvent.wheelDelta/120 > 0 ){
   					if(vBarTop > 0){
					   yAxis = yAxis + (($(this).parent().children(".VSCROLL").height()-$(this).parent().children(".VSCROLL").children(".VBAR").height())*ScrollFactor);
					   $(this).css("margin-top",yAxis*(canvasHeight / canvasWrapperHeight));
					}else{ 
					   $(this).parent().children(".VSCROLL").children(".VBAR").css("top",yAxis); 
					}
   				}else{
   					if( vBarTop < ( canvasWrapperHeight - $(this).parent().children(".VSCROLL").children(".VBAR").height()) ){
					   yAxis = yAxis - (($(this).parent().children(".VSCROLL").height()-$(this).parent().children(".VSCROLL").children(".VBAR").height())*ScrollFactor);
					   $(this).css("margin-top",yAxis*(canvasHeight / canvasWrapperHeight));
					}else{ 
					   $(this).parent().children(".VSCROLL").children(".VBAR").css("top",yAxis);
					}
   				}
   				$(this).parent().children(".VSCROLL").children(".VBAR").css("top",-yAxis);
				$(".MENU_LIST").hide("fade",100);				
            });    
		}else{			
			$(this).children("._CONTENT").css("margin-right","0px");
			$(this).children("._CONTENT").css("margin-top","0px");
			$(this).children(".VSCROLL").remove();			 
		} 
	  }        
   $(this).unbind("DOMSubtreeModified");   
   $(this).bind("DOMSubtreeModified",function(e){ $(this).SlimScrollbar(e); });      
 });
}
$(window).resize(function(){ $(".DIV_CONTENT_SCROLL").SlimScrollbar(); });