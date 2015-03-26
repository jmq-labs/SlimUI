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
/*                      Twitter: @josemq2000						 */
/*                                                                   */
/*********************************************************************/

function eLog(t,d){
   if(ELOGS == "true"){
      $.ajax({
             async: true,
         	  url: "content/apps/logs/process.php",
         	  type: "POST",      
       	  data: { name: parent.activeUsr, type: t, data: d }
      });
   }
}

$.fn.SlimMenu = function(o,s){
	$(this).each(function(){
      $(this).children(".INPUT_BUTTON").SlimButton();
      $(this).children().each(function(){ 
      $(this).children(".INPUT_BUTTON").SlimButton(); 
      });
      if(!o){
       if(!$(this).hasClass("_MENU")){
    	$(this).children(".INPUT_MENU").each(function(){ 
			var divTitle = "";
			if($(this).contents("._INPUT_BUTTON").length > 0){
				var divTitle = "<div class='MENU_LIST_TITLE _VOID'>" + $(this).contents().get(0).nodeValue; + "</div>";
			}
			$(this).append("<div class='MENU_LIST'>" + divTitle + "</div>");    		
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
			$(this).click(function(){		
        			parent.eLog("Input click handler", $(this).attr("id") + " : " + $(this).attr("title"));
        	});		         				
     	 }
      }
      if(!o){
    	 if(!$(this).hasClass("_INPUT_BUTTON")){
            $(this).each(function(){		
        		if($(this).attr("icon")){ 
        			$(this).css("background-image","url('"+$(this).attr("icon")+"')");
        		}			      		
        		$(this).addClass("_INPUT_BUTTON"); 
        		$(this).removeClass("INPUT_BUTTON");		 
        	});
    	 }
     }
  });
}

$.fn.SlimTextbox = function(){	 
  $(this).each(function(){
     if(!$(this).parent().hasClass("_INPUT_TEXT")){
        $(this).wrap("<div class='_INPUT_TEXT'></div>");
		$(this).removeClass("INPUT_TEXT");
     }
	 if($(this).attr("icon")){
	 	$(this).prepend("<img />"); 
		$(this).children("img").attr("src",$(this).attr("icon")); 
		$(this).children("img").click(function(){ 
			$(this).parent().children("input").trigger("click"); 
		});
	 }	 	 	 
	 if(!$(this).children("input, img").hasClass("_VOID")){ $(this).children("input, img").addClass("_VOID"); }
  });
  $("input").click(function(){ parent.eLog("Input click handler", $(this).attr("id")+" : "+$(this).val()); });
  $(":text").change(function(){ parent.eLog("Text change handler", $(this).attr("id")+" : "+$(this).val()); });
}

$.fn.SlimTextArea = function(){
  $(this).each(function(){
  	if(!$(this).parent().hasClass("TEXT_AREA") && $(this).is("textarea")){
          $(this).wrap("<div class='_TEXT_AREA'></div>");
  		$(this).removeClass("TEXT_AREA");		
      }
  });
  $("input, textarea").focusin(function(){ $(".MENU_LIST").hide("fade",100); });
}

$.fn.SlimComboBox = function(){
  $(this).each(function(){
  	if($(this).hasClass("COMBO_BOX")){        
  		$(this).removeClass("COMBO_BOX");
  		$(this).addClass("_COMBO_BOX");
      }
  });
  $("select").change(function(){ parent.eLog("Combobox change handler", $(this).attr("id")+" : "+$(this).val()); });
}

$.fn.SlimCheckbox = function(){
$(this).each(function(){
	if(!$(this).hasClass("_CHECKBOX")){
		$(this).each(function(){ 
			if($(this).children("input").length < 1){
    			$(this).html("<input id='"+"INPUT_"+$(this).prop("id")+"' name='"+"INPUT_"+$(this).prop("id")+"' type='checkbox' /><label for='"+"INPUT_"+$(this).prop("id")+"'>"+$(this).prop("title")+"</label>");    			
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
    			$(this).html("<input id='"+"INPUT_"+$(this).prop("id")+"' name='"+"INPUT_"+$(this).attr("name")+"' value='"+$(this).attr("value")+"' type='radio' /><label for='"+"INPUT_"+$(this).prop("id")+"'>"+$(this).prop("title")+"</label>");
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
    	if($(this).children("input").length == 0){
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

function SlimAlert(m,fn){
    if(!m){ m = "- Message not defined!"; } 
	var BKS = "<div class='BLOCK_SCREEN'><div class='MSG_WINDOW_CONTAINER'><div class='MSG_WINDOW'></div></div></div>";
	var BT_OPTION1 = "<br /><input type='button' id='MSG_CONFIRM_BT' class='_INPUT_BUTTON' value='" + LANG_MAIN_CLOSESESSIONMSGBTY + "' />"; 
	var BT_OPTION2 = "<br /><input type='button' id='MSG_CONFIRM_BT' class='_INPUT_BUTTON' value='" + LANG_MAIN_CLOSESESSIONMSGBTY + "' /><input type='button' id='MSG_CANCEL_BT' class='_INPUT_BUTTON' value='" + LANG_MAIN_CLOSESESSIONMSGBTN + "' />";
	
	if($(".BLOCK_SCREEN").length == 0){ $('body').append(BKS); }				
	$(".MSG_WINDOW").html("<p><label>"+m+"</label></p>");
	
	parent.eLog("Alert",m);
	
	if(!fn){		
		$(".MSG_WINDOW").append(BT_OPTION1);
		$("#MSG_CONFIRM_BT").click(function(){
			$(this).attr("disabled", "disabled");
			$(".BLOCK_SCREEN").hide("fade","fast",function(){ $(this).closest(".BLOCK_SCREEN").remove(); }); 
			$(".MSG_WINDOW").hide("fade","fast",function(){ $(this).closest(".MSG_WINDOW").remove(); });			
		}); 
	}else{ 
		$(".MSG_WINDOW").append(BT_OPTION2);
		$("#MSG_CANCEL_BT").click(function(){
			$(".BLOCK_SCREEN").hide("fade","fast",function(){ $(this).closest(".BLOCK_SCREEN",this).remove(); }); 
			$(".MSG_WINDOW").hide("fade","fast",function(){ $(this).closest(".MSG_WINDOW",this).remove(); });			
		});
		$("#MSG_CONFIRM_BT").click(function(){ 
			$(this).attr("disabled", "disabled");
			$(".BLOCK_SCREEN").hide("fade","fast",function(){ $(this).closest(".BLOCK_SCREEN",this).remove(); }); 
			$(".MSG_WINDOW").hide("fade","fast",function(){ $(this).closest(".MSG_WINDOW",this).remove(); });			
			if(fn){ fn(); }
		});	
	}
	
	$("#MSG_CONFIRM_BT, #MSG_CANCEL_BT").click(function(e){		
		parent.eLog("Alert Callback",$(this).attr("id")+" : "+$(this).val());		
	});
	window.scrollTo(0,0);
		
	$(".BLOCK_SCREEN").height($(document).height());
	$(".BLOCK_SCREEN").show("fade","fast");
	$(".MSG_WINDOW").show("fade","fast",function(){ $("#MSG_CONFIRM_BT").focus(); });	
}

function SlimLockScr(o){
	if(o){	    
	   var BKS = "<div class='BLOCK_SCREEN'></div><div class='MSG_WINDOW'></div>"; 
	   if($(".BLOCK_SCREEN").length == 0){ 
	   		$('body').append(BKS);
			$(".BLOCK_SCREEN").height($(document).height());
	   		$(".BLOCK_SCREEN").show("fade","fast");   
	   }	   
	}else{
	   $(".BLOCK_SCREEN").hide("fade","fast",function(){ $(".BLOCK_SCREEN").remove(); });
	}
	   
}

/************************* OTHER FUNCTIONS *************************/

function ReqFields(){	
	$("form").submit(function(e){ 
		var btn = $("form").find("input[type=submit]:focus");
    	$("> .REQUIRED, > ._INPUT_TEXT .REQUIRED, > ._TEXT_AREA .REQUIRED, > ._INPUT_TEXT,> table .REQUIRED", btn.closest(".CONTENT")).each(function(){
    		if($(this).is("input") || $(this).is("textarea") || $(this).is("select")){     			
        		if(((($(this).is("input") || $(this).is("textarea")) && !$(this).val()) || ($(this).is("select") && !$("option:selected", this).text()))&&($(this).is(':visible'))){
        		    e.preventDefault(); 
        			if($(this).parent().is("div") && ($(this).parent().hasClass("_INPUT_TEXT") || $(this).parent().hasClass("_TEXT_AREA") || $(this).parent().hasClass("_COMBO_BOX"))){
        				$(this).parent().addClass("MISSED");
        			}else{
        				$(this).addClass("MISSED");
        			}
        			parent.SlimAlert("Debe llenar los campos obligatorios para poder continuar.");
        		}
				
				$(this).change(function(){ 
        			if($(this).hasClass("MISSED")){ 
        				$(this).removeClass("MISSED");
        			}
        			if($(this).parent().hasClass("MISSED")){
        				$(this).parent().removeClass("MISSED");
        			}
        		});		
    		 }    				
		});
	});
	
	$("form").bind('reset', function() {		
  		$("> .REQUIRED, > ._INPUT_TEXT .REQUIRED, > ._INPUT_TEXT, > table .REQUIRED", this).removeClass("MISSED");
    });
}

function DP_endDate(min,max){
   	max.datepicker("destroy");
	max.datepicker().datepicker('option', {  		  
   		  minDate: min.val(), 
        		  dateFormat: 'dd-mm-yy'	  
  	});
	max.datepicker("refresh");
}

function toggleElement(id,c){
	switch(c){
	  case true:
	  	  $("#"+id).hide();
	  	  break;
	  case false:
	  	  $("#"+id).show();
	      break;
	}
}

$(window).resize(function(){ $(".MAIN_DIV").css("height", window.innerHeight-$("#MAIN_MENU").outerHeight()); });