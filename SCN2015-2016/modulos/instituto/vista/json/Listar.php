<?php
	$instituto['institutos'] = Vista::obtenerDato('institutos');
	$instituto['estatus'] = 1;
	$instituto['mensaje']= Vista::obtenerDato('mensaje');
	$cad = json_encode($instituto);
	echo $cad;

?>
