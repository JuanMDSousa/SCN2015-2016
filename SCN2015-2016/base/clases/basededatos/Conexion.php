<?php
/**
 * @copyright 2014 - Instituto Universtiario de Tecnología Dr. Federico Rivero Palacio
 * @license GPLv3
 * @license http://www.gnu.org/licenses/gpl-3.0.html
 *
 * Conexion.php - Componente de MVCRIVERO.
 *
 * Esta clase permite manejar todas las conexiones que se realizan a la base de datos,
 * utilizado la clase PDO como corazon en las peticiones.
 *
 * @link /base/clases/Errores.php 		Clase manejadora de errores.
 * 
 *  
 * @author JHONNY VIELMA (jhonnyvq1@gmail.com)
 * 
 * @package Componentes
 */

class Conexion{
		public static $baseDeDatos;
		public static $host;
		public static $usuario;
		public static $clave;  
		public static $puerto;
		
		/**
		 * Función que permite iniciar el objeto.
		 * 
		 *Funcion estatica que permite iniciar todo los atributos de la clase conexcion
		 *con los pasados por parametros.Esta permitira tener los atribtos inicializados con
		 *los parametros de la conexcion
		 *
		 * @param string $host 					Host de la maquina ejem. localhost.
		 * @param string $baseDeDatos			Nombre de la base de datos. 
		 * @param string $puerto				Puerto ejemp (5432).
		 * @param string $clave					Cotraseña de la base de datos.
		 * @param string $usuario				Usuario de la base de datos ejemp: postgrest
		 * 
		 */
		public static function  iniciar($host, $baseDeDatos, $puerto, $usuario, $clave ){
			self::$host = $host;
			self::$baseDeDatos = $baseDeDatos;
			self::$puerto = $puerto;
			self::$usuario = $usuario;
			self::$clave = $clave;
		}
		
		
		/**
		 * Funcion estatica que permite conectarse a la base de datos.
		 * 
		 * Permite conectarse a la base de datos mediante la clase PDO.Conectandose
		 * con los atributos de la clase antes inicializados.
		 * 
		 * @throws Exception 					Si se producen errores de autentificacion al conectarse.
		 * 
		 */
		public static function conectar(){
			 try {
				$co= new PDO("pgsql:dbname=".self::$baseDeDatos.";host=".self::$host.";port=".self::$puerto,self::$usuario ,self::$clave);	
				$co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //<--- INSTRUCCION DE ARRIBA
				return $co;	
			}catch  (Exception $e){
				throw new Exception ("Datos de autenticación incorrectos, Revise su usuario y password");
			}
		
		}
		
		
		/**
		 * Funcion estatica que permite obtener el nombre de la base de datos.
		 * 
		 * Permite obtener el nombre de la base de datos en la cual el objeto esta instanciada.
		 * 
		 * @return string                       Nombre de la base de datos.
		 * 
		 */
		public static function obtenerBaseDeDatos(){
			return self::$baseDeDatos;
		}
		
		
		/**
		 * Funcion estatica que permite obtener el host.
		 * 
		 * Permite obtener el host con el cual esta instanciado el objeto.
		 * 
		 * @return string                      Host con el que esta instanciado el objeto.
		 * 
		 */
		public static function obtenerHost(){
			return self::$host;
		}

		
		
		/**
		 * Funcion estatica que permite obtener el usuario.
		 * 
		 * Permite obtener el usuario con el que esta instanciado el objeto
		 * y con el que se accedera a la base de datos.
		 * 
		 * @return string                      Usuario con el que esta instanciado el objeto.
		 * 
		 */
		public static function obtenerUsuario(){
			return self::$usuario;
		}
	
		
		/**
		 * Funcion estatica que permite obtener la clave.
		 * 
		 * Permite obtener la clave con el que esta instanciado el objeto
		 * y con el que se accedera a la base de datos.
		 * 
		 * @return string                      Clave con el que esta instanciado el objeto.
		 * 
		 */
		
		public static function obtenerClave(){
			return self::$clave;
		}	
		
		
		/**
		 * Funcion estatica que permite obtener el puerto.
		 * 
		 * Permite obtener el puerto con el que esta instanciado el objeto
		 * y con el que se accedera a la base de datos.
		 * 
		 * @return string                      Puerto con el que esta instanciado el objeto.
		 * 
		 */
		public static function obtenerPuerto(){
			return self::$puerto;
		}
}
?>
