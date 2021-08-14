<?php

require_once('../db/conexion.php');
$opcion = $_POST['opc'];

if ($opcion == 1) {

 
  $sql = "SELECT n_ubicacion FROM ubicaciones;";
  $respuesta= mysqli_query($conexion,$sql);

  $sql2 = "SELECT * FROM transportes;";
  $respuesta2= mysqli_query($conexion,$sql2);
  
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
                    <a class="nav-link" id="custom-tabs-three-settings-tab" data-toggle="pill" href="#custom-tabs-three-settings" role="tab" aria-controls="custom-tabs-three-settings" aria-selected="false">Final Step</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                          <div class="form-group">
                            <label for="ubi1">Pick up location</label>
                            <input type="text" class="form-control" id="ubi1" name="ubi1" list="ubicaciones">
                          </div>
                          
                          <datalist id="ubicaciones">
                              <option selected>&nbsp;</option>';

                          while ($destinos = mysqli_fetch_array($respuesta)) {
                            echo "<option value='".$destinos['n_ubicacion']."'>".utf8_encode($destinos['n_ubicacion'])."</option>";
                            
                          };

                          echo '</datalist>
                          <div class="form-group">
                            <label for="ubi2">Drop off location</label>
                            <input type="text" class="form-control" id="ubi2" name="ubi2" list="ubicaciones">
                            
                          </div>
                          <div class="form-group">
                            <label for="people">How many people (including children)</label>
                            <input type="number" class="form-control" id="people" placeholder="1">
                          </div>
                          <div class="form-group">
                            <label for="dep-date">Departure date and time</label>
                            <input type="date" class="form-control" id="dep-date" name="dep-date">
                          </div>
                          <div class="form-group">
                            <label for="dep-date">Time</label>
                            <input type="time" class="form-control" id="dep-date2" name="dep-date2" min="06:00" max="22:00" step="3600">
                          </div>
                          <div class="form-group">
                            <label for="dep-date">Tipe Traslate</label>
                            <select class="form-control" id="radio" name="radio" onchange="HabilitarReturn(this.value)">
                              <option value="1" selected>ONEWAY</option>
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
                          </div> 
                          

                          <div class="card-footer">
                            <a onclick="ValidarInfo1(3)" class="btn btn-primary float-right" data-toggle="pill" href="#custom-tabs-three-profile">Next</a>
                          </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                        <div class="form-group">
                            <label for="n_transporte">Transport</label>
                            <select type="radio" class="form-control" id="n_transporte" name="n_transporte">
                                ';
                                
                                echo '
                            </select>
                          </div>

                          <div class="card-footer">
                            <a class="btn btn-secondary float-left" data-toggle="pill" href="#custom-tabs-three-home">Back</a>
                            <a class="btn btn-primary float-right" data-toggle="pill" href="#custom-tabs-three-messages">Next</a>
                          </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-three-messages" role="tabpanel" aria-labelledby="custom-tabs-three-messages-tab">
                     <div class="form-group">
                        <label for="n_persona">Name and surname</label>
                        <input type="text" class="form-control" id="n_persona" placeholder="Name">
                      </div>
                      <div class="form-group">
                        <label for="telefono_p">Mobile number</label>
                        <input type="text" class="form-control" id="telefono_p" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="email_p">Email address</label>
                        <input type="email" class="form-control" id="email_p" placeholder="Enter email">
                      </div>
                      <div class="form-group">
                        <label for="direccion_p">Street address</label>
                        <input type="text" class="form-control" id="direccion_p" placeholder="795 Folsom Ave, Suite. San Francisco, CA">
                      </div>
                      <div class="form-group">
                        <label for="zip">Zip Code</label>
                        <input type="text" class="form-control" id="zip" placeholder="1010">
                      </div>
                      <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control" id="city" placeholder="City">
                      </div>
                      <div class="form-group">
                        <label for="country">Country</label>
                        <input type="text" class="form-control" id="country" placeholder="Country">
                      </div>
                      <div class="form-group">
                            <label for="aerolinea">Airline and arrival time</label>
                            <input type="text" class="form-control" id="aerolinea" name="aerolinea">
                            
                          </div>
                      <div class="card-footer">
                        <a data-toggle="pill" href="#custom-tabs-three-profile" class="btn btn-secondary float-left">Back</button>
                        <a data-toggle="pill" href="#custom-tabs-three-settings" class="btn btn-primary float-right">Next</a>
                      </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-three-settings" role="tabpanel" aria-labelledby="custom-tabs-three-settings-tab">
                          <div class="form-group">
                            <label for="t_pago">Type Payment</label>
                            <select class="form-control" id="t_pago" name="t_pago" onchange="HabilitarPaymentType(this.value)">
                                <option value="DIRECTO">DIRECTO</option>
                                <option value="PAYPAL">PAYPAL"</option>
                            </select>
                          </div>
                          <div class="form-group" id="paypalType" style="display:none;">
                            <label for="transaccion_paypal">ID Transaction Paypal</label>
                            <input type="text" class="form-control" id="transaccion_paypal" name="transaccion_paypal" placeholder="21312312">
                          </div>
                          <div class="card-footer">
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


    //$permisos = $_POST['permi'];
    $sql = "SELECT * FROM transportes";
   
    $respuesta= mysqli_query($conexion,$sql);
    $aa = '';
    $a = '';
    $b = '';
    $i = 0;
    while ($row = mysqli_fetch_array($respuesta)) {
      $a .= '<div class="form-group">
                            <label for="ubi1">'.$row['n_transporte'].'-Price:</label>
                            <input type="text" class="form-control" name="one[]" id="one'.$i.'">
                          </div>';

      $b .= '<div class="form-group">
                            <label for="ubi1">'.$row['n_transporte'].'-Return Price:</label>
                            <input type="text" class="form-control" name="ret[]" id="ret'.$i.'">
                          </div>';
      $i++;
    }

    $sql2 = "SELECT * FROM ubicaciones";
    $respuesta2= mysqli_query($conexion,$sql2);
    while ($row2 = mysqli_fetch_array($respuesta2)) {
        $sql3 = "SELECT * FROM rutas WHERE id_p_llegada=".$row2['id_ubicacion'];
        $respuesta3= mysqli_query($conexion,$sql3);
        if ($row3 = mysqli_fetch_array($respuesta3)) {}
        else{
          $aa .= '<option value="'.$row2['id_ubicacion'].'">'.utf8_encode($row2['n_ubicacion']).'</option>';
        }

    };



    echo '<form role="form"><div class="col-12 col-sm-12">
          <div class="form-group">
                            <label for="ubi">Ubicacion</label>
                            <select class="form-control" id="ubi" name="ubi">
                                <option value="">SELECCIONE UNA UBICACION</option>'.$aa.'
                            </select>
          </div>

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
                          
                          <div class="card-footer">
                            <a class="btn btn-primary float-right" data-toggle="pill" href="#custom-tabs-three-messages">Next</a>
                          </div>
                  </div>
                 
                  <div class="tab-pane fade" id="custom-tabs-three-messages" role="tabpanel" aria-labelledby="custom-tabs-three-messages-tab">'.$b.'

                        <div class="card-footer">
                            <a onclick="Guardar_Tarifa(1,0)" class="btn btn-success float-right">Save</a>
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
   

   echo '<form role="form"><div class="col-12 col-sm-12">
          <div class="form-group">
              <label for="n_ubicacion">Nombre de la Ubicacion</label>
              <input type="text" class="form-control" id="n_ubicacion" name="n_ubicacion" placeholder="Las Rivieras Mayas">
            </div>
          <div class="card-footer">
              <a onclick="Guardar_Ubicacion(3,0)" class="btn btn-success float-right" data-toggle="pill" href="#custom-tabs-three-profile">Save</a>
          </div>
        </div>   
      </form>';
        
 };

 if ($opcion ==4) {
   

   echo '<form role="form"><div class="col-12 col-sm-12">
          <div class="form-group">
              <label for="n_transporte">Nombre del Transporte</label>
              <input type="text" class="form-control" id="n_transporte" placeholder="VANS">
            </div>
          <div class="form-group">
              <label for="n_ubicacion">Cantidad Min de Personas</label>
              <input type="number" class="form-control" id="cant_min" min="1">
            </div>
          <div class="form-group">
              <label for="n_ubicacion">Cantidad Max de Personas</label>
              <input type="number" class="form-control" id="cant_max" min="1">
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
   

   echo '<form role="form"><div class="col-12 col-sm-12">
          <div class="form-group">
              <label for="n_transporte">Usuario</label>
              <input type="text" class="form-control" id="usuario" name="usuario" placeholder="adminstrador129312">
            </div>
          <div class="form-group">
              <label for="n_ubicacion">Password</label>
              <input type="password" class="form-control" id="password" name="password">
            </div>
          <div class="form-group">
              <label for="n_ubicacion">Nombre Usuario</label>
              <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario">
            </div>
          <div class="card-footer">
              <a onclick="GuardarUsuario(7,0)" class="btn btn-success float-right" data-toggle="modal">Save</a>
          </div>
        </div>   
      </form>';
        
 };


 if ($opcion ==6) {
   

   echo '<form role="form"><div class="col-12 col-sm-12">
          <div class="form-group">
              <label for="n_transporte">Nombre del Cliente</label>
              <input type="text" class="form-control" id="nombre_c" name="nombre_c" placeholder="Leonardo Perez">
            </div>
          <div class="form-group">
              <label for="n_ubicacion">Telefono</label>
              <input type="number" class="form-control" id="telefono_c" name="telefono_c" placeholder="584242933560">
            </div>
          <div class="form-group">
              <label for="n_ubicacion">Email</label>
              <input type="text" class="form-control" id="email_c" name="email_c">
          </div>
          <div class="form-group">
              <label for="n_ubicacion">Codigo Zip</label>
              <input type="text" class="form-control" id="codigo_c" name="codigo_c">
          </div>
          <div class="form-group">
              <label for="n_ubicacion">Dirección</label>
              <input type="text" class="form-control" id="direccion_c" name="direccion_c">
          </div>
          <div class="form-group">
              <label for="n_ubicacion">Ciudad</label>
              <input type="text" class="form-control" id="ciudad_c" name="ciudad_c">
          </div>
          <div class="form-group">
              <label for="n_ubicacion">País</label>
              <input type="text" class="form-control" id="pais_c" name="pais_c">
          </div>
          <div class="card-footer">
              <a onclick="GuardarCliente(8,0)" class="btn btn-success float-right" data-toggle="modal">Save</a>
          </div>
        </div>   
      </form>';
        
 };
 
 if ($opcion ==7) {
   $sql2 = "SELECT * FROM categorias";
    $respuesta2= mysqli_query($conexion,$sql2);
    

   echo '<form role="form"><div class="col-12 col-sm-12">
          <div class="form-group">
              <label for="n_extra">Nombre del Extra</label>
              <input type="text" class="form-control" id="n_extra" placeholder="VANS">
            </div>
          <div class="form-group">
              <label for="descri_extra">Descripción</label>
              <input type="text" class="form-control" id="descri_extra" placeholder="SODA">
            </div>
          <div class="form-group">
              <label for="precio_extra">Precio</label>
              <input type="number" class="form-control" id="precio_extra" min="1">
          </div>
          <div class="form-group">
              <label for="categoria_extra">Categoria</label>
              <select class="form-control" id="categoria">';
              while ($row2 = mysqli_fetch_array($respuesta2)) {
                ?>
                <option value="<?php echo $row2['id_categoria'] ?>"><?php echo $row2['nombre'] ?></option>
                <?php
              }

                

          echo '
              </select>
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
              <a onclick="Guardar_Transfer(9,0)" class="btn btn-success float-right" data-toggle="pill" href="#custom-tabs-three-profile">Save</a>
          </div>
        </div>   
      </form>';
        
 };

if ($opcion ==8) {
   

   echo '<form role="form"><div class="col-12 col-sm-12">
          <div class="form-group">
              <label for="nombre">Nombre de la categoria</label>
              <input type="text" class="form-control" id="nombre" placeholder="Bebidas">
            </div>
          <div class="card-footer">
              <a onclick="Guardar_Categoria(9,0)" class="btn btn-success float-right" data-toggle="pill" href="#custom-tabs-three-profile">Save</a>
          </div>
        </div>   
      </form>';
        
 };

?>