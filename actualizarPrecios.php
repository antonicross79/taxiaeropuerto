<?php
$conexion = mysqli_connect("localhost","canczdhg_taxiaeropuerto","A;2FE+fi","canczdhg_taxiaeropuerto");


if ($conexion -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

$strJsonFileContents = file_get_contents("./tabla6taxi.json");
$List = json_decode($strJsonFileContents, true);
foreach ($List as $array) {
	foreach ($array as $key) {

		$sql = "call updatePrices(".$key['1-8 PAX ONE AWAY'].", ".$key['1-8 PAX ROUND TRIP'].", ".$key['9-16 PAX ONE AWAY'].", ".$key['9-16 PAX ROUND TRIP'].", ".$key['1-16 GRUPO ONE AWAY'].", ".$key['1-16 GRUPO ROUND TRIP'].", ".$key['1-16 SUBURBAN ONE AWAY'].", ".$key['1-16 SUBURBAN ROUND TRIP'].", '".str_replace("'", "`",$key['CANCUN'] )."')";
		echo $sql;echo "<br>";
		if ($conexion->query($sql) === TRUE) {
		  echo "Precio actualizado";
		} else {
		  echo "Error actualizando precio: " . $conn->error;
		  echo "Consulta: ".$sql;
		}
	}
}