<?php

class Estudiante { 
	//atributos de la clase
	private $codigo;
	private $codInstituto;
	private $codDpto;
	private $codPensum;
	private $numCarnet;
	private $numExp;
	private $codRusnies;
	private $codEstado;


	public function __construct($codigo=NULL, $codInstituto=NULL, $codPensum=NULL, $numCarnet=NULL, $numExp=NULL, $codRusnies=NULL, $codEstado=NULL, $codDpto=NULL)
	{
		$this->asignarCodigo($codigo);
		$this->asignarCodInstituto($codInstituto);
		$this->asignarCodPensum($codPensum);
		$this->asignarNumCarnet($numCarnet);
		$this->asignarNumExp($numExp);
		$this->asignarCodRusnies($codRusnies);
		$this->asignarCodEstado($codEstado);
		$this->asignarCodDpto($codDpto);

	}


	//Coloque aquí los métodos y operaciones de la clase
	public function asignarCodDpto ($codDpto)
	{
 		$this->codDpto = $codDpto;
	}
	public function obtenerCodDpto ()
	{
		return $this->codDpto;
	}
	//Asignar y obtener de cada atributo
	public function asignarCodigo($codigo){
		$this->codigo = $codigo;
	}
	public function obtenerCodigo(){
		return $this->codigo;
	}

	public function asignarCodInstituto($codInstituto){
		$this->codInstituto = $codInstituto;
	}
	public function obtenerCodInstituto(){
		return $this->codInstituto;
	}

	public function asignarCodPensum($codPensum){
		$this->codPensum = $codPensum;
	}
	public function obtenerCodPensum(){
		return $this->codPensum;
	}

	public function asignarNumCarnet($numCarnet){
		$this->numCarnet = $numCarnet;
	}
	public function obtenerNumCarnet(){
		return $this->numCarnet;
	}

	public function asignarNumExp($numExp){
		$this->numExp = $numExp;
	}
	public function obtenerNumExp(){
		return $this->numExp;
	}

	public function asignarCodRusnies($codRusnies){
		$this->codRusnies = $codRusnies;
	}
	public function obtenerCodRusnies(){
		return $this->codRusnies;
	}

	public function asignarCodEstado($codEstado){
		$this->codEstado = $codEstado;
	}
	public function obtenerCodEstado(){
		return $this->codEstado;
	}

}

?>