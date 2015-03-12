<?php
include("../../config/config.php"); require("../../config/language/".LANG.".php");

ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);

$ldap_server = AD_SERVER_ADDRESS;
$auth_user = AUTH_USER;
$auth_pass = AUTH_PASS;
$base_dn = BASE_DN;
$filter = "(&(objectClass=user)(objectCategory=person)(cn=*))";

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
?>

<script>
function Alert(m){ parent.SlimAlert(m); }
function Confirm(m,f){
  parent.SlimAlert(m,false,false, function a(r) {
          if (r) {            
  			if(f){ f(); }
          }
  });
}

$(document).ready(function(){
	$(".USR_OPT1").click(function(){ Alert("UID : "+$(this).attr("uid")); });
	$(".USR_OPT3").click(function(){ Confirm("Esta seguro que desea bloquear el usuario "+$(this).attr("name")+"?"); }); 
});
</script>
<div class="CONTENT">
<div class="BODY_CONTAINER">
<div class="FRAME">
<div class="FRAME" title="<?php print LANG_ADMIN_USERS_MANAGE; ?>">
<div class="FRAME" title="<?php print LANG_ADMIN_USERS_LOCAL; ?>">
<table class="USR_DISPLAY_TABLE"><tr><td width="15px"></td><td><b><?php print LANG_ADMIN_USERS_NAME; ?></b></td><td></td></tr>
<?php
for ($i=0; $i<3; $i++) {
   if($info[$i]["displayname"][0]){   
     echo "<tr class='USR_LIST_ITEM'><td class='TDFIRST' ><a class='USR_OPT1' uid='".md5($info[$i]["samaccountname"][0])."' href='#' title='".LANG_ADMIN_USERS_UID."' ><img class='USR_OPT_ICON' src='../content/themes/".THEME."/icons/usr.png' height='15px' /></a></td>
	 <td class='USR_LIST_ITEM'><a uid='".md5($info[$i]["samaccountname"][0])."' >". $info[$i]["displayname"][0]."</a></td><td class='USR_LIST_ITEM TDLAST' > 
	 <a class='USR_OPT2 USR_OPT_ICON' uid='".md5($info[$i]["samaccountname"][0])."' href='#' title='".LANG_ADMIN_USERS_KEY."' ><img src='../content/themes/".THEME."/icons/key.png' height='15px' /></a>
	 <a class='USR_OPT3 USR_OPT_ICON' name='".$info[$i]["displayname"][0]."' href='#' title='".LANG_ADMIN_USERS_BLOCK."' ><img src='../content/themes/".THEME."/icons/block.png' height='15px' /></a>
	 <a class='USR_OPT4 USR_OPT_ICON' href='mailto:".$info[$i]["mail"][0]."' title='".LANG_ADMIN_USERS_MAIL."' ><img src='../content/themes/".THEME."/icons/email.png' height='15px' /></a></td></tr>";    
   }      
}
?>
</table>
</div>
<div class="FRAME" title="<?php print LANG_ADMIN_USERS_LDAP; ?>">
<table class="USR_DISPLAY_TABLE"><tr><td width="15px"></td><td><b><?php print LANG_ADMIN_USERS_NAME; ?></b></td><td></td></tr>
<?php
for ($i=0; $i<$info["count"]; $i++) {
   if($info[$i]["displayname"][0]){   
     echo "<tr class='USR_LIST_ITEM'><td class='TDFIRST' ><a class='USR_OPT1' uid='".md5($info[$i]["samaccountname"][0])."' href='#' title='".LANG_ADMIN_USERS_UID."' ><img class='USR_OPT_ICON' src='../content/themes/".THEME."/icons/usr.png' height='15px' /></a></td>
	 <td class='USR_LIST_ITEM'><a uid='".md5($info[$i]["samaccountname"][0])."' >". $info[$i]["displayname"][0]."</a></td><td class='USR_LIST_ITEM TDLAST' > 
	 <a class='USR_OPT2 USR_OPT_ICON' uid='".md5($info[$i]["samaccountname"][0])."' href='#' title='".LANG_ADMIN_USERS_KEY."' ><img src='../content/themes/".THEME."/icons/key.png' height='15px' /></a>
	 <a class='USR_OPT3 USR_OPT_ICON' name='".$info[$i]["displayname"][0]."' href='#' title='".LANG_ADMIN_USERS_BLOCK."' ><img src='../content/themes/".THEME."/icons/block.png' height='15px' /></a>
	 <a class='USR_OPT4 USR_OPT_ICON' href='mailto:".$info[$i]["mail"][0]."' title='".LANG_ADMIN_USERS_MAIL."' ><img src='../content/themes/".THEME."/icons/email.png' height='15px' /></a></td></tr>";    
   }      
}
?>
</table>
</div>
</div>
</div>
</div>
</div>
