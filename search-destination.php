<?php

$destino_1 = $_GET['q'];

	$conexion = mysqli_connect("localhost","canczdhg_taxiaeropuerto","A;2FE+fi","canczdhg_taxiaeropuerto");
	
$sql = "SELECT * FROM ubicaciones WHERE n_ubicacion LIKE '%".$destino_1."%'";

$respuesta = mysqli_query($conexion,$sql);
?>
<ul class="list-group">
<?php
while ($row = mysqli_fetch_array($respuesta)) {
	$destino = $row['n_ubicacion'];
	$destinox = $row['n_zona'];
	$id = $row['id_ubicacion'];
	?>
	<a href="#" class="list-group-item list-group-item-action" onclick="return selectDestination('<?php echo $destino ; ?>')"><?php echo $destino , "&nbsp;" .$destinox; ?></li>
	<?php
}

?>
</ul>