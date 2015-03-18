<?php
define('DATEFORMAT','d-m-YYYY'); 
session_start();
$con=odbc_connect('planner','sa','22197926');

$today = date('d-m-Y');
if(isset($_POST['get'])){            $get = $_POST['get']; }else{ $get = ""; }
if(isset($_POST['ticket_id'])){      $id = $_POST['ticket_id']; }else{ $id = ""; }
if(isset($_POST['status'])){         $stat = $_POST['status']; }else{ $stat = ""; }
if(isset($_POST['info'])){           $data = json_decode($_POST['info']); }else{ $data = ""; }
if(isset($_POST['priority'])){       $priority = json_decode($_POST['priority']); }else{ $priority = "1"; }

if(isset($_POST['tab'])){            $tab = $_POST['tab']; }else{ $tab = 1; }
if(isset($_POST['order'])){          $order = $_POST['order']; }else{ $order = "estado"; }
if(isset($_POST['az'])){             $az = $_POST['az']; }else{ $az = "DESC"; }
if(isset($_POST['items'])){          $items = $_POST['items']; }else{ $items = 10; }
if(isset($_POST['search'])){         $search = utf8_encode($_POST['search']); }else{ $search = ""; }
if(isset($_SESSION['uid'])){         $uid = $_SESSION['uid']; }else{ $uid = ""; }
if(isset($_SESSION['user_email'])){  $email = $_SESSION['user_email']; }else{ $email = ""; }
if(isset($_POST['dept'])){        	 $udept = $_POST['dept']; }else{ $udept = $_SESSION['user_department']; }

if($get == "SET_TICKET"){ 
  
  $q = "SELECT estado FROM TICKETS WHERE id = $id";
  $e = odbc_exec($con, $q);
  $r = odbc_result($e,1); 
  
  $query = "UPDATE tickets SET estado = '$stat' WHERE id = $id";
  odbc_exec($con, $query);
  
  if($stat == "En curso" && $r != "En curso"){    
  $q1 = "INSERT INTO tickets_meta_data(ticket_id, meta_id, value) VALUES($id,2,'$today')";    
  odbc_exec($con, $q1);
  }else{ if($stat == "En curso" && $r == "En curso"){ echo "La tarea ya fue iniciada por otro usuario!"; }}
  
  if($stat == "Completada" && $r != "Completada"){
    $q1 = "INSERT INTO tickets_meta_data(ticket_id, meta_id, value) VALUES($id,1,'".ms_escape_string(utf8_encode($data[1]))."')";    
    $q2 = "INSERT INTO tickets_meta_data(ticket_id, meta_id, value) VALUES($id,3,'$today')";
    $q3 = "INSERT INTO tickets_meta_data(ticket_id, meta_id, value) VALUES($id,4,'".$_SESSION['user_displayname']."')";
    $q4 = "INSERT INTO tickets_meta_data(ticket_id, meta_id, value) VALUES($id,5,'".utf8_encode($data[5])."')";  
    if($data[1]){ odbc_exec($con, $q1); }
    odbc_exec($con, $q2);
    odbc_exec($con, $q3);
    odbc_exec($con, $q4);  
	
  }else{ if($stat == "Completada" && $r == "Completada"){ echo "La tarea ya fue completada por otro usuario!"; } }
}

