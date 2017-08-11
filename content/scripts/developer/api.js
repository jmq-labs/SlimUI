<!------------------------------------------------------------------------------->
var userInfo = (function(){    
    var json;
      $.ajax({
        type: "GET",
        url: "../../config/api.php",
        dataType: "json",
  	  	data: { userinfo: "true", uqid: parent.UQID },
  	  	async: false,
        success : function(data) {
                  json = data;
               }
    });
	return {getUserInfo : function(){	  
      if (json){ return json }else{ return false };        
    }};
})();
<!------------------------------------------------------------------------------->
var dmUsers = (function(){    
    var json;
    $.ajax({
        type: "GET",
        url: "../../config/api.php",
        dataType: "json",
  	  	data: { dmusers: "true", uqid: parent.UQID },
  	  	async: true,
        success : function(data) {
                  json = data;
               }
    });
	return {getDmUsers : function(){	  
      if (json) return json;        
    }};
})();
<!------------------------------------------------------------------------------->
var userTasks = (function(){  
    var json; var respond;
	function sync(o){
  		if(!o){ o = false; }
		$.ajax({	  
            type: "POST",				
            url: "../../config/api.php",
            dataType: "json",
      		data: { usertasks: "true", uqid: parent.UQID },
      	  	async: o,
            success : function(data) {
                      json = data;
            }
      });
	}
	function update(id,col,val){  		
		$.ajax({	  
            type: "POST",				
            url: "../../config/api.php",
            dataType: "json",
      		data: { updateusertask: "true", id: id, col: col, val: val, uqid: parent.UQID },
      	  	async: true,
            success : function(data) {
                      respond = data;
            }
      });
	}
	return{ 
		getUserTasks : function(o){      
	  		sync(o); 
	  		if (json) return json;        
    	},
		updateUserTask : function(o){  		
	  		<!-- update(x,y,z); -->
	  		if (respond) parent.SlimAlert(respond);        
      	}
	};	
})();
<!------------------------------------------------------------------------------->
function getObject(obj, key, val){
    var newObj = false; 
    $.each(obj, function(){
        var testObject = this; 
        $.each(testObject, function(k,v){            
            if(val == v && k == key){
                newObj = testObject;
            }
        });
    });
    return newObj;
}