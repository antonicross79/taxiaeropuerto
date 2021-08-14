<?php

require_once('../db/conexion.php');
session_start();
 $opcion = $_POST['opc'];

 if ($opcion == 1) {
    //$permisos = $_POST['permi'];
    $sql = "SELECT * FROM reservaciones AS res
                LEFT JOIN tipo_traslado AS t_tras ON t_tras.id_t_traslado = res.id_t_traslado
                WHERE estatus='PENDIENTE';";
    $respuesta= mysqli_query($conexion,$sql);
    $output = '';
    $i =1;
    while($row = mysqli_fetch_array($respuesta))
    {
        $desde = intval($row['modo_viaje']) < 3?'Airport':$row['ubicacion_desde'];
        $hasta = intval($row['modo_viaje']) == 3?'Airport':$row['ubicacion_desde'];
        if(intval($row['modo_viaje']) == 4){
          $desde = $row['ubicacion_desde'];
          $hasta = $row['ubicacion_hasta'];
        }
        $output .= '<tr style="text-align: center;">
                        <td>GST0000000'.$row['id_reservacion'].'</td>
                        <td>'.$desde.'</td>
                        <td>'.$hasta.'</td>
                        <td>'.$row['n_traslado'].'</td>';
                        if ($row['tipo_pago'] == 'DIRECTO') {
                             $output .= '<td><span class="badge bg-primary">'.$row['tipo_pago'].'</span></td>';
                        }elseif ($row['tipo_pago'] == 'PAYPAL') {
                             $output .= '<td><img src="../dist/img/credit/paypal2.png" alt="Paypal"></td>';
                        }

                        $output .= '<td>'.$row['nombre_p'].'</td>
                        <td>'.$row['fecha_ida'].'</td>
                        <td><small class="badge badge-danger">'.$row['estatus'].'</small></td>
                        <td>

                                        <button type="button" class="btn btn-block bg-gradient-primary btn-xs" onclick="CambiarStatusCompletado(5,'.$row['id_reservacion'].')"><i class="fa fa-thumbs-up"></i></button>
                                        <button type="button" class="btn btn-block bg-gradient-success btn-xs" data-toggle="modal" data-target="#modal-xl" onclick="CargarVentanaVer(2,'.$row['id_reservacion'].')"><i class="fas fa-eye"></i></button> 
                                        <button type="button" class="btn btn-block bg-gradient-info btn-xs" data-toggle="modal" data-target="#modal-lg" onclick="CargarVentanaModificar(1,'.$row['id_reservacion'].')"><i class="fas fa-edit"></i></button>';

                         /* if ($_SESSION['permisos'] == 'ADMINISTRADOR') {
                            $output .= '<button type="button" class="btn btn-block bg-gradient-danger btn-xs" onclick="EliminarReservacion(5,'.$row['id_reservacion'].')"><i class="fas fa-trash"></i></button>
                                    ';
                          };*/
                           
        $output .=  '</td></tr>'   ;                                                     
        $i++;              
    };

    echo $output;
 };


