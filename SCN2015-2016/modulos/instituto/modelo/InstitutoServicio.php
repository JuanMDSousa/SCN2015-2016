	<?php

/**
 * @copyright 2014 - Instituto Universtiario de Tecnología Dr. Federico Rivero Palacio
 * @license GPLv3
 * @license http://www.gnu.org/licenses/gpl-3.0.html
 *
 * InstitutoServicio.php - Servicio del módulo Instituto.
 *
 * Esta clase ofrece el servicio de conexión a la base de datos, recibe 
 * los parámetros, construye las consultas SQL, hace las peticiones a 
 * la base de datos y retorna los objetos o datos correspondientes a la
 * acción. en este archivo se contiene todo lo relacionado a instituto
 * es el archivo que permite la interacion la lo relacionado a instituto
 * en la base de datos.Todas las funciones de esta clase relanzan las excepciones si son capturadas.
 * Esto con el fin de que la clase manejadora de errores las capture y procese.
 * 
 * Esta clase trabaja en conjunto con la clase Conexion.
 *
 * @link /base/clases/conexion/Conexion.php 	Clase Conexion
 * 
 * Esta clase trabaja en conjunto co la clase manejadora de errores.
 * 
 * @link /base/clases/Errores.php 		Clase manejadora de errores.
 *  
 * @author JHONNY VIELMA (jhonnyvq1@gmail.com)
 * 
 * @package Servicios
 */

class InstitutoServicio {
	/**
		 * Función que permite listar todos los institutos.
		 * 
		 * Realiza la consulta a la base de datos y retorna un arreglo asociativo de los institutos o
		 * null si no se encontró coincidencia.
		 * 
		 * Es utilizado para filtrar la búsqueda.
		 * @return array|null					Retorna un arreglo de arreglos asociativos o null de no encontrarse coincidencias.								
		 *
		 * @throws Exception 					Si se producen errores en operaciones con la base de datos.
		 */
	public static function listarInstitutos(){
		try{
			$conexion=Conexion::conectar();
			$consulta= "select * from sis.t_instituto;";
							
				$ejecutar= $conexion->prepare($consulta);
				
				$ejecutar->execute(array());
				
				if($ejecutar->rowCount()!=0){
					return $ejecutar->fetchAll();
				}
				else
					return null;		
			}catch (Exception $e ){
				throw $e;
			}	
		
	}
	
	/**
		 * Función que permite agregar un instituto.
		 * 
		 * Permite agrega un instituto a la base de datos, recive como parametro un objeto instituto
		 * que luego se descompone y agrega a la base de datos
		 * 
		 * @param objet $instituto 			  	Objeto instituto a agregar.
		 *
		 * @throws Exception 					Si no se puede agregar el instituto.
		 */
	public static function agregar($instituto){
			try{
				$codigo=self::obtenerMaxCodigo()+1;
				$conexion=Conexion::conectar();
				$consulta="insert into sis.t_instituto 
								(codigo,nombre,nom_corto,
								direccion)
								values
								(?,?,?,?)";
								
				$ejecutar=$conexion->prepare($consulta);
				$ejecutar->execute(array($codigo,
										$instituto->obtenerNombre(),
										$instituto->obtenerNombreCorto(),
										$instituto->obtenerDireccion()
								
										));
				if ($ejecutar->rowCount()==0)
					throw new Exception("No se puede agregar el instituto");	
			}catch(Exception $e){
				throw $e;
			} 
		}
	
	/**
		 * Función que permite modificar un instituto.
		 * 
		 * Permite modificar un instituto a la base de datos, recive como parametro un objeto instituto
		 * que luego se descompone y mopdifica.
		 * 
		 * @param objet $instituto 			  	Objeto instituto a modificar.
		 *
		 * @throws Exception 					Si no se puede modificar el instituto.
		 */
	public static function modificar($instituto){
			try{
				$conexion=Conexion::conectar();
				$consulta="UPDATE sis.t_instituto SET nombre=?,nom_corto=?, direccion=? WHERE codigo=?";
								
				$ejecutar=$conexion->prepare($consulta);
				$ejecutar->execute(array($instituto->obtenerNombre(),
										 $instituto->obtenerNombreCorto(),
										 $instituto->obtenerDireccion(),
										 $instituto->obtenerCodigo()
								
										));
				if ($ejecutar->rowCount()==0)
					throw new Exception("No se puede modificar el instituto");	
			}catch(Exception $e){
				throw $e;
			} 
		}
		
		/**
		 * Función que permite eliminar un instituto.
		 * 
		 * Permite eliminar un instituto a la base de datos, recive como parametro un codigo de instituto
		 * que sera el que se eliminara en la base de datos.
		 * 
		 * @param int $codigo 			  		Codigo instituto a eliminar.
		 *
		 * @throws Exception 					Si no se puede eliminar el instituto.
		 */
		public static function eliminar($codigo){
			try{
				$conexion=Conexion::conectar();
				$consulta="delete from sis.t_instituto where codigo =?";
								
				$ejecutar=$conexion->prepare($consulta);
				$ejecutar->execute(array($codigo
								
										));
				if ($ejecutar->rowCount()==0)
					throw new Exception("No se pudo eliminar el instituto");	
			}catch(Exception $e){
				throw $e;
			} 
		}
		
		/**
		 * Función que permite obtener el max codigode  un instituto.
		 * 
		 * Permite obtener el ultimo codigo de instituto que se encuentra en la base de datos.
		 * 
		 * @return int				Codigo del ultimo instituto,
		 * 
		 */
	public static function obtenerMaxCodigo(){
				try{
					$conexion=Conexion::conectar();
					$consulta="select coalesce(max(codigo),0) from sis.t_instituto";
					$ejecutar=$conexion->query($consulta);
					$r= $ejecutar->fetchAll();
					return $r[0][0];
				}catch(Exception $e){
					throw $e;
				}
		}
	
	
	/**
		 * Función que permite obtener un instituto.
		 * 
		 * Permite obtener eun instituto de la base de datos, luego arma un objeto instituto
		 * con lo obtenido de base de datos y lo retorna.
		 * 
		 * @return objet				Objeto istituto obtenido en la base de datos.
		 * 
		 * @throws Exception 			si no existe el instituto.
		 * 
		 */
	public static function obtener($codigo){
			try{
				$conexion=Conexion::conectar();
				$consulta="select * from sis.t_instituto where codigo=? ";
				$ejecutar=$conexion->prepare($consulta);
				$ejecutar->execute(array($codigo));
				if ($ejecutar->rowCount()==0)
					throw new Exception ('no existe el instituto a modificar');
				else {
					return $ejecutar->fetchAll();
					
				}
			}catch(Exception $e){
				throw $e;
			}
			
		}
		
	
}

