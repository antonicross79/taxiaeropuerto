<?php

require_once('../db/conexion.php');
$opcion = $_POST['opc'];

if ($opcion == 1) {
    
    $id = $_POST['id'];
    $sql = 'DELETE FROM usuarios WHERE id_usuario='.$id;
    if ($respuesta = mysqli_query($conexion,$sql)) {
       echo "Eliminado con Exito";
    }else{
        echo "No Eliminado.";
    }

  
};

if ($opcion == 2) {

    $id = $_POST['id'];
    $sql = 'DELETE FROM transportes WHERE id_transporte='.$id;
    if ($respuesta = mysqli_query($conexion,$sql)) {
       echo "Eliminado con Exito";
    }else{
        echo "No Eliminado.";
    }


};

if ($opcion ==3) {

   $id = $_POST['id'];
    $sql = 'DELETE FROM ubicaciones WHERE id_ubicacion='.$id;
    if ($respuesta = mysqli_query($conexion,$sql)) {
       echo "Eliminado con Exito";
    }else{
        echo "No Eliminado.";
    }

};

if ($opcion ==4) {
   
  $id = $_POST['id'];
    $sql = 'DELETE FROM rutas WHERE id_p_llegada='.$id;
    if ($respuesta = mysqli_query($conexion,$sql)) {
       echo "Eliminado con Exito";
    }else{
        echo "No Eliminado.";
    }

};


if ($opcion ==5) {
   
   $id = $_POST['id'];
    $sql = 'DELETE FROM reservaciones WHERE id_reservacion='.$id;
    if ($respuesta = mysqli_query($conexion,$sql)) {
       echo "Eliminado con Exito";
    }else{
        echo "No Eliminado.";
    }

};


if ($opcion ==6) {
   
   $id = $_POST['id'];
    $sql = 'DELETE FROM clientes WHERE id_cliente='.$id;
    if ($respuesta = mysqli_query($conexion,$sql)) {
       echo "Eliminado con Exito";
    }else{
        echo "No Eliminado.";
    }

};


if ($opcion == 7) {

    $id = $_POST['id'];
    $sql = 'DELETE FROM extras WHERE id_extra='.$id;
    if ($respuesta = mysqli_query($conexion,$sql)) {
       echo "Eliminado con Exito";
    }else{
        echo "No Eliminado.";
    }
};

if ($opcion == 8) {

    $id = $_POST['id'];
    $sql = 'DELETE FROM categorias WHERE id_categoria='.$id;
    if ($respuesta = mysqli_query($conexion,$sql)) {
       echo "Eliminado con Exito";
    }else{
        echo "No Eliminado.";
    }
};


?>