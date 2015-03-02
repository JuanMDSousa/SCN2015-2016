<?php

	$mensaje = Vista::obtenerDato('mensaje');
	
	$estudiante['mensaje']=$mensaje;
	$estudiante['estatus']=1;
	
	$cad = json_encode($estudiante);
	
	echo $cad;
	
?>
