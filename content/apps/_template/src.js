var uid 	= $(userInfo.getUserInfo())[0]['user_name'];
var uname  	= $(userInfo.getUserInfo())[0]['user_displayname'];
var email	= $(userInfo.getUserInfo())[0]['user_email'];

$(function(){
	 var info = "<p><b>User name</b>: " + uid + "</p>" +
	 	 	  	"<p><b>Display name</b>: " + uname + "</p>" +
				"<p><b>E-mail</b>: " + email + "</p>";
	 $("#USER_INFO").html(info);
});