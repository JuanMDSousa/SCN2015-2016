<?php
	$pensums = $this->obtenerDato('pensums');
	$cad = "[";
	if ($pensums != false){
		$c = 0;
		foreach ($pensums as $ins) { 
			if ($c > 0) 
				$cad .= ",";
			$cad .= "{";
			$cad .= '"label": "' . $ins->obtenerNombre() . ' (' . $ins->obtenerNombreCorto() . ')' . '", ';
			$cad .= '"value": {';
			$cad .=	'"codigo":"' . $ins->obtenerCodigo() . '","nombreCorto":"' . $ins->obtenerNombreCorto() . '","nombre":"' . $ins->obtenerNombre(). '","observaciones":"' . $ins->obtenerObservaciones() . '"';
			$cad .= '}';
			$cad .= "}";
			$c++;
		}
	}	
	$cad .= "]";
	echo $cad;

?>
