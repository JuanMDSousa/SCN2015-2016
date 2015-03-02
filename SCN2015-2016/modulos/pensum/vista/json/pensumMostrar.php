<?php		
$pensum = $this->obtenerDato('pensums');

 

if ($pensum) {
	$cad = ""
	     . "{"
		 . "\"codigo\":\"" . $pensum->obtenerCodigo()  . "\","
		 . "\"nombre\":\"" .  $pensum->obtenerNombre() . "\","
		 . "\"nombreCorto\":\"" .   $pensum->obtenerNombreCorto() . "\","
		 . "\"trayect\":\"" .   $pensum->obtenerCantidaDeTrayectos(). "\","
		 . "\"hti\":\"" .   $pensum->obtenerHtiPensum(). "\","
		 . "\"hta\":\"" .   $pensum->obtenerHtaPensum(). "\","
		 . "\"unidades\":\"" .   $pensum->obtenerCreditoPorPensum(). "\","
		 . "\"uc\":\"" .   $pensum->obtenerCantidadDeUnidadesCurricularesPensum(). "\","
		 . "\"observaciones\":\"" . $pensum->obtenerObservaciones()  . "\""
		 . "}"
		 . "";
	echo $cad;
}else
	echo "[{\"codigo\":\"ERROR\",\"nombre\":\"ERROR\",\"nombreCorto\":\"ERROR\",\"descripcion\":\"ERROR\"}]";




?>
		
