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

Nombre: Util.clase.php
Diseñador: Johan Alamo (johan.alamo@gmail.com)
Programador: Johan Alamo
Fecha: Febrero de 2012
Descripción:  
	Clase que ofrece utilidades para el programador
	
	
 * * * * * * * * Cambios/Mejoras/Correcciones/Revisiones * * * * * * * *
Diseñador - Programador /   Fecha   / Descripción del cambio
---                         ----      ---------

 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/

abstract class Util {
    
    /**
	 * función que permite crear una clase
	 *  Parámetros de entrada:
	  *   $nombre: Indica el nombre de la clase a crear
	   *  $atributos: recibe los atributos de la clase separados por coma
	  * Valor de retorno:
	   *  No tiene
	*/
	

	public static function crearClase($clase, $atributos) 
	{	

		//separar en un arreglo cuando encuentre comas en la variable $atributos
		$arrAtributos = explode(",",$atributos);


		//crea el archivo
		$arch = fopen("$clase.clase.php","w");
		$cl = "\r\n"; //caracter de cambio de linea
		$tab = "\t";  //caracter tabulador
		echo "entro a crear clase";
		
		$cad = "<?php$cl$cl";
		$cad .= "class $clase { $cl";
		
		$cad .= "$tab//atributos de la clase$cl";
		foreach ( $arrAtributos as $atrib){
				$cad .= "${tab}private \$$atrib;$cl";
		}
	
		$cad .= "$cl$cl";
		
		//*********  hacer el constructor  *****************
		$cad .= "${tab}public function __construct(";
		$coma = "";
		foreach ($arrAtributos as $atrib){  //los parámetros del constructor
			$cad .= $coma;
			$cad .= "\$$atrib=NULL";
			$coma = ", ";
		}
		$cad .= ")$cl$tab" . '{' . "$cl";
		foreach ($arrAtributos as $atrib){
			$atribMayuscula = ucfirst($atrib);
			$cad .= "$tab$tab\$this->asignar$atribMayuscula(\$$atrib);$cl";
		}
		$cad .= "$cl${tab}}"; 
		//********* fin hacer constructor  **********************
		
		$cad .= "$cl$cl$cl$tab//Coloque aquí los métodos y operaciones de la clase$cl$cl$cl";
		
		$cad .= "$tab//Asignar y obtener de cada atributo$cl";
		foreach($arrAtributos as $atrib){
			$atribMayuscula = ucfirst($atrib);
			
			$cad .= "${tab}public function asignar$atribMayuscula(\$$atrib)" . '{' . $cl;
			$cad .= "$tab$tab\$this->$atrib = \$$atrib;$cl";
			$cad .= $tab . '}' . $cl;
			
			$cad .= "${tab}public function obtener$atribMayuscula()" . '{' . $cl;
			$cad .= "$tab${tab}return \$this->$atrib;$cl";
			$cad .= $tab . '}' . $cl . $cl;
		}
		
		
		$cad .= '}' . $cl . $cl; //llave de cerrado de la clase
		$cad .= "?>";
		fputs($arch, $cad);  //grabar en el archivo.
		fclose($arch);		//cerrar archivo

		//$cad =  htmlentities($cad);
		//$cad = str_replace( "\n","<br>",$cad );
		//echo $cad; 
		
		//cambiar dueño y permisos al archivo creado
		//chown("$clase.php", "nobody");
		chmod("$clase.php",  0777);
	}
}
?>
