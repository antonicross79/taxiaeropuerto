<?php

require_once('../db/conexion.php');
$opcion = $_POST['opc'];

if ($opcion == 1) {
    $id= $_POST['id'];
    $destino_1 = $_POST['ubi1'];
    $destino_2 = $_POST['ubi2'];
    $destino_3 = $destino_2;
    $destino_4 = $destino_1;
    $personas= $_POST['people'];
    $tipo_traslado = $_POST['radio'];
    $fecha = $_POST['dep-date'];
    $fecha_r = $_POST['ret-date'];
    $nombre_transporte = $_POST['n_transporte'];
    $precio= $_POST['precio'];
    $tipo_de_pago = $_POST['t_pago'];
    $nombre_persona = $_POST['n_persona'];
    $telefono_persona = $_POST['t_persona'];
    $email_persona = $_POST['e_persona'];
    $codigo_postal= $_POST['zip'];
    $direccion_persona = $_POST['d_persona'];
    $ciudad= $_POST['city'];
    $pais= $_POST['country'];
    $id_transaccion= $_POST['transaccion_paypal'];
    $aerolinea = $_POST['aerolinea'];

    if ($id != 0) {
        if ($fecha_r != '0000-00-00 00:00') {
            $sql = "UPDATE reservaciones SET ubicacion_desde='".$destino_1."', ubicacion_hasta='".$destino_2."', transporte='".$nombre_transporte."', id_t_traslado=".$tipo_traslado.", nombre_p='".$nombre_persona."', telefono_p='".$telefono_persona."', email_p='".$email_persona."', direccion_p='".$direccion_persona."', codigo_p='".$codigo_postal."', ciudad_p='".$ciudad."', pais_p='".$pais."', tipo_pago='".$tipo_de_pago."', cantidad_personas='".$personas."', total=".$precio.", fecha_ida='".$fecha."', fecha_regreso='".$fecha_r."', aerolinea='".$aerolinea."' WHERE id_reservacion=".$id.";";

            if ($tipo_pago = 'PAYPAL') {
                $sql = "UPDATE reservaciones SET ubicacion_desde='".$destino_1."', ubicacion_hasta='".$destino_2."', transporte='".$nombre_transporte."', id_t_traslado=".$tipo_traslado.", nombre_p='".$nombre_persona."', telefono_p='".$telefono_persona."', email_p='".$email_persona."', direccion_p='".$direccion_persona."', codigo_p='".$codigo_postal."', ciudad_p='".$ciudad."', pais_p='".$pais."', tipo_pago='".$tipo_de_pago."', cantidad_personas='".$personas."', total=".$precio.", fecha_ida='".$fecha."', fecha_regreso='".$fecha_r."',transaccion_paypal='".$id_transaccion."', aerolinea='".$aerolinea."' WHERE id_reservacion=".$id.";";
            }
       
        }else{

            $sql = "UPDATE reservaciones SET ubicacion_desde='".$destino_1."', ubicacion_hasta='".$destino_2."', transporte='".$nombre_transporte."', id_t_traslado=".$tipo_traslado.", nombre_p='".$nombre_persona."', telefono_p='".$telefono_persona."', email_p='".$email_persona."', direccion_p='".$direccion_persona."', codigo_p='".$codigo_postal."', ciudad_p='".$ciudad."', pais_p='".$pais."', tipo_pago='".$tipo_de_pago."', cantidad_personas='".$personas."', total=".$precio.", fecha_ida='".$fecha."', aerolinea='".$aerolinea."' WHERE id_reservacion=".$id.";";

            if ($tipo_pago = 'PAYPAL') {
                $sql = "UPDATE reservaciones SET ubicacion_desde='".$destino_1."', ubicacion_hasta='".$destino_2."', transporte='".$nombre_transporte."', id_t_traslado=".$tipo_traslado.", nombre_p='".$nombre_persona."', telefono_p='".$telefono_persona."', email_p='".$email_persona."', direccion_p='".$direccion_persona."', codigo_p='".$codigo_postal."', ciudad_p='".$ciudad."', pais_p='".$pais."', tipo_pago='".$tipo_de_pago."', cantidad_personas='".$personas."', total=".$precio.", fecha_ida='".$fecha."',transaccion_paypal='".$id_transaccion."', aerolinea='".$aerolinea."' WHERE id_reservacion=".$id.";";
            }
        }

    }else{

        if ($fecha_r != '0000-00-00 00:00') {

            $sql = "INSERT INTO reservaciones (ubicacion_desde, ubicacion_hasta , transporte, id_t_traslado, nombre_p, telefono_p, email_p, direccion_p, codigo_p, ciudad_p, pais_p, tipo_pago, cantidad_personas, total, fecha_ida, fecha_regreso, aerolinea) VALUES ('".$destino_1."','".$destino_2."','".$nombre_transporte."',".$tipo_traslado.",'".$nombre_persona."','".$telefono_persona."', '".$email_persona."', '".$direccion_persona."', '".$codigo_postal."', '".$ciudad."', '".$pais."','".$tipo_de_pago."','".$personas."',".$precio.", '".$fecha."','".$fecha_r."','".$aerolinea."');";

            if ($tipo_pago = 'PAYPAL') {
                $sql = "INSERT INTO reservaciones (ubicacion_desde, ubicacion_hasta , transporte, id_t_traslado, nombre_p, telefono_p, email_p, direccion_p, codigo_p, ciudad_p, pais_p, tipo_pago, cantidad_personas, total, fecha_ida, fecha_regreso, transaccion_paypal , aerolinea) VALUES ('".$destino_1."','".$destino_2."','".$nombre_transporte."',".$tipo_traslado.",'".$nombre_persona."','".$telefono_persona."', '".$email_persona."', '".$direccion_persona."', '".$codigo_postal."', '".$ciudad."', '".$pais."','".$tipo_de_pago."','".$personas."',".$precio.", '".$fecha."','".$fecha_r."','".$id_transaccion."','".$aerolinea."');";
            }  
        }else{

            $sql = "INSERT INTO reservaciones (ubicacion_desde, ubicacion_hasta , transporte, id_t_traslado, nombre_p, telefono_p, email_p, direccion_p, codigo_p, ciudad_p, pais_p, tipo_pago, cantidad_personas, total, fecha_ida , aerolinea) VALUES ('".$destino_1."','".$destino_2."','".$nombre_transporte."',".$tipo_traslado.",'".$nombre_persona."','".$telefono_persona."', '".$email_persona."', '".$direccion_persona."', '".$codigo_postal."', '".$ciudad."', '".$pais."','".$tipo_de_pago."','".$personas."',".$precio.", '".$fecha."','".$aerolinea."');";

            if ($tipo_pago = 'PAYPAL') {
                $sql = "INSERT INTO reservaciones (ubicacion_desde, ubicacion_hasta , transporte, id_t_traslado, nombre_p, telefono_p, email_p, direccion_p, codigo_p, ciudad_p, pais_p, tipo_pago, cantidad_personas, total, fecha_ida, transaccion_paypal , aerolinea) VALUES ('".$destino_1."','".$destino_2."','".$nombre_transporte."',".$tipo_traslado.",'".$nombre_persona."','".$telefono_persona."', '".$email_persona."', '".$direccion_persona."', '".$codigo_postal."', '".$ciudad."', '".$pais."','".$tipo_de_pago."','".$personas."',".$precio.", '".$fecha."','".$id_transaccion."','".$aerolinea."');";
            }
        }
    };
    
    if ($respuesta = mysqli_query($conexion,$sql)) {
       echo "Guardado";
    }else{
        echo "No Guardado";
    }

  
};

