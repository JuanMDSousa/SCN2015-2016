<?php		
$unidad = $this->obtenerDato('respuesta');

 

if ($unidad) {
	$cad = ""
	     . "{"
		 . "\"codigo\":\"" . $unidad->obtenerCodigo()  . "\","
		 . "\"codPensum\":\"" .  $unidad->obtenerCodPensum() . "\","
		 . "\"codTrayecto\":\"" .   $unidad->obtenerCodTrayecto() . "\","
		 . "\"codUnidad\":\"" .   $unidad->obtenerCodUnidad(). "\","
		 . "\"nombre\":\"" .   $unidad->obtenerNombre(). "\","
		 . "\"tipo\":\"" .   $unidad->obtenerTipo(). "\","
		 . "\"hti\":\"" .   $unidad->obtenerHti(). "\","
		 . "\"hta\":\"" .   $unidad->obtenerHta(). "\","
		 . "\"uniCredito\":\"" .   $unidad->obtenerUniCredito(). "\","
		 . "\"durSemana\":\"" .   $unidad->obtenerDurSemana(). "\","
		 . "\"notMinima\":\"" .   $unidad->obtenerNotMinima(). "\","
		 . "\"notMaxima\":\"" . $unidad->obtenerNotMaxima()  . "\""
		 . "}"
		 . "";
	echo $cad;
}else
	echo "[{\"codigo\":\"ERROR\",\"cosPensum\":\"ERROR\",\"numero\":\"ERROR\",\"certificado\":\"ERROR\"}]";




?>
		
