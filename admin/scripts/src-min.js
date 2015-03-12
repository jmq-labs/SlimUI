var name_container = "<div>"+LANG_MAIN_WELCOME+" <b><label id='USER_NAME' ></label></b><input type='button' class='_INPUT_BUTTON' value="+LANG_MAIN_CLOSESESSION+" id='SESSION_OFF' /></div>";

$(document).ajaxComplete(function(){ 
	$(".FRAME").SlimFrame();
    $(".CHECKBOX").SlimCheckbox();
    $(".INPUT_BUTTON").SlimButton();    
	$(".SEARCH_LIST").SlimMenu("SearchList");
	$(".INPUT_TEXT").SlimTextbox();
	$(".RADIO").SlimRadio();
	$(".COLOR_PICKER").SlimColorPicker();
});

$(function(){        	
    
	$("#USER_SESSION_DATA").html(name_container);
    $("#USER_NAME").html(AUTH_USERFIRSTNAME);
	$(".USER_PROFILE").show("fade",150);
	$("#SESSION_OFF").click(function(){ 
		SlimAlert(LANG_MAIN_CLOSESESSIONMSG, function a(){  	        
    	    window.location = "index.php?kill_session=true";
    	});		 
	});
		
	$("#MAIN_PANE").load("content/home.php");
	   
    switch(code){
       	case "e0Auth":
            SlimAlert(LANG_LOGIN_ERRCODEAUTH0);
            break;
    	case "e1Auth":
            SlimAlert(LANG_LOGIN_ERRCODEAUTH1);
            break;
        case "e0Conn":
            SlimAlert(LANG_LOGIN_ERRCODECONN0);
            break;
    	case "e0Token":
            SlimAlert(LANG_TOKEN_E0);
            break;
    	case "e1Token":
            SlimAlert(LANG_TOKEN_E1);
            break;			
        default:
    }	
	
	$(".MENU-WIDGET").delegate(".CONTENT_TITLE","click",function(e){ 
			if(!$(this).parent().children("input").hasClass("MENU-ITEM-SELECTED")){ $(this).parent().children("input").toggle("blind",200); }
	});
	$(".MENU-WIDGET ._INPUT_BUTTON").each(function(){ 
			$(this).click(function(){ 
					$(".MENU-ITEM-SELECTED").removeClass("MENU-ITEM-SELECTED");
					$(this).toggleClass("MENU-ITEM-SELECTED"); 
			}); 
	});
	
	$("#WM_LOGO").click(function(){ $("#MAIN_PANE").load("content/home.php"); $(".MENU-ITEM-SELECTED").removeClass("MENU-ITEM-SELECTED"); });
	$("#BT_F1_4").click(function(){ $("#MAIN_PANE").load("content/basic.php"); });
	$("#BT_F1_1").click(function(){ $("#MAIN_PANE").load("content/integration.php"); });
	$("#BT_F1_2").click(function(){ $("#MAIN_PANE").load("content/database.php"); });
	$("#BT_F1_3").click(function(){ $("#MAIN_PANE").load("content/security.php"); });
	$("#BT_F2_1").click(function(){ $("#MAIN_PANE").load("content/themes.php"); });
	$("#BT_F2_2").click(function(){ $("#MAIN_PANE").load("content/csseditor.php"); });
	$("#BT_F2_3").click(function(){ $("#MAIN_PANE").load("content/appimport.php"); });
	$("#BT_F3_1").click(function(){ $("#MAIN_PANE").load("content/plugins.php"); });
	$("#BT_F3_2").click(function(){ $("#MAIN_PANE").load("content/plugimport.php"); });
	$("#BT_F4_1").click(function(){ $("#MAIN_PANE").load("content/translator.php"); });
	$("#BT_F4_2").click(function(){ $("#MAIN_PANE").load("content/themeexport.php"); });
	$("#BT_F4_3").click(function(){ $("#MAIN_PANE").load("content/tickets.php"); });
	$("#BT_F5_1").click(function(){ $("#MAIN_PANE").load("content/eventslog.php"); });
	$("#BT_F6_1").click(function(){ $("#MAIN_PANE").load("content/users.php"); });
	$("#BT_F6_2").click(function(){ $("#MAIN_PANE").load("content/privileges.php"); });
	$("#BT_F7_1").click(function(){ $("#MAIN_PANE").load("content/cfgie.php"); });
	$("#BT_F7_2").click(function(){ $("#MAIN_PANE").load("content/updates.php"); });
	$("#BT_F8_1").click(function(){ $("#MAIN_PANE").load("content/appnew.php"); });
	$("#BT_F8_2").click(function(){ $("#MAIN_PANE").load("content/appmanage.php"); });
	$("#BT_F8_3").click(function(){ $("#MAIN_PANE").load("content/appie.php"); });	
		
});

