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
  <title>Taxiaeropuerto</title>
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
      <span class="brand-text font-weight-light">Taxiaeropuerto</span>
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
            <a href="clientes.php" class="nav-link active">
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
            <h1>Clientes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="menu.php">Home</a></li>
              <li class="breadcrumb-item active">Clientes</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        

           <!-- ./row -->
        <div class="row">
          <div class="col-12 col-sm-12">
            <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                  <li class="pt-2 px-3"><h3 class="card-title">Tipos de Clientes</h3></li>
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Agregados por Pagina Web</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Agregados por Admin</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-two-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
                    <div class="input-group input-group-sm" style="width: 250px;">
                              <input type="text" name="table_search" id="table_search" class="form-control float-right" placeholder="Buscar">

                              <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                              </div>
                            </div>
                            <br>

                      <div class="col-12">
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Listado de Clientes</h3>
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body table-responsive p-0" style="height: 450px;">
                            <table class="table table-head-fixed text-nowrap" id="mytable" name="mytable">
                              <thead >
                                 <tr style="text-align: center; color: white;">
                                  <th style="background-color: #01A9DB;">#</th>
                                  <th style="background-color: #01A9DB;">Nombre y Apellido</th>
                                  <th style="background-color: #01A9DB;">Dirección</th>
                                  <th style="background-color: #01A9DB;">Ciudad</th>
                                  <th style="background-color: #01A9DB;">País</th>
                                  <th style="background-color: #01A9DB;">Telefono</th>
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
                  <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
                     

                     <button type="button" class="btn btn-success" style="float: right" data-toggle="modal" data-target="#modal-lg" onclick="CargarVentanaAgregar(6)">
                        <i class="fas fa-plus"></i> Agregar
                    </button>
                    <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 250px;">
                              <input type="text" name="table_search2" id="table_search2" class="form-control float-right" placeholder="Buscar">

                              <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                              </div>
                            </div>
                    </div>
                    <br>

                    <div class="col-12">
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Listado de Clientes</h3>
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body table-responsive p-0" style="height: 450px;">
                            <table class="table table-head-fixed text-nowrap" id="mytable2" name="mytable2">
                              <thead >
                                <tr style="text-align: center; color: white;">
                                  <th style="background-color: #01A9DB;">#</th>
                                  <th style="background-color: #01A9DB;">Nombre y Apellido</th>
                                  <th style="background-color: #01A9DB;">Dirección</th>
                                  <th style="background-color: #01A9DB;">Ciudad</th>
                                  <th style="background-color: #01A9DB;">País</th>
                                  <th style="background-color: #01A9DB;">Telefono</th>
                                  <th style="background-color: #01A9DB;"></th>
                                </tr>
                              </thead>
                              <tbody id="tabla2">
                               
                              </tbody>
                            </table>
                          </div>
                          <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                      </div>
              
       
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>

      </div><!-- /.container-fluid -->

      

     
      <div class="modal fade" id="modal-sm">
        <div class="modal-dialog modal-sm">
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
        CargarListado2();
        

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
                url: '../php/consultar_clientes.php',
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
                url: '../php/consultar_clientes.php',
                success: function(data){
                    $('#tabla').html(data);
                }
            });
      }

      function CargarListado2()
      {


        var val = 2;
        $.ajax({
                data: "opc="+val,
                type: "POST",
                url: '../php/consultar_clientes.php',
                success: function(data){
                    $('#tabla2').html(data);
                }
            });
      }


      function EliminarCliente(opcion,id)
      {

        if(confirm("¿Desea Eliminar Este registro?")){
          $.ajax({
                data: "opc="+opcion+"&id="+id,
                type: "POST",
                url: '../php/eliminar_registros.php',
                success: function(resp){
                    alert(resp); 
                    CargarListado();  
                    CargarListado2();
                }
            });
        }
        
      }

      function GuardarCliente(opcion,id)
      {
        
        
        var nombre_c = document.getElementById("nombre_c").value;
        var telefono_c = document.getElementById("telefono_c").value;
        var email_c = document.getElementById("email_c").value;
        var codigo_c = document.getElementById("codigo_c").value;
        var direccion_c = document.getElementById("direccion_c").value;
        var ciudad_c = document.getElementById("ciudad_c").value;
        var pais_c = document.getElementById("pais_c").value;
      
    
        $.ajax({
                data: "opc="+opcion+"&id="+id+"&nombre_c="+nombre_c+"&telefono_c="+telefono_c+"&email_c="+email_c+"&codigo_c="+codigo_c+"&direccion_c="+direccion_c+"&ciudad_c="+ciudad_c+"&pais_c="+pais_c,
                type: "POST",
                url: '../php/guardar_registros.php',
                success: function(data){
                    alert(data);
                    $("#modal-lg").modal('hide');
                    CargarListado2();
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
    <script>
     // Write on keyup event of keyword input element
     $(document).ready(function(){
     $("#table_search2").keyup(function(){
     _this = this;
     // Show only matching TR, hide rest of them
     $.each($("#mytable2 tbody tr"), function() {
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