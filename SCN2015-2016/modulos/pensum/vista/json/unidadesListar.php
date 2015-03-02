<?php

//     D O C U M E N T A C I Ó N
	$pensum = $this->obtenerDato('pensum');
	$unidades = $this->obtenerDato('uniCurriculares'); 
	$cant = count($unidades);
	$codPensum = $this->obtenerDato("codPensum");
	$codTrayecto = $this->obtenerDato("codTrayecto");
	
	
	
	$r = "{\"cantidad\":\"" . $cant   . "\",";
	$r .= "\"codPensum\":\"" .  $codPensum  . "\",";
	$r .= "\"codTrayecto\":\"" .  $codTrayecto  . "\"";
	
	if ($cant > 0){
		
		$r .= ",";	
		$r .= '"unidades":[';
	
		//construcción de la lista de trayectos
		for ($i=0; $i< $cant; $i++){
			$t = $unidades[$i];
			
			if ($i > 0)
				$r .= ",";
			
			$r .= '{';
			
			$r .= '"codigo":"' . $t->obtenerCodigo() . '",'
				. '"codPensum":"' . $t->obtenerCodPensum() . '",'
				. '"codTrayecto":"' . $t->obtenerCodTrayecto() . '",'
				. '"codUnidad":"' . $t->obtenerCodUnidad() . '",'
				. '"nombre":"' . $t->obtenerNombre() . '",'
				. '"hti":"' . $t->obtenerHti() . '",'
				. '"hta":"' . $t->obtenerHta() . '",'
				. '"uniCredito":"' . $t->obtenerUniCredito() . '",'
				. '"durSemana":"' . $t->obtenerDurSemana() . '",'
				. '"notaMinima":"' . $t->obtenerNotMinima() . '",'
				. '"notaMaxima":"' . $t->obtenerNotMaxima() . '",'
				. '"tipo":"' . $t->obtenerTipo() . '"';
			$r .= "}\n";
		}	
		$r.= "]";
	}
	$r .= "}";
	
	echo $r;

?>
