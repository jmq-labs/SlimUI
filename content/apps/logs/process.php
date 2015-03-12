<?php  
  $dirfilter = array('/', '\\', '<', '>', '?', ':', '|', '"');
  if(!isset($_POST["name"]) || $_POST["name"]==""){ $filename = "_UNKNOWN"; }else{ $filename =  ms_escape_string(str_replace($dirfilter, '', strtoupper(utf8_decode($_POST["name"])))); }
  if(!isset($_POST['type'])){ $type = ""; }else{ $type = $_POST['type']; }
  if(!isset($_POST['data'])){ $content = ""; }else{ $content = $_POST['data']; }
    
  $filedir = "archive/".$filename;
  $today = date("d-m-y");
  $document = $filedir."/".$today.".txt";  
  $data = date("g:i a")." | ".$type." | ".$content."\n";
  
if (!file_exists($filedir)) {
        mkdir("archive/" . $filename, 0777);        
        $file = fopen($document,"w");
        fwrite($file, $data);
        fclose($file);	        
        exit;	  
} else {      	  
      	$file = fopen($document,"a+");
      	fwrite($file, PHP_EOL.$data);
      	fclose($file);	        
        exit;  	  
}

function ms_escape_string($data) {
        if ( !isset($data) or empty($data) ) return '';
        if ( is_numeric($data) ) return $data;

        $non_displayables = array(
            '/%0[0-8bcef]/',            // url encoded 00-08, 11, 12, 14, 15
            '/%1[0-9a-f]/',             // url encoded 16-31
            '/[\x00-\x08]/',            // 00-08
            '/\x0b/',                   // 11
            '/\x0c/',                   // 12
            '/[\x0e-\x1f]/'             // 14-31
        );
        foreach ( $non_displayables as $regex )
            $data = preg_replace( $regex, '', $data );
        $data = str_replace("'", "''", $data );
        return $data;
}

?>