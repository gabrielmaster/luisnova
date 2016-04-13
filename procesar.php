<?php
//ob_start();


ini_set('display_errors',1);

/* $from = 'From: info@luisnova.com'; 
$to = 'herohat@gmail.com'; 
$subject = 'Subject'; 
$body = 'TEST'; 
 
if (mail ($to, $subject, $body, $from)) { 
echo 'MAIL - OK'; 
} else { 
echo 'MAIL FAILED'; 
} 

*/


	$us_asunto="Formulario de contacto desde LuisNova.com";
	$us_headers = "From: info@luisnova.com";
	//$us_headers .= "X-Sender: <info@luisnova.com>\n";
	//$us_headers .= "X-Priority: 3\n";
	//$us_headers .= "Return-Path: <info@luisnova.com>\n";
	//$us_headers .= "Content-Type: text/html; charset=iso-8859-1\n";
        //$us_headers .= "bcc: herohat@gmail.com\n";
	$us_email_destino="luisnova@mac.com";
	//$us_email_destino="herohat@gmail.com";

	$us_body = "Formulario de contacto completado:<br /><br />
            Nombre: ".$_POST['nombre']."<br />
            E-Mail: ".$_POST['email']."<br />
            Tel.: ".$_POST['tel']."<br />
            Mensaje:<br /> ".$_POST['msj']."<br />

";

	if(!mail($us_email_destino,$us_asunto,$us_body,$us_headers)){
		echo "<div style='font-family:tahoma; color: red; font-size:10px;  text-align: center; margin: 0 auto;'>Hubo un problema al enviar su email</div>";        
	}else{
		echo "<div style='font-family:tahoma; color: #cccccc; text-align: center; margin: 0 auto; padding-top:100px; width:100%; background:#666666; height: 518px;'>Mensaje enviado correctamente</div>";
		//sleep(15);
		/*echo "<script>alert('Mensaje enviado correctamente');
		var url = 'index.php';
		parent.window.location = url;
		</script>";
//		header("Location: http://www.luisnova.com/index.php");*/
	}




?>