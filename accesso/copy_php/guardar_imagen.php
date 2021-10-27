<?php

	if($_POST['transporte'] != '0' AND $_POST['transporte'] != '999999'){
		if(isset($_FILES["file"])){
			$ruta="../../images/transportes/";
				@opendir($ruta);
				$uploadfile_temporal=$_FILES['file']['tmp_name'];
				$uploadfile_nombre=$ruta.$_FILES['file']['name'];
				$a = "transporte_".$_POST['transporte'].".jpg";
				move_uploaded_file($uploadfile_temporal,$uploadfile_nombre);
				rename($uploadfile_nombre, $ruta.$a);
				$resultado= "Guardado con Exito!";
		}else{
			$resultado= 'Guardado, No se modifico la foto.';
		};
	}
	else
	{
		if($_POST['transporte'] == '0'){
			$resultado= 'No se Guardo';
		}
		elseif($_POST['transporte'] == '999999'){
			$resultado= 'No se Pudo Actualizar';
		}	
	}
	echo $resultado;
?>