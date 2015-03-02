<?php

/**
 * * * * * * * * * * LICENCIA * * * * * * * * * * * * * * * * * * * * *

Copyright(C) 2012
Instituto Universtiario de Tecnología Dr. Federico Rivero Palacio

Este programa es Software Libre y usted puede redistribuirlo y/o modificarlo
bajo los términos de la versión 3.0 de la Licencia Pública General (GPLv3)
publicada por la Free Software Foundation (FSF), es distribuido sin ninguna
garantía. Usted debe haber recibido una copia de la GPLv3 junto con este
programa, sino, puede encontrarlo en la página web de la FSF, 
específicamente en la dirección http://www.gnu.org/licenses/gpl-3.0.html

 * * * * * * * * * * ARCHIVO * * * * * * * * * * * * * * * * * * * * *

Nombre: index.php
Diseñador: Johan Alamo (johan.alamo@gmail.com)
Programador: Johan Alamo
Fecha: Julio de 2012
Descripción:  
	Este archivo es el punto de partida de la aplicación, cualquier petición
	será recibida por este archivo y luego se pasará el control a 
	PrincipalControlador y éste se encargará de determinar cuál es el módulo
	y la acción solicitada y ejecutará las acciones correspondientes.

 * * * * * * * * Cambios/Mejoras/Correcciones/Revisiones * * * * * * * *
Diseñador - Programador /   Fecha   / Descripción del cambio
---                         ----      ---------

 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/
try{
	require_once("base/clases/utilitarias/PostGet.clase.php");
	require_once("base/clases/utilitarias/errores/manejoErrores.php");
	//set_exception_handler("manejoErrores::manejadorExcepcionesNoCapturadas");
	//set_error_handler("manejoErrores::manejarErrores");
	//Inclusión del archivo que contiene el controlador principal del programa	
	
	require_once 'modulos/principal/PrincipalControlador.clase.php';

//llamado a la función iniciar del controlador principal
	PrincipalControlador::iniciar();
}catch (Exception $e){//captura de exepciones 
	manejoErrores::manejarExcepcion($e);				
}
?>
