<?php

	$mensaje = Vista::obtenerDato('mensaje');
	
	$persona['mensaje']=$mensaje;
	$persona['estatus']=1;
	
	$cad = json_encode($persona);
	
	echo $cad;
	
?>

