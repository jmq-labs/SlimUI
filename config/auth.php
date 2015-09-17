<?php
/*********************************************************
*
*	This is the authentication service connector for the
*	Microsoft Domain Server; if you need more information 
*	about ldap function, refer to the php manual.  
*
**********************************************************/

error_reporting(0);
session_start();
require_once('config.php');

$username = strtolower(@$_POST['username']);
$ldapdn = $username . "@" . LDAP_DN;
$ldapen = $username . "@" . LDAP_MAIL_DN;
$ldappass = @$_POST['password'];
$domainserver = AD_SERVER_ADDRESS;
$keepsession = @$_POST['keepsession'];
$redirectUrlFail = $_POST['redirectFail'];
$redirectUrlPass = $_POST['redirectPass'];

if(MAINTENANCE_MODE == "true"){
  	if($username != DEV_ACCOUNT){
		header('Location: '.$redirectUrlFail."&code=e2Auth", true, 302); exit;
	}
}

if(LDAPAUTH == "true"){
    if(!empty($username) && !empty($ldappass)){
    	if($ldappass=="" || $ldappass==NULL){ $ldappass="NA"; }
    
    	$ldapconn = ldap_connect($domainserver)or die("Could not connect to LDAP server.");
    	ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
    	ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
    
    	if ($ldapconn) {
    		$ldapbind = ldap_bind($ldapconn, $ldapdn, $ldappass);
    		if ($ldapbind) {
    			if($keepsession){
    				$_SESSION['keepsession'] = true;				
    			}			
    			$attributes = array("displayname","mail","department","title","samaccountname");
    			$filter = "(&(objectCategory=person)(sAMAccountName=$username))";
    			$dn = "dc=".DC_1.",dc=".DC_2;
    			$result = ldap_search($ldapconn, $dn, $filter,$attributes);
    			$entries = ldap_get_entries($ldapconn, $result);
    			
    			$_SESSION['uid'] = $entries[0]['samaccountname'][0];
				$_SESSION['ldappass'] = $ldappass;
    			$_SESSION['user_displayname'] = $entries[0]['displayname'][0];
    			$_SESSION['user_department'] = $entries[0]['department'][0];
    			$_SESSION['user_title'] = $entries[0]['title'][0];
    			if($entries[0]['mail'][0]){ $_SESSION['user_email'] = $entries[0]['mail'][0]; }else{ $_SESSION['user_email'] = "null"; }	
    			
    			$_SESSION['token'] = $md5 = md5(utf8_encode(TOKENSTR)+$_SESSION['uid']);
    			header('Location: '.$redirectUrlPass, true, 302);
    						
      		}else{ 	header('Location: '.$redirectUrlFail."&code=e0Auth", true, 302); }
    	}else{ header('Location: '.$redirectUrlFail."&code=e0Conn", true, 302); }
    }else{ header('Location: '.$redirectUrlFail."&code=e1Auth", true, 302); }
  }else{
    if(!empty($username) && !empty($ldappass)){
      if($ldappass=="" || $ldappass==NULL){ $ldappass="NA"; }	
  	  $DBSERVER = DBSERVER;
      $DBNAME = DBNAME;
	  $DBUSER = DBUSER;
      $DBPASS = DBPASS;
	  $DBUSRT = DB_USERS_TABLE;
	  $DBUSRN = DB_USERS_FIELD_USER;
	  $DBUSRP = DB_USERS_FIELD_PASS;
      $MD5PW = md5($ldappass);    
	  
  	  $login = "SELECT * FROM $DBUSRT WHERE $DBUSRN = '".$_POST['username']."' AND $DBUSRP =  '$MD5PW'";
	  
      if(ODBC_DBNAME){
	    $conn_odbc = odbc_connect($DBNAME, $DBUSER, $DBPASS); 
	  	if(!$conn_odbc){ header('Location: '.$redirectUrlFail."&code=e0Conn", true, 302); exit; }
		$exec = odbc_exec($conn_odbc, $login);
      	$session = odbc_fetch_array($exec);	
	  }else{
	    $conn_mysql = mysql_connect($DBSERVER, $DBUSER, $DBPASS);		
		if(!$conn_mysql){ header('Location: '.$redirectUrlFail."&code=e0Conn", true, 302); exit; }
		mysql_select_db($DBNAME, $conn_mysql);		
		$exec = mysql_query($login);
      	$session = mysql_fetch_array($exec);		
	  }
      if($session[$DBUSRN]){	 
  		if($keepsession){
    		$_SESSION['keepsession'] = true;				
    	}   
  		$_SESSION['uid'] = @$session[$DBUSRN];
		$_SESSION['ldappass'] = $ldappass;
    	$_SESSION['user_displayname'] = utf8_encode(@$session[DB_USERS_FIELD_DISPLAY_NAME]);
  		$_SESSION['user_department'] = utf8_encode(@$session['department']);
    	$_SESSION['user_title'] = @$session['title'];
  		$_SESSION['user_email'] = @$session['mail'];
  		$_SESSION['site_identity'] = SITE_IDENTITY;		
    	$_SESSION['token'] = $md5 = md5(utf8_encode(TOKENSTR)+$_SESSION['uid']);
    	header('Location: '.$redirectUrlPass, true, 302);
  	}else{ header('Location: '.$redirectUrlFail."&code=e0Auth", true, 302); exit; }	
    }else{ header('Location: '.$redirectUrlFail."&code=e1Auth", true, 302); exit; }
}
?>