<?php 
session_start();
$destino_1 = $_POST['ubi1'];
$destino_2 = $_POST['ubi2'];
$destino_3 = $destino_2;
$destino_4 = $destino_1;
$personas= $_POST['people'];
$tipo_traslado = $_POST['modo'];
$fecha = $_POST['dep-date'];
$fecha_r = $_POST['ret-date'];
$nombre_transporte = $_POST['n_transporte'];
$precio= $_POST['precio'];
$_SESSION['total_and_extras'] = number_format($_POST['total_and_extras'],2,',','');
$jj = 0;
$total_extras= 0;
$todos_los_precios = array();
$todos_los_ida = array();
$todos_los_return = array();
$extra_ida = $_POST['cant_ida'];
$extra_retorno = $_POST['cant_return'];
$id_extra = $_POST['id_extra'];
$extra_precios = $_POST['precios'];
$comments = $_POST['comments'];
$pickup_hour_arrival = $_POST['pickup_hour_arrival'];
$pickup_hour_departure = $_POST['pickup_hour_departure'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$is_safari = false;
$is_firefox = false;
if(stripos($user_agent,'Firefox') !== false){
	$is_firefox = true;
}elseif(stripos($user_agent,'Safari') !== false){
	$is_safari = true;
}


/*
if ( !empty($_GET["precios"]) && is_array($_GET["precios"]) ) { 
    $numero_de_extras = count($_GET["precios"]);
    foreach ( $_GET["precios"] as $como ) { 
        $todos_los_precios[$jj] =  $como; 
    };
    foreach ( $_GET["cant_ida"] as $comoo ) { 
        $todos_los_ida[$jj] =  $como; 
    };
    foreach ( $_GET["cant_return"] as $comooo ) { 
        $todos_los_return[$jj] =  $como; 
    };
    while ($jj <= $numero_de_extras) {
        if($todos_los_ida[$jj] != 0){
            $total_extras = $total_extras+ ($todos_los_precios[$jj]*$todos_los_ida[$jj]); 
            if($todos_los_return[$jj] != 0){
                $total_extras = $total_extras+ ($todos_los_precios[$jj]*$todos_los_return[$jj]);
            };
        }
		$jj++;
	};
};*/

//$conexion = mysqli_connect("127.0.0.1","root","6101696","transfer");

	$conexion = mysqli_connect("localhost","canczdhg_taxiaeropuerto","A;2FE+fi","canczdhg_taxiaeropuerto");

$extras = [];
$suma_precios = 0;
for ($i=0; $i < count($id_extra) ; $i++) { 
	if(strlen($extra_ida[$i]) != 0 ||  strlen($extra_retorno[$i]) != 0){
		$t_extra_ida = strlen($extra_ida[$i]) != 0?$extra_ida[$i]:"0";
		$t_extra_retorno = strlen($extra_retorno[$i]) != 0?$extra_retorno[$i]:"0";
		$suma_precios += (intval($extra_precios[$i])*floatval($t_extra_ida)) + (intval($extra_precios[$i])*floatval($t_extra_retorno));
		$extras[] = ["id"=>$id_extra[$i],"ida"=>$t_extra_ida,"retorno"=>$t_extra_retorno,"precio"=>$extra_precios[$i]];
	}
}

if(count($extras) > 0){
	$_SESSION['extras'] = $extras;
	$_SESSION['suma_extra'] = $suma_precios;	
}

$sql = "select precio from extras where id = ".$id_extra;



$sql = "SELECT * FROM rutas AS rut
				LEFT JOIN ubicaciones AS ubi ON ubi.n_ubicacion ='".$destino_2."'
				LEFT JOIN transportes AS trans ON trans.id_transporte = rut.id_transporte
				WHERE id_p_llegada = ubi.id_ubicacion AND t_traslado=1 AND ".$personas." BETWEEN cantidad_min and  cantidad_max";
	$respuesta = mysqli_query($conexion,$sql);


	$sql2 = "SELECT n_ubicacion FROM ubicaciones;";
	$respuesta2= mysqli_query($conexion,$sql2);
	 
	$sql3 = "SELECT * FROM rutas AS rut
				LEFT JOIN ubicaciones AS ubi ON ubi.n_ubicacion ='".$destino_2."'
				LEFT JOIN transportes AS trans ON trans.id_transporte = rut.id_transporte
				WHERE id_p_llegada = ubi.id_ubicacion AND t_traslado=2 AND ".$personas." BETWEEN cantidad_min and  cantidad_max";
				
	$respuesta3 = mysqli_query($conexion,$sql3);




?>
<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="keywords" content="Private Transport and Car Hire HTML Template" />
	<meta name="description" content="Private Transport and Car Hire HTML Template">
	<meta name="author" content="themeenergy.com">
	
	<title>Booking step 1</title>
	
		<link rel="stylesheet" href="../css/theme-lblue.css" />
	<link rel="stylesheet" href="../css/style.css" />
	<link rel="stylesheet" href="../css/animate.css" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Raleway:400,500,600,700|Montserrat:400,700">
	<link rel="shortcut icon" href="../images/favicon.ico">
	<script type="text/javascript" src="../js/countries.js"></script>
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="../css/styleslideshow.css" />
	<link rel="stylesheet" href="../css/whatsapp.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
    	.input-shadow{
    		box-shadow:8px 7px 10px 0px #00000047;
    	}
    </style>
  </head>
  
  <body>

<!-- Header -->
              <?php
				include "header.php";
				
				?>
		<!-- //Header -->
	
	<!-- Main -->
	<main class="main" role="main">
		<!-- Search -->
		<div class="output color twoway container-fluid">
			<div class="wrap">
				
					<?php 
						if ($tipo_traslado == 1 || $tipo_traslado == 2) {
							echo '<p>'.$fecha.'</p>
					<p>Airport &nbsp  hasta  &nbsp'.$destino_1.'</p></div>';
						};
                        
                        if ($tipo_traslado == 3) {
							echo '<p>'.$fecha.'</p>
					<p>'.$destino_1.'&nbsp  hasta  &nbsp Airport</p></div>';
							echo '<div>
										<p>'.$fecha_r.'</p>
										<p>'.$destino_2.'&nbsp  hasta  &nbsp'.$destino_1.'</p>
									</div>';
						}

						if ($tipo_traslado == 4) {
							echo '<p>'.$fecha.'</p>
					<p>'.$destino_1.'&nbsp  hasta  &nbsp'.$destino_2.'</p></div>';
							/*echo '<div>
										<p>'.$fecha_r.'</p>
										<p>'.$destino_2.'&nbsp  hasta  &nbsp'.$destino_1.'</p>
									</div>';*/
						}


					?>

			</div>
		</div>
		<!-- //Search -->
		<div class="full-width content container-fluid">
					<h2>Datos de Reserva</h2>
					<p> Asegúrese de completar todos los campos obligatorios en el momento de la reserva. Esta información es imprescindible para garantizar un viaje sin problemas. <br /> Todos los campos son obligatorios. </p>
				</div>
		
		  <?php
			if ($is_firefox == true) {
				?>
				<div class="full-width content container-fluid">		
				<div class="row">
				<div class="col-xs-12 col-md-9 input-shadow">
				<?php
			}elseif($is_safari == true){
				?>
				<div class="container-fluid">
				<div class="row">
				<div class="col-xs-12 col-md-8 input-shadow">
				<?php
			}else{
				?>
				<div class="container-fluid">
				<div class="row">
					<div class="col-xs-12 col-md-9 input-shadow">
				<?php
			}
			?>
				<form action="booking-step2.php" method="POST" name="formulario" id="formulario">
				 <div class="form-row">
				 	<div class="input-group col-xs-12 col-md-6">
				    <label for="n_persona" class="pl-0 col-xs-12 col-md-12 mb-0 pb-2 mt-2">
 Name and Surname</label>
					<div class="input-group-prepend">
					  <div class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-check" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#00abfb" fill="none" stroke-linecap="round" stroke-linejoin="round">
  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
  <circle cx="9" cy="7" r="4" />
  <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
  <path d="M16 11l2 2l4 -4" /></svg></div>
					</div>
				    <input type="text" name="n_persona" class="form-control" id="n_persona" aria-describedby="emailHelp" placeholder="Ingrese su nombre y Apellido" required="">
				  </div>
				  <div class="input-group col-xs-12 col-md-6">
				  	<label for="t_persona"  class="pl-0 col-xs-12 col-md-12 mb-0 pb-2 mt-2"> Numero movil</label>
				  	<div class="input-group-prepend">
					  <div class="input-group-text">
					  	<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone-calling" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#00abfb" fill="none" stroke-linecap="round" stroke-linejoin="round">
						  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
						  <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
						  <line x1="15" y1="7" x2="15" y2="7.01" />
						  <line x1="18" y1="7" x2="18" y2="7.01" />
						  <line x1="21" y1="7" x2="21" y2="7.01" />
						</svg>
					  </div>
					</div>
				    <input type="text" class="form-control" id="t_persona" placeholder="" name="t_persona" required="">
				  </div>	
				 </div>
		  		 <div class="form-row">
			  		 <div class="input-group col-xs-12 col-md-6">
					    <label for="e_persona" class="pl-0 col-xs-12 col-md-12 mb-0 pb-2 mt-2">Correo</label>
					    <div class="input-group-prepend">
						  <div class="input-group-text">
						  	<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#00abfb" fill="none" stroke-linecap="round" stroke-linejoin="round">
							  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
							  <rect x="3" y="5" width="18" height="14" rx="2" />
							  <polyline points="3 7 12 13 21 7" />
							</svg> 
						  </div>
						</div>
					    <input type="text" class="form-control" id="e_persona" placeholder="john@example.com" name="e_persona" required="">
					  </div>
					  <div class="input-group col-xs-12 col-md-6">
					    <label for="e_persona2" class="pl-0 col-xs-12 col-md-12 mb-0 pb-2 mt-2">Confirme su correo</label>
					    <div class="input-group-prepend">
						  <div class="input-group-text">
						  	<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#00abfb" fill="none" stroke-linecap="round" stroke-linejoin="round">
							  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
							  <rect x="3" y="5" width="18" height="14" rx="2" />
							  <polyline points="3 7 12 13 21 7" />
							</svg> 
						  </div>
						</div>
					    <input type="text" class="form-control" id="e_persona2" placeholder="" name="e_persona2" required="">
					  </div>	
		  		 </div>
				 <div class="form-row">
				 	<div class="input-group mb-3 col-xs-12 col-md-6">
						<label for="country" class="pl-0 col-xs-12 col-md-12 mb-0 pb-2 mt-2">Pais</label>
					  <div class="input-group-prepend">
					    <label class="input-group-text" for="inputGroupSelect01"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#00abfb" fill="none" stroke-linecap="round" stroke-linejoin="round">
						  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
						  <polyline points="3 7 9 4 15 7 21 4 21 17 15 20 9 17 3 20 3 7" />
						  <line x1="9" y1="4" x2="9" y2="17" />
						  <line x1="15" y1="7" x2="15" y2="20" />
						</svg></label>
					  </div>
					  <select class="form-control" id="country" name="country" placeholder=""></select>
					</div>
					<div class="input-group mb-3 col-xs-12 col-md-6">
						<label for="city" class="pl-0 col-xs-12 col-md-12 mb-0 pb-2 mt-2">Ciudad</label>
					  <div class="input-group-prepend">
					    <label class="input-group-text" for="inputGroupSelect01"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-route" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#00abfb" fill="none" stroke-linecap="round" stroke-linejoin="round">
						  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
						  <circle cx="6" cy="19" r="2" />
						  <circle cx="18" cy="5" r="2" />
						  <path d="M12 19h4.5a3.5 3.5 0 0 0 0 -7h-8a3.5 3.5 0 0 1 0 -7h3.5" />
						</svg></label>
					  </div>
					  <select class="form-control" id="city" name="city" placeholder=""></select>
					</div>
					  
				 </div>
				 <div class="form-row">
				 	<div class="input-group mb-3 col-xs-12 col-md-6">
						<label for="flying_from" class="pl-0 col-xs-12 col-md-12 mb-0 pb-2 mt-2">Vuelos Desde</label>
					  <div class="input-group-prepend">
					    <label class="input-group-text" for="inputGroupSelect01"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#00abfb" fill="none" stroke-linecap="round" stroke-linejoin="round">
						  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
						  <polyline points="3 7 9 4 15 7 21 4 21 17 15 20 9 17 3 20 3 7" />
						  <line x1="9" y1="4" x2="9" y2="17" />
						  <line x1="15" y1="7" x2="15" y2="20" />
						</svg></label>
					  </div>
					  <select class="form-control" id="flying_from" name="flying_from" placeholder=""></select>
					</div>
					  <div class="input-group col-xs-12 col-md-6">
					    <label for="Airline" class="pl-0 col-xs-12 col-md-12 mb-0 pb-2 mt-2">Aerolinea</label>
					    <div class="input-group-prepend">
						  <div class="input-group-text">
						  	<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plane-arrival" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#00abfb" fill="none" stroke-linecap="round" stroke-linejoin="round">
							  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
							  <path d="M15 12h5a2 2 0 0 1 0 4h-15l-3 -6h3l2 2h3l-2 -7h3z" transform="rotate(15 12 12) translate(0 -1)" />
							  <line x1="3" y1="21" x2="21" y2="21" />
							</svg>
						  </div>
						</div>
					    <input type="text" class="form-control" id="Airline" name="Airline" placeholder="Avianca" required="">
					  </div>
					  <div class="input-group col-xs-12 col-md-6">
					    <label for="flight_number" class="pl-0 col-xs-12 col-md-12 mb-0 pb-2 mt-2">Numero de Vuelo</label>
					    <div class="input-group-prepend">
						  <div class="input-group-text">
						  	<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-hash" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#00abfb" fill="none" stroke-linecap="round" stroke-linejoin="round">
							  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
							  <line x1="5" y1="9" x2="19" y2="9" />
							  <line x1="5" y1="15" x2="19" y2="15" />
							  <line x1="11" y1="4" x2="7" y2="20" />
							  <line x1="17" y1="4" x2="13" y2="20" />
							</svg>
						  </div>
						</div>
					    <input type="text" class="form-control" id="flight_number" name="flight_number" placeholder="123" required="">
					  </div>
					  <div class="input-group mb-3 col-xs-3 col-md-3">
							<label for="pickup_hour" class="pl-0 col-xs-12 col-md-12 mb-0 pb-2 mt-2">Hotel Pickup Time</label>
						  <div class="input-group-prepend">
						    <label class="input-group-text" for="inputGroupSelect01"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#00abfb" fill="none" stroke-linecap="round" stroke-linejoin="round">
							  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
							  <circle cx="12" cy="12" r="9" />
							  <polyline points="12 7 12 12 15 15" />
							</svg></label>
						  </div>
						  <select class="form-control" name="pickup_hour" id="pickup_hour" required="">
					    	<?php 
					    	$j = 0;
					    	for ($i=0; $i < 24; $i++) { 
					    		if($i > 12){
					    			$j = $i - 12;
					    		}
					    		?>
					    		<option value="<?php echo $i; ?>"><?php echo ($j>9?$j:'0'.$j); echo " "; echo ($i>11?'pm':'am') ?> </option>
					    		<?php
					    		$j++;
					    	}

					    	?>
					    </select>
					</div>
					<div class="input-group mb-3 col-xs-3 col-md-3">
							<label for="pickup_minute" class="pl-0 col-xs-12 col-md-12 mb-0 pb-2 mt-2">Minutos</label>
						  <div class="input-group-prepend">
						    <label class="input-group-text" for="inputGroupSelect01"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#00abfb" fill="none" stroke-linecap="round" stroke-linejoin="round">
							  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
							  <circle cx="12" cy="12" r="9" />
							  <polyline points="12 7 12 12 15 15" />
							</svg></label>
						  </div>
						  <select class="form-control" name="pickup_minute" id="pickup_minute" required="">
					    	<?php 
					    	for ($i=0; $i < 60; $i++) { 
					    		?>
					    		<option value="<?php echo $i; ?>"><?php echo ($i>9?$i:'0'.$i); ?> min</option>
					    		<?php
					    	}

					    	?>
					    </select>
					</div>					  
				 </div>
				 <div class="form-row">
				 	<div class="input-group col-xs-12 col-12">
					    <label for="comments" class="pl-0 col-xs-12 col-md-12 mb-0 pb-2 mt-2"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-text" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#00abfb" fill="none" stroke-linecap="round" stroke-linejoin="round">
  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
  <path d="M14 3v4a1 1 0 0 0 1 1h4" />
  <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
  <line x1="9" y1="9" x2="10" y2="9" />
  <line x1="9" y1="13" x2="15" y2="13" />
  <line x1="9" y1="17" x2="15" y2="17" />
</svg> Commentarios</label>
					    <textarea class="form-control" id="comments" name="comments" rows="2"></textarea>
					  </div>	
				 </div>
				  <?php 
							echo '<input type="hidden" name="ubi1" value="'.$destino_1.'"/>
										<input type="hidden" name="ubi2" value="'.$destino_2.'"/>
										<input type="hidden" name="precio" value="'.$precio.'"/>
										<input type="hidden" name="dep-date" value="'.$fecha.'"/>
										<input type="hidden" name="ret-date" value="'.$fecha_r.'"/>
										<input type="hidden" name="people" value="'.$personas.'"/>
										<input type="hidden" name="modo" value="'.$tipo_traslado.'"/>
										<input type="hidden" name="n_transporte" value="'.$nombre_transporte.'"/>
                                        <input type="hidden" name="total_extras" value="'.$total_extras.'"/>
                                        <input type="hidden" name="pickup_hour_arrival" value="'.$_POST['pickup_hour_arrival'].'"/>
										<input type="hidden" name="pickup_hour_departure" value="'.$_POST['pickup_hour_departure'].'"/>'
                                        ;
						?>
				  <button type="submit" class="btn btn-primary mt-2 mb-3">Enviar</button>
				</form>	
			</div>
			<div class="col-xs-12 col-md-3">
					<!-- Widget -->
					<div class="widget">
						<h4>Resumen</h4>
						<div class="summary">
							<div>
								<h5>SALIDA</h5>
								<table class="table table-sm">
									<tbody>
										<tr>
											<td scope="row">Fecha</td>
											<td><?php echo $fecha; ?></td>
										</tr>
										<tr>
											<td scope="row">Desde</td>
											<td><?php 
												if ($tipo_traslado == 1 || $tipo_traslado == 2) {
			                    							echo 'Airport ';
			                    				};
			                    				if ($tipo_traslado == 3) {
			                    							echo $destino_1;
			                    				};
			                    				
			                    				if ($tipo_traslado == 4) {
			                    							echo $destino_1;
			                    				};
												?>
													
											</td>
										</tr>
										<tr>
											<td scope="row">Hacia</td>
											<td>
												<?php echo $destino_2; 
									
												if ($tipo_traslado == 1 || $tipo_traslado == 2) {
			                    							echo $destino_1;
			                    				};
			                    				if ($tipo_traslado == 3) {
			                    							echo 'Airport';
			                    				};
			                    				
			                    				if ($tipo_traslado == 4) {
			                    							$destino_2;
			                    				};
			                    				?>
											</td>
										</tr>
										<tr>
											<td scope="row">Vehiculo</td>
											<td><?php echo $nombre_transporte; ?></td>
										</tr>
										<tr>
											<td scope="row">Pasajeros</td>
											<td><?php echo $personas; ?></td>
										</tr>
									</tbody>
								</table>
								<?php 

								if ($tipo_traslado == 1) {
									?>
									<h5>LLEGADA</h5>
									<table class="table table-sm">
									<tbody>
										<tr>
											<td scope="row">Fecha</td>
											<td><?php echo $fecha_r; ?></td>
										</tr>
										<tr>
											<td scope="row">Desde</td>
											<td><?php 
	                    							echo $destino_1;
												?>		
											</td>
										</tr>
										<tr>
											<td scope="row">Hacia</td>
											<td>
												Aeropuerto
											</td>
										</tr>
										<tr>
											<td scope="row">Vehiculo</td>
											<td><?php echo $nombre_transporte; ?></td>
										</tr>
										<tr>
											<td scope="row">Pasajeros</td>
											<td><?php echo $personas; ?></td>
										</tr>
									</tbody>
								</table>
								<?php
								};

							?>
							</div>


							
							
							
							<dl class="total">
								<dt>Total</dt>
								<dd><?php echo $_SESSION['total_and_extras']." MXN";?></dd>
							</dl>
						</div>
					</div>
					<!-- //Widget -->
				</div>	
		  </div>
			
		</div>
		
		<div class="wrap">
			<div class="row">
				<!--- Content -->
				
				<!--- //Content -->
				
				
				
				<!--- Sidebar -->
				
				<!--- //Sidebar -->
			</div>
		</div>
	</main>
	<!-- //Main -->
	
<!-- Footer -->

      <?php
				include "footer.php";
				
				?>

	<!-- //Footer -->


	
	
	

    <!-- jQuery -->
    <script src="../js/jquery.min.js"></script>
	<script src="../js/jquery.uniform.min.js"></script>
	<script src="../js/jquery.slicknav.min.js"></script>
	
	
	  <script type="text/javascript">
    function validar_clave(e) {


      var email1 = document.getElementById("e_persona").value;
      var email2 = document.getElementById("e_persona2").value;
      
       if (email1 != email2 && email1 != "") {
          alert('Los mails no coinciden...');
          //document.registro
          e.preventDefault();
          return false;
        }
      
    }

    $(function() {
	  populateCountries("country", "city"); 
	  populateCountries("flying_from"); 
  	  
  	  
      $('#formulario').submit(function(e) {
        validar_clave(e);
      });
    });
  </script>
  
 <a href="https://api.whatsapp.com/send?phone=+529983545838" class="btn-wsp" target="_blank">
	<i class="fa fa-whatsapp icono"></i>
	</a>
	
  </body>
</html>