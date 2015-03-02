<?php

/**
 * @copyright 2014 - Instituto Universtiario de Tecnología Dr. Federico Rivero Palacio
 * @license GPLv3
 * @license http://www.gnu.org/licenses/gpl-3.0.html
 *
 * LoginControlador.php  Controladores de MVCRIVERO.
 *
 * Este es el controlador del módulo Login, permite manejar las operaciones relacionadas 
 * con los datos del logueo (iniciar , mostrar , cerrar), es el intermediario entre la
 * base de datos y la vista.
 * 
 *  
 * @author JHONNY VIELMA 		(jhonnyvq1@gmail.com)
 * 
 * 
 * @link /modulos/login/modelo/LoginServicio.php 			 Clase LoginControlador
 * 
 * @package Controladores
 */
 



/* Clase que permite la comunicación con la base de datos*/
require_once "modulos/login/modelo/LoginServicio.php";

class LoginControlador {
	  
	 /**
		 * Funcion estatica que permite manejar el requerimiento .
		 *
		 * Permite manjear el requerimiento (o acción) indicado por el usuario según su petición
		 * que envia al controlador mediantes post o get con el name de m_accion.
	     * 		Acciones: 	mostrar-> muestra toda la información de un logueo 
	     * 					Cada acción será redireccionada a un método que la procesa para	mayor orden.
		 *
		 * 
		 */
	public static function manejarRequerimiento(){
		
		$accion = PostGet::obtenerPostGet('m_accion');
		//permite colocar una acción predefinida en caso de no colocarla
		if (!$accion)
			$accion = 'mostrar';
				
		if($accion == 'mostrar'){
			self::mostrarLogin();		
		}elseif($accion == 'iniciar'){
			self::iniciarLogin();	
		}elseif($accion == 'cerrar'){
			self::cerrarLogin();
		}			
		else
			echo "Acci&oacute;n no v&aacute;lida en el m&oacute;dulo Login: $accion";	
	}
	
	
	/**
		 * Funcion estatica que permite extraer un objeto Login .
		 *
		 * Permite extraer en un objeto tipo Login toda la información de un usuario (Usuario, 
		 * apellido,tipo,codigo) de la base de datos . Recibe los datos desde la vista (arreglo PostGet). De ser
		 * satisfactoria la autenticación los datos del usuario se guardarán en la variable de session  a través de
		 * la clase que contiene solo métodos estáticos Sesion ejemplo: Sesion::asignarNombre(nombre del usuario). 
		 * En caso de error se llamará a la función estática mostrarLogin la cual enviará a la pantalla de logueo
		 *
		 * 
		 */
	public static function iniciarLogin(){	
		$usuario      = PostGet::obtenerPostGet('usuario');
		$password     = PostGet::obtenerPostGet('pass');
		$login=null;
		if ($usuario=='usuarioscn'){
			Conexion::iniciar("localhost","bd_scnfinal","5432",$usuario,$password);
			conexion::conectar();
			Vista::asignarDato("mensaje", "Bienvenido Administrador usuarioSCN");
			$permisos=new Permisos();
			$permisos::iniciar();
			$permisos::asignarPermisos();
			$login= new Login('usuarioSCN','Administrador',"A",1,'usuarioscn',$password,null,null,null,null,null);
			Sesion::iniciar($login,$permisos);
			Vista::asignarDato("login",$login);
			Vista::asignarDato("permisos",$permisos);
			Vista::asignarDato("estatus",1);
		}else{
			$login=LoginServicio::obtenerLogin($usuario);
			if ($login!=null){
				Conexion::iniciar("localhost","bd_scnfinal","5432",$usuario,$password);
				conexion::conectar();
				Vista::asignarDato("mensaje", "Bienvenido, ".$login->obtenerNombre()." ".$login->obtenerApellido());
				$permisos=new Permisos();
				$permisos::iniciar();
				$permisos::asignarPermisos();
				$login->asignarPass($password);
				Sesion::iniciar($login,$permisos);
				Vista::asignarDato("login",$login);
				Vista::asignarDato("permisos",$permisos);
				Vista::asignarDato("estatus",1);

			}else
				Vista::asignarDato("mensaje", "Datos no existentes Creese un usuario.");
		}
		Vista::mostrar();

	}
	
	
	/**
		 * Funcion estatica que  permite mostrar la vista .
		 *
		 * Método público que permite mostrar la vista 	mediante la cual se pedirán los datos 
		 * de autenticación de usuario.
		 * 
		 */
	public static function mostrarLogin(){					
		Vista::mostrar();				
	}
	
	
	/**
		 * Método público que permite cerrar una sesion.
		 *
		 * Permite cerrar una sesion; lo hace a través de la clase Sesion ejemplo 
		 * Sesion::cerrarSesion(). Luego de cerrar la sesión redireccionará al index de la aplicación
		 * 
		 */
	public static function cerrarLogin(){
		Sesion::cerrarSesion();
		Vista::asignarDato("mensaje","Sesión cerrada, hasta pronto.");
		Vista::asignarDato("estatus",1);
		Vista::mostrar();
	}
}
?>

