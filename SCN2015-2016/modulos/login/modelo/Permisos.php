<?php
/**
 * @copyright 2014 - Instituto Universtiario de Tecnología Dr. Federico Rivero Palacio
 * @license GPLv3
 * @license http://www.gnu.org/licenses/gpl-3.0.html
 *
 * Permisos.php - Componente de MVCRIVERO.
 *
 * Clase que permite almacenar en un objeto todos los permisos que posee un usuario
 * en el sistema y dividirlos por modulos ya que como todo esta desarrollado por modulos.
 * Esta clase facilita todo lo referenciado a permisos ya que es capaz de tranformar los
 * permisos en javascrip, o twig al momento de necesitos todos estos permisos en algunos 
 * de esos ambientes. Ademas facilita el manejo de permiso al programador ya que se puede
 * utilizar de una manera muy intuitiva y muy segura ya que dichos permisos se cargaran 
 * de base de datos ya que los usuarios que se utilizaran seran usuarios de base de datos,
 * obtendremos sus permisos de usuario mediante los catalogos.
 * 
 *  
 * @author JHONNY VIELMA (jhonnyvq1@gmail.com)
 * 
 * @package Componentes
 */
 
	class Permisos{

		private static $permisos;
		
		
		/**
		 * Funcion estatica que permite iniciar los permisos.
		 *
		 * Esta funcion inicia los permisos para su pronta utilización ya que al iniciarlos 
		 * se podran utilizar las funciones de esta clase.
		 *
		 */
		static function iniciar(){
			self::$permisos=array();
		}


		/**
		 * Funcion estatica que agregar un modulo a los permisos.
		 *
		 * Permite crear un modulo a los permisos y luego de crearlo revoca todos los permisos 
		 * en el modulo es decir el usuario no tendra permiso de insert,delete,update y select
		 * en el sistema, esto por parte de seguridad.
		 *
		 * @param strig    $modulo				Modulo que se agregara a los permisos.
		 * 
		 * @throws Exception 					Exception de error al crear el modulo.
		 */
		static function agregarModulo($modulo){
			try{
				if (!(self::existeModulo($modulo))){
					self::$permisos[$modulo]['existe']=true;
					self::revocarPermisos($modulo,"Delete");
					self::revocarPermisos($modulo,"Insert");
					self::revocarPermisos($modulo,"Update");
					self::revocarPermisos($modulo,"Select");
				}else
					throw new Exception("Ya existe el modulo: ".$modulo." en los permisos");

			}catch (Exception $e){
				throw $e;
			}
		}
		/**
		 * Funcion estatica que permite otorgar un permiso en un modulo.
		 *
		 * Permite otorgar un permiso al modulo pasado por parametro es decir 
		 * el usuario tendra el permiso en el modulo que se pasen por parametro.
		 *
		 * @param strig    $modulo				Modulo al cual se otrogara permiso.
		 * @param strig    $permiso				Permiso que se otorgara en este modulo ejemplo (insert,update,select,delete)
		 * 
		 * @throws Exception 					Mensaje de permiso desconocido.
		 */
		static function otorgarPermiso($modulo,$permiso){
			try{
				$per=strtolower($permiso);

				if (($per=='insert')||($per=="i"))
					self::otorgarPermisos($modulo,"Insert");
				else if (($per=='delete')||($per=="d"))
					self::otorgarPermisos($modulo,"Delete");
				else if (($per=='update')||($per=="u"))
					self::otorgarPermisos($modulo,"Update");
				else if (($per=='select')||($per=="s"))
					self::otorgarPermisos($modulo,"Select");
				else
					throw new Exception("Permiso: ".$permiso." desconocido lea la documentacion del metodo.");

			}catch (Exception $e){
				throw $e;
			}
		}
		/**
		 * Funcion estatica que permite revocar un permiso en un modulo.
		 *
		 * Permite revocar un permiso al modulo pasado por parametro es decir 
		 * el usuario no tendra ese permiso en el modulo que se pasen por parametro.
		 *
		 * @param strig    $modulo				Modulo al cual se revocara el permiso.
		 * @param strig    $permiso				Permiso que se revocara en este modulo ejemplo (insert,update,select,delete)
		 * 
		 * @throws Exception 					Mensaje de permiso desconocido.
		 */
		static function revocarPermiso($modulo,$permiso){
			try{
				$per=strtolower($permiso);

				if (($per=='insert')||($per=="i"))
					self::revocarPermisos($modulo,"Insert");
				else if (($per=='delete')||($per=="d"))
					self::revocarPermisos($modulo,"Delete");
				else if (($per=='update')||($per=="u"))
					self::revocarPermisos($modulo,"Update");
				else if (($per=='select')||($per=="s"))
					self::revocarPermisos($modulo,"Select");
				else
					throw new Exception("Permiso: ".$permiso." desconocido lea la documentacion del metodo.");

			}catch (Exception $e){
				throw $e;
			}
		}
		/**
		 * Funcion privada que permite saber si existe un modulo.
		 * .
		 *
		 * Permite saber si el modulo pasado por parametro esta entre la lista de los modulos de 
		 * los permisos..
		 *
		 * @param strig    $modulo				Modulo a buscar.
		 * 
		 */
		private static function existeModulo($modulo){
			 return isset(self::$permisos[$modulo])? true: false;
		}

		
		/**
		 * Funcion privada que permite otorgarle permisos
		 *
		 * Permite otorgarle permiso a un usuario en una accion correspondiente a un modulo
		 * al pásado por parametro ejemplo (insert,update,select,delete).
		 *
		 * @param strig    $modulo				Modulo a otorgar el permiso.
		 * @param strig    $permiso				permiso a otorgar(insert,update,select,delete).
		 * 
		 * @throws Exception 					Mensaje no se pudo otorgar el permiso.
		 * 
		 */
		private static function otorgarPermisos($modulo,$permiso){
			try{
				if (self::existeModulo($modulo))
					self::$permisos[$modulo][$permiso]=1;
				else 
					throw new Exception("No se puede otorgar permiso de ".$permiso." al modulo ya que no existe el modulo: ".$modulo);
			}catch (Exception $e){
				throw $e;
			}

		}

		/**
		 * Funcion privada que permite revocar permisos
		 *
		 * Permite revocar permiso a un usuario en una accion correspondiente a un modulo
		 * al pásado por parametro ejemplo (insert,update,select,delete).
		 *
		 * @param strig    $modulo				Modulo a revocar el permiso.
		 * @param strig    $permiso				permiso a revocar(insert,update,select,delete
		 * 
		 * @throws Exception 					Mensaje de no se pudo revocar los permisos.
		 * 
		 */
		private static function revocarPermisos($modulo,$permiso){
			try{
				if (self::existeModulo($modulo))
					self::$permisos[$modulo][$permiso]=0;
				else 
					throw new Exception("No se puede revocar permiso de ".$permiso ."al modulo ya que no existe el modulo: ".$modulo);
			}catch (Exception $e){
				throw $e;
			}

		}

		/**
		 * Funcion privada que permite verificar un permiso
		 *
		 * Permite verificar un permiso en un modulo si el usuario lo posee retorna true 
		 * si no retorna un 0 que se puede conparar con false.
		 *
		 * @param strig    $modulo				Modulo a donde se verificara el permiso.
		 * @param strig    $permiso				permiso a verificar(insert,update,select,delete).
		 * 
		 * @throws Exception 					Mensaje de no se pudo obtener el permiso.
		 * 
		 * @return boolean						True en caso de tener permiso y false en caso de que no tenga permiso.                      .
		 * 
		 */
		private static function verificarPermiso($modulo,$permiso){
			try{
				if (self::existeModulo($modulo))
					return (self::$permisos[$modulo][$permiso]==1)? true: 0;
				else 
					throw new Exception("No se puede obtener el permiso ya que el modulo no existe: ".$modulo);
			}catch (Exception $e){
				throw $e;
			}

		}
		/**
		 * Funcion publica que permite obtener permisos
		 *
		 * Permite obtener todos los permisos que se posee el usuario en un modulo
		 * en particular.
		 *
		 * @param strig    $modulo				Modulo al cual se obtendran los permisos.
		 * 
		 * @throws Exception 					Mensaje de no se pudo obtener los permisos.
		 * 
		 * @return array						arreglo asociativo con los diferentes tipos de permiso y el permiso.                      .
		 * 
		 */
		static function obtenerPermisos($modulo){
			try{
				if (self::existeModulo($modulo)){
					$permiso["Insert"]=self::obtenerPermiso($modulo,"i");
					$permiso["Delete"]=self::obtenerPermiso($modulo,"d");
					$permiso["Update"]=self::obtenerPermiso($modulo,"u");
					$permiso["Select"]=self::obtenerPermiso($modulo,"s");
					return $permiso;
				}else 
					throw new Exception("No se puede obtener el permiso ya que el modulo no existe: ".$modulo);
			}catch (Exception $e){
				throw $e;
			}

		}
		/**
		 * Funcion publica que permite obtener un permiso
		 *
		 * Permite tener un permiso en un modulo en particular y un permiso en especial.
		 *
		 * @param strig   $modulo				Modulo al cual se obtendran los permisos.
		 * @param strig   $permiso				Tipo de permiso que se quiere obtener (isert,delete,selet,update)
		 * 
		 * @throws Exception 					Mensaje de permiso desconocido.
		 * 
		 * @return boolean						true si tiee permiso y false si no los posee.                      .
		 * 
		 */
		static function obtenerPermiso($modulo,$permiso){
			try{
				$per=strtolower($permiso);

				if (($per=='insert')||($per=="i"))
					return self::verificarPermiso($modulo,"Insert");
				else if (($per=='delete')||($per=="d"))
					return self::verificarPermiso($modulo,"Delete");
				else if (($per=='update')||($per=="u"))
					return self::verificarPermiso($modulo,"Update");
				else if (($per=='select')||($per=="s"))
					return self::verificarPermiso($modulo,"Select");
				else
					throw new Exception("Permiso: ".$permiso." desconocido lea la documentacion del metodo.");

			}catch (Exception $e){
					throw $e;
			}
		}
		/**
		 * Funcion publica que permite obtener un modulo en javascrip
		 *
		 * Permite tranformar un modulo en un objeto modulo en javascript para tener lso permisos en 
		 * javascript al momento de necesitarlo
		 *
		 * @param strig   $modulo				Modulo el cual se tranformara a javascript
		 * 
		 * @throws Exception 					exceptiones capturadas.
		 * 
		 * @return string						Cadena del modulo tranformado.                      .
		 * 
		 */
		static function obtenerModuloJavaScript($modulo){
			try{
				$cad="";
				$cad.="function ".$modulo."(){";
				$cad.="this.insert =".self::obtenerPermiso($modulo,"i").";";
				$cad.="this.update =".self::obtenerPermiso($modulo,"u").";";
				$cad.="this.select =".self::obtenerPermiso($modulo,"s").";";
				$cad.="this.delete =".self::obtenerPermiso($modulo,"d")."; }";	
				return $cad;
			}catch (Exception $e){
					throw $e;
			}
		}
		/**
		 * Funcion publica que permite obtener los modulos
		 *
		 * Permite obtener todos los modulos que tienen el objeto permiso cargado
		 *
		 * 
		 * 
		 * @return array			Arreglo con todos los modulos.                      .
		 * 
		 */
		static  function obtenerModulos(){
			return array_keys(self::$permisos);
		}
		/**
		 * Funcion publica que permite obtener permisos en javascript
		 *
		 * Permite obtener todos los permisos de un usuario en javascript
		 * para su utilizacion en dicho lenguaje de una manera facil y practica
		 * para tener los permisos del lado del cliente.
		 *
		 * 
		 * @return string			Cadena con objeto javascrip armado.                      .
		 * 
		 */
		static function obtenerEnJavaScript(){
			try{
				$modulos=self::obtenerModulos();
				$cad="";
				$cad.="function Per(){";
				for ($i=0;$i<count($modulos);$i++){
					$cad.="this.".$modulos[$i]." = new ".self::obtenerModuloJavaScript($modulos[$i]).";";
				}
				$cad.="}";	
				return $cad;
			}catch (Exception $e){
					throw $e;
			}
		}
		/**
		 * Funcion publica que permite otorgar permisos de administrador
		 *
		 *	Permite otorgarle permisos de administrador al usuario que se encuetre logueado
		 * 	esta funcion le otrorga permisos en todos los modulos
		 *                      .
		 * @throws Exception 			Exceptiones capturadas.
		 */
		static function asignarPermisos(){
			try{
				if (Sesion::obtenerTipoUsuario()=='A'){
					Permisos::agregarModulo('persona');
					Permisos::agregarModulo('docente');
					Permisos::agregarModulo('estudiante');
					Permisos::agregarModulo('usuario');
					Permisos::agregarModulo('curso');
					Permisos::agregarModulo('instituto');
					Permisos::agregarModulo('pensum');
					Permisos::agregarModulo('estudianteCurso');
					Permisos::otorgarPermiso('instituto',"I");
					Permisos::otorgarPermiso('instituto',"u");
					Permisos::otorgarPermiso('instituto',"d");
					Permisos::otorgarPermiso('instituto',"s");
					Permisos::otorgarPermiso('persona',"I");
					Permisos::otorgarPermiso('persona',"u");
					Permisos::otorgarPermiso('persona',"d");
					Permisos::otorgarPermiso('persona',"s");
					Permisos::otorgarPermiso('docente',"I");
					Permisos::otorgarPermiso('docente',"u");
					Permisos::otorgarPermiso('docente',"d");
					Permisos::otorgarPermiso('docente',"s");
					Permisos::otorgarPermiso('estudiante',"I");
					Permisos::otorgarPermiso('estudiante',"u");
					Permisos::otorgarPermiso('estudiante',"d");
					Permisos::otorgarPermiso('estudiante',"s");
					Permisos::otorgarPermiso('usuario',"I");
					Permisos::otorgarPermiso('usuario',"u");
					Permisos::otorgarPermiso('usuario',"d");
					Permisos::otorgarPermiso('usuario',"s");
					Permisos::otorgarPermiso('curso',"I");
					Permisos::otorgarPermiso('curso',"u");
					Permisos::otorgarPermiso('curso',"d");
					Permisos::otorgarPermiso('curso',"s");
					Permisos::otorgarPermiso('estudianteCurso',"I");
					Permisos::otorgarPermiso('estudianteCurso',"u");
					Permisos::otorgarPermiso('estudianteCurso',"d");
					Permisos::otorgarPermiso('estudianteCurso',"s");
					Permisos::otorgarPermiso('pensum',"I");
					Permisos::otorgarPermiso('pensum',"u");
					Permisos::otorgarPermiso('pensum',"d");
					Permisos::otorgarPermiso('pensum',"s");
				}else 
					if (Sesion::obtenerTipoUsuario()=='E'){

						Permisos::agregarModulo('persona');
						Permisos::agregarModulo('docente');
						Permisos::agregarModulo('estudiante');
						Permisos::agregarModulo('usuario');
						Permisos::agregarModulo('curso');
						Permisos::agregarModulo('instituto');
						Permisos::agregarModulo('pensum');
						Permisos::agregarModulo('estudianteCurso');
						Permisos::revocarPermiso('instituto',"I");
						Permisos::revocarPermiso('instituto',"u");
						Permisos::revocarPermiso('instituto',"d");
						Permisos::otorgarPermiso('instituto',"s");
						Permisos::revocarPermiso('persona',"I");
						Permisos::revocarPermiso('persona',"u");
						Permisos::revocarPermiso('persona',"d");
						Permisos::otorgarPermiso('persona',"s");
						Permisos::revocarPermiso('docente',"I");
						Permisos::revocarPermiso('docente',"u");
						Permisos::revocarPermiso('docente',"d");
						Permisos::otorgarPermiso('docente',"s");
						Permisos::revocarPermiso('estudiante',"I");
						Permisos::revocarPermiso('estudiante',"u");
						Permisos::revocarPermiso('estudiante',"d");
						Permisos::otorgarPermiso('estudiante',"s");
						Permisos::revocarPermiso('usuario',"I");
						Permisos::revocarPermiso('usuario',"u");
						Permisos::revocarPermiso('usuario',"d");
						Permisos::revocarPermiso('usuario',"s");
						Permisos::revocarPermiso('curso',"I");
						Permisos::revocarPermiso('curso',"u");
						Permisos::revocarPermiso('curso',"d");
						Permisos::otorgarPermiso('curso',"s");
						Permisos::revocarPermiso('estudianteCurso',"I");
						Permisos::revocarPermiso('estudianteCurso',"u");
						Permisos::revocarPermiso('estudianteCurso',"d");
						Permisos::otorgarPermiso('estudianteCurso',"s");
						Permisos::revocarPermiso('pensum',"I");
						Permisos::revocarPermiso('pensum',"u");
						Permisos::revocarPermiso('pensum',"d");
						Permisos::otorgarPermiso('pensum',"s");

					}else 
					if (Sesion::obtenerTipoUsuario()=='D'){

						Permisos::agregarModulo('persona');
						Permisos::agregarModulo('docente');
						Permisos::agregarModulo('estudiante');
						Permisos::agregarModulo('usuario');
						Permisos::agregarModulo('curso');
						Permisos::agregarModulo('instituto');
						Permisos::agregarModulo('pensum');
						Permisos::agregarModulo('estudianteCurso');
						Permisos::revocarPermiso('instituto',"I");
						Permisos::revocarPermiso('instituto',"u");
						Permisos::revocarPermiso('instituto',"d");
						Permisos::otorgarPermiso('instituto',"s");
						Permisos::revocarPermiso('persona',"I");
						Permisos::revocarPermiso('persona',"u");
						Permisos::revocarPermiso('persona',"d");
						Permisos::otorgarPermiso('persona',"s");
						Permisos::revocarPermiso('docente',"I");
						Permisos::revocarPermiso('docente',"u");
						Permisos::revocarPermiso('docente',"d");
						Permisos::otorgarPermiso('docente',"s");
						Permisos::revocarPermiso('estudiante',"I");
						Permisos::revocarPermiso('estudiante',"u");
						Permisos::revocarPermiso('estudiante',"d");
						Permisos::otorgarPermiso('estudiante',"s");
						Permisos::revocarPermiso('usuario',"I");
						Permisos::revocarPermiso('usuario',"u");
						Permisos::revocarPermiso('usuario',"d");
						Permisos::revocarPermiso('usuario',"s");
						Permisos::revocarPermiso('curso',"I");
						Permisos::revocarPermiso('curso',"u");
						Permisos::revocarPermiso('curso',"d");
						Permisos::otorgarPermiso('curso',"s");
						Permisos::revocarPermiso('estudianteCurso',"I");
						Permisos::otorgarPermiso('estudianteCurso',"u");
						Permisos::revocarPermiso('estudianteCurso',"d");
						Permisos::otorgarPermiso('estudianteCurso',"s");
						Permisos::revocarPermiso('pensum',"I");
						Permisos::revocarPermiso('pensum',"u");
						Permisos::revocarPermiso('pensum',"d");
						Permisos::otorgarPermiso('pensum',"s");


					}else 
						if (Sesion::obtenerTipoUsuario()=='M'){
					Permisos::agregarModulo('persona');
					Permisos::agregarModulo('docente');
					Permisos::agregarModulo('estudiante');
					Permisos::agregarModulo('usuario');
					Permisos::agregarModulo('curso');
					Permisos::agregarModulo('instituto');
					Permisos::agregarModulo('pensum');
					Permisos::agregarModulo('estudianteCurso');
					Permisos::otorgarPermiso('instituto',"I");
					Permisos::otorgarPermiso('instituto',"u");
					Permisos::otorgarPermiso('instituto',"d");
					Permisos::otorgarPermiso('instituto',"s");
					Permisos::otorgarPermiso('persona',"I");
					Permisos::otorgarPermiso('persona',"u");
					Permisos::otorgarPermiso('persona',"d");
					Permisos::otorgarPermiso('persona',"s");
					Permisos::revocarPermiso('docente',"I");
					Permisos::revocarPermiso('docente',"u");
					Permisos::revocarPermiso('docente',"d");
					Permisos::otorgarPermiso('docente',"s");
					Permisos::revocarPermiso('estudiante',"I");
					Permisos::revocarPermiso('estudiante',"u");
					Permisos::revocarPermiso('estudiante',"d");
					Permisos::otorgarPermiso('estudiante',"s");
					Permisos::otorgarPermiso('usuario',"I");
					Permisos::otorgarPermiso('usuario',"u");
					Permisos::otorgarPermiso('usuario',"d");
					Permisos::otorgarPermiso('usuario',"s");
					Permisos::revocarPermiso('curso',"I");
					Permisos::revocarPermiso('curso',"u");
					Permisos::revocarPermiso('curso',"d");
					Permisos::otorgarPermiso('curso',"s");
					Permisos::revocarPermiso('estudianteCurso',"I");
					Permisos::revocarPermiso('estudianteCurso',"u");
					Permisos::revocarPermiso('estudianteCurso',"d");
					Permisos::otorgarPermiso('estudianteCurso',"s");
					Permisos::otorgarPermiso('pensum',"I");
					Permisos::otorgarPermiso('pensum',"u");
					Permisos::otorgarPermiso('pensum',"d");
					Permisos::otorgarPermiso('pensum',"s");
				}else 
						if (Sesion::obtenerTipoUsuario()=='JC'){
					Permisos::agregarModulo('persona');
					Permisos::agregarModulo('docente');
					Permisos::agregarModulo('estudiante');
					Permisos::agregarModulo('usuario');
					Permisos::agregarModulo('curso');
					Permisos::agregarModulo('instituto');
					Permisos::agregarModulo('pensum');
					Permisos::agregarModulo('estudianteCurso');
					Permisos::revocarPermiso('instituto',"I");
					Permisos::revocarPermiso('instituto',"u");
					Permisos::revocarPermiso('instituto',"d");
					Permisos::otorgarPermiso('instituto',"s");
					Permisos::otorgarPermiso('persona',"I");
					Permisos::otorgarPermiso('persona',"u");
					Permisos::otorgarPermiso('persona',"d");
					Permisos::otorgarPermiso('persona',"s");
					Permisos::otorgarPermiso('docente',"I");
					Permisos::otorgarPermiso('docente',"u");
					Permisos::otorgarPermiso('docente',"d");
					Permisos::otorgarPermiso('docente',"s");
					Permisos::otorgarPermiso('estudiante',"I");
					Permisos::otorgarPermiso('estudiante',"u");
					Permisos::otorgarPermiso('estudiante',"d");
					Permisos::otorgarPermiso('estudiante',"s");
					Permisos::otorgarPermiso('usuario',"I");
					Permisos::otorgarPermiso('usuario',"u");
					Permisos::otorgarPermiso('usuario',"d");
					Permisos::otorgarPermiso('usuario',"s");
					Permisos::revocarPermiso('curso',"I");
					Permisos::revocarPermiso('curso',"u");
					Permisos::revocarPermiso('curso',"d");
					Permisos::otorgarPermiso('curso',"s");
					Permisos::revocarPermiso('estudianteCurso',"I");
					Permisos::revocarPermiso('estudianteCurso',"u");
					Permisos::revocarPermiso('estudianteCurso',"d");
					Permisos::otorgarPermiso('estudianteCurso',"s");
					Permisos::revocarPermiso('pensum',"I");
					Permisos::revocarPermiso('pensum',"u");
					Permisos::revocarPermiso('pensum',"d");
					Permisos::otorgarPermiso('pensum',"s");
				}
				else 
						if (Sesion::obtenerTipoUsuario()=='JD'){
					Permisos::agregarModulo('persona');
					Permisos::agregarModulo('docente');
					Permisos::agregarModulo('estudiante');
					Permisos::agregarModulo('usuario');
					Permisos::agregarModulo('curso');
					Permisos::agregarModulo('instituto');
					Permisos::agregarModulo('pensum');
					Permisos::agregarModulo('estudianteCurso');
					Permisos::revocarPermiso('instituto',"I");
					Permisos::revocarPermiso('instituto',"u");
					Permisos::revocarPermiso('instituto',"d");
					Permisos::otorgarPermiso('instituto',"s");
					Permisos::revocarPermiso('persona',"I");
					Permisos::revocarPermiso('persona',"u");
					Permisos::revocarPermiso('persona',"d");
					Permisos::otorgarPermiso('persona',"s");
					Permisos::revocarPermiso('docente',"I");
					Permisos::revocarPermiso('docente',"u");
					Permisos::revocarPermiso('docente',"d");
					Permisos::otorgarPermiso('docente',"s");
					Permisos::revocarPermiso('estudiante',"I");
					Permisos::revocarPermiso('estudiante',"u");
					Permisos::revocarPermiso('estudiante',"d");
					Permisos::otorgarPermiso('estudiante',"s");
					Permisos::revocarPermiso('usuario',"I");
					Permisos::revocarPermiso('usuario',"u");
					Permisos::revocarPermiso('usuario',"d");
					Permisos::otorgarPermiso('usuario',"s");
					Permisos::otorgarPermiso('curso',"I");
					Permisos::otorgarPermiso('curso',"u");
					Permisos::otorgarPermiso('curso',"d");
					Permisos::otorgarPermiso('curso',"s");
					Permisos::otorgarPermiso('estudianteCurso',"I");
					Permisos::otorgarPermiso('estudianteCurso',"u");
					Permisos::otorgarPermiso('estudianteCurso',"d");
					Permisos::otorgarPermiso('estudianteCurso',"s");
					Permisos::revocarPermiso('pensum',"I");
					Permisos::revocarPermiso('pensum',"u");
					Permisos::revocarPermiso('pensum',"d");
					Permisos::otorgarPermiso('pensum',"s");
				}

			}catch (Exception $e){
					throw $e;
			}
		}
	}	

?>
