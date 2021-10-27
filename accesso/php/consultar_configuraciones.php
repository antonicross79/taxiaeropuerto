<?php

require_once('../db/conexion.php');

 $opcion = $_POST['opc'];

 if ($opcion == 1) {
    //$permisos = $_POST['permi'];
    $sql = "SELECT * FROM usuarios;
                ";
    $respuesta= mysqli_query($conexion,$sql);
    $output = '';
    $i =1;
    while($row = mysqli_fetch_array($respuesta))
    {
      
        $output .= '<tr style="text-align: center;">
                        <td>'.$i.'</td>
                        <td>'.utf8_encode($row['usuario']).'</td>';

                        if ($row['estatus_u']== 'A') {
                          $output .= '<td><small class="badge badge-success">ACTIVO</small></td>';
                        }
                        if ($row['estatus_u']== 'I') {
                          $output .=$output .= '<td><small class="badge badge-danger">INACTIVO</small></td>';
                        };
                        
                       $output .= '<td>
                                        <button type="button" class="btn btn-block bg-gradient-success btn-xs" data-toggle="modal" data-target="#modal-lg" onclick="CargarVentanaVer(2,'.$row['id_usuario'].')"><i class="fas fa-eye"></i></button> 
                                        <button type="button" class="btn btn-block bg-gradient-info btn-xs" data-toggle="modal" data-target="#modal-lg" onclick="CargarVentanaModificar(5,'.$row['id_usuario'].')"><i class="fas fa-edit"></i></button>';
                                        
                        if ($row['id_usuario']!= '1') {
                          
                            $output .= '<button type="button" class="btn btn-block bg-gradient-danger btn-xs" onclick="EliminarUsuario(1,'.$row['id_usuario'].')"><i class="fas fa-trash"></i></button>';
                        }
                                        
                           
        $output .=  '</td></tr>'   ;                                                     
        $i++;              
    };

    echo $output;
 };

  if ($opcion == 2) {


    $id = $_POST['id'];
    $sql = "SELECT * FROM usuarios WHERE id_usuario=".$id;
    $respuesta= mysqli_query($conexion,$sql);
    $row = mysqli_fetch_array($respuesta);

   
    echo '<form role="form"><div class="col-12 col-sm-12">
          <div class="form-group">
              <label for="usuario">Usuario</label><br>
              <label for="usuario">'.$row['usuario'].'</label>
            
          </div>
          <div class="form-group">
              <label for="password">Password</label><br>
              <label for="password">'.$row['password'].'</label>
            
          </div>
          <div class="form-group">
              <label for="usuario_n">Nombre del Usuario</label><br>
              <label for="usuario_n">'.$row['nombre_u'].'</label>
            
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