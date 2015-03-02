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

Nombre: Pensum.clase.php
Diseñador: Jhonny vielma
Programador: Jhonny vielma
Fecha: Enero de 2014
Descripción:  
	Este archivo contiene la implementación del objeto Pensum, el cual
	consta de su constructor y de los atributos siguientes
		$codigo: código del instituto
		$nombre: Nombre del instituto
		$nombreCorto: Abreviación del instituto, ej: IUT-FRP
		$observaciones: Ubicación geográfica del instituto
		$trayecto: Trayectos que contiene el pensum. 
	
	Se corresponde con la siguiente estructura de la base de datos 
		create table ts_instituto(
		   codigo serial,
		   nombre varchar(100) not null,
		   nombre_corto varchar(20) not null,
		   observaciones varchar(200),
			CONSTRAINT cp_pensum PRIMARY KEY (codigo ),
			CONSTRAINT ca_pensum UNIQUE (nom_corto )
		 );		

 * * * * * * * * Cambios/Mejoras/Correcciones/Revisiones * * * * * * * *
Diseñador - Programador /   Fecha   / Descripción del cambio
---                         ----      ---------

 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/

require_once "Trayecto.clase.php";
class Pensum { 
	//atributos de la clase
	public $codigo;
	public $nombre;
	public $nombreCorto;
	public $observaciones;
	public $trayectos;

	public function __construct($codigo=NULL, $nombre=NULL, $observaciones=NULL, $nombreCorto=NULL, $trayectos=NULL)
	{
		$this->asignarCodigo($codigo);
		$this->asignarNombre($nombre);
		$this->asignarNombreCorto($nombreCorto);
		$this->asignarObservaciones($observaciones);
		if ($trayectos!=null)
			$this->asignarTrayectos($trayectos);
	}

	/*Método permite obtener la cantidad de  horas de trabajo independiente 
	* por pensum. Retorna un valor entero.*/
	public function obtenerHtiPensum(){
		$Tpensum=0;
		for ($i=0; $i<count($this->obtenerTrayectos());$i++){
			if ($this->obtenerTrayecto($i) != FALSE) {
				$Tpensum +=  $this->obtenerTrayecto($i)->obtenerHtiAnio();
			}
		}
		return $Tpensum;
	}
	/*Método permite obtener la cantidad de  horas de trabajo acompañado 
	* por pensum. Retorna un valor entero.*/
	public function obtenerHtaPensum(){
		$Tpensum=0;
		for ($i=0; $i<count($this->obtenerTrayectos());$i++){
			if ($this->obtenerTrayecto($i) != FALSE) {
				$Tpensum +=  $this->obtenerTrayecto($i)->obtenerHtaAnio();
			}
		}
		return $Tpensum;
	}
	/*Método permite obtener la cantidad de unidades  curricular que posee
	*  el pensum. Retorna un valor entero.*/
	public function obtenerCantidadDeUnidadesCurricularesPensum(){
		$Tpensum=0;
		for ($i=0; $i<count($this->obtenerTrayectos());$i++){
			if ($this->obtenerTrayecto($i) != FALSE) {
				$Tpensum +=  $this->obtenerTrayecto($i)->obtenerCantidaDeUnidades();
			}
		}
		return $Tpensum;
	}
	/*Método permite obtener la cantidad de trayectos que posee
	*  el pensum. Retorna un valor entero.*/
	public function obtenerCantidaDeTrayectos(){
		
		return count($this->obtenerTrayectos());
	}
	/*Método permite obtener la cantidad de unidades de credito que posee
	*  el pensum. Retorna un valor entero.*/
	public function obtenerCreditoPorPensum(){
		$Tcredito=0;
		for ($i=0; $i<count($this->obtenerTrayectos());$i++){
			if ($this->obtenerTrayecto($i) != FALSE) {
				$Tcredito +=  $this->obtenerTrayecto($i)->obtenerCreditoPorTrayecto();
			}
		}
		return $Tcredito;
	}
	
	
	/* Método que permite asignar un trayecto en una posición especifica.
	 * trayecto y posición ambos pasados por parámetro .*/
	public function asignarTrayecto($trayecto ,$posicion){
		if (!is_numeric($posicion))
			throw new Exception("La posicion pasada por parametro en la funcion asignarTrayecto() no es un numero ");
		if ($posicion<0)
			throw new Exception("La posicion pasada por parametro en la funcion asignarTrayecto() es menor a 0 solo se permiten valones mayores a 0");
		if(!is_object($trayecto)) 
			throw new Exception("El Trayecto pasado por parametro en la funcion asignarTrayecto() no es un objeto");
		$this->trayectos[$posicion] = $trayecto;
	}
	/* Método permite obtener un trayecto en especifico, la de la posición
	 * pasada por parámetro. Retorna false si no existe ese trayecto  o el
	 * trayecto si existe.*/
	public function obtenerTrayecto($posicion){
		return is_null($this->trayectos[$posicion])? false: $this->trayectos[$posicion]  ;
	}
	//Asignar y obtener de cada atributo
	public function asignarCodigo($codigo){
		$this->codigo = $codigo;
	}
	public function obtenerCodigo(){
		return $this->codigo;
	}

	public function asignarNombre($nombre){
		$this->nombre = $nombre;
	}
	public function obtenerNombre(){
		return $this->nombre;
	}
	public function asignarNombreCorto($nombreCorto){
		$this->nombreCorto = $nombreCorto;
	}
	public function obtenerNombreCorto(){
		return $this->nombreCorto;
	}
	public function asignarObservaciones($observaciones){
		$this->observaciones = $observaciones;
	}
	public function obtenerObservaciones(){
		return $this->observaciones;
	}
	public function asignarTrayectos($trayectos){
		if (!is_array($trayectos))
			throw new Exception("Los Trayectos pasada por parametro en la funcion asignarTrayectos() no es un array debe ser array de objetos ");
			foreach ($trayectos as $clave => $valor) {
				$this->asignarTrayecto($valor,$clave);
			}
	}
	
	public function obtenerTrayectos(){
		return $this->trayectos;
	}

}

?>
