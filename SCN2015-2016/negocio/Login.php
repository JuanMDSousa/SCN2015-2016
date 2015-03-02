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
	public $nombre; // Atributos de la clase
	public $codigo;
	public $tipo;
	public $apellido;
	public $usuario;
	private $pass;
	public $nomInstituto;
	public $codInstituto;
	public $nomDepartamento;
	public $codDepartamento;
	public $codPensum;
	
	/* Este es el constructor de la clase que permite inicializar los atributos
	   privados: nombre, codigo, tipo y el apellido con los valores pasados por
	   parámetros. Cada parámetro tiene el 	valor null por omisión, es decir, algunos
	   se pueden omitir.
	 * */
	
	public function __construct($nombre=NULL,$apellido=NULL,$tipo=NULL,$codigo=NULL,$usuario=null,$pass=null,$nombreInstituto=null,
								$codInstituto=null,$nombreDepartamento=null,$codDepartamento=null,$codPensum=null){
		$this->asignarNombre($nombre);
		$this->asignarApellido($apellido);
		$this->asignarTipo($tipo);
		$this->asignarCodigo($codigo);
		$this->asignarUsuario($usuario);
		$this->asignarPass($pass);
		$this->asignarNombreInstituto($nombreInstituto);
		$this->asignarCodigoInstituto($codInstituto);
		$this->asignarNombreDepartamento($nombreDepartamento);
		$this->asignarCodigoDepartamento($codDepartamento);
		$this->asignarCodigoPensum($codPensum);
		
	}
	
//Asignar y obtener de cada atributo
	public function asignarNombre($nombre){
		$this->nombre = $nombre;
	}
	public function asignarNombreInstituto($nomInstituto){
		$this->nomInstituto = $nomInstituto;
	}
	public function asignarCodigoInstituto($codInstituto){
		$this->codInstituto = $codInstituto;
	}
	public function asignarNombreDepartamento($nomDepartamento){
		$this->nomDepartamento = $nomDepartamento;
	}
	public function asignarCodigoDepartamento($codDepartamento){
		$this->codDepartamento = $codDepartamento;
	}
	public function asignarCodigoPensum($codPensum){
		$this->codPensum = $codPensum;
	}

	public function obtenerNombreInstituto(){
		return $this->nomInstituto;
	}
	public function obtenerCodigoInstituto(){
		return $this->codInstituto;
	}
	public function obtenerNombreDepartamento(){
		return $this->nomDepartamento;
	}
	public function obtenerCodigoDepartamento(){
		return $this->codDepartamento;
	}
	public function obtenerCodigoPensum(){
		return $this->codPensum;
	}











	public function obtenerNombre(){
		return $this->nombre;
	}

	public function asignarUsuario($usuario){
		$this->usuario = $usuario;
	}
	public function obtenerUsuario(){
		return $this->usuario;
	}
	public function asignarPass($pass){
		$this->pass = $pass;
	}
	public function obtenerPass(){
		return $this->pass;
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
