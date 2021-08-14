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
     if ($_SESSION['permisos'] != 'ADMINISTRADOR') {
        header("Location: menu.php");
      } 

  }
  $_SESSION['tiempo'] = time();

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
            <a href="transportes.php" class="nav-link active">
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
            <h1>Transportes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="menu.php">Home</a></li>
              <li class="breadcrumb-item active">Transportes</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <button type="button" class="btn btn-success" style="float: right" data-toggle="modal" data-target="#modal-lg" onclick="CargarVentanaAgregar(4)">
                  <i class="fas fa-plus"></i> Agregar
          </button>
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
                <h3 class="card-title">Listado de Transportes</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 450px;">
                <table class="table table-head-fixed text-nowrap" id="mytable" name="mytable">
                  <thead >
                    <tr style="text-align: center; color: white;">
                      <th style="background-color: #01A9DB;">#</th>
                      <th style="background-color: #01A9DB;">Nombre Transporte</th>
                      <th style="background-color: #01A9DB;">Cant. Min Personas</th>
                      <th style="background-color: #01A9DB;">Cant. Max Personas</th>
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
                url: '../php/consultar_transportes.php',
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
                url: '../php/consultar_transportes.php',
                success: function(data){
                    $('#tabla').html(data);
                }
            });
      }

      function EliminarTransporte(opcion,id)
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
  
    function Guardar_Foto(transporte)
      {

        var inputFileImage = document.getElementById("fichero");
        var file = inputFileImage.files[0];
        var data = new FormData();
        data.append('file',file);
        data.append('transporte',transporte);
        $.ajax({
                url: '../php/guardar_imagen.php',
                type: "POST",
                data: data,
                contentType: false,
                processData: false,
                success: function(datos)
                {
                    alert(datos);
                }
            });
        
      }

      function Guardar_Transfer(opcion,id)
      {
        
        
        var n_transporte = document.getElementById("n_transporte").value;
        var cant_min = document.getElementById("cant_min").value;
        var cant_max = document.getElementById("cant_max").value;
    
        $.ajax({
                data: "opc="+opcion+"&id="+id+"&n_transporte="+n_transporte+"&cant_min="+cant_min+"&cant_max="+cant_max,
                type: "POST",
                url: '../php/guardar_registros.php',
                success: function(data){
                    transporte=data;
                    Guardar_Foto(transporte);
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
