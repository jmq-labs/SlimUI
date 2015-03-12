<?php
session_start();
require('../config/conn.php');
mysql_select_db(DBNAME, $conn);

$username = strtolower($_POST['username']);
$password = $_POST['password'];
$keepsession = $_POST['keepsession'];
$redirectUrlFail = $_POST['redirectFail'];
$redirectUrlPass = $_POST['redirectPass'];

if(!empty($username) && !empty($password)){	
	$svr_query = mysql_query("SELECT COUNT(*) FROM users WHERE username = '$username' AND password = MD5('$password')");	
	$auth_result = mysql_result($svr_query,0); 
	
	if ($auth_result){
		if($keepsession){ $_SESSION['_keepsession'] = true; }
		$query = mysql_query("SELECT username,firstname,lastname,email,createdate,role,active FROM users WHERE username = '$username'");	
		$result = mysql_fetch_array($query);
	
		$_SESSION['_username'] = $result["username"];
		$_SESSION['_firstname'] = $result["firstname"];
		$_SESSION['_lastname'] = $result["lastname"];			
		$_SESSION['_email']  = $result["email"];
		$_SESSION['_createdate']  = $result["createdate"];
		$_SESSION['_role']  = $result["role"];
		$_SESSION['_active']  = $result["active"];	
		$_SESSION['_token'] = md5(utf8_encode(TOKENSTR.date()));
		$_SESSION['site_identity']  = SITE_IDENTITY;
		
		header('Location: '.$redirectUrlPass, true, 302);					
  		
	}else{ header('Location: '.$redirectUrlFail."?code=e0Auth", true, 302); }
}else{ header('Location: '.$redirectUrlFail."?code=e1Auth", true, 302); }

mysql_close($conn);
?>