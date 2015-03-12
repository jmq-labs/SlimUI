<?php
session_start();
$con = odbc_connect('planner','sa','22197926');
$url = "";

if(isset($_POST['ticket_id'])){ $id = $_POST['ticket_id']; }else{ $id = "";  }
if(isset($_POST['nombre'])){ $no = utf8_encode($_POST['nombre']); }else{ $no = ""; }
if(isset($_POST['estado'])){ $es = isset($_POST['estado']); }else{ $es = "No comenzada"; }
if(isset($_POST['asunto'])){ $as = utf8_encode($_POST['asunto']); }else{ $as = ""; }
if(isset($_POST['fechain'])){ $fi = utf8_encode($_POST['fechain']); }else{ $fi = ""; }
if(isset($_POST['fechafin'])){ $ff = utf8_encode($_POST['fechafin']); }else{ $ff = ""; }
if(isset($_POST['isevent'])){ $iv = 1; $es = "Visible"; }else{ $iv = 0; }
if(isset($_POST['allday'])){ $ad = 1; }else{ $ad = 0; $fi .= " ".$_POST['timestart']; $ff .= " ".$_POST['timeend']; }
if(isset($_POST['descripcion'])){ $de = utf8_encode($_POST['descripcion']); }else{ $de = ""; }
if(isset($_SESSION['user_department'])){ $udept = $_SESSION['user_department']; }else{ $udept = ""; }
if(isset($_POST['invitar'])){ $co = $_POST['invitar']; $recipients = explode("; ", substr($co,0,-2)); }

