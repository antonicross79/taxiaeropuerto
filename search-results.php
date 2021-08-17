<?php 

$destino_1 = $_POST['ubi1'];
$destino_2 = $_POST['ubi2'];
$destino_3 = $destino_2;
$destino_4 = $destino_1;
$personas= $_POST['people'];
$tipo_traslado = $_POST['modo'];
$fecha = $_POST['dep-date'];
$fecha_r = $_POST['ret-date'];
$destinos2 = array();

									
$destinos2[1] = 'Round Trip: Airport-Hotel-Airport';
$destinos2[2] ='Arrival: Airport-Hotel';
$destinos2[3] ='Departure: Hotel-Airport';
$destinos2[4] ='Transfer: Hotel-Hotel';

//$conexion = mysqli_connect("127.0.0.1","root","6101696","transfer");

	$conexion = mysqli_connect("localhost","canczdhg_taxiaeropuerto","A;2FE+fi","canczdhg_taxiaeropuerto");
	
$sql = "SELECT * FROM rutas AS rut
			LEFT JOIN ubicaciones AS ubi ON ubi.n_ubicacion ='".$destino_1."'
			LEFT JOIN transportes AS trans ON trans.id_transporte = rut.id_transporte
			WHERE id_p_llegada = ubi.id_ubicacion AND t_traslado=1 AND ".$personas." BETWEEN cantidad_min and  cantidad_max";
$respuesta = mysqli_query($conexion,$sql);
$sql2 = "SELECT n_ubicacion FROM ubicaciones;";
$respuesta2= mysqli_query($conexion,$sql2);
 
$sql3 = "SELECT * FROM rutas AS rut
			LEFT JOIN ubicaciones AS ubi ON ubi.n_ubicacion ='".$destino_1."'
			LEFT JOIN transportes AS trans ON trans.id_transporte = rut.id_transporte
			WHERE id_p_llegada = ubi.id_ubicacion AND t_traslado=2 AND ".$personas." BETWEEN cantidad_min and  cantidad_max";
			
$respuesta3 = mysqli_query($conexion,$sql3);

$sqlHotelHotel = "SELECT * FROM rutas AS rut
			LEFT JOIN ubicaciones AS ubi ON ubi.n_ubicacion ='".$destino_2."'
			LEFT JOIN transportes AS trans ON trans.id_transporte = rut.id_transporte
			WHERE id_p_llegada = ubi.id_ubicacion AND t_traslado=1 AND ".$personas." BETWEEN cantidad_min and  cantidad_max";
$respuestaHotelHotel = mysqli_query($conexion,$sql);
$hotelhotel = [];

while ($rowHotel = mysqli_fetch_array($respuestaHotelHotel)) {
	$hotelhotel[] = $rowHotel;
}

