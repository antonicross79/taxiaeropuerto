<?php

require_once('../db/conexion.php');

 $opcion = $_POST['opc'];

 if ($opcion == 1) {
    //$permisos = $_POST['permi'];
    $sql = "SELECT * FROM transportes;
                ";
    $respuesta= mysqli_query($conexion,$sql);
    $output = '';
    $i =1;
    while($row = mysqli_fetch_array($respuesta))
    {
      
        $output .= '<tr style="text-align: center;">
                        <td>'.$i.'</td>
                        <td>'.utf8_encode($row['n_transporte']).'</td>
                        <td>'.$row['cantidad_min'].'</td>
                        <td>'.$row['cantidad_max'].'</td>
                        <td>
                                        <button type="button" class="btn btn-block bg-gradient-success btn-xs" data-toggle="modal" data-target="#modal-xl" onclick="CargarVentanaVer(2,'.$row['id_transporte'].')"><i class="fas fa-eye"></i></button> 
                                        <button type="button" class="btn btn-block bg-gradient-info btn-xs" data-toggle="modal" data-target="#modal-lg" onclick="CargarVentanaModificar(4,'.$row['id_transporte'].')"><i class="fas fa-edit"></i></button>
                                        
                                    
                        <button type="button" class="btn btn-block bg-gradient-danger btn-xs" onclick="EliminarTransporte(2,'.$row['id_transporte'].')"><i class="fas fa-trash"></i></button>   </td>';
        $output .=  '</tr>'   ;                                                     
        $i++;              
    };

    echo $output;
 };

  if ($opcion == 2) {


    $id = $_POST['id'];
    $sql = "SELECT * FROM transportes WHERE id_transporte=".$id;
    $respuesta= mysqli_query($conexion,$sql);
    $row = mysqli_fetch_array($respuesta);

   
    echo '<form role="form"><div class="col-12 col-sm-12">
          <div class="form-group">
              <label for="n_transporte">Nombre del Transporte</label><br>
              <label for="n_transporte">'.$row['n_transporte'].'</label>
          </div>
          <div class="form-group">
              <label for="n_transporte">Cantidad Min de Personas</label><br>
              <label for="n_transporte">'.$row['cantidad_min'].'</label>
          </div>
          <div class="form-group">
              <label for="n_transporte">Cantidad Max de Personas</label><br>
              <label for="n_transporte">'.$row['cantidad_max'].'</label>
          </div>
          <div class="card-footer">
              <a class="btn btn-primary float-right" data-dismiss="modal">Close</a>
          </div>
        </div>   
      </form>';
};

if ($opcion == 3) {
    //$permisos = $_POST['permi'];
    $sql = "SELECT * FROM transportes";
    $respuesta= mysqli_query($conexion,$sql);
    $i =1;
    $row = mysqli_num_rows($respuesta);
    
    echo $row;
 };

?>