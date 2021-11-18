<?php namespace Listener;

ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

// Reply with an empty 200 response to indicate to paypal the IPN was received correctly

header("HTTP/1.1 200 OK");

require_once('./accesso/db/conexion.php');

$postcito = "";

file_put_contents('test.log',$postcito, FILE_APPEND);

$LOG_STRING = "Log started: ".date('Y-m-d H:i');

// Set this to true to use the sandbox endpoint during testing:

$paypalSQL = "SELECT * FROM configuraciones;";



$configuracionesQuery = mysqli_query($conexion,$paypalSQL);

$paypalSQL = mysqli_fetch_array($configuracionesQuery);



if($paypalSQL['url_paypal'] == "https://www.sandbox.paypal.com/cgi-bin/webscr

"){

    $enable_sandbox = true;    

}else{

    $enable_sandbox = false;

}



error_log("log IPN".json_encode($_POST), 0);



$LOG_STRING .="\n CORRECT DATABASE";

$sql = "SELECT * FROM configuraciones";

$respuesta= mysqli_query($conexion,$sql);

$row = mysqli_fetch_array($respuesta);



// Use this to specify all of the email addresses that you have attached to paypal:

$my_email_addresses = array($row['correo_paypal']);



// Set this to true to send a confirmation email:

$send_confirmation_email = true;

$confirmation_email_address = "My Name <".$row['correo_paypal'].">";

$from_email_address = "TaxiAeropuertodeCancun<no-replyr@taxiaeropuertodecancun.com>";



// Set this to true to save a log file:

$save_log_file = true;

$log_file_dir = __DIR__ . "/logs";



// Here is some information on how to configure sendmail:

// http://php.net/manual/en/function.mail.php#118210





require('PaypalIPN.php');

$LOG_STRING .="\n IPN class loaded";



use PaypalIPN;

$ipn = new PaypalIPN();

$LOG_STRING .="\n IPN INIT";



if ($enable_sandbox) {

    $ipn->useSandbox();

}

$LOG_STRING .="\n IPN SETUP CORRECTLY";

try{

  $verified = $ipn->sockVerifyIPN();

}catch(Exception $e){

  file_put_contents('test.log',$e, FILE_APPEND);

}

file_put_contents('test.log',$LOG_STRING, FILE_APPEND);



$LOG_STRING .="\n IPN verified";



$data_text = "";

foreach ($_POST as $key => $value) {

    $data_text .= $key . " = " . $value . "\r\n";

}

$LOG_STRING .="\n Loaded POST values";

$test_text = "";

if ($_POST["test_ipn"] == 1) {

    $test_text = "Test ";

}



// Check the receiver email to see if it matches your list of paypal email addresses

$receiver_email_found = false;

foreach ($my_email_addresses as $a) {

    if (strtolower($_POST["receiver_email"]) == strtolower($a)) {

        $receiver_email_found = true;

        break;

    }

}

$LOG_STRING .="\n Email checked 1";

date_default_timezone_set("America/Los_Angeles");

list($year, $month, $day, $hour, $minute, $second, $timezone) = explode(":", date("Y:m:d:H:i:s:T"));

$date = $year . "-" . $month . "-" . $day;

$timestamp = $date . " " . $hour . ":" . $minute . ":" . $second . " " . $timezone;

$dated_log_file_dir = $log_file_dir . "/" . $year . "/" . $month;

$LOG_STRING .="\n LIST loaded";

$paypal_ipn_status = "VERIFICATION FAILED";

if ($verified) {

    $paypal_ipn_status = "RECEIVER EMAIL MISMATCH";

    $LOG_STRING .="\n IPN: ".$paypal_ipn_status;

    if ($receiver_email_found) {

        $paypal_ipn_status = "Completed Successfully";

$LOG_STRING .="\n VERIFIED";



        // Process IPN

        // A list of variables are available here:

        // https://developer.paypal.com/webapps/developer/docs/classic/ipn/integration-guide/IPNandPDTVariables/



        // This is an example for sending an automated email to the customer when they purchases an item for a specific amount:

        if ($_POST["payment_status"] == "Completed") {

            $LOG_STRING .="\n IPN Payment status completed";

            $email_to = $_POST["first_name"] . " " . $_POST["last_name"] . " <" . $_POST["payer_email"] . ">";

            $email_subject = $test_text . "Completed order for: " . $_POST["item_name"];

            $email_body = "Thank you for purchasing " . $_POST["item_name"] . "." . "\r\n" . "\r\n" . "This is an example email only." . "\r\n" . "\r\n" . "Thank you.";

            mail($email_to, $email_subject, $email_body, "From: " . $from_email_address);

        }





    }

} elseif ($enable_sandbox) {

    $LOG_STRING .="\n IPN ON SANDBOX";

    if ($_POST["test_ipn"] != 1) {

        $LOG_STRING .="\n IPN RECEIVED FROM LIVE IN SANDBOX";

        $paypal_ipn_status = "RECEIVED FROM LIVE WHILE SANDBOXED";

    }

} elseif ($_POST["test_ipn"] == 1) {

    file_put_contents("log.txt", "step18");

    $paypal_ipn_status = "RECEIVED FROM SANDBOX WHILE LIVE";

    $LOG_STRING .="\n IPN ".$paypal_ipn_status;

}



if ($save_log_file) {

    

    // Create log file directory

    if (!is_dir($dated_log_file_dir)) {

        

        if (!file_exists($dated_log_file_dir)) {

            

            mkdir($dated_log_file_dir, 0777, true);

            if (!is_dir($dated_log_file_dir)) {

                

                $save_log_file = false;

            }

        } else {

            

            $save_log_file = false;

        }

    }

    // Restrict web access to files in the log file directory

    $htaccess_body = "RewriteEngine On" . "\r\n" . "RewriteRule .* - [L,R=404]";

    

    if ($save_log_file && (!is_file($log_file_dir . "/.htaccess") || file_get_contents($log_file_dir . "/.htaccess") !== $htaccess_body)) {

        

        if (!is_dir($log_file_dir . "/.htaccess")) {

            

            file_put_contents($log_file_dir . "/.htaccess", $htaccess_body);

            if (!is_file($log_file_dir . "/.htaccess") || file_get_contents($log_file_dir . "/.htaccess") !== $htaccess_body) {

                

                $save_log_file = false;

            }

        } else {

            

            $save_log_file = false;

        }

    }

    if ($save_log_file) {

        

        // Save data to text file

        file_put_contents($dated_log_file_dir . "/" . $test_text . "paypal_ipn_" . $date . ".txt", "paypal_ipn_status = " . $paypal_ipn_status . "\r\n" . "paypal_ipn_date = " . $timestamp . "\r\n" . $data_text . "\r\n", FILE_APPEND);

        

    }

}



