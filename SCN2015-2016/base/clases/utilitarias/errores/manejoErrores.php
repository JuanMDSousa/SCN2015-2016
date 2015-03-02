<?php
/**
 * @copyright 2014 - Instituto Universtiario de Tecnología Dr. Federico Rivero Palacio
 * @license GPLv3
 * @license http://www.gnu.org/licenses/gpl-3.0.html
 *
 * manejoErrores.php - Componente de MVCRIVERO.
 *
 * Clase manejoErrores esta clase permite tener un manejo detallado de los errores
 * del sitema al momento de la ejecucion de este mismo. Permite capturar lo errores
 * y exceptiones que lanza el sistema y manejar dichos errores y exceptiones  de una
 * manera ordena.Esta clase permitira que el sistema sea mantenible en el tiempo, ya
 * que dependiendo el tipo de vista que se este trabajando en el sistema, este mandara
 * el error en la vistas correspondient y guardando en un archivo la cantidad de errores
 * del sistema.
 *
 *  
 * @author JHONNY VIELMA (jhonnyvq1@gmail.com)
 * 
 * @package Componentes
 */

	class manejoErrores{
	


		/**
		 * Funcion estatica que permite lanzar los errores.
		 *
		 * Permite lanzar los errores capturados como exceptiones,
		 * esta funcion captura los errores del sistema y los lanza como una exception.
		 * Ejemplo set_error_handler("manejoErrores::manejarErrores")
		 *
		 * @param int     $tipo 				Tipos de error.
		 * @param string  $mensaje 				Mensaje del error. 
		 * @param string  $archivo				Archivo en el cual ocurrio el error.
		 * @param string  $linea				Linea donde ocurrio el error.
		 * 
		 * @throws Exception 					Mensaje que entra en la funcion.
		 */
		public static function manejarErrores($tipo,$mensaje,$archivo,$linea){
			
			throw new Exception ($mensaje);
		}
		
		
		/**
		 * Funcion estatica que permite lanzar las exceptiones no capturados.
		 *
		 * Lanzar las exceptiones no capturados en el sistema y procesarlas en el manejo de errores del sistema, esta 
		 * funcion permite que no se escapen exceptiones. Ejemplo set_exception_handler("manejoErrores::manejadorExcepcionesNoCapturadas").
		 * 
		 *
		 * @param exception  $e					Exception no capturada.
		 * 
		 */
		
		public static function manejadorExcepcionesNoCapturadas($e){
			self::manejarExcepcion($e);
		}
		
			/**
		 * Funcion estatica que permite obtener el codigo de error.
		 *
		 * Permite obtener el codigo de error del archivo numeroErrores.txt
		 * ya que este posee el numero de errores y exceptiones que ha disparado el sistema y asi
		 * mantener un menejo de error ordenado.
		 * 
		 * @return int                    Cantidad de errores
		 *
		 * 
		 */

		public static function obtenerCodigoError(){
			$archivo=fopen("numeroErrores.txt","r");
			 return fgets($archivo);
			
		}
		
		/**
		 * Funcion estatica que permite crear los archivos en el sistema.
		 *
		 * Crear los archivos en el sistema en el cual se manejaran los 
		 * errores. Son  2 archivos errores.txt donde se encuentra la especificacion del error en 
		 * especifico y numeroErrores.txt que posee la cantidad de errores que ha lanzado el sistema.
		 * 
		 *
		 * 
		 */
		public static function crearArchivos(){
			$archivo=fopen("errores.txt","w+");
			fclose($archivo);
			$archivo=fopen("numeroErrores.txt","w+");
			fputs($archivo,"0");
			fclose($archivo);
		}
			
			/**
		 * Funcion estatica que permite verificar si algun archivo ya esta creado.
		 *
		 * Permite verificar si algun archivo ya esta creado un algun directorio
		 * especifico del sistema.
		 *  
		 * @return boolean                   Si existe el archivo true si no false
		 *
		 * 
		 */
		public static function existeArchivo($nombre){
			return file_exists ($nombre);
		} 
		
		/**
		 * Funcion estatica que permite escribir el codigo de error.
		 *
		 * Permite escribir el codigo de error pasado por parametro en el
		 * archivo que tambien se pasa por parametro.
		 *  
		 * @param string  $nombre 				Nombre del archivo donde se escribira el error.
		 * @param string  $codigo 				Codigo del error al escribir. 
		 * 
		 *
		 * 
		 */
		
		 
		public static function escribirCodigoError($nombre,$codigo){
			$archivo=fopen($nombre,"w+");
			fputs($archivo,$codigo);
			fclose($archivo);
			
		}
		
		/**
		 * Funcion estatica que permite escribir en json la exception.
		 *
		 * Permite escribir en json la exception pasada por parametro, esto para
		 * tener el manejo de errores a la hora de hacer consultas ajax al servidor, esto agilizara muchos
		 * procesos y tiempo que se empleaba antes para ver los errores ajax.
		 *  
		 * @param exception $e 				Exception a escribir
		 *
		 * 
		 */
		public static function escribirExceptionJson(Exception $e){
			$estatus =-1;
			$codigo= manejoErrores::obtenerCodigoAEscribir();
			$cad = ""
		     . "{"
			 . "\"estatus\":\"" . $estatus. "\","
			 . "\"codigo\":\"" . $codigo. "\","
			 . "\"mensaje\":\"" . $e->getMessage(). "\""
			 . "}"
			 . "";
			echo $cad;
			
		} 
		
		
		/**
		 *  Funcion que permite obtener el codigo de error que se acaba de generar.
		 *
		 *  Permite obtener el codigo de error que se acaba de generar, siempre sera un 
		 *  numero mas a el anterior error originado es decir, si el anterior fue 8 lo que retornara
		 *  la funcion sera un 9.Esto permitira tener un manejo ordenado de errores en el sistema.
		 * 
		 * @return int                 Codigo que genero el error.
		 *
		 * 
		 */
		public static function obtenerCodigoAEscribir(){
				return self::obtenerCodigoError() + 1;
		} 
		
		/**
		 *  Funcion que permite tener el manejo detallado de la exception
		 *
		 *  Permite tener el manejo detallado de la exception ya que dependiendo de la vista
		 *	en la que se genero el error esta funcion permite tener el manejo a la hora de mostrar la informacion
		 *	en el mismo tipo de vista en el que este trabajando el desarrolar.
		 * 
		 * @param exception $e 				Exception a manejar
		 * 
		 *  @throws Exception 				En caso de encotrar alguna exception
		 * 
		 */
			
		public static function manejarExcepcion($e){
			try{
				if ((self::existeArchivo("numeroErrores.txt")!=true) || (self::existeArchivo("errores.txt")!=true))
					self::crearArchivos();
				$formato= PostGet::obtenerPostGet('m_formato');
				self::escribirExceptionArchivo($e);
				if($formato=="json")
					self::escribirExceptionJson($e);
				else if ($formato=="html5"){
					self::escribirExceptionHtml5($e);
				} else if ($formato=="pdf"){
					self::escribirExceptionPdf($e);
				} else if ($formato=="odt"){
					self::escribirExceptionOdt($e);
				} else if ($formato=="txt"){
					self::escribirExceptionTxt($e);
				}else{
					$mensaje = "Formato incorrecto ".$formato;
					$codigo = manejoErrores::obtenerCodigoAEscribir();
					require_once("base/clases/utilitarias/errores/mensajeErrorHtml5.php");
				}
				manejoErrores::escribirCodigoError("numeroErrores.txt", manejoErrores::obtenerCodigoAEscribir());
			}catch(Exception $e){
				throw $e;
			}
		} 
		
		/**
		 *  Funcion que permite escribir en el archivo errores.txt los errores producidos.
		 *
		 * Permite escribir en el archivo errores.txt los errores producidos en el sistema
		 * en tiempo de ejecucion. Esta funcion guarda el error en el archivo con su codigo, mensaje, linea
		 * y traza de todo el error en general en un formato entendible y legible.
		 * 
		 * @param exception $e 				Exception a escribir
		 * 
		 * 
		 */
		
		public static function escribirExceptionArchivo(Exception $e){
			$archivo=fopen("errores.txt","a");
			$codigoError=self::obtenerCodigoAEscribir();
			$cl = "\r\n";
			$tab = "\t";
			$cadena="";
			$cadena.=$cl."**************************** Error n° ".$codigoError." *****************************";
			$cadena.=$cl."codigo Error: $codigoError";
			$cadena.=$cl."Mensaje error: ".$e->getMessage()."";
			$cadena.=$cl."Archivo Error: ".$e->getFile()."";
			$cadena.=$cl."Linea Error: ".$e->getLine()."";
			$cadena.=$cl."Trayecto:";
			$cadena.=implode("\n\t\t",explode("\n",$cl.$e->gettraceAsString()));
			fputs($archivo,$cadena ); 
			fclose($archivo);
		}
		
		 
		
		/**
		 *  Funcion que permite escribir en un archivo pdf los errores producidos.
		 *
		 * Permite escribir en un archivo pdf los errores producidos en el sistema
		 * en tiempo de ejecucion.
		 * 
		 * @param exception $e 				Exception a escribir
		 * 
		 * 
		 */ 
		
		public static function escribirExceptionPdf(Exception $e){
			$mensaje= $e->getMessage();
			$codigo= self::obtenerCodigoAEscribir();
			require_once("mensajePdf.php");
		}
		
		/**
		 *  Funcion que permite escribir en HTML5 los errores.
		 *
		 * Permite escribir en HTML5 los errores producidos en el sistema
		 * en tiempo de ejecucion.
		 * 
		 * @param exception $e 				Exception a escribir
		 * 
		 * 
		 */ 
		public static function escribirExceptionHtml5(Exception $e){
			$mensaje= $e->getMessage();
			$codigo= self::obtenerCodigoAEscribir();
			require_once("mensajeErrorHtml5.php");
		}
		
		/**
		 *  Funcion que permite escribir en TXT los errores.
		 *
		 * Permite escribir en TXT los errores producidos en el sistema
		 * en tiempo de ejecucion.
		 * 
		 * @param exception $e 				Exception a escribir
		 * 
		 * 
		 */
		public static function escribirExceptionTxt(Exception $e){
			$mensaje= $e->getMessage();
			$codigo= self::obtenerCodigoAEscribir();
			require_once("mensajeErrorTxt.php");
		} 
		
		/**
		 *  Funcion que permite obtener los traces de una exception.
		 *
		 * Permite obtener los traces de una exception los de la pasada por 
		 * parametro, los traces son todo el recorrido que ha tenido e error o la exception..
		 * 
		 * @param exception $e 				Exception a escribir
		 * 
		 * 
		 */
		
		public static function obtenerTraces(Exception $e){
				return $traces=  $e->gettrace();
			
		} 
		
		
		/**
		 *  Funcion que permite armar una cadena de los traces de una exception.
		 *
		 * permite armar una cadena de los traces de una exception los de la pasada por 
		 * parametro, los traces son todo el recorrido que ha tenido e error o la exception.
		 * 
		 * @param exception $e 				Exception a escribir
		 * 
		 * 
		 */
		
		public static function escribirTraces(array $traces){
				$tab = "\t";
				$cl = "\r\n";
				$cad=$cl.$tab;
				echo"entro"; 
				for ($i=0; $i<count($traces);$i++){
					
					$cad.=$cl.$tab.$tab.$tab."Recorrido ".($i+1);
					$cad.=$cl.$tab.$tab.$tab.$tab."archivo: ".$traces[$i]['file'];
					$cad.=$cl.$tab.$tab.$tab.$tab."funcion: ".$traces[$i]['function'];
					
					
				}
			return $cad;
		}


	}


?>
