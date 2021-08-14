<?php
//Leer POST del sistema de PayPal y añadir ‘cmd’

$req = 'cmd=_notify-validate';

 

foreach ($_POST as $key => $value) {
	$value = urlencode(stripslashes($value));
	$req .= "&$key=$value";
}

 

// Cabeceras para el correo
	$header = "Content-Type: text/html; charset=utf-8\n";
	$header.= "From:Taxiaeropuertodecancun<no-replyr@Taxiaeropuertodecancun.com>";
	
	// Servidor SMTP
	ini_set("SMTP","smtp.gmail.com");
	
	
	$email_destinatario = "antonicross@gmail.com";
	$recibido = '';
	
	
//Si estamos usando el testeo de paypal:
$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
//En caso de querer usar PayPal oficialmente:
//$fp = fsockopen (‘ssl://www.paypal.com’, 443, $errno, $errstr, 30);
if (!$fp) {
    
	// ERROR DE HTTP
	$recibido = "no se ha aiberto el socket<br/>";
	mail($email_destinatario,utf8_decode("Taxiaeropuertodecancun Ticket"), $recibido , $header);
	
}else{ echo "si se ha abierto el socket<br/>";
	fputs ($fp, $header . $req);
	while (!feof($fp)) {
		$res = fgets ($fp, 1024);
		if (strcmp ($res, "VERIFIED") == 0) {//Almacenamos todos los valores recibidos por $_POST.
			foreach($_POST as $key => $value){
				$recibido.= $key." = ". $value."\r\n";
			}//Enviamos por correo todos los datos , esto es solo para que veáis como funciona


		//En un caso real accederíamos a una BBDD y almacenaríamos los datos.
		// > Comprobando que payment_status es Completed
		// > Comprobando que txn_id no ha sido previamente procesado
		// > Comprobando que receiver_email es tu email primario de paypal
		// > Comprobando que payment_amount/payment_currency son procesos de pago correctos
		mail($email_destinatario,utf8_decode("Taxiaeropuertodecancun Ticket"), $recibido , $header);

		} else if (strcmp ($res, "INVALID") == 0) {

			mail($email_destinatario,utf8_decode("Taxiaeropuertodecancun Ticket"),"INVALIDO",$header);
		}
	}fclose ($fp);
}

 

?>