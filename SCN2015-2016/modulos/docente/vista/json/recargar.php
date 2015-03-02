<?php

	$doc = Vista::obtenerDato('docente');
	
	$docente['estatus']=1;
	$docente['docente']=$doc;
	
	$cad = json_encode($docente);
	
	echo $cad;
	
?>
