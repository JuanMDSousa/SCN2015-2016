<?php		
$pe['estatus']=1;
$pe['periodos']=Vista::obtenerDato('periodos');


	$cad=json_encode($pe);
	echo $cad;
?>
		
