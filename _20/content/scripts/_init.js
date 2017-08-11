var initial_bkg;

$(document).ready(function(){
	initial_bkg = $('#main-content').css('background-color');
	$('#main-content').css('background-color','rgb(229, 229, 229)');
	newDOM('login.html');
});

$(document).ajaxStart(function(){
	$('#body-progress').show('fade');
});

$(document).ajaxSuccess(function(){
	 $.when($('#body-progress').show('fade')).then(function(){ $('#body-progress').hide('fade') });
});
 
function init(){	
	$('iframe:visible').hide('fade',100,function(){ $(this).remove();
		$('header').load('config/system/header.html',function(){ 
			$('#nav-bar').load('config/system/navbar.html',function(){
				$('#main-content').animate({'background-color': initial_bkg }, 150,function(){
					$.getScript( "content/themes/material/material.min.js",function(){ 
						componentHandler.upgradeAllRegistered();						
						$('#session-about').click(function() {
							  alert("Slim-UI 2.0");
						});	
					});
				});
			});
		});	
	});	
 }

function newDOM(url){
	var id = $('iframe').length;
	var iFrame = $("<iframe/>",{
		id:		"Snippet-" + id,
        src:	'config/system/master.php?url='+url
	});
	$('#snippet-container').append(iFrame);
}