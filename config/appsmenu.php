<?php session_start(); include('config.php'); ?>
<div id="MAIN_WIDGET_MENU" style="padding:25px;" >
<?php
if($_SESSION['uid']){
$directory = "../content/apps/";
$it = new RecursiveDirectoryIterator($directory);
  while($it->valid()){    
  	if(!$it->isDot()){
  	    $file = new RecursiveDirectoryIterator($directory.($it->getSubPathname()));		
  		while($file->valid()) {			
  			if (!$file->isDot()) { 
  			   if ($file->isFile()) {
          	   	  if(substr($file->getSubPathname(), -3) == "xml"){
      				  $appdir = $directory.$it->getSubPathname()."/";
  					  $xml = simplexml_load_file($appdir.$file->getSubPathname());  					  
  					  if($xml->app[0]->menu){ $menu = "content/apps/".$it->getSubPathname()."/".$xml->app[0]->menu; }else{ $menu = ""; }
					  if($xml->app[0]->hidden != true){					  	  						  
						  if(ALLOW_FILTERS == "true"){
    						  if(FILTER_TYPE == "include"){
    							  if(find($_SESSION[FILTER_BY], $display_filters["wb_".$xml->app[0]->appname])){
        							  echo "<div id='WB_".$xml->app[0]->appname."' appname='".$xml->app[0]->appname."' folder='".$appdir."' isasp='".$xml->app[0]->asp."' class='WIDGET_BUTTON' icon='".IMG_DIR.$xml->app[0]->icon."' title='".$xml->app[0]->title."' url='config/system/master.php?page=../".$appdir.$xml->app[0]->default."&asp=".$xml->app[0]->asp."' color='".$xml->app[0]->color."' safemode='".$xml->app[0]->safemode."' appmenu='".$menu."' onload_src='".$xml->app[0]->onload_src."' style='".$xml->app[0]->style."' ></div>";
        						  }
							  }
							  if(FILTER_TYPE == "exclude"){
    							  if(!find($_SESSION[FILTER_BY], $display_filters["wb_".$xml->app[0]->appname])){
        							  echo "<div id='WB_".$xml->app[0]->appname."' appname='".$xml->app[0]->appname."' folder='".$appdir."' isasp='".$xml->app[0]->asp."' class='WIDGET_BUTTON' icon='".IMG_DIR.$xml->app[0]->icon."' title='".$xml->app[0]->title."' url='config/system/master.php?page=../".$appdir.$xml->app[0]->default."&asp=".$xml->app[0]->asp."' color='".$xml->app[0]->color."' safemode='".$xml->app[0]->safemode."' appmenu='".$menu."' onload_src='".$xml->app[0]->onload_src."' style='".$xml->app[0]->style."' ></div>";
        						  }
							  }
						  }else{
						  	  echo "<div id='WB_".$xml->app[0]->appname."' appname='".$xml->app[0]->appname."' folder='".$appdir."' isasp='".$xml->app[0]->asp."' class='WIDGET_BUTTON' icon='".IMG_DIR.$xml->app[0]->icon."' title='".$xml->app[0]->title."' url='config/system/master.php?page=../".$appdir.$xml->app[0]->default."&asp=".$xml->app[0]->asp."' color='".$xml->app[0]->color."' safemode='".$xml->app[0]->safemode."' appmenu='".$menu."' onload_src='".$xml->app[0]->onload_src."' style='".$xml->app[0]->style."' ></div>";
						  }
					  }			 
  				  }				  
      		   }			   
  			}
  			$file->next();
  		}		
  	}
  	$it->next();	
  }
}

function find($find,$string){
$array = explode(',', $string);
  if (in_array($find,$array)){         
          return true;
  }else{
          return false;
  }
}
?>
</div>