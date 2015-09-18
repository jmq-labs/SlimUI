var uid 	= $(userInfo.getUserInfo())[0]['userid'];
var uname  	= $(userInfo.getUserInfo())[0]['user_displayname'];
var email	= $(userInfo.getUserInfo())[0]['user_email'];

$(function(){
	 var info = "<p><b>User id</b>: " + uid + "</p>" +
	 	 	  	"<p><b>User name</b>: " + uname + "</p>" +
				"<p><b>E-mail</b>: " + email + "</p>";
	 $("#USER_INFO").html(info);
});