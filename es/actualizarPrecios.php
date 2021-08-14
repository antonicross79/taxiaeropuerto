<?php

	$conexion = mysqli_connect("localhost","canczdhg_taxiaeropuerto","A;2FE+fi","canczdhg_taxiaeropuerto");


if ($conexion -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

$strJsonFileContents = file_get_contents("./tabla6.json");
$array = json_decode($strJsonFileContents, true);
foreach ($array as $key) {
	$sql = "call updatePrices($key[3], $key[4], $key[5], $key[6], $key[7], $key[8], $key[9], $key[10], '$key[1]')";

	if ($conexion->query($sql) === TRUE) {
	  echo "Precio actualizado";
	} else {
	  echo "Error actualizando precio: " . $conn->error;
	  echo "Consulta: ".$sql;
	}
}