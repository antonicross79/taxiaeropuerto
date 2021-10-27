<?php
	require("../db/conexion.php");


	$usuario = $_POST['usuario'];
	$password = md5($_POST['password']);



	$sql = "SELECT * FROM usuarios WHERE usuario='".$usuario."';";

	$respuesta= mysqli_query($conexion,$sql);
	if($row = mysqli_fetch_array($respuesta))
	{	
		if($password== $row['password'])
		{	
			session_start();
			$_SESSION["usuario_p"] = $row['nombre_u'];
			$_SESSION["permisos"] = $row['t_usuario'];
			$_SESSION["tiempo"] = time();
			header('Location: ../app/menu.php');
		}	
		else
		{
			

			echo "<script type='text/javascript'>alert('Clave Incorrecta! verifiquela, e intente de nuevo.');</script>";   
            echo "<script>
                                      var pagina='../index.html'.concat();
                                         function redireccionar() {
                                         location.href=pagina;
                                      }

                                      setTimeout ('redireccionar()', 0);
                                      </script>";
		}
	}			
	else
	{
	

			echo "<script type='text/javascript'>alert('No Existe el Usuario! verifiquelo, e intente de nuevo.');</script>";   
            echo "<script>
                                      var pagina='../index.html'.concat();
                                         function redireccionar() {
                                         location.href=pagina;
                                      }

                                      setTimeout ('redireccionar()', 0);
                                      </script>";
	}


?>