if ($opcion == 2) {

    $id = $_POST['id'];
    $ubicacion = $_POST['ubicacion'];
    $one = array();
    $one = $_POST['one'];
    $ret = array();
    $ret = $_POST['ret'];
    $ida = array();
    $ida = $_POST['ida'];
    $id_ret = array();
    $id_ret = $_POST['id_ret'];

    $sqlnumero = "SELECT * FROM transportes";
    $respuestanumero= mysqli_query($conexion,$sqlnumero);
    $rownumero = mysqli_num_rows($respuestanumero);
 
    if ($id != 0) {
        $a =explode(",",$one);
        $b = explode(",",$ret);
        $ids_ida = explode(",", $ida);
        $ids_retorno = explode(",",$id_ret);

        foreach ($a as $key => $precio) {
            $sql2 = 'UPDATE rutas  SET precio='.$precio.' WHERE id_ruta='.$ids_ida[$key].';';
            if($respuesta2= mysqli_query($conexion,$sql2)){
                $mensaje = "Guardado";
            }else{
                $mensaje = "No Guardado";
            }
        }

        foreach ($b as $key => $precio) {
            $sql3 = 'UPDATE rutas  SET precio='.$precio.' WHERE id_ruta='.$ids_retorno[$key].';';
            if ($respuesta3= mysqli_query($conexion,$sql3)) {
               $mensaje = "Guardado";
            }else{
                $mensaje = "No Guardado";
            }
        }

        echo $mensaje;
        
    }else{
        $a =explode(",",$one);
        $i =0;
        $aa = count($a);
        $b = explode(",",$ret);
        $bb = count($b);
        $sql = "SELECT * FROM transportes";
        $respuesta= mysqli_query($conexion,$sql);
        while ($row = mysqli_fetch_array($respuesta)) {
            
                $sql2 = 'INSERT INTO rutas (id_p_llegada, id_transporte , t_traslado, precio) VALUES ('.$ubicacion.','.$row['id_transporte'].',1,'.$a[$i].');';

                $respuesta2= mysqli_query($conexion,$sql2);
                $sql3 = 'INSERT INTO rutas (id_p_llegada, id_transporte , t_traslado, precio) VALUES ('.$ubicacion.','.$row['id_transporte'].',2,'.$b[$i].');';

                if ($respuesta3= mysqli_query($conexion,$sql3)){
                   $mensaje= "Guardado";
                }else{
                    $mensaje = "No Guardado";
                }
                $i++;
        }

        echo $mensaje;
    
    }


};

