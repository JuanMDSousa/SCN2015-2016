<?php

	$mensaje = Vista::obtenerDato('mensaje');
	$pen = Vista::obtenerDato('pensum');
	
	$pensum['mensaje']=$mensaje;
	$pensum['estatus']=1;
	$pensum['pensum']=$pen;
	
	$cad = json_encode($pensum);
	
	echo $cad;
	
?>


