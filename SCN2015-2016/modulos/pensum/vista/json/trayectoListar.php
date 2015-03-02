<?php

//     D O C U M E N T A C I Ó N
	$pensum = $this->obtenerDato('pensum');
	$trayectos = $this->obtenerDato('trayectos'); 
	$cant = count($trayectos);
	$r = "{\"cantidad\":\"" . $cant   . "\"";
	if ($cant > 0){
		
		$r .= ",";	
		$r .= '"trayectos":[';
	
		//construcción de la lista de trayectos
		for ($i=0; $i< $cant; $i++){
			$t = $trayectos[$i];
			
			if ($i > 0)
				$r .= ",";
			
			$r .= '{';
			
			$r .= '"numero":"' . $t->obtenerNumero() . '",'
				. '"certificado":"' . $t->obtenerCertificado() . '",'
				. '"codigo":"' . $t->obtenerCodigo() . '",'
				. '"codPensum":"' . $t->obtenerCodPensum() . '",'
				. '"canUnidades":"' . $t->obtenerCantidaDeUnidades() . '",'
				. '"minCredito":"' . $t->obtenerMinCredito() . '"';
			$r .= "}\n";
		}	
		$r.= "]";
	}
	$r .= "}";
	
	echo $r;

?>
