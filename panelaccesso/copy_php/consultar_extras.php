<?php

require_once('../db/conexion.php');

 $opcion = $_POST['opc'];

 if ($opcion == 1) {
    //$permisos = $_POST['permi'];
    $sql = "SELECT * FROM extras ex join categorias cat on(cat.id_categoria=ex.categoria);
                ";
    $respuesta= mysqli_query($conexion,$sql);
    $output = '';
    $i =1;
    while($row = mysqli_fetch_array($respuesta))
    {
      
        $output .= '<tr style="text-align: center;">
                        <td>'.$row['id_extra'].'</td>
                        <td>'.utf8_encode($row['n_extra']).'</td>
                        <td>'.$row['descri_extra'].'</td>
                        <td>'.$row['nombre'].'</td>
                        <td><img width="100" height="100" alt="extra_'.$row['id_extra'].'" src="https://'.$_SERVER['SERVER_NAME'].'/images/extras/extra_'.$row['id_extra'].'.jpg"></td>
                        <td>'.$row['precio'].'</td>
                        <td>
                                        <button type="button" class="btn btn-block bg-gradient-success btn-xs" data-toggle="modal" data-target="#modal-xl" onclick="CargarVentanaVer(2,'.$row['id_extra'].')"><i class="fas fa-eye"></i></button> 
                                        <button type="button" class="btn btn-block bg-gradient-info btn-xs" data-toggle="modal" data-target="#modal-lg" onclick="CargarVentanaModificar(7,'.$row['id_extra'].')"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-block bg-gradient-danger btn-xs" onclick="eliminarExtra('.$row['id_extra'].')"><i class="fas fa-trash"></i></button>
                                    </td>';
                        //<button type="button" class="btn btn-block bg-gradient-danger btn-xs" onclick="EliminarTransporte(2,'.$row['id_extra'].')"><i class="fas fa-trash"></i></button>   
        $output .=  '</tr>'   ;                                                     
        $i++;              
    };

    echo $output;
 };

  if ($opcion == 2) {


    $id = $_POST['id'];
    $sql = "SELECT * FROM extras ex join categorias cat on(cat.id_categoria=ex.categoria) WHERE id_extra=".$id;
    $respuesta= mysqli_query($conexion,$sql);
    $row = mysqli_fetch_array($respuesta);

   
    echo '<form role="form"><div class="col-12 col-sm-12">
          <div class="form-group">
              <label for="n_extra">Nombre del Extra</label><br>
              <label for="n_extra">'.$row['n_extra'].'</label>
          </div>
          <div class="form-group">
              <label for="descri_extra">Descripción</label><br>
              <label for="descri_extra">'.$row['descri_extra'].'</label>
          </div>
          <div class="form-group">
              <label for="cat_extra">Descripción</label><br>
              <label for="cat_extra">'.$row['nombre'].'</label>
          </div>
          <div class="form-group">
              <label for="descri_extra">Imagen</label><br>
              <td><img width="200" height="200" alt="extra_'.$i.'" src="https://'.$_SERVER['SERVER_NAME'].'/images/extras/extra_'.$id.'.jpg"></td>
          </div>
          <div class="form-group">
              <label for="precio">Precio</label><br>
              <label for="precio">'.$row['precio'].'</label>
          </div>
          <div class="card-footer">
              <a class="btn btn-primary float-right" data-dismiss="modal">Close</a>
          </div>
        </div>   
      </form>';
};

if ($opcion == 3) {
    //$permisos = $_POST['permi'];
    $sql = "SELECT * FROM extras";
    $respuesta= mysqli_query($conexion,$sql);
    $i =1;
    $row = mysqli_num_rows($respuesta);
    
    echo $row;
 };

if ($opcion == 4) {
    //$permisos = $_POST['permi'];
    $sql = "SELECT * FROM categorias";
    $respuesta= mysqli_query($conexion,$sql);
    $i =1;
    while($row = mysqli_fetch_array($respuesta))
    {
      
        $output .= '<tr style="text-align: center;">
                        <td>'.$row['id_categoria'].'</td>
                        <td>'.$row['nombre'].'</td>
                        <td>
                                        <button type="button" class="btn btn-block bg-gradient-success btn-xs" data-toggle="modal" data-target="#modal-xl" onclick="CargarVentanaVer(5,'.$row['id_categoria'].')"><i class="fas fa-eye"></i></button> 
                                        <button type="button" class="btn btn-block bg-gradient-info btn-xs" data-toggle="modal" data-target="#modal-lg" onclick="CargarVentanaModificar(8,'.$row['id_categoria'].')"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-block bg-gradient-danger btn-xs" onclick="eliminarExtra('.$row['id_categoria'].')"><i class="fas fa-trash"></i></button>
                                    </td>';
                        //<button type="button" class="btn btn-block bg-gradient-danger btn-xs" onclick="EliminarTransporte(2,'.$row['id_extra'].')"><i class="fas fa-trash"></i></button>   
        $output .=  '</tr>'   ;                                                     
        $i++;              
    };
    echo $output;
 };

 if ($opcion == 5) {


    $id = $_POST['id'];
    $sql = "SELECT * FROM categorias WHERE id_categoria=".$id;
    $respuesta= mysqli_query($conexion,$sql);
    $row = mysqli_fetch_array($respuesta);

   
    echo '<form role="form"><div class="col-12 col-sm-12">
          <div class="form-group">
              <label for="n_extra">Nombre del grupo</label><br>
              <span >'.$row['nombre'].'</span>
          </div>
      </form>';
};

?>