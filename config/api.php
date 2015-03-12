<?php
session_start();
require_once('conn.php');
header('Content-type: application/json; charset=utf-8');

if(@$_SESSION['uid']){
  /*************************************************************************************************************/
  if(isset($_GET['cookiedata'])){
  	$data = array();	
	for($i = 0; $i < count($cookie_data); $i++){
		$data[$i] = $cookie_data[$i];
	}
		
	$out = array_values($data);
	echo json_encode($out);
  }
  /*************************************************************************************************************/
  if(isset($_GET['userinfo'])){
  	$data['userinfo'] = array();
	$data['userinfo']['userid'] 		  = @$_SESSION['uid'];	
	$data['userinfo']['user_displayname'] = @$_SESSION['user_displayname'];
	$data['userinfo']['user_department']  = @$_SESSION['user_department'];
	$data['userinfo']['user_email']		  = @$_SESSION['user_email'];
	$data['userinfo']['user_title']		  = @$_SESSION['user_title'];
	
	$out = array_values($data);
	echo json_encode($out);
  }
  /*************************************************************************************************************/    
  if(isset($_GET['dmusers'])){
    ldap_set_option(@$ds, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option(@$ds, LDAP_OPT_REFERRALS, 0);
    
    $ldap_server = AD_SERVER_ADDRESS;
    $auth_user = AUTH_USER;
    $auth_pass = AUTH_PASS;
    $base_dn = BASE_DN;
    $filter = "(&(givenName=".@$_GET['q']."*)(objectClass=user)(objectCategory=person)(cn=*))";
    
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
         array_push($array, array('value' => @$info[$i]["displayname"][0], 'mail' => @$info[$i]["mail"][0], 'uid' => @$info[$i]["samaccountname"][0], 'department' => @$info[$i]["department"][0]));		     
       }      
    }
    
    $out = array_values($array);
    echo json_encode($out);
  }
  /*************************************************************************************************************/  
  if(isset($_POST['usertasks'])){
  	$con=odbc_connect('planner','sa','22197926');
	$q = "SELECT row_number() over (ORDER BY (SELECT 0)) as item, * FROM ( SELECT tickets.id, fecha, nombre, departamento, asunto, descripcion, correo, prioridad, estado, uid, project_id, evento, allday, (select tickets_meta_data.value from tickets_meta_data join meta_names on tickets_meta_data.meta_id = meta_names.id where tickets_meta_data.ticket_id = tickets.id and meta_id = 8) as fecha_inicio, (select tickets_meta_data.value from tickets_meta_data join meta_names on tickets_meta_data.meta_id = meta_names.id where tickets_meta_data.ticket_id = tickets.id and meta_id = 9) as fecha_vence FROM TICKETS left join project_meta_data on tickets.id = project_meta_data.ticket_id ) as tasks WHERE ( uid = '".$_SESSION['uid']."' OR correo LIKE '%".$_SESSION['user_email']."%')";
  	$e = odbc_exec($con, $q);
	$array = array();    	
	while($task = odbc_fetch_array($e)){		
		if($task['uid'] != $_SESSION['uid'] && !$task['evento']){ $eventColor = "#888888"; }else{ $eventColor = "#3A87AD"; }
		if($task['evento']){ $eventColor = "#4F9E48"; }		
		if($task['allday'] == 0){ 
			$allDay = false; 
			$endDate = date("Y-m-d H:i:s", strtotime($task['fecha_vence']));			
		}else{ 
			$allDay = true;
			$endDate = date("Y-m-d H:i:s", strtotime("+1 day", strtotime($task['fecha_vence']))); 
		}		
		array_push($array, 
			array(
			   'item' 	   	  	  => $task['item'],
			   'id' 	   	  	  => $task['id'],
			   'taskdate' 	   	  => $task['fecha'],
			   'taskname' 	   	  => $task['nombre'],
			   'taskdepartment'   => $task['departamento'],						   						   
			   'title'			  => $task['asunto'],
			   'description'  	  => $task['descripcion'],
			   'taskinvites' 	  => $task['correo'],
			   'taskpriority' 	  => $task['prioridad'],
			   'taskstat' 		  => $task['estado'],
			   'taskowner' 		  => $task['uid'],
			   'projectid' 		  => $task['project_id'],
			   'start' 		  	  => date("Y-m-d H:i:s", strtotime($task['fecha_inicio'])),
			   'end' 		  	  => $endDate,
			   'rawstart'		  => $task['fecha_inicio'],
			   'rawend'		  	  => $task['fecha_vence'],
			   'startdate'		  => date("Y-m-d", strtotime($task['fecha_inicio'])),
			   'enddate'		  => date("Y-m-d", strtotime($task['fecha_vence'])),
			   'starttime'		  => date("H:i a", strtotime($task['fecha_inicio'])),
			   'endtime'		  => date("H:i a", strtotime($task['fecha_vence'])),
			   'isevent'		  => $task['evento'],
			   'allDay'		  	  => $allDay,
			   'color'			  => $eventColor,			   	   		     
			)
		);
	}
	
	$out = array_values($array);
	echo json_encode($out);
  }
  /*************************************************************************************************************/
  if(isset($_POST['updateusertask'])){
  	$con=odbc_connect('planner','sa','22197926');
	switch($_POST['col']){
		case "taskname":
			 $q = "UPDATE tasks SET nombre = '".$_POST['val']."' WHERE id = ".$_POST['id']." AND uid = '".$_SESSION['uid']."'";
			 break;
		case "taskdepartment":
			 $q = "UPDATE tasks SET departamento = '".$_POST['val']."' WHERE id = ".$_POST['id']." AND uid = '".$_SESSION['uid']."'";
			 break;
		case "title":
			 $q = "UPDATE tasks SET asunto = '".$_POST['val']."' WHERE id = ".$_POST['id']." AND uid = '".$_SESSION['uid']."'";
			 break;
		case "taskdepartment":
			 $q = "UPDATE tasks SET departamento = '".$_POST['val']."' WHERE id = ".$_POST['id']." AND uid = '".$_SESSION['uid']."'";
			 break;
		case "description":
			 $q = "UPDATE tasks SET descripcion = '".$_POST['val']."' WHERE id = ".$_POST['id']." AND uid = '".$_SESSION['uid']."'";
			 break;
		case "taskinvites":
			 $q = "UPDATE tasks SET correo = '".$_POST['val']."' WHERE id = ".$_POST['id']." AND uid = '".$_SESSION['uid']."'";
			 break;
		case "taskpriority":
			 $q = "UPDATE tasks SET prioridad = ".$_POST['val']." WHERE id = ".$_POST['id']." AND uid = '".$_SESSION['uid']."'";
			 break;
		case "taskstat":
			 $q = "UPDATE tasks SET estado = '".$_POST['val']."' WHERE id = ".$_POST['id']." AND uid = '".$_SESSION['uid']."'";
			 break;
		case "start":
			 $q = "UPDATE tickets_meta_data SET value = '".$_POST['val']."' WHERE ticket_id = ".$_POST['id']." AND meta_id = 8";
			 break;
		case "end":
			 $q = "UPDATE tickets_meta_data SET value = '".$_POST['val']."' WHERE ticket_id = ".$_POST['id']." AND meta_id = 9";
			 break;
		case "isevent":
			 $q = "UPDATE tasks SET evento = '".$_POST['val']."' WHERE id = ".$_POST['id']." AND uid = '".$_SESSION['uid']."'";
			 break;
		case "allday":
			 $q = "UPDATE tasks SET allday = '".$_POST['val']."' WHERE id = ".$_POST['id']." AND uid = '".$_SESSION['uid']."'";
			 break;
	}
  	if( !odbc_exec($con, $q) ){ echo "Parece que algo salio mal! Error: ".mysql_error(); }
  }
}
?>