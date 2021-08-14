<?php 
session_start();
$destino_1 = $_POST['ubi1'];
$destino_2 = $_POST['ubi2'];
$destino_3 = $destino_2;
$destino_4 = $destino_1;
$personas= $_POST['people'];
$total_extras= $_POST['total_extras'];
$fecha = $_POST['dep-date'].' '.$_POST['pickup_hour_arrival'];
$fecha_r = $_POST['ret-date'].' '.$_POST['pickup_hour_departure'];
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

if($tipo_traslado == 2 || $tipo_traslado == 3 || $tipo_traslado == 4){
    $tipo_traslado2 = 1;
}if($tipo_traslado == 1){
    $tipo_traslado2 = 2;
};

//$conexion = mysqli_connect("127.0.0.1","root","6101696","transfer");
	$conexion = mysqli_connect("localhost","canczdhg_taxiaeropuerto","A;2FE+fi","canczdhg_taxiaeropuerto");
	
if ($fecha_r != '') {
	$sql = "INSERT INTO reservaciones (ubicacion_desde, ubicacion_hasta , transporte, id_t_traslado, nombre_p, telefono_p, email_p, direccion_p, codigo_p, ciudad_p, pais_p, tipo_pago, cantidad_personas, total, fecha_ida, fecha_regreso,aerolinea,modo_viaje,lang,comments) VALUES ('".$destino_1."','".$destino_2."','".$nombre_transporte."',".$tipo_traslado2.",'".$nombre_persona."','".$telefono_persona."', '".$email_persona."', '".$direccion_persona."', '".$codigo_postal."', '".$ciudad."', '".$pais."','".$tipo_de_pago."','".$personas."',".$precio_total.", '".$fecha."','".$fecha_r."','".$airline."','".$tipo_traslado."','en','".$comments."');";
}else{
	$sql = "INSERT INTO reservaciones (ubicacion_desde, ubicacion_hasta , transporte, id_t_traslado, nombre_p, telefono_p, email_p, direccion_p, codigo_p, ciudad_p, pais_p, tipo_pago, cantidad_personas, total, fecha_ida, aerolinea,modo_viaje,lang, comments) VALUES ('".$destino_1."','".$destino_2."','".$nombre_transporte."',".$tipo_traslado2.",'".$nombre_persona."','".$telefono_persona."', '".$email_persona."', '".$direccion_persona."', '".$codigo_postal."', '".$ciudad."', '".$pais."','".$tipo_de_pago."','".$personas."',".$precio_total.", '".$fecha."','".$airline."','".$tipo_traslado."','en','".$comments."');";
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
elseif ($tipo_de_pago == 'DIRECTO') {
	


	// Cabeceras para el correo
	$header = "Content-Type: text/html; charset=utf-8\n";
    $header.= "From: Taxiaeropuertodecancun<no-responder@taxiaeropuertodecancun.com>";
	
	// Servidor SMTP
	ini_set("SMTP","smtp.gmail.com");
	
	
	$email_destinatario = $email_persona;
	$nombre_destinatario = $nombre_persona;
	
	$contenido_correo.= "<hr style= 'border: 4px solid #3e9efe ' width:100%;  />" ;
	
	
    $contenido_correo.= "<img src='https://taxiaeropuertodecancun.com/images/logocancuntransportation.jpeg' style='width:35%;'><br>" ;
    $contenido_correo.= "<p><h2><strong> Your Confirmation code is: CT0000000".$row['MAX(id_reservacion)']."</h2></p>";
    $contenido_correo.= "<p style='border: 4px solid #3e9efe; background-color:#33A5FF; color: white; font-family: arial,helvetica; font-size: 44px; font-weight: bold;text-align: center;'>WELCOME  ".$nombre_persona." </p>";
//	$contenido_correo.= "<img src='https://cancunshuttleairport.com/images/welcome.jpg' style='width:100%;'><br>";
    $contenido_correo.= "<p><b>¡Looking for the logo is easier than looking for your name among the whole crowd! </b></p>";
    $contenido_correo.="<p>Thank you for trusting <b>Cancun Transportation™</b> with your Cancun and Riviera Maya transportation services.</p>"; 
    $contenido_correo.="<p>Your reservation details are below. If any information below is not correct, please contact us immediately with the correction. Upon arrival to the airport is very important that you carefully read our suggestions for a faster and safer access to your transportation.</p>"; 
    $contenido_correo.= "<p>REMEMBER TO PRINT AND BRING THIS VOUCHER WITH YOU AND PRESENT IT TO OUR WELCOMING STAFF AT THE AIRPORT.</p>";
    $contenido_correo.= "<img src='https://taxiaeropuertodecancun.com/images/personalinformation.jpg' style='width:100%;'>";
	
                         
	$contenido_correo.= "<p><b>Name and surname</b>: ".$nombre_persona."</p>";
	$contenido_correo.= "<p><b>Mobile number</b>: ".$telefono_persona."</p>";
	$contenido_correo.= "<p><b>Email address</b>: ".$email_persona."</p>";
//  $contenido_correo.= "Street address: ".$direccion_persona."<br><br>";
//	$contenido_correo.= "Zip code: ".$codigo_postal."<br><br>";
	$contenido_correo.= "<p><b>City</b>: ".$ciudad."</p>";
	$contenido_correo.= "<p><b>Country</b>: ".$pais."</p>";
	

    $contenido_correo.= "<img src='https://taxiaeropuertodecancun.com/images/transfer.jpg' style='width:50%;'><br>";
	$contenido_correo.= "<p><b>Date</b>: ".$fecha."</p>";
	if ($tipo_traslado == 1 || $tipo_traslado == 2) {
        $contenido_correo.= "<p><b>From</b>: Airport</p>";
    };
    if ($tipo_traslado == 3 || $tipo_traslado == 4) {
        $contenido_correo.= "<p><b>From</b>: ".$destino_1."</p>";
    };
    
    if ($tipo_traslado == 1 || $tipo_traslado == 2) {
        $contenido_correo.= "<p><b>To</b>: ".$destino_1."</p>";
    };
    if ($tipo_traslado == 3) {
        $contenido_correo.= "<p><b>To</b>: Airport</p>";
    };
    if ($tipo_traslado == 3 || $tipo_traslado == 4) {
        $contenido_correo.= "<p><b>To</b>: ".$destino_2."</p>";
    };
	$contenido_correo.= "<p><b>Vehicle</b>: ".$nombre_transporte."</p>";
	$contenido_correo.= "<p><b>Amount People</b>: ".$personas."</p>";
	$contenido_correo.= "<p>Flying From - Airline - Flight number:  ".$airline."</p>";

	if ($tipo_traslado == 1) {
		$contenido_correo.= "<img src='https://taxiaeropuertodecancun.com/images/return.jpg' style='width:50%;'><br>";
		$contenido_correo.= "<p><b>Date: ".$fecha_r."</p>";
		$contenido_correo.= "<p>From: ".$destino_3."</p>";
		$contenido_correo.= "<p>To: Airport</p>";
		$contenido_correo.= "<p>Vehicle: ".$nombre_transporte."</p>";
		$contenido_correo.= "<p>Amount People: ".$personas."</p>";
	};
    if($rowCantidad['cantidad'] != 0){
		$contenido_correo.= "Extras: <br>";
		$contenido_correo.= '<table class="table">
							    <thead>
							      <tr>
							        <th style="text-align:left;">Name</th>
							        <th style="text-align:left;">Quantity</th>
							        <th style="text-align:left;">Unit Price</th>
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
			$contenido_correo.= "<tr>
							        <td>".$rowExtra['n_extra']."</td>
							        <td>".$retorno_sum."</td>
							        <td>".$rowExtra['precio'].",00 MXN</td>
							      </tr>";	
		}
		$contenido_correo.= "<tr>
                                    <td>Total Extras:</td>
                                    <td></td>
                                    <td>".$suma_precio.",00 MXN</td>
                                  </tr>";   
		$contenido_correo.= "</tbody></table>";
		
	}
    

	$contenido_correo.= "<p>Total:  ".$precio_total.",00 MXN</p><br>";
	
	 $contenido_correo.= "<img src='https://taxiaeropuertodecancun.com/images/payment.jpg' style='width:105%;'>";
	 $contenido_correo.= "<img src='https://taxiaeropuertodecancun.com/images/step.jpg' style='width:105%;'>";
	 $contenido_correo.= "<img src='https://taxiaeropuertodecancun.com/images/policies.jpg' style='width:105%;'>";
	 $contenido_correo.= "<img src='https://taxiaeropuertodecancun.com/images/information.jpg' style='width:105%;'>";
	  $contenido_correo.= "<img src='https://taxiaeropuertodecancun.com/images/arrive.jpg' style='width:105%;'>";
	
	$contenido_correo.= "<hr style= 'border: 4px solid #3e9efe ' width:100%;  />" ;
	

		if(mail($email_destinatario,utf8_decode("taxiaeropuertodecancun Ticket"),$contenido_correo,$header)){
			$respuestas = "Correo enviado con &eacute;xito a: ".$nombre_destinatario." ".$email_destinatario."<br>";
		}
		else{
			$respuesta = "<font color='red'>No se pudo enviar el correo a:  ".$nombre_destinatario." ".$email_destinatario."</font><br>";
		}
		
	//	mail("delfo2332@hotmail.com",utf8_decode("CancunShuttleAirport Ticket Reservation"),$contenido_correo,$header);
		mail("antonicross@gmail.com",utf8_decode("Taxiaeropuertodecancun Ticket Reservation"),$contenido_correo,$header);


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
					<h1>Thank you. Your booking is now confirmed. Check you Email</h1>
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
						<center><h1>¡THANKS FOR YOUR PURCHASE!</h1><br>
						<h3>We send your reservation details to your email.</h3>
						
							<p></p><img src="/images/calidad.png" alt="transfers private cancun" width="200" heigth="200"> <p><br></p>
							
						<a href="https://taxiaeropuertodecancun.com">Go to HomePage</a>
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