<?

class Motivo {
	private $id;
	private $descripcion;
	
	function __construct ($id=null, $desc=null){
		$this->asignarId($id);
		$this->asignarDescripcion($desc);
	}
	
	public function asignarId($id){
		$this->id = $id;
	}
	public function obtenerId(){
		return $this->id;
	}
	
	public function asignarDescripcion($desc){
		$this->descripcion = $desc;
	}
	public function obtenerDescripcion(){
		return $this->descripcion;
	}
	
}
