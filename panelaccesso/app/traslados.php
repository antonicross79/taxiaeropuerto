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

?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CancunShuttleAirport | Traslados</title>
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
           alt="CancunShuttleAirport"
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
           <?php 

            if ($_SESSION['permisos'] == 'ANALISTA') {
                  ECHO '<li class="nav-item">
            <a href="traslados.php" class="nav-link active">
              <i class="nav-icon fas fa-road"></i>
              <p>
                Traslados Pendientes
              </p>
            </a>
          </li><li class="nav-item">
                <a href="traslados2.php" class="nav-link ">
                  <i class="nav-icon fas fa-check-circle"></i>
                  <p>
                   Traslados Realizados
                  </p>
                </a>
              </li>';
            }

            if ($_SESSION['permisos'] == 'ADMINISTRADOR') {
              ECHO '<li class="nav-item">
            <a href="traslados.php" class="nav-link active">
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
            <a href="ubicaciones.php" class="nav-link">
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
            <a href="configuraciones.php" class="nav-link">
              <i class="nav-icon fas fa-wrench"></i>
              <p>
                Configuración
              </p>
            </a>
          </li>';
            }

          ?>
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
            <h1>Traslados</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="menu.php">Home</a></li>
              <li class="breadcrumb-item active">Traslados</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <?php if ($_SESSION['permisos'] == 'ADMINISTRADOR') {
          ECHO '<button type="button" class="btn btn-success" style="float: right" data-toggle="modal" data-target="#modal-lg" onclick="CargarVentanaAgregar(1)">
                  <i class="fas fa-plus"></i> Agregar
          </button>';
        } ?>
        
          <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" name="table_search" id="table_search" class="form-control float-right" placeholder="Buscar">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
          <br>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Listado de Traslados</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 450px;">
                <table class="table table-head-fixed text-nowrap" id="mytable" name="mytable">
                  <thead >
                    <tr style="text-align: center; color: white;">
                      <th style="background-color: #01A9DB;">#</th>
                      <th style="background-color: #01A9DB;">Desde</th>
                      <th style="background-color: #01A9DB;">Hacia</th>
                      <th style="background-color: #01A9DB;">Modo</th>
                      <th style="background-color: #01A9DB;">Pago</th>
                      <th style="background-color: #01A9DB;">Cliente</th>
                      <th style="background-color: #01A9DB;">Dia</th>
                      <th style="background-color: #01A9DB;">Status</th>
                      <th style="background-color: #01A9DB;"></th>
                    </tr>
                  </thead>
                  <tbody id="tabla">
                   
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->

      

     
      <div class="modal fade" id="modal-xl">
        <div class="modal-dialog modal-xl">
          <div class="modal-content" id="agregar">
            
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

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
                url: '../php/consultar_reservaciones.php',
                success: function(resp){
                    $('#agregar').html(resp);
 
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

      function CargarListado()
      {


        var val = 1;
        $.ajax({
                data: "opc="+val,
                type: "POST",
                url: '../php/consultar_reservaciones.php',
                success: function(data){
                    $('#tabla').html(data);
                }
            });
      }

      function CambiarStatusCompletado(opcion,id)
      {

        $.ajax({
                data: "opc="+opcion+"&id="+id,
                type: "POST",
                url: '../php/guardar_registros.php',
                success: function(data){
                    alert(data);
                    CargarListado();
                }
            });
      }


      function ValidarInfo1(opcion)
      {

        var ubicacion1 = document.getElementById("ubi1").value;
        var ubicacion2 = document.getElementById("ubi2").value;
        var personas = document.getElementById("people").value;   
        var fecha_separada = document.getElementById("dep-date").value.split('-');
        var fecha_mejorada = fecha_separada[0]+'/'+fecha_separada[1]+'/'+fecha_separada[2];
        var hora = document.getElementById("dep-date2").value;
        var fecha_hora = fecha_mejorada+' '+hora;

        var fecha_separada2 = document.getElementById("ret-date").value.split('-');
        var fecha_mejorada2 = fecha_separada2[0]+'/'+fecha_separada2[1]+'/'+fecha_separada2[2];
        var hora2 = document.getElementById("ret-date2").value;
        var fecha_hora2 = fecha_mejorada2+' '+hora2;
        var e = document.getElementById("radio");
        var t_traslado = e.options[e.selectedIndex].value;

        if (t_traslado == '1') {
            fecha_hora2 = '0000-00-00 00:00';
        };

        $.ajax({
                data: "opc="+opcion+"&ubi1="+ubicacion1+"&ubi2="+ubicacion2+"&people="+personas+"&dep-date="+fecha_hora+"&ret-date="+fecha_hora2+"&radio="+t_traslado,
                type: "POST",
                url: '../php/consultar_reservaciones.php',
                success: function(data){
                $('#n_transporte').html(data);
            }
        });
        

      }

      function HabilitarReturn(val)
      {

        var x = document.getElementById("return1");
        var x2 = document.getElementById("return2");

        if (val == '1') {
            x.style.display = "none";
            x2.style.display = "none";
        }
        if (val == '2') {
            x.style.display = "block";
            x2.style.display = "block";
        }

      }

      function HabilitarPaymentType(val)
      {

        var x3 = document.getElementById("paypalType");

        if (val == 'DIRECTO') {
            x3.style.display = "none";
        }
        if (val == 'PAYPAL') {
            x3.style.display = "block";
        }

      }

      function EliminarReservacion(opcion,id)
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


      function Guardar_Transfer(opcion,id)
      {
        
        // STEP 1

        var ubicacion1 = document.getElementById("ubi1").value;
        var ubicacion2 = document.getElementById("ubi2").value;
        var personas = document.getElementById("people").value;   
        var fecha_separada = document.getElementById("dep-date").value.split('-');
        var fecha_mejorada = fecha_separada[0]+'/'+fecha_separada[1]+'/'+fecha_separada[2];
        var hora = document.getElementById("dep-date2").value;
        var fecha_hora = fecha_mejorada+' '+hora;

        var fecha_separada2 = document.getElementById("ret-date").value.split('-');
        var fecha_mejorada2 = fecha_separada2[0]+'/'+fecha_separada2[1]+'/'+fecha_separada2[2];
        var hora2 = document.getElementById("ret-date2").value;
        var fecha_hora2 = fecha_mejorada2+' '+hora2;
        var e = document.getElementById("radio");
        var t_traslado = e.options[e.selectedIndex].value;

        if (t_traslado == '1') {
            fecha_hora2 = '0000-00-00 00:00';
        };

        // STEP 2
        var e2 = document.getElementById("n_transporte");
        var trans = e2.options[e2.selectedIndex].value.split('/');

        var transporte= trans[0];
        var precio = trans[1];
        // STEP 3

        var nombre_persona = document.getElementById("n_persona").value;
        var telefono_persona = document.getElementById("telefono_p").value;
        var email_persona = document.getElementById("email_p").value; 
        var direccion_persona = document.getElementById("direccion_p").value;
        var codigo_persona = document.getElementById("zip").value;
        var ciudad_persona = document.getElementById("city").value; 
        var pais_persona = document.getElementById("country").value;


        // STEP 4
        var e3 = document.getElementById("t_pago");
        var t_pago = e3.options[e3.selectedIndex].value;        
        
        if (t_pago == 'DIRECTO') {
            var transaccion_pago = '';
        }

        if (t_pago == 'PAYPAL') {
            var transaccion_pago = document.getElementById("transaccion_paypal").value;
        } 


        $.ajax({
                data: "opc="+opcion+"&ubi1="+ubicacion1+"&ubi2="+ubicacion2+"&people="+personas+"&dep-date="+fecha_hora+"&ret-date="+fecha_hora2+"&radio="+t_traslado+"&n_transporte="+transporte+"&precio="+precio+"&n_persona="+nombre_persona+"&t_persona="+telefono_persona+"&e_persona="+email_persona+"&d_persona="+direccion_persona+"&zip="+codigo_persona+"&city="+ciudad_persona+"&country="+pais_persona+"&t_pago="+t_pago+"&transaccion_paypal="+transaccion_pago+"&id="+id,
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
    <script>
     // Write on keyup event of keyword input element
     $(document).ready(function(){
     $("#table_search").keyup(function(){
     _this = this;
     // Show only matching TR, hide rest of them
     $.each($("#mytable tbody tr"), function() {
     if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
     $(this).hide();
     else
     $(this).show();
     });
     });
    });
    </script>
</body>
</html>