if ($opcion == 11) {
    //$permisos = $_POST['permi'];
    $sql = "SELECT * FROM reservaciones AS res
                LEFT JOIN tipo_traslado AS t_tras ON t_tras.id_t_traslado = res.id_t_traslado
                WHERE estatus='COMPLETADO';";
    $respuesta= mysqli_query($conexion,$sql);
    $output = '';
    $i =1;
    while($row = mysqli_fetch_array($respuesta))
    {
        $desde = intval($row['modo_viaje']) < 3?'Airport':$row['ubicacion_desde'];
        $hasta = intval($row['modo_viaje']) == 3?'Airport':$row['ubicacion_desde'];
        if(intval($row['modo_viaje']) == 4){
          $desde = $row['ubicacion_desde'];
          $hasta = $row['ubicacion_hasta'];
        } 
        $output .= '<tr style="text-align: center;">
                        <td>GST0000000'.$row['id_reservacion'].'</td>
                        <td>'.$desde.'</td>
                        <td>'.$hasta.'</td>
                        <td>'.$row['n_traslado'].'</td>';
                        if ($row['tipo_pago'] == 'DIRECTO') {
                             $output .= '<td><span class="badge bg-primary">'.$row['tipo_pago'].'</span></td>';
                        }elseif ($row['tipo_pago'] == 'PAYPAL') {
                             $output .= '<td><img src="../dist/img/credit/paypal2.png" alt="Paypal"></td>';
                        }

                        $output .= '<td>'.$row['nombre_p'].'</td>
                        <td>'.$row['fecha_ida'].'</td>
                        <td><small class="badge badge-success">'.$row['estatus'].'</small></td>
                        <td>

                                        <button type="button" class="btn btn-block bg-gradient-success btn-xs" data-toggle="modal" data-target="#modal-xl" onclick="CargarVentanaVer(2,'.$row['id_reservacion'].')"><i class="fas fa-eye"></i></button> 
                                        <button type="button" class="btn btn-block bg-gradient-info btn-xs" data-toggle="modal" data-target="#modal-lg" onclick="CargarVentanaModificar(1,'.$row['id_reservacion'].')"><i class="fas fa-edit"></i></button><button type="button" class="btn btn-block bg-gradient-danger btn-xs" onclick="EliminarReservacion(5,'.$row['id_reservacion'].')"><i class="fas fa-trash"></i></button>
                                        
                                    </td>';
                           
        $output .=  '</tr>'   ;                                                     
        $i++;              
    };

    echo $output;
 };

  if ($opcion == 2) {


    $id = $_POST['id'];
    //$permisos = $_POST['permi'];
    $sql = "SELECT * FROM reservaciones AS res
                LEFT JOIN tipo_traslado AS t_tras ON t_tras.id_t_traslado = res.id_t_traslado
            WHERE id_reservacion=".$id;
   
    $respuesta= mysqli_query($conexion,$sql);
    $row = mysqli_fetch_array($respuesta);

    $sql = "SELECT * FROM `extra_reservaciones` er join extras ex on(ex.id_extra=er.id_extra) where id_reservacion=".$id." and (cantidad_ida !=0 || cantidad_retorno !=0)";

    $respuesta= mysqli_query($conexion,$sql);

    $sql = "SELECT count(*) cantidad FROM `extra_reservaciones` er join extras ex on(ex.id_extra=er.id_extra) where id_reservacion=".$id." and (cantidad_ida !=0 || cantidad_retorno !=0)";
   
    $respuesta2= mysqli_query($conexion,$sql);
    $row_cant = mysqli_fetch_array($respuesta2);

    $sql = "SELECT sum(precio*(cantidad_ida+cantidad_retorno)) suma FROM `extra_reservaciones` er join `extras` ex on(ex.id_extra=er.id_extra) where (cantidad_ida != 0 || cantidad_retorno != 0) group by id_reservacion having id_reservacion=".$id;
   
    $respuestaSumaExtras= mysqli_query($conexion,$sql);
    $rowSumExtras = mysqli_fetch_array($respuestaSumaExtras);
    
    $round = 0;
    echo '<div class="modal-header">
              <h4 class="modal-title"> Factura</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body"><div class="col-12">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> Bytedex, Inc.';

                    if ($row['id_t_traslado'] == 2) {
                       Echo '<small class="float-right">Dia: '.$row['fecha_ida'].' / '.$row['fecha_regreso'].'</small>';
                    }else{
                        Echo '<small class="float-right">Dia: '.$row['fecha_ida'].'</small>';
                    }

              $desde = intval($row['modo_viaje']) < 3?'Airport':$row['ubicacion_desde'];
              $hasta = intval($row['modo_viaje']) == 3?'Airport':$row['ubicacion_desde'];
              if(intval($row['modo_viaje']) == 1){
                $round = 1;
                $desde = $row['ubicacion_desde'];
                $hasta = $row['ubicacion_hasta'];
              }

                  Echo '</h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row">
                <div class="col-12">
                <span>Confirmation: GST0000000'.$row['id_reservacion'].'</span>
                </div>
              </div>
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  Desde
                  <address>
                    <strong>'.$desde.'</strong><br>
                  </address>
                  Nombre :
                  <address>
                    <strong>'.$row['nombre_p'].'</strong><br>
                  </address>
                  <!-- Address 
                  <address>
                    <strong>'.$row['direccion_p'].'</strong><br>
                  </address>. -->
                  Teléfono:
                  <address>
                    <strong>'.$row['telefono_p'].'</strong><br>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  Hacia
                  <address>
                    <strong>'.$hasta.'</strong><br>
                  </address>
                  Correo
                  <address>
                    <strong>'.$row['email_p'].'</strong><br>
                  </address>
                  <!-- Zip Code 
                  <address>
                    <strong>'.$row['codigo_p'].'</strong><br>
                  </address>  -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  Modo
                  <address>
                    <strong>'.$row['n_traslado'].'</strong><br>
                  </address>
                  Cantidad Personas
                  <address>
                    <strong>'.$row['cantidad_personas'].'</strong><br>
                  </address>

                  Transporte
                  <address>
                  <strong>'.$row['transporte'].'</strong><br>
                  </address>
                  
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->';

                    if ($row['tipo_pago'] == "PAYPAL") {
                       Echo '<div class="row">
                                <!-- accepted payments column -->
                                <div class="col-6">
                                 Aerolinea y Hora de llegada
                                  <address>
                                  <strong>'.$row['aerolinea'].'</strong><br>
                                  </address>
                                  <p class="lead">Comentarios:</p>
                                  <address>
                                  <strong>'.$row['comments'].'</strong><br>
                                  </address>
                                  <p class="lead">Metodo de Pago:</p>
                              
                                  <img src="../dist/img/credit/paypal2.png" alt="Paypal">

                                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                    ID TRANSACCION:
                                  <address>
                                  <strong>'.$row['transaccion_paypal'].'</strong><br>
                                  </address>
                                  </p>
                                 
                                  
                                </div>
                                <!-- /.col -->';
                    }else{
                        Echo '<div class="row">
                                    <!-- accepted payments column -->
                                    <div class="col-6">
                                      Aerolinea y hora de llegadas
                                  <address>
                                  <strong>'.$row['aerolinea'].'</strong><br>
                                  </address>
                                  Comentarios
                                  <address>
                                  <strong>'.$row['comments'].'</strong><br>
                                  </address>
                                    </div>
                                    <!-- /.col -->';
                    };

                if(intval($row_cant['cantidad']) != 0){
                ?>
                <div class="col-6">
                  <p class="lead">Extras:</p>

                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Nombre</th>
                          <th>Cantidad<?php
                            if($round == 1){
                              echo " Ida";
                            }
                          ?></th>
                          <?php
                            if($round == 1){
                              ?>
                              <th>Cantidad Regreso</th>
                              <?php
                            }
                          ?>
                          <th>Costo Unitario</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          while($row_extra = mysqli_fetch_array($respuesta)){
                            ?>
                            <tr>
                              <td><?php echo $row_extra['n_extra'] ?></td>
                              <td><?php echo $row_extra['cantidad_ida'] ?></td>
                              <?php
                                if($round == 1){
                                  ?>
                                  <td><?php echo $row_extra['cantidad_retorno'] ?></td>
                                  <?php
                                }
                              ?>
                              <td><?php echo $row_extra['precio'] ?>,00 USD</td>
                            </tr>
                            <?php
                          }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
                <?php    
                }//end if
                $totalWithExtras = $rowSumExtras['suma']+$row['total'];
                Echo '<div class="col-6">
                  <p class="lead"></p>

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>'.$row['total'].',00 USD</td>
                      </tr>
                      <tr>
                        <th style="width:50%">Extras:</th>
                        <td>'.$rowSumExtras['suma'].',00 USD</td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>'.$totalWithExtras.',00 USD</td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                <button type="button" class="btn btn-warning float-right" data-dismiss="modal">Cerrar</button>
                  <a type="button" class="btn btn-primary float-left" style="margin-right: 5px;" target="_blank" href="../php/generar_kardex.php?id='.$id.'">
                    <i class="fas fa-download"></i> Generate PDF
                  </a>
                  
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
            </div>
           ';
 

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


if ($opcion == 4) {
    //$permisos = $_POST['permi'];
    $sql = "SELECT * FROM reservaciones AS res
                LEFT JOIN tipo_traslado AS t_tras ON t_tras.id_t_traslado = res.id_t_traslado WHERE estatus!='COMPLETADO';";
    $respuesta= mysqli_query($conexion,$sql);
    $output = '';
    $i =1;
    while($row = mysqli_fetch_array($respuesta))
    {
        $desde = intval($row['modo_viaje']) < 3?'Airport':$row['ubicacion_desde'];
        $hasta = intval($row['modo_viaje']) == 3?'Airport':$row['ubicacion_desde'];
        if(intval($row['modo_viaje']) == 4){
          $desde = $row['ubicacion_desde'];
          $hasta = $row['ubicacion_hasta'];
        }
        $output .= '<tr style="text-align: center;">
                        <td>GST0000000'.$row['id_reservacion'].'</td>
                        <td>'.$desde.'</td>
                        <td>'.$hasta.'</td>
                        <td>'.$row['n_traslado'].'</td>';
                        if ($row['tipo_pago'] == 'DIRECTO') {
                             $output .= '<td><span class="badge bg-primary">'.$row['tipo_pago'].'</span></td>';
                        }elseif ($row['tipo_pago'] == 'PAYPAL') {
                             $output .= '<td><img src="../dist/img/credit/paypal2.png" alt="Paypal"></td>';
                        }

                        $output .= '<td>'.$row['nombre_p'].'</td>
                        <td>'.$row['fecha_ida'].'</td>
                       ';
                           
        $output .=  '</tr>'   ;                                                     
        $i++;              
    };

    echo $output;
 };

 if ($opcion == 5) {
    //$permisos = $_POST['permi'];
    $sql = "SELECT * FROM reservaciones AS res
                LEFT JOIN tipo_traslado AS t_tras ON t_tras.id_t_traslado = res.id_t_traslado;";
    $respuesta= mysqli_query($conexion,$sql);
    $i =1;
    $row = mysqli_num_rows($respuesta);
    
    echo $row;
 };

 if ($opcion == 6) {
    //$permisos = $_POST['permi'];
    $sql = "SELECT * FROM reservaciones GROUP BY nombre_p;";
    $respuesta= mysqli_query($conexion,$sql);
    $i =1;
    $row = mysqli_num_rows($respuesta);
    
    echo $row;
 };
?>