<?php 
/**
 * @copyright 2014 - Instituto Universtiario de Tecnología Dr. Federico Rivero Palacio
 * @license GPLv3
 * @license http://www.gnu.org/licenses/gpl-3.0.html
 *
 * Vista.php - Componente de MVCRIVERO.
 *
 * Esta clase permite manejar todas las vistas del MVCRIVERO en distintos formatos,
 *Ya que suministra informacion a los distintos tipos de vista(PDF,ODT,JSON,HTML5
 *TXT), para los tipos de vista HTML5 se utiliza el potente motopr de platillas
 *llamadas TWIG cuyo motor permite tener codigos aun mas reutilizables ya que permite 
 *la reutilizacion de html5 en diferentes vista. Es unos de los complementos mas
 *importante del mvc.
 *Algunas las funciones de esta clase relanzan las excepciones si son capturadas.
 * Esto con el fin de que la clase manejadora de errores las capture y procese.
 *
 * @link /base/clases/Errores.php 		Clase manejadora de errores.
 * 
 *  
 * @author JHONNY VIELMA (jhonnyvq1@gmail.com)
 * 
 * @package Componentes
 */
 
	class Vista {
		
		public static $modulo;	
		public static $formato;
		public static $vista;
		public static $datos;
		public static $nombreArchivoDestino;
		
		
		/**
		 * Función que permite iniciar la vista de la aplicación.
		 *
		 * 	Esta funcion setea los valores y verifica que el tipo peticion corresponda con
		 * 	lo necesario para realizarse.
		 *
		 * @param string $cadenaConfigurar 		Cadena que lleva la configuracion 'modulo:vista:vista'.
		 * @param array  $Datos 				Arreglo asociativo con los datos que tendra la vista. 
		 *
		 * @throws Exception 					Si se producen errores en validaciones para tipos de vista.
		 */
		public static function iniciar($cadenaConfigurar=null,$datos=null,$nombreArchivoDestino=null){
				try{
					if ($cadenaConfigurar != null){
						$parametros= explode(':',$cadenaConfigurar);
						if ((count($parametros)!=3)&&(count($parametros)!=2)){
							throw new Exception("La candenaConfigurar de la funcion requiere 3 parametros para vistas html5 modulo:formato:vista ejemplo (pemsun:html5:agregar) y 2 parameros para vistas json ejemplo(pensum:json).");
						}
						self::$modulo=$parametros[0];
						self::$formato=$parametros[1];

						if (self::$formato=="html5"){
							self::$vista=$parametros[2];
								if (self::existeArchivo(self::obtenerRuta())==false){
									throw new Exception("Ruta no existente verifique dicha ruta: ".self::obtenerRuta());
								}
						}
						if ($datos!=null)
							self::asignarDatos($datos);
						
						if(self::$formato=="pdf"){
							self::$vista=$parametros[2];
							if(self::existeArchivo(self::obtenerRuta())==false){
								throw new Exception("Ruta no existente verifique dicha ruta: ".self::obtenerRuta());
							}
						}

						if(self::$formato=="odt"){
							self::$vista=$parametros[2];
							if(self::existeArchivo(self::obtenerRuta())==false){
								throw new Exception("Ruta no existente verifique dicha ruta: ".self::obtenerRuta());
							}
						}

						if (((self::$formato=="html5" ||(self::$formato=="json")) && ($nombreArchivoDestino!=null)))
							throw new Exception("Cuando se tiene nombre de archivo destino los fomatos de la vista no puede ser ni html5 o json ya que estas vistas no poseen nombre de archivo distinto ");
						if ($nombreArchivoDestino!=null){
							self::$nombreArchivoDestino=$nombreArchivoDestino;
						}
					}
				}catch (Exception $e){
					throw $e;
				}	
			
		}
		
		/**
		 * Permite obtener la ruta de del archivo a mostrar.
		 *
		 * Permite obtener la ruta de del archivo a mostrar con todos sus parametro pasados anteriormente al iniciarlos.
		 * 
		 * @return string                       Retorna la ruta de la vista a mostrar.
		 *
		 */
		private static function obtenerRuta(){
			if (self::$formato=="html5")
				return "modulos/".self::$modulo."/vista/".self::$formato."/".self::$vista.".html.twig";
			return "modulos/".self::$modulo."/vista/".self::$formato."/".self::$vista.".php";
		}
		
		/**
		 * Permite verificar la ruta.
		 * 
		 * Verifica la ruta en la que se encuetra la vista a mostrar, recive como parametro la ruta
		 * a verificar esto para evitar futuros errores.
		 *
		 * @return boolean                  Retorna true en caso de que exista y false de no existir.
		 *
		 */
		 
		private static function existeArchivo($ruta){
			return file_exists ($ruta);
		}
		 /**
		 * Permite Obtener un dato de los seteados en la vista.
		 * 
		 * Recive como parametros la posicion donde se encuentra el dato que se solicita.
		 * 
		 * @param string $posicion 						 Cadena con el nombre donde se encuentra el dato solicitado.
		 * @return array|int|strig|boolean|null          Retorna null al no encotrar datos e esa posicion de lo contrario el tipo de dato que se encuentre en esa posición.
		 *
		 */
		public static function obtenerDato($posicion){
			if (isset(self::$datos[$posicion]))
				return self::$datos[$posicion];
			else 
				return null;
		}
		
		/**
		 * Permite Obtener todos los datos seteados en la vista.
		 * 
		 * Esta función no recive parametros y se encarga de obtener todo los datos que posee la vista.
		 *
		 * @return array|null          Retorna un arreglo asociativo de poseer información o null si no posee información.
		 *
		 */
		public static function obtenerDatos(){
			return !(isset(self::$datos))? null:self::$datos;

		}
		
		/**
		 * Permite asigar un dato a la vista.
		 * 
		 * Asigar un dato que se necesite en la vista a mostrar este dato se anexara a todos los demas
		 * ya asigados
		 *
		 * @param strig $posicion 						Cadena con la cual se guardara el dato, con el nombre se obtendra luego.
		 * @param strig|array|int|boolean| $posicion 	Informacion que se guardara en la posicion, puede ser String,vector,integer o cualquier tipo de datos .
		 * 												
		 * @throws Exception 							Si se producen errores al momento de setear los datos.
		 */
		public static function asignarDato($posicion=null,$dato=null){
			
			try{
				if ($posicion==null){
					throw new Exception("La posición debe ser difente de null revise los parámetros de la función");	
				}
				//~ if ($dato==null){
					//~ throw new Exception("Los datos a obtener en la vista se debe pasar por parametros a la función");	
				//~ }
				if (isset(self::$datos[$posicion])){
					throw new Exception("Ya esta posicion posee información, se recomienda cambiar el nombre de la posición:".$posicion);
				}
				self::$datos[$posicion]=$dato;
			}catch (Exception $e){
					throw $e;
			}	
		}
		 /**
		 * Permite asigar todos los datos.
		 * 
		 * Asigna todos los datos que poseera la vista  en una sola funcion, esta funcion tiene un parametro de entrada que son
		 * los datos.
		 *
		 * @param array $datos 				Arreglo asociativo que posee todo los datos que se utilizaran en la vista.
		 * 												
		 * @throws Exception 				Si se producen errores al momento de setear los datos.
		 */ 
		public static function asignarDatos($datos=null){
			try{
				if ($datos==null){
					throw new Exception("Los datos a guardar  en la vista se debe pasar por parametros a la función setDatos() o ser diferente de null");	
				}	
				if (!(is_array($datos))) {
					throw new Exception("Los datos a guardar en la vista se debe pasar por parametros a la función setDatos() debe un arreglo");
				}
				self::$datos=$datos;
			}catch (Exception $e){
					throw $e;
				}	
		}
		/**
		 * Permite mostrar la vista .
		 * 
		 * Muestra la vista y asigna los datos correspondientes ya seteados,
		 * dependiendo del formato se setea de diferentes maeras por ejemplo cuando es html5 carga el 
		 * motor de plantillas twig y hace un display a la vista.
		 *
		 * 												
		 * @throws Exception 				Si se producen errores al momento mostrar la vista.
		 */ 
		public static function mostrar(){
			try{
				if (self::$formato=="html5")
					if (self::existeArchivo(self::obtenerRuta())==false)
						throw new Exception("La ruta a mostrar no se encuenta: ".self::obtenerRuta() ." verfique que ya inicio la clase vista");
					else 
						self::mostrarHtml5();
				if (self::$formato=="json")
					self::mostrarJson();
					
				if (self::$formato=="pdf")
					if (self::existeArchivo(self::obtenerRuta())==false)
						throw new Exception("La ruta a mostrar no se encuenta: ".self::obtenerRuta() ." verfique que ya inicio la clase vista");
					else
						self::mostrarPDF();
				if (self::$formato=="odt")
					if (self::existeArchivo(self::obtenerRuta())==false)
						throw new Exception("La ruta a mostrar no se encuenta: ".self::obtenerRuta() ." verfique que ya inicio la clase vista");
					else
						self::mostrarODT();

			}catch (Exception $e){
					throw $e;
				}	
		}
		 /**
		 * Carga todas las liberias twig .
		 * 
		 * Carga las librerias de twig para luego utilizarlas 
		 * esta funcion se debe llamar solo si la vista a mostrar es html5.
		 *
		 * 												
		 */ 
		private static function cargarTwig(){
			require_once "recursos/twig/lib/Twig/Autoloader.php";
			Twig_Autoloader::register();
			$loader = new Twig_Loader_Filesystem(array("base/clases/vista/html5","modulos/".self::$modulo."/vista/".self::$formato));
			return new Twig_Environment($loader);
		}
		/**
		 * Muetra la vista en formato HTML5.
		 * 
		 *Muestra una vista html5 antes seteada cargada con el motor de plantillas twig, y setea los datos con twig
		 * 												
		 */ 
		private static function mostrarHtml5(){
			$twig=self::cargarTwig();
			
			if(self::obtenerDatos() == null)
				$twig->display(self::$vista.".html.twig");
			else
				$twig->display(self::$vista.".html.twig",self::obtenerDatos());
		}
		/**
		 * Muetra la vista en formato JSON.
		 * 
		 * Muestra una vista JSON antes seteada realiza toda la tranformacion de datos a json
		 * para su utilizacion en json.
		 * 												
		 */ 
		private static function mostrarJson(){
			if(self::obtenerDatos() != null){
				$datos=self::obtenerDatos();
				$a=0;
				foreach ($datos as $nombre => $valor) {
					if ($nombre=="auto"){
						echo $valor;
						$a=1;
						break;  
					}
	
					$da[$nombre]=$valor;
				}
				if ($a!=1){
					
					$cad=json_encode($da);
					
					echo $cad;
				}
			}
			
		}
		/**
		 * Muetra la vista en formato PDF.
		 * 
		 * Muestra una vista PDF le paso todo los datos a la vista para su utilización
		 * 												
		 */
		private static function mostrarPDF(){
			if(self::obtenerDatos() != null){
				require_once("recursos/fpdf/fpdf.php");
				require_once(self::obtenerRuta());
			}
		}

		/**
		  * Muestra la vista en formato ODT
		  *
		  * Muestra una vista ODT, se le pasan los datos pertinentes y se obtiene la ruta.
		  *
		  */

		private static function mostrarODT(){
			if(self::obtenerDatos() != null){
				require_once("recursos/odf/odf");
				require_once(self::obtenerRuta());
			}
		}
	}
?>
