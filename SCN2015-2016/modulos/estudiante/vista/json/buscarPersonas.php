<?php
	$est = Vista::obtenerDato('estudiante');
	
	$estudiante['estatus']=1;
	$estudiante['estudiante']=$est;
	
	$cad = json_encode($estudiante);
	
	echo $cad;
	
?>
