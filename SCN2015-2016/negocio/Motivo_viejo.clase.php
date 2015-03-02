<?php

class Motivo { 
	//atributos de la clase
	private $id;
	private $descripcion;
	private $codigo;
	private $calculoHoras;
	private $ctaContable;
	private $nomina;
	private $finesSemana;
	private $domingo;


	public function __construct($id=NULL, $descripcion=NULL, $codigo=NULL, $calculoHoras=NULL, $ctaContable=NULL, $nomina=NULL, $finesSemana=NULL, $domingo=NULL)
	{
		$this->asignarId($id);
		$this->asignarDescripcion($descripcion);
		$this->asignarCodigo($codigo);
		$this->asignarCalculoHoras($calculoHoras);
		$this->asignarCtaContable($ctaContable);
		$this->asignarNomina($nomina);
		$this->asignarFinesSemana($finesSemana);
		$this->asignarDomingo($domingo);

	}


	//Coloque aquí los métodos y operaciones de la clase


	//Asignar y obtener de cada atributo
	public function asignarId($id){
		$this->id = $id;
	}
	public function obtenerId(){
		return $this->id;
	}

	public function asignarDescripcion($descripcion){
		$this->descripcion = $descripcion;
	}
	public function obtenerDescripcion(){
		return $this->descripcion;
	}

	public function asignarCodigo($codigo){
		$this->codigo = $codigo;
	}
	public function obtenerCodigo(){
		return $this->codigo;
	}

	public function asignarCalculoHoras($calculoHoras){
		$this->calculoHoras = $calculoHoras;
	}
	public function obtenerCalculoHoras(){
		return $this->calculoHoras;
	}

	public function asignarCtaContable($ctaContable){
		$this->ctaContable = $ctaContable;
	}
	public function obtenerCtaContable(){
		return $this->ctaContable;
	}

	public function asignarNomina($nomina){
		$this->nomina = $nomina;
	}
	public function obtenerNomina(){
		return $this->nomina;
	}

	public function asignarFinesSemana($finesSemana){
		$this->finesSemana = $finesSemana;
	}
	public function obtenerFinesSemana(){
		return $this->finesSemana;
	}

	public function asignarDomingo($domingo){
		$this->domingo = $domingo;
	}
	public function obtenerDomingo(){
		return $this->domingo;
	}

}

?>