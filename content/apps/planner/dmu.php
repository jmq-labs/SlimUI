<?php
header('Content-type: application/json; charset=utf-8');
include("../../../config/config.php"); require("../../../config/language/".LANG.".php");

ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);

$ldap_server = AD_SERVER_ADDRESS;
$auth_user = AUTH_USER;
$auth_pass = AUTH_PASS;
$base_dn = BASE_DN;
$filter = "(&(givenName=".$_GET['q']."*)(objectClass=user)(objectCategory=person)(cn=*))";

if (!($connect=ldap_connect($ldap_server))) {
     die("Error al conectar al servidor ldap");
}

if (!($bind=ldap_bind($connect, $auth_user, $auth_pass))) {
     die("Error al autenticar en ldap");
}

if (!($search=ldap_search($connect, $base_dn, $filter))) {
     die("Error al buscar en servidor ldap");
}

$number_returned = ldap_count_entries($connect,$search);
ldap_sort($connect, $search, 'displayname');

$info = ldap_get_entries($connect, $search);

$array = array();
for ($i=0; $i<$info["count"]; $i++) {
   if($info[$i]["displayname"][0]){   
     array_push($array, array('value' => $info[$i]["displayname"][0], 'mail' => $info[$i]["mail"][0]));    
   }      
}

$out = array_values($array);
echo json_encode($out);

?>