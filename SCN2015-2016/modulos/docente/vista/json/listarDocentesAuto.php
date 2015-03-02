<?php
	$docentes =Vista::obtenerDato("docentes");
	$cad = "[";
	if ($docentes != null){
		$c = 0;
		foreach ($docentes as $docente) { 
			if ($c > 0) 
				$cad .= ",";
			$cad .= "{";
			$cad .= '"label": "' . $docente['nombre1']. ' ' . $docente['apellido1'] . '", ';
			$cad .= '"value": '.$docente['codigo'];
			$cad .= "}";
			$c++;
		}
	}
	else{
		$cad .= "{";
			$cad .= '"label": " No hay coincidencias ", ';
			$cad .= '"value": null';
			$cad .= "}";
	}	
	$cad .= "]";
	echo $cad;

?>
