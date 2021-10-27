<?php

require_once('../db/conexion.php');

if (isset($_GET['idreservation'])) {

	$sql = "UPDATE extra_reservaciones SET cantidad_ida=0 ,cantidad_retorno=0 WHERE id_reservacion=".$_GET['idreservation']." AND id_extra=".$_GET['idextra'].";";
	
	if(mysqli_query($conexion,$sql)){
		$_GET['id'] = $_GET['idreservation'];
		require('./extras_reservacion.php');
	}

}