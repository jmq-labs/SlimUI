<script type="text/javascript" src="../../content/apps/_template/src.js"></script>
<div class="CONTENT">
  <div class="BODY_CONTAINER">
    <div class="FRAME">
    	<form id="F1">    	 
		<div class="FRAME" title="Sample app page">
		<hr />    		
			<p><div id="USER_INFO"></div></p>
			 <input type="text" />			 		 
			 <p>
			 <textarea></textarea>
			 </p>
			 <input type="button" onclick="parent.SlimAlert('Hi!')" value="Click me!" />
			 <br />
		<hr />
		<h2>index.php</h2>
		<xmp>
	<script type="text/javascript" src="../../content/apps/_template/src.js"></script>
	
	<div class="CONTENT">
          <div class="BODY_CONTAINER">
            <div class="FRAME">
            	<form id="F1">    	 
        		<div class="FRAME" title="Sample app page">
        		<hr />
        			<p><div id="USER_INFO"></div></p>
        			 <input type="text" />			 		 
        			 <p>
        			 <textarea></textarea>
        			 </p>
        			 <input type="button" onclick="parent.SlimAlert('Hi!')" value="Click me!" />
        		</div>   	
            	</form>   		 	
             </div>  
           </div>    
        </div>
		</xmp>
		<h2>src.js</h2>
		<xmp>
        var uid 	= $(userInfo.getUserInfo())[0]['userid'];
        var uname  	= $(userInfo.getUserInfo())[0]['user_displayname'];
        var email	= $(userInfo.getUserInfo())[0]['user_email'];

        $(function(){
        	 var info = "<p><b>User id</b>: " + uid + "</p>" +
        	 	 	  	"<p><b>User name</b>: " + uname + "</p>" +
        				"<p><b>E-mail</b>: " + email + "</p>";
        	 $("#USER_INFO").html(info);
        });
		</xmp>
		</div>   	
    	</form>
     </div>  
   </div>    
</div>
