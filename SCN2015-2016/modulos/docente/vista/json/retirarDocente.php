<?php
	$mensaje = Vista::obtenerDato('mensaje');
	
	$docente['mensaje']=$mensaje;
	$docente['estatus']=1;

	$cad = json_encode($docente);
	
	echo $cad;
	
?>
