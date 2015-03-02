<?php
/*
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

Nombre: Fotografia.php
Diseñador: Daniel Abreu (dabreuperes@gmail.com)
Programador: Daniel Abreu
Fecha: Diciembre de 2012
Descripción
	-----------------------------
	-----------------------------
 * * * * * * * * Cambios/Mejoras/Correcciones/Revisiones * * * * * * * *
Diseñador - Programador /   Fecha   / Descripción del cambio
---                         ----      ---------

 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
*/ 

class Fotografia { 
	//atributos de la clase
	private $cedula;
	private $codigo;
	private $imagen;
	private $ancho;
	private $alto;
	private $nombre;
	private $tamaño;
	private $formato;
	private $nombreTemporal;
	private $direccion;


	public function __construct($cedula=NULL, $codigo=NULL, $imagen=NULL, $ancho=NULL, $alto=NULL, $nombre=NULL, $tamaño=NULL, $formato=NULL, $nombreTemporal=NULL, $direccion=NULL)
	{
		$this->asignarCedula($cedula);
		$this->asignarCodigo($codigo);
		$this->asignarImagen($imagen);
		$this->asignarAncho($ancho);
		$this->asignarAlto($alto);
		$this->asignarNombre($nombre);
		$this->asignarTamaño($tamaño);
		$this->asignarFormato($formato);
		$this->asignarNombreTemporal($nombreTemporal);
		$this->asignarDireccion($imagen);
	}


	//Coloque aquí los métodos y operaciones de la clase


	//Asignar y obtener de cada atributo
	public function asignarCedula($cedula){
		$this->cedula = $cedula;
	}
	public function obtenerCedula(){
		return $this->cedula;
	}

	public function asignarCodigo($codigo){
		$this->codigo = $codigo;
	}
	public function obtenerCodigo(){
		return $this->codigo;
	}

	public function asignarImagen($imagen){
		$this->imagen = $imagen;
	}
	public function obtenerImagen($index=NULL){
		if ($index!=NULL)
			return $this->imagen[$index];
		else
			return $this->imagen;
	}

	public function asignarAncho($ancho){
		$this->ancho = $ancho;
	}
	public function obtenerAncho(){
		return $this->ancho;
	}

	public function asignarAlto($alto){
		$this->alto = $alto;
	}
	public function obtenerAlto(){
		return $this->alto;
	}

	public function asignarNombre($nombre){
		$this->nombre = $nombre;
	}
	public function obtenerNombre(){
		return $this->nombre;
	}

	public function asignarTamaño($tamaño){
		$this->tamaño = $tamaño;
	}
	public function obtenerTamaño(){
		return $this->tamaño;
	}

	public function asignarFormato($formato){
		$this->formato = $formato;
	}
	public function obtenerFormato(){
		return $this->formato;
	}

	public function asignarNombreTemporal($nombreTemporal){
		$this->nombreTemporal = $nombreTemporal;
	}
	public function obtenerNombreTemporal(){
		return $this->nombreTemporal;
	}
	public function asignarDireccion($direccion){
		$this->direccion = $direccion;
	}
	public function obtenerDireccion(){
		return $this->direccion;
	}

}

?>
