<?php 

$destino_1 = $_POST['ubi1'];
$destino_2 = $_POST['ubi2'];
$destino_3 = $destino_2;
$destino_4 = $destino_1;
$personas= $_POST['people'];
$tipo_traslado = $_POST['radio'];
$fecha = $_POST['dep-date'];
$fecha_r = $_POST['ret-date'];

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




?>

<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="keywords" content="Private Transport and Car Hire HTML Template" />
	<meta name="description" content="Private Transport and Car Hire HTML Template">
	<meta name="author" content="themeenergy.com">
	
	<title>Search results</title>
	
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
		<!-- Search -->
		<div class="advanced-search color">
			<div class="wrap">
				<form role="form" action="search-results.php" method="post">
					<!-- Row -->
					<div class="f-row">
						<div class="form-group datepicker one-third">
							<label for="dep-date">Departure date and time / Fecha y hora de salida</label>
							<input type="text" id="dep-date" name="dep-date" value="<?php echo $fecha?>" onclick="MostrarMensaje()" required/>
						</div>
						<div class="form-group select one-third">
							<label>Pick up location</label>
							<input type="text" name="ubi1" autocomplete="off" list="ubicaciones" value="<?php echo $destino_1?>" required>
							
								
								<?php
									
									echo '<datalist id="ubicaciones">
											<option selected>&nbsp;</option>';
									while ($destinos = mysqli_fetch_array($respuesta2)) {
										echo "<option value='".$destinos['n_ubicacion']."'>".utf8_encode($destinos['n_ubicacion'])."</option>";
										
									};

									echo '</datalist>';
								?>
						</div>
						<div class="form-group select one-third">
							<label>Drop off location</label>
							<input type="text" name="ubi2" autocomplete="off" list="ubicaciones" value="<?php echo $destino_2 ?>" required>
						</div>
					</div>
					<!-- //Row -->
					
					<!-- Row -->
					<div class="f-row">
						<div class="form-group datepicker one-third">
							<label for="ret-date">Return date and time / Fecha y hora de regreso</label>
							<input type="text" id="ret-date" name="ret-date" value="<?php echo $fecha_r ?>" onclick="MostrarMensaje()"/>
						</div>
						<!--<div class="form-group select" style="width: 360px;">
							<label>Pick up location</label>
							<input type="hidden" name="ubi3" autocomplete="off" list="ubicaciones" value="<?php echo $destino_3?>" >
						</div>
						<div class="form-group select one-third" style="margin-left: 25px;">
							<label>Drop off location</label>
							<input type="hidden" name="ubi4" autocomplete="off" list="ubicaciones" value="<?php echo $destino_4?>">
						</div>-->
					</div>
					<!-- //Row -->
					
					<!-- Row -->
					<div class="f-row">
						<div class="form-group right">
							<button type="submit" class="btn large black">Find a transfer / Buscar </button>
						</div>
						<div class="form-group spinner">
							<label for="people">How many people / Cuantos personas<small>(including children /incluidos los niños)</small>?</label>
							<input type="number" id="people" name="people" min="1" value="<?php echo $personas?>" required/>
						</div>
						<div class="form-group radios">
							<?php 

							if ($tipo_traslado == 1) {
								echo '<div>
								<input type="radio" name="radio" id="return" value="2" />
								<label for="return">Return</label>
								</div>
								<div>
									<input type="radio" name="radio" id="oneway" value="1" checked/>
									<label for="oneway">One way</label>
								</div>';
							};
							if ($tipo_traslado == 2) {
								echo '<div>
								<input type="radio" name="radio" id="return" value="2" checked/>
								<label for="return">Return</label>
								</div>
								<div>
									<input type="radio" name="radio" id="oneway" value="1" />
									<label for="oneway">One way</label>
								</div>';
							};
							

							?>



							
						</div>
					</div>

					<input type="hidden" name="destinos_list" id="destinos_list" value="<?php echo base64_encode(serialize($destinos));?>" />
					<!--// Row -->
				</form>
			</div>
		</div>
		<!-- //Search -->
		
		<div class="wrap">
			<div class="row">
				<!--- Content -->
				<div class="full-width content">
					
						
						<?php
						if ($tipo_traslado == 1) {
								echo '<h2>Select transfer type for your DEPARTURE</h2>';
						while ($transportes = mysqli_fetch_array($respuesta)) {

							echo '
					
					<div class="results"><!-- Item -->
								<article class="result">
								<form action="booking-step1.php" method="POST">
									<div class="one-fourth heightfix"><img src="http://placehold.it/1024x768" alt="" /></div>
									<div class="one-half heightfix">
										<h3>'.$transportes['n_transporte'].'<a href="javascript:void(0)" class="trigger color" title="Read more">?</a></h3>
										<ul>
											<li>
												<span class="ico people"></span>
												<p>Max <strong>'.$transportes['cantidad_max'].'</strong> <br />per vehicle</p>
											</li>
											<li>
												<span class="ico luggage"></span>
												<p>Max <strong>3 suitcases</strong> <br />per vehicle/por vehiculo</p>
											</li>
											<li>
												<span class="ico time"></span>
												<p>Price per vehicle NOT <br /><strong>per person</strong></p>
											</li>
										</ul>
									</div>
									<div class="one-fourth heightfix">
										<div>
											<div class="price">'.$transportes['precio'].',00 <small>MXN</small></div>
											<span class="meta">per vehicle</span>
											<button type="submit" class="btn grey large">select</button>
										</div>
									</div>

									<input type="hidden" name="ubi1" value="'.$destino_1.'"/>
										<input type="hidden" name="ubi2" value="'.$destino_2.'"/>
										<input type="hidden" name="precio" value="'.$transportes['precio'].'"/>
										<input type="hidden" name="dep-date" value="'.$fecha.'"/>
										<input type="hidden" name="ret-date" value="'.$fecha_r.'"/>
										<input type="hidden" name="people" value="'.$personas.'"/>
										<input type="hidden" name="radio" value="'.$tipo_traslado.'"/>
										<input type="hidden" name="n_transporte" value="'.$transportes['n_transporte'].'"/>

									</form>
									<div class="full-width information">	
										<a href="javascript:void(0)" class="close color" title="Close">x</a>
											<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
									</div>
									
								</article>
								<!-- //Item -->';			
						};
						};
					?>
					</div>
					
					
						
						<?php
						if ($tipo_traslado == 2) {	
						    echo '<h2>Select transfer for your RETURN</h2>';
							while ($transportes2 = mysqli_fetch_array($respuesta3)) {

								echo '
					
									<div class="results"><!-- Item -->
								<article class="result">
								<form action="booking-step1.php" method="POST">
									<div class="one-fourth heightfix"><img src="http://placehold.it/1024x768" alt="" /></div>
									<div class="one-half heightfix">
										 <h3>'.$transportes2['n_transporte'].'<a href="javascript:void(0)" class="trigger color" title="">?</a></h3>  
										<ul>
											<li>
												<span class="ico people"></span>
												<p>Max <strong>'.$transportes2['cantidad_max'].'</strong> <br />per vehicle / por vehiculo</p>
											</li>
											<li>
												<span class="ico luggage"></span>
												<p>Max <strong>3 suitcases / Max 3 maletas</strong> <br />per vehicle</p>
											</li>
											<li>
												<span class="ico car"></span>
												<p>Price for vehicule<br /><strong>not for person</strong></p>
											</li>
										</ul>
									</div>
									<div class="one-fourth heightfix">
										<div>
											<div class="price">'.$transportes2['precio'].',00 <small>MXN</small></div>
											<span class="meta">per vehicle</span>
											<button type="submit" class="btn grey large">select</button>
										</div>
									</div>

										<input type="hidden" name="ubi1" value="'.$destino_1.'"/>
										<input type="hidden" name="ubi2" value="'.$destino_2.'"/>
										<input type="hidden" name="precio" value="'.$transportes2['precio'].'"/>
										<input type="hidden" name="dep-date" value="'.$fecha.'"/>
										<input type="hidden" name="ret-date" value="'.$fecha_r.'"/>
										<input type="hidden" name="people" value="'.$personas.'"/>
										<input type="hidden" name="radio" value="'.$tipo_traslado.'"/>
										<input type="hidden" name="n_transporte" value="'.$transportes2['n_transporte'].'"/>

									</form>
									<div class="full-width information">	
										<a href="javascript:void(0)" class="close color" title="Close">x</a>
											<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
									</div>
									
								</article>
								<!-- //Item -->';	
							};
									
						};
					?>
						
					</div>
				</div>
				<!--- //Content -->
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
	<script src="js/jquery.datetimepicker.js"></script>
	<script src="js/jquery.slicknav.min.js"></script>
	<script src="js/wow.min.js"></script>
	<script src="js/search.js"></script>
	<script src="js/scripts.js"></script>
	<script type="text/javascript">
		
		$(document).ready(function () {

			var a = <?php echo $tipo_traslado ?>;
			if (a == 2) {
				$('.f-row:nth-child(2)').slideToggle(500);
			}
		});
		
        function MostrarMensaje(){
			alert('The schedule must be Between 06:00 and 22:00');
		}
	</script>
	
	<a href="https://api.whatsapp.com/send?phone=+529983545838" class="btn-wsp" target="_blank">
	<i class="fa fa-whatsapp icono"></i>
	</a>
  </body>
</html>