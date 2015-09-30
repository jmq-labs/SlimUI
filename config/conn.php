<?php 
require('config.php');
require('language/'.LANG.'.php');

if(DBSERVER){ 
	$conn = mysql_connect(DBSERVER, DBUSER, DBPASS); 
	if(!$conn){ die( LANG_DB_CONNERR . mysql_error()); }
}
?>