<?php
	$pen = Vista::obtenerDato('pensum');
	$pensum['estatus']=1;
	$pensum['pensum']=$pen;
	$cad = json_encode($pensum);
	echo $cad;
?>
