<?php
	$mensaje = Vista::obtenerDato('mensaje');
	$est = Vista::obtenerDato('estudiante');
	
	$estudiante['mensaje']=$mensaje;
	$estudiante['estatus']=1;
	$estudiante['estudiante']=$est;
	
	$cad = json_encode($estudiante);
	
	echo $cad;
	
?>