if ($opcion ==3) {
   
    $id = $_POST['id'];
    $ubicacion = $_POST['ubicacion'];
    
    if ($id != 0) {

        $sql2 = 'UPDATE ubicaciones  SET n_ubicacion='.$ubicacion.' WHERE id_ubicacion='.$id.';';
        $respuesta2= mysqli_query($conexion,$sql2);

        if ($respuesta2= mysqli_query($conexion,$sql2)) {
           echo "Guardado";
        }else{
            echo "No Guardado";
        }

        
    }else{

        $sql2 = 'INSERT INTO ubicaciones (n_ubicacion) VALUES ("'.$ubicacion.'");';

        if ($respuesta2= mysqli_query($conexion,$sql2)) {
               echo "Guardado";
            }else{
                echo "No Guardado";
            }
            
    }

};

if ($opcion ==4) {
   
    $id = $_POST['id'];
    $transporte = $_POST['n_transporte'];
    $cant_min = $_POST['cant_min'];
    $cant_max = $_POST['cant_max'];
    
    if ($id != 0) {

        $sql2 = 'UPDATE transportes  SET n_transporte="'.$transporte.'",cantidad_min='.$cant_min.', cantidad_max='.$cant_max.' WHERE id_transporte='.$id.';';
        $respuesta2= mysqli_query($conexion,$sql2);

        if ($respuesta2= mysqli_query($conexion,$sql2)) {
           echo $id;
        }else{
            echo "01";
        };
        
    }else{

        $sql2 = 'INSERT INTO transportes (n_transporte, cantidad_min, cantidad_max) VALUES ("'.$transporte.'", '.$cant_min.', '.$cant_max.');';

        if ($respuesta2= mysqli_query($conexion,$sql2)) {

               $sql3="SELECT * FROM transportes WHERE n_transporte='".$transporte."';";
               $respuesta3= mysqli_query($conexion,$sql3);
               $row3 = mysqli_fetch_array($respuesta3);
               echo $row3['id_transporte'];
            }else{
                echo "0";
            }
            
    }

};


if ($opcion ==5) {
   
    $id = $_POST['id'];
    
    $sql2 = 'UPDATE reservaciones SET estatus="COMPLETADO" WHERE id_reservacion='.$id.';';
    $respuesta2= mysqli_query($conexion,$sql2);

    if ($respuesta2= mysqli_query($conexion,$sql2)) {
        echo "Guardado";
    }else{
        echo "No Guardado";
    }

};


if ($opcion ==6) {
   
    $correo = $_POST['correo'];
    $moneda = $_POST['t_moneda'];
    $modo_paypal = $_POST['modo_paypal'];


    $sql2 = 'UPDATE configuraciones SET correo_paypal="'.$correo.'" , tipo_moneda="'.$moneda.'", url_paypal="'.$modo_paypal.'";';
    $respuesta2= mysqli_query($conexion,$sql2);

    if ($respuesta2= mysqli_query($conexion,$sql2)) {
        echo "Guardado";
    }else{
        echo "No Guardado";
    }

};