if($get == "TICKETS_ALL"){
  if( $items == "Todos" ){ $items = "SELECT COUNT(*) FROM tickets"; } 
  
  if($tab==1){ $query = "SELECT row_number() over (ORDER BY (SELECT 0)) as count, * FROM (SELECT top ($items) * FROM tickets WHERE estado != 'Completada' AND departamento LIKE '%$udept%' AND ( uid = '$uid' OR correo LIKE '%$email%') AND evento = 0 ORDER BY '$order' $az) as t1"; }  
  if($tab==2){ $query = "SELECT row_number() over (ORDER BY (SELECT 0)) as count, * FROM (SELECT top ($items) * FROM tickets WHERE estado = 'Completada' AND departamento LIKE '%$udept%' AND ( uid = '$uid' OR correo LIKE '%$email%') AND evento = 0 ORDER BY '$order' $az) as t1"; }
  if($tab==3){ $query = "SELECT row_number() over (ORDER BY (SELECT 0)) as count, * FROM (SELECT top ($items) * FROM tickets WHERE (id LIKE '$search%' OR CONVERT(VARCHAR(12),fecha, 110) LIKE CONVERT(VARCHAR(12),'%$search%', 110) OR nombre LIKE '%$search%' OR asunto LIKE '%$search%' OR descripcion LIKE '%$search%' OR estado LIKE '%$search%') AND departamento LIKE '%$udept%' AND ( uid = '$uid' OR correo LIKE '%$email%') ORDER BY '$order' $az) as t1"; }
  if($tab==4){ $query = "SELECT row_number() over (ORDER BY (SELECT 0)) as count, tickets.id as id,project_id, projects.creado as fechaproyecto, fecha, projects.nombre as nombreproyecto, projects.uid as projectuid, tickets.nombre, departamento, asunto, descripcion, correo, prioridad, tickets.estado, tickets.uid FROM (SELECT top (SELECT COUNT(*) FROM tickets) * FROM project_meta_data ) as t1 join projects on t1.project_id = projects.id join tickets on t1.ticket_id = tickets.id WHERE departamento LIKE '%$udept%' AND ( tickets.uid = '$uid' OR correo LIKE '%$email%') AND evento = 0 ORDER BY '$order' $az"; }
  if($tab==5){ $query = "SELECT row_number() over (ORDER BY (SELECT 0)) as count, * FROM (SELECT top ($items) * FROM tickets WHERE estado != 'Completada' AND departamento LIKE '%$udept%' AND ( uid = '$uid' OR correo LIKE '%$email%') AND evento = 1 ORDER BY '$order' $az) as t1"; }
  
  $exec = odbc_exec($con, $query);
  $tdClass = "TDODD";
  
  //--------------------------------------------------------------- ShowTicketsAll ---------------------------------------------------------------//
  if($tab!=4){ ?>  
  <table class="TICKETS_TABLE"><tr class="TRTITLE"><td class='PRIORITY_TD' ></td><td  class='TD1'><b>No.</b></td><td  class='TD2'><b>Creada</b></td><td  class='TD3'><b>De</b></td><td  class='TD4'><b>Asunto</b></td><td  class='TD5'><b>Estado</b></td><td  class='TD6'></td></tr>
  <?php }else{ ?>
  <table class="TICKETS_TABLE"><tr class="TRTITLE"><td  class='TD2'><b>Creado</b></td><td  class='TD3'><b>Administrador</b></td><td  class='TD3'><b>Asunto</b></td><td  class='TD5'><b>Progreso</b></td></tr>  
  <?php }
  
  while($array = odbc_fetch_array($exec)){
     $q1= "SELECT meta_names.meta_name, tickets_meta_data.value FROM tickets join tickets_meta_data on tickets.id = tickets_meta_data.ticket_id join meta_names on tickets_meta_data.meta_id = meta_names.id where tickets.id = ". $array["id"]." order by meta_names.meta_name";
     $e1 = odbc_exec($con, $q1);
	 $q2 = "SELECT tickets.id as ticket_id, meta_names.id as meta_id, meta_names.meta_name, tickets_meta_data.value FROM tickets join tickets_meta_data on tickets.id = tickets_meta_data.ticket_id join meta_names on tickets_meta_data.meta_id = meta_names.id where tickets.id = ". $array["id"]." order by meta_names.meta_name";
     $e2 = odbc_exec($con, $q2);  
     
	 $array["fechaproyecto"] = date('d-m-Y',strtotime($array["fechaproyecto"]));
	 $array["fecha"] = date('d-m-Y',strtotime($array["fecha"]));
	 	 
     if ( $array["estado"] == "No comenzada" ) { $ticketButton = "Abrir"; }
     if ( $array["estado"] == "En curso" || $array["estado"] == "A espera de otra persona" ) { $ticketButton = "Editar"; }
     if ( $array["estado"] == "Completada" || $array["estado"] == "Visible" ) { $ticketButton = "Ver";  $x = "style='background-color:#555'"; }
	 if ( $array["prioridad"] == "1" &&  $array["estado"] != "Completada" ) { $x = "style='background-color:#FF4200'"; }
	 if ( $array["prioridad"] == "2" &&  $array["estado"] != "Completada" ) { $x = "style='background-color:#FFB700'"; }
	 if ( $array["prioridad"] == "3" &&  $array["estado"] != "Completada" ) { $x = "style='background-color:#4DAC00'"; } 

   echo "<table class='TICKETS_TABLE TICKET_CONTAINER' projectid='".$array["project_id"]."' projectname='".$array["nombreproyecto"]."' created='".substr($array["fechaproyecto"],0,10)."' stat='".$array["estado"]."' admin='".$array["projectuid"]."' ><tr taskid='".$array["id"]."' class='TICKET'><td id='PRIORITY_TD".$array["id"]."' class='PRIORITY_TD' ".$x."></td><td class='TD1'>".$array["count"]."</td>"
       	."<td class='TD2'>".substr($array["fecha"],0,10)."</td><td class='TD3'>"
       	.utf8_decode($array["nombre"])."</td><td class='TD4'>"
        .utf8_decode($array["asunto"])."</td><td id='STAT".$array["id"]."' class='TD5' >"
        .$array["estado"]."</td><td align='center' class='TD6' >"
        ."<input id='BT".$array["id"]."' class='INPUT_BUTTON TICKETBTN' type='button' value='".$ticketButton."' ticketStat='".$array["estado"]."' ticketId='".$array["id"]."' ></td>"
        ."<tr id='TR".$array["id"]."' class='TROPTIONS'><td colspan='6' class='TDOPTIONS'><div id='TDIV".$array["id"]."' class='DIVOPTIONS'>"
        ."<span><b>Descripción de la actividad:</b></span><br />"
        ."<p>".utf8_decode($array["descripcion"])."</p>"; 
  
  if( $array["estado"] == "Completada" || $array["estado"] == "Visible" ){
	echo "<hr /><p><table class='TICKETDATA'>";    
	while( $a1 = odbc_fetch_array($e1) ){
       if($a1["meta_name"] == "Invitado(s)"){	   	 
		 $mailtags = "";
		 $recipients = explode("; ", substr($a1["value"],0,-2));		 
		 for( $i=0; $i<count($recipients); $i++){
   		 	  $mailtags .= "<div class='DIV_INVITADO'>".$recipients[$i]."</div>";			  
   		 }
		 $a1["value"] = $mailtags;		 		  
	  }
	   echo  "<tr><td width='140px'><b>".utf8_decode($a1["meta_name"]).":</b></td><td>".utf8_decode($a1["value"])."</td></tr>";
    }
    echo "</table></p>";    
  }else{          
    echo "<p><table class='TICKETDATA'>";
	while( $a2 = odbc_fetch_array($e2) ){
      $meta = ""; $class = "";
	  if($a2["meta_name"] == "Invitado(s)"){	   	 
		 $mailtags = "";
		 $recipients = explode("; ", substr($a2["value"],0,-2));		 
		 for( $i=0; $i<count($recipients); $i++){
   		 	  $mailtags .= "<div class='DIV_INVITADO'>".$recipients[$i]."</div>";			  
   		 }
		 $a2["value"] = $mailtags;		 		  
	  }
	  switch($a2["meta_id"]){	   	 
		 case 8;
		 	$meta = "taskstart";
			$class = "METAEDITABLE";
			break;
		case 9;
		 	$meta = "taskstart";
			$class = "METAEDITABLE";
			break;  		 		  
	  }
	  echo  "<tr><td width='140px'><b>".utf8_decode($a2["meta_name"]).":</b></td><td ><label class='$class' meta='$meta' task_id='".utf8_decode($a2["ticket_id"])."'>".utf8_decode($a2["value"])."</label></td></tr>";
    }	
	$q3 = "SELECT prioridad FROM tickets WHERE id = ".$array['id'];
    $e3 = odbc_exec($con, $q3);
	$a3 = odbc_result($e3,1);
	
	$options = array(
     1 => "1",
     2 => "2",     
     3 => "3"
 	);
	
	echo "<tr><td><b>Prioridad:</b></td><td><select class='PRIORITY_OPT' ticketId='".$array["id"]."' >";
	
	foreach ($options as $k => $v) {  
      echo "<option value=\"$k\"";  
      if ($k == $a3)
          echo " selected";  
      echo ">$v</option>";
	}
	echo "</select></td></tr></table></p><hr />";
	
   ?>
	<div class="RDIVDATA RDIV<?php print $array["id"]; ?>">
    <label class="INPUT_LABEL" ><b>Otro estado: </b></label>
    <select id="DIAG<?php echo $array["id"] ?>" class="_COMBO_BOX" style="margin-left:10px" >      
      <?php if($array["correo"]!="" || $array["uid"] == $_SESSION['uid']){  ?><option>Completada</option><?php } ?>
      <?php if($array["correo"]!="" && $array["uid"] != $_SESSION['uid']){  ?><option>A la espera de otra persona</option><?php } ?>
      <?php if($array["uid"] == $_SESSION['uid']){  ?><option>Aplazada</option><?php } ?>
    </select>
    <p><label class="INPUT_LABEL" ><b>Observaciones:</b></label><textarea id="OBS<?php echo $array["id"] ?>" class="RTXTDATA"></textarea></p>
    <hr />
    </div>    
    <?php    
    echo  "<input id='BTR1".$array["id"]."' ticketId='".$array["id"]."' ticketStat='".$array["estado"]."' class='INPUT_BUTTON BTR1' type='button' value='Responder' >"
            ."<input id='BTR2".$array["id"]."' ticketId='".$array["id"]."' ticketStat='".$array["estado"]."' class='INPUT_BUTTON BTR2' type='button' value='Finalizar' >"
            ."</div></td></tr>"; 
    }  ?>
</table>  
<?php } 
  
  while($array = odbc_fetch_array($exec)){
     $q1= "SELECT meta_names.meta_name, tickets_meta_data.value FROM tickets join tickets_meta_data on tickets.id = tickets_meta_data.ticket_id join meta_names on tickets_meta_data.meta_id = meta_names.id where tickets.id = ". $array["id"]." order by meta_names.meta_name";
     $e1 = odbc_exec($con, $q1);
	 $q2 = "SELECT meta_names.meta_name, tickets_meta_data.value FROM tickets join tickets_meta_data on tickets.id = tickets_meta_data.ticket_id join meta_names on tickets_meta_data.meta_id = meta_names.id where tickets.id = ". $array["id"]." order by meta_names.meta_name";
     $e2 = odbc_exec($con, $q2);   
   
     if ( $array["count"] & 1 ) { $tr = "TDEVEN"; }else{ $tr = "TDODD";  }
     if ( $array["estado"] == "No comenzada" ) { $ticketButton = "Abrir"; }
     if ( $array["estado"] == "En curso" || $array["estado"] == "A espera de otra persona" ) { $ticketButton = "Editar"; }
     if ( $array["estado"] == "Completada" ) { $ticketButton = "Ver";  $x = "style='background-color:#555'"; }
	 if ( $array["prioridad"] == "1" &&  $array["estado"] != "Completada" ) { $x = "style='background-color:#FF4200'"; }
	 if ( $array["prioridad"] == "2" &&  $array["estado"] != "Completada" ) { $x = "style='background-color:#FFB700'"; }
	 if ( $array["prioridad"] == "3" &&  $array["estado"] != "Completada" ) { $x = "style='background-color:#4DAC00'"; } 
   
   echo "<tr taskid='".$array["id"]."' class='".$tr."'><td id='PRIORITY_TD".$array["id"]."' class='PRIORITY_TD' ".$x."></td><td class='TD1'>".$array["count"]."</td>"
       	."<td class='TD2'>".substr($array["fecha"],0,10)."</td><td class='TD3'>"
       	.utf8_decode($array["nombre"])."</td><td class='TD4'>"
        .utf8_decode($array["asunto"])."</td><td id='STAT".$array["id"]."' class='TD5' >"
        .$array["estado"]."</td><td align='center' class='TD6' >"
        ."<input id='BT".$array["id"]."' class='INPUT_BUTTON TICKETBTN' type='button' value='".$ticketButton."' ticketStat='".$array["estado"]."' ticketId='".$array["id"]."' ></td>"
        ."<tr id='TR".$array["id"]."' class='TROPTIONS'><td colspan='6' class='TDOPTIONS'><div id='TDIV".$array["id"]."' class='DIVOPTIONS'>"
        ."<span><b>Descripción de la actividad:</b></span><br />"
        ."<p>".utf8_decode($array["descripcion"])."</p>"; 
  }
}

if($get == "SET_PRIORITY"){
  $query = "UPDATE tickets SET prioridad = $priority WHERE id = $id";
  odbc_exec($con, $query);  
} 

if($get == "DELETE_TICKET"){
  $q1 = "DELETE FROM tickets WHERE id = $id";
  $q2 = "DELETE FROM tickets_meta_data WHERE ticket_id = $id";
  $q3 = "DELETE FROM project_meta_data WHERE ticket_id = $id";  
  odbc_exec($con, $q1);
  odbc_exec($con, $q2);
  odbc_exec($con, $q3);  
} 

if($get == "DELETE_PROJECT"){
  $q2 = "DELETE FROM projects WHERE id = $id";
  $q1 = "DELETE FROM project_meta_data WHERE project_id = $id";  
  odbc_exec($con, $q1);
  odbc_exec($con, $q2);
} 

if($get == "EXCLUDE_TICKET"){
  $q1 = "DELETE FROM project_meta_data WHERE ticket_id = $id";  
  odbc_exec($con, $q1);
  odbc_exec($con, $q2);
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

odbc_close($con);
?>
