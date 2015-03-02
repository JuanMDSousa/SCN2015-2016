<?php

/**
 * * * * * * * * * * LICENCIA * * * * * * * * * * * * * * * * * * * * *

Copyright(C) 2012
Instituto Universtiario de Tecnología Dr. Federico Rivero Palacio

Este programa es Software Libre y usted puede redistribuirlo y/o modificarlo
bajo los términos de la versión 3.0 de la Licencia Pública General (GPLv3)
publicada por la Free Software Foundation (FSF), es distribuido sin ninguna
garantía. Usted debe haber recibido una copia de la GPLv3 junto con este
programa, sino, puede encontrarlo en la página web de la FSF, 
específicamente en la dirección http://www.gnu.org/licenses/gpl-3.0.html

 * * * * * * * * * * ARCHIVO * * * * * * * * * * * * * * * * * * * * *

Nombre: PrincipalControlador.clase.php
Diseñador: Johan Alamo (johan.alamo@gmail.com)
Programador: Johan Alamo
Fecha: Julio de 2012
Descripción:  
	Este es el controlador principal del MVC, aquí se obtendrá el módulo a trabajar para luego llamar al controlador correspondiente a ese módulo y que éste continúe con el trabajo obteniendo la acción y los parámetros a manejar. 

Al MVC se le puede enviar la información tanto por POST o por GET, por ello se usar la clase PostGet a través del método obtenerPostGet(indice). 	
ejemplo: PostGet::obtenerPostGet('modulo')

 * * * * * * * * Cambios/Mejoras/Correcciones/Revisiones * * * * * * * *
Johan Alamo  - Geraldine Castillo /  diciembre del 2013  /se modificó la configuración del logueo de los usuarios.
---                         ----      ---------

 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/


/* A continuación se definen las variables globales a utilizar en toda la
   aplicación , éstas serán instanciadas en el constructor de
   PrincipalControlador
*/

//objeto que contendrá el arreglo con la información de $_POST y $GET
//estará disponible como un objeto global a toda la aplicación
require_once 'base/clases/utilitarias/PostGet.clase.php';
require_once 'base/clases/utilitarias/Util.clase.php';
require_once 'modulos/login/modelo/Sesion.php';
require_once "negocio/Login.php";
require_once "modulos/login/modelo/Permisos.php";
//objeto que permitirá efectuar conexiones con la base de datos.
//estará disponible como una clase estatica en toda la aplicacion
require_once 'base/clases/basededatos/Conexion.php';
//require_once 'modulos/login/modelo/Sesion.clase.php';



//Clase que permite mostrar la vista cuando se esté trabajando desde
//un computador
require_once 'base/clases/vista/Vista.php';




class PrincipalControlador {
	
	/*método público que llama a las funciones configurar()  y 	manejarRequerimiento() . Es llamado desde el index de la aplicación e 	inicia el flujo del sistema.
	*/
	public static function iniciar(){	
		self::configurar();
		self::manejarRequerimiento();
	}    

	/*método privado que permite configurar la aplicación. El 	algoritmo de este método es el siguiente:
 
	1. En este método está  incluido  la  verificación de la sesión . Si hay usuario logueado  y el módulo es igual a null colocará como predeterminado el módulo pesum. Cuando no hay una sesión iniciada y hay un usuario en proceso de logueo, procederá con el flujo normal hacia la verificación del usuario ; pero si no hay usuario en proceso de logueo y el módulo es distinto de login redireccionará a la pantalla de autentificación de datos.

	2. Obtiene el módulo, acción, formato y vista mediante el objeto clase estática PostGet a través del método obtenerPostGet(indice) . Ejemplo: PostGet::obtenerPostGet('m_modulo');.

	3. Se hace la conexión a la base de datos (y se guarda en un objeto global para ser utilizado desde cualquier módulo).

	4. Crear e instanciar el  objeto vista al cual se le asignará el formato,que pueden ser: html5, txt, json etc. Asignar scripts y css que se utilizarán en toda la aplicación, asignar la dirección de la vista que mostrará la información y por último asignar el módulo con la letra inicial en mayúscula.
	*/
        
