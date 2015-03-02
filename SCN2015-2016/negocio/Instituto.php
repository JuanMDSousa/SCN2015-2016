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

Nombre: Instituto.clase.php
Diseñador: Johan Alamo (johan.alamo@gmail.com)
Programador: Johan Alamo
Fecha: Julio de 2012
Descripción:  
	Este archivo contiene la implementación del objeto Instituto, el cual
	consta de su constructor y de los atributos siguientes
		$codigo: código del instituto
		$nombre: Nombre del instituto
		$nombreCorto: Abreviación del instituto, ej: IUT-FRP
		$direccion: Ubicación geográfica del instituto
	
	Se corresponde con la siguiente estructura de la base de datos 
		create table ts_instituto(
		   codigo_instituto smallint,
		   nombre varchar(100) not null,
		   nombre_corto varchar(20) not null,
		   direccion varchar(100),
		   constraint cp_instituto primary key (codigo_instituto),
		   constraint ca_instituto unique (nombre_corto)
		 );		

 * * * * * * * * Cambios/Mejoras/Correcciones/Revisiones * * * * * * * *
Diseñador - Programador /   Fecha   / Descripción del cambio
---                         ----      ---------

 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/

	class Instituto {
		private $codigo;
		private $nombre;
		private $nombreCorto;
		private $direccion;

		//Constructor
		function __construct ($codigo=null,$nombre=null,$nombreCorto=null,$direccion=null){
			$this->asignarCodigo($codigo);
			$this->asignarNombre($nombre);
			$this->asignarNombreCorto($nombreCorto);
			$this->asignarDireccion($direccion);
		}
		
		//Asignar y Obtener de cada instituto
		
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
				
		public function asignarDireccion($direccion){
			$this->direccion = $direccion;
		}
		public function obtenerDireccion(){
			return $this->direccion;
		}	
	}
?>
