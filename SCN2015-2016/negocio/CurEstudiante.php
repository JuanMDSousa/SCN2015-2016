<?php



class CurEstudiante{ 
	//atributos de la clase
	private $codigo;
	private $codEstudiante;
	private $codCurso;
	private $porAsistencia;
	private $nota;
	private $estado;
	private $observaciones;
	
	public function __construct( $codigo=NULL, $codEstudiante=NULL, $codCurso=NULL, $porAsistencia=NULL, $nota=NULL, $estado=NULL, $observaciones=NULL)
	{
	$this->asignarCodigo($codigo);
	$this->asignarCodEstudiante($codEstudiante);
	$this->asignarCodCurso($codCurso);
	$this->asignarPorAsistencia($porAsistencia);
	$this->asignarNota($nota);
	$this->asignarEstado($estado);
	$this->asignarObservaciones($observaciones);
	}
	
	//Asignar y obtener de cada atributo
	
	
	
	
	
	public function asignarCodigo($codigo){
		$this->codigo = $codigo;
	}
	public function obtenerCodigo(){
		return $this->codigo;
	}
	
	
	public function asignarCodEstudiante($codEstudiante){
		$this->codEstudiante = $codEstudiante;
	}
	public function obtenerCodEstudiante(){
		return $this->codEstudiante;
	}
	
	
	
	public function asignarCodCurso($codCurso){
		$this->codCurso = $codCurso;
	}
	public function obtenerCodCurso(){
		return $this->codCurso;
	}
	
	
	public function asignarPorAsistencia($porAsistencia){
		$this->porAsistencia = $porAsistencia;
	}
	public function obtenerPorAsistencia(){
		return $this->porAsistencia;
	}
	
	
	
	public function asignarNota($nota){
		$this->nota= $nota;
	}
	public function obtenerNota(){
		return $this->nota;
	}

	public function asignarEstado($estado){
		$this->estado= $estado;
	}
	public function obtenerEstado(){
		return $this->estado;
	}

	public function asignarObservaciones($observaciones){
		$this->observaciones= $observaciones;
	}
	public function obtenerObservaciones(){
		return $this->observaciones;
	}



}



?>
