<?php

require_once('../db/conexion.php');

 $opcion = $_POST['opc'];

 if ($opcion == 1) {
    //$permisos = $_POST['permi'];
    $sql = "SELECT * FROM ubicaciones;
                ";
    $respuesta= mysqli_query($conexion,$sql);
    $output = '';
    $i =1;
    while($row = mysqli_fetch_array($respuesta))
    {
      
        $output .= '<tr style="text-align: center;">
                        <td>'.$i.'</td>
                        <td>'.utf8_encode($row['n_ubicacion']).'</td>
                        
                        <td>
                                        <button type="button" class="btn btn-block bg-gradient-success btn-xs" data-toggle="modal" data-target="#modal-xl" onclick="CargarVentanaVer(2,'.$row['id_ubicacion'].')"><i class="fas fa-eye"></i></button> 
                                        <button type="button" class="btn btn-block bg-gradient-info btn-xs" data-toggle="modal" data-target="#modal-lg" onclick="CargarVentanaModificar(3,'.$row['id_ubicacion'].')"><i class="fas fa-edit"></i></button>
                                       
                                    
              <button type="button" class="btn btn-block bg-gradient-danger btn-xs" onclick="EliminarUbicacion(3,'.$row['id_ubicacion'].')"><i class="fas fa-trash"></i></button> </td>';          
        $output .=  '</tr>'   ;                                                     
        $i++;              
    };

    echo $output;
 };

  if ($opcion == 2) {


    $id = $_POST['id'];
    $sql = "SELECT * FROM ubicaciones WHERE id_ubicacion=".$id;
    $respuesta= mysqli_query($conexion,$sql);
    $row = mysqli_fetch_array($respuesta);

   
    echo '<form role="form"><div class="col-12 col-sm-12">
          <div class="form-group">
              <label for="n_ubicacion">Nombre de la Ubicacion</label><br>
              <label for="n_ubicacion">'.$row['n_ubicacion'].'</label>
            
          </div>
          <div class="card-footer">
              <a class="btn btn-primary float-right" data-dismiss="modal">Close</a>
          </div>
        </div>   
      </form>';
};

if ($opcion == 3) {
    //$permisos = $_POST['permi'];
    $sql = "SELECT * FROM ubicaciones";
    $respuesta= mysqli_query($conexion,$sql);
    $i =1;
    $row = mysqli_num_rows($respuesta);
    
    echo $row;
 };

?>