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

Nombre: PostGet.clase.php
Diseñador: Johan Alamo (johan.alamo@gmail.com)
Programador: Johan Alamo
Fecha: Julio de 2012
Descripción:  
	Maneja el arreglo POST y/o GET de una forma más ordendada, centralizada
	y sencilla
	
	
 * * * * * * * * Cambios/Mejoras/Correcciones/Revisiones * * * * * * * *
Diseñador - Programador /   Fecha   / Descripción del cambio
---                         ----      ---------

 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/

abstract class PostGet {
    
    /**Función que permite colocar todos los índices de los arreglos
     * $_POST y $_GET en minúscula, esto para evitar problemas al momento
     * de pasar la información por alguno de los métodos post y/o get
     */
    public static function colocarIndicesMinuscula(){
		foreach($_POST as $clave => $valor)
			$_POST[strtolower($clave)] = $valor;
		foreach($_GET as $clave => $valor)
			$_GET[strtolower($clave)] = $valor;
	}
    
    
	/**función que permite obtener un valor del arreglo POST y/o GET
	  dándole prioridad al arreglo POST
	   Parámetros de entrada:
	     $indice: índice en donde se buscará el valor
	   Valor de retorno:
	     - el valor de la posición en caso de existir
	     - null en caso de no existir
	*/
    public static function obtenerPostGet($indice){
		//en primer lugar revisa el arreglo $_POST
        $valor = PostGet::obtenerPost($indice);
		//si no encuentra en POST busca en GET
		if (is_null($valor))
			$valor = PostGet::obtenerGet($indice);
        //retorna lo encontrado
        return $valor;
    }

    
	/**
	 * función que permite obtener un valor del arreglo POST
	   Parámetros de entrada:
	     $indice: índice en donde se buscará el valor
	   Valor de retorno:
	     - el valor de la posición en caso de existir
	     - null en caso de no existir
	*/
    public static function obtenerPost($indice){
        return isset($_POST[$indice]) ?   $_POST[$indice]: null;
    }


	/**
	 * función que permite obtener un valor del arreglo GET
	   Parámetros de entrada:
	     $indice: índice en donde se buscará el valor
	   Valor de retorno:
	     - el valor de la posición en caso de existir
	     - null en caso de no existir
	 *  @param miindice
	*/
    public static function obtenerGet($indice){
        return isset($_GET[$indice]) ?   $_GET[$indice]: null;
    }
}
?>
