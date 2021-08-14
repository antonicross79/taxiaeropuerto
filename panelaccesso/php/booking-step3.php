<?php 
session_start();
$suma_extras = $_SESSION['suma_extra'];
$extras = $_SESSION['extras'];
$id_reservacion = $_SESSION['id_reservacion'];
$id_transaccion = $_REQUEST['txn_id'];

var_dump($_REQUEST);
die();
//$conexion = mysqli_connect("127.0.0.1","root","6101696","transfer");
$conexion = mysqli_connect("127.0.0.1","u327298531_cancunshutt","cM2~hmMMjsWr","u327298531_cancunshutt");

foreach ($extras as $extra) {
	$sql = "INSERT INTO extra_reservaciones(id_reservacion,id_extra,cantidad_ida,cantidad_retorno) VALUES('".$id_reservacion."','".$extra['id']."','".$extra['ida']."','".$extra['retorno']."')";
	$res = mysqli_query($conexion,$sql);
}

	
$sql2 = "UPDATE reservaciones SET transaccion_paypal='".$id_transaccion."' WHERE id_reservacion=".$id_reservacion;
$respuesta2 = mysqli_query($conexion,$sql2);

$sql = "SELECT * FROM reservaciones WHERE id_reservacion =".$id_reservacion;
$respuesta = mysqli_query($conexion,$sql);
$row = mysqli_fetch_array($respuesta);


	// Cabeceras para el correo
	$header = "Content-Type: text/html; charset=utf-8\n";
	$header.= "From: GetShuttle<no-responder@GetShuttle.com>";
	
	// Servidor SMTP
	ini_set("SMTP","smtp.gmail.com");
	
	
	$email_destinatario = $row['email_p'];
	$nombre_destinatario = $row['nombre_p'];
		

    $contenido_correo.= "<img src='https://cancunshuttleairport.com/images/getshuttlecancun.png' style='width:35%;'><br>";
    $contenido_correo.= "<img src='https://cancunshuttleairport.com/images/logo_correo2.png'><br><br>";
	$contenido_correo.= "<h2><strong> INGLES <strong></h2><br><br>";
	$contenido_correo.= "<p>GetShuttle Cancun appreciates your preference to provide your transportation services in Cancun and the Riviera Maya with us.</p><br>";
	$contenido_correo.= "<p>Below, you will find your reservation details. If any information is NOT correct, please contact us immediately with the corrections to your data at reservation@getshuttlecancun.com noting in SUBJECT: (reservation number).</p><br>";
    $contenido_correo.= "<p>You will receive an email shortly with the meeting point instructions upon arrival at the terminal to make our meeting faster and safer.Below, you will find your reservation details. If any information below is not correct, please contact us immediately with the corrections. You will receive an email shortly with the meeting point instructions upon arrival at the terminal to make our meeting faster and safer.</p><br>";
    $contenido_correo.= "<p style='text-align:center;'><strong>Please present this printed or digital voucher on your phone and present it to our representative at the airport.</strong></p><br><br>";
    
    $contenido_correo.= "<h2><strong> ESPAÑOL <strong></h2><br><br>";
	$contenido_correo.= "<p>GetShuttle Cancún agradece su preferencia para proveerle sus servicios de transportación en Cancún y la Riviera Maya nosotros.</p><br>";
	$contenido_correo.= "<p>A continuación, encontrará los detalles de su reservación. Si alguna información NO es correcta, comuníquese con nosotros de inmediato con las correcciones de sus datos al correo reservation@getshuttlecancun.com anotando en ASUNTO: (Número de Reserva). </p><br>";
	$contenido_correo.= "<p>A continuación, encontrará los detalles de su reservación. Si alguna información NO es correcta, comuníquese con nosotros de inmediato con las correcciones. A la brevedad le llegará un correo con las instrucciones de punto de encuentro a su llegada a la terminal para hacer más rápido y segura nuestro encuentro.</p><br>";

    $contenido_correo.= "<p style='text-align:center;'><strong>Por favor de presentar este voucher impreso o digital en su teléfono y presentarlo a nuestro representante en el aeropuerto.</strong></p><br>";
    
    
    $contenido_correo.= "<h1><strong> Your Confirmation code is : GST0000000".$id_reservacion."cun</strong></h1>";
	$contenido_correo.= "<strong> Passenger details <strong><br><br><br>";
	$contenido_correo.= "Name and surname: ".$row['nombre_p']."<br><br>";
	$contenido_correo.= "Mobile number: ".$row['telefono_p']."<br><br>";
	$contenido_correo.= "Email address: ".$row['email_p']."<br><br>";
	//$contenido_correo.= "Street address: ".$row['direccion_p']."<br><br>";
	//$contenido_correo.= "Zip code: ".$row['codigo_p']."<br><br>";
	$contenido_correo.= "City: ".$row['ciudad_p']."<br><br>";
	$contenido_correo.= "Country: ".$row['pais_p']."<br><br><br>";

	$contenido_correo.= "<strong> Departure Transfer details <strong><br><br><br>";
	$contenido_correo.= "Date: ".$row['fecha_ida']."<br><br>";
	$contenido_correo.= "From: ".$row['ubicacion_desde']."<br><br>";
	$contenido_correo.= "To: ".$row['ubicacion_hasta']."<br><br>";
	$contenido_correo.= "Vehicle: ".$row['transporte']."<br><br>";
	$contenido_correo.= "Amount People: ".$row['cantidad_personas']."<br><br>";	

	if ($row['id_t_traslado'] == 2) {
		$contenido_correo.= "<strong> Return Transfer details <strong><br><br><br>";
		$contenido_correo.= "Date: ".$row['fecha_regreso']."<br><br>";
		$contenido_correo.= "From: ".$row['ubicacion_hasta']."<br><br>";
		$contenido_correo.= "To: ".$row['ubicacion_desde']."<br><br>";
		$contenido_correo.= "Vehicle: ".$row['transporte']."<br><br>";
		$contenido_correo.= "Amount People: ".$row['cantidad_personas']."<br><br>";
	};
    
    $contenido_correo.= "<h2><strong>FLYING FROM  - AIRLINE - FLIGHT NUMBER: ".$row['aerolinea']."</strong></h2><br>";
	$contenido_correo.= "Codigo Transacci贸n Paypal:  ".$row['transaccion_paypal']."<br><br>";
	$contenido_correo.= "Codigo Transacci贸n Paypal:  ".$row['transaccion_paypal']."<br><br>";
	if(count($extras) > 0){
		$contenido_correo.= "Extras: ".$suma_extras.",00 USD<br><br>";
	}
	$contenido_correo.= "Total:  ".$row['total']+$suma_extras.",00 USD<br><br>";
	
	$contenido_correo.= "<h2><strong> PAID / CASH <strong></h2><br><br>";
	$contenido_correo.= "<p>We will be happy to provide you with additional information about services and activities that you can do in Cancun and the Riviera Maya.</p><br>";
	$contenido_correo.= "<p>If the reservation has been completed, you can cancel your reserve up to 24 hours before your arrival.</p><br>";
	$contenido_correo.= "<p>If for any reason, you make a change to your flight and schedule, or your flight is canceled by the airline, we will honor the reservation for that other flight or another day, as long as you notify us of said change immediately to the email reservation@getshuttlecancun.com noting in SUBJECT: (reservation number).</p><br>";
	$contenido_correo.= "<p>To return to the airport, there is a waiting tolerance time of 15 minutes after your PickUp time. After that time, if you need to continue waiting, it will cost an additional 20 dlls per hour or part of the wait. If you do not want us to wait after the 15 minute time, we will withdraw by giving NO SHOW in the service.</p><br>";
	
	$contenido_correo.= "<h2><strong> PAID<strong></h2><br><br>";
	$contenido_correo.= "<p>Estaremos encantados de brindarle información adicional sobre servicios y actividades que puede realizar en Cancún y la Riviera Maya.</p><br>";
	$contenido_correo.= "<p>La reserva ha sido Completada, puede cancelar su reserva hasta 24 horas antes de su llegada.</p><br>";
	$contenido_correo.= "<p>Si por algún motivo, hace un cambio de vuelo y horario, o le es cancelado su vuelo por la aerolínea, le respetaremos la reserva para ese otro vuelo u otro día, siempre y cuando nos notifique dicho cambio inmediatamente al correo reservation@getshuttlecancun.com anotando en ASUNTO: (Número de Reserva).</p><br>";
	$contenido_correo.= "<p>Para regreso al aeropuerto, se tiene un tiempo de tolerancia de espera de 15 minutos después de su horario de PickUp. Después de ese tiempo si requiere que se le siga esperando, tendrá costo adicional de 20 dlls la hora o fracción de espera. Si no quiere que esperemos después del tiempo de 15 minutos nos retiraremos dando NO SHOW en el servicio.</p><br>";
		

		if(mail($email_destinatario,utf8_decode("GetShuttle Ticket"),$contenido_correo,$header)){
			$respuestas = "Correo enviado con &eacute;xito a: ".$nombre_destinatario." ".$email_destinatario."<br>";
		}
		else{
			$respuesta = "<font color='red'>No se pudo enviar el correo a:  ".$nombre_destinatario." ".$email_destinatario."</font><br>";
		};
		

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
					<form class="box readonly">
						<h3>Passenger details</h3>
						<div class="f-row">
							<div class="one-fourth">Name and surname</div>
							<div class="three-fourth"><?php echo $row['nombre_p'] ?></div>
						</div>
						<div class="f-row">
							<div class="one-fourth">Mobile number</div>
							<div class="three-fourth"><?php echo $row['telefono_p'] ?></div>
						</div>
						<div class="f-row">
							<div class="one-fourth">Email address</div>
							<div class="three-fourth"><?php echo $row['email_p'] ?></div>
						</div>
						
						
						
						<div class="f-row">
							<div class="one-fourth">City</div>
							<div class="three-fourth"><?php echo $row['ciudad_p'] ?></div>
						</div>
						<div class="f-row">
							<div class="one-fourth">Country</div>
							<div class="three-fourth"><?php echo $row['pais_p'] ?></div>
						</div>
						
						<h3>Departure Transfer details</h3>
						<div class="f-row">
							<div class="one-fourth">Date</div>
							<div class="three-fourth"><?php echo $row['fecha_ida'] ?></div>
						</div>
						<div class="f-row">
							<div class="one-fourth">From</div>
							<div class="three-fourth"><?php echo $row['ubicacion_desde'] ?></div>
						</div>
						<div class="f-row">
							<div class="one-fourth">To</div>
							<div class="three-fourth"><?php echo $row['ubicacion_hasta'] ?></div>
						</div>
						<div class="f-row">
							<div class="one-fourth">Vehicle</div>
							<div class="three-fourth"><?php echo $row['transporte'] ?></div>
						</div>
						<div class="f-row">
							<div class="one-fourth">Amount People</div>
							<div class="three-fourth"><?php echo $row['cantidad_personas'] ?></div>
						</div>
						
						<?php 

							if ($row['id_t_traslado'] == 2) {
								echo '<h3>Return Transfer details</h3>
						<div class="f-row">
							<div class="one-fourth">Date</div>
							<div class="three-fourth">'.$row['fecha_regreso'].'</div>
						</div>
						<div class="f-row">
							<div class="one-fourth">From</div>
							<div class="three-fourth">'.$row['ubicacion_hasta'].'</div>
						</div>
						<div class="f-row">
							<div class="one-fourth">To</div>
							<div class="three-fourth">'.$row['ubicacion_desde'].'</div>
						</div>
						<div class="f-row">
							<div class="one-fourth">Vehicle</div>
							<div class="three-fourth">'.$row['transporte'].'</div>
						</div>
						<div class="f-row">
							<div class="one-fourth">Amount People</div>
							<div class="three-fourth">'.$row['cantidad_personas'].'</div>
						</div>';
							}
						?>
						
						<h3>TOTAL: <?php echo $row['total'] ?>,00 USD</h3>
					</form>
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
include "footer.php"

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
	
		
       <a href="https://api.whatsapp.com/send?phone=+529981105994" class="btn-wsp" target="_blank">
	<i class="fa fa-whatsapp icono"></i>
	</a>
	
  </body>
</html>