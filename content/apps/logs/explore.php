<?php
session_start();
$count = 0;
$archivSize = 0;
$onlinecount = 0;
$directory = 'archive/';
$it = new RecursiveDirectoryIterator($directory);

echo "<table class='TABLE' ><tr class='TRTITLE'>";
if(@$_SESSION['_ISMOBILE'] && @$_SESSION['_ISMOBILE']!="true"){
	echo "<td><b>Tamaño</b></td><td><b>Archivos</b></td>";
}
echo "<td class='TD3'></td></tr>";
while($it->valid()) {    
	if (!$it->isDot()) {
    if ( @$count++ & 1 ) { $tr = ""; }else{ $tr = "TDODD";  }	
	echo "<tr class='ROW ".$tr."'>";		
		$new_str_nav = "Desconocido";
		$new_str_ip = "No disponible";		
		$lastFile ="";
		$lastdate = 0;
		$lastmodify = "No disponible";
		$totalSize = 0;
		$itemcount = 0;
		$location = "No disponible";
		$searchSname = "User session name";	
		$searchNav = "Login event | Navegador";
		$searchIp = "Client Ip address";		
		$file = new RecursiveDirectoryIterator($directory.($it->getSubPathname()));		
		$size = new RecursiveDirectoryIterator($directory.($it->getSubPathname()));
		?>		
		<script>		 	
        	logDates[<?php echo $count; ?>] = new Array(); 
        </script><?php		
		while($file->valid()) {			
			if (!$file->isDot()) { ?>		   			   	
         	   <script>		 	
         			logDates[<?php echo $count; ?>]['<?php echo substr(utf8_encode($file->getSubPathname()),0,8); ?>'] = "<?php print rawurlencode($file->key()); ?>"; 
         	   </script>	   			
			<?php }			
						
			if( $file->getMTime() > $lastdate){
				$lastmodify = $file->getMTime();
				$lastdate = $file->getMTime();
				$lastFile = $file->key();
			}	
			$file->next();
		}			
		if($lastmodify > strtotime("-5 minutes",time())){ 
				$bullet = "<font color='#25D41C' size='3'><b>|</b></font>";
				$status = " En linea"; $onlinecount++;                     
			}else{ 
				$bullet = "<font color='#D41E1E' size='3'><b>|</b></font>";
				$status = " Sin actividad"; 
		}		
        $lines = file($lastFile);
        foreach($lines as $line){
           if(strpos($line, $searchNav) !== false){
               $new_str_nav = array_pop(explode(":", $line));			  
           }
		   if(strpos($line, $searchIp) !== false){
               $new_str_ip = array_pop(explode("| ", $line));			   
           }		  
        }
		foreach ($size as $f) {
            $totalSize += $f->getSize();			
			$itemcount++;
        }
		$archivSize += $totalSize;		
        echo "<td class='TD1'>".$count."</td><td>".$bullet." ".utf8_encode($it->getSubPathname()) . "</td>";
       	if(@$_SESSION['_ISMOBILE'] && @$_SESSION['_ISMOBILE']!="true"){
			echo "<td class='TD1'>".round((($totalSize)/1024))." KB</td><td class='TD1'>".$itemcount."</td>";
       	}
		echo "<td class='TD3'><input id='BT".$count."' class='_INPUT_BUTTON LOGBT' value='Ver' type='button' logId='".$count."' ></td>"		
       		."<tr><td></td><td class='TDOPTIONS' colspan='4'><div id='ROW".$count."' class='DIVOPTIONS' >"
       		."<div logId='".$count."' class='datepicker' ></div>"		
			."<table class='LOGINFO' cellpadding='2px'><tr><td><b>Actividad:</b></td><td>".$status."</td></tr>"
			."<tr><td colspan='3'><hr /></td></tr>"			 
			."<tr><td><b>Navegador:</b></td><td>".$new_str_nav."</td></tr>"
			."<tr><td><b>Dirección Ip:</b></td><td>".$new_str_ip."</td></tr>"
			."<tr><td><b>Localidad:</b></td><td><div id='LOC".$count."' ip='".$new_str_ip."'></div></td></tr>"
			."<tr><td><b>Ultima sesión:</b></td><td>".date("d-m-Y g:i a",$lastmodify)."</td></tr></table>"			 
			."</div></td></tr>";		
    echo "</tr>";	
	}
    
	$it->next();	
}
echo "</table><hr /><p><label><b>Tamaño de la carpeta: </b>".number_format((($archivSize)/1024)/1024,2,'.','')." Mb</label>"
	 ."<label style='float:right'><b>Usuarios en linea:</b> ".$onlinecount."</label></p>";
?>