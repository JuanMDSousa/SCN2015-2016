<?php

$institutos = $this->obtenerDato('institutos');
$instituto = $institutos[0];

if ($instituto) {
	$cad = ""
	     . "{"
		 . "\"codigo\":\"" . $instituto->obtenerCodigo()  . "\","
		 . "\"nombre\":\"" .  $instituto->obtenerNombre() . "\","
		 . "\"nombreCorto\":\"" .   $instituto->obtenerNombreCorto() . "\","
		 . "\"direccion\":\"" . $instituto->obtenerDireccion()  . "\""
		 . "}"
		 . "";
	echo $cad;
}else
	echo "[{\"codigo\":\"ERROR\",\"nombre\":\"ERROR\",\"nombreCorto\":\"ERROR\",\"descripcion\":\"ERROR\"}]";




?>
		