	private static function configurar(){
		Sesion::iniciarSesion();
		//colocar todas las claves de los arreglos $_POST y $_GET en 
		//minúscula
		PostGet::colocarIndicesMinuscula();
		
	//	var_dump(Sesion::obtenerLogin());
	
		if (!Sesion::hayUsuarioLogueado()){
			if (is_null(PostGet::obtenerPostGet('m_modulo'))){
				$_POST['m_modulo'] = 'login';
				$_POST['m_accion'] = 'mostrar';
				$_POST['m_formato'] = 'html5';
				$_POST['m_vista'] = 'Inicio';
			}

		}else{
			Permisos::asignarPermisos();
			//Permisos::asignarPermiso(Conexion::obtenerPermisos(usuario));
			//Sesion::asignarPermisos(Permisos);
			Vista::asignarDato("login",Sesion::obtenerLogin());
			Vista::asignarDato("permisos",Sesion::obtenerPermisos());
		}
	
		if(PostGet::obtenerPostGet('m_modulo')== null){
				 $_POST['m_modulo'] = 'principal';
				 $_POST['m_accion'] = 'inicio';
				 $_POST['m_formato'] = 'html5';
				 $_POST['m_vista'] = 'Inicio';
		}	


		$modulo = PostGet::obtenerPostGet('m_modulo');
		$accion = PostGet::obtenerPostGet('m_accion');
		$formato = PostGet::obtenerPostGet('m_formato');
		$vista = PostGet::obtenerPostGet('m_vista');
		if ((PostGet::obtenerPostGet('m_modulo')=="login")&&(PostGet::obtenerPostGet('m_accion')=="iniciar"))
			Conexion::iniciar("localhost","bd_scnfinal","5432","usuarioscn","123");
		else
			Conexion::iniciar("localhost","bd_scnfinal","5432",Sesion::obtenerUsuario(),Sesion::obtenerPass());

		Vista::iniciar($modulo.":".$formato.":".$vista);
			//Conexion::iniciar("localhost","bd_scnfinal","5432","postgres","12345");
	}

                
	/* Método privado  que permite manejar el 	requerimiento (o acción) indicado por  el usuario según su petición .
	Si el módulo es login, instituto ó pensum  se irá al controlador 	correspondiente llamando a la función 		iniciar y realizará el flujo pertinente 	a la petición del usuario.
	*/
    private static function manejarRequerimiento() {
		//se obtiene el modulo a trabajar del arreglo POST y/o GET
		// y convertirlo a minuscula
		$modulo = strtolower(PostGet::obtenerPostGet('m_modulo'));

		if ($modulo=='instituto'){
			// ****** controlador del módulo Instituto   ******
			require_once 'modulos/instituto/InstitutoControlador.php';
			InstitutoControlador::manejarRequerimiento();
		}elseif ($modulo == 'unidad'){
		require_once 'modulos/unidad/UnidadCurricularControlador.php';
			UnidadControlador::manejarRequerimiento();
		}elseif ($modulo == 'trayecto'){
		require_once 'modulos/trayecto/TrayectoControlador.php';
			TrayectoControlador::manejarRequerimiento();
		}elseif ($modulo == 'periodo'){
		    require_once 'modulos/periodo/PeriodoControlador.php';
		    PeriodoControlador::manejarRequerimiento();
		}elseif ($modulo == 'principal'){
		    PrincipalControlador::inicio();
		}elseif ($modulo == 'curso'){
		    require_once 'modulos/curso/CursoControlador.php';
		    CursoControlador::manejarRequerimiento();
		}elseif ($modulo == 'pensum'){
		    require_once 'modulos/pensum/PensumControlador.php';
		    PensumControlador::manejarRequerimiento();
		}elseif($modulo == 'departamento'){
			require_once 'modulos/departamento/DepartamentoControlador.php';
			DepartamentoControlador::manejarRequerimiento();
		}elseif($modulo == 'persona'){
			require_once 'modulos/persona/PersonaControlador.php';
			PersonaControlador::manejarRequerimiento();
		}elseif($modulo == 'estudiante'){
			require_once 'modulos/estudiante/EstudianteControlador.php';
			EstudianteControlador::manejarRequerimiento();
		}elseif($modulo == 'docente'){
			require_once 'modulos/docente/DocenteControlador.php';
			DocenteControlador::manejarRequerimiento();
		}elseif($modulo == 'login'){
			require_once 'modulos/login/LoginControlador.php';
			LoginControlador::manejarRequerimiento();
		}else
			echo "(PrincipalControlador) Módulo inválido: $modulo<br>";
    }

	/*Método privado que permite manejar las acciones del 	MVC generales.

 	*'phpinfo': ver la información de configuración de php .
	*'crearclase': permite crear un archivo con el código fuente de una clase. 
	ejemplos: 
		url: index.php?modulo=principal&accion=phpinfo 
		url:index.phpmodulo=principal&accion=crearclase&nombreclase= 						      	Fraccion&atributos=numerador,denominador  	 
	*/
	private static function manejarAccion(){
		$accion = PostGet::obtenerPostGet('m_accion');
			
		if ($accion=='phpinfo')
			phpinfo();
		elseif ($accion=='crearclase')
			Util::crearClase(PostGet::obtenerPostGet('nombreclase'),  PostGet::obtenerPostGet('atributos'));
		elseif($accion=='documentacion') {
			global $gbVista;
			$gbVista->mostrar();	
		}elseif($accion=='documentacionmarcotrabajo') {
			header("location:base/documentacion/MarcoTrabajo.html");;
		}else  //Da el mensaje de acción inválida para orientar al programador
			echo "Acción inválida en el módulo principal: $accion<br>";
	}

	public static function inicio(){
		Vista::mostrar();
	}	
}

?>
