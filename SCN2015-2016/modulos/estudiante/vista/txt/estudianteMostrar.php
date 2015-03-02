<?php

$pensums = $this->obtenerDato('pensums');
$pensum = $pensums[0];

$arch = fopen("salida.txt", "w");

fwrite($arch, "infor. del pensum\n\n");

fwrite($arch, "\nNombre:       " . $pensum->obtenerNombre() . "\n" );
fwrite($arch, "\nNombre corto: " . $pensum->obtenerNombreCorto() . "\n" );

fclose($arch);

?>