if ($send_confirmation_email) {

    

    // Send confirmation email

    mail($confirmation_email_address, $test_text . "PayPal IPN : " . $paypal_ipn_status, "paypal_ipn_status = " . $paypal_ipn_status . "\r\n" . "paypal_ipn_date = " . $timestamp . "\r\n" . $data_text, "From: " . $from_email_address);

    



$id_reservacion = $_POST['item_number'];

$id_transaccion = $_POST['txn_id'];



$LOG_STRING .="\n IPN TXN ID ".$id_transaccion;

$LOG_STRING .="\n IPN ITEM ID ".$id_reservacion;



if(isset($_POST['receipt_ID'])){

    $id_transaccion = $_POST['receipt_ID'];  

}



$sql2 = "UPDATE reservaciones SET transaccion_paypal='".$id_transaccion."' WHERE id_reservacion=".$id_reservacion;

$LOG_STRING .="\n SQL 1: ".$sql2;

$respuesta2 = mysqli_query($conexion,$sql2);



$sql = "SELECT * FROM reservaciones WHERE id_reservacion =".$id_reservacion;

$LOG_STRING .="\n SQL 2: ".$sql;

$respuesta = mysqli_query($conexion,$sql);

$row = mysqli_fetch_array($respuesta);





$sql = "SELECT sum(precio*(cantidad_ida+cantidad_retorno)) suma FROM `extra_reservaciones` er join `extras` ex on(ex.id_extra=er.id_extra) where (cantidad_ida != 0 || cantidad_retorno != 0) group by id_reservacion having id_reservacion=".$id_reservacion;

$LOG_STRING .="\n SQL 3: ".$sql;

$respuesta6 = mysqli_query($conexion,$sql);

$row2 = mysqli_fetch_array($respuesta6);



$sql = "SELECT count(*) cantidad FROM extras AS ex JOIN extra_reservaciones er ON(er.id_extra=ex.id_extra) WHERE er.id_reservacion=".$id_reservacion." AND (cantidad_ida != 0 || cantidad_retorno != 0)";

$LOG_STRING .="\n SQL 4: ".$sql;

$respuesta3= mysqli_query($conexion,$sql);

$rowCantidad = mysqli_fetch_array($respuesta3);



$sql = "SELECT * FROM extras AS ex JOIN extra_reservaciones er ON(er.id_extra=ex.id_extra) WHERE er.id_reservacion=".$id_reservacion." AND (cantidad_ida != 0 || cantidad_retorno != 0)";

$LOG_STRING .="\n SQL 5: ".$sql;

$respuesta6= mysqli_query($conexion,$sql);





    // Cabeceras para el correo

    $header = "Content-Type: text/html; charset=utf-8\n";

    $header.= "From: TaxiAeropuertodeCancun<no-responder@taxiaeropuertodecancun.com>";

    

    // Servidor SMTP

    ini_set("SMTP","smtp.gmail.com");

    

    

    $email_destinatario = $row['email_p'];

    $nombre_destinatario = $row['nombre_p'];
    $suma_total = number_format($row['Total_comision'],2,',','');
    $aerolineaArray = explode(',', $row['aerolinea']);

    switch ($row['modo_viaje']) {

        case 1:

            $transfer_type= "Round Trip - Airport > Hotel > Airport";

            $transfer = $row['ubicacion_desde'];

            break;

        case 2:

            $transfer_type.= "One Way - Airport > Hotel";

            $transfer = $row['ubicacion_desde'];

            break;

        case 3:

            $transfer_type.= "One Way - Hotel > Airport";

            $transfer = $row['ubicacion_desde'];

            break;

        case 4:

            $transfer_type.= "One Way - Hotel > Hotel";

            $transfer = $row['ubicacion_desde']." - ".$row['ubicacion_hasta'];

            break;

        default:

            # code...

            break;

    }

    $pmam = intval($row['pickup_hour'])>12?'pm':'am';

        

    if($row['lang'] == "es"){

        $LOG_STRING .="\n IPN LANG: ES";

        $contenido_correo.= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

        <html xmlns="http://www.w3.org/1999/xhtml">

          <head>



            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

            

                  <style type="text/css">

                  .ExternalClass{width:100%}.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:150%}a{text-decoration:none}body,td,input,textarea,select{margin:unset;font-family:unset}input,textarea,select{font-size:unset}@media screen and (max-width: 600px){table.row th.col-lg-1,table.row th.col-lg-2,table.row th.col-lg-3,table.row th.col-lg-4,table.row th.col-lg-5,table.row th.col-lg-6,table.row th.col-lg-7,table.row th.col-lg-8,table.row th.col-lg-9,table.row th.col-lg-10,table.row th.col-lg-11,table.row th.col-lg-12{display:block;width:100% !important}.d-mobile{display:block !important}.d-desktop{display:none !important}.w-lg-25{width:auto !important}.w-lg-25>tbody>tr>td{width:auto !important}.w-lg-50{width:auto !important}.w-lg-50>tbody>tr>td{width:auto !important}.w-lg-75{width:auto !important}.w-lg-75>tbody>tr>td{width:auto !important}.w-lg-100{width:auto !important}.w-lg-100>tbody>tr>td{width:auto !important}.w-lg-auto{width:auto !important}.w-lg-auto>tbody>tr>td{width:auto !important}.w-25{width:25% !important}.w-25>tbody>tr>td{width:25% !important}.w-50{width:50% !important}.w-50>tbody>tr>td{width:50% !important}.w-75{width:75% !important}.w-75>tbody>tr>td{width:75% !important}.w-100{width:100% !important}.w-100>tbody>tr>td{width:100% !important}.w-auto{width:auto !important}.w-auto>tbody>tr>td{width:auto !important}.p-lg-0>tbody>tr>td{padding:0 !important}.pt-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-top:0 !important}.pr-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-right:0 !important}.pb-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-bottom:0 !important}.pl-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-left:0 !important}.p-lg-1>tbody>tr>td{padding:0 !important}.pt-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-top:0 !important}.pr-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-right:0 !important}.pb-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-bottom:0 !important}.pl-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-left:0 !important}.p-lg-2>tbody>tr>td{padding:0 !important}.pt-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-top:0 !important}.pr-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-right:0 !important}.pb-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-bottom:0 !important}.pl-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-left:0 !important}.p-lg-3>tbody>tr>td{padding:0 !important}.pt-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-top:0 !important}.pr-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-right:0 !important}.pb-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-bottom:0 !important}.pl-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-left:0 !important}.p-lg-4>tbody>tr>td{padding:0 !important}.pt-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-top:0 !important}.pr-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-right:0 !important}.pb-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-bottom:0 !important}.pl-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-left:0 !important}.p-lg-5>tbody>tr>td{padding:0 !important}.pt-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-top:0 !important}.pr-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-right:0 !important}.pb-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-bottom:0 !important}.pl-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-left:0 !important}.p-0>tbody>tr>td{padding:0 !important}.pt-0>tbody>tr>td,.py-0>tbody>tr>td{padding-top:0 !important}.pr-0>tbody>tr>td,.px-0>tbody>tr>td{padding-right:0 !important}.pb-0>tbody>tr>td,.py-0>tbody>tr>td{padding-bottom:0 !important}.pl-0>tbody>tr>td,.px-0>tbody>tr>td{padding-left:0 !important}.p-1>tbody>tr>td{padding:4px !important}.pt-1>tbody>tr>td,.py-1>tbody>tr>td{padding-top:4px !important}.pr-1>tbody>tr>td,.px-1>tbody>tr>td{padding-right:4px !important}.pb-1>tbody>tr>td,.py-1>tbody>tr>td{padding-bottom:4px !important}.pl-1>tbody>tr>td,.px-1>tbody>tr>td{padding-left:4px !important}.p-2>tbody>tr>td{padding:8px !important}.pt-2>tbody>tr>td,.py-2>tbody>tr>td{padding-top:8px !important}.pr-2>tbody>tr>td,.px-2>tbody>tr>td{padding-right:8px !important}.pb-2>tbody>tr>td,.py-2>tbody>tr>td{padding-bottom:8px !important}.pl-2>tbody>tr>td,.px-2>tbody>tr>td{padding-left:8px !important}.p-3>tbody>tr>td{padding:16px !important}.pt-3>tbody>tr>td,.py-3>tbody>tr>td{padding-top:16px !important}.pr-3>tbody>tr>td,.px-3>tbody>tr>td{padding-right:16px !important}.pb-3>tbody>tr>td,.py-3>tbody>tr>td{padding-bottom:16px !important}.pl-3>tbody>tr>td,.px-3>tbody>tr>td{padding-left:16px !important}.p-4>tbody>tr>td{padding:24px !important}.pt-4>tbody>tr>td,.py-4>tbody>tr>td{padding-top:24px !important}.pr-4>tbody>tr>td,.px-4>tbody>tr>td{padding-right:24px !important}.pb-4>tbody>tr>td,.py-4>tbody>tr>td{padding-bottom:24px !important}.pl-4>tbody>tr>td,.px-4>tbody>tr>td{padding-left:24px !important}.p-5>tbody>tr>td{padding:48px !important}.pt-5>tbody>tr>td,.py-5>tbody>tr>td{padding-top:48px !important}.pr-5>tbody>tr>td,.px-5>tbody>tr>td{padding-right:48px !important}.pb-5>tbody>tr>td,.py-5>tbody>tr>td{padding-bottom:48px !important}.pl-5>tbody>tr>td,.px-5>tbody>tr>td{padding-left:48px !important}.s-lg-1>tbody>tr>td,.s-lg-2>tbody>tr>td,.s-lg-3>tbody>tr>td,.s-lg-4>tbody>tr>td,.s-lg-5>tbody>tr>td{font-size:0 !important;line-height:0 !important;height:0 !important}.s-0>tbody>tr>td{font-size:0 !important;line-height:0 !important;height:0 !important}.s-1>tbody>tr>td{font-size:4px !important;line-height:4px !important;height:4px !important}.s-2>tbody>tr>td{font-size:8px !important;line-height:8px !important;height:8px !important}.s-3>tbody>tr>td{font-size:16px !important;line-height:16px !important;height:16px !important}.s-4>tbody>tr>td{font-size:24px !important;line-height:24px !important;height:24px !important}.s-5>tbody>tr>td{font-size:48px !important;line-height:48px !important;height:48px !important}}@media yahoo{.d-mobile{display:none !important}.d-desktop{display:block !important}.w-lg-25{width:25% !important}.w-lg-25>tbody>tr>td{width:25% !important}.w-lg-50{width:50% !important}.w-lg-50>tbody>tr>td{width:50% !important}.w-lg-75{width:75% !important}.w-lg-75>tbody>tr>td{width:75% !important}.w-lg-100{width:100% !important}.w-lg-100>tbody>tr>td{width:100% !important}.w-lg-auto{width:auto !important}.w-lg-auto>tbody>tr>td{width:auto !important}.p-lg-0>tbody>tr>td{padding:0 !important}.pt-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-top:0 !important}.pr-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-right:0 !important}.pb-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-bottom:0 !important}.pl-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-left:0 !important}.p-lg-1>tbody>tr>td{padding:4px !important}.pt-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-top:4px !important}.pr-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-right:4px !important}.pb-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-bottom:4px !important}.pl-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-left:4px !important}.p-lg-2>tbody>tr>td{padding:8px !important}.pt-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-top:8px !important}.pr-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-right:8px !important}.pb-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-bottom:8px !important}.pl-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-left:8px !important}.p-lg-3>tbody>tr>td{padding:16px !important}.pt-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-top:16px !important}.pr-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-right:16px !important}.pb-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-bottom:16px !important}.pl-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-left:16px !important}.p-lg-4>tbody>tr>td{padding:24px !important}.pt-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-top:24px !important}.pr-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-right:24px !important}.pb-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-bottom:24px !important}.pl-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-left:24px !important}.p-lg-5>tbody>tr>td{padding:48px !important}.pt-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-top:48px !important}.pr-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-right:48px !important}.pb-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-bottom:48px !important}.pl-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-left:48px !important}.s-lg-0>tbody>tr>td{font-size:0 !important;line-height:0 !important;height:0 !important}.s-lg-1>tbody>tr>td{font-size:4px !important;line-height:4px !important;height:4px !important}.s-lg-2>tbody>tr>td{font-size:8px !important;line-height:8px !important;height:8px !important}.s-lg-3>tbody>tr>td{font-size:16px !important;line-height:16px !important;height:16px !important}.s-lg-4>tbody>tr>td{font-size:24px !important;line-height:24px !important;height:24px !important}.s-lg-5>tbody>tr>td{font-size:48px !important;line-height:48px !important;height:48px !important}}



                </style>

        </head>

          <body style="outline: 0; width: 100%; min-width: 100%; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 24px; font-weight: normal; font-size: 16px; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; color: #000000; margin: 0; padding: 0; border: 0;" bgcolor="#ffffff">

        <table valign="top" class="bg-light body" style="outline: 0; width: 100%; min-width: 100%; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 24px; font-weight: normal; font-size: 16px; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; color: #000000; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; margin: 0; padding: 0; border: 0;" bgcolor="#f8f9fa">

          <tbody>

            <tr>

              <td valign="top" style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; margin: 0;" align="left" bgcolor="#f8f9fa">

                

            <table class="container" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%;">

          <tbody>

            <tr>

              <td align="center" style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; margin: 0; padding: 0 16px;">

                <!--[if (gte mso 9)|(IE)]>

                  <table align="center">

                    <tbody>

                      <tr>

                        <td width="600">

                <![endif]-->

                <table align="center" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%; margin: 0 auto;">

                  <tbody>

                    <tr>

                      <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; margin: 0;" align="left">

                        

              <div style="background-color: #33a5ff;">';

      $contenido_correo.='<img src="https://cancunshuttleairport.com/images/logocancuntransportation.jpg" width="130" height="40" style="height: auto; line-height: 100%; outline: none; text-decoration: none; border: 0 none;">

        <h2 style="float: right; padding-top: 20px; padding-right: 10px; color: #fff; margin-top: 0; margin-bottom: 0; font-weight: 500; vertical-align: baseline; font-size: 22px; line-height: 38.4px;" align="left">

        Hola, '.$nombre_destinatario.'!

        </h2>

        </div>

        <table class="s-4 w-100" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">

          <tbody>

            <tr>

              <td height="24" style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 24px; width: 100%; height: 24px; margin: 0;" align="left">

                 

              </td>

            </tr>

          </tbody>

        </table>



        <div class="">

        <p style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left">

        ¡Buscar el logo es más fácil que buscar tu nombre entre toda la multitud!</p>



        <p style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left">Gracias por confiar en Cancun Transportation ™ con sus servicios de transporte en Cancún y la Riviera Maya.</p>



        <p style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left">Los detalles de su reserva se encuentran a continuación. Si alguna información a continuación no es correcta, comuníquese con nosotros inmediatamente con la corrección. Al llegar al aeropuerto es muy importante que lea atentamente nuestras sugerencias para un acceso más rápido y seguro a su transporte.</p>



        <p class="text-primary" style="line-height: 24px; font-size: 16px; width: 100%; color: #007bff; margin: 0;" align="left"><strong>RECUERDA IMPRIMIR Y LLEVAR ESTE VOUCHER Y PRESENTARLO A NUESTRO PERSONAL DE BIENVENIDA EN EL AEROPUERTO.

        </strong></p>

        </div>

        <table class="s-3 w-100" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">

          <tbody>

            <tr>

              <td height="16" style="border-spacing: 0px; border-collapse: collapse; line-height: 16px; font-size: 16px; width: 100%; height: 16px; margin: 0;" align="left">

                 

              </td>

            </tr>

          </tbody>

        </table>



        <div class="">

        <span>Your confirmation code is: <b>CT0000000'.$id_reservacion.'</b></span>

        <span style="float: right;">TOTAL + 9% commission: <b>'.$suma_total.' '.$paypalSQL['tipo_moneda'].'</b></span>

        </div>

        <table class="s-4 w-100" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">

          <tbody>

            <tr>

              <td height="24" style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 24px; width: 100%; height: 24px; margin: 0;" align="left">

                 

              </td>

            </tr>

          </tbody>

        </table>



        <table class="table " border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%; max-width: 100%;">

          <thead>

            <tr>

              <th width="25%" style="line-height: 24px; border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">TRASLADO</th>

              <th width="25%" style="line-height: 24px; border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">SERVICIO</th>

              <th width="25%" style="line-height: 24px; border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">VEHICULO</th>

              <th width="25%" style="line-height: 24px; border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">PASAJERO(S)</th>

            </tr>

          </thead>

          <tbody>

            <tr>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$transfer_type.'</td>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">Private</td>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['transporte'].'</td>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['cantidad_personas'].'</td>

            </tr>

          </tbody>

        </table>

        <table class="table" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%; max-width: 100%;">

          <thead>

            <tr>

              <th width="50%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">HOTEL</th>

              <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">LLEGADA</th>

              <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">SALIDA</th>

            </tr>

          </thead>

          <tbody>

            <tr>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$transfer.'</td>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['fecha_ida'].'</td>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['fecha_regreso'].'</td>

            </tr>

          </tbody>

        </table>

        <table class="table" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%; max-width: 100%;">

          <thead>

            <tr>

              <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">VUELO DESDE</th>

              <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">AEROLINEA</th>

              <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">NUMERO VUELO</th>

              <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">TRANSACCIÓN PAYPAL</th>

            </tr>

          </thead>

          <tbody>

            <tr>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$aerolineaArray[0].'</td>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$aerolineaArray[1].'</td>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$aerolineaArray[2].'</td>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['transaccion_paypal'].'</td>

            </tr>

          </tbody>

        </table>

        <table class="table" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%; max-width: 100%;">

          <thead>

            <tr>

              <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">NOMBRE</th>

              <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">CORREO</th>

              <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">TELEFONO</th>

              <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">PAIS</th>

            </tr>

          </thead>

          <tbody>

            <tr>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['nombre_p'].'</td>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['email_p'].'</td>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['telefono_p'].'</td>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['pais_p'].'</td>

            </tr>

          </tbody>

        </table>

        <table class="table" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%; max-width: 100%;">

          <thead>

            <tr>

            <th style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">PICKUP TIME</th>

              <th style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">COMMENTS</th>

            </tr>

          </thead>

          <tbody>

            <tr>

            <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['pickup_hour'].':'.$row['pickup_minute'].' '.$pmam.'</td>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['comments'].'</td>

            </tr>

          </tbody>

        </table>';

                if($rowCantidad['cantidad'] != 0){

                $contenido_correo.= '

              <div style="color: #fff; background-color: #33a5ff; padding: 15px;">

                <h5 style="margin-top: 0; margin-bottom: 0; font-weight: 500; vertical-align: baseline; font-size: 20px; line-height: 24px;" align="left">Extras:</h5>

              </div>

              <table class="table" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%; max-width: 100%;">

          <thead>

            <tr>

              <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">PRODUCTO</th>

              <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">CANTIDAD</th>

              <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">PRECIO UNIDAD</th>

            </tr>

          </thead>

          <tbody>';

            $retorno_sum = "";                    

            while($rowExtra = mysqli_fetch_array($respuesta6)){



                if(intval($rowExtra['cantidad_retorno']) != 0 && intval($rowExtra['cantidad_ida']) != 0){

                    $retorno_sum = $rowExtra['cantidad_ida']." on departure And ".$rowExtra['cantidad_retorno']." on return";

                }elseif(intval($rowExtra['cantidad_retorno']) != 0){

                    $retorno_sum = $rowExtra['cantidad_retorno']." on return";

                }else{

                    $retorno_sum = $rowExtra['cantidad_ida']." on departure";

                }

                $contenido_correo.= '<tr>

                                        <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$rowExtra['n_extra'].'</td>

                                        <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$retorno_sum.'</td>

                                        <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$rowExtra['precio'].'</td>

                                      </tr>';   

            }

            $contenido_correo.= '<tr>   

                                        <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">Total Extras:</td>

                                        <td></td>

                                        <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row2['suma'].',00 '.$paypalSQL['tipo_moneda'].'</td>

                                      </tr>';   

            $contenido_correo.= '</tbody></table>';

            }//end if extras

            $contenido_correo.='

              <div style="" align="center">

              <table class="s-3 w-100" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">

          <tbody>

            <tr>

              <td height="16" style="border-spacing: 0px; border-collapse: collapse; line-height: 16px; font-size: 16px; width: 100%; height: 16px; margin: 0;" align="left">

                 

              </td>

            </tr>

          </tbody>

        </table>

        <table class="alert alert-success " border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: separate !important; width: 100%; border: 0;">

          <tbody>

            <tr>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; border-radius: 4px; color: #0a2c12; margin: 0; padding: 12px 20px; border: 1px solid transparent;" align="left" bgcolor="#afecbd">

                <div style="text-align:center;">

          PAGADO EN EFECTIVO<br>

		  <b>RECUERDE pagar en efectivo con '.$paypalSQL['tipo_moneda'].' a su llegada a nuestro operador</b>

		</div>

		      </td>

		    </tr>

		  </tbody>

		</table>



		        </div>

		    

		              </td>

		            </tr>

		          </tbody>

		        </table>

		        <!--[if (gte mso 9)|(IE)]>

		                </td>

		              </tr>

		            </tbody>

		          </table>

		        <![endif]-->

		      </td>

		    </tr>

		  </tbody>

		</table>

		      </td>

		    </tr>

    

		  </tbody>

		</table>

		





