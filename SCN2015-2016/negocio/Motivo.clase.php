<?php

class Motivo { 
	//atributos de la clase
	private $id;
	private $descripcion;
	private $atribucionId;
	private $pasaNomina;
	private $finesSemana;
	private $usuarioCreador;
	private $fechaCreacion;
	private $usuarioModificador;
	private $fechaModificacion;


	public function __construct($id=NULL, $descripcion=NULL, $atribucionId=NULL, $pasaNomina=NULL, $finesSemana=NULL, $usuarioCreador=NULL, $fechaCreacion=NULL, $usuarioModificador=NULL, $fechaModificacion=NULL)
	{
		$this->asignarId($id);
		$this->asignarDescripcion($descripcion);
		$this->asignarAtribucionId($atribucionId);
		$this->asignarPasaNomina($pasaNomina);
		$this->asignarFinesSemana($finesSemana);
		$this->asignarUsuarioCreador($usuarioCreador);
		$this->asignarFechaCreacion($fechaCreacion);
		$this->asignarUsuarioModificador($usuarioModificador);
		$this->asignarFechaModificacion($fechaModificacion);

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

	public function asignarAtribucionId($atribucionId){
		$this->atribucionId = $atribucionId;
	}
	public function obtenerAtribucionId(){
		return $this->atribucionId;
	}

	public function asignarPasaNomina($pasaNomina){
		$this->pasaNomina = $pasaNomina;
	}
	public function obtenerPasaNomina(){
		return $this->pasaNomina;
	}

	public function asignarFinesSemana($finesSemana){
		$this->finesSemana = $finesSemana;
	}
	public function obtenerFinesSemana(){
		return $this->finesSemana;
	}

	public function asignarUsuarioCreador($usuarioCreador){
		$this->usuarioCreador = $usuarioCreador;
	}
	public function obtenerUsuarioCreador(){
		return $this->usuarioCreador;
	}

	public function asignarFechaCreacion($fechaCreacion){
		$this->fechaCreacion = $fechaCreacion;
	}
	public function obtenerFechaCreacion(){
		return $this->fechaCreacion;
	}

	public function asignarUsuarioModificador($usuarioModificador){
		$this->usuarioModificador = $usuarioModificador;
	}
	public function obtenerUsuarioModificador(){
		return $this->usuarioModificador;
	}

	public function asignarFechaModificacion($fechaModificacion){
		$this->fechaModificacion = $fechaModificacion;
	}
	public function obtenerFechaModificacion(){
		return $this->fechaModificacion;
	}

}

?>