<?php

require_once('../db/conexion.php');
$opcion = $_POST['opc'];

if ($opcion == 1) {

  $id = $_POST['id'];

  $sql = "SELECT * FROM reservaciones AS res
              LEFT JOIN transportes AS trans ON trans.n_transporte = res.transporte
              LEFT JOIN rutas AS rut ON rut.id_transporte = trans.id_transporte
  WHERE id_reservacion=".$id;
  $respuesta= mysqli_query($conexion,$sql);
  $row = mysqli_fetch_array($respuesta);

  
  

  $sql = "SELECT * FROM `extras` ex join categorias cat on(cat.id_categoria=ex.categoria) order by categoria";
  $respuesta = mysqli_query($conexion,$sql);
  

  $fechahora = explode(' ', $row['fecha_ida']);
  $fechahora2 = explode(' ', $row['fecha_regreso']);

  echo '  <form role="form"><div class="col-12 col-sm-12">
            <div class="card card-primary card-outline card-tabs">
              <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Step 1</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Step 2</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill" href="#custom-tabs-three-messages" role="tab" aria-controls="custom-tabs-three-messages" aria-selected="false">Step 3</a>
                  </li>
                  <li class="nav-item">
                    <a onclick="loadReservationExtras('.$id.')" class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill" href="#custom-tabs-three-extras" role="tab" aria-controls="custom-tabs-three-extras" aria-selected="false">Extras</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-settings-tab" data-toggle="pill" href="#custom-tabs-three-settings" role="tab" aria-controls="custom-tabs-three-settings" aria-selected="false">Final Step</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                          <div class="form-group">
                            <label for="ubi1">Pick up location</label>
                            <input type="text" class="form-control" id="ubi1" name="ubi1" list="ubicaciones"  value="'.$row['ubicacion_desde'].'">
                          </div>
                          
                          <datalist id="ubicaciones">
                              <option selected>&nbsp;</option></datalist>
                          <div class="form-group">
                            <label for="ubi2">Drop off location</label>
                            <input type="text" class="form-control" id="ubi2" name="ubi2" list="ubicaciones" value="'.$row['ubicacion_hasta'].'">
                            
                          </div>
                          <div class="form-group">
                            <label for="people">How many people (including children)</label>
                            <input type="number" class="form-control" id="people" value="'.$row['cantidad_personas'].'">
                          </div>
                          <div class="form-group">
                            <label for="dep-date">Departure date and time</label>
                            <input type="date" class="form-control" id="dep-date" name="dep-date" value="'.$fechahora[0].'">
                          </div>
                          <div class="form-group">
                            <label for="dep-date">Time</label>
                            <input type="time" class="form-control" id="dep-date2" name="dep-date2" min="06:00" max="22:00" step="3600" 
                            value="'.$fechahora[1].'">
                          </div>
                          <div class="form-group">
                            <label for="dep-date">Tipe Traslate</label>
                            <select class="form-control" id="radio" name="radio" onchange="HabilitarReturn(this.value)">';

                            if ($row['id_t_traslado'] == 1) {
                              echo '<option value="1" selected>ONEWAY</option>
                              <option value="2">RETURN</option>
                              </select>
                              </div>
                              <div class="form-group" style="display:none" id="return1">
                                <label for="dep-date">Return date and time</label>
                                <input type="date" class="form-control" id="ret-date" name="ret-date">
                              </div>
                              <div class="form-group" style="display:none" id="return2">
                                <label for="dep-date">Return Time</label>
                                <input type="time" class="form-control" id="ret-date2" name="ret-date2" min="06:00" max="22:00" step="3600">
                              </div> ';
                            }
                            if ($row['id_t_traslado'] == 2) {
                              echo '<option value="1">ONEWAY</option>
                              <option value="2" selected>RETURN</option>
                              </select>
                          </div>
                          <div class="form-group" style="display:block" id="return1">
                            <label for="dep-date">Return date and time</label>
                            <input type="date" class="form-control" id="ret-date" name="ret-date" value="'.$fechahora2[0].'">
                          </div>
                          <div class="form-group" style="display:block" id="return2">
                            <label for="dep-date">Return Time</label>
                            <input type="time" class="form-control" id="ret-date2" name="ret-date2" min="06:00" max="22:00" step="3600" value="'.$fechahora2[1].'">
                          </div> ';
                            }
                              
                            echo ' 

                          <div class="card-footer">
                            <a onclick="ValidarInfo1(3)" class="btn btn-primary float-right" data-toggle="pill" href="#custom-tabs-three-profile">Save</a>
                          </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                        <div class="form-group">
                            <label for="n_transporte">Transport</label>
                            <select type="radio" class="form-control" id="n_transporte" name="n_transporte">
                            <option value="'.$row['transporte'].'/'.$row['precio'].'">'.utf8_encode($row['n_transporte']).' - Cant. Max:'.$row['cantidad_max'].' - Total: '.$row['precio'].'</option>
                            </select>
                            
                          </div>

                          <div class="card-footer">
                            <a class="btn btn-secondary float-left" data-toggle="pill" href="#custom-tabs-three-home">Back</a>
                            <a class="btn btn-primary float-right" data-toggle="pill" href="#custom-tabs-three-messages">Save</a>
                          </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-three-messages" role="tabpanel" aria-labelledby="custom-tabs-three-messages-tab">
                     <div class="form-group">
                        <label for="n_persona">Name and surname</label>
                        <input type="text" class="form-control" id="n_persona"  value="'.$row['nombre_p'].'">
                      </div>
                      <div class="form-group">
                        <label for="telefono_p">Mobile number</label>
                        <input type="text" class="form-control" id="telefono_p" value="'.$row['telefono_p'].'">
                      </div>
                      <div class="form-group">
                        <label for="email_p">Email address</label>
                        <input type="email" class="form-control" id="email_p" value="'.$row['email_p'].'">
                      </div>
                      <div class="form-group">
                        <label for="direccion_p">Street address</label>
                        <input type="text" class="form-control" id="direccion_p" value="'.$row['direccion_p'].'">
                      </div>
                      <div class="form-group">
                        <label for="zip">Zip Code</label>
                        <input type="text" class="form-control" id="zip" value="'.$row['codigo_p'].'">
                      </div>
                      <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control" id="city" value="'.$row['ciudad_p'].'">
                      </div>
                      <div class="form-group">
                        <label for="country">Country</label>
                        <input type="text" class="form-control" id="country" value="'.$row['pais_p'].'">
                      </div>
                      <div class="form-group">
                        <label for="country">Airline and arrival time</label>
                        <input type="text" class="form-control" id="country" value="'.$row['aerolinea'].'">
                      </div>
                      <div class="card-footer">
                        <a data-toggle="pill" href="#custom-tabs-three-profile" class="btn btn-secondary float-left">Back</button>
                        <a data-toggle="pill" href="#custom-tabs-three-settings" class="btn btn-primary float-right">save</a>
                      </div>
                  </div>';
                  ?>
                  <div class="tab-pane fade" id="custom-tabs-three-extras" role="tabpanel" aria-labelledby="custom-tabs-three-extras-tab">
                        <div class="form-group">
                            <label for="n_transporte">Buscar extras</label>
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
                                    if($row['modo_viaje'] == 1){
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

                            while($extrasRow = mysqli_fetch_array($respuesta)){
                              ?>
                              
                                  <tr>
                                    <td><?php echo $extrasRow['n_extra']; ?></td>
                                    <td><?php echo $extrasRow['descri_extra']; ?></td>
                                    <td><?php echo $extrasRow['precio']; ?>,00 USD</td>
                                    <td><?php echo $extrasRow['nombre']; ?></td>
                                    <td><input style="width: 50px;display: inline;" class="form-control" min="0" max="99"  type="number" value="0"></td>
                                    <?php 
                                    $modoreturn = 0;
                                    if($row['modo_viaje'] == 1){
                                      ?>
                                      <td><input style="width: 50px;display: inline;" class="form-control" min="0" max="99"  type="number" value="0"></td>
                                      <?php
                                      $modoreturn = 1;
                                    }
                                    ?>
                                    <td><button class="btn-sm btn-success" onclick="return addExtraToReservation(<?php echo $extrasRow['id_extra']; ?>,<?php echo $id; ?>,<?php echo $modoreturn; ?>)"><i class="fas fa-plus"></i> Add</button></td>
                                  </tr>   
                              <?php
                            }
                            ?>
                            </tbody>
                          </table>
                        </div>
                        </div>
                        <div class="form-group">
                            <label for="n_transporte">Extras en esta reservación</label>
                            <div id="myextras"></div>
                        </div>
                        <script>
                          function loadReservationExtras(id){
                            $.ajax({
                              data:"id="+id,
                              type:"GET",
                              url:'../php/extras_reservacion.php',
                              success:function(data){
                                $('#myextras').html(data);
                              }
                            });
                          }

                          function addExtraToReservation(idextra,idreservation,modo){
                            var cantIda = event.target.parentElement.parentElement.children[4].children[0].value;
                            var cantRet = 0;
                            if(modo == 1){
                              cantRet = event.target.parentElement.parentElement.children[5].children[0].value;
                              event.target.parentElement.parentElement.children[5].children[0].value = 0;
                            }
                            
                            if(cantIda==0 && cantRet ==0){
                                return false;
                            }           
                            
                            event.target.parentElement.parentElement.children[4].children[0].value = 0;
                              
                              $.ajax({
                                data:"idreservation="+idreservation+"&idextra="+idextra+"&cantida="+cantIda+"&cantret="+cantRet,
                                type:"GET",
                                url:'../php/addextra_reservacion.php',
                                success:function(data){
                                  alert("Added!");
                                  $('#myextras').html(data);
                                }
                              }); 
                           return false;
                          }

                          function removeExtraFromReservation(idextra,idreservation){
                            $.ajax({
                                data:"idreservation="+idreservation+"&idextra="+idextra,
                                type:"GET",
                                url:'../php/removeextra_reservacion.php',
                                success:function(data){
                                  $('#myextras').html(data);
                                }
                              }); 
                            return false;
                          }
                          
                        </script>
                  </div>


                  <?php
                  echo '
                  <div class="tab-pane fade" id="custom-tabs-three-settings" role="tabpanel" aria-labelledby="custom-tabs-three-settings-tab">
                          <div class="form-group">
                            <label for="t_pago">Type Payment</label>
                            <select class="form-control" id="t_pago" name="t_pago" onchange="HabilitarPaymentType(this.value)">';

                            if ($row['tipo_pago'] == 'DIRECTO') {
                              echo '<option value="DIRECTO" selected>DIRECTO</option>
                                <option value="PAYPAL">PAYPAL"</option>
                                </select>
                              </div>
                              <div class="form-group" id="paypalType" style="display:none;">
                                <label for="transaccion_paypal">ID Transaction Paypal</label>
                                <input type="text" class="form-control" id="transaccion_paypal" name="transaccion_paypal" placeholder="21312312">
                              </div>';
                            }
                            if ($row['tipo_pago'] == 'PAYPAL') {
                              echo '<option value="DIRECTO" >DIRECTO</option>
                                <option value="PAYPAL" selected>PAYPAL"</option>
                                </select>
                              </div>
                              <div class="form-group" id="paypalType" style="display:nlock;">
                                <label for="transaccion_paypal">ID Transaction Paypal</label>
                                <input type="text" class="form-control" id="transaccion_paypal" name="transaccion_paypal" value="'.$row['transaccion_paypal'].'">
                              </div>';
                            }
                  
                          echo '<div class="card-footer">
                            <a data-toggle="pill" href="#custom-tabs-three-messages" class="btn btn-secondary float-left">Back</a>
                            <button type="submit" class="btn btn-success float-right" onclick="Guardar_Transfer(1,0)">Submit</button>
                          </div>
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
      </form>';

};

if ($opcion == 2) {

  $id = $_POST['id'];

  $sql = "SELECT * FROM rutas AS rut
                LEFT JOIN tipo_traslado AS t_tras ON t_tras.id_t_traslado = rut.t_traslado
                LEFT JOIN ubicaciones AS ubi ON ubi.id_ubicacion = rut.id_p_llegada
                LEFT JOIN transportes AS trans ON trans.id_transporte = rut.id_transporte
            WHERE id_p_llegada=".$id." order by trans.n_transporte";
  $respuesta= mysqli_query($conexion,$sql);
  $a = '';
  $b ='';
  $i=0;
  $j =0;
  while ($row = mysqli_fetch_array($respuesta)) {
      $nombre= $row['n_ubicacion'];
      if ($row['t_traslado'] == 1) {
        $a .= '<div class="form-group">
                            <label for="ubi1">'.$row['n_transporte'].'-Price:</label>
                            <input type="text" class="form-control" id="one'.$i.'" name="one[]" value="'.$row['precio'].'">
                            <input type="hidden" name="id_ruta[]" value="'.$row['id_ruta'].'">
                          </div>';
                          $i++;
      }
      if ($row['t_traslado'] == 2) {
           $b .= '<div class="form-group">
                            <label for="ubi1">'.$row['n_transporte'].'-Return Price:</label>
                            <input type="text" class="form-control" id="ret'.$j.'" name="ret[]" value="'.$row['precio'].'">
                            <input type="hidden" name="id_retorno[]" value="'.$row['id_ruta'].'">
                          </div>';
                    $j++;
      }
      
      
  }



    echo '<form role="form"><div class="col-12 col-sm-12">
          
          <h2>'.utf8_encode($nombre).'</h2>
          <input type="hidden" name="ubi2" id="ubi2" value="'.$id.'">

            <div class="card card-primary card-outline card-tabs">
              <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home2" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">ONEWAY</a>
                  </li>
                  
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill" href="#custom-tabs-three-messages2" role="tab" aria-controls="custom-tabs-three-messages" aria-selected="false">RETURN</a>
                  </li>
                  
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-three-home2" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">'.$a.'
                          
                          <div class="card-footer">
                            <a class="btn btn-primary float-right" data-toggle="pill" href="#custom-tabs-three-messages2">Next</a>
                          </div>
                  </div>
                 
                  <div class="tab-pane fade" id="custom-tabs-three-messages2" role="tabpanel" aria-labelledby="custom-tabs-three-messages-tab">'.$b.'

                        <div class="card-footer">
                            <a class="btn btn-success float-right" onclick="Guardar_Tarifa(2,'.$id.')">Save</a>
                          </div>

                  </div>
                  

                    
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>

                
              </form>';

};

if ($opcion ==3) {
  
   $id = $_POST['id'];
    $sql = "SELECT * FROM ubicaciones WHERE id_ubicacion=".$id;
    $respuesta= mysqli_query($conexion,$sql);
    $row = mysqli_fetch_array($respuesta);
    echo '<form role="form"><div class="col-12 col-sm-12">
          <div class="form-group">
              <label for="n_ubicacion">Nombre de la Ubicacion</label>
              <input type="text" class="form-control" id="n_ubicacion" value="'.$row['n_ubicacion'].'">
            </div>
          <div class="card-footer">
              <a onclick="Guardar_Transfer(3,0)" class="btn btn-success float-right" data-toggle="pill" href="#custom-tabs-three-profile">Save</a>
          </div>
        </div>   
      </form>';
};

if ($opcion ==4) {
  
   $id = $_POST['id'];
    $sql = "SELECT * FROM transportes WHERE id_transporte=".$id;
    $respuesta= mysqli_query($conexion,$sql);
    $row = mysqli_fetch_array($respuesta);

    echo '<form role="form"><div class="col-12 col-sm-12">
          <div class="form-group">
              <label for="n_transporte">Nombre del Transporte</label>
              <input type="text" class="form-control" id="n_transporte" value="'.$row['n_transporte'].'">
            </div>
          <div class="form-group">
              <label for="cant_min">Cantidad Min de Personas</label>
              <input type="number" class="form-control" id="cant_min" min="1" value="'.$row['cantidad_min'].'">
            </div>
          <div class="form-group">
              <label for="cant_max">Cantidad Max de Personas</label>
              <input type="number" class="form-control" id="cant_max" min="1" value="'.$row['cantidad_max'].'">
            </div>
            <div class="form-group">
                        <form action="../php/guardar_imagen.php" id="formSubirFoto" enctype="multipart/form-data">
                            <fieldset class="form-group">
                                <label for="foto">Foto</label>
                                <input type="file" class="form-control-file" name="foto" id="fichero">
                            </fieldset>
                        </form>
                    </div>
          <div class="card-footer">
              <a onclick="Guardar_Transfer(4,0)" class="btn btn-success float-right" data-toggle="pill" href="#custom-tabs-three-profile">Save</a>
          </div>
        </div>   
      </form>';
};

if ($opcion ==5) {

   $id = $_POST['id'];
    $sql = "SELECT * FROM usuarios WHERE id_usuario=".$id;
    $respuesta= mysqli_query($conexion,$sql);
    $row = mysqli_fetch_array($respuesta);

   echo '<form role="form"><div class="col-12 col-sm-12">';
          
            
            if($id == '1'){
                echo '<div class="form-group">
                        <label for="n_transporte">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" value="'.$row['usuario'].'" disabled></div>';
            }else{
                echo '<div class="form-group">
                        <label for="n_transporte">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" value="'.$row['usuario'].'"></div>';
            };
            
          echo '<div class="form-group">
              <label for="n_ubicacion">Password</label>
              <input type="password" class="form-control" id="password" name="password" value="'.$row['password'].'">
            </div>';
            
            if($id == '1'){
                echo '<div class="form-group">
              <label for="n_ubicacion">Nombre Usuario</label>
              <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" value="'.$row['nombre_u'].'" disabled>';
            }else{
                echo '<div class="form-group">
              <label for="n_ubicacion">Nombre Usuario</label>
              <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" value="'.$row['nombre_u'].'">';
            };
          
        echo '</div>
          <div class="card-footer">
              <a onclick="GuardarUsuario(7,'.$row['id_usuario'].')" class="btn btn-success float-right" data-toggle="modal">Save</a>
          </div>
        </div>   
      </form>';
        
 };

 if ($opcion ==6) {

   $id = $_POST['id'];
    $sql = "SELECT * FROM clientes WHERE id_cliente=".$id;
    $respuesta= mysqli_query($conexion,$sql);
    $row = mysqli_fetch_array($respuesta);

   echo '<form role="form"><div class="col-12 col-sm-12">
           <div class="form-group">
              <label for="n_transporte">Nombre del Cliente</label>
              <input type="text" class="form-control" id="nombre_c" name="nombre_c" value="'.$row['nombre_c'].'">
            </div>
          <div class="form-group">
              <label for="n_ubicacion">Telefono</label>
              <input type="number" class="form-control" id="telefono_c" name="telefono_c" value="'.$row['telefono_c'].'">
            </div>
          <div class="form-group">
              <label for="n_ubicacion">Email</label>
              <input type="text" class="form-control" id="email_c" name="email_c" value="'.$row['email_c'].'">
          </div>
          <div class="form-group">
              <label for="n_ubicacion">Codigo Zip</label>
              <input type="text" class="form-control" id="codigo_c" name="codigo_c" value="'.$row['codigo_c'].'">
          </div>
          <div class="form-group">
              <label for="n_ubicacion">Dirección</label>
              <input type="text" class="form-control" id="direccion_c" name="direccion_c" value="'.$row['direccion_c'].'">
          </div>
          <div class="form-group">
              <label for="n_ubicacion">Ciudad</label>
              <input type="text" class="form-control" id="ciudad_c" name="ciudad_c" value="'.$row['ciudad_c'].'">
          </div>
          <div class="form-group">
              <label for="n_ubicacion">País</label>
              <input type="text" class="form-control" id="pais_c" name="pais_c" value="'.$row['pais_c'].'">
          </div>
          <div class="card-footer">
              <a onclick="GuardarCliente(8,'.$row['id_cliente'].')" class="btn btn-success float-right" data-toggle="modal">Save</a>
          </div>
        </div>   
      </form>';
        
 };

if ($opcion ==7) {
  
   $id = $_POST['id'];
    $sql = "SELECT * FROM extras ex join categorias cat on(cat.id_categoria=ex.categoria) WHERE id_extra=".$id;
    $respuesta= mysqli_query($conexion,$sql);
    $row = mysqli_fetch_array($respuesta);

    

    echo '<form role="form"><div class="col-12 col-sm-12">
          <div class="form-group">
              <label for="n_extra">Nombre del Extra</label>
              <input type="text" class="form-control" id="n_extra" value="'.$row['n_extra'].'">
            </div>
          <div class="form-group">
              <label for="descri_extra">Descripción</label>
              <input type="text" class="form-control" id="descri_extra" value="'.$row['descri_extra'].'">
            </div>
            <div class="form-group">
              <label for="cat_extra">Categoria</label>
              <select class="form-control" id="categoria">';
              $sql = "SELECT * FROM categorias";
              $respuesta = mysqli_query($conexion,$sql);
              while ($row2 = mysqli_fetch_array($respuesta)) {
                ?>
                <option value="<?php echo $row2['id_categoria'] ?>" <?php
                if($row['categoria'] == $row2['id_categoria']){
                  echo "selected";
                }
                ?> ><?php echo $row2['nombre'] ?></option>
                <?php
              }
    echo '
              </select>
              
            </div>
          <div class="form-group">
              <label for="precio_extra">Precio</label>
              <input type="number" class="form-control" id="precio_extra" min="1" value="'.$row['precio'].'">
          </div>
          <div class="form-group">
                        <form action="../php/guardar_imagen2.php" id="formSubirFoto" enctype="multipart/form-data">
                            <fieldset class="form-group">
                                <label for="foto">Foto</label>
                                <input type="file" class="form-control-file" name="foto" id="fichero">
                            </fieldset>
                        </form>
                    </div>
          <div class="card-footer">
              <a onclick="Guardar_Transfer(9,'.$row['id_extra'].')" class="btn btn-success float-right" data-toggle="pill" href="#custom-tabs-three-profile">Save</a>
          </div>
        </div>   
      </form>';
};

if ($opcion == 8) {
  
   $id = $_POST['id'];
    $sql = "SELECT * FROM categorias WHERE id_categoria=".$id;
    $respuesta= mysqli_query($conexion,$sql);
    $row = mysqli_fetch_array($respuesta);

    

    echo '<form role="form"><div class="col-12 col-sm-12">
          <div class="form-group">
              <label for="nombre">Nombre del grupo</label>
              <input type="text" class="form-control" id="nombre" value="'.$row['nombre'].'">
            </div>
            <div class="card-footer">
              <a onclick="Guardar_Categoria(10,'.$row['id_categoria'].')" class="btn btn-success float-right" data-toggle="pill" href="#custom-tabs-three-profile">Save</a>
          </div>
      </form>';
};

?>