<table class="s-4 w-100" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">

<thead>

  <tr>

     <th><img src="https://taxiaeropuertodecancun.com/images/operator.jpeg" alt="transfers private cancun"  width="150" height="200"></th>

    <td colspan="2">Estaremos encantados de brindarle información adicional sobre servicios y actividades.

Su reserva se ha completado; puede cancelar su reserva hasta 3 días antes del servicio con una multa del 10%. No habrá reembolso por cancelaciones el mismo día de servicio.

A su llegada a CUN (Aeropuerto Internacional de Cancún), siga estas recomendaciones para garantizar un acceso fácil y rápido a su vehículo.

 </td>

  </tr>

</thead>

<tbody>

  <tr>

    <tr><h3>POLITICAS</h3> </tr>

    <td colspan="2"><b>SALIDAS</b>: Para vuelos internacionales debe estar en el aeropuerto al menos 3:00 horas antes de su hora de salida, en el caso de vuelos nacionales el mínimo es 2 horas antes de su hora de salida.<br>

<b>Cancun Shuttle Airport</b> no será responsable de ningún inconveniente o pérdida del vuelo en caso de que decida llegar más tarde de la hora sugerida. El conductor lo esperará hasta 15 minutos en el Lobby de su hotel, después de ese tiempo el vehículo saldrá del hotel sin responsabilidad por Cancun Shuttle Airport " no se aplican reembolsos si esto sucede.<br>

