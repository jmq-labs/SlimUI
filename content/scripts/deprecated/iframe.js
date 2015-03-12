
$(function () {        
    $(".FRAME").SlimFrame();
	$(".CHECKBOX").SlimCheckbox();
    $(".INPUT_BUTTON").SlimButton();    
    $(".DIV_CONTENT_SCROLL").SlimScrollbar();
	
	/*** Alerts ***/
	
	switch(code){
      case "e0Auth":
        AlertMsg(LANG_LOGIN_ERRCODEAUTH0);
        break;
	  case "e1Auth":
        AlertMsg(LANG_LOGIN_ERRCODEAUTH1);
        break;
      case "e0Conn":
        AlertMsg(LANG_LOGIN_ERRCODECONN0);
        break;
      default:
    }
});
     
function AlertMsg(m) {
    parent.SlimAlert(m);
}

function ConfirmMsg(m, u, p) {
    parent.SlimAlert(m, function a(r) {
        if (r) {
            parent.go(parent.CurrentFrame, u + '?var=' + r + p);
        }
    });
}
