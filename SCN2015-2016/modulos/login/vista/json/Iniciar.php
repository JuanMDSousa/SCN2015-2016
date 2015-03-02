<?php		
$mensaje=Vista::obtenerDato('mensaje');
$cur['estatus']=1;
$cur['mensaje']=$mensaje;
$cur["login"]=Vista::obtenerDato('login');
	$cad=json_encode($cur);
	echo $cad;
?>
		
