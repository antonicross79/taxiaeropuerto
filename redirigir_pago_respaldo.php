<?php 

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

//$conexion = mysqli_connect("127.0.0.1","root","6101696","transfer");
	$conexion = mysqli_connect("localhost","canczdhg_taxiaeropuerto","A;2FE+fi","canczdhg_taxiaeropuerto");


if ($tipo_de_pago == 'PAYPAL' ) {
	$product_name = 'Ticket de Transporte :'.$destino_1.'/'.$destino_2 ;//Nombre del producto
	$product_price = $precio;//Precio del producto
	$product_currency = 'MXN';//Moneda del producto 
	//URL Paypal Modo pruebas.
	$paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	//URL Paypal para Recibir pagos 
	//$paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
	//Correo electronico del comercio. 
     $merchant_email = 'antonicross@gmail.com';
	//Pon aqui la URL para redireccionar cuando el pago es completado
	$cancel_return = "https://taxiaeropuertodecancun.com/booking-step2.php";
	//Colocal la URL donde se redicciona cuando el pago fue completado con exito.
	$success_return = "https://taxiaeropuertodecancun.com/booking-step3.php";
?>
	<div style="margin-left: 40%"><img src="img/processing_animation.gif"/>
<form name="myform" action="<?php echo $paypal_url; ?>" method="post" target="_top">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="cancel_return" value="<?php echo $cancel_return ?>">
<input type="hidden" name="return" value="<?php echo $success_return; ?>">
<input type="hidden" name="business" value="<?php echo $merchant_email; ?>">
<input type="hidden" name="lc" value="C2">
<input type="hidden" name="item_name" value="<?php echo $product_name; ?>">
<input type="hidden" name="item_number" value="1">
<input type="hidden" name="amount" value="<?php echo $product_price; ?>">
<input type="hidden" name="currency_code" value="<?php echo $product_currency; ?>">
<input type="hidden" name="button_subtype" value="services">
<input type="hidden" name="no_note" value="0">
</form>
<script type="text/javascript">
document.myform.submit();
</script>

<?php
}
elseif ($tipo_de_pago == 'DIRECTO') {
	
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
	
	<link rel="stylesheet" href="css/theme-lblue.css" />
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="css/animate.css" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Raleway:400,500,600,700|Montserrat:400,700">
	<link rel="shortcut icon" href="images/favicon.ico">
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/styleslideshow.css" />
	<link rel="stylesheet" href="css/whatsapp.css" />

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
					<h1>Thank you. Your booking is now confirmed.</h1>
				</div>
			</div>
		</header>
		<!-- //Page info -->
		
		<div class="wrap">
			<div class="row">
				<div class="three-fourth">
					<form class="box readonly">
						<h3>Passenger details</h3>
						<div class="f-row">
							<div class="one-fourth">Name and surname</div>
							<div class="three-fourth">John Doe</div>
						</div>
						<div class="f-row">
							<div class="one-fourth">Mobile number</div>
							<div class="three-fourth">00386 30 555 555</div>
						</div>
						<div class="f-row">
							<div class="one-fourth">Email address</div>
							<div class="three-fourth">john.doe@email.com</div>
						</div>
						<div class="f-row">
							<div class="one-fourth">Street address</div>
							<div class="three-fourth">1036 Awesome Lane</div>
						</div>
						<div class="f-row">
							<div class="one-fourth">Zip code</div>
							<div class="three-fourth">21462</div>
						</div>
						<div class="f-row">
							<div class="one-fourth">City</div>
							<div class="three-fourth">Transferville</div>
						</div>
						<div class="f-row">
							<div class="one-fourth">Country</div>
							<div class="three-fourth">Drivingland</div>
						</div>
						
						<h3>Departure Transfer details</h3>
						<div class="f-row">
							<div class="one-fourth">Date</div>
							<div class="three-fourth">28.08.2014 10:00</div>
						</div>
						<div class="f-row">
							<div class="one-fourth">From</div>
							<div class="three-fourth">London bus station</div>
						</div>
						<div class="f-row">
							<div class="one-fourth">To</div>
							<div class="three-fourth">London airport</div>
						</div>
						<div class="f-row">
							<div class="one-fourth">Vehicle</div>
							<div class="three-fourth">Private shuttle</div>
						</div>
						<div class="f-row">
							<div class="one-fourth">Extras</div>
							<div class="three-fourth">2 pieces of baggage up to 15kg</div>
						</div>
						
						<h3>Return Transfer details</h3>
						<div class="f-row">
							<div class="one-fourth">Date</div>
							<div class="three-fourth">02.09.2014 17:00</div>
						</div>
						<div class="f-row">
							<div class="one-fourth">From</div>
							<div class="three-fourth">London airport</div>
						</div>
						<div class="f-row">
							<div class="one-fourth">To</div>
							<div class="three-fourth">London bus station</div>
						</div>
						<div class="f-row">
							<div class="one-fourth">Vehicle</div>
							<div class="three-fourth">Private shuttle</div>
						</div>
						<div class="f-row">
							<div class="one-fourth">Extras</div>
							<div class="three-fourth">2 pieces of baggage up to 15kg</div>
						</div>
						
						<h3>TOTAL: 840,00 MXN</h3>
					</form>
				</div>
				
				<!--- Sidebar -->
				
         <?php
				include "sidebar.php";
				
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
    <script src="js/jquery.min.js"></script>
	<script src="js/jquery.uniform.min.js"></script>
	<script src="js/jquery.slicknav.min.js"></script>
	<script src="js/wow.min.js"></script>
	<script src="js/scripts.js"></script>
	
  </body>
</html>

<?php 
}


?>