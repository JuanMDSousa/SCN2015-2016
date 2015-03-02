<?php
/*
 * * * * * * * * * * LICENCIA * * * * * * * * * * * * * * * * * * * * *

Copyright(C) 2012
Instituto Universtiario de Tecnología Dr. Federico Rivero Palacio

Este programa es ARCHIVO * * * * * * * * * * * * * * * * * * * * *

Nombre: Trayecto.clase.php
Diseñador: Miguel Terrami
Programador: Miguel Terrami
Fecha: Julio de 2012
Descripción:  
	Este archivo contiene la implementación del objeto Trayecto, el cual
	consta de su constructor y de los atributos siguientes
			$codigo;
			$codPensum;
			$numTrayecto;
			$certificado;
			$minCredito
	
	Se corresponde con la siguiente estructura de la base de datos 
		CREATE TABLE ts_trayecto
			(
				codigo smallint NOT NULL,
				num_trayecto smallint NOT NULL,
				cod_pensum smallint NOT NULL,
				certificado character varying(150),
				min_credito smallint NOT NULL,
			CONSTRAINT cp_trayecto PRIMARY KEY (codigo ),
			CONSTRAINT cf_trayecto__pensum FOREIGN KEY (cod_pensum)
				REFERENCES ts_pensum (codigo) MATCH SIMPLE
               ON UPDATE NO ACTION ON DELETE NO ACTION,
			CONSTRAINT ca_trayecto UNIQUE (num_trayecto , cod_pensum )
			)

 * * * * * * * * Cambios/Mejoras/Correcciones/Revisiones * * * * * * * *
Diseñador - Programador /   Fecha   / Descripción del cambio
---                         ----      ---------

 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/

require_once "UniCurricular.clase.php";

class Trayecto { 
	//atributos de la clase
	public $codigo;      
	public $codPensum;
	public $numTrayecto;
	public $certificado;
	public $minCredito;
	public $unidades;

	public function __construct($codigo=NULL, $codPensum=NULL, 
	$numTrayecto=NULL, $certificado=NULL,$minCredito=NULL,$unidades=NULL)
	{
		$this->asignarCodigo($codigo);
		$this->asignarCodPensum($codPensum);
		$this->asignarNumero($numTrayecto);
		$this->asignarCertificado($certificado);
		$this->asignarMinCredito($minCredito);
		if ($unidades!=null)
		$this->asignarUnidades($unidades);

	}


	//Coloque aquí los métodos y operaciones de la clase
	
	/*Método permite obtener la cantidad de  horas de trabajo acompañado 
	 * por trayecto o año. Retorna un valor entero.*/
	public function obtenerHtaAnio(){
		$Tanio=0;
		for ($i=0; $i<count($this->obtenerUnidades());$i++){
			
			if ($this->obtenerUnidadC($i) != FALSE){
				$Tanio +=  $this->obtenerUnidadC($i)->obtenerTotalHorasHta();
			}
		}
		return $Tanio;
	}
	
	/*Método permite obtener la cantidad de unidades curriculares que posee
	 * el trayecto o año. Retorna un valor entero.*/
	public function obtenerCantidaDeUnidades(){
		
		return count($this->obtenerUnidades());
	}
	
	/*Método permite obtener la cantidad de  horas de trabajo independiente 
	 * por trayecto o año. Retorna un valor entero.*/
	public function obtenerHtiAnio(){
		$Tanio=0;
		for ($i=0; $i<count($this->obtenerUnidades());$i++){	
			if ($this->obtenerUnidadC($i) != FALSE){
				$Tanio +=  $this->obtenerUnidadC($i)->obtenerTotalHorasHti();
			}
		}
		return $Tanio;
	}
	
	/*Método permite obtener la cantidad de  unidades de credito que posee 
	 * el trayecto o año. Retorna un valor entero.*/
	public function obtenerCreditoPorTrayecto(){
		$Tcredito=0;
		for ($i=0; $i<count($this->obtenerUnidades());$i++){			
			if ($this->obtenerUnidadC($i) != FALSE){
				$Tcredito +=  $this->obtenerUnidadC($i)->obtenerUniCredito();
			}
		}
		
		return $Tcredito;
	}
	
	
	public function asignarUnidades($unidades){
		if (!is_array($unidades))
			throw new Exception("Las unidades pasada por parametro en la funcion asignarUnidades() no es un array debe ser array de objetos ");
			foreach ($unidades as $clave => $valor) {
				$this->asignarUnidadC($valor,$clave);
			}
	}
	
	public function obtenerUnidades(){
		return $this->unidades;
	}
	/*Método que permite asignar una unidad curricular en una posición 
	* especifica. unidad curricular y posición ambos pasados por parámetro .*/
	public function asignarUnidadC($unidad ,$posicion){
		if (!is_numeric($posicion))
			throw new Exception("La posicion pasada por parametro en la funcion asignarUnidadC() no es un numero ");
		if ($posicion<0)
			throw new Exception("La posicion pasada por parametro en la funcion asignarUnidadC() es menor a 0 solo se permiten valones mayores a 0");
		if(!is_object($unidad)) 
			throw new Exception("La unidad pasada por parametro en la funcion asignarUnidadC() no es un objeto");
		$this->unidades[$posicion] = $unidad;
	}
	/*Método permite obtener una unidad curricular en especifico, la de 
	* la posición pasada por parámetro. Retorna false si no existe esa 
	* unidad o la unidad curricular si existe.*/
	public function obtenerUnidadC($posicion){
		return is_null($this->unidades[$posicion])? false: $this->unidades[$posicion];
	}
	
	//Asignar y obtener de cada atributo
	public function asignarCodigo($codigo){
		$this->codigo = $codigo;
	}
	public function obtenerCodigo(){
		return $this->codigo;
	}

	public function asignarCodPensum($codPensum){
		$this->codPensum = $codPensum;
	}
	public function obtenerCodPensum(){
		return $this->codPensum;
	}

	public function asignarNumero($numTrayecto){
		$this->numTrayecto = $numTrayecto;
	}
	
	public function obtenerNumero(){
		return $this->numTrayecto;
	}
	
	public function asignarCertificado($certificado){
		$this->certificado = $certificado;
	}
	
	public function obtenerCertificado(){
		return $this->certificado;
	}
	
	public function asignarMinCredito($minCredito){
		$this->minCredito = $minCredito;
	}
	
	public function obtenerMinCredito(){
		return $this->minCredito;
	}

}

?>
