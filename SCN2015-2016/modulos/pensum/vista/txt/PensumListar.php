<?php

//extracción de la información
$pensums = $this->obtenerDato('pensums');
$patron = $this->obtenerDato("patron");

$nombreArchivo = $this->obtenerNombreArchivoDestino(); //extraer el nombre del archivo

$arch = fopen($nombreArchivo, "w");

fwrite($arch, "Lista de pensums. Patron de busqueda: '$patron'\n\n");

fwrite($arch, " #  N. Corto      Nombre\n");

$cont = 1;
foreach ($pensums as $ins) {
	fwrite ($arch, "$cont" . ". " . $ins->obtenerNombreCorto() . ":        " . $ins->obtenerNombre()  . "\n");
	$cont++;
}

fclose($arch);




?>
