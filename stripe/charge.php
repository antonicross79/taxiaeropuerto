<?php

session_start();
require_once('../accesso/db/conexion.php');
require_once('config.php');


$token = $_POST['stripeToken'];
$email = $_POST['stripeEmail'];
$product_price = $_SESSION['product_price'];
$product_name = $_SESSION['product_name'];

 
$customer = \Stripe\Customer::create([
  'email' => $email,
  'source'  => $token,
]);
 
$charge = \Stripe\Charge::create([
  'customer' => $customer->id,
  'amount'   => $product_price*100,
  'currency' => 'mxn',
  "description" => $product_name,
]);

$id_reservacion = $_SESSION['id_reservacion'];

$sql2 = "UPDATE reservaciones SET transaccion_stripe='".$charge->id."' WHERE id_reservacion=".$id_reservacion;


$respuesta2 = mysqli_query($conexion,$sql2);
$sql = "SELECT * FROM reservaciones WHERE id_reservacion =".$id_reservacion;
$respuesta = mysqli_query($conexion,$sql);
$row = mysqli_fetch_array($respuesta);


$sql = "SELECT sum(precio*(cantidad_ida+cantidad_retorno)) suma FROM `extra_reservaciones` er join `extras` ex on(ex.id_extra=er.id_extra) where (cantidad_ida != 0 || cantidad_retorno != 0) group by id_reservacion having id_reservacion=".$id_reservacion;

$respuesta6 = mysqli_query($conexion,$sql);
$row2 = mysqli_fetch_array($respuesta6);

$sql = "SELECT count(*) cantidad FROM extras AS ex JOIN extra_reservaciones er ON(er.id_extra=ex.id_extra) WHERE er.id_reservacion=".$id_reservacion." AND (cantidad_ida != 0 || cantidad_retorno != 0)";

$respuesta3= mysqli_query($conexion,$sql);
$rowCantidad = mysqli_fetch_array($respuesta3);

$sql = "SELECT * FROM extras AS ex JOIN extra_reservaciones er ON(er.id_extra=ex.id_extra) WHERE er.id_reservacion=".$id_reservacion." AND (cantidad_ida != 0 || cantidad_retorno != 0)";

$respuesta6= mysqli_query($conexion,$sql);




    // Cabeceras para el correo
    $header = "Content-Type: text/html; charset=utf-8\n";
    $header.= "From: Taxiaeropuertodecancun<no-responder@taxiaeropuertodecancun.com>";
    
    // Servidor SMTP
    ini_set("SMTP","smtp.gmail.com");
    
    
    $email_destinatario = $row['email_p'];
    $nombre_destinatario = $row['nombre_p'];
    $suma_total = intval($row['total'])+intval($row2['suma']);
    $aerolineaArray = explode(',', $row['aerolinea']);
    switch ($row['modo_viaje']) {
        case 1:
            $transfer_type.= "Round Trip - Airport > Hotel > Airport";
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




      $contenido_correo.='<img src="https://taxiaeropuertodecancun.com/images/logocancuntransportation.jpg" width="130" height="40" style="height: auto; line-height: 100%; outline: none; text-decoration: none; border: 0 none;">
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
        <span style="float: right;">TOTAL: <b>'.$suma_total.',00 MXN</b></span>
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
              <th style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">STRIPE TRANSACCIÓN ID</th>
            </tr>
          </thead>
          <tbody>
            <tr>
            <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['pickup_hour'].':'.$row['pickup_minute'].' '.$pmam.'</td>
              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['comments'].'</td>
              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['transaccion_stripe'].'</td>
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
                                        <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row2['suma'].',00 MXN</td>
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
		  <b>RECUERDE pagar en efectivo con MXN o USD a su llegada a nuestro operador</b>
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
        
            if(mail($email_destinatario,utf8_decode("Taxiaeropuertodecancun Ticket"),$contenido_correo,$header)){


            $respuestas = "Correo enviado con &eacute;xito a: ".$nombre_destinatario." ".$email_destinatario."<br>";

    
        }
        else{
            $respuesta = "<font color='red'>No se pudo enviar el correo a:  ".$nombre_destinatario." ".$email_destinatario."</font><br>";
        }
}else{
        $LOG_STRING .="\n IPN LANG: EN";
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
        <span style="float: right;">TOTAL: <b>'.$suma_total.',00 MXN</b></span>
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
              
              <th style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">STRIPE TRANSACCIÓN ID</th>
            </tr>
          </thead>
          <tbody>
            <tr>
            <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['pickup_hour'].':'.$row['pickup_minute'].' '.$pmam.'</td>
              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['comments'].'</td>
              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row['transaccion_stripe'].'</td>
              
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
                                        <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$row2['suma'].',00 MXN</td>
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
          PAID WITH STRIPE<br>
          <b>Please REMEMBER to pay in cash with MXN or USD at you Arrival to our Driver</b>
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


?>

<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="keywords" content="Private Transport and Car Hire HTML Template" />
	<meta name="description" content="Private Transport and Car Hire HTML Template">
	<meta name="author" content="themeenergy.com">
	
	<title>Booking step 3</title>
	
	<link rel="stylesheet" href="../css/theme-lblue.css" />
	<link rel="stylesheet" href="../css/fondo-gracias.css">
	<link rel="stylesheet" href="../css/style.css" />
	<link rel="stylesheet" href="../css/animate.css" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Raleway:400,500,600,700|Montserrat:400,700">
	<link rel="shortcut icon" href="../images/favicon.ico">
	
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="../css/styleslideshow.css" />
	<link rel="stylesheet" href="../css/whatsapp.css" />

	<style type="text/css">
  	.d-md-none{
  		display: none;
  	}
  </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
  <body>
    <!-- Header -->
        <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light d-md-none">
        <a class="navbar-brand" href="#">
          <img src="../images/logocancuntransportation3.jpg" width="200" alt="Cancun Shuttle Airport" />
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link" href="../index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../about.php">About Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../service.php">Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" href="../contact.php">Contact</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Language
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="../es/index.php">ESPANOL</a>
                <a class="dropdown-item" href="../index.php">INGLES</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>
    <header class="header d-none d-lg-block" role="banner">
      <div class="wrap">
        <!-- Logo -->
        <div class="logo">
           <a href="index.php" title="Transfers"><img src="../images/logocancuntransportation3.jpg" width="200" alt="Cancun Shuttle Airport" /></a> 
           
                    



        </div>
        
    
         
        <!-- //Logo -->
        
        <!-- Main Nav -->
        <nav role="navigation" class="main-nav">
          <ul>
            <li class="active"><a href="../index.php" title="">Home</a></li>
            <!-- <li><a href="destinations.html" title="Destinations">Destinations</a>
              <ul> 
                <li><a href="destination-single.html" title="Single destination">Single destination</a></li>
                
              </ul> -->
            <li><a href="../about.php" title="About us">About Us</a></li>
            
          
          
        
          <li><a href="../service.php" title="Services">Services</a></li>
          
          <!-- <li><a href="faq.php" title="faq">FAQ</a></li> -->
            
          
            <li><a href="../contact.php" title="Contact">Contact</a></li>
            
            
                <li><a href="#" title="idioma">Language</a>
            
            
                    <ul>    
                <li><a href="../es/index.php" title="Espanol">Espanol</a></li>
                
               <li><a href="../index.php" title="English">Ingles</a></li>
            </li>   
         </ul> 
            
            
                
               
             
            
          </ul> 
        </nav> 
        <!-- //Main Nav -->
      </div>
    </header>
    
  
    <!-- //Header -->
		<!-- //Header -->
	<!-- Main -->
	<main class="main" role="main">
		<!-- Page info -->
		<header class="site-title color">
			<div class="wrap">
				<div class="container">
					<h1>Thank you. Your booking is now confirmed. Check you Email</h1>
				</div>
			</div>
		</header>
		<!-- //Page info -->
		
		<div class="wrap">
			<div class="row">
				<div class="three-fourth">
				    <div class="fondo">
				        <br><br>
					<form class="box readonly">
						<center><h1>¡THANKS FOR YOUR PURCHASE!</h1><br>
						<h3>We send your reservation details to your email.
					    If you have not received your reservation confirmation email, please call us at <br><a href="https://api.whatsapp.com/send?phone=+529983545838"> +52 998 1105994</a></p> </h3><br>
					    
					    <a href="https://api.whatsapp.com/send?phone=+529983545838" target="_blank" ><img src="/images/whats2.png" alt="taxi cancun airport" width="250" hight="100"/></a> <br>
						
							<p></p><img src="/images/calidad.png" alt="transfers private cancun" width="200" heigth="200"> <p><br></p>
							
						<a href="https://taxiaeropuertodecancun.com">Go to HomePage</a>
					</form> </center>
					</div>
				</div>
				
				<!--- Sidebar -->
				<?php
				include "../sidebar.php"
				?>
				<!--- //Sidebar -->
			</div>
		</div>
	</main> 
	<!-- //Main -->
	
<!-- Footer -->

              <?php
				include "../footer.php";
				
				?>
		
	<!-- //Footer -->

	<!-- //Preloader -->

    <!-- jQuery -->
    <script src="../js/jquery.min.js"></script>
	<script src="../js/jquery.uniform.min.js"></script>
	<script src="../js/jquery.slicknav.min.js"></script>
	<script src="../js/wow.min.js"></script>
	<script src="../js/scripts.js"></script>
	
	<a href="https://api.whatsapp.com/send?phone=+529983545838" class="btn-wsp" target="_blank">
	<i class="fa fa-whatsapp icono"></i>
	</a>
	
  </body>
</html>