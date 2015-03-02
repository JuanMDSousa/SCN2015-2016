<?php
class Curso{ 
	//atributos de la clase
	private $codigo;
	private $codPeriodo;
	private $codUniCurricular;
	private $codDocente;
	private $seccion;
	private $fecInicio;
	private $fecFinal;
	private $capacidad;
	private $observaciones;


	public function __construct($codigo=NULL, $codPeriodo=NULL, $codUniCurricular=NULL, $codDocente=NULL, $seccion=NULL, $fecInicio=NULL, $fecFinal=NULL, $capacidad=NULL,$observaciones=NULL)
	{
		$this->asignarCodigo($codigo);
		$this->asignarPeriodo($codPeriodo);
		$this->asignarCodUniCurricular($codUniCurricular);
		$this->asignarCodDocente($codDocente);
		$this->asignarSeccion($seccion);
		$this->asignarFecInicio($fecInicio);
		$this->asignarFecFinal($fecFinal);
		$this->asignarCapacidad($capacidad);
		$this->asignarObservaciones($observaciones);

	}
	public function asignarCapacidad($capacidad){
		$this->capacidad= $capacidad;
	}
	public function obtenerCapacidad(){
		return $this->capacidad;
	}


	//Coloque aquí los métodos y operaciones de la clase


	//Asignar y obtener de cada atributo
	public function asignarCodigo($codigo){
		$this->codigo = $codigo;
	}
	public function obtenerCodigo(){
		return $this->codigo;
	}

	public function asignarPeriodo($codPeriodo){
		$this->codPeriodo = $codPeriodo;
	}
	public function obtenerCodPeriodo(){
		return $this->codPeriodo;
	}

	public function asignarCodUniCurricular($codUniCurricular){
		$this->codUniCurricular = $codUniCurricular;
	}
	public function obtenerCodUniCurricular(){
		return $this->codUniCurricular;
	}

	public function asignarCodDocente($codDocente){
		$this->codDocente = $codDocente;
	}
	public function obtenerCodDocente(){
		return $this->codDocente;
	}

	public function asignarSeccion($seccion){
		$this->seccion = $seccion;
	}
	public function obtenerSeccion(){
		return $this->seccion;
	}

	public function asignarFecInicio($fecInicio){
		$this->fecInicio = $fecInicio;
	}
	public function obtenerFecInicio(){
		return $this->fecInicio;
	}

	public function asignarFecFinal($fecFinal){
		$this->fecFinal = $fecFinal;
	}
	public function obtenerFecFinal(){
		return $this->fecFinal;
	}

	public function asignarObservaciones($observaciones){
		$this->observaciones = $observaciones;
	}
	public function obtenerObservaciones(){
		return $this->observaciones;
	}

}

?>
