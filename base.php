<?php

$conexion = mysqli_connect("localhost","canczdhg_taxiaeropuerto","A;2FE+fi","canczdhg_taxiaeropuerto");
 
$sql = "ALTER TABLE reservaciones ADD COLUMN Total_comision decimal(10,2)" ; 

$respuesta = mysqli_query($conexion,$sql);

if( $respuesta ) {
    echo "Connection established.<br />";
}else{
    echo "Connection could not be established.<br />";
}

?>