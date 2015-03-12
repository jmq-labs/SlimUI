var name_container = "<div>Welcome, <label id='USER_NAME' ></label><input type='button' class='_INPUT_BUTTON' value="+LANG_MAIN_CLOSESESSION+" id='SESSION_OFF' /></div>";

$(document).ajaxComplete(function(){ 
	$(".FRAME").SlimFrame();
    $(".CHECKBOX").SlimCheckbox();
    $(".INPUT_BUTTON").SlimButton();    
    $(".DIV_CONTENT_SCROLL").SlimScrollbar();
});

$(function(){        	
    
	$("#USER_SESSION_DATA").html(name_container);
    $("#USER_NAME").html("Admin");
	$(".USER_PROFILE").show("fade",150);
		
	$("#MAIN_PANE").load("content/start.php");	
	
	$(".MENU-WIDGET").delegate(".CONTENT_TITLE","click",function(e){ $(this).parent().children("input").toggle("blind"); });
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
	
	$("#WM_LOGO").click(function(){ $("#MAIN_PANE").load("content/start.php"); });
	$("#BT_F1_1").click(function(){ $("#MAIN_PANE").load("content/integration.php"); });
	$("#BT_F1_2").click(function(){ $("#MAIN_PANE").load("content/database.php"); });
	$("#BT_F1_3").click(function(){ $("#MAIN_PANE").load("content/security.php"); });
	$("#BT_F2_1").click(function(){ $("#MAIN_PANE").load("content/theme.php"); });
	$("#BT_F2_2").click(function(){ $("#MAIN_PANE").load("content/csseditor.php"); });
	$("#BT_F2_3").click(function(){ $("#MAIN_PANE").load("content/appimport.php"); });
	$("#BT_F3_1").click(function(){ $("#MAIN_PANE").load("content/plugins.php"); });
	$("#BT_F3_2").click(function(){ $("#MAIN_PANE").load("content/plugimport.php"); });
	$("#BT_F4_1").click(function(){ $("#MAIN_PANE").load("content/translator.php"); });
	$("#BT_F4_2").click(function(){ $("#MAIN_PANE").load("content/themeexport.php"); });
	$("#BT_F5_1").click(function(){ $("#MAIN_PANE").load("content/eventslog.php"); });
	$("#BT_F6_1").click(function(){ $("#MAIN_PANE").load("content/usernew.php"); });
	$("#BT_F6_2").click(function(){ $("#MAIN_PANE").load("content/useredit.php"); });
	$("#BT_F6_3").click(function(){ $("#MAIN_PANE").load("content/privileges.php"); });
	$("#BT_F7_1").click(function(){ $("#MAIN_PANE").load("content/cfgimport.php"); });
	$("#BT_F7_2").click(function(){ $("#MAIN_PANE").load("content/cfgexport.php"); });
	$("#BT_F8_1").click(function(){ $("#MAIN_PANE").load("content/appnew.php"); });
	$("#BT_F8_2").click(function(){ $("#MAIN_PANE").load("content/appmanage.php"); });
	$("#BT_F8_3").click(function(){ $("#MAIN_PANE").load("content/appie.php"); });
	
});

