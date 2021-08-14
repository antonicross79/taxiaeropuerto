<?php 
session_start();
$destino_1 = $_POST['ubi1'];
$destino_2 = $_POST['ubi2'];
$destino_3 = $destino_2;
$destino_4 = $destino_1;
$personas= $_POST['people'];
$total_extras= $_POST['total_extras'];
$fecha = $_POST['dep-date'].' '.$_POST['pickup_hour_arrival'].':00';
$fecha_r = $_POST['ret-date'].' '.$_POST['pickup_hour_departure'].':00';
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
$airline= $_POST['Airline'];
$extras = $_SESSION['extras'];
$tipo_traslado = $_POST['modo'];
$suma_precio = $_SESSION['suma_extra'];
$comments = $_POST['comments'];
$pickup_hour = $_POST['pickup_hour'];
$pickup_minute = $_POST['pickup_minute'];

if($tipo_traslado == 2 || $tipo_traslado == 3 || $tipo_traslado == 4){
    $tipo_traslado2 = 1;
}if($tipo_traslado == 1){
    $tipo_traslado2 = 2;
};

//$conexion = mysqli_connect("127.0.0.1","root","6101696","transfer");
	$conexion = mysqli_connect("localhost","canczdhg_taxiaeropuerto","A;2FE+fi","canczdhg_taxiaeropuerto");
if ($fecha_r != '') {
	$sql = "INSERT INTO reservaciones (ubicacion_desde, ubicacion_hasta , transporte, id_t_traslado, nombre_p, telefono_p, email_p, direccion_p, codigo_p, ciudad_p, pais_p, tipo_pago, cantidad_personas, total, fecha_ida, fecha_regreso,aerolinea,modo_viaje,lang,comments,pickup_hour,pickup_minute) VALUES ('".$destino_1."','".$destino_2."','".$nombre_transporte."',".$tipo_traslado2.",'".$nombre_persona."','".$telefono_persona."', '".$email_persona."', '".$direccion_persona."', '".$codigo_postal."', '".$ciudad."', '".$pais."','".$tipo_de_pago."','".$personas."',".$precio_total.", '".$fecha."','".$fecha_r."','".$airline."','".$tipo_traslado."','es','".$comments."','".$pickup_hour."','".$pickup_minute."');";
}else{
	$sql = "INSERT INTO reservaciones (ubicacion_desde, ubicacion_hasta , transporte, id_t_traslado, nombre_p, telefono_p, email_p, direccion_p, codigo_p, ciudad_p, pais_p, tipo_pago, cantidad_personas, total, fecha_ida, aerolinea,modo_viaje,lang, comments,pickup_hour,pickup_minute) VALUES ('".$destino_1."','".$destino_2."','".$nombre_transporte."',".$tipo_traslado2.",'".$nombre_persona."','".$telefono_persona."', '".$email_persona."', '".$direccion_persona."', '".$codigo_postal."', '".$ciudad."', '".$pais."','".$tipo_de_pago."','".$personas."',".$precio_total.", '".$fecha."','".$airline."','".$tipo_traslado."','es','".$comments."','".$pickup_hour."','".$pickup_minute."');";
}

$respuesta = mysqli_query($conexion,$sql);

$sql2 = "SELECT MAX(id_reservacion) FROM reservaciones;";

$respuesta2 = mysqli_query($conexion,$sql2);
$row = mysqli_fetch_array($respuesta2);
$_SESSION['id_reservacion'] = $row['MAX(id_reservacion)'];
foreach ($extras as $extra) {
	$sql = "INSERT INTO extra_reservaciones(id_reservacion,id_extra,cantidad_ida,cantidad_retorno) VALUES('".$row['MAX(id_reservacion)']."','".$extra['id']."','".$extra['ida']."','".$extra['retorno']."')";
	$res = mysqli_query($conexion,$sql);
}

$sql = "SELECT sum(precio*(cantidad_ida+cantidad_retorno)) suma FROM `extra_reservaciones` er join `extras` ex on(ex.id_extra=er.id_extra) where (cantidad_ida != 0 || cantidad_retorno != 0) group by id_reservacion having id_reservacion=".$row['MAX(id_reservacion)'];
$respuestaSumaTotal = mysqli_query($conexion,$sql);
$rowSumaTotal = mysqli_fetch_array($respuestaSumaTotal);

$sql4 = "SELECT * FROM configuraciones;";

$respuesta4 = mysqli_query($conexion,$sql4);
$row4 = mysqli_fetch_array($respuesta4);

