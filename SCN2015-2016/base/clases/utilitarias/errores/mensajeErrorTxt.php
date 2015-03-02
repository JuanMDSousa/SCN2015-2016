<?php


$arch = fopen("salida.txt", "w");

fwrite($arch, "mensaje de error\n\n");

fwrite($arch, "\nMensaje Error:       " . $mensaje . "\n" );
fwrite($arch, "\nCodigo Error: " . $codigo . "\n" );

fclose($arch);

?>
