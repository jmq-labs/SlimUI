<?php
session_start();
$con = odbc_connect('sopit','sa','22197926');
$url = "";

if(isset($_POST['ticket_id'])){ $id = $_POST['ticket_id']; }else{ $id = "";  }
if(isset($_POST['nombre'])){ $no = utf8_encode($_POST['nombre']); }else{ $no = ""; }
if(isset($_POST['estado'])){ $es = utf8_encode($_POST['estado']); }else{ $es = ""; }
if(isset($_POST['asunto'])){ $as = utf8_encode($_POST['asunto']); }else{ $as = ""; }
if(isset($_POST['descripcion'])){ $de = utf8_encode($_POST['descripcion']); }else{ $de = ""; }
if(isset($_POST['correo'])){ $co = utf8_encode($_POST['correo']); }else{ $co = ""; }
$site_identity = @$_SESSION['site_identity'];

if(!$id){ 
if ($as != "" && $as != NULL) {         
$query = "INSERT INTO tickets(fecha,nombre,departamento,asunto,descripcion,correo,prioridad,estado,uid) VALUES(CURRENT_TIMESTAMP,'".$_SESSION['user_displayname']."','".$site_identity."','".ms_escape_string($as)."','".ms_escape_string($de)."','$co','2','En cola','".$_SESSION['uid']."')";
odbc_exec($con, $query);

$printID = "SELECT * FROM tickets WHERE id = @@Identity";
$execPrintID = odbc_exec($con, $printID);
$PrintIDarray = odbc_fetch_array($execPrintID);
$ID = $PrintIDarray["id"];

print "El ticket se envío correctamente! Su numero de referencia es el #".$ID.". ";

if($_FILES['file']['name'] != ''){
  $temp = explode(".", $_FILES["file"]["name"]);
  $extension = end($temp);
  
  if ((($_FILES["file"]["type"] == "image/gif")
  || ($_FILES["file"]["type"] == "image/jpeg")
  || ($_FILES["file"]["type"] == "image/jpg")
  || ($_FILES["file"]["type"] == "image/pjpeg")
  || ($_FILES["file"]["type"] == "image/x-png")
  || ($_FILES["file"]["type"] == "image/png")
  || ($_FILES["file"]["type"] == "application/octet-stream")
  || ($_FILES["file"]["type"] == "application/zip")
  || ($_FILES["file"]["type"] == "application/x-rar-compressed")
  || ($_FILES["file"]["type"] == "application/doc")
  || ($_FILES["file"]["type"] == "application/docx")
  || ($_FILES["file"]["type"] == "application/pdf"))
  && ($_FILES["file"]["size"] < 15000000)) {
    if ($_FILES["file"]["error"] > 0) {
      echo "Sin embargo hubo un error al subir el archivo: " . $_FILES["file"]["error"] . "<br>";
    } else {
	  	mkdir("upload/".$ID, 0700);  
        $ext = pathinfo(urlencode($_FILES["file"]["name"]));		
		move_uploaded_file($_FILES["file"]["tmp_name"],"upload/".$ID."/".$ID.".".$ext['extension']);
        $url = "<a href=http://ahm-honduras.com/sisprocinco/content/sopit/upload/".$ID."/".$ID.".".$ext['extension']." >Descargar</a>";				 
		$q_meta_file = "INSERT INTO tickets_meta_data(ticket_id, meta_id, value) VALUES($ID,7,'".$url."')";
	 	odbc_exec($con, $q_meta_file);     
    }
  } else {
    echo "PD: Archivo no valido.";
  }
}else{ $url = "No se adjunto ningun archivo."; }

}
if ($as != "" && $as != NULL ) {  
   require_once('mailer/class.phpmailer.php');
   require_once('mailer/class.pop3.php');
            
   $pop = new POP3();
   $pop->Authorise('mail1', 110, 30, 'ahm\noreply', 'nr.ahm2012', 1);
           
   $mail = new PHPMailer(true);
   $mail->IsSMTP();
   $mail->IsHTML(true);            
   $mail->Host = 'mail1';
   $mail->SMTPAuth   = true; 
   $mail->Username   = "noreply";
   $mail->Password   = "nr.ahm2012"; 
            
   $mail->SetFrom('noreply@ahm-honduras.com', $_SESSION['user_department']);
   $mail->AddAddress('informatica2@ahm-honduras.com', 'Jose Medardo Salinas');
   //$mail->AddAddress('informatica@ahm-honduras.com', 'Edgar Guerra');
   //$mail->AddAddress('manuelcastro10@gmail.com', 'Manuel Castro');
            
   $data = "<body style=\"font-family:Verdana, Verdana, Geneva, sans-serif; font-size:12px; color:#444;\">\n"
   		   ."El usuario "
		   .utf8_decode($no)." a ingresado un nuevo caso de soporte con ticket #".$ID.".<br /><br />"
		   ."<table cellspacing=\"10\" style=\"font-family:Verdana, Verdana, Geneva, sans-serif; font-size:12px; color:#444;\" >"
		   ."<tr><td><b>Asunto: </b></td><td>".utf8_decode($as)."</td></tr>"
		   ."<tr><td><b>Descripción: </b></td><td>".utf8_decode($de)."</td></tr>"
		   ."<tr><td><b>Adjunto: </b></td><td>".$url."</td></tr></table>";
   
   $mail->Subject = 'Ticket de '.$site_identity;
   $mail->MsgHTML(utf8_decode($data));
   $mail->Send();
			
   //--------------------------------------------------------------------------------
			
   if(filter_var($co, FILTER_VALIDATE_EMAIL)){
     
	 $q_meta1 = "INSERT INTO tickets_meta_data(ticket_id, meta_id, value) VALUES($ID,6,'".$co."')";
	 odbc_exec($con, $q_meta1);
	 
	 $mail2 = new PHPMailer(true);
     $mail2->IsSMTP();
	 $mail2->IsHTML(true);	           
     $mail2->Host = 'mail1';
	 $mail->SMTPAuth   = true; 
     $mail->Username   = "noreply";
   	 $mail->Password   = "nr.ahm2012";
	 
	 $mail2->SetFrom('noreply@ahm-honduras.com', 'AHM Notification Service');
     $mail2->AddAddress($co, $no);
              
     $data = "<body style=\"font-family:Verdana, Verdana, Geneva, sans-serif; font-size:12px; color:#444;\">\n"
	 	   	 ."Su ticket de soporte: [ ".utf8_decode($as)." ] fue recibido.<br /><br />"
			 ."<b>Su numero de ticket es: </b>".$ID."<br /><br /><b>Descripción del Problema: </b>".utf8_decode($de)
			 ."<br /><p>Gracias por su información!</p>";
  			
     $mail2->Subject = 'Ticket de '.$site_identity;
     $mail2->MsgHTML(utf8_decode($data));
     $mail2->Send();
   }	
     
   
}
}else{ 

$query = "SELECT * FROM tickets WHERE id = $id AND departamento = '$site_identity'";
$exec = odbc_exec($con, $query);
$array = odbc_fetch_array($exec);
if(count($array)>1){
?>
	<table width="100%">
	<tr><td><label class="title">Ticket #</label></td><td><?php echo $id; ?>&nbsp;( <?php echo utf8_decode($array["estado"]); ?> )</td></tr>
	<tr><td></td><td></td></tr>
	<tr><td><label class="label_gray"><b>Enviado por: </b></td><td><?php echo utf8_decode($array["nombre"]); ?></label></td></tr>		
	<tr><td><label class="label_gray"><b>Fecha: </b><td><?php echo $array["fecha"]; ?></label></td></tr>
	<tr><td><label class="label_gray"><b>Asunto: </b><td><?php echo utf8_decode($array["asunto"]); ?></label></td></tr>	  
	<tr><td><label class="label_gray"><b>Descripción: </b></label></td><td></td></tr>
	<tr><td colspan="2"><textarea class="desc"><?php echo utf8_decode($array["descripcion"]); ?></textarea></td></tr>	
	</tr></table><br />
	<label class="label_gray"><b>Últimos eventos registrados</b></label>
	<hr />
	<?php
	$q = "SELECT meta_names.meta_name, tickets_meta_data.value FROM tickets join tickets_meta_data on tickets.id = tickets_meta_data.ticket_id join meta_names on tickets_meta_data.meta_id = meta_names.id where tickets.id = $id order by meta_names.meta_name";
  	$e = odbc_exec($con, $q);
	echo "<p><table class=''>";
		while( $a = odbc_fetch_array($e) ){
			 echo  "<tr><td width='125px'><b>".utf8_decode($a["meta_name"]).":</b></td><td>".utf8_decode($a["value"])."</td></tr>";
		}
	echo "</table></p><hr /><input type='button' class='_INPUT_BUTTON' value='Volver' onclick='window.location.href=&apos;master.php?page=../../content/apps/sopit/index.php&apos; ' />";
	
}}

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