$sql = "SELECT count(*) cantidad FROM extras AS ex JOIN extra_reservaciones er ON(er.id_extra=ex.id_extra) WHERE er.id_reservacion=".$row['MAX(id_reservacion)']." AND (cantidad_ida != 0 || cantidad_retorno != 0)";
$respuesta5= mysqli_query($conexion,$sql);
$rowCantidad = mysqli_fetch_array($respuesta5);

$sql = "SELECT * FROM extras AS ex JOIN extra_reservaciones er ON(er.id_extra=ex.id_extra) WHERE er.id_reservacion=".$row['MAX(id_reservacion)']." AND (cantidad_ida != 0 || cantidad_retorno != 0)";
$respuesta6= mysqli_query($conexion,$sql);


if ($tipo_de_pago == 'PAYPAL' ) {

    if($tipo_traslado == 1 || $tipo_traslado == 2){
        $product_name = 'Ticket de Transporte : Airport /'.$destino_2;//Nombre del producto
    };
    if($tipo_traslado == 3){
        $product_name = 'Ticket de Transporte : '.$destino_1.'/Aiport';//Nombre del producto
    };
    if($tipo_traslado == 4){
        $product_name = 'Ticket de Transporte : '.$destino_1.'/'.$destino_2;//Nombre del producto
    };
	
	$product_price = $precio+$suma_precio;//Precio del producto
	$product_currency = $row4['tipo_moneda'];//Moneda del producto 
	//URL Paypal Modo pruebas.
	$paypal_url = $row4['url_paypal'];
	//URL Paypal para Recibir pagos 
	//$paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
	//Correo electronico del comercio. 
     $merchant_email = $row4['correo_paypal'];
	//Pon aqui la URL para redireccionar cuando el pago no es completado
	$cancel_return = "https://taxiaeropuertodecancun.com/es/booking-step2.php";
	//Colocal la URL donde se redicciona cuando el pago fue completado con exito.
	$success_return = "https://taxiaeropuertodecancun.com/es/booking-step3.php";


?>
	<div style="margin-left: 40%"><img src="../img/processing_animation.gif"/>
		<form name="myform" action="<?php echo $paypal_url; ?>" method="post" target="_top">
		    
		    
		<input type="hidden" name="cmd" value="_xclick">
		<input type="hidden" name="cancel_return" value="<?php echo $cancel_return ?>">
		<input type="hidden" name="return" value="<?php echo $success_return; ?>">
		<input type="hidden" name="business" value="<?php echo $merchant_email; ?>">
		<input type="hidden" name="item_name" value="<?php echo $product_name; ?>">
		<input type="hidden" name="item_number" value="<?php echo $row['MAX(id_reservacion)'] ; ?>">

		<input type="hidden" name="amount" value="<?php echo $product_price; ?>">
		<input type="hidden" name="currency_code" value="<?php echo $product_currency; ?>">
		<input type="hidden" name="button_subtype" value="services">
		<input type="hidden" name="no_note" value="0">
		<input name="rm" type="hidden" value="2" />
		</form>
<script type="text/javascript">
document.myform.submit();
</script>

<?php
}

else if ($tipo_de_pago == 'Stripe' ) {

	require_once('stripe/config.php');


    if($tipo_traslado == 1 || $tipo_traslado == 2){
        $product_name = 'Ticket de Transporte : Airport /'.$destino_1;//Nombre del producto
    };
    if($tipo_traslado == 3){
        $product_name = 'Ticket de Transporte : '.$destino_1.'/Aiport';//Nombre del producto
    };
    if($tipo_traslado == 4){
        $product_name = 'Ticket de Transporte : '.$destino_1.'/'.$destino_2;//Nombre del producto
    };
	
	$product_price = $precio+$suma_precio;//Precio del producto
	$_SESSION['product_price'] = $product_price;
	$product_price = $product_price*100;
	$_SESSION['product_name'] = $product_name;

	?>

	<!DOCTYPE html>
	<html>
	  <head><meta charset="utf-8">
		
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<meta name="keywords" content="Private Transport and Car Hire HTML Template" />
		<meta name="description" content="Private Transport and Car Hire HTML Template">
		<meta name="author" content="themeenergy.com">
		
		<title>Cancun Shuttle Airport</title>
		
		<link rel="stylesheet" href="../css/theme-lblue.css" />
		<link rel="stylesheet" href="../css/style.css" />
		<link rel="stylesheet" href="../css/animate.css" />
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Raleway:400,500,600,700|Montserrat:400,700">
		<link rel="shortcut icon" href="images/favicon.ico">
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="../css/styleslideshow.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

		<link rel="stylesheet" href="../css/whatsapp.css" />

	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
	    <style type="text/css">
	    	
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
								/*echo '<div>
											<p>'.$fecha_r.'</p>
											<p>'.$destino_2.'&nbsp  hasta &nbsp'.$destino_1.'</p>
										</div>';*/
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
					<div class="col-xs-12 col-md-9 text-center">
						<h5>Haga click en el boton para pagar con Stripe</h5>
						<form action="stripe/charge.php" method="post">
							<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
						          data-key="<?php echo $stripe['publishable_key']; ?>"
						          data-description="<?php echo $product_name; ?>"
						          data-amount="<?php echo $product_price; ?>"
						          data-locale="auto">
						            
						  </script>
						</form>

					</div>
					<!--- //Content -->
					
					
					
					<!--- Sidebar -->
					<aside class="one-fourth sidebar right col-xs-12 col-md-3 mt-5">
					<!-- Widget -->
					<div class="widget">
						<h4>Booking Summary</h4>
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
	    <script src="../js/jquery.min.js"></script>
		<script src="../js/jquery.uniform.min.js"></script>
		<script src="../js/jquery.slicknav.min.js"></script>
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
	
	<?php	
}

elseif ($tipo_de_pago == 'DIRECTO') {
	


	// Cabeceras para el correo
	$header = "Content-Type: text/html; charset=utf-8\n";
    $header.= "From: Taxiaeropuertodecancun<no-responder@Taxiaeropuertodecancun.com>";
	
	// Servidor SMTP
	ini_set("SMTP","smtp.gmail.com");
	
	
	$email_destinatario = $email_persona;
	$nombre_destinatario = $nombre_persona;
	$aerolineaArray = explode(',', $airline);
	$pmam = intval($pickup_hour)>12?'pm':'am';
	$pickup_hour = intval($pickup_hour)>12?($pickup_hour - 12):$pickup_hour;
	$pickup_hour = intval($pickup_hour)<10?'0'.$pickup_hour:$pickup_hour;
	$pickup_minute = intval($pickup_minute)<10?'0'.$pickup_minute:$pickup_minute;


	switch ($tipo_traslado) {
		case 1:
			$transfer_type.= "Round Trip - Airport > Hotel > Airport";
			$transfer = $destino_1;
			break;
		case 2:
			$transfer_type.= "One Way - Airport > Hotel";
			$transfer = $destino_1;
			break;
		case 3:
			$transfer_type.= "One Way - Hotel > Airport";
			$transfer = $destino_1;
			break;
		case 4:
			$transfer_type.= "One Way - Hotel > Hotel";
			$transfer = $destino_1." - ".$destino_2;
			break;
		default:
			# code...
			break;
	}

	
	
	$contenido_correo.= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		  <head>

		    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		    
		           <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            
                  <style type="text/css">
		          .ExternalClass{width:100%}.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:150%}a{text-decoration:none}body,td,input,textarea,select{margin:unset;font-family:unset}input,textarea,select{font-size:unset}@media screen and (max-width: 600px){table.row th.col-lg-1,table.row th.col-lg-2,table.row th.col-lg-3,table.row th.col-lg-4,table.row th.col-lg-5,table.row th.col-lg-6,table.row th.col-lg-7,table.row th.col-lg-8,table.row th.col-lg-9,table.row th.col-lg-10,table.row th.col-lg-11,table.row th.col-lg-12{display:block;width:100% !important}.d-mobile{display:block !important}.d-desktop{display:none !important}.w-lg-25{width:auto !important}.w-lg-25>tbody>tr>td{width:auto !important}.w-lg-50{width:auto !important}.w-lg-50>tbody>tr>td{width:auto !important}.w-lg-75{width:auto !important}.w-lg-75>tbody>tr>td{width:auto !important}.w-lg-100{width:auto !important}.w-lg-100>tbody>tr>td{width:auto !important}.w-lg-auto{width:auto !important}.w-lg-auto>tbody>tr>td{width:auto !important}.w-25{width:25% !important}.w-25>tbody>tr>td{width:25% !important}.w-50{width:50% !important}.w-50>tbody>tr>td{width:50% !important}.w-75{width:75% !important}.w-75>tbody>tr>td{width:75% !important}.w-100{width:100% !important}.w-100>tbody>tr>td{width:100% !important}.w-auto{width:auto !important}.w-auto>tbody>tr>td{width:auto !important}.p-lg-0>tbody>tr>td{padding:0 !important}.pt-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-top:0 !important}.pr-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-right:0 !important}.pb-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-bottom:0 !important}.pl-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-left:0 !important}.p-lg-1>tbody>tr>td{padding:0 !important}.pt-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-top:0 !important}.pr-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-right:0 !important}.pb-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-bottom:0 !important}.pl-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-left:0 !important}.p-lg-2>tbody>tr>td{padding:0 !important}.pt-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-top:0 !important}.pr-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-right:0 !important}.pb-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-bottom:0 !important}.pl-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-left:0 !important}.p-lg-3>tbody>tr>td{padding:0 !important}.pt-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-top:0 !important}.pr-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-right:0 !important}.pb-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-bottom:0 !important}.pl-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-left:0 !important}.p-lg-4>tbody>tr>td{padding:0 !important}.pt-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-top:0 !important}.pr-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-right:0 !important}.pb-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-bottom:0 !important}.pl-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-left:0 !important}.p-lg-5>tbody>tr>td{padding:0 !important}.pt-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-top:0 !important}.pr-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-right:0 !important}.pb-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-bottom:0 !important}.pl-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-left:0 !important}.p-0>tbody>tr>td{padding:0 !important}.pt-0>tbody>tr>td,.py-0>tbody>tr>td{padding-top:0 !important}.pr-0>tbody>tr>td,.px-0>tbody>tr>td{padding-right:0 !important}.pb-0>tbody>tr>td,.py-0>tbody>tr>td{padding-bottom:0 !important}.pl-0>tbody>tr>td,.px-0>tbody>tr>td{padding-left:0 !important}.p-1>tbody>tr>td{padding:4px !important}.pt-1>tbody>tr>td,.py-1>tbody>tr>td{padding-top:4px !important}.pr-1>tbody>tr>td,.px-1>tbody>tr>td{padding-right:4px !important}.pb-1>tbody>tr>td,.py-1>tbody>tr>td{padding-bottom:4px !important}.pl-1>tbody>tr>td,.px-1>tbody>tr>td{padding-left:4px !important}.p-2>tbody>tr>td{padding:8px !important}.pt-2>tbody>tr>td,.py-2>tbody>tr>td{padding-top:8px !important}.pr-2>tbody>tr>td,.px-2>tbody>tr>td{padding-right:8px !important}.pb-2>tbody>tr>td,.py-2>tbody>tr>td{padding-bottom:8px !important}.pl-2>tbody>tr>td,.px-2>tbody>tr>td{padding-left:8px !important}.p-3>tbody>tr>td{padding:16px !important}.pt-3>tbody>tr>td,.py-3>tbody>tr>td{padding-top:16px !important}.pr-3>tbody>tr>td,.px-3>tbody>tr>td{padding-right:16px !important}.pb-3>tbody>tr>td,.py-3>tbody>tr>td{padding-bottom:16px !important}.pl-3>tbody>tr>td,.px-3>tbody>tr>td{padding-left:16px !important}.p-4>tbody>tr>td{padding:24px !important}.pt-4>tbody>tr>td,.py-4>tbody>tr>td{padding-top:24px !important}.pr-4>tbody>tr>td,.px-4>tbody>tr>td{padding-right:24px !important}.pb-4>tbody>tr>td,.py-4>tbody>tr>td{padding-bottom:24px !important}.pl-4>tbody>tr>td,.px-4>tbody>tr>td{padding-left:24px !important}.p-5>tbody>tr>td{padding:48px !important}.pt-5>tbody>tr>td,.py-5>tbody>tr>td{padding-top:48px !important}.pr-5>tbody>tr>td,.px-5>tbody>tr>td{padding-right:48px !important}.pb-5>tbody>tr>td,.py-5>tbody>tr>td{padding-bottom:48px !important}.pl-5>tbody>tr>td,.px-5>tbody>tr>td{padding-left:48px !important}.s-lg-1>tbody>tr>td,.s-lg-2>tbody>tr>td,.s-lg-3>tbody>tr>td,.s-lg-4>tbody>tr>td,.s-lg-5>tbody>tr>td{font-size:0 !important;line-height:0 !important;height:0 !important}.s-0>tbody>tr>td{font-size:0 !important;line-height:0 !important;height:0 !important}.s-1>tbody>tr>td{font-size:4px !important;line-height:4px !important;height:4px !important}.s-2>tbody>tr>td{font-size:8px !important;line-height:8px !important;height:8px !important}.s-3>tbody>tr>td{font-size:16px !important;line-height:16px !important;height:16px !important}.s-4>tbody>tr>td{font-size:24px !important;line-height:24px !important;height:24px !important}.s-5>tbody>tr>td{font-size:48px !important;line-height:48px !important;height:48px !important}}@media yahoo{.d-mobile{display:none !important}.d-desktop{display:block !important}.w-lg-25{width:25% !important}.w-lg-25>tbody>tr>td{width:25% !important}.w-lg-50{width:50% !important}.w-lg-50>tbody>tr>td{width:50% !important}.w-lg-75{width:75% !important}.w-lg-75>tbody>tr>td{width:75% !important}.w-lg-100{width:100% !important}.w-lg-100>tbody>tr>td{width:100% !important}.w-lg-auto{width:auto !important}.w-lg-auto>tbody>tr>td{width:auto !important}.p-lg-0>tbody>tr>td{padding:0 !important}.pt-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-top:0 !important}.pr-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-right:0 !important}.pb-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-bottom:0 !important}.pl-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-left:0 !important}.p-lg-1>tbody>tr>td{padding:4px !important}.pt-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-top:4px !important}.pr-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-right:4px !important}.pb-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-bottom:4px !important}.pl-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-left:4px !important}.p-lg-2>tbody>tr>td{padding:8px !important}.pt-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-top:8px !important}.pr-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-right:8px !important}.pb-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-bottom:8px !important}.pl-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-left:8px !important}.p-lg-3>tbody>tr>td{padding:16px !important}.pt-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-top:16px !important}.pr-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-right:16px !important}.pb-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-bottom:16px !important}.pl-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-left:16px !important}.p-lg-4>tbody>tr>td{padding:24px !important}.pt-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-top:24px !important}.pr-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-right:24px !important}.pb-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-bottom:24px !important}.pl-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-left:24px !important}.p-lg-5>tbody>tr>td{padding:48px !important}.pt-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-top:48px !important}.pr-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-right:48px !important}.pb-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-bottom:48px !important}.pl-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-left:48px !important}.s-lg-0>tbody>tr>td{font-size:0 !important;line-height:0 !important;height:0 !important}.s-lg-1>tbody>tr>td{font-size:4px !important;line-height:4px !important;height:4px !important}.s-lg-2>tbody>tr>td{font-size:8px !important;line-height:8px !important;height:8px !important}.s-lg-3>tbody>tr>td{font-size:16px !important;line-height:16px !important;height:16px !important}.s-lg-4>tbody>tr>td{font-size:24px !important;line-height:24px !important;height:24px !important}.s-lg-5>tbody>tr>td{font-size:48px !important;line-height:48px !important;height:48px !important}}

		        </style>
		</head>
		  <body style="outline: 0; width: 100%; min-width: 100%; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 24px; font-weight: normal; font-size: 16px; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; color: #000000; margin: 0; padding: 0; border: 0;" bgcolor="#ffffff">
		<table valign="top" class="bg-light body" style="outline: 0; width: 100%; min-width: 100%; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 24px; font-weight: normal; font-size: 16px; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; color: #000000; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; margin: 0; padding: 0; border: 0;" bgcolor="#f8f9fa">
		  <tbody>
		    <tr>
		      <td valign="top" style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; margin: 0;" align="left" bgcolor="#f8f9fa">
		        
		    <table class="container" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%;">
		  <tbody>
		    <tr>
		      <td align="center" style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; margin: 0; padding: 0 16px;">
		        <!--[if (gte mso 9)|(IE)]>
		          <table align="center">
		            <tbody>
		              <tr>
		                <td width="600">
		        <![endif]-->
		        <table align="center" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%; margin: 0 auto;">
		          <tbody>
		            <tr>
		              <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; margin: 0;" align="left">
		                
		      <div style="background-color: #33a5ff;">';
      $contenido_correo.='<img src="https://taxiaeropuertodecancun.com/images/logocancuntransportation.jpeg" width="130" height="40" style="height: auto; line-height: 100%; outline: none; text-decoration: none; border: 0 none;">
		<h2 style="float: right; padding-top: 20px; padding-right: 10px; color: #fff; margin-top: 0; margin-bottom: 0; font-weight: 500; vertical-align: baseline; font-size: 22px; line-height: 38.4px;" align="left">
		Hi, '.$nombre_persona.'!
		</h2>
		</div>
		<table class="s-4 w-100" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
		  <tbody>
		    <tr>
		      <td height="24" style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 24px; width: 100%; height: 24px; margin: 0;" align="left">
		         
		      </td>
		    </tr>
		  </tbody>
		</table>

		<div class="">
		<p style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left">
		¡Buscar el logo es más fácil que buscar tu nombre entre toda la multitud!</p>

		<p style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left">Gracias por confiar en Cancun Transportation ™ con sus servicios de transporte en Cancún y la Riviera Maya.</p>

		<p style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left">Los detalles de su reserva se encuentran a continuación. Si alguna información a continuación no es correcta, comuníquese con nosotros inmediatamente con la corrección. Al llegar al aeropuerto es muy importante que lea atentamente nuestras sugerencias para un acceso más rápido y seguro a su transporte.</p>

		<p class="text-primary" style="line-height: 24px; font-size: 16px; width: 100%; color: #007bff; margin: 0;" align="left"><strong>RECUERDA IMPRIMIR Y LLEVAR ESTE VOUCHER Y PRESENTARLO A NUESTRO PERSONAL DE BIENVENIDA EN EL AEROPUERTO.
		</strong></p>
		</div>
		<table class="s-3 w-100" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
		  <tbody>
		    <tr>
		      <td height="16" style="border-spacing: 0px; border-collapse: collapse; line-height: 16px; font-size: 16px; width: 100%; height: 16px; margin: 0;" align="left">
		         
		      </td>
		    </tr>
		  </tbody>
		</table>

		<div class="">
		<span>Su codigo de Confirmación es: <b>CT0000000'.$row['MAX(id_reservacion)'].'</b></span>
		<span style="float: right;">TOTAL: <b>'.($rowSumaTotal['suma']+$precio_total).',00 MXN</b></span>
		</div>
		<table class="s-4 w-100" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
		  <tbody>
		    <tr>
		      <td height="24" style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 24px; width: 100%; height: 24px; margin: 0;" align="left">
		         
		      </td>
		    </tr>
		  </tbody>
		</table>

		<table class="table " border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%; max-width: 100%;">
		  <thead>
		    <tr>
		      <th width="25%" style="line-height: 24px; border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">TRASLADO</th>
		      <th width="25%" style="line-height: 24px; border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">SERVICIO</th>
		      <th width="25%" style="line-height: 24px; border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">VEHICULO</th>
		      <th width="25%" style="line-height: 24px; border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">PASAJERO(S)</th>
		    </tr>
		  </thead>
		  <tbody>
		    <tr>
		      <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$transfer_type.'</td>
		      <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">Private</td>
		      <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$nombre_transporte.'</td>
		      <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$personas.'</td>
		    </tr>
		  </tbody>
		</table>
		<table class="table" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%; max-width: 100%;">
		  <thead>
		    <tr>
		      <th width="50%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">HOTEL</th>
		      <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">FECHA LLEGADA</th>
		      <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">FECHA SALIDA</th>
		    </tr>
		  </thead>
		  <tbody>
		    <tr>
		      <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$transfer.'</td>
		      <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$fecha.'</td>
		      <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$fecha_r.'</td>
		    </tr>
		  </tbody>
		</table>
		<table class="table" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%; max-width: 100%;">
		  <thead>
		    <tr>
		      <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">VUELO DESDE</th>
		      <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">AEROLINEA</th>
		      <th width="50%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">VUELO NUMERO</th>
		    </tr>
		  </thead>
		  <tbody>
		    <tr>
		      <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$aerolineaArray[0].'</td>
		      <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$aerolineaArray[1].'</td>
		      <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$aerolineaArray[2].'</td>
		    </tr>
		  </tbody>
		</table>
		<table class="table" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%; max-width: 100%;">
		  <thead>
		    <tr>
		      <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">NOMBRE</th>
		      <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">CORREO</th>
		      <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">TELEFONO</th>
		      <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">PAIS</th>
		    </tr>
		  </thead>
		  <tbody>
		    <tr>
		      <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$nombre_persona.'</td>
		      <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$email_persona.'</td>
		      <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$telefono_persona.'</td>
		      <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$pais.'</td>
		    </tr>
		  </tbody>
		</table>
		<table class="table" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%; max-width: 100%;">
		  <thead>
		    <tr>
		    <th style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">TIEMPO DE RECOGIDA</th>
		      <th style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">COMMENTARIOS</th>
		    </tr>
		  </thead>
		  <tbody>
		    <tr>
		    <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$pickup_hour.':'.$pickup_minute.' '.$pmam.'</td>
		      <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$comments.'</td>
		    </tr>
		  </tbody>
		</table>';
				if($rowCantidad['cantidad'] != 0){
				$contenido_correo.= '
		      <div style="color: #fff; background-color: #33a5ff; padding: 15px;">
		        <h5 style="margin-top: 0; margin-bottom: 0; font-weight: 500; vertical-align: baseline; font-size: 20px; line-height: 24px;" align="left">Extras:</h5>
		      </div>
		      <table class="table" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%; max-width: 100%;">
		  <thead>
		    <tr>
		      <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">NOMBRE</th>
		      <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">CANTIDAD</th>
		      <th width="25%" style="line-height: 24px;  border-bottom-width: 2px; border-bottom-color: #dee2e6; border-bottom-style: solid; border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">PRECIO UNIDAD</th>
		    </tr>
		  </thead>
		  <tbody>';
			$retorno_sum = "";				      
			while($rowExtra = mysqli_fetch_array($respuesta6)){

				if(intval($rowExtra['cantidad_retorno']) != 0 && intval($rowExtra['cantidad_ida']) != 0){
					$retorno_sum = $rowExtra['cantidad_ida']." on departure And ".$rowExtra['cantidad_retorno']." on return";
				}elseif(intval($rowExtra['cantidad_retorno']) != 0){
					$retorno_sum = $rowExtra['cantidad_retorno']." on return";
				}else{
					$retorno_sum = $rowExtra['cantidad_ida']." on departure";
				}
				$contenido_correo.= '<tr>
										<td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$rowExtra['n_extra'].'</td>
										<td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$retorno_sum.'</td>
										<td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$rowExtra['precio'].'</td>
								      </tr>';	
			}
			$contenido_correo.= '<tr>	
										<td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">Total Extras:</td>
	                                    <td></td>
	                                    <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px;  border-top-width: 1px; border-top-color: #dee2e6; border-top-style: solid; margin: 0;" align="left" valign="top">'.$suma_precio.',00 MXN</td>
	                                  </tr>';   
			$contenido_correo.= '</tbody></table>';
			}//end if extras
			$contenido_correo.='
		      <div style="" align="center">
		      <table class="s-3 w-100" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
		  <tbody>
		    <tr>
		      <td height="16" style="border-spacing: 0px; border-collapse: collapse; line-height: 16px; font-size: 16px; width: 100%; height: 16px; margin: 0;" align="left">
		         
		      </td>
		    </tr>
		  </tbody>
		</table>
		<table class="alert alert-success " border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: separate !important; width: 100%; border: 0;">
		  <tbody>
		    <tr>
		      <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; border-radius: 4px; color: #0a2c12; margin: 0; padding: 12px 20px; border: 1px solid transparent;" align="left" bgcolor="#afecbd">
		        <div style="text-align:center;">
		  PAGADO EN EFECTIVO<br>
		  <b>RECUERDE pagar en efectivo con MXN o USD <br> a su llegada a nuestro operador</b>
		</div>
		      </td>
		    </tr>
		  </tbody>
		</table>

		        </div>
		    
		              </td>
		            </tr>
		          </tbody>
		        </table>
		        <!--[if (gte mso 9)|(IE)]>
		                </td>
		              </tr>
		            </tbody>
		          </table>
		        <![endif]-->
		      </td>
		    </tr>
		  </tbody>
		</table>
		      </td>
		    </tr>
    
		  </tbody>
		</table>
		


<table class="s-4 w-100" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
<thead>
  <tr>
     <th><img src="https://taxiaeropuertodecancun.com/images/operator.jpeg" alt="transfers private cancun"  width="150" height="200"></th>
    <td colspan="2">Estaremos encantados de brindarle información adicional sobre servicios y actividades.
Su reserva se ha completado; puede cancelar su reserva hasta 3 días antes del servicio con una multa del 10%. No habrá reembolso por cancelaciones el mismo día de servicio.
A su llegada a CUN (Aeropuerto Internacional de Cancún), siga estas recomendaciones para garantizar un acceso fácil y rápido a su vehículo.
 </td>
  </tr>
</thead>
<tbody>
  <tr>
    <tr><h3>POLITICAS</h3> </tr>
    <td colspan="2"><b>SALIDAS</b>: Para vuelos internacionales debe estar en el aeropuerto al menos 3:00 horas antes de su hora de salida, en el caso de vuelos nacionales el mínimo es 2 horas antes de su hora de salida.<br>
<b>Cancun Shuttle Airport</b> no será responsable de ningún inconveniente o pérdida del vuelo en caso de que decida llegar más tarde de la hora sugerida. El conductor lo esperará hasta 15 minutos en el Lobby de su hotel, después de ese tiempo el vehículo saldrá del hotel sin responsabilidad por Cancun Shuttle Airport " no se aplican reembolsos si esto sucede.<br>
A continuación, encontrará información importante sobre los servicios de transporte que ha concertado con nosotros: <br>
<ul><li>Cancun Shuttle Airport TM es una empresa legalmente establecida con los más altos estándares de calidad y servicio y le brinda un servicio sin preocupaciones desde y hacia el aeropuerto. </li>
    <li> Puede cancelar su reserva hasta 4 días antes del servicio con una multa del 10%. No habrá reembolsos por cancelaciones hechas 3 días o menos antes del servicio.</li>
    <li>Para cancelaciones, avísenos con al menos 3 días de anticipación. Para modificaciones o actualizaciones de reservas, debe comunicarse con nuestro departamento de reservas por teléfono, correo electrónico o chat. Los conductores no son responsables de notificaciones o modificaciones a las reservas.</li>
    <li>Nuestros Contactos:</li>
  <li> Staff en el aeropuerto (llegadas): +52 998 110 5994 o Office phone: +52 998 354 5838 OR +52 998 241 6255</li> 
  <li>LUN to VIE: de 9:00 AM a 11:00 PM o SAB y DOM: de 9:00 AM a 7:00 PM</li>
  </td>
  </tr>
</tbody>
</table>



		
		
	
		</body>
		</html>
';
		
		if(mail($email_destinatario,utf8_decode("Taxiaeropuertodecancun Ticket"),$contenido_correo,$header)){
			$respuestas = "Correo enviado con &eacute;xito a: ".$nombre_destinatario." ".$email_destinatario."<br>";
		}
		else{
			$respuesta = "<font color='red'>No se pudo enviar el correo a:  ".$nombre_destinatario." ".$email_destinatario."</font><br>";
		}
		
		mail("delfo2332@hotmail.com",utf8_decode("TaxiAeropuertodeCancun Ticket Reservation"),$contenido_correo,$header);
		mail("pauescamilla05@gmail.com",utf8_decode("TaxiAeropuertodeCancun Ticket Reservation"),$contenido_correo,$header);
		mail("cantranportation18@gmail.com",utf8_decode("TaxiAeropuertodeCancun Ticket Reservation"),$contenido_correo,$header);
		mail("antonicross@gmail.com",utf8_decode("TaxiAeropuertodeCancun Ticket Reservation"),$contenido_correo,$header);


?>
	<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="keywords" content="Private Transport and Car Hire HTML Template" />
	<meta name="description" content="Private Transport and Car Hire HTML Template">
	<meta name="author" content="themeenergy.com">
	
	<title>Booking step 3</title>
	
	<link rel="stylesheet" href="../css/theme-dblue.css" />
	<link rel="stylesheet" href="../css/fondo-gracias.css">
	<link rel="stylesheet" href="../css/style.css" />
	<link rel="stylesheet" href="../css/animate.css" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Raleway:400,500,600,700|Montserrat:400,700">
	<link rel="shortcut icon" href="../images/favicon.ico">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="../css/styleslideshow.css" />
	<link rel="stylesheet" href="../css/whatsapp.css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
  <body>
    <!-- Header -->
              <?php
				include "header.php";
				
				?>
		<!-- //Header -->
	<!-- Main -->
	<main class="main" role="main">
		<!-- Page info -->
		<header class="site-title color">
			<div class="wrap">
				<div class="container">
					<h1>¡Gracias Por su Reserva!</h1>
				</div>
			</div>
		</header>
		<!-- //Page info -->
		
		<div class="wrap">
			<div class="row">
				<div class="three-fourth">
				    <div class="fondo">
				        <br><br>
					<form class="box readonly">
						<center><h1>¡GRACIAS POR RESERVAR CON NOSOTROS!</h1><br>
						<h3>Le enviamos los datos de su reserva a su correo.</h3>
						
							<p><img src="/images/calidad.png" alt="transfers private cancun" width="200" heigth="200"> <br></p>
							
						<a href="https://taxiaeropuertodecancun.com/es/index.php">Ir a Pagina Principal</a>
					</form> </center>
					</div>
				</div>
				
				<!--- Sidebar -->
				<?php
				include "sidebar.php"
				?>
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
	<div class="preloader">
		<div id="followingBallsG">
			<div id="followingBallsG_1" class="followingBallsG"></div>
			<div id="followingBallsG_2" class="followingBallsG"></div>
			<div id="followingBallsG_3" class="followingBallsG"></div>
			<div id="followingBallsG_4" class="followingBallsG"></div>
		</div>
	</div>
	<!-- //Preloader -->

    <!-- jQuery -->
    <script src="../js/jquery.min.js"></script>
	<script src="../js/jquery.uniform.min.js"></script>
	<script src="../js/jquery.slicknav.min.js"></script>
	<script src="../js/wow.min.js"></script>
	<script src="../js/scripts.js"></script>
	
	<a href="https://api.whatsapp.com/send?phone=+529983545838" class="btn-wsp" target="_blank">
	<i class="fa fa-whatsapp icono"></i>
	</a>
	
  </body>
</html>

<?php 
}


?>