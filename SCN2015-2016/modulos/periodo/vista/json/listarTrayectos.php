<?php		
$trayectos=Vista::obtenerDato('trayectos');
$tray['estatus']=1;
$tray['trayectos']=Vista::obtenerDato('trayectos');


	$cad=json_encode($tray);
	echo $cad;
?>
		