<?php 

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

$user_agent = $_SERVER['HTTP_USER_AGENT'];
$is_firefox = false;
if(stripos($user_agent,'Firefox') !== false){
	$is_firefox = true;
}

//$conexion = mysqli_connect("127.0.0.1","root","6101696","transfer");

     $conexion = mysqli_connect("localhost","canczdhg_taxiaeropuerto","A;2FE+fi","canczdhg_taxiaeropuerto");
    $sql = "SELECT * FROM extras ex join categorias cat on(cat.id_categoria=ex.categoria) ORDER BY nombre,n_extra;";
	$respuesta22 = mysqli_query($conexion,$sql);



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
	
	<link rel="stylesheet" href="../css/theme-dblue.css" />
	<link rel="stylesheet" href="../css/style.css" />
	<link rel="stylesheet" href="../css/animate.css" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Raleway:400,500,600,700|Montserrat:400,700">
	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

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
										<p>'.$destino_2.'&nbsp  hasta  &nbsp'.$destino_1.'</p>
									</div>';*/
						}


					?>

			</div>
		</div>
		<!-- //Search -->
		<style type="text/css">
			div.item{
			    display:inline-block;
			    padding:10px;
			    text-align:center;
			    width:250px;
			}

			.item > span{
			    display:block;
			    text-align:center;
			    /* overflow:hidden; */
			}

			.item > img{
			    width:100px;
			    height:100px;
			}

			.item > button{
			    margin:10px;
			}

			#accordion{
				width: 100%;	
				float:left;
			}

			.collapseNumber{
				box-shadow: 2px 1px 14px 0px #0495c4;
			    border-radius: 0px 20px 20px 20px;
			    padding: 10px;	
			    margin-bottom: 20px;
			    background: white;
			}

			.btn-accordion{
			    background: #00a1dc;
			    padding: 10px;
			    border-radius: 10px 10px 10px 10px;
			}

			@media screen and (max-width: 980px){
				#accordion{
					width: 100% !important;	
				}
				.collapseNumber{
					text-align: center;
				}
			}
		</style>
		<div class="container">
			<?php
			if ($is_firefox == true) {
				?>
				<div>
				<?php
			}else{
				?>
				<div class="row">
				<?php
			}
			?>
				<!--- Content -->
				<div class="full-width content">
					<h2>Extras</h2>
					<p>Seleccione el número total de piezas de equipaje y extras para sus traslados. Si llega con más equipaje del especificado en la reserva, no podemos garantizar su transporte. En caso de que podamos transportarlos, le cobraremos una tarifa adicional.</p>
				</div>
				<!--- //Content -->
				
				
							<?php 
							$output = '';
							$num_extra = 0;
							$temp_categoria = "";
							$collapse = 0;
							$secondCollapse = 0;
							?>
							<div id="accordion" class="col-xs-12 col-md-9">
								<form action="booking-step1.php" method="POST">		
							<?php

							while($row = mysqli_fetch_array($respuesta22))
                            {
                            	if($row['nombre'] != $temp_categoria){

                            		if($collapse != 0){
                        				?>
										</div><!-- div card -->
                        				<?php
                            		}
                            		$collapse++;
                            		$temp_categoria = $row['nombre'];
                            		?>
							        <button style="font-size: 16px;width: 100%; margin-top: 5px;margin-bottom: 5px;" onclick="return toggleAccordion(<?php echo $collapse; ?>)" class="btn btn-accordion" data-toggle="collapse" data-target="#collapse<?php echo $collapse; ?>" aria-expanded="true" aria-controls="collapse<?php echo $collapse; ?>">
								          <?php echo $temp_categoria; ?>
							        </button>
								    <div id="collapse<?php echo $collapse; ?>" class="collapseNumber" aria-labelledby="
								    heading<?php echo $collapse; ?>" data-parent="#accordion">
                            		<?php
                            	}
                                $ruta_imagen = "../images/extras/extra_".$row['id_extra'].".jpg";
                                ?>
                                <div class="item">
                                	<img src="<?php echo $ruta_imagen; ?>" class="item-img">
                                	<span><?php echo $row['n_extra'] ?></span>
                                	<span><?php echo $row['descri_extra'] ?></span>
                                	<span><?php echo $row['precio'] ?>,00 MXN</span>
                                	<button onclick="return addRemovePrice(this,0)">-</button><b>0</b><button onclick="return addRemovePrice(this,1)">+</button>
                                	<input type="hidden" name="precios[]" value="<?php echo $row['precio']; ?>">
                                	<input type="hidden" name="cant_ida[]" value="0">
                                	<input type="hidden" name="id_extra[]" value="<?php echo $row['id_extra']; ?>" />
                                </div>
                                <?php
                                
                            };
							?>
							</div>
							<?php
							if($tipo_traslado == 1){
							?>
							<div style="margin-bottom: 14px" class="collapseNumber">
					          <button class="btn btn-primary" style="font-size: 18px;" onclick="return showReturnProducts(this)">Click agregar Producos al Retorno</button>
					        </div>
							
							<div id="accordion_return" style="display: none;">
							<?php
							
								$respuesta22 = mysqli_query($conexion,$sql);
								while($row = mysqli_fetch_array($respuesta22))
	                            {
	                            	if($row['nombre'] != $temp_categoria){

	                            		if($secondCollapse != 0){
	                        				?>
											</div><!-- div card -->
	                        				<?php
	                            		}
	                            		$collapse++;
	                            		if($secondCollapse == 0){
	                            			$secondCollapse = $collapse;
	                            		}
	                            		$temp_categoria = $row['nombre'];
	                            		?>
								        <button style="font-size: 16px;width: 100%; margin-top: 5px;margin-bottom: 5px;" onclick="return toggleAccordion(<?php echo $collapse; ?>)" class="btn btn-accordion" data-toggle="collapse" data-target="#collapse<?php echo $collapse; ?>" aria-expanded="true" aria-controls="collapse<?php echo $collapse; ?>">
									          <?php echo $temp_categoria; ?>
								        </button>
									    <div id="collapse<?php echo $collapse; ?>" class="collapseNumber" aria-labelledby="
									    heading<?php echo $collapse; ?>" data-parent="#accordion">
	                            		<?php
	                            	}
	                                $ruta_imagen = "../images/extras/extra_".$row['id_extra'].".jpg";
	                                ?>
	                                <div class="item">
	                                	<img src="<?php echo $ruta_imagen; ?>" class="item-img">
	                                	<span><?php echo $row['n_extra'] ?></span>
	                                	<span><?php echo $row['descri_extra'] ?></span>
	                                	<span><?php echo $row['precio'] ?>,00 MXN</span>
	                                	<button onclick="return addRemovePrice(this,0)">-</button><b>0</b><button onclick="return addRemovePrice(this,1)">+</button>
	                                	<input type="hidden" name="precios[]" value="<?php echo $row['precio']; ?>">
	                                	<input type="hidden" name="cant_return[]" value="0">
	                                	<input type="hidden" name="id_extra[]" value="<?php echo $row['id_extra']; ?>" />
	                                </div>
	                                <?php
	                                
	                            };
							}else{
								$secondCollapse = $collapse+1;
							}
							
                            
                            $output .= '<input type="hidden" name="ubi1" value="'.$destino_1.'"/>
										<input type="hidden" name="ubi2" value="'.$destino_2.'"/>
										<input type="hidden" name="precio" value="'.$precio.'"/>
										<input type="hidden" name="dep-date" value="'.$fecha.'"/>
										<input type="hidden" name="ret-date" value="'.$fecha_r.'"/>
										<input type="hidden" name="people" value="'.$personas.'"/>
										<input type="hidden" name="modo" value="'.$tipo_traslado.'"/>
										<input type="hidden" name="n_transporte" value="'.$nombre_transporte.'"/>
										<input type="hidden" name="pickup_hour_arrival" value="'.$_POST['pickup_hour_arrival'].'"/>
										<input type="hidden" name="pickup_hour_departure" value="'.$_POST['pickup_hour_departure'].'"/>
										<input type="hidden" name="total_and_extras" value="'.$precio.' MXN" id="total_and_extras"/>
										';
                            echo $output;
                            if($tipo_traslado == 1){
                            	?>
                            	</div>
                            	</div>
                            	<?php
                            }else{
                            	?>

                            	
                            	<?php
                            }
							?>
						
						
					
					
					<div class="actions">
							<button type="submit" class="btn btn-primary col-xs-12 col-md-6">Continue</button>
						</div>
						</form>
				</div>
				
				<!--- Sidebar -->
				<aside class="one-fourth sidebar right col-xs-12 col-md-3">
					<!-- Widget -->
					<div class="widget">
						<h4>Resumen</h4>
						<div class="summary">
							<div>
								<h5>Llegada</h5>
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
									<h5>Salida</h5>
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
								<dd><?php echo $precio; ?>,00 MXN</dd>
							</dl>
						</div>
					</div>
					<!-- //Widget -->
				</aside>
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
	<script type="text/javascript">
		var flag = 0;
		var initPrice = 0;
		var lastAccordion = 1;
		var returnItems = false;

		function showReturnProducts(event){
			$('#accordion_return')[0].setAttribute("style","display:block");
			$("#collapse"+lastAccordion).toggle(500);
			lastAccordion = <?php echo $secondCollapse	; ?>;
			returnItems = true;
			return false;
		}

		function toggleAccordion(id){
			if(id != false){
				$("#collapse"+lastAccordion).toggle(500);
				$("#collapse"+id).toggle(500);
				lastAccordion = id;	
			}else{
				$("#collapse"+id).toggle(500);
			}
			return false;
		}

		function addRemovePrice(e,type){
			if(flag == 0){
				initPrice = parseFloat($('.total dd')[0].innerText);		
				flag = 1;
			}
			var actualPrice = initPrice;
			var price = parseFloat(e.parentElement.children[3].innerText.split(" ")[0]);
			//setting value
			if(type == 1){
				var valueOfItem = parseInt(e.parentElement.children[5].innerText);
				e.parentElement.children[5].innerText = valueOfItem <99?parseInt(e.parentElement.children[5].innerText)+1:99;	
			}else{
				var valueOfItem = parseInt(e.parentElement.children[5].innerText);
				e.parentElement.children[5].innerText = valueOfItem == 0?0:parseInt(e.parentElement.children[5].innerText)-1;	
			}
			e.parentElement.children[8].value = e.parentElement.children[5].innerText;

			var length = $('input:hidden').length;
			var sum = 0;
			for (var i = 0; i < length ; i++) {
				if($('input:hidden')[i].name == "precios[]"){
					sum += parseFloat($('input:hidden')[i].value) * parseInt($('input:hidden')[i+1].value);
				}
			}
			actualPrice += sum;
			$('.total dd')[0].innerText = actualPrice+" MXN";
			$('#total_and_extras').val(actualPrice+" MXN");
			return false;
		}

		function updatepriceIda(){
			if(flag == 0){
				initPrice = parseFloat($('.total dd')[0].innerText);		
				flag = 1;
			}
			var actualPrice = initPrice;
			var length = $('#extratable tr').length;
			var sum = 0;
			for (var i = 1; i < length; i++) {
				var individualPrice = parseFloat($('#extratable tr')[i].children[3].innerText);
				var QtyIda = $('#extratable tr')[i].children[4].children[0].value.length !=0?parseFloat($('#extratable tr')[i].children[4].children[0].value):0;
				var QtyReturn = $('#extratable tr')[i].children[5].children[0].value.length !=0?parseFloat($('#extratable tr')[i].children[5].children[0].value):0;

				sum += (individualPrice * QtyIda) + (individualPrice * QtyReturn);
			}

			actualPrice += sum;
			$('.total dd')[0].innerText = actualPrice+" MXN";

		}
	</script>
	<script type="text/javascript">
			window.onload = function () {
			$('.main-nav').slicknav({
				prependTo:'.header .wrap',
				label:''
			});
      	}
	</script>
    <!-- jQuery -->
    <script src="../js/jquery.min.js"></script>
	<script src="../js/jquery.uniform.min.js"></script>
	<script src="../js/jquery.slicknav.min.js"></script>
	<script type="text/javascript">
		for (var i = 2; i < <?php echo $secondCollapse	; ?>;i++) {
				$("#collapse"+i).toggle(500);	
		}

		for(var i = <?php echo $secondCollapse+1 ?>;i <= <?php echo $collapse ?> ; i++){
			$("#collapse"+i).toggle(500);		
		}
	</script>
	<a href="https://api.whatsapp.com/send?phone=+529983545838" class="btn-wsp" target="_blank">
	<i class="fa fa-whatsapp icono"></i>
	</a>
	
  </body>
</html>