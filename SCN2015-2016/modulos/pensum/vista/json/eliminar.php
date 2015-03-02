<?php
	$mensaje = Vista::obtenerDato('mensaje');
	
	$pensum['mensaje']=$mensaje;
	$pensum['estatus']=1;
	
	$cad = json_encode($pensum);
	
	echo $cad;
	
?>
