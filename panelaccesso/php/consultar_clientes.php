<?php

require_once('../db/conexion.php');

 $opcion = $_POST['opc'];

 if ($opcion == 1) {
    //$permisos = $_POST['permi'];
    $sql = "SELECT * FROM clientes WHERE agrego_desde='PAGINA';
                ";
    $respuesta= mysqli_query($conexion,$sql);
    $output = '';
    $i =1;
    while($row = mysqli_fetch_array($respuesta))
    {
      
        $output .= '<tr style="text-align: center;">
                        <td>'.$i.'</td>
                        <td>'.utf8_encode($row['nombre_c']).'</td>
                        <td>'.utf8_encode($row['direccion_c']).'</td>
                        <td>'.utf8_encode($row['ciudad_c']).'</td>
                        <td>'.utf8_encode($row['pais_c']).'</td>
                        <td>'.utf8_encode($row['telefono_c']).'</td>
                        <td>
                                        <button type="button" class="btn btn-block bg-gradient-success btn-xs" data-toggle="modal" data-target="#modal-sm" onclick="CargarVentanaVer(3,'.$row['id_cliente'].')"><i class="fas fa-eye"></i></button> 
                                        <button type="button" class="btn btn-block bg-gradient-info btn-xs" data-toggle="modal" data-target="#modal-lg" onclick="CargarVentanaModificar(6,'.$row['id_cliente'].')"><i class="fas fa-edit"></i></button>
                                       
                                    
                <button type="button" class="btn btn-block bg-gradient-danger btn-xs" onclick="EliminarCliente(6,'.$row['id_cliente'].')"><i class="fas fa-trash"></i></button>  </td>';         
        $output .=  '</tr>'   ;                                                     
        $i++;              
    };

    echo $output;
 };

if ($opcion == 2) {
    //$permisos = $_POST['permi'];
    $sql = "SELECT * FROM clientes WHERE agrego_desde='ADMIN';
                ";
    $respuesta= mysqli_query($conexion,$sql);
    $output = '';
    $i =1;
    while($row = mysqli_fetch_array($respuesta))
    {
      
        $output .= '<tr style="text-align: center;">
                        <td>'.$i.'</td>
                        <td>'.utf8_encode($row['nombre_c']).'</td>
                        <td>'.utf8_encode($row['direccion_c']).'</td>
                        <td>'.utf8_encode($row['ciudad_c']).'</td>
                        <td>'.utf8_encode($row['pais_c']).'</td>
                        <td>'.utf8_encode($row['telefono_c']).'</td>
                        <td>
                                        <button type="button" class="btn btn-block bg-gradient-success btn-xs" data-toggle="modal" data-target="#modal-sm" onclick="CargarVentanaVer(3,'.$row['id_cliente'].')"><i class="fas fa-eye"></i></button> 
                                        <button type="button" class="btn btn-block bg-gradient-info btn-xs" data-toggle="modal" data-target="#modal-lg" onclick="CargarVentanaModificar(6,'.$row['id_cliente'].')"><i class="fas fa-edit"></i></button>
                                       
                 <button type="button" class="btn btn-block bg-gradient-danger btn-xs" onclick="EliminarCliente(6,'.$row['id_cliente'].')"><i class="fas fa-trash"></i></button> </td>';          
        $output .=  '</tr>'   ;                                                     
        $i++;              
    };

    echo $output;
 };
if ($opcion == 3) {
    
    $id = $_POST['id'];
    $sql = "SELECT * FROM clientes WHERE id_cliente=".$id;
    $respuesta= mysqli_query($conexion,$sql);
    $row = mysqli_fetch_array($respuesta);
    
    echo '<div class="col-12 col-sm-6 col-md-12 d-flex align-items-stretch">
              <div class="card bg-light">
                <div class="card-header text-muted border-bottom-0">
         
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b>'.$row['nombre_c'].'</b></h2>
                      <p class="text-muted text-sm"><b>Email: </b>'.$row['email_c'].' </p>
                      <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span><strong> Address: </strong>'.$row['direccion_c'].' -   Code Zip: '.$row['codigo_c'].' - '.$row['ciudad_c'].'</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-globe"></i></span> <strong>Country: </strong>'.$row['pais_c'].'</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> <strong>Phone #: </strong>'.$row['telefono_c'].'</li>
                      </ul>
                    </div>
                    <div class="col-5 text-center">
                      <img src="../dist/img/user.png" alt="" class="img-circle img-fluid">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                    <button type="button" class="btn btn-warning float-right" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
            </div>';
    
 };

 if ($opcion == 4) {
    //$permisos = $_POST['permi'];
    $sql = "SELECT * FROM clientes";
    $respuesta= mysqli_query($conexion,$sql);
    $i =1;
    $row = mysqli_num_rows($respuesta);
    
    echo $row;
 };

?>