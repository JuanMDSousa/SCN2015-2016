<?php		
$trayecto = $this->obtenerDato('respuesta');

 

if ($trayecto) {
	$cad = ""
	     . "{"
		 . "\"codigo\":\"" . $trayecto->obtenerCodigo()  . "\","
		 . "\"codPensum\":\"" .  $trayecto->obtenerCodPensum() . "\","
		 . "\"numero\":\"" .   $trayecto->obtenerNumero() . "\","
		 . "\"certificado\":\"" .   $trayecto->obtenerCertificado(). "\","
		 . "\"minCredito\":\"" . $trayecto->obtenerMinCredito()  . "\""
		 . "}"
		 . "";
	echo $cad;
}else
	echo "[{\"codigo\":\"ERROR\",\"cosPensum\":\"ERROR\",\"numero\":\"ERROR\",\"certificado\":\"ERROR\"}]";




?>
		
