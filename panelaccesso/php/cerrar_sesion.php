<?php
	session_start();
	
		// Destruir sesion
		session_unset();
		session_destroy();
		// Redireccionar al index
		header("Location:../index.html");
		
		
	
?>