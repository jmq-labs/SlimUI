<?php 
session_start();
$con=odbc_connect('sopit','sa','22197926');

$today = date('Y-m-d');
if(isset($_POST['get'])){            $get = $_POST['get']; }else{ $get = ""; }
if(isset($_POST['ticket_id'])){      $id = $_POST['ticket_id']; }else{ $id = ""; }
if(isset($_POST['status'])){         $stat = $_POST['status']; }else{ $stat = ""; }
if(isset($_POST['info'])){           $data = json_decode($_POST['info']); }else{ $data = ""; }
if(isset($_POST['priority'])){       $priority = json_decode($_POST['priority']); }else{ $priority = "1"; }

if(isset($_POST['tab'])){            $tab = $_POST['tab']; }else{ $tab = 1; }
if(isset($_POST['order'])){          $order = $_POST['order']; }else{ $order = "estado"; }
if(isset($_POST['az'])){             $az = $_POST['az']; }else{ $az = "DESC"; }
if(isset($_POST['items'])){          $items = $_POST['items']; }else{ $items = 10; }
if(isset($_POST['search'])){         $search = $_POST['search']; }else{ $search = ""; }
$site_identity = $_SESSION['site_identity'];

if($get == "SET_TICKET"){ 
  
  $q = "SELECT estado FROM TICKETS WHERE id = $id";
  $e = odbc_exec($con, $q);
  $r = odbc_result($e,1); 
  
  $query = "UPDATE tickets SET estado = '$stat' WHERE id = $id";
  odbc_exec($con, $query);
  
  if($stat == "Abierto" && $r != "Abierto"){    
  $q1 = "INSERT INTO tickets_meta_data(ticket_id, meta_id, value) VALUES($id,2,'$today')";    
  odbc_exec($con, $q1);
  }else{ if($stat == "Abierto" && $r == "Abierto"){ echo "El ticket ya fue Abierto por otro moderador!"; }}
  
  if($stat == "Cerrado" && $r != "Cerrado"){
    $q1 = "INSERT INTO tickets_meta_data(ticket_id, meta_id, value) VALUES($id,1,'".ms_escape_string(utf8_encode($data[1]))."')";    
    $q2 = "INSERT INTO tickets_meta_data(ticket_id, meta_id, value) VALUES($id,3,'$today')";
    $q3 = "INSERT INTO tickets_meta_data(ticket_id, meta_id, value) VALUES($id,4,'".$_SESSION['user_displayname']."')";
    $q4 = "INSERT INTO tickets_meta_data(ticket_id, meta_id, value) VALUES($id,5,'".utf8_encode($data[5])."')";  
    if($data[1]){ odbc_exec($con, $q1); }
    odbc_exec($con, $q2);
    odbc_exec($con, $q3);
    odbc_exec($con, $q4);  
  
  $q = "SELECT correo FROM TICKETS WHERE id = $id";
  $e = odbc_exec($con, $q);
  $m = odbc_result($e,1);
    
  if(filter_var($m, FILTER_VALIDATE_EMAIL)){
      require_once('.../mailer/class.phpmailer.php');
        require_once('.../mailer/class.pop3.php');
                 
        $pop = new POP3();
        $pop->Authorise('mail1', 110, 30, 'ahm\noreply', 'nr.ahm2012', 1);
                
        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->IsHTML(true);            
        $mail->Host = 'mail1';
        $mail->SMTPAuth   = true; 
        $mail->Username   = "noreply";
        $mail->Password   = "nr.ahm2012"; 
                 
        $mail->SetFrom('noreply@ahm-honduras.com', 'Ticket de '.$site_identity);
        $mail->AddAddress($m);    
                 
        $data = "<body style=\"font-family:Verdana, Verdana, Geneva, sans-serif; font-size:12px; color:#444;\">\n"
            ."El ticket #".$id." fue cerrado por un moderador.<br /><br />"
              ."<b>Diagnostico:</b><br />".$data[5]."<br /><br />"
        ."<b>Observaciones:</b><br />".$data[1]."<br /><br />"
          ."Para ver más información sobre el caso ingrese a la aplicación de tickets del Sistema ".$site_identity." o comuníquese con el departamento de soporte técnico.<br />";
        
        $mail->Subject = 'Ticket de '.$site_identity;
        $mail->MsgHTML(utf8_decode($data));
        $mail->Send();
  }
  }else{ if($stat == "Cerrado" && $r == "Cerrado"){ echo "El ticket ya fue Cerrado por otro moderador!"; }}
  
}

if($get == "TICKETS_ALL"){
  if( $items == "Todos" ){ $items = "SELECT COUNT(*) FROM tickets"; } 
  
  if($tab==1){ $query = "SELECT row_number() over (ORDER BY (SELECT 0)) as count, * FROM (SELECT top ($items) * FROM tickets WHERE estado != 'Cerrado' AND departamento = '$site_identity' ORDER BY '$order' $az) as t1"; }  
  if($tab==2){ $query = "SELECT row_number() over (ORDER BY (SELECT 0)) as count, * FROM (SELECT top ($items) * FROM tickets WHERE estado = 'Cerrado' AND departamento = '$site_identity' ORDER BY '$order' $az) as t1"; }
  if($tab==3){ $query = "SELECT row_number() over (ORDER BY (SELECT 0)) as count, * FROM (SELECT top ($items) * FROM tickets WHERE (id LIKE '$search%' OR CONVERT(VARCHAR(12),fecha, 110) LIKE CONVERT(VARCHAR(12),'%$search%', 110) OR nombre LIKE '%$search%' OR asunto LIKE '%$search%' OR descripcion LIKE '%$search%' OR estado LIKE '%$search%') AND departamento = '$site_identity' ORDER BY '$order' $az) as t1"; }
  
  $exec = odbc_exec($con, $query);
  $tdClass = "TDODD";
  ?>  
  <table class="TICKETS_TABLE"><tr class="TRTITLE"><td class='PRIORITY_TD' ></td><td  class='TD1'><b>No.</b></td><td  class='TD1'><b>Id</b></td><td  class='TD2'><b>Recibido</b></td><td  class='TD3'><b>De</b></td><td  class='TD4'><b>Asunto</b></td><td  class='TD5'><b>Estado</b></td><td  class='TD6'></td></tr>
  <?php
  while($array = odbc_fetch_array($exec)){
     $q1= "SELECT meta_names.meta_name, tickets_meta_data.value FROM tickets join tickets_meta_data on tickets.id = tickets_meta_data.ticket_id join meta_names on tickets_meta_data.meta_id = meta_names.id where tickets.id = ". $array["id"]." order by meta_names.meta_name";
     $e1 = odbc_exec($con, $q1);
	 $q2 = "SELECT meta_names.meta_name, tickets_meta_data.value FROM tickets join tickets_meta_data on tickets.id = tickets_meta_data.ticket_id join meta_names on tickets_meta_data.meta_id = meta_names.id where tickets.id = ". $array["id"]." order by meta_names.meta_name";
     $e2 = odbc_exec($con, $q2);   
   
     if ( $array["count"] & 1 ) { $tr = ""; }else{ $tr = "TDODD";  }
     if ( $array["estado"] == "En cola" ) { $ticketButton = "Abrir"; }
     if ( $array["estado"] == "Abierto" ) { $ticketButton = "Editar"; }
     if ( $array["estado"] == "Cerrado" ) { $ticketButton = "Ver";  $x = "style='background-color:#555'"; }
	 if ( $array["prioridad"] == "1" &&  $array["estado"] != "Cerrado" ) { $x = "style='background-color:#FF4200'"; }
	 if ( $array["prioridad"] == "2" &&  $array["estado"] != "Cerrado" ) { $x = "style='background-color:#FFB700'"; }
	 if ( $array["prioridad"] == "3" &&  $array["estado"] != "Cerrado" ) { $x = "style='background-color:#4DAC00'"; } 
   
   echo "<tr class='".$tr."'><td id='PRIORITY_TD".$array["id"]."' class='PRIORITY_TD' ".$x."></td><td class='TD1'>".$array["count"]."</td>"
       ."<td class='TD7'>".$array["id"]."</td>"
       ."<td class='TD2'>".substr($array["fecha"],0,10)."</td><td class='TD3'>"
       .$array["nombre"]."</td><td class='TD4'>"
      .utf8_decode($array["asunto"])."</td><td id='STAT".$array["id"]."' class='TD5' >"
      .$array["estado"]."</td><td align='center' class='TD6' >"
      ."<input id='BT".$array["id"]."' class='INPUT_BUTTON TICKETBTN' type='button' value='".$ticketButton."' ticketStat='".$array["estado"]."' ticketId='".$array["id"]."' ></td>"
      ."<tr id='TR".$array["id"]."' class='TROPTIONS'><td colspan='7' class='TDOPTIONS'><div id='TDIV".$array["id"]."' class='DIVOPTIONS'>"
      ."<span><b>Descripción del caso:</b></span><br />"
      ."<p>".utf8_decode($array["descripcion"])."</p>"; 
  
  if( $array["estado"] == "Cerrado" ){    
    echo "<hr /><p><table class='TICKETDATA'>";
    while( $a1 = odbc_fetch_array($e1) ){
       echo  "<tr><td width='125px'><b>".utf8_decode($a1["meta_name"]).":</b></td><td>".utf8_decode($a1["value"])."</td></tr>";
    }
    echo "</table></p>";    
  }else{          
    echo "<p><table class='TICKETDATA'>";
	while( $a2 = odbc_fetch_array($e2) ){
       echo  "<tr><td width='125px'><b>".utf8_decode($a2["meta_name"]).":</b></td><td>".utf8_decode($a2["value"])."</td></tr>";
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
    <label class="INPUT_LABEL" ><b>Diagnóstico: </b></label>
    <select id="DIAG<?php echo $array["id"] ?>" class="_COMBO_BOX" style="margin-left:10px" >
      <option>Sin diagnóstico</option>
      <option>Solucionado</option>
      <option>Parcialmente solucionado</option>
      <option>Preexistente</option>
      <option>Información insuficiente</option>
      <option>No aplica</option>      
    </select>
    <p><label class="INPUT_LABEL" ><b>Observaciones:</b></label><textarea id="OBS<?php echo $array["id"] ?>" class="RTXTDATA"></textarea></p>
    <hr />
    </div>    
    <?php    
    echo  "<input id='BTR1".$array["id"]."' ticketId='".$array["id"]."' ticketStat='".$array["estado"]."' class='INPUT_BUTTON BTR1' type='button' value='Responder' >"
            ."<input id='BTR2".$array["id"]."' ticketId='".$array["id"]."' ticketStat='".$array["estado"]."' class='INPUT_BUTTON BTR2' type='button' value='Cerrar Ticket' >"
            ."</div></td></tr>";
  }
  }  
  ?>
  </table>
  <?php
}

if($get == "SET_PRIORITY"){
  $query = "UPDATE tickets SET prioridad = $priority WHERE id = $id";
  odbc_exec($con, $query);  
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
