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
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>CancunShuttleAirport | Menu Principal</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
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
    <a href="index3.html" class="brand-link">
      <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">CancunShuttleAirport</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION["usuario_p"]; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="menu.php" class="nav-link active">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Menu Principal
              </p>
            </a>
          </li>

          <?php 

            if ($_SESSION['permisos'] == 'ANALISTA') {
                  ECHO '<li class="nav-item">
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
              </li>';
            }

            if ($_SESSION['permisos'] == 'ADMINISTRADOR') {
              ECHO '<li class="nav-item">
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
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Bienvenido al Menu Principal</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Menu Principal</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
     
      
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <div class="col-md-8">

            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Ultimos Traslados Pendientes</h3>

              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead >
                    <tr style="text-align: center; color: white;">
                      <th style="background-color: #01A9DB;">#</th>
                      <th style="background-color: #01A9DB;">Desde</th>
                      <th style="background-color: #01A9DB;">Hacia</th>
                      <th style="background-color: #01A9DB;">Modo</th>
                      <th style="background-color: #01A9DB;">Pago</th>
                      <th style="background-color: #01A9DB;">Cliente</th>
                      <th style="background-color: #01A9DB;">Dia</th>
                    </tr>
                  </thead>
                    <tbody id="tabla">
                   
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                
                <a href="traslados.php" class="btn btn-sm btn-secondary float-right">View All Orders</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->

          <div class="col-md-4">
            <!-- Info Boxes Style 2 -->
            <div class="info-box mb-3 bg-warning">
              <span class="info-box-icon"><i class="fas fa-globe"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Ubicaciones</span>
                <span class="info-box-number" id="ubicaciones">/span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-success">
              <span class="info-box-icon"><i class="fas fa-road"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Traslados Realizados</span>
                <span class="info-box-number" id="traslados"></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-danger">
              <span class="info-box-icon"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Clientes</span>
                <span class="info-box-number" id="clientes">114,381</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-info">
              <span class="info-box-icon"><i class="fas fa-truck"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Tipo de Transportes</span>
                <span class="info-box-number" id="transportes">5</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->

            

          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <?php
      include "footer.php";
  ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="../dist/js/demo.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="../plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="../plugins/raphael/raphael.min.js"></script>
<script src="../plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="../plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="../plugins/chart.js/Chart.min.js"></script>

<!-- PAGE SCRIPTS -->
<script src="../dist/js/pages/dashboard2.js"></script>

<script type="text/javascript">
      window.onload = function () {

        CargarListado();
        CargarListado2();
        CargarListado3();
        CargarListado4();
        CargarListado5();

        

      }

     
      function CargarListado()
      {
        var val = 4;
        $.ajax({
                data: "opc="+val,
                type: "POST",
                url: '../php/consultar_reservaciones.php',
                success: function(data){
                    $('#tabla').html(data);
                }
            });
      }
      function CargarListado2()
      {
        var val = 5;
        $.ajax({
                data: "opc="+val,
                type: "POST",
                url: '../php/consultar_reservaciones.php',
                success: function(data){
                    $('#traslados').html(data);
                }
            });
      }
      function CargarListado3()
      {
        var val = 3;
        $.ajax({
                data: "opc="+val,
                type: "POST",
                url: '../php/consultar_transportes.php',
                success: function(data){
                    $('#transportes').html(data);
                }
            });
      }
      function CargarListado4()
      {
        var val = 3;
        $.ajax({
                data: "opc="+val,
                type: "POST",
                url: '../php/consultar_ubicaciones.php',
                success: function(data){
                    $('#ubicaciones').html(data);
                }
            });
      }
      function CargarListado5()
      {
        var val = 4;
        $.ajax({
                data: "opc="+val,
                type: "POST",
                url: '../php/consultar_clientes.php',
                success: function(data){
                    $('#clientes').html(data);
                }
            });
      }



    </script>
</body>
</html>
