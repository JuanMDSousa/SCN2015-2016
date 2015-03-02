<?php
/**
 * @copyright 2014 - Instituto Universtiario de Tecnología Dr. Federico Rivero Palacio
 * @license GPLv3
 * @license http://www.gnu.org/licenses/gpl-3.0.html
 *
 * Sesion.php - Componente de MVCRIVERO.
 *
 * Esta clase permite encapsular y simplificar el manejo de los datos de
 * las sesiones en PHP. En el sistema se manejan cuatro datos básicos por 
 * la sesión que son:  nombre, apellido, tipo y  código del usuario. La 
 * clase permite manejar estos datos como si se tratara de un objeto, y 
 * además encapsula las instrucciones para iniciar y cerrar sesión. Los 
 * atributos de esta clase son posiciones en el arreglo $_SESSIO
 * 
 *  
 * @author GERALDINE CASTILLO	(geralcs94@gmail.com)
 * @author JHONNY VIELMA 		(jhonnyvq1@gmail.com)
 * @author JOHAN ALAMO 			(johan.alamo@gmail.com)
 * 
 * @package Componentes
 */


class Sesion{
	/**
		 * Funcion estatica que permite iniciar la sesion .
		 *
		 * Permite iniciar la sesion con el login y los permisos para que se puedan utilizar 
		 * posteriormente y obtenerlo.
		 *
		 * @param object   $login				Objetro login para guardar en la variable de sesion.
		 * @param object   $permisos			Objetro Permisos para guardar en la variable de sesion.
		 * 
		 * @throws Exception 					Exception cuando el parametro no es login.
		 */
	public static function iniciar($login,$permisos=null){
		try{	
			if ((is_object($login)) && (get_class($login)=='Login')){
			
			Sesion::asignarNombre($login->obtenerNombre());
			Sesion::asignarApellido($login->obtenerApellido());
			Sesion::asignarTipoUsuario($login->obtenerTipo());
			Sesion::asignarCodigo($login->obtenerCodigo());
			Sesion::asignarUsuario($login->obtenerUsuario());
			Sesion::asignarPass($login->obtenerPass());
			Sesion::asignarNombreInstituto($login->obtenerNombreInstituto());
			Sesion::asignarNombreDepartamento($login->obtenerNombreDepartamento());
			Sesion::asignarCodigoInstituto($login->obtenerCodigoInstituto());
			Sesion::asignarCodigoDepartamento($login->obtenerCodigoDepartamento());
			Sesion::asignarCodigoPensum($login->obtenerCodigoPensum());
			}else
				throw new exception("El primer parametro de la funcion debe ser un objeto tipo Login");
			if ($permisos != null)
				Sesion::asignarPermisos($permisos);
		}catch (Exception $e){
			throw $e;
		}	
		
	}
	/**
		 * Funcion estatica que permite iniciar sesion .
		 *
		 * Permite iniciar la variable $_SESION de php.
		 * 
		 * @throws Exception 					Exception cuando el parametro no es login.
		 */
	
	public static function iniciarSesion(){
		session_start();
	}
	
	/**
		 * Funcion estatica que permite cerrar la sesion .
		 *
		 * Permite cerrar la sesion cuando ya esta activada, destruyendo $_SESION de php.
		 * 
		 */
	 
	public static function cerrarSesion(){
		unset($_SESSION);
		session_destroy();
			
	}
	
		/**
		 * Funcion estatica que permite saber si hay usuario logueado .
		 *
		 * Permite saber si hay un usuario logueado en el sistema.
		 * 
		 * @return boolean		True en caso de haber usuario logueado y false en caso de no estar loguado.
		 * 
		 */
	 
	public static function hayUsuarioLogueado(){
		return isset ($_SESSION['codigo']);
	}
	 
	 /**
		 * Funcion estatica que permite asignar tipo de usuario .
		 *
		 * Permite asigarle el tipo de usuario al arreglo $_SESSION .
		 * 
		 * @param string $tipoUsuario 	Tipo de usuario
		 * 
		 *@throws Exception 			Exception cuando el tipo de usuario no existe.
		 */
		 
	public static function asignarTipoUsuario($tipoUsuario){
		$tipoUsuario=strtoupper($tipoUsuario);
		if (($tipoUsuario!='D' ) && ($tipoUsuario!='E' ) && ($tipoUsuario!='A') && ($tipoUsuario!='JC' ) && ($tipoUsuario!='JD')&& ($tipoUsuario!='M'))
			throw new Exception ("Tipo de usuario inválido debe ser D para docente, E para estudiante, A para administrador, JC para jefe control de estudios y JD para jefe de departamento");
		$_SESSION['tipoU']=$tipoUsuario;
	}
	
	
	/**
		 * Funcion estatica que permite obtener el tipo de usuario.
		 *
		 * Permite obtener el tipo de usuario de la persona del $_SESSION .
		 * 
		 *  @return string|falce			Tipo de usuario de la persona si hay usuario o false de no haber.
		 */
	public static function obtenerTipoUsuario(){
		if (Sesion::hayUsuarioLogueado())
			return $_SESSION['tipoU'];
		else 
			return Sesion::hayUsuarioLogueado();
	}
	
	/**
		 * Funcion estatica que permite asignar el codigo .
		 *
		 * Permite asigarle el codigo del usuario al arreglo $_SESSION .
		 * 
		 * @param int $codigo 		Codigo del usuario
		 * 
		 *@throws Exception 		Exception cuando el codigo es vacio o null.
		 */
	
	public static function asignarCodigo($codigo){
		if (($codigo==null) || ($codigo ==""))
			throw new Exception ("El código de usuario no puede estar vacio o null");
		$_SESSION['codigo']=$codigo;
	}
	/**
		 * Funcion estatica que permite asignar el usuario .
		 *
		 * Permite asigarle el usuario al arreglo $_SESSION .
		 * 
		 * @param string $usuario	Nombre del usuario
		 * 
		 *@throws Exception 		Exception cuando el usuario es vacio o null.
		 */

	public static function asignarUsuario($usuario){
		if (($usuario==null) || ($usuario ==""))
			throw new Exception ("El usuario no puede estar vacio o null");
		$_SESSION['usuario']=$usuario;
	}
		/**
		 * Funcion estatica que permite asignar el password.
		 *
		 * Permite asigarle el password del usuario al arreglo $_SESSION .
		 * 
		 * @param string $pass		Contraseña del usuario
		 * 
		 *@throws Exception 		Exception cuando la password es vacio o null.
		 */
	public static function asignarPass($pass){
		if (($pass==null) || ($pass ==""))
			throw new Exception ("La password no puede estar vacio o null");
		$_SESSION['pass']=$pass;
	}
	

	 /**
		 * Funcion estatica que permite obtener el codigo.
		 *
		 * Permite obtener el codigo del usuario del $_SESSION .
		 * 
		 *  @return int|falce			codigo del usuario si hay usuario o false de no haber.
		 */
	public static function obtenerCodigo(){
		if (Sesion::hayUsuarioLogueado())
			return $_SESSION['codigo'];
		else 
			return Sesion::hayUsuarioLogueado();
	}
	/**
		 * Funcion estatica que permite obtener el usuario.
		 *
		 * Permite obtener el usuario, de la persona del $_SESSION .
		 * 
		 *  @return string|falce			usuario de la persona si hay usuario o false de no haber.
		 */

	public static function obtenerUsuario(){
		if (Sesion::hayUsuarioLogueado())
			return $_SESSION['usuario'];
		else 
			return Sesion::hayUsuarioLogueado();
	}
	/**
		 * Funcion estatica que permite obtener las password.
		 *
		 * Permite obtener la password del usuario del $_SESSION .
		 * 
		 *  @return string|falce			Password del usuario si hay usuario o false de no haber.
		 */

	public static function obtenerPass(){
		if (Sesion::hayUsuarioLogueado())
			return $_SESSION['pass'];
		else 
			return Sesion::hayUsuarioLogueado();
	}
	
	/**
		 * Funcion estatica que permite asignar el apellido.
		 *
		 * Permite asigarle el apellido del usuario al arreglo $_SESSION .
		 * 
		 * @param string $apellido		Apellido del usuario
		 * 
		 *@throws Exception 		Exception cuando el apellido es vacio o null.
		 */
	 
	public static function asignarApellido($apellido){
		if (($apellido==null) || ($apellido ==""))
			throw new Exception ("El apellido del usuario no puede estar vacio o null");
			$_SESSION['apellido']=$apellido;
	}
	public static function asignarNombreInstituto($nomInstituto){
			$_SESSION['nomInstituto']=$nomInstituto;
	}
	public static function asignarCodigoInstituto($codInstituto){
			$_SESSION['codInstituto']=$codInstituto;
	}
	public static function asignarNombreDepartamento($nomDepartamento){
			$_SESSION['nomDepartamento']=$nomDepartamento;
	}
	public static function asignarCodigoDepartamento($codDepartamento){
			$_SESSION['codDepartamento']=$codDepartamento;
	}
	public static function asignarCodigoPensum($codPensum){
			$_SESSION['codPensum']=$codPensum;
	}

	public static function obtenerNombreInstituto(){
		if (Sesion::hayUsuarioLogueado())
			return $_SESSION['nomInstituto'];
		else 
			return Sesion::hayUsuarioLogueado();
	}

	public static function obtenerCodigoInstituto(){
		if (Sesion::hayUsuarioLogueado())
			return $_SESSION['codInstituto'];
		else 
			return Sesion::hayUsuarioLogueado();
	}

	public static function obtenerNombreDepartamento(){
		if (Sesion::hayUsuarioLogueado())
			return $_SESSION['nomDepartamento'];
		else 
			return Sesion::hayUsuarioLogueado();
	}

	public static function obtenerCodigoDepartamento(){
		if (Sesion::hayUsuarioLogueado())
			return $_SESSION['codDepartamento'];
		else 
			return Sesion::hayUsuarioLogueado();
	}
	public static function obtenerCodigoPensum(){
		if (Sesion::hayUsuarioLogueado())
			return $_SESSION['codPensum'];
		else 
			return Sesion::hayUsuarioLogueado();
	}



		/**
		 * Funcion estatica que permite asignar los permisos.
		 *
		 * Permite asigarle los permisos  del usuario al arreglo $_SESSION .
		 * 
		 * @param object $permisos		Permisos del usuario
		 * 
		 * @throws Exception 		Exception cuando el permiso no es un objeto permiso.
		 */
	public static function asignarPermisos($permisos){
		if ((is_object($permisos)) && (get_class($permisos)=='Permisos'))
			$_SESSION['permisos']=$permisos;
		else 
			throw new Exception ("El parametro permisos no posee el formato adecuado,lea manual del programador");
	}
	/**
		 * Funcion estatica que permite obtener el apellido.
		 *
		 * Permite obtener el apellido del usuario del $_SESSION .
		 * 
		 *  @return string|falce			Apellido del usuario si hay usuario o false de no haber.
		 */
	
	public static function obtenerApellido(){
		if (Sesion::hayUsuarioLogueado())
			return $_SESSION['apellido'];
		else 
			return Sesion::hayUsuarioLogueado();
	}
	/**
		 * Funcion estatica que permite obtener los permisos.
		 *
		 * Permite obtener los permisos del usuario del $_SESSION .
		 * 
		 *  @return object|falce			Permisos del usuario si hay usuario o false de no haber.
		 */

	public static function obtenerPermisos(){
		if (Sesion::hayUsuarioLogueado())
			return $_SESSION['permisos'];
		else 
			return Sesion::hayUsuarioLogueado();
	}
	/**
		 * Funcion estatica que permite el objeto  login.
		 *
		 * Permite obtener el objeto login del usuario del $_SESSION .
		 * 
		 *  @return object|falce			Objeto del usuario si hay usuario o false de no haber.
		 */


	public static function obtenerLogin(){
		if (Sesion::hayUsuarioLogueado()){
			$login= new Login(Sesion::obtenerNombre(),Sesion::obtenerApellido(),Sesion::obtenerTipoUsuario(),Sesion::obtenerCodigo(),
				              Sesion::obtenerUsuario(),Sesion::obtenerPass(),Sesion::obtenerNombreInstituto(),Sesion::obtenerCodigoInstituto(),
				              Sesion::obtenerNombreDepartamento(),Sesion::obtenerCodigoDepartamento(),Sesion::obtenerCodigoPensum());
			return $login;
		}
		else 
			return Sesion::hayUsuarioLogueado();
	}
	
	/**
		 * Funcion estatica que permite asignar el nombre.
		 *
		 * Permite asigarle nombre del usuario al arreglo $_SESSION .
		 * 
		 * @param string $nombre		Nombre del usuario
		 * 
		 *@throws Exception 		Exception cuando el nombre es vacio o null.
		 */
	
	public static function asignarNombre($nombre){
		if (($nombre==null) || ($nombre==""))
			throw new Exception ("El nombre del usuario no puede estar vacio");
		$_SESSION['nombre']=$nombre;
	}
	

	/**
		 * Funcion estatica que permite obtener el nombre.
		 *
		 * Permite obtener el nombre del usuario del $_SESSION .
		 * 
		 *  @return string|falce			Nombre del usuario si hay usuario o false de no haber.
		 */
	public static function obtenerNombre(){
		if (Sesion::hayUsuarioLogueado())
			return $_SESSION['nombre'];
		else 
			return Sesion::hayUsuarioLogueado();
	}
}

?>
	
