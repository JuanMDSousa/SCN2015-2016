<?php

/**
 * @copyright 2014 - Instituto Universtiario de Tecnología Dr. Federico Rivero Palacio
 * @license GPLv3
 * @license http://www.gnu.org/licenses/gpl-3.0.html
 *
 * InstitutoControlador.php  Controladores de MVCRIVERO.
 *
 *	Este es el controlador del módulo Instituto, permite manejar las 
 *	operaciones relacionadas con los institutos (agregar, modificar,
 *	eliminar, consultar, buscar), es el intermediario entre la base de
 *	datos y la vista. La función manejarRequerimiento se maneja la accion a emprender, 
 *  obteniéndola del arreglo Post/Get en la posición 'accion'
 * 
 * 
 *  
 * @author JHONNY VIELMA 		(jhonnyvq1@gmail.com)
 * 
 * 
 * @link /modulos/instituto/modelo/InstitutoServicio.php 			 Clase InstitutoControlador
 * @link /negocio/Instituto.php 			                         Clase Instituto
 * 
 * @package Controladores
 */

//Objeto Instituto
require_once "negocio/Instituto.php";
require_once "modulos/instituto/modelo/InstitutoServicio.php";


class InstitutoControlador {
	
	
	 /**
		 * Funcion estatica que permite manejar el requerimiento .
		 *
		 * Permite manjear el requerimiento (o acción) indicado por el usuario según su petición
		 * que envia al controlador mediantes post o get con el name de m_accion.
	     * 		Acciones: 	mostrar-> muestra toda la información de un instituto 
	     * 					Cada acción será redireccionada a un método que la procesa para	mayor orden.
		 *
		 * 
		 */
	 
	public static function manejarRequerimiento(){

		//permite obtener la acción a realizar en este módulo
		$accion = PostGet::obtenerPostGet('m_accion');

		//permite colocar una acción predefinida en caso de no colocarla
		if ( ! $accion)
			$accion = 'listar';
			
		if ($accion == 'mostrar') 
			self::mostrarInstituto();
		elseif ($accion == 'listar')
			self::listarInstitutos();
		elseif ($accion == 'preagregar') 
			self::preagregarInstituto();
		elseif ($accion == 'agregar') 
			self::agregarInstituto();
		elseif ($accion == 'premodificar') 
			self::premodificarInstituto();
		elseif ($accion == 'modificar') 
			self::modificarInstituto();
		elseif ($accion == 'eliminar') 
			self::eliminar();
		elseif ($accion == 'obtener') 
			self::obtener();
		else
			die("Acci&oacute;n inv&aacute;lida en el m&oacute;dulo Instituto: $accion");
	}

	
	
	/**
		 * Método que permite agregar un instituto.
		 *
		 * Permite agregar un instituto, recibe los parámetros desde 
		 * la vista (arreglo PostGet) y llama a instituto servicio que permite
		 * comunicarse con la base de datos,y este último retorna el resultado
	     * ya sea éxito o fracaso, y con este resultado se le envía la respuesta
	     * al usuario.
		 * 
		 */
	private static function agregarInstituto() {
		$instituto = new Instituto();
		$instituto->asignarNombre(PostGet::obtenerPostGet('nombre'));
		$instituto->asignarNombreCorto(PostGet::obtenerPostGet('nombreC'));
		$instituto->asignarDireccion(PostGet::obtenerPostGet('direccion'));

		InstitutoServicio::agregar($instituto);
		Vista::asignarDato('mensaje','Se ha agregado el instituto');
		Vista::asignarDato('estatus',1);
		Vista::mostrar();
	}
	/**
		 * Método que permite modificar un instituto.
		 *
		 * Permite modificar un instituto, recibe los parámetros desde 
		 * la vista (arreglo PostGet) y llama a instituto servicio que permite
		 * comunicarse con la base de datos,y este último retorna el resultado
	     * ya sea éxito o fracaso, y con este resultado se le envía la respuesta
	     * al usuario esta funcion ecesita recivir el codigo del istituto.
		 * 
		 */
	private static function modificarInstituto() {
		
		//construir el objeto instituto sin el código ya que la base de datos
		//lo asigna automáticamente 
		$instituto = new Instituto();
		$instituto->asignarNombre(PostGet::obtenerPostGet('nombre'));
		$instituto->asignarCodigo(PostGet::obtenerPostGet('codigo'));
		$instituto->asignarNombreCorto(PostGet::obtenerPostGet('nombreC'));
		$instituto->asignarDireccion(PostGet::obtenerPostGet('direccion'));

		InstitutoServicio::modificar($instituto);
		Vista::asignarDato('estatus',1);
		Vista::asignarDato('mensaje','Se ha modificado el instituto');
		Vista::mostrar();
	}
	/**
		 * Método que permite obtener un instituto.
		 *
		 * Permite obtener un instituto, recibe los parámetros desde 
		 * la vista (arreglo PostGet) y llama a instituto servicio que permite
		 * comunicarse con la base de datos,y este último retorna el resultado
	     * ya sea éxito o fracaso, y con este resultado se le envía la respuesta
	     * al usuario esta funcion ecesita recivir el codigo del istituto.
		 * 
		 */
	private static function obtener() {
		

		$ins=InstitutoServicio::obtener(PostGet::obtenerPostGet('codigo'));
		Vista::asignarDato('instituto',$ins);
		Vista::asignarDato('estatus',1);
		Vista::mostrar();
	}
	/**
		 * Método que permite eliminar un instituto.
		 *
		 * Permite eliminar un instituto, recibe los parámetros desde 
		 * la vista (arreglo PostGet) y llama a instituto servicio que permite
		 * comunicarse con la base de datos,y este último retorna el resultado
	     * ya sea éxito o fracaso, y con este resultado se le envía la respuesta
	     * al usuario esta funcion ecesita recivir el codigo del istituto.
		 * 
		 */
	private static function eliminar() {
		

		$ins=InstitutoServicio::eliminar(PostGet::obtenerPostGet('codigo'));
		Vista::asignarDato('mensaje',"instituto eliminado");
		Vista::asignarDato('estatus',1);
		Vista::mostrar();
	}
	 /**
		 * Método que permite Listar los institutos.
		 *
		 * Permite listar los institutos, recibe los parámetros desde 
		 * la vista (arreglo PostGet) y llama a instituto servicio que permite
		 * comunicarse con la base de datos,y este último retorna el resultado
	     * ya sea éxito o fracaso, y con este resultado se le envía la respuesta
	     * al usuario.
		 * 
		 */
	private static function listarInstitutos(){
		try{
			$institutos=InstitutoServicio::listarInstitutos();
				
				if ($institutos){
					Vista::asignarDato('institutos',$institutos);
					Vista::asignarDato('estatus',1);
				}
				else {
					$mensaje="no hay institutos";
					Vista::asignarDato('mensaje',$mensaje);
				}
				Vista::mostrar();
			}catch(Exception $e){
				throw $e;
			}
	}
		
}