A continuación, encontrará información importante sobre los servicios de transporte que ha concertado con nosotros: <br>

<ul><li>Cancun Shuttle Airport TM es una empresa legalmente establecida con los más altos estándares de calidad y servicio y le brinda un servicio sin preocupaciones desde y hacia el aeropuerto. </li>

    <li> Puede cancelar su reserva hasta 4 días antes del servicio con una multa del 10%. No habrá reembolsos por cancelaciones hechas 3 días o menos antes del servicio.</li>

    <li>Para cancelaciones, avísenos con al menos 3 días de anticipación. Para modificaciones o actualizaciones de reservas, debe comunicarse con nuestro departamento de reservas por teléfono, correo electrónico o chat. Los conductores no son responsables de notificaciones o modificaciones a las reservas.</li>

    <li>Nuestros Contactos:</li>

  <li> Staff en el aeropuerto (llegadas): +52 998 110 5994 o Office phone: +52 998 354 5838 OR +52 998 241 6255</li> 

  <li>LUN to VIE: de 9:00 AM a 11:00 PM o SAB y DOM: de 9:00 AM a 7:00 PM</li>

  </td>

  </tr>

</tbody>

</table>





        </body>

        </html>

';

        



            if(mail($email_destinatario,utf8_decode("TaxiAeropuertodeCancun"),$contenido_correo,$header)){

            $respuestas = "Correo enviado con &eacute;xito a: ".$nombre_destinatario." ".$email_destinatario."<br>";

        }

        else{

            $respuesta = "<font color='red'>No se pudo enviar el correo a:  ".$nombre_destinatario." ".$email_destinatario."</font><br>";

        }

    }else{

        $LOG_STRING .="\n IPN LANG: EN";

        $contenido_correo= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

        <html xmlns="http://www.w3.org/1999/xhtml">

          <head>



            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

            

                  <style type="text/css">

                  .ExternalClass{width:100%}.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:150%}a{text-decoration:none}body,td,input,textarea,select{margin:unset;font-family:unset}input,textarea,select{font-size:unset}@media screen and (max-width: 600px){table.row th.col-lg-1,table.row th.col-lg-2,table.row th.col-lg-3,table.row th.col-lg-4,table.row th.col-lg-5,table.row th.col-lg-6,table.row th.col-lg-7,table.row th.col-lg-8,table.row th.col-lg-9,table.row th.col-lg-10,table.row th.col-lg-11,table.row th.col-lg-12{display:block;width:100% !important}.d-mobile{display:block !important}.d-desktop{display:none !important}.w-lg-25{width:auto !important}.w-lg-25>tbody>tr>td{width:auto !important}.w-lg-50{width:auto !important}.w-lg-50>tbody>tr>td{width:auto !important}.w-lg-75{width:auto !important}.w-lg-75>tbody>tr>td{width:auto !important}.w-lg-100{width:auto !important}.w-lg-100>tbody>tr>td{width:auto !important}.w-lg-auto{width:auto !important}.w-lg-auto>tbody>tr>td{width:auto !important}.w-25{width:25% !important}.w-25>tbody>tr>td{width:25% !important}.w-50{width:50% !important}.w-50>tbody>tr>td{width:50% !important}.w-75{width:75% !important}.w-75>tbody>tr>td{width:75% !important}.w-100{width:100% !important}.w-100>tbody>tr>td{width:100% !important}.w-auto{width:auto !important}.w-auto>tbody>tr>td{width:auto !important}.p-lg-0>tbody>tr>td{padding:0 !important}.pt-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-top:0 !important}.pr-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-right:0 !important}.pb-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-bottom:0 !important}.pl-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-left:0 !important}.p-lg-1>tbody>tr>td{padding:0 !important}.pt-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-top:0 !important}.pr-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-right:0 !important}.pb-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-bottom:0 !important}.pl-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-left:0 !important}.p-lg-2>tbody>tr>td{padding:0 !important}.pt-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-top:0 !important}.pr-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-right:0 !important}.pb-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-bottom:0 !important}.pl-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-left:0 !important}.p-lg-3>tbody>tr>td{padding:0 !important}.pt-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-top:0 !important}.pr-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-right:0 !important}.pb-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-bottom:0 !important}.pl-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-left:0 !important}.p-lg-4>tbody>tr>td{padding:0 !important}.pt-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-top:0 !important}.pr-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-right:0 !important}.pb-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-bottom:0 !important}.pl-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-left:0 !important}.p-lg-5>tbody>tr>td{padding:0 !important}.pt-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-top:0 !important}.pr-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-right:0 !important}.pb-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-bottom:0 !important}.pl-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-left:0 !important}.p-0>tbody>tr>td{padding:0 !important}.pt-0>tbody>tr>td,.py-0>tbody>tr>td{padding-top:0 !important}.pr-0>tbody>tr>td,.px-0>tbody>tr>td{padding-right:0 !important}.pb-0>tbody>tr>td,.py-0>tbody>tr>td{padding-bottom:0 !important}.pl-0>tbody>tr>td,.px-0>tbody>tr>td{padding-left:0 !important}.p-1>tbody>tr>td{padding:4px !important}.pt-1>tbody>tr>td,.py-1>tbody>tr>td{padding-top:4px !important}.pr-1>tbody>tr>td,.px-1>tbody>tr>td{padding-right:4px !important}.pb-1>tbody>tr>td,.py-1>tbody>tr>td{padding-bottom:4px !important}.pl-1>tbody>tr>td,.px-1>tbody>tr>td{padding-left:4px !important}.p-2>tbody>tr>td{padding:8px !important}.pt-2>tbody>tr>td,.py-2>tbody>tr>td{padding-top:8px !important}.pr-2>tbody>tr>td,.px-2>tbody>tr>td{padding-right:8px !important}.pb-2>tbody>tr>td,.py-2>tbody>tr>td{padding-bottom:8px !important}.pl-2>tbody>tr>td,.px-2>tbody>tr>td{padding-left:8px !important}.p-3>tbody>tr>td{padding:16px !important}.pt-3>tbody>tr>td,.py-3>tbody>tr>td{padding-top:16px !important}.pr-3>tbody>tr>td,.px-3>tbody>tr>td{padding-right:16px !important}.pb-3>tbody>tr>td,.py-3>tbody>tr>td{padding-bottom:16px !important}.pl-3>tbody>tr>td,.px-3>tbody>tr>td{padding-left:16px !important}.p-4>tbody>tr>td{padding:24px !important}.pt-4>tbody>tr>td,.py-4>tbody>tr>td{padding-top:24px !important}.pr-4>tbody>tr>td,.px-4>tbody>tr>td{padding-right:24px !important}.pb-4>tbody>tr>td,.py-4>tbody>tr>td{padding-bottom:24px !important}.pl-4>tbody>tr>td,.px-4>tbody>tr>td{padding-left:24px !important}.p-5>tbody>tr>td{padding:48px !important}.pt-5>tbody>tr>td,.py-5>tbody>tr>td{padding-top:48px !important}.pr-5>tbody>tr>td,.px-5>tbody>tr>td{padding-right:48px !important}.pb-5>tbody>tr>td,.py-5>tbody>tr>td{padding-bottom:48px !important}.pl-5>tbody>tr>td,.px-5>tbody>tr>td{padding-left:48px !important}.s-lg-1>tbody>tr>td,.s-lg-2>tbody>tr>td,.s-lg-3>tbody>tr>td,.s-lg-4>tbody>tr>td,.s-lg-5>tbody>tr>td{font-size:0 !important;line-height:0 !important;height:0 !important}.s-0>tbody>tr>td{font-size:0 !important;line-height:0 !important;height:0 !important}.s-1>tbody>tr>td{font-size:4px !important;line-height:4px !important;height:4px !important}.s-2>tbody>tr>td{font-size:8px !important;line-height:8px !important;height:8px !important}.s-3>tbody>tr>td{font-size:16px !important;line-height:16px !important;height:16px !important}.s-4>tbody>tr>td{font-size:24px !important;line-height:24px !important;height:24px !important}.s-5>tbody>tr>td{font-size:48px !important;line-height:48px !important;height:48px !important}}@media yahoo{.d-mobile{display:none !important}.d-desktop{display:block !important}.w-lg-25{width:25% !important}.w-lg-25>tbody>tr>td{width:25% !important}.w-lg-50{width:50% !important}.w-lg-50>tbody>tr>td{width:50% !important}.w-lg-75{width:75% !important}.w-lg-75>tbody>tr>td{width:75% !important}.w-lg-100{width:100% !important}.w-lg-100>tbody>tr>td{width:100% !important}.w-lg-auto{width:auto !important}.w-lg-auto>tbody>tr>td{width:auto !important}.p-lg-0>tbody>tr>td{padding:0 !important}.pt-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-top:0 !important}.pr-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-right:0 !important}.pb-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-bottom:0 !important}.pl-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-left:0 !important}.p-lg-1>tbody>tr>td{padding:4px !important}.pt-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-top:4px !important}.pr-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-right:4px !important}.pb-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-bottom:4px !important}.pl-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-left:4px !important}.p-lg-2>tbody>tr>td{padding:8px !important}.pt-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-top:8px !important}.pr-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-right:8px !important}.pb-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-bottom:8px !important}.pl-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-left:8px !important}.p-lg-3>tbody>tr>td{padding:16px !important}.pt-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-top:16px !important}.pr-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-right:16px !important}.pb-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-bottom:16px !important}.pl-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-left:16px !important}.p-lg-4>tbody>tr>td{padding:24px !important}.pt-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-top:24px !important}.pr-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-right:24px !important}.pb-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-bottom:24px !important}.pl-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-left:24px !important}.p-lg-5>tbody>tr>td{padding:48px !important}.pt-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-top:48px !important}.pr-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-right:48px !important}.pb-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-bottom:48px !important}.pl-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-left:48px !important}.s-lg-0>tbody>tr>td{font-size:0 !important;line-height:0 !important;height:0 !important}.s-lg-1>tbody>tr>td{font-size:4px !important;line-height:4px !important;height:4px !important}.s-lg-2>tbody>tr>td{font-size:8px !important;line-height:8px !important;height:8px !important}.s-lg-3>tbody>tr>td{font-size:16px !important;line-height:16px !important;height:16px !important}.s-lg-4>tbody>tr>td{font-size:24px !important;line-height:24px !important;height:24px !important}.s-lg-5>tbody>tr>td{font-size:48px !important;line-height:48px !important;height:48px !important}}



                </style>

        </head>

          <body style="outline: 0; width: 100%; min-width: 100%; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 24px; font-weight: normal; font-size: 16px; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; color: #000000; margin: 0; padding: 0; border: 0;" bgcolor="#ffffff">

        <table valign="top" class="bg-light body" style="outline: 0; width: 100%; min-width: 100%; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 24px; font-weight: normal; font-size: 16px; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; color: #000000; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; margin: 0; padding: 0; border: 0;" bgcolor="#f8f9fa">

          <tbody>

            <tr>

              <td valign="top" style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; margin: 0;" align="left" bgcolor="#f8f9fa">

                

            <table class="container" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%;">

          <tbody>

            <tr>

              <td align="center" style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; margin: 0; padding: 0 16px;">

                <!--[if (gte mso 9)|(IE)]>

                  <table align="center">

                    <tbody>

                      <tr>

                        <td width="600">

                <![endif]-->

                <table align="center" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%; margin: 0 auto;">

                  <tbody>

                    <tr>

                      <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; margin: 0;" align="left">

                        

           <div style="background-color: #33a5ff;">';

      $contenido_correo.='<img src="https://taxiaeropuertodecancun.com/images/logocancuntransportation.jpg" width="130" height="30" style="height: auto; line-height: 100%; outline: none; text-decoration: none; border: 0 none;">

        <h3 style="float: right; padding-top: 20px; padding-right: 10px; color: #fff; margin-top: 0; margin-bottom: 0; font-weight: 500; vertical-align: baseline; font-size: 22px; line-height: 38.4px;" align="left">

        Hi, '.$nombre_destinatario.'!

        </h3>

        </div>

        <table class="s-4 w-100" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">

          <tbody>

            <tr>

              <td height="24" style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 24px; width: 100%; height: 24px; margin: 0;" align="left">

                 

              </td>

            </tr>

          </tbody>

        </table>



        <div class="">

        <p style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left">

        ¡Looking for the logo is easier than looking for your name among the whole crowd!</p>



        <p style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left">Thank you for trusting Cancun Transportation™ with your Cancun and Riviera Maya transportation services.</p>



        <p style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left">Your reservation details are below. If any information below is not correct, please contact us immediately with the correction. Upon arrival to the airport is very important that you carefully read our suggestions for a faster and safer access to your transportation.</p>



        <p class="text-primary" style="line-height: 24px; font-size: 16px; width: 100%; color: #007bff; margin: 0;" align="left"><strong>REMEMBER TO PRINT AND BRING THIS VOUCHER WITH YOU AND PRESENT IT TO OUR WELCOMING STAFF AT THE AIRPORT.

        </strong></p>

        </div>

        <table class="s-3 w-100" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">

          <tbody>

            <tr>

              <td height="16" style="border-spacing: 0px; border-collapse: collapse; line-height: 16px; font-size: 16px; width: 100%; height: 16px; margin: 0;" align="left">

                 

              </td>

            </tr>

          </tbody>

        </table>



        <div class="">

        <span>Your confirmation code is: <b>CT0000000'.$id_reservacion.'</b></span>

        <span style="float: right;">TOTAL + 9% commission: <b>'.$suma_total.' '.$paypalSQL['tipo_moneda'].'</b></span>

        </div>

        <table class="s-4 w-100" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">

          <tbody>

            <tr>

              <td height="24" style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 24px; width: 100%; height: 24px; margin: 0;" align="left">

                 

              </td>

            </tr>

          </tbody>

        </table>



        <table class="table " border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%; max-width: 100%;">

          <thead>

            <tr>

              <th width="25%" style="line-height: 24px; border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">TRANSFER</th>

              <th width="25%" style="line-height: 24px; border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">SERVICE</th>

              <th width="25%" style="line-height: 24px; border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">VEHICLE</th>

              <th width="25%" style="line-height: 24px; border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">PASSENGER(S)</th>

            </tr>

          </thead>

          <tbody>

            <tr>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$transfer_type.'</td>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">Private</td>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['transporte'].'</td>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['cantidad_personas'].'</td>

            </tr>

          </tbody>

        </table>

        <table class="table" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%; max-width: 100%;">

          <thead>

            <tr>

              <th width="50%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">HOTEL</th>

              <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">ARRIVAL DATE</th>

              <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">DEPARTURE TIME</th>

            </tr>

          </thead>

          <tbody>

            <tr>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$transfer.'</td>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['fecha_ida'].'</td>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['fecha_regreso'].'</td>

            </tr>

          </tbody>

        </table>

        <table class="table" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%; max-width: 100%;">

          <thead>

            <tr>

              <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">FLYING FROM</th>

              <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">AIRLINE</th>

              <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">FLIGHT NUMBER</th>

              <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">PAYPAL TRANSACTION</th>

            </tr>

          </thead>

          <tbody>

            <tr>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$aerolineaArray[0].'</td>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$aerolineaArray[1].'</td>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$aerolineaArray[2].'</td>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['transaccion_paypal'].'</td>

            </tr>

          </tbody>

        </table>

        <table class="table" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%; max-width: 100%;">

          <thead>

            <tr>

              <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">FULLNAME</th>

              <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">EMAIL</th>

              <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">PHONE</th>

              <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">COUNTRY</th>

            </tr>

          </thead>

          <tbody>

            <tr>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['nombre_p'].'</td>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['email_p'].'</td>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['telefono_p'].'</td>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['pais_p'].'</td>

            </tr>

          </tbody>

        </table>

        <table class="table" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%; max-width: 100%;">

          <thead>

            <tr>

            <th style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">PICKUP TIME</th>

              <th style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">COMMENTS</th>

            </tr>

          </thead>

          <tbody>

            <tr>

            <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['pickup_hour'].':'.$row['pickup_minute'].' '.$pmam.'</td>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['comments'].'</td>

            </tr>

          </tbody>

        </table>';

                if($rowCantidad['cantidad'] != 0){

                $contenido_correo.= '

              <div style="color: #fff; background-color: #33a5ff; padding: 15px;">

                <h5 style="margin-top: 0; margin-bottom: 0; font-weight: 500; vertical-align: baseline; font-size: 20px; line-height: 24px;" align="left">Extras:</h5>

              </div>

              <table class="table" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%; max-width: 100%;">

          <thead>

            <tr>

              <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">NAME</th>

              <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">QUANTITY</th>

              <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">UNIT PRICE</th>

            </tr>

          </thead>

          <tbody>';

            $retorno_sum = "";                    

            while($rowExtra = mysqli_fetch_array($respuesta6)){



                if(intval($rowExtra['cantidad_retorno']) != 0 && intval($rowExtra['cantidad_ida']) != 0){

                    $retorno_sum = $rowExtra['cantidad_ida']." on departure And ".$rowExtra['cantidad_retorno']." on return";

                }elseif(intval($rowExtra['cantidad_retorno']) != 0){

                    $retorno_sum = $rowExtra['cantidad_retorno']." on return";

                }else{

                    $retorno_sum = $rowExtra['cantidad_ida']." on departure";

                }

                $contenido_correo.= '<tr>

                                        <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$rowExtra['n_extra'].'</td>

                                        <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$retorno_sum.'</td>

                                        <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$rowExtra['precio'].'</td>

                                      </tr>';   

            }

            $contenido_correo.= '<tr>   

                                        <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">Total Extras:</td>

                                        <td></td>

                                        <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row2['suma'].',00 '.$paypalSQL['tipo_moneda'].'</td>

                                      </tr>';   

            $contenido_correo.= '</tbody></table>';

            }//end if extras

            $contenido_correo.='

              <div style="" align="center">

              <table class="s-3 w-100" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">

          <tbody>

            <tr>

              <td height="16" style="border-spacing: 0px; border-collapse: collapse; line-height: 16px; font-size: 16px; width: 100%; height: 16px; margin: 0;" align="left">

                 

              </td>

            </tr>

          </tbody>

        </table>

        <table class="alert alert-success " border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: separate !important; width: 100%; border: 0;">

          <tbody>

            <tr>

              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; border-radius: 4px; color: #0a2c12; margin: 0; padding: 12px 20px; border: 1px solid transparent;" align="left" bgcolor="#afecbd">

                <div style="text-align:center;">

          PAID IN CASH<br>

          <b>Please REMEMBER to pay in cash with '.$paypalSQL['tipo_moneda'].' at you Arrival to our Driver</b>

        </div>

              </td>

            </tr>

          </tbody>

        </table>



		        </div>

		    

		              </td>

		            </tr>

		          </tbody>

		        </table>

		        <!--[if (gte mso 9)|(IE)]>

		                </td>

		              </tr>

		            </tbody>

		          </table>

		        <![endif]-->

		      </td>

		    </tr>

		  </tbody>

		</table>

		      </td>

		    </tr>

    

		  </tbody>

		</table>

		





<table class="s-4 w-100" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">

<thead>

  <tr>

     <th><img src="https://taxiaeropuertodecancun.com/images/operator.jpeg" alt="transfers private cancun"  width="150" height="200"></th>

    <td colspan="2">We will be happy to provide you with additional information about services and activities.

Your reservation has been completed; you may cancel your reservation up to 3 days prior to service with a 10% penalty fee. There will be no refund for cancellations on the same day of service.

Upon arrival to CUN (Cancun International Airport) please follow these recommendations to ensure an easy and fast access to your vehicle.

 </td>

  </tr>

</thead>

<tbody>

  <tr>

    <tr><h3>POLICES</h3> </tr>

    <td colspan="2"><b>Departures</b>: For international flights you need to be at the airport at least 3:00 hours prior to your departure time, in the case of national flights the minimum is 2 hours prior to your departure time.<br>

<b>Cancun Shuttle Airport</b> will not be responsible for any inconvenience or flight loss in case you decide to arrive later than the suggested time. The driver will wait up to 15 minutes for you at your hotel Lobby, after that time the vehicle will leave the hotel with no responsibility for Cancun Transportation " no refunds are applicable if this happens.<br>

Below you will find important information regarding the transportation services you have arranged with us:<br>

<ul><li>Cancun Shuttle Airport TM is a legally established company with the highest quality & service standards and provides you with a worry-free service from and to the airport.</li>

    <li>You may cancel your reservation up to 4 days prior to service with a 10% penalty fee. There will be no refunds for cancelations made 3 days or less prior to service. </li>

    <li>For cancellations please let us know at least 3 days in advance. For reservation modifications or updates, you must contact our reservations department by phone, email or chat. Drivers are not responsible for notifications or modifications to reservations.</li>

    <li>Our contacts:</li>

  <li> Staff at the airport (arrivals): +52 998 110 5994 o Office phone: +52 998 354 5838 OR +52 998 241 6255</li> 

  <li>MON to FRI: From 9:00 AM to 11:00 PM o SAT to SUN: From 9:00 AM to 7:00 PM</li>

  </td>

  </tr>

</tbody>

</table>





        </body>

        </html>

';

            



                if(mail($email_destinatario,utf8_decode("Taxiaeropuertodecancun Ticket"),$contenido_correo,$header)){

                $respuestas = "Correo enviado con &eacute;xito a: ".$nombre_destinatario." ".$email_destinatario."<br>";

            }

            else{

                $respuesta = "<font color='red'>No se pudo enviar el correo a:  ".$nombre_destinatario." ".$email_destinatario."</font><br>";

            }

    }

    

        

      mail("delfo2332@hotmail.com",utf8_decode("Taxiaeropuertodecancun Ticket Reservation"),$contenido_correo,$header);

        mail("antonicross@gmail.com",utf8_decode("taxiaeropuertodecancun Ticket Reservation"),$contenido_correo,$header);

        mail("ditaguirre@gmail.com",utf8_decode("taxiaeropuertodecancun Ticket Reservation"),$contenido_correo,$header);

}

file_put_contents('ipn.log',$LOG_STRING, FILE_APPEND);