if($_SESSION['uid']){ 
if ($as != "" && $as != NULL) {
$query = "INSERT INTO tickets(fecha,nombre,departamento,asunto,descripcion,correo,prioridad,estado,uid,evento,allday) VALUES(CURRENT_TIMESTAMP,'".$_SESSION['user_displayname']."','$udept','".ms_escape_string($as)."','".ms_escape_string($de)."','$co','2','$es','".$_SESSION['uid']."', $iv, $ad)";
odbc_exec($con, $query);

$printID = "SELECT * FROM tickets WHERE id = @@Identity";
$execPrintID = odbc_exec($con, $printID);
$PrintIDarray = odbc_fetch_array($execPrintID);
$ID = $PrintIDarray["id"];

$q_meta_fi = "INSERT INTO tickets_meta_data(ticket_id, meta_id, value) VALUES($ID,8,'".$fi."')";
$q_meta_ff = "INSERT INTO tickets_meta_data(ticket_id, meta_id, value) VALUES($ID,9,'".$ff."')";	 
odbc_exec($con, $q_meta_fi);
odbc_exec($con, $q_meta_ff);

if($_FILES['file']['name'] != ''){
  $temp = explode(".", $_FILES["file"]["name"]);
  $extension = end($temp);
  
    if($_FILES["file"]["size"] < 15000000){
       if ($_FILES["file"]["error"] > 0) {
         echo "Hubo un error al subir el archivo: " . $_FILES["file"]["error"] . "<br>";
       } else {
	  	 mkdir("upload/".$ID, 0700);  
         $ext = pathinfo(urlencode($_FILES["file"]["name"]));		
		 move_uploaded_file($_FILES["file"]["tmp_name"],"upload/".$ID."/".$ID.".".$ext['extension']);
         $url = "<a href=http://ahm-honduras.com/slimui/content/apps/planner/upload/".$ID."/".$ID.".".$ext['extension']." >Descargar</a>";				 
		 $q_meta_file = "INSERT INTO tickets_meta_data(ticket_id, meta_id, value) VALUES($ID,7,'".$url."')";
	 	 odbc_exec($con, $q_meta_file);     
       }
    } else {
      echo "PD: Archivo no valido.";
    }
  }else{ $url = "No se adjunto ningun archivo."; }
}

if ($as != "" && $as != NULL ) {	 
   if($co || isset($_POST['isevent'])){
      
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
    	 
       $mail->SetFrom('noreply@ahm-honduras.com', 'Actividad en Planner');
       
       if($co){
    	   for( $i=0; $i<count($recipients); $i++){   		
        		$mail->AddAddress($recipients[$i], "Usuario de Planner");		
           }
		   $q_meta1 = "INSERT INTO tickets_meta_data(ticket_id, meta_id, value) VALUES($ID,6,'".$co."')";	 
   	   	   odbc_exec($con, $q_meta1);
	   }
                  
       $data = "<body style=\"font-family:Verdana, Verdana, Geneva, sans-serif; font-size:12px; color:#444;\">\n"
    	 	   	 ."Has recibido una invitación de colaboración en Planner.<br /><br />"
    			 ."<b>De: </b>".utf8_decode($no)."<br /><br />"
				 ."<b>Descripción de la actividad: </b>".utf8_decode($de)."<br /><br />";		 
       
	   if(isset($_POST['isevent'])){   	   		   
		   $today = date("Ymd\THis", time());
		   $mail->AddAddress($_SESSION['user_email'], "Usuario de Planner");		   
    	   $DescDump = str_replace("\r", "=0D=0A=", $de);
    	   $Start = date("Ymd\THis", strtotime($fi)); 
    	   $End = date("Ymd\THis", strtotime($ff));	   
    	   
		   $iCal = "BEGIN:VCALENDAR".PHP_EOL
                  ."METHOD:REQUEST".PHP_EOL
                  ."PRODID:Planner".PHP_EOL
                  ."VERSION:2.0".PHP_EOL
                  
				  ."BEGIN:VEVENT".PHP_EOL
                  ."ORGANIZER;CN=".$_SESSION['user_displayname'].":MAILTO:".$_SESSION['user_email'].PHP_EOL
                  ."DESCRIPTION;LANGUAGE=es-ES:$de".PHP_EOL
                  ."SUMMARY;LANGUAGE=es-ES:$as".PHP_EOL
				  ."DTSTART;TZID=America/Tegucigalpa:$Start".PHP_EOL
				  ."DTEND;TZID=America/Tegucigalpa:$End".PHP_EOL
                  ."UID:$ID".PHP_EOL
                  ."TRANSP:TRANSPARENT".PHP_EOL
                  
                  ."X-MICROSOFT-CDO-APPT-SEQUENCE:0".PHP_EOL
                  ."X-MICROSOFT-CDO-BUSYSTATUS:BUSY".PHP_EOL
                  ."X-MICROSOFT-CDO-INTENDEDSTATUS:FREE".PHP_EOL
                  ."X-MICROSOFT-CDO-IMPORTANCE:1".PHP_EOL
                  ."X-MICROSOFT-CDO-INSTTYPE:0".PHP_EOL
                  ."X-MICROSOFT-DISALLOW-COUNTER:FALSE".PHP_EOL
                  
                  ."BEGIN:VALARM".PHP_EOL
                  ."ACTION:DISPLAY".PHP_EOL
                  ."DESCRIPTION:REMINDER".PHP_EOL
                  ."TRIGGER;RELATED=START:-PT2H".PHP_EOL
                  ."END:VALARM".PHP_EOL
                  ."END:VEVENT".PHP_EOL
                  ."END:VCALENDAR";
				  			  
    	   $mail->AddStringAttachment("$iCal", "evento.ics", "base64", "text/calendar; charset=utf-8; method=REQUEST");		   
	   }	      			  
	   $mail->Subject = 'Planner';	   
       $mail->MsgHTML(utf8_decode($data));	   
       $mail->Send();	   	 
   }
  }
  
  if(isset($_POST['nomproyecto'])){
  	$tickets = explode(";", substr($_POST['project_tasks'],0,-1));
	$addProject = "INSERT INTO projects(nombre,creado,estado,uid) VALUES('".$_POST['nomproyecto']."',CURRENT_TIMESTAMP,0,'".$_SESSION['uid']."')";   	   
	odbc_exec($con, $addProject);
	
	$printID = "SELECT * FROM projects WHERE id = @@Identity";
    $execPrintID = odbc_exec($con, $printID);
    $id = odbc_result($execPrintID,1);
	
	for( $i=0; $i<count($tickets); $i++){   		
      	$addTickets = "INSERT INTO project_meta_data(project_id,ticket_id) VALUES($id,$tickets[$i])";
		odbc_exec($con, $addTickets);			
    }	   
  }
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
