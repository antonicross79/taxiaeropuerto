<?php

	if($_POST['extra'] != '0' AND $_POST['extra'] != '999999'){
		if(isset($_FILES["file"])){
			$ruta="../../images/extras/";
				@opendir($ruta);
				$uploadfile_temporal=$_FILES['file']['tmp_name'];
				$uploadfile_nombre=$ruta.$_FILES['file']['name'];
				$a = "extra_".$_POST['extra'].".jpg";
				if(move_uploaded_file($uploadfile_temporal,$uploadfile_nombre)){
					if(rename($uploadfile_nombre, $ruta.$a)){
						$resultado= "Guardado con Exito!";	
					}else{
						$resultado= "Error al renombrar la imagen";	
					}
				}else{
					$resultado= "Error al subir la imagen";
				}
		}else{
			$resultado= 'Guardado, No se modifico la foto.';
		};
	}
	else
	{
		if($_POST['extra'] == '0'){
			$resultado= 'No se Guardo';
		}
		elseif($_POST['extra'] == '999999'){
			$resultado= 'No se Pudo Actualizar';
		}	
	}
	echo $resultado;
?>