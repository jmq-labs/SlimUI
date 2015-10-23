<?php
define('tmp_file_name','tmpfile.zip');
define('tmp_dir','temp');
define('root_dir','../../../');

if(isset($_GET['step'])){
	$o = $_GET['step'];
	if($o == 1){ Step1(@$_GET['param']); }
	if($o == 2){ Step2(@$_GET['param']); }
	if($o == 3){ Step3(@$_GET['param']); }
	if($o == 4){ Step4(@$_GET['param']); }
	if($o == 5){ Step5(tmp_dir); }
	if($o == 6){ Step6(@$_GET['param']); }
}else{
	echo "link failure";
}

function Step1($a){
	set_time_limit(0); 
    $file = file_get_contents($a);
    file_put_contents(tmp_dir."/".tmp_file_name, $file);
}
function Step2($a){
	$zip = new ZipArchive;
    if ($zip->open(tmp_dir."/".tmp_file_name) === TRUE) {
        mkdir(tmp_dir."/".$a, 0700);
		$zip->extractTo(tmp_dir."/".$a."/");
        $zip->close();
    }
}
function Step3($a){
  $file = "../../../slim-ui.config";
  $bkup_file = "../restore/".$a.'.bak';
  copy($file, $bkup_file);
}
function Step4($a){
  $dir = tmp_dir."/".$a;  
  recurse_copy($dir,root_dir);
}
function Step5($a){
  $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($a),RecursiveIteratorIterator::CHILD_FIRST);
  foreach ($iterator as $path) {
    if ($path->isDir()) {
       rmdir($path->__toString());
    } else {
       unlink($path->__toString());
    }
  }
}
function Step6($a){	
	list($new_build, $old_build, $new_version) = split(';', $a);
	$new_config_file = root_dir."slim-ui.config";
	$old_config_file = "../restore/".$old_build.".bak";	
	
	if (file_exists($old_config_file)){
        $old_xml = simplexml_load_file($old_config_file);       
		if (file_exists($new_config_file)){
            $new_xml = simplexml_load_file($new_config_file);     
            foreach($new_xml->config as $new_child){
            	foreach($old_xml->config->children() as $t => $v){
        			$new_child->$t = $v;
				}
				$new_child->version = $new_version;
				$new_child->build = $new_build;
    		}
			foreach($new_xml->appsmenu_filters as $new_child){
            	foreach($old_xml->appsmenu_filters->children() as $t => $v){
        			$new_child->$t = $v;
				}
    		}
			foreach($new_xml->cookie as $new_child){
            	foreach($old_xml->cookie->children() as $t => $v){
        			$new_child->addChild('data', $v);
				}
    		}
			$update = fopen($new_config_file, "w");
			fwrite($update, $new_xml->asXML());
			fclose($update);
        }
    }
}

function recurse_copy($src,$dst) { 
    $dir = opendir($src); 
    @mkdir($dst); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                recurse_copy($src . '/' . $file,$dst . '/' . $file); 
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file); 
            } 
        } 
    } 
    closedir($dir); 
} 
?>