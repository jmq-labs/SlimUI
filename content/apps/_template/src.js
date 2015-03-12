
var id_usuario 	  	 = $(userInfo.getUserInfo())[0]['userid'];
var nombre_completo  = $(userInfo.getUserInfo())[0]['user_displayname']; 										 
var departamento	 = $(userInfo.getUserInfo())[0]['user_department'];
var correo			 = $(userInfo.getUserInfo())[0]['user_email'];
var cargo		 	 = $(userInfo.getUserInfo())[0]['user_title'];

$(function(){
	 var info = "<p><b>User id</b>: " + id_usuario + "</p>" +
	 	 	  	"<p><b>User name</b>: " + nombre_completo + "</p>" +
				"<p><b>Department</b>: " + departamento + "</p>" +
				"<p><b>E-mail</b>: " + correo + "</p>" +
				"<p><b>Title</b>: " + cargo + "</p>";
	 $("#USER_INFO").html(info);	
});