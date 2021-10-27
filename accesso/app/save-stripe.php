<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../db/conexion.php');

$sql = "SELECT * FROM stripe";

$res = mysqli_query($conexion,$sql);

$count = mysqli_num_rows($res);

if($count > 0){
	$sql = "UPDATE stripe set secret_key='".$_POST['private_key']."', publishable_key='".$_POST['publishable_key']."', currency='".$_POST['currency']."'";	
}else{
	$sql = "INSERT INTO stripe set secret_key='".$_POST['private_key']."', publishable_key='".$_POST['publishable_key']."', currency='".$_POST['currency']."'";	
}



if($respuesta = mysqli_query($conexion,$sql)){
	echo "Actualizado";
}else{
	echo "No Actualizado";
}

?>