<?php
	$r = Vista::obtenerDato("docentes");

	$docentes['docentes'] = $r;

	$docentes = json_encode($docentes);

	echo $docentes;
?>