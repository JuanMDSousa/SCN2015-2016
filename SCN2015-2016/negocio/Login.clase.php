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

Nombre: Login.clase.php
Diseñador: Geraldine Castillo
Programador: Geraldin Castillo 
Fecha: enero 2014
Descripción:  
	Esta clase permite contener los datos de logueo de un usuario en un objeto tipo login.

 * * * * * * * * Cambios/Mejoras/Correcciones/Revisiones * * * * * * * *
Diseñador - Programador /   Fecha   / Descripción del cambio
---                         ----      ---------

* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/
class Login{ 
	private $nombre; // Atributos de la clase
	private $codigo;
	private $tipo;
	private $apellido;
	
	/* Este es el constructor de la clase que permite inicializar los atributos
	   privados: nombre, codigo, tipo y el apellido con los valores pasados por
	   parámetros. Cada parámetro tiene el 	valor null por omisión, es decir, algunos
	   se pueden omitir.
	 * */
	
	public function __construct($nombre=NULL,$apellido=NULL,$tipo=NULL,$codigo=NULL){
		$this->asignarNombre($nombre);
		$this->asignarApellido($apellido);
		$this->asignarTipo($tipo);
		$this->asignarCodigo($codigo);
		
	}
	
//Asignar y obtener de cada atributo
	public function asignarNombre($nombre){
		$this->nombre = $nombre;
	}
	public function obtenerNombre(){
		return $this->nombre;
	}
	public function asignarApellido($apellido){
		$this->apellido = $apellido;
	}
	public function obtenerApellido(){
		return $this->apellido;
	}
	public function asignarCodigo($codigo){
		$this->codigo = $codigo;
	}
	public function obtenerCodigo(){
		return $this->codigo;
	}
	public function asignarTipo($tipo){
		$this->tipo= $tipo;
	}
	public function obtenerTipo(){
		return $this->tipo;
	}
	
}
?>
