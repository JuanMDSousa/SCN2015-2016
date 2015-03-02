<?php

	$per = Vista::obtenerDato('persona');
	
	$persona['estatus']=1;
	$persona['persona']=$per;
	
	$cad = json_encode($persona);
	
	echo $cad;
	
?>
