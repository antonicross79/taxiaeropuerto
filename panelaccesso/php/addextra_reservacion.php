<?php

require_once('../db/conexion.php');

if (isset($_GET['idreservation'])) {

	$sql = "SELECT id_reservacion FROM extra_reservaciones WHERE id_extra=".$_GET['idextra'];
	
	$result = mysqli_query($conexion,$sql);



	if($result->num_rows != 0){
		$sql = "UPDATE extra_reservaciones SET cantidad_ida=".$_GET['cantida']." ,cantidad_retorno=".$_GET['cantret']." WHERE id_reservacion=".$_GET['idreservation']." AND id_extra=".$_GET['idextra'].";";
	
		if(mysqli_query($conexion,$sql)){
			$_GET['id'] = $_GET['idreservation'];
			require('./extras_reservacion.php');
		}	
	}else{
		$sql = "INSERT INTO extra_reservaciones SET cantidad_ida=".$_GET['cantida']." ,cantidad_retorno=".$_GET['cantret'].", id_reservacion=".$_GET['idreservation'].", id_extra=".$_GET['idextra'].";";
	
		if(mysqli_query($conexion,$sql)){
			$_GET['id'] = $_GET['idreservation'];
			require('./extras_reservacion.php');
		}	
	}

	

}