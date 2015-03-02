<?php
 class Docente {

 	private $codigo;
 	public $codDpto;
 	public $numEmpleado;
 	public $codEstado;

 	public function __construct($codigo=NULL,$codDpto=NULL,$numEmpleado=NULL,$codEstado=NULL)
	{
		$this->asignarCodigo($codigo);
		$this->asignarCodDpto($codDpto);
		$this->asignarNumEmpleado($numEmpleado);
		$this->asignarCodEstado($codEstado);
	}

	public function asignarCodigo($codigo){
		$this->codigo = $codigo;
	}
	public function obtenerCodigo(){
		return $this->codigo;
	}

	public function asignarCodDpto ($codDpto)
	{
 		$this->codDpto = $codDpto;
	}
	public function obtenerCodDpto()
	{
		return $this->codDpto;
	}

	public function asignarNumEmpleado($numEmpleado)
	{
		$this->numEmpleado = $numEmpleado;
	}
	public function obtenerNumEmpleado()
	{
		return $this->numEmpleado;
	}

	public function asignarCodEstado($codEstado){
		$this->codEstado = $codEstado;
	}
	public function obtenerCodEstado(){
		return $this->codEstado;
	}


 }
?>
