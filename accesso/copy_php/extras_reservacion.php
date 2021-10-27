<?php

require_once('../db/conexion.php');


if (isset($_GET['id'])) {
	$sql = "SELECT * FROM extras AS ex JOIN extra_reservaciones er ON(er.id_extra=ex.id_extra) JOIN categorias cat on(cat.id_categoria=categoria) WHERE er.id_reservacion=".$_GET['id']." AND (cantidad_ida != 0 || cantidad_retorno != 0)";
  $respuestaExtras = mysqli_query($conexion,$sql);

  $sql = "SELECT * FROM reservaciones WHERE id_reservacion=".$_GET['id'];
  $respuestaReservacion = mysqli_query($conexion,$sql);
  $reservacion = mysqli_fetch_array($respuestaReservacion);  

  if(intval($respuestaExtras->num_rows) != 0){
  	?>
  	<div class="card-body table-responsive p-0" style="height: 200px;">
      <table class="table table-striped" style="margin-bottom: 0;">
        <thead class="table table-head-fixed text-nowrap">
          <tr>
            <th width="30%">Nombre</th>
            <th width="10%">Descrip</th>
            <th >Precio</th>
            <th width="20%">Categoría</th>
            <th >Cant Ida</th>
            <?php 
            if($reservacion['modo_viaje'] == 1){
              ?>
              <th >Cant Ret</th>
              <?php
            }
            ?>
            
            <th width="20%">Acción</th>
          </tr>
        </thead>
        <tbody>
    <?php

    while($extrasRow = mysqli_fetch_array($respuestaExtras)){
      ?>
      
          <tr>
            <td><?php echo $extrasRow['n_extra']; ?></td>
            <td><?php echo $extrasRow['descri_extra']; ?></td>
            <td><?php echo $extrasRow['precio']; ?>,00 USD</td>
            <td><?php echo $extrasRow['nombre']; ?></td>
            <td><?php echo $extrasRow['cantidad_ida']; ?></td>
            <?php 
            if($reservacion['modo_viaje'] == 1){
              ?>
              <td><?php echo $extrasRow['cantidad_retorno']; ?></td>
              <?php
            }
            ?>
            <td><button onclick="return removeExtraFromReservation(<?php echo $extrasRow['id_extra']; ?>,<?php echo $_GET['id']; ?>)"class="btn-sm btn-danger"><i class="fas fa-minus"></i> Remove</button></td>
          </tr>   
      <?php
    }
    ?>
    </tbody>
  </table>
</div>
  	<?php
	}else{
		echo "There is no extras in this reservation";
	}
}