<?php
class Persona { 
	//atributos de la clase
	private $cedula;
	private $codigo;
	private $numEmpleado;
	private $login;
	private $nombre1;
	private $nombre2;
	private $apellido1;
	private $apellido2;
	private $sexo;
	private $rif;
	private $fecNacimiento;
	private $tipSangre;
	private $telefono1;
	private $telefono2;
	private $correoPersonal;
	private $correoInstitucional;
	private $direccion;
	private $codPensum;
	private $codInstituto;
	private $privilegio;


	public function __construct($cedula=NULL, $codigo=NULL, $numEmpleado=NULL, $login=NULL, $nombre1=NULL, $nombre2=NULL, $apellido1=NULL, $apellido2=NULL, $sexo=NULL, $rif=NULL, $fecNacimiento=NULL, $tipSangre=NULL, $telefono1=NULL, $telefono2=NULL, $correoPersonal=NULL, $correoInstitucional=NULL, $direccion=NULL, $codPensum=NULL, $codInstituto=NULL, $privilegio=NULL)
	{
		$this->asignarCedula($cedula);
		$this->asignarCodigo($codigo);
		$this->asignarNumEmpleado($numEmpleado);
		$this->asignarLogin($login);
		$this->asignarNombre1($nombre1);
		$this->asignarNombre2($nombre2);
		$this->asignarApellido1($apellido1);
		$this->asignarApellido2($apellido2);
		$this->asignarSexo($sexo);
		$this->asignarRif($rif);
		$this->asignarFecNacimiento($fecNacimiento);
		$this->asignarTipSangre($tipSangre);
		$this->asignarTelefono1($telefono1);
		$this->asignarTelefono2($telefono2);
		$this->asignarCorreoPersonal($correoPersonal);
		$this->asignarCorreoInstitucional($correoInstitucional);
		$this->asignarDireccion($direccion);
		$this->asignarCodPensum($codPensum);
		$this->asignarCodInstituto($codInstituto);
		$this->asignarPrivilegio($privilegio);

	}


	//Coloque aquí los métodos y operaciones de la clase


	//Asignar y obtener de cada atributo
	public function asignarCedula($cedula){
		$this->cedula = $cedula;
	}
	public function obtenerCedula(){
		return $this->cedula;
	}

	public function asignarCodigo($codigo){
		$this->codigo = $codigo;
	}
	public function obtenerCodigo(){
		return $this->codigo;
	}

	public function asignarNumEmpleado($numEmpleado){
		$this->numEmpleado = $numEmpleado;
	}
	public function obtenerNumEmpleado(){
		return $this->numEmpleado;
	}

	public function asignarLogin($login){
		$this->login = $login;
	}
	public function obtenerLogin(){
		return $this->login;
	}

	public function asignarNombre1($nombre1){
		$this->nombre1 = $nombre1;
	}
	public function obtenerNombre1(){
		return $this->nombre1;
	}

	public function asignarNombre2($nombre2){
		$this->nombre2 = $nombre2;
	}
	public function obtenerNombre2(){
		return $this->nombre2;
	}

	public function asignarApellido1($apellido1){
		$this->apellido1 = $apellido1;
	}
	public function obtenerApellido1(){
		return $this->apellido1;
	}

	public function asignarApellido2($apellido2){
		$this->apellido2 = $apellido2;
	}
	public function obtenerApellido2(){
		return $this->apellido2;
	}

	public function asignarSexo($sexo){
		$this->sexo = $sexo;
	}
	public function obtenerSexo(){
		return $this->sexo;
	}

	public function asignarRif($rif){
		$this->rif = $rif;
	}
	public function obtenerRif(){
		return $this->rif;
	}

	public function asignarFecNacimiento($fecNacimiento){
		$this->fecNacimiento = $fecNacimiento;
	}
	public function obtenerFecNacimiento(){
		return $this->fecNacimiento;
	}

	public function asignarTipSangre($tipSangre){
		$this->tipSangre = $tipSangre;
	}
	public function obtenerTipSangre(){
		return $this->tipSangre;
	}

	public function asignarTelefono1($telefono1){
		$this->telefono1 = $telefono1;
	}
	public function obtenerTelefono1(){
		return $this->telefono1;
	}

	public function asignarTelefono2($telefono2){
		$this->telefono2 = $telefono2;
	}
	public function obtenerTelefono2(){
		return $this->telefono2;
	}

	public function asignarCorreoPersonal($correoPersonal){
		$this->correoPersonal = $correoPersonal;
	}
	public function obtenerCorreoPersonal(){
		return $this->correoPersonal;
	}

	public function asignarCorreoInstitucional($correoInstitucional){
		$this->correoInstitucional = $correoInstitucional;
	}
	public function obtenerCorreoInstitucional(){
		return $this->correoInstitucional;
	}

	public function asignarDireccion($direccion){
		$this->direccion = $direccion;
	}
	public function obtenerDireccion(){
		return $this->direccion;
	}

	public function asignarCodPensum($codPensum){
		$this->codPensum = $codPensum;
	}
	public function obtenerCodPensum(){
		return $this->codPensum;
	}

	public function asignarCodInstituto($codInstituto){
		$this->codInstituto = $codInstituto;
	}
	
	public function obtenerCodInstituto(){
		return $this->codInstituto;
	}
	
	public function asignarPrivilegio($privilegio){
		$this->privilegio = $privilegio;
	}
	
	public function obtenerPrivilegio(){
		return $this->privilegio;
	}

	public function obtenerNombreCompleto( $forma=1){
		if ($forma==1)
			return $this->obtenerNombre1() . " " . $this->obtenerNombre2() . " " . $this->obtenerApellido1() . " " . $this->obtenerApellido2(); 
		elseif ($forma==2)
			return $this->obtenerApellido1() . " " . $this->obtenerApellido2() . ", " . $this->obtenerNombre1() . " " . $this->obtenerNombre2(); 	
	}
}

?>
