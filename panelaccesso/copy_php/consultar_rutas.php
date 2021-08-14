<?php

require_once('../db/conexion.php');

 $opcion = $_POST['opc'];

 if ($opcion == 1) {
    //$permisos = $_POST['permi'];
    $sql = "SELECT * FROM rutas AS rut
                LEFT JOIN tipo_traslado AS t_tras ON t_tras.id_t_traslado = rut.t_traslado
                LEFT JOIN ubicaciones AS ubi ON ubi.id_ubicacion = rut.id_p_llegada 
                GROUP BY n_ubicacion;
                ";
    $respuesta= mysqli_query($conexion,$sql);
    $output = '';
    $i =1;
    while($row = mysqli_fetch_array($respuesta))
    {
      
        $output .= '<tr style="text-align: center;">
                        <td>'.$i.'</td>
                        <td>'.utf8_encode($row['n_ubicacion']).'</td>
                        
                        <td>
                                        <button type="button" class="btn btn-block bg-gradient-success btn-xs" data-toggle="modal" data-target="#modal-xl" onclick="CargarVentanaVer(2,'.$row['id_p_llegada'].')"><i class="fas fa-eye"></i></button> 
                                        <button type="button" class="btn btn-block bg-gradient-info btn-xs" data-toggle="modal" data-target="#modal-lg" onclick="CargarVentanaModificar(2,'.$row['id_p_llegada'].')"><i class="fas fa-edit"></i></button>
                                        
                                    
                <button type="button" class="btn btn-block bg-gradient-danger btn-xs" onclick="EliminarTarifas(4,'.$row['id_p_llegada'].')"><i class="fas fa-trash"></i></button>   </td>';        
        $output .=  '</tr>'   ;                                                     
        $i++;              
    };

    echo $output;
 };

  if ($opcion == 2) {


    $id = $_POST['id'];
    //$permisos = $_POST['permi'];
    $sql = "SELECT * FROM rutas AS rut
                LEFT JOIN tipo_traslado AS t_tras ON t_tras.id_t_traslado = rut.t_traslado
                LEFT JOIN ubicaciones AS ubi ON ubi.id_ubicacion = rut.id_p_llegada
                LEFT JOIN transportes AS trans ON trans.id_transporte = rut.id_transporte  
                WHERE id_p_llegada=".$id;
   
    $respuesta= mysqli_query($conexion,$sql);
    $a = '';
    $b = '';

    while ($row = mysqli_fetch_array($respuesta)) {
      $nombre = $row['n_ubicacion'];
      if ($row['t_traslado'] == 1) {
        $a .= '<div class="form-group">
                            <label for="ubi1">Transport Type:'.$row['n_transporte'].'</label><br>
                            <label for="ubi1">Price : '.$row['precio'].'</label>
                          </div>';
      }
      if ($row['t_traslado'] == 2) {
          $b .= '<div class="form-group">
                            <label for="ubi1">Transport Type:'.$row['n_transporte'].'</label><br>
                            <label for="ubi1">Price : '.$row['precio'].'</label>
                          </div>';
      }
                    
    }
  
    echo '<h2>'.utf8_encode($nombre).'</h2>

          <form role="form"><div class="col-12 col-sm-12">
            <div class="card card-primary card-outline card-tabs">
              <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">ONEWAY</a>
                  </li>
                  
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill" href="#custom-tabs-three-messages" role="tab" aria-controls="custom-tabs-three-messages" aria-selected="false">RETURN</a>
                  </li>
                  
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">'.$a.'
                  </div>
                 
                  <div class="tab-pane fade" id="custom-tabs-three-messages" role="tabpanel" aria-labelledby="custom-tabs-three-messages-tab">'.$b.'
                     
                  </div>
                  
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>

                
              </form>';
 

};

 if ($opcion ==3) {
     
      $destino_1 = $_POST['ubi1'];
      $destino_2 = $_POST['ubi2'];
      $destino_3 = $destino_2;
      $destino_4 = $destino_1;
      $personas= $_POST['people'];
      $tipo_traslado = $_POST['radio'];
      $fecha = $_POST['dep-date'];
      $fecha_r = $_POST['ret-date'];



      $sql = "SELECT * FROM rutas AS rut
        LEFT JOIN ubicaciones AS ubi ON ubi.n_ubicacion ='".$destino_2."'
        LEFT JOIN transportes AS trans ON trans.id_transporte = rut.id_transporte
        WHERE id_p_llegada = ubi.id_ubicacion AND t_traslado=1 AND ".$personas." BETWEEN cantidad_min and  cantidad_max";
      $respuesta = mysqli_query($conexion,$sql);


      $sql2 = "SELECT n_ubicacion FROM ubicaciones;";
      $respuesta2= mysqli_query($conexion,$sql2);
       
      $sql3 = "SELECT * FROM rutas AS rut
            LEFT JOIN ubicaciones AS ubi ON ubi.n_ubicacion ='".$destino_2."'
            LEFT JOIN transportes AS trans ON trans.id_transporte = rut.id_transporte
            WHERE id_p_llegada = ubi.id_ubicacion AND t_traslado=2 AND ".$personas." BETWEEN cantidad_min and  cantidad_max";
            
      $respuesta3 = mysqli_query($conexion,$sql3);

      if ($tipo_traslado == 1) {
         while ($transportes = mysqli_fetch_array($respuesta)) {
        
          echo '<option value="'.$transportes['n_transporte'].'/'.$transportes['precio'].'">'.utf8_encode($transportes['n_transporte']).' - Cant. Max:'.$transportes['cantidad_max'].' - Total: '.$transportes['precio'].'</option>';
        }
      }
      if ($tipo_traslado == 2) {
         while ($transportes = mysqli_fetch_array($respuesta3)) {
          echo '<option value="'.$transportes['n_transporte'].'/'.$transportes['precio'].'">'.utf8_encode($transportes['n_transporte']).' - Cant. Max:'.$transportes['cantidad_max'].' - Total: '.$transportes['precio'].'</option>';
        }
      }
     
        
 };

?>