if ($opcion == 7) {


    $id= $_POST['id'];
    $usuario = $_POST['usuario'];
    $password = md5($_POST['password']);
    $nombre_usuario = $_POST['nombre_usuario'];
   

    if ($id != 0) {
        
        $sql = "UPDATE usuarios SET usuario='".$usuario."',password='".$password."',nombre_u='".$nombre_usuario."' WHERE id_usuario=".$id.";";

    }else{

        $sql = "INSERT INTO usuarios (usuario, password , nombre_u) VALUES ('".$usuario."','".$password."','".$nombre_usuario."');";

    };
    
    if ($respuesta = mysqli_query($conexion,$sql)) {
       echo "Guardado";
    }else{
        echo "No Guardado";
    }

  
};

if ($opcion == 8) {


    $id= $_POST['id'];
    $cliente = $_POST['nombre_c'];
    $telefono = $_POST['telefono_c'];
    $email = $_POST['email_c'];
    $direccion = $_POST['direccion_c'];
    $codigo= $_POST['codigo_c'];
    $ciudad = $_POST['ciudad_c'];
    $pais = $_POST['pais_c'];
    $agregado_desde= 'ADMIN';
   

    if ($id != 0) {
        
        $sql = "UPDATE clientes SET nombre_c='".$cliente."',telefono_c='".$telefono."',email_c='".$email."',direccion_c='".$direccion."',codigo_c='".$codigo."',ciudad_c='".$ciudad."',pais_c='".$pais."' WHERE id_cliente=".$id.";";

    }else{

        $sql = "INSERT INTO clientes (nombre_c, telefono_c , email_c, direccion_c,codigo_c, ciudad_c , pais_c, agrego_desde) VALUES ('".$cliente."','".$telefono."','".$email."','".$direccion."','".$codigo."','".$ciudad."','".$pais."','".$agregado_desde."');";

    };
    
    if ($respuesta = mysqli_query($conexion,$sql)) {
       echo "Guardado";
    }else{
        echo "No Guardado";
    }

  
};

if ($opcion ==9) {
   
    $id = $_POST['id'];
    $extra = $_POST['n_extra'];
    $descripcion = $_POST['descri_extra'];
    $precio = strval($_POST['precio_extra']);
    $categoria = $_POST['categoria'];

    if ($id != 0) {

        $sql2 = 'UPDATE extras  SET n_extra="'.$extra.'",categoria="'.$categoria.'", descri_extra="'.$descripcion.'", precio="'.$precio.'" WHERE id_extra='.$id.';';
        $respuesta2= mysqli_query($conexion,$sql2);

        if ($respuesta2= mysqli_query($conexion,$sql2)) {
           echo $id;
        }else{
            echo "01";
        };
        
    }else{

        $sql2 = 'INSERT INTO extras (n_extra, descri_extra, precio, categoria) VALUES ("'.$extra.'", "'.$descripcion.'", "'.$precio.'","'.$categoria.'");';
        
        if ($respuesta2= mysqli_query($conexion,$sql2)) {

               $sql3="SELECT * FROM extras WHERE n_extra='".$extra."';";
               $respuesta3= mysqli_query($conexion,$sql3);
               $row3 = mysqli_fetch_array($respuesta3);
               echo $row3['id_extra'];
            }else{
                echo "0";
            }
            
    }

};

if ($opcion == 10) {
   
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];

    if ($id != 0) {

        $sql2 = 'UPDATE categorias SET nombre="'.$nombre.'" WHERE id_categoria="'.$id.'" ;';
        $respuesta2= mysqli_query($conexion,$sql2);

        if ($respuesta2= mysqli_query($conexion,$sql2)) {
           echo $id;
        }else{
            echo "01";
        };
        
    }else{

        $sql2 = 'INSERT INTO categorias (nombre) VALUES ("'.$nombre.'");';

        if ($respuesta2= mysqli_query($conexion,$sql2)) {

               $sql3="SELECT * FROM categorias WHERE id_categoria='".$id."';";
               $respuesta3= mysqli_query($conexion,$sql3);
               $row3 = mysqli_fetch_array($respuesta3);
               echo $row3['id_extra'];
            }else{
                echo "0";
            }
            
    }

};

?>