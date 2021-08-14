<?php

require_once('vendor/autoload.php');

$sqlStripe = "SELECT * FROM stripe;";
$respuestaStripe= mysqli_query($conexion,$sqlStripe);
$rowStripe = mysqli_fetch_array($respuestaStripe);


$stripe = [
  "secret_key"      => $rowStripe['secret_key'],
  "publishable_key" => $rowStripe['publishable_key'],
  "currency" => $rowStripe['currency']
];


\Stripe\Stripe::setApiKey($stripe['secret_key']);

?>