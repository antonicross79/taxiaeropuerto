<?php 


  session_start();
    //Comprobamos si esta definida la sesión 'tiempo'.
  if(isset($_SESSION['tiempo']) ) {

    //Tiempo en segundos para dar vida a la sesión.
    $inactivo = 1200;//20min en este caso.

    //Calculamos tiempo de vida inactivo.
    $vida_session = time() - $_SESSION['tiempo'];

    //Compraración para redirigir página, si la vida de sesión sea mayor a el tiempo insertado en inactivo.
    if($vida_session > $inactivo)
    {
      //Removemos sesión.
      session_unset();
      //Destruimos sesión.
      session_destroy();              
      //Redirigimos pagina.
      header("Location: ../index.html");

        exit();
      }

  }
  $_SESSION['tiempo'] = time();

  require_once('../db/conexion.php');

  $sql55 = "SELECT * FROM configuraciones;
                ";
  $respuesta55= mysqli_query($conexion,$sql55);
  $row55 = mysqli_fetch_array($respuesta55);

  $sqlStripe = "SELECT * FROM stripe;";
  $respuestaStripe= mysqli_query($conexion,$sqlStripe);
  $rowStripe = mysqli_fetch_array($respuestaStripe);
  

?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CancunShuttleAirport</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
      <img src="../dist/img/AdminLTELogo.png"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">CancunShuttleAirport</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['usuario_p'] ; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="menu.php" class="nav-link ">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Menu Principal
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="traslados.php" class="nav-link">
              <i class="nav-icon fas fa-road"></i>
              <p>
                Traslados Pendientes
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="traslados2.php" class="nav-link">
              <i class="nav-icon fas fa-check-circle"></i>
              <p>
                Traslados Realizados
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="tarifas.php" class="nav-link">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>
                Tarifas
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="ubicaciones.php" class="nav-link ">
              <i class="nav-icon fas fa-globe"></i>
              <p>
                Ubicaciones
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="transportes.php" class="nav-link">
              <i class="nav-icon fas fa-truck"></i>
              <p>
                Transportes
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="clientes.php" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Clientes
              </p>
            </a>
          </li> 
          <li class="nav-item">
            <a href="extras.php" class="nav-link">
              <i class="nav-icon fas fa-cart-plus"></i>
              <p>
                Extras
              </p>
            </a>
          </li>
          <li class="nav-item">
          <li class="nav-item">
            <a href="configuraciones.php" class="nav-link active">
              <i class="nav-icon fas fa-wrench"></i>
              <p>
                Configuración
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../index.html" class="nav-link">
              <i class="nav-icon fas fa-share"></i>
              <p>
                Salir
              </p>
            </a>
          </li>
        </ul> 
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Configuracion</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="menu.php">Home</a></li>
              <li class="breadcrumb-item active">Configuracion</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
       
        <!-- /.row -->
        <div class="card card-primary card-outline">
          
          <div class="card-body">
            <h4>Opciones</h4>
            <div class="row">
              <div class="col-5 col-sm-3">
                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                  <a class="nav-link active" id="vert-tabs-home-tab" data-toggle="pill" href="#vert-tabs-home" role="tab" aria-controls="vert-tabs-home" aria-selected="true"><i class="nav-icon fas fa-users"></i> Usuarios</a>
                  <a class="nav-link" id="vert-tabs-profile-tab" data-toggle="pill" href="#vert-tabs-profile" role="tab" aria-controls="vert-tabs-profile" aria-selected="false"><i class="nav-icon fas fa-dollar-sign"></i> Paypal</a>
                  <a class="nav-link" id="vert-tabs-stripe-tab" data-toggle="pill" href="#vert-tabs-stripe" role="tab" aria-controls="vert-tabs-stripe" aria-selected="false"><i class="nav-icon fas fa-dollar-sign"></i> Stripe</a>
                   <!--<a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill" href="#vert-tabs-messages" role="tab" aria-controls="vert-tabs-messages" aria-selected="false">Messages</a>
                  <a class="nav-link" id="vert-tabs-settings-tab" data-toggle="pill" href="#vert-tabs-settings" role="tab" aria-controls="vert-tabs-settings" aria-selected="false">Settings</a>-->
                </div>
              </div>
              <div class="col-7 col-sm-9">
                <div class="tab-content" id="vert-tabs-tabContent">
                  <div class="tab-pane text-left fade show active" id="vert-tabs-home" role="tabpanel" aria-labelledby="vert-tabs-home-tab">

                    <button type="button" class="btn btn-success" style="float: right" data-toggle="modal" data-target="#modal-lg" onclick="CargarVentanaAgregar(5)">
                          <i class="fas fa-plus"></i> Agregar
                  </button>
                  <br><br>
                      <div class="table-responsive" style="height: 400px;">
                        <table class="table m-0">
                          <thead >
                          <tr style="text-align: center; color: white;">
                            <th style="background-color: #01A9DB;">#</th>
                            <th style="background-color: #01A9DB;">Usuario</th>
                            <th style="background-color: #01A9DB;">Status</th>
                            <th style="background-color: #01A9DB;"></th>
                          </tr>
                        </thead>
                          <tbody id="tabla">
                         
                          </tbody>
                        </table>
                      </div>
                      <!-- /.table-responsive --> 
                  </div>
                  <div class="tab-pane fade" id="vert-tabs-profile" role="tabpanel" aria-labelledby="vert-tabs-profile-tab">
                    <form method="POST">
                          <div class="form-group">
                            <label for="ubi2">Correo Paypal</label>
                            <input type="text" class="form-control" id="correo" name="correo" value="<?php echo $row55['correo_paypal'] ?>">
                            
                          </div>
                         
                          <div class="form-group">
                            <label for="dep-date">Paypal Modo de Uso</label>

                            <div class="col-sm-6">
                              <!-- radio -->
                                <div class="form-group">
                                  <select class="form-control" id="modo_paypal" name="modo_paypal">
                              <?php 

                                if ($row55['url_paypal'] == 'https://www.sandbox.paypal.com/cgi-bin/webscr') {
                                  echo '
                                    <option value="https://www.sandbox.paypal.com/cgi-bin/webscr" selected>Modo Prueba</option>
                                    <option value="https://www.paypal.com/cgi-bin/webscr">Modo Produccion</option>
                                  ';
                                }
                                if ($row55['url_paypal'] == 'https://www.paypal.com/cgi-bin/webscr') {
                                  echo '<option value="https://www.sandbox.paypal.com/cgi-bin/webscr" >Modo Prueba</option>
                                    <option value="https://www.paypal.com/cgi-bin/webscr" selected>Modo Produccion</option>';
                                }

                              ?>
                              </select>
                                 
                                </div>
                              
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="ubi2">Tipo de Moneda</label>
                            <input type="text" class="form-control" id="t_moneda" name="t_moneda" list="ubicaciones" value="<?php echo $row55['tipo_moneda'] ?>">
                            
                          </div>

                          <button type="button" class="btn btn-success" style="float: right" onclick="GuardarConfiguracion(6)">
                          <i class="fas fa-plus"></i> Guardar
                  </button>
                    </form>
                  </div>
                  <div class="tab-pane fade" id="vert-tabs-stripe" role="tabpanel" aria-labelledby="vert-tabs-stripe-tab">
                    <form method="POST">
                          <div class="form-group">
                            <label for="ubi2">Private Key</label>
                            <input type="text" class="form-control" id="stripe_private" name="correo" value="<?php echo $rowStripe['secret_key'] ?>">
                            
                          </div>
                          <div class="form-group">
                            <label for="ubi2">Publishable Key</label>
                            <input type="text" class="form-control" id="stripe_publishable" name="correo" value="<?php echo $rowStripe['publishable_key'] ?>">
                            
                          </div>
                         
                          <div class="form-group">
                            <label for="ubi2">Tipo de Moneda</label>
                            <input type="text" class="form-control" id="stripe_currency" name="t_moneda" list="ubicaciones" value="<?php echo $rowStripe['currency'] ?>">
                            
                          </div>

                          <button type="button" class="btn btn-success" style="float: right" onclick="GuardarStripe()">
                          <i class="fas fa-plus"></i> Guardar
                  </button>
                    </form>
                  </div>
                 <!-- <div class="tab-pane fade" id="vert-tabs-messages" role="tabpanel" aria-labelledby="vert-tabs-messages-tab">
                     Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna. 
                  </div>
                  <div class="tab-pane fade" id="vert-tabs-settings" role="tabpanel" aria-labelledby="vert-tabs-settings-tab">
                     Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate. Morbi euismod molestie tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum placerat urna nec pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et felis ut nisl commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet accumsan ex sit amet facilisis. 
                  </div>-->
                </div>
              </div>
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.card -->
      </div><!-- /.container-fluid -->

      


      <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content" id="agregar2">
            
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->





    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
      include "footer.php";
  ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="../plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>

   <script type="text/javascript">
      window.onload = function () {

        CargarListado();
      }

     
      function CargarListado()
      {


        var val = 1;
        $.ajax({
                data: "opc="+val,
                type: "POST",
                url: '../php/consultar_configuraciones.php',
                success: function(data){
                    $('#tabla').html(data);
                }
            });
      }

      function CargarVentanaAgregar(val)
      {
        $.ajax({
                data: "opc="+val,
                type: "POST",
                url: 'ventana_agregar.php',
                success: function(resp){
                    $('#agregar2').html(resp);
 
                }
            });
      }

      function CargarVentanaVer(opcion,id)
      {
        $.ajax({
                data: "opc="+opcion+"&id="+id,
                type: "POST",
                url: '../php/consultar_configuraciones.php',
                success: function(resp){
                    $('#agregar2').html(resp);
 
                }
            });
      }

      function CargarVentanaModificar(opcion,id)
      {
        $.ajax({
                data: "opc="+opcion+"&id="+id,
                type: "POST",
                url: 'ventana_modificar.php',
                success: function(resp){
                    $('#agregar2').html(resp);   
                }
            });
      }

      function EliminarUsuario(opcion,id)
      {

        if(confirm("¿Desea Eliminar Este registro?")){
          $.ajax({
                data: "opc="+opcion+"&id="+id,
                type: "POST",
                url: '../php/eliminar_registros.php',
                success: function(resp){
                    alert(resp); 
                    CargarListado();  
                }
            });
        }
        
      }


      function GuardarConfiguracion(opcion)
      {
        
        
        var correo = document.getElementById("correo").value;
        var t_moneda = document.getElementById("t_moneda").value;
        var e = document.getElementById("modo_paypal");
        var modo_paypal = e.options[e.selectedIndex].value;
      
    
        $.ajax({
                data: "opc="+opcion+"&correo="+correo+"&t_moneda="+t_moneda+"&modo_paypal="+modo_paypal,
                type: "POST",
                url: '../php/guardar_registros.php',
                success: function(data){
                    alert(data);
                    location.reload();
                }
            });
      }

      function GuardarStripe()
      {
        var private_key = $('#stripe_private').val();
        var publishable_key = $('#stripe_publishable').val();
        var currency = $('#stripe_currency').val();
      
    
        $.ajax({
                data: "private_key="+private_key+"&publishable_key="+publishable_key+"&currency="+currency,
                type: "POST",
                url: './save-stripe.php',
                success: function(data){
                    alert(data);
                    location.reload();
                }
            });
      }

      function GuardarUsuario(opcion,id)
      {
        
        
        var usuario = document.getElementById("usuario").value;
        var password = document.getElementById("password").value;
        var nombre_usuario = document.getElementById("nombre_usuario").value;
      
      
    
        $.ajax({
                data: "opc="+opcion+"&usuario="+usuario+"&password="+password+"&nombre_usuario="+nombre_usuario+"&id="+id,
                type: "POST",
                url: '../php/guardar_registros.php',
                success: function(data){
                    alert(data);
                    $("#modal-lg").modal('hide');
                    CargarListado();
                }
            });
      }


    </script>
</body>
</html>
