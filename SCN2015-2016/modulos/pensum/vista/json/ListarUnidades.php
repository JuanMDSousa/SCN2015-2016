<?php		
$uni['estatus']=1;
$uni['unidades']=Vista::obtenerDato('unidades');


	$cad=json_encode($uni);
	echo $cad;
?>