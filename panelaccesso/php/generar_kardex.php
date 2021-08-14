<?php
include_once('PDF.php');
require_once('../db/conexion.php');


$id = $_GET['id'];
$sql = "SELECT * FROM reservaciones AS res
                LEFT JOIN tipo_traslado AS t_tras ON t_tras.id_t_traslado = res.id_t_traslado
            WHERE id_reservacion=".$id;
$respuesta= mysqli_query($conexion,$sql);
$row = mysqli_fetch_array($respuesta);

$sql = "SELECT count(*) cantidad FROM extras AS ex JOIN extra_reservaciones er ON(er.id_extra=ex.id_extra) WHERE er.id_reservacion=".$id." AND (cantidad_ida != 0 || cantidad_retorno != 0)";
$respuesta2= mysqli_query($conexion,$sql);
$rowCantidad = mysqli_fetch_array($respuesta2);

$sql = "SELECT * FROM extras AS ex JOIN extra_reservaciones er ON(er.id_extra=ex.id_extra) WHERE er.id_reservacion=".$id." AND (cantidad_ida != 0 || cantidad_retorno != 0)";
$respuesta3= mysqli_query($conexion,$sql);

$sql = "SELECT sum(precio*(cantidad_ida+cantidad_retorno)) suma FROM `extra_reservaciones` er join `extras` ex on(ex.id_extra=er.id_extra) where (cantidad_ida != 0 || cantidad_retorno != 0) group by id_reservacion having id_reservacion=".$id;
$respuestaSuma= mysqli_query($conexion,$sql);
$rowSumaExtra = mysqli_fetch_array($respuestaSuma);


$pmam = intval($row['pickup_hour'])>12?'pm':'am';
$pickup_hour = intval($row['pickup_hour'])>12?intval($row['pickup_hour'])-12:$row['pickup_hour'];
$pickup_hour = intval($pickup_hour)<10?'0'.$pickup_hour:$pickup_hour;
$pickup_minute = intval($row['pickup_minute'])<10?'0'.$row['pickup_minute']:$row['pickup_minute'];

$datos[0] = $row['ubicacion_desde'];
$datos[1] = $row['ubicacion_hasta'];
$datos[2] = $row['n_traslado'];
$datos[3] = $row['nombre_p'];
$datos[4] = $row['email_p'];
$datos[5] = $row['cantidad_personas'];
$datos[6] = $row['direccion_p'];
$datos[7] = $row['codigo_p'];
$datos[8] = $row['transporte'];
$datos[9] = $row['aerolinea'];
$datos[10] = $row['telefono_p'];
$datos[11] = $pickup_hour.':'.$pickup_minute.' '.$pmam;
$datos[12] = $row['comments'];


$datos[0] = intval($row['modo_viaje']) < 3?'Airport':$row['ubicacion_desde'];
$datos[1] = intval($row['modo_viaje']) == 3?'Airport':$row['ubicacion_desde'];
if(intval($row['modo_viaje']) == 4){
    $datos[0] = $row['ubicacion_desde'];
    $datos[1] = $row['ubicacion_hasta'];
}


$datos2[0] = $row['total'];
$datos2[1] = $rowSumaExtra['suma']?$rowSumaExtra['suma']:0;
$datos2[2] = $row['total']+$datos2[1];

if ($row['tipo_pago'] == 'PAYPAL') {
    $titulos_t3 = array('Payment Methods','ID TRANSACTION');
    $datos3[0] = $row['tipo_pago'];
    $datos3[1] = $row['transaccion_paypal'];
}elseif($row['tipo_pago'] == 'Stripe'){
    $titulos_t3 = array('Payment Methods','ID TRANSACTION');
    $datos3[0] = $row['tipo_pago'];
    $datos3[1] = $row['transaccion_stripe'];
}
else{
    $titulos_t3 = array('Payment Methods');
    $datos3[0] = $row['tipo_pago'];
}


$fecha = $row['fecha_ida'];


//include_once('myDBC.php');
    //Se crea un objeto de PDF
    //Para hacer uso de los métodos

    $pdf = new PDF();
    $pdf->AddPage('P',array(170,120)); //Vertical, Carta
    $pdf->Titulo('Factura'); //Vertical, Carta
    $pdf->Confirmation('Confirmation: GST0000000'.$row['id_reservacion']); //Vertical, Carta
    $pdf->Fecha('Date: '.$fecha); //Vertical, Carta
    $pdf->Cajetin(); //Vertical, Carta
    if($rowCantidad['cantidad'] != 0){
        $titulos_t = array('From','To','Mode','Name','Email','Amount People','Addres','Zip Code','Transport','Airline and Arrival time','Phone','Hotel Pickup Time','Comments');
        $titulos_t3[] = ['Extras'];
    }else{
        $titulos_t = array('From','To','Mode','Name','Email','Amount People','Addres','Zip Code','Transport','Airline and Arrival time','Phone','Hotel Pickup Time','Comments');
    }
    $pdf->TitulosTabla($titulos_t); 
    $pdf->DatosTabla($datos);
    $titulos_t2 = array('Subtotal:','Extras:','Total:');
    if($rowCantidad['cantidad'] != 0){
        if(intval($row['modo_viaje']) == 1){
            $titulos_te = array('Nombre','Ida','Retorno', 'Costo Unit');    
            
            $datos_te = [];
            $posy = 0;
            $maxsize = 0; // the max width of a cell
            while($rowExtra = mysqli_fetch_array($respuesta3)){
                $datos_te[] = [$rowExtra['n_extra'],$rowExtra['cantidad_ida'],$rowExtra['cantidad_retorno'],$rowExtra['precio']];
                $maxsize = strlen($rowExtra['n_extra']) > $maxsize?strlen($rowExtra['n_extra']):$maxsize;
                //$pdf->DatosTablaExtras($datos_te,$posy);
                $posy += 2;
            }
            //$pdf->TitulosTablaExtras($titulos_te,$maxsize);
            $pdf->BasicTable($titulos_te,$datos_te,true);
        }else{
            $titulos_te = array('Nombre','Cantidad','Costo Unit');    
            
            $datos_te = [];
            $posy = 0;
            $maxsize = 0; // the max width of a cell
            while($rowExtra = mysqli_fetch_array($respuesta3)){
                $datos_te[] = [$rowExtra['n_extra'],$rowExtra['cantidad_ida'],$rowExtra['precio']];
                $maxsize = strlen($rowExtra['n_extra']) > $maxsize?strlen($rowExtra['n_extra']):$maxsize;
                //$pdf->DatosTablaExtras($datos_te,$posy);
                $posy += 2;
            }
            //$pdf->TitulosTablaExtras($titulos_te);
            $pdf->BasicTable($titulos_te,$datos_te,false);
        }    
    }
    

    $pdf->TitulosTabla2($titulos_t2,115+$posy); 
    $pdf->DatosTabla2($datos2,115+$posy);
    $pdf->TitulosTabla3($titulos_t3); 
    $pdf->DatosTabla3($datos3);
    $pdf->Output(); //Salida al navegador del pdf
?>
