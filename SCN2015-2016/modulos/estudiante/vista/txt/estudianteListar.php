<?php

//extracción de la información
$estudiante = $this->obtenerDato('pensums');
$patron = $this->obtenerDato("patron");

$nombreArchivo = $this->obtenerNombreArchivoDestino(); //extraer el nombre del archivo

$arch = fopen($nombreArchivo, "w");

fwrite($arch, "Lista de pensums. Patron de busqueda: '$patron'\n\n");

fwrite($arch, " #  N. Corto      Nombre\n");

$cont = 1;
foreach ($estudiante as $ins) {
	fwrite ($arch, "$cont" . ". " . $ins->obtenerNombre1() . ":        " . $ins->obtenerNApellido1()  . "\n");
	$cont++;
}

fclose($arch);




?>
