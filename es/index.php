<!DOCTYPE html>
<?php 
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

	$destinos = array();
	$destinos[1] = 'Viaje Redondo: Aeropuerto-Hotel-Aeropuerto';
	$destinos[2] ='Llegada: Aeropuerto-Hotel';
	$destinos[3] ='Salida: Hotel-Aeropuerto';
	$destinos[4] ='Traslado: Hotel-Hotel';
								
									
	//ESTO ES PARA EL CASO QUE APLIQUE USANDO BASE DE DATOS CON UNA TABLA SENCILLA.
	

		$conexion = mysqli_connect("localhost","canczdhg_taxiaeropuerto","A;2FE+fi","canczdhg_taxiaeropuerto");
	//$conexion = mysqli_connect("127.0.0.1","root","6101696","transfer");
	$sql = "SELECT n_ubicacion FROM ubicaciones;";
	$respuesta= mysqli_query($conexion,$sql);
	

			


?>



<html lang="en">
   <head><meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="keywords" content="Private Transport and Car Hire HTML Template" />
	<meta name="description" content="Private Transport and Car Hire HTML Template">
	<meta name="author" content="themeenergy.com">
	
	<title>Home</title>
	
	<link rel="stylesheet" href="../css/styleslideshow.css" />
	<link rel="stylesheet" href="../css/whatsapp.css" />

	
	<link rel="stylesheet" href="../css/theme-dblue.css" />
	<link rel="stylesheet" href="../css/style.css" />
	<link rel="stylesheet" href="../css/animate.css" />
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,500,600,700|Montserrat:400,700' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" href="../images/favicon.ico" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <?php
    if($is_safari == true){
    	?>
    	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    	<?php
    }
    ?>
    
    <div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v9.0&appId=393071095180655&autoLogAppEvents=1" nonce="zk4ilA0O"></script>

	<style type="text/css">
		.dropdown-toggle{
		    margin-top: 5px;
		    border: 1px solid #cecece;
		    padding-top: 12px;
		}

		.dropdown-toggle:hover{
		    color:black !important;
		    background: white !important;
		}
	</style>
  </head>
  
  <body class="home">
      
        
         
		<!-- Header -->
		<?php
		include "header.php";
		
		?>
		<!-- //Header -->
	
	<!-- Main -->
	<main class="main" role="main">
		<!-- Intro -->
		
		<div class="container" style="max-width: none;">
    <div class="slider">
        <div class="slide foto1">
            <div class="caption">
                <h2>Traslado Aeropuerto-Hotel-Aeropuerto</h2>
                <p>
                    
                </p>
            </div>
        </div>

        <div class="slide slide2">
            <!--<div class="caption">
                <h2></h2> 
                <p> 
                    
                </p> 
            </div> -->
        </div>

        <div class="slide foto1">
            <div class="caption">
                <h2>Necesita un Traslado Privado??</h2>
                <p>
                    
                </p>
            </div>
        </div>

         <div class="slide slide2">
            <!-- <div class="caption">
                <h2>Tours</h2>
                <p>
                    
                </p> 
            </div> -->
        </div>. 

        <div class="slide foto1">
            <div class="caption">
                <h2>Traslado Seguro</h2>
                <p>
                    
                </p>
            </div>
        </div>

       

    </div>
    </div>
		<!-- //Intro -->
		<div class="container-fluid" style="background: #4bb5c1;">
		<form action="search-results.php" method="post">
		<div class="form-row p-5" style="border: 1px solid #00000059;border-radius: 20px;box-shadow: 5px 5px 10px 2px #00000042;background: white;">

			<div class="input-group mb-3 col-xs-12 col-md-2">
			  <label for="transfer_type" class="col-xs-12 col-md-12 pb-0 pl-0">Tipo de viaje</label>
			  <div class="input-group-prepend">
			    <label class="input-group-text" for="inputGroupSelect01"><i class="fa fa-road"></i></label>
			  </div>
			  <?php
				
					$num = count($destinos);
					$i=1;
					echo '<select name="modo" id="modo" class="form-control" style="height:auto"  required onchange="Validar()">';
					while ($i<= $num ) {
						echo "<option value='".$i."'>".$destinos[$i]."</option>";
						$i++;
					};
					echo '</select>';
				?>
			</div>
			<div class="input-group mb-3 col-xs-12 col-md-2">
			  <label for="transfer_type" class="col-xs-12 col-md-12 pb-0 pl-0">Destinos</label>
			  <div class="input-group-prepend">
				    <label class="input-group-text" for="destination1"><i class="fa fa-building"></i></label>
				</div>
			    <input type="text" name="ubi1" id="destination1" placeholder="Type your destination here" class="form-control" style="height: auto;" onclick="document.getElementById('livesearch2').innerHTML=''" onkeyup="return showResult(this.value)" value="">	
				<div id="livesearch" style="max-height: 200px;overflow-x: auto;position: absolute;top:5em;z-index: 9;"></div>		  
			</div>
			<div class="input-group mb-3 col-xs-12 col-md-2" id="destination2">
			  <label for="transfer_type" class="col-xs-12 col-md-12 pb-0 pl-0">Destinos</label>
			  <div class="input-group-prepend">
				    <label class="input-group-text" for="destinationextra"><i class="fa fa-building"></i></label>
				</div>
			    <input type="text" name="ubi2" id="destinationextra" placeholder="Type your destination here" class="form-control" style="height: auto;" onclick="document.getElementById('livesearch').innerHTML=''" onkeyup="return showResult(this.value)" value="">
			    <div id="livesearch2" style="max-height:200px;overflow-x: auto;position: absolute;top:5em;z-index: 9;"></div>		  
			</div>
			<div class="input-group mb-3 col-xs-9 col-md-1" id="arrival_date">
			  <label for="transfer_type" class="col-xs-12 col-md-12 pb-0 pl-0">Llegada</label>
			  <?php
			    if($is_safari == true && $is_mobile_iphone == false){
			    	?>
			    	<div class="input-group-prepend">
					    <label class="input-group-text" for="inputGroupSelect01"><i class="fa fa-calendar"></i></label>
					  </div>
			    	<input type="text" name="dep-date" id="dep-date" placeholder="yyyy-mm-dd" class="form-control" style="height: auto;">
			    	<?php
			    }elseif($is_safari == true && $is_mobile_iphone == true){
			    	?>
			    	<div class="input-group-prepend">
					    <label class="input-group-text" for="inputGroupSelect01"><i class="fa fa-calendar"></i></label>
					  </div>
			    	<input type="date" class="form-control" name="dep-date"placeholder="yyyy-mm-dd" class="form-control" style="height: auto;">
			    	<?php
			    }elseif($is_safari == false){
			    	?>
			    	<input type="date" class="form-control" name="dep-date">
			    	<?php
			    }
			    ?>
			</div>
			<div class="input-group mb-3 col-xs-3 col-md-1" id="arrival_time">
			  <label for="pickup_hour" class="col-xs-12 col-md-12 pb-0 pl-0">hora</label>
			  <select class="form-control input-shadow" name="pickup_hour_arrival" id="pickup_hour" style="height: auto;">
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
			<div class="input-group mb-3 col-xs-12 col-md-1" id="departure_date">
				<label for="transfer_type" class="col-xs-12 col-md-12 pb-0 pl-0">Salida</label>
			  <?php
			    if($is_safari == true && $is_mobile_iphone == false){
			    	?>
			    	<div class="input-group-prepend">
					    <label class="input-group-text" for="inputGroupSelect01"><i class="fa fa-calendar"></i></label>
					  </div>
			    	<input type="text" name="ret-date" id="ret-date" placeholder="yyyy-mm-dd" class="form-control" style="height: auto;">
			    	<?php
			    }elseif($is_safari == true && $is_mobile_iphone == true){
			    	?>
			    	<div class="input-group-prepend">
					    <label class="input-group-text" for="inputGroupSelect01"><i class="fa fa-calendar"></i></label>
					  </div>
			    	<input type="date" class="form-control" name="ret-date"placeholder="yyyy-mm-dd" class="form-control" style="height: auto;">
			    	<?php
			    }else{
			    	?>
			    	<input type="date" class="form-control" name="ret-date">
			    	<?php
			    }
			    ?>
			</div>
			<div class="input-group mb-3 col-xs-3 col-md-1" id="departure_time">
			  <label for="pickup_hour" class="col-xs-12 col-md-12 pb-0 pl-0">hora</label>
			  <select class="form-control input-shadow" name="pickup_hour_departure" id="pickup_hour" style="height: auto;">
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
			<div class="input-group mb-3 col-xs-12 col-md-3" id="number_passengers">
				<label for="transfer_type" class="col-xs-12 col-md-12 pb-0 pl-0">Pasajero(s)</label>
			  <div class="input-group-prepend">
			    <label class="input-group-text" for="inputGroupSelect01"><i class="fa fa-user"></i></label>
			  </div>
			  <select class="form-control col-xs-12 col-md-6 mr-2" name="people" id="inputGroupSelect01" style="height:auto;">
			    <option value="1" selected>1 Pasajero</option>
			    <option value="2">2 Pasajeros</option>
			    <option value="3">3 Pasajeros</option>
			    <option value="4">4 Pasajeros</option>
			    <option value="5">5 Pasajeros</option>
			    <option value="6">6 Pasajeros</option>
			    <option value="7">7 Pasajeros</option>
			    <option value="8">8 Pasajeros</option>
			    <option value="9">9 Pasajeros</option>
			    <option value="10">10 Pasajeros</option>
			    <option value="11">11 Pasajeros</option>
			    <option value="12">12 Pasajeros</option>
			    <option value="13">13 Pasajeros</option>
			    <option value="14">14 Pasajeros</option>
			    <option value="15">15 Pasajeros</option>
			    <option value="16">16 Pasajeros</option>
			  </select>
			  <button class="btn btn-primary col-xs-12 col-md-6" type="submit">Continuar</button>
			</div>
		</div>	
		</form>
		</div>
	    	<!-- Call to action -->
		<div class="color cta">
			<div class="wrap">
				<p class="wow fadeInRight">Nuestros Servicios</p>
				
			</div>
		</div>
		<!-- //Call to action -->
	

		<!-- Services -->
			<div class="services boxed white" id="services">
		<!-- Item -->
			<article class="one-fourth wow fadeIn">
			<figure class="featured-image">
			<img src="../images/airport_cancun.jpg" alt="" />
			<div class="overlay">
			<a href="service.php" class="expand">+</a>
			</div>
			</figure>
			<div class="details">
			<h4><a href="service.php">Traslado Aeropuerto -Cancun</a></h4>
			<p>La Zona Hotelera de Cancún está a unos 15-25 minutos del Aeropuerto de Cancún y tiene algunas de las playas y vistas más hermosas de México.</p>
			<a class="more" title="Read more" href="service.php">Leer Más</a>
			</div>
			</article>
		<!-- //Item -->
		<!-- Item -->
			<article class="one-fourth wow fadeIn" data-wow-delay=".2s">
			<figure class="featured-image">
			<img src="../images/playa_del_carmen.jpg" alt=""/>
			<div class="overlay">
			<a href="service.php" class="expand">+</a>
			</div>
			</figure>
			<div class="details">
			<h4><a href="service.php">Traslado Aeropuerto - Playa del Carmen</a></h4>
			<p>Playa del Carmen está a unos 45-55 minutos del aeropuerto de Cancún y es una ciudad cosmopolita conocida por su población diversa.</p>
			<a class="more" title="Read more" href="service.php">Leer más</a>
			</div>
			</article>
		<!-- //Item -->
		<!-- Item -->
			<article class="one-fourth wow fadeIn" data-wow-delay=".4s">
			<figure class="featured-image">
			<img src="../images/tulum.jpg" alt="" />
			<br>
			<div class="overlay">
			<a href="service.php" class="expand">+</a>
			</div>
			</figure>
			<div class="details">
			<h4><a href="service.php">Traslado - Aeropuerto - Tulum</a></h4>
			<p>Tulum se encuentra aproximadamente a 1:30- 2:00 horas del Aeropuerto de Cancún y es el destino de moda en la Riviera Maya con gente que viene de todo el mundo.</p>
			<a class="more" title="Read more" href="service.php">Leer más</a>
			</div>
			</article>
	
			
			<!-- Item -->
				<!-- Item -->
			<article class="one-fourth wow fadeIn" data-wow-delay=".4s">
			<figure class="featured-image">
			<img src="../images/private_cancun_playa.jpg" alt="" />
			<br>
			<div class="overlay">
			<a href="service.php" class="expand">+</a>
			</div>
			</figure>
			<div class="details">
			<h4><a href="service.php">Viaje Especial Cancun-Tulum-Playa del Carmen</a></h4>
			<p>viaje comodo y seguro en cancun,playa del carmen,Tulum y Riviera Maya.</p>
			<a class="more" title="Read more" href="service.php">Leer más</a>
			</div>
			</article>
	
			
			<!-- Item -->
		
			</div>
			<!-- //Services -->
		
		
			<!-- Call to action -->
		<div class="color cta">
			<div class="wrap">
				<p class="wow fadeInLeft">Momentos inolvidables</p>
				<p class="wow fadeInRight">Redes sociales</p>
			</div>
		</div>
		<!-- //Call to action -->
		
		
		<!-- facebook -->
		<br>
		
		<!-- Item -->
			<article class="one-half wow fadeIn">
					<div class="container">
    <div class="slider">
        <div class="slide foto1">
            <div class="caption1">
                
                <p>
                    
                </p>
            </div>
        </div>

        <div class="slide foto2">
            <div class="caption1"> 
                
                <p>
                    
                </p>
            </div>
        </div>

        <div class="slide foto3">
            <div class="caption1"> 
                
                <p>
                    
                </p>
            </div>
        </div>

        <div class="slide foto4">
            <div class="caption1"> 
                
                <p>
                    
                </p>
            </div>
        </div>

        <div class="slide foto1">
            <div class="caption1"> 
                
                <p>
                    
                </p>
            </div>
        </div>

       

    </div>
    </div>
    
    
			</article>
		<!-- //Item -->
		<!-- Item -->
			<article class="one-half wow fadeIn" data-wow-delay=".2s">
			<figure class="featured-image">
			<div class="fb-page" data-href="https://www.facebook.com/TransportationServiceinCancun/" data-tabs="timeline" data-width="540" data-height="600" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/TransportationServiceinCancun/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/TransportationServiceinCancun/">Cancun Transportation</a></blockquote></div>
			
			</article>
		<!-- //Item -->
		
		
			</div>
			<!-- //facebook -->
		
		
		
		
		<!-- Testimonials -->
		<!-- 
		 <div class="testimonials center black">
			<div class="wrap">
				<h6 class="wow fadeInDown">A great team working for you!</h6>
				<p class="wow fadeInUp">A great team working for your comfortable and safe transfer.</p>
				<p class="meta wow fadeInUp">-Matias...</p>
			</div>
		</div> 
		<!-- //Testimonials -->
	
		<!-- <div class="partners white center">
			<div class="wrap">
				<h2 class="wow fadeIn">Our partners</h2>
				<div class="one-fifth wow fadeIn"><a href="#"><img src="http://placehold.it/205x60" alt="" /></a></div>
				<div class="one-fifth wow fadeIn" data-wow-delay=".2s"><a href="#"><img src="http://placehold.it/205x60" alt="" /></a></div>
				<div class="one-fifth wow fadeIn" data-wow-delay=".4s"><a href="#"><img src="http://placehold.it/205x60" alt="" /></a></div>
				<div class="one-fifth wow fadeIn" data-wow-delay=".6s"><a href="#"><img src="http://placehold.it/205x60" alt="" /></a></div>
				<div class="one-fifth" data-wow-delay=".8s"><a href="#"><img src="http://placehold.it/205x60" alt="" /></a></div>
			</div>
		</div>
		-->   
	
		
		
	
	</main>
	<!-- //Main -->
	
	
<!-- Footer -->
	<?php
	
	      include "footer.php";
		?>
		
	<!-- //Footer -->
	
	<!-- Preloader 
	<div class="preloader">
		<div id="followingBallsG">
			<div id="followingBallsG_1" class="followingBallsG"></div>
			<div id="followingBallsG_2" class="followingBallsG"></div>
			<div id="followingBallsG_3" class="followingBallsG"></div>
			<div id="followingBallsG_4" class="followingBallsG"></div>
		</div>
	</div>
	-->
	<!-- //Preloader -->
	
	 <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="../js/jquery.uniform.min.js"></script>
	<script src="../js/jquery.datetimepicker.js"></script>
	<script src="../js/jquery.slicknav.min.js"></script>
	
   
	
	  <script type="text/javascript">
		window.onload = function () {
			$("#destination2").hide();
			$('.main-nav').slicknav({
				prependTo:'.header .wrap',
				label:''
			});
        	Validar();
        	$('#dep-date').datetimepicker({timepicker:false});
        	$('#ret-date').datetimepicker({timepicker:false});
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
		  xmlhttp.open("GET","../search-destination.php?q="+str,true);
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