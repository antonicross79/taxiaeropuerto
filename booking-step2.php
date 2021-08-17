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
	$total_extras= $_POST['total_extras'];

	$nombre_persona = $_POST['n_persona'];
	$telefono_persona = $_POST['t_persona'];
	$email_persona = $_POST['e_persona'];
	$direccion_persona = $_POST['d_persona'];
	$codigo_postal= $_POST['zip'];
	$ciudad= $_POST['city'];
	$pais= $_POST['country'];
	$airline=$_POST['flying_from'].','.$_POST['Airline'].','.$_POST['flight_number'];
	$comments = $_POST['comments'];
	$pickup_hour = $_POST['pickup_hour'];
	$pickup_minute = $_POST['pickup_minute'];

	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$is_firefox = false;
	if(stripos($user_agent,'Firefox') !== false){
		$is_firefox = true;
	}


	//$conexion = mysqli_connect("127.0.0.1","root","6101696","transfer");
		$conexion = mysqli_connect("localhost","canczdhg_taxiaeropuerto","A;2FE+fi","canczdhg_taxiaeropuerto");
		
		
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




	?><!DOCTYPE html>
	<html>
	  <head><meta charset="utf-8">
		
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<meta name="keywords" content="Private Transport and Car Hire HTML Template" />
		<meta name="description" content="Private Transport and Car Hire HTML Template">
		<meta name="author" content="themeenergy.com">
		
		<title>Cancun Shuttle Airport</title>
		
		<link rel="stylesheet" href="css/theme-lblue.css" />
		<link rel="stylesheet" href="css/style.css" />
		<link rel="stylesheet" href="css/animate.css" />
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Raleway:400,500,600,700|Montserrat:400,700">
		<link rel="shortcut icon" href="images/favicon.ico">
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/styleslideshow.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

		<link rel="stylesheet" href="css/whatsapp.css" />

	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
	    <style type="text/css">
	    	
	    </style>
	    
	   <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-PZLBPB41VC"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-PZLBPB41VC');
</script>

<!-- Event snippet for reservar conversion page -->
<script>
  gtag('event', 'conversion', {
      'send_to': 'AW-319886299/kK90CJTm2OYCENunxJgB',
      'transaction_id': ''
  });
</script>




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
			<div class="output color twoway">
				<div class="container-fluid">
				
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
								echo '<div>
											<p>'.$fecha_r.'</p>
											<p>'.$destino_2.'&nbsp  hasta &nbsp'.$destino_1.'</p>
										</div>';
							}


						?>
				</div>
			</div>
			<!-- //Search -->
			
			
				<?php
			if ($is_firefox == true) {
				?>
				<div class="full-width content container-fluid">
				<div class="row">
				<?php
			}else{
				?>
				<div class="container-fluid">
				<div class="row">
				<?php
			}
			?>
					<!--- Content -->
					<div class="col-xs-12 col-md-9">
						<h2>PAY CASH</h2>
						<p>Please select one of the payment methods to make your reservation.</p>
						<img src="/images/pago-seguro.png" alt="transfers private cancun" width="350" heigth="250">
						<div>
						<form action="redirigir_pago_new_format.php" method="POST">
							<div class="form-check">
							  <input class="form-check-input" type="radio" name="t_pago" id="t_pago1" value="DIRECTO" checked style="width: 12px;height: 12px">
							  <label class="form-check-label" for="t_pago1">
							    Direct Payment. Pay when boarding
							  </label>
								</div>
								<div class="form-check">
								  <input class="form-check-input" type="radio" name="t_pago" id="t_pago2" value="PAYPAL" style="width: 12px;height: 12px">
								  <label class="form-check-label" for="t_pago2">
								    Secure payment with Paypal
								  </label>
								</div>  
								<div class="form-check">
								  <input class="form-check-input" type="radio" name="t_pago" id="t_pago3" value="Stripe" style="width: 12px;height: 12px">
								  <label class="form-check-label" for="t_pago3">
								    Secure payment with Stripe
								  </label>
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


									<input type="hidden" id="n_persona" name="n_persona" value="'.$nombre_persona.'"/>
								
									<input type="hidden" id="t_persona" name="t_persona" value="'.$telefono_persona.'"/>
								
									<input type="hidden" id="e_persona" name="e_persona" value="'.$email_persona.'"/>
								
							
									<input type="hidden" id="d_persona" name="d_persona" value="'.$direccion_persona.'"/>

									<input type="hidden" id="zip" name="zip" value="'.$codigo_postal.'"/>
							
									<input type="hidden" id="city" name="city" value="'.$ciudad.'"/>
								    <input type="hidden" name="total_extras" value="'.$total_extras.'"/>
									<input type="hidden" id="country" name="country" value="'.$pais.'"/>
									<input type="hidden" id="Airline" name="Airline" value="'.$airline.'"/>
									<input type="hidden" id="Comments" name="comments" value="'.$comments.'"/>
									<input type="hidden" id="Comments" name="pickup_minute" value="'.$pickup_minute.'"/>
									<input type="hidden" id="Comments" name="pickup_hour" value="'.$pickup_hour.'"/>
									<input type="hidden" name="pickup_hour_arrival" value="'.$_POST['pickup_hour_arrival'].'"/>
									<input type="hidden" name="pickup_hour_departure" value="'.$_POST['pickup_hour_departure'].'"/>';

							?>
							<button type="submit" class="btn medium color mt-3" >Continue</button>
						</form>
					</div>
					</div>
					<!--- //Content -->
					
					
					
					<!--- Sidebar -->
					<aside class="one-fourth sidebar right col-xs-12 col-md-3 mt-5">
					<!-- Widget -->
					<div class="widget">
						<h4>Booking summary</h4>
						<div class="summary" style="padding: 10px;">
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
			                    							echo 'Aeropuerto ';
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
			                    							echo 'Aeropuerto';
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
											<td scope="row">Cant de personas</td>
											<td><?php echo $personas; ?></td>
										</tr>
									</tbody>
								</table>
								<?php 

								if ($tipo_traslado == 1) {
									?>
									<h5>Llegada</h5>
									<table class="table table-sm">
									<tbody>
										<tr>
											<td scope="row">Date</td>
											<td><?php echo $fecha_r; ?></td>
										</tr>
										<tr>
											<td scope="row">From</td>
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
											<td scope="row">Cant de personas</td>
											<td><?php echo $personas; ?></td>
										</tr>
									</tbody>
								</table>
								<?php
								};

							?>


							
							
							
							<dl class="total">
								<dt>Total</dt>
								<dd><?php echo $_SESSION['total_and_extras']; ?></dd>
							</dl>
						</div>
					</div>
					<!-- //Widget -->
				</div>
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

		
		<!-- Preloader -->
		<!-- //Preloader -->

	    <!-- jQuery -->
	    <script src="js/jquery.min.js"></script>
		<script src="js/jquery.uniform.min.js"></script>
		<script src="js/jquery.slicknav.min.js"></script>
		<script type="text/javascript">
			window.onload = function () {
			$('.main-nav').slicknav({
				prependTo:'.header .wrap',
				label:''
			});
      	}
		</script>
		  <a href="https://api.whatsapp.com/send?phone=+529982930168" class="btn-wsp" target="_blank">
		<i class="fa fa-whatsapp icono"></i>
		</a>
		
	  </body>
	</html>