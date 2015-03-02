<?php

	//$r = $this->obtenerDato("respuesta");
	//var_dump($r);
	//echo '{"resp":' . (($r)? '"1"':'"0"') . '}';
	//echo "blabla";	
	//echo (($r)? "1":"0");

$arr = $this->obtenerDatos();
$r = $arr["ress"];
/*
echo "<pre>";
var_dump($arr);	
var_dump($r);	
echo "</pre>";
*/

$penn = $this->obtenerDato("ress");
$exito= $this->obtenerDato("exito");


//var_dump($pensum);


if ($exito){
	$cad = ""
	     . "{"
		 . "\"exito\":\"" . (($exito)? "1":"0") . "\","
		 . "\"codigo\":\"" .$penn . "\""
		 . "}"
		 . "";
	echo $cad;
}else
	echo "[{\"codigo\":\"ERROR\",\"nombre\":\"ERROR\",\"nombreCorto\":\"ERROR\",\"descripcion\":\"ERROR\"}]";





?>
