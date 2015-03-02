<?php
	$mensaje = Vista::obtenerDato('mensaje');
	$per = Vista::obtenerDato('persona');
	
	$persona['mensaje']=$mensaje;
	$persona['estatus']=1;
	$persona['persona']=$per;
	
	$cad = json_encode($persona);
	
	echo $cad;
	
?>