$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$is_safari = false;
	$is_mobile_iphone = false;
	if(stripos($user_agent,'Chrome') !== false){
		$is_safari = false;
	}
	elseif(stripos($user_agent,'Safari') !== false){
		$is_safari = true;
	}

	if(stripos($user_agent,'iPhone') || stripos($user_agent,'iPod') || stripos($user_agent,'iPad')){
		$is_mobile_iphone = true;
	}


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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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



  </head>
  
  <body>
    <!-- Header -->
		<?php
		include "header.php"
		?>
	<!-- //Header -->
	
	<!-- Main -->
	<main class="main" role="main">
		<!-- Search -->
		<div class="container-fluid">
		<form action="search-results.php" method="post">
		<div class="form-row p-5" style="border: 1px solid #00000059;border-radius: 20px;box-shadow: 5px 5px 10px 2px #00000042;background: white;">

			<div class="input-group mb-3 col-xs-12 col-md-2">
			  <label for="transfer_type" class="col-xs-12 col-md-12 pb-0 pl-0">Transfer Type</label>
			  <div class="input-group-prepend">
			    <label class="input-group-text" for="inputGroupSelect01"><i class="fa fa-road"></i></label>
			  </div>
			  <?php
								
					$num = count($destinos);
					$i=1;
					echo '<select name="modo" id="modo" class="form-control"  required onchange="Validar()" style="height:auto">';
					while ($i<= 4 ) {
						if ($i == $tipo_traslado) {
							echo "<option value='".$i."' selected>".$destinos2[$i]."</option>";
						}else{
							echo "<option value='".$i."'>".$destinos2[$i]."</option>";
						}
						$i++;
					};
					echo '</select>';
				?>
			</div>
			<div class="input-group mb-3 col-xs-12 col-md-2">
			  <label for="transfer_type" class="col-xs-12 col-md-12 pb-0 pl-0">Destinations</label>
			  <div class="input-group-prepend">
				    <label class="input-group-text" for="destination1"><i class="fa fa-building"></i></label>
				</div>
			    <input type="text" name="ubi1" id="destination1" placeholder="Type your destination here" class="form-control" style="height: auto;" onclick="document.getElementById('livesearch2').innerHTML=''" onkeyup="return showResult(this.value)" value="">	
				<div id="livesearch" style="max-height: 200px;overflow-x: auto;position: absolute;top:5em;z-index: 9;"></div>	
			</div>
			<div class="input-group mb-3 col-xs-12 col-md-2" id="destination2">
			  <label for="transfer_type" class="col-xs-12 col-md-12 pb-0 pl-0">Destinations</label>
			  <div class="input-group-prepend">
				    <label class="input-group-text" for="destinationextra"><i class="fa fa-building"></i></label>
				</div>
			    <input type="text" name="ubi2" id="destinationextra" placeholder="Type your destination here" class="form-control" style="height: auto;" onclick="document.getElementById('livesearch').innerHTML=''" onkeyup="return showResult(this.value)" value="">
			    <div id="livesearch2" style="max-height:200px;overflow-x: auto;position: absolute;top:5em;z-index: 9;"></div>	
			</div>
			<div class="input-group mb-3 col-xs-9 col-md-1" id="arrival_date">
			  <label for="transfer_type" class="col-xs-12 col-md-12 pb-0 pl-0">Arrival</label>
			  <input type="date" class="form-control" name="dep-date" value="<?php echo $fecha; ?>">
			</div>
			<div class="input-group mb-3 col-xs-3 col-md-1" id="arrival_time">
			  <label for="pickup_hour" class="col-xs-12 col-md-12 pb-0 pl-0">time</label>
			  <select class="form-control input-shadow" name="pickup_hour_arrival" id="pickup_hour" style="height: auto;">
		    	<?php 
		    	$j = 0;
		    	for ($i=0; $i < 24; $i++) { 
		    		if($i > 12){
		    			$j = $i - 12;
		    		}
		    		if($i == intval($_POST['pickup_hour_arrival'])){
						?>
						<option value="<?php echo $i; ?>" selected><?php echo ($j>9?$j:'0'.$j); echo " "; echo ($i>11?'pm':'am') ?> </option>
						<?php		    			
		    		}else{
		    		?>

		    		<option value="<?php echo $i; ?>"><?php echo ($j>9?$j:'0'.$j); echo " "; echo ($i>11?'pm':'am') ?> </option>
		    		<?php	
		    		}
		    		
		    		$j++;
		    	}

		    	?>
		    </select>
			</div>
			<div class="input-group mb-3 col-xs-12 col-md-1" id="departure_date">
				<label for="transfer_type" class="col-xs-12 col-md-12 pb-0 pl-0">Departure</label>
			  <input type="date" name="ret-date" class="form-control" value="<?php echo $fecha_r; ?>">
			</div>
			<div class="input-group mb-3 col-xs-3 col-md-1" id="departure_time">
			  <label for="pickup_hour" class="col-xs-12 col-md-12 pb-0 pl-0">Time</label>
			  <select class="form-control input-shadow" name="pickup_hour_departure" id="pickup_hour" style="height: auto;">
		    	<?php 
		    	$j = 0;
		    	for ($i=0; $i < 24; $i++) { 
		    		if($i > 12){
		    			$j = $i - 12;
		    		}
		    		if($i == intval($_POST['pickup_hour_departure'])){
						?>
						<option value="<?php echo $i; ?>" selected><?php echo ($j>9?$j:'0'.$j); echo " "; echo ($i>11?'pm':'am') ?> </option>
						<?php		    			
		    		}else{
		    		?>

		    		<option value="<?php echo $i; ?>"><?php echo ($j>9?$j:'0'.$j); echo " "; echo ($i>11?'pm':'am') ?> </option>
		    		<?php	
		    		}
		    		
		    		$j++;
		    	}

		    	?>
		    </select>
			</div>
			<div class="input-group mb-3 col-xs-12 col-md-3" id="number_passengers">
				<label for="transfer_type" class="col-xs-12 col-md-12 pb-0 pl-0">Passenger(s)</label>
			  <div class="input-group-prepend">
			    <label class="input-group-text" for="inputGroupSelect01"><i class="fa fa-user"></i></label>
			  </div>
			  <select class="form-control col-xs-12 col-md-6 mr-2" name="people" id="inputGroupSelect01" style="height:auto;">
			  	<?php
			  	for ($i=1; $i < 17; $i++) { 
			  		if($i == $personas){
			  			?>
			  			<option value="<?php echo $i; ?>" selected><?php echo $i; ?>  Passenger<?php echo $i!=0?'s':''; ?></option>
			  			<?php	
			  		}else{
			  			?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?>  Passenger<?php echo $i!=0?'s':''; ?></option>
				  		<?php	
			  		}

			  		
			  	}

			  	?>
			  </select>
			  <button class="btn btn-primary col-xs-12 col-md-6" type="submit">Continue</button>
			</div>
		</div>	
		</form>
		</div>
		<!-- //Search -->
		
		<div class="container-fluid col-10 mt-4">
			<div class="row">
				<!--- Content -->
				<div class="full-width content">
					
						
						<?php
						$aux_precio = 0;
						if ($tipo_traslado == 4 || $tipo_traslado == 2 || $tipo_traslado == 3 ) {
								echo '<h2>Select transport for your DEPARTURE</h2>';
							while ($transportes = mysqli_fetch_array($respuesta)) {
								$aux_precio = intval($transportes['precio']);
								if ($tipo_traslado == 4) {
									foreach ($hotelhotel as $hotel) {
										if ($hotel['n_transporte']  == $transportes['n_transporte']) {
											$aux_precio = intval($transportes['precio'])+intval($hotel['precio']);
										}
									}
								}
                            $ruta_imagen = "images/transportes/transporte_".$transportes['id_transporte'].".jpg";
							echo '<div class="results"><!-- Item -->
								<article class="result">
								<form action="extras.php" method="POST">
									<div class="one-fourth heightfix"><img src="'.$ruta_imagen.'" alt="" style="padding-top:40px;" /></div>
									<div class="one-half heightfix">
										<h3>'.$transportes['n_transporte'].'<a onclick="showInfo('.$transportes['id_transporte'].')" href="javascript:void(0)" class="trigger color" title="Read more">?</a></h3>
										<ul>
											<li>
												<span class="ico people"></span>
												<p>Max <strong>'.$transportes['cantidad_max'].'</strong> <br />per vehicle</p>
											</li>
											<li>
												<span class="ico luggage"></span>
												<p>Max <strong>'.$transportes['cantidad_max'].'</strong>
											</li>
											<li>
												<span class="ico time"></span>
												<p>Estimated time <br /><strong>50 mins</strong></p>
											</li>
										</ul>
									</div>
									<div class="one-fourth heightfix">
										<div>
											<div class="price">'.$aux_precio.',00 <small>MXN</small></div>
											<span class="meta">per vehicule</span>
											<button type="submit" class="btn btn-primary col-xs-12 col-md-6">select</button>
										</div>
									</div>

									<input type="hidden" name="ubi1" value="'.$destino_1.'"/>
										<input type="hidden" name="ubi2" value="'.$destino_2.'"/>
										<input type="hidden" name="precio" value="'.$aux_precio.'"/>
										<input type="hidden" name="dep-date" value="'.$fecha.'"/>
										<input type="hidden" name="ret-date" value="'.$fecha_r.'"/>
										<input type="hidden" name="people" value="'.$personas.'"/>
										<input type="hidden" name="modo" value="'.$tipo_traslado.'"/>
										<input type="hidden" name="n_transporte" value="'.$transportes['n_transporte'].'"/>
										<input type="hidden" name="pickup_hour_arrival" value="'.$_POST['pickup_hour_arrival'].'"/>
										<input type="hidden" name="pickup_hour_departure" value="'.$_POST['pickup_hour_departure'].'"/>

									</form>
									<div class="full-width information" id="'.$transportes['id_transporte'].'" style="">	
										<a href="javascript:void(0)" class="close color" title="Close">x</a>
											<p>Includes: private trip, water, wifi, 1 baby seat, apple and android usb charger, air conditioning, travel insurance.</p>
									</div>
									
								</article>
								<!-- //Item -->';			
							};
						};
					?>
					</div>
					
					
						
						<?php
						if ($tipo_traslado == 1) {
						    echo '<h2>Select Transport for your Round Trip</h2>';
							while ($transportes2 = mysqli_fetch_array($respuesta3)) {

                                $ruta_imagen = "images/transportes/transporte_".$transportes2['id_transporte'].".jpg";
								echo '
					
									<div class="results"><!-- Item -->
								<article class="result">
								<form action="extras.php" method="POST">
									<div class="one-fourth heightfix"><img src="'.$ruta_imagen.'" alt="" style="padding-top:40px;" /></div>
									<div class="one-half heightfix">
										<h3>'.$transportes2['n_transporte'].'<a href="javascript:void(0)" class="trigger color" title="Read more">?</a></h3>
										<ul>
											<li>
												<span class="ico people"></span>
												<p>Max <strong>'.$transportes2['cantidad_max'].'</strong> <br />per vehicle</p>
											</li>
											<li>
												<span class="ico luggage"></span>
												<p>Max <strong>'.$transportes2['cantidad_max'].'</strong>
											</li>
											<li>
												<span class="ico time"></span>
												<p>Estimated time <br /><strong>50 mins</strong></p>
											</li>
										</ul>
									</div>
									<div class="one-fourth heightfix">
										<div>
											<div class="price">'.$transportes2['precio'].',00 <small>MXN</small></div>
											<span class="meta">per vehicule</span>
											<button type="submit" class="btn btn-primary col-xs-12 col-md-6">select</button>
										</div>
									</div>

										<input type="hidden" name="ubi1" value="'.$destino_1.'"/>
										<input type="hidden" name="ubi2" value="'.$destino_2.'"/>
										<input type="hidden" name="precio" value="'.$transportes2['precio'].'"/>
										<input type="hidden" name="dep-date" value="'.$fecha.'"/>
										<input type="hidden" name="ret-date" value="'.$fecha_r.'"/>
										<input type="hidden" name="people" value="'.$personas.'"/>
										<input type="hidden" name="modo" value="'.$tipo_traslado.'"/>
										<input type="hidden" name="n_transporte" value="'.$transportes2['n_transporte'].'"/>
										<input type="hidden" name="pickup_hour_arrival" value="'.$_POST['pickup_hour_arrival'].'"/>
										<input type="hidden" name="pickup_hour_departure" value="'.$_POST['pickup_hour_departure'].'"/>

									</form>
									<div class="full-width information">	
										<a href="javascript:void(0)" class="close color" title="Close">x</a>
											<p>Includes: private trip, water, wifi, 1 baby seat, apple and android usb charger, air conditioning, travel insurance.</p>
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
	include "footer.php"
	?>
	<!-- //Footer -->
	
	<!-- Preloader -->
	
	<!-- //Preloader -->

    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
	<script src="js/jquery.uniform.min.js"></script>
	<script src="js/jquery.datetimepicker.js"></script>
	<script src="js/jquery.slicknav.min.js"></script>
	
	
	<script type="text/javascript">
		window.onload = function () {
			$("#destination2").hide();
			$('.main-nav').slicknav({
				prependTo:'.header .wrap',
				label:''
			});
        	Validar();
      	}
		
		function MostrarMensaje(){
			alert('El Horario debe ser Entre las 06:00 y las 22:00');
		}
           
		function Validar(){

			var modo_de_viaje  = $("#modo").val();
        	if (modo_de_viaje == 1) {
        		$("#destination2").hide();
        		$("#arrival_date").show(500);
        		$("#arrival_time").show(500);
        		$("#departure_date").show(500);
        		$("#departure_time").show(500);
        	}
        	if (modo_de_viaje == 2) {
        		$("#destination2").hide();	
        		$("#arrival_date").show(500);
        		$("#arrival_time").show(500);
        		$("#departure_date").hide();
        		$("#departure_time").hide();
        	}
        	if (modo_de_viaje == 3) {
        		$("#destination2").hide();
        		$("#arrival_date").hide();
        		$("#arrival_time").hide();
        		$("#departure_date").show(500);
        		$("#departure_time").show(500);
        	}
        	if (modo_de_viaje == 4) {
        		$("#destination2").show(500);
        		$("#arrival_date").hide();
        		$("#arrival_time").hide();
        		$("#departure_date").show(500);
        		$("#departure_time").show(500);
        	}
		}

		function showInfo(id){
			$("#"+id).show(500);
		}

		function hideInfo(id){
			$("#"+id).hide(500);	
		}

	</script>
	<script type="text/javascript">
		var target = "";
		var livesearch = ""
		function showResult(str) {
		  target = event.target.id;
		  if (target == 'destinationextra') {
		  	livesearch = "livesearch2";
		  }else{
		  	livesearch = "livesearch";
		  }
		  if (str.length==0) {
		    document.getElementById(livesearch).innerHTML="";
		    document.getElementById(livesearch).style.border="0px";
		    return;
		  }
		  var xmlhttp=new XMLHttpRequest();
		  xmlhttp.onreadystatechange=function() {
		    if (this.readyState==4 && this.status==200) {
		      document.getElementById(livesearch).innerHTML=this.responseText;
		      document.getElementById(livesearch).style.border="1px solid #A5ACB2";
		    }
		  }
		  xmlhttp.open("GET","search-destination.php?q="+str,true);
		  xmlhttp.send();
		}

		function selectDestination(destino){
			$("#"+target).val(destino);
			document.getElementById(livesearch).innerHTML="";
			document.getElementById(livesearch).style.border="0px";
			return false;
		}
	</script>
	
<a href="https://api.whatsapp.com/send?phone=+529983545838" class="btn-wsp" target="_blank">
	<i class="fa fa-whatsapp icono"></i>
	</a>
	
  </body>
</html>