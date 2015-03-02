<?php		

$cur['estatus']=1;
$cur['departamentos']=Vista::obtenerDato('departamentos');


	$cad=json_encode($cur);
	echo $cad;
?>
