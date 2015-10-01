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
$userpass = @$_POST['password'];
$keepsession = @$_POST['keepsession'];
$redirectUrlFail = $_POST['redirectFail'];
$redirectUrlPass = $_POST['redirectPass'];

if(MAINTENANCE_MODE == "true"){
  	if($username != DEV_ACCOUNT){
		header('Location: '.$redirectUrlFail."&code=e2Auth", true, 302); exit;
	}
}

if(LDAPAUTH == "true"){
	$ldapdn = $username . "@" . LDAP_DN;
	$domainserver = AD_SERVER_ADDRESS;
    if(!empty($username) && !empty($userpass)){
    	if($userpass=="" || $userpass==NULL){ $userpass="NA"; }
    
    	$ldapconn = ldap_connect($domainserver)or die("Could not connect to LDAP server.");
    	ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
    	ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
    
    	if ($ldapconn) {
      		$ldapbind = ldap_bind($ldapconn, $ldapdn, $userpass);
    		if ($ldapbind) {
    			if($keepsession){
    				$_SESSION['keepsession'] = true;				
    			}			
    			$attributes = array("displayname","mail","department","title","samaccountname");
    			$filter = "(&(objectCategory=person)(sAMAccountName=$username))";
    			$dc = explode('.', LDAP_DN); $dn = "dc=".$dc[0].",dc=".$dc[1];
    			$result = ldap_search($ldapconn, $dn, $filter,$attributes);
    			$entries = ldap_get_entries($ldapconn, $result);
    			
    			$_SESSION['uid'] 					   = $entries[0]['samaccountname'][0];
				$_SESSION['username'] 				   = $entries[0]['samaccountname'][0];
				$_SESSION['ldappass'] 				   = $userpass;
    			$_SESSION['user_displayname'] 		   = $entries[0]['displayname'][0];
    			$_SESSION['user_department'] 		   = $entries[0]['department'][0];
    			$_SESSION['user_title'] 			   = $entries[0]['title'][0];
				$_SESSION['domain'] 			   	   = LDAP_DN;				
				$_SESSION['ldap_server_address']	   = AD_SERVER_ADDRESS;
    			if($entries[0]['mail'][0]){ $_SESSION['user_email'] = $entries[0]['mail'][0]; }else{ $_SESSION['user_email'] = "null"; }	
    			
				ldap_close($ldapconn);    			
				$_SESSION['token'] = $md5 = md5(TOKENSTR + $_SESSION['uid']);
    			header('Location: '.$redirectUrlPass, true, 302);
    						
      		}else{ 	header('Location: '.$redirectUrlFail."&code=e0Auth", true, 302); }
    	}else{ header('Location: '.$redirectUrlFail."&code=e0Conn", true, 302); }
    }else{ header('Location: '.$redirectUrlFail."&code=e1Auth", true, 302); }
  }else{
    if(!empty($username) && !empty($userpass)){
      if($userpass=="" || $userpass==NULL){ $userpass="NA"; }	
  	  $DBSERVER = DBSERVER;
      $DBNAME = DBNAME;
	  $DBUSER = DBUSER;
      $DBPASS = DBPASS;
	  $DBUSRT = DB_USERS_TABLE;
	  $DBUSRN = DB_USERS_FIELD_USERNAME;
	  $DBUSRP = DB_USERS_FIELD_PASSWORD;
      $MD5PW = md5($userpass);    
	  
  	  $login = "SELECT * FROM $DBUSRT WHERE $DBUSRN = '".$_POST['username']."' AND $DBUSRP =  '$MD5PW'";
	  
      if(ODBC_DBNAME){
	    $conn_odbc = odbc_connect(ODBC_DBNAME, $DBUSER, $DBPASS); 
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
  		$_SESSION['uid'] 			   = @$session[DB_USERS_FIELD_UID];
		$_SESSION['username']		   = @$session[$DBUSRN];
		$_SESSION['ldappass'] 		   = $userpass;
    	$_SESSION['user_displayname']  = utf8_encode(@$session[DB_USERS_FIELD_DISPLAY_NAME]);
   		$_SESSION['user_department']   = utf8_encode(@$session[DB_USERS_FIELD_DEPT]);
    	$_SESSION['user_title']		   = @$session[DB_USERS_FIELD_TITLE];
  		$_SESSION['user_email'] 	   = @$session[DB_USERS_FIELD_EMAIL];
  		$_SESSION['site_identity'] 	   = SITE_IDENTITY;		
    	$_SESSION['token'] = $md5 = md5(TOKENSTR + $_SESSION['uid']);
    	header('Location: '.$redirectUrlPass, true, 302);
  	}else{ header('Location: '.$redirectUrlFail."&code=e0Auth", true, 302); exit; }	
    }else{ header('Location: '.$redirectUrlFail."&code=e1Auth", true, 302); exit; }
}
?>