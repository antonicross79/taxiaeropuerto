<?php 
session_start();
$suma_extras = $_SESSION['suma_extra'];
$extras = $_SESSION['extras'];
$id_reservacion = $_SESSION['id_reservacion'];
$id_transaccion = $_REQUEST['txn_id'];
$id_recibo = $_REQUEST['receipt_ID'];

if(isset($_REQUEST['receipt_ID'])){
	$id_transaccion = $_REQUEST['receipt_ID'];	
}

//$conexion = mysqli_connect("127.0.0.1","root","6101696","transfer");
	$conexion = mysqli_connect("localhost","canczdhg_taxiaeropuerto","A;2FE+fi","canczdhg_taxiaeropuerto");



	
$sql2 = "UPDATE reservaciones SET transaccion_paypal='".$id_transaccion."' WHERE id_reservacion=".$id_reservacion;
$respuesta2 = mysqli_query($conexion,$sql2);

?>

<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="keywords" content="Private Transport and Car Hire HTML Template" />
	<meta name="description" content="Private Transport and Car Hire HTML Template">
	<meta name="author" content="themeenergy.com">
	
	<title>Gracias</title>
	
	<link rel="stylesheet" href="css/theme-lblue.css" />
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="css/fondo-gracias.css">
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
						<h3>We send your reservation details to your email.
					    If you have not received your reservation confirmation email, please call us at <a href="https://api.whatsapp.com/send?phone=+529983545838"> +52 998 1105994</a></p> </h3><br>
					    
					    <a href="https://api.whatsapp.com/send?phone=+529983545838" target="_blank" ><img src="/images/whats2.png" alt="taxi cancun airport" width="250" hight="100"/></a> <br>
						
							<p></p><img src="/images/calidad.png" alt="transfers private cancun" width="200" heigth="200"> <p><br></p>
							
						<a href="https://Taxiaeropuertodecancun.com">Go to HomePage</a>
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
	
		
     <a href="https://api.whatsapp.com/send?phone=+529983545838" class="btn-wsp" target="_blank">
	<i class="fa fa-whatsapp icono"></i>
	</a>
	
  </body>
</html>