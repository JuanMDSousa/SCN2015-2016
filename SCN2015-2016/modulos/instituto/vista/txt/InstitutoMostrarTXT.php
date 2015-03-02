<?php

$institutos = $this->obtenerDato('institutos');
$instituto = $institutos[0];

$arch = fopen("salida.txt", "w");

fwrite($arch, "infor. del instituto\n\n");

fwrite($arch, "\nNombre:       " . $instituto->obtenerNombre() . "\n" );
fwrite($arch, "\nNombre corto: " . $instituto->obtenerNombreCorto() . "\n" );

fclose($arch);

?>
