<?php


/**
 * * * * * * * * * * LICENCIA * * * * * * * * * * * * * * * * * * * * *

Copyright(C) 2014
Instituto Universtiario de Tecnología Dr. Federico Rivero Palacio

Este programa es Software Libre y usted puede redistribuirlo y/o modificarlo
bajo los términos de la versión 3.0 de la Licencia Pública General (GPLv3)
publicada por la Free Software Foundation (FSF), es distribuido sin ninguna
garantía. Usted debe haber recibido una copia de la GPLv3 junto con este
programa, sino, puede encontrarlo en la página web de la FSF, 
específicamente en la dirección http://www.gnu.org/licenses/gpl-3.0.html

 * * * * * * * * * * ARCHIVO * * * * * * * * * * * * * * * * * * * * *

Nombre: PersonaControlador.php
Diseñador: Hector Zea, Leonardo Camacaro (zea3471@gmail.com, leonardocamacaro@hotmail.com)
Programador: Hector Zea, Leonardo Camacaro (zea3471@gmail.com, leonardocamacaro@hotmail.com)
Fecha: Julio de 2014
Descripción:  
	Controlador del modulo persona del sistema de control de notas del 
	departamento de mecanica del instituto universitario dr federico rivero palacios.
	
 * * * * * * * * Cambios/Mejoras/Correcciones/Revisiones * * * * * * * *
Diseñador - Programador /   Fecha   / Descripción del cambio
---                         ----      ---------

 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

*/
    /** El controlador Persona se encarga de gestionar
    	todas las funciones necesarias para la llamada de los
    	servicios.
     */
     
    
	require_once("modulos/estudiante/modelo/estudianteservicio.php");
	require_once("negocio/Estudiante.clase.php");


	class EstudianteControlador{

	/** Funcion encargada de manejar todos los servicios
		o requerimientos del sistema.
     */


		public static function manejarRequerimiento(){
			//accion mandada en el sistema
			$accion = PostGet::obtenerPostGet('m_accion');
			//si alguna de las acciones no es mandada
			//se muestra el respectivo listar persona.
			if($accion == null)
				$accion = 'listar';		
			//pre agregar, en este consta del formulario
			//de la vista.	
			else if ($accion == 'listar')
				self::listar();		
			else if($accion == 'agregar')
				self::agregar();
			else if ($accion == 'eliminar')
				self::eliminar();
			else if ($accion == 'buscarEstudianteCodigo')
				self::buscarEstudianteCodigo();	
			else if ($accion == 'obtenerEstudiantes')
				self::obtenerEstudiantes();
			else if($accion =='buscarPersonas')
				self::buscarPersonas();
			else if($accion =='buscarDepartamentos')
				self::buscarDepartamentos();
			else if($accion =='buscarEstado')
				self::buscarEstado();
			else if($accion == 'agregarEstudiante')
				self::agregarEstudiante();
			else if ($accion =='modificar')
				self::modificar();
			else if ($accion == 'retirar')				
				self::retirar();
			else if ($accion =='buscarE')
				self::buscarEstudiantes();
			else if ($accion == 'buscarEstudianteCodigo')
				self::buscarEstudianteCodigo();	
			else
				throw new Exception("(EstudianteControlador) Acción $accion no es válida");
		}	

		//controlador encargado de agregar una persona al sistema
		//de control de notas al sistema.

		

		public static function obtenerEstudiantes(){
			try{
				$cod = PostGet::obtenerPostGet('codCurso');
				
				$r = ServicioEstudiante::obtenerEstudiantes($cod);	
				Vista::asignarDato('estudiantes',$r);
				Vista::asignarDato('estatus',1);

				
				Vista::mostrar();
			}catch (Exception $e){
				throw $e;
			}
		}

public static function buscarEstudiantes(){
			$patron = PostGet::obtenerPostGet("patron");

			$r=ServicioEstudiante::buscarEstudiantes($patron);

			if ((PostGet::obtenerPostGet('m_formato')=="json")&&(PostGet::obtenerPostGet('tipoB')=="autocompletar")){
				$cad = "[";
				if ($r != null){
					$c = 0;
					foreach ($r as $estudiante) { 
						if ($c > 0) 
							$cad .= ",";
						$cad .= "{";
						$cad .= '"label": "' . $estudiante['nombre1']. ' ' . $estudiante['apellido1'] . '", ';
						$cad .= '"value": '.$estudiante['codigo'];
						$cad .= "}";
						$c++;
					}
				}
				else{
					$cad .= "{";
					$cad .= '"label": " No hay coincidencias ", ';
					$cad .= '"value": null';
					$cad .= "}";
				}	
				$cad .= "]";
			Vista::asignarDato("auto",$cad);
			}
			else{
				Vista::asignarDato("estudiantes",$r);
				Vista::asignarDato("estatus",1);
			}
			Vista::mostrar();
		}

		public static function listar()
		{
			$r= ServicioEstudiante::listar(PostGet::obtenerPostGet('patron'));
			
			Vista::asignarDato('estudiante',$r);
			Vista::asignarDato('estatus',1);
			Vista::mostrar();
		}

	public static function buscarEstudianteCodigo()
		{
			try{
				
				$r=ServicioEstudiante::obtenerPorCodigo(PostGet::obtenerPostGet('codigo'));
					Vista::asignarDato('estudiante',$r);
					Vista::asignarDato('estatus',1);
				
				Vista::mostrar();
			}
			catch(Exception $e){
				throw $e;
			}
		}
		
		public static function agregar(){
			try{
				$estudiante = new Estudiante();				
				$estudiante->asignarCodDpto(PostGet::obtenerPostGet('departamentoEst2'));
				$estudiante->asignarCodPensum(PostGet::obtenerPostGet('departamentoEst2'));
				$estudiante->asignarCodEstado(PostGet::obtenerPostGet('estadoEst2'));		
				$r = ServicioEstudiante::agregar($estudiante);				
				$mensaje = "Estudiante Agregado con exito";
				Vista::asignarDato('mensaje',$mensaje);
				Vista::asignarDato('estatus',1);
				Vista::mostrar();
			}catch (Exception $e){
				throw $e;
			}
		}

		public static function agregarEstudiante(){
			try{
				$estudiante = new Estudiante();				
				$estudiante->asignarCodDpto(PostGet::obtenerPostGet('departamentoEst2'));
				$estudiante->asignarCodPensum(PostGet::obtenerPostGet('departamentoEst2'));
				$estudiante->asignarCodEstado(PostGet::obtenerPostGet('estadoEst2'));	
				$estudiante->asignarCodigo(PostGet::obtenerPostGet('selectNombre'));		
				$r = ServicioEstudiante::agregarEstudiante($estudiante);				
				$mensaje = "Estudiante Agregado con exito";
				Vista::asignarDato('mensaje',$mensaje);
				Vista::asignarDato('estatus',1);
				Vista::mostrar();
			}catch (Exception $e){
				throw $e;
			}
		}

		public static function modificar(){

			$estudiante = new Estudiante();				
				$estudiante->asignarCodDpto(PostGet::obtenerPostGet('departamento'));
				$estudiante->asignarCodPensum(PostGet::obtenerPostGet('pensum'));
				$estudiante->asignarCodEstado(PostGet::obtenerPostGet('estado'));			
				$r = ServicioEstudiante::modificar(PostGet::obtenerPostGet('codigo'),$estudiante);
				$mensaje = "Estudiante Modificado con exito";
				Vista::asignarDato('mensaje',$mensaje);
				Vista::asignarDato('estatus',1);
				Vista::mostrar();
		}	

		public static function retirar(){
			$r=ServicioEstudiante::retirarPorCodigo(PostGet::obtenerPostGet('codigo'));			
			$mensaje = "Estudiante retirado con exito";
			Vista::asignarDato('mensaje',$mensaje);
			Vista::asignarDato('estatus',1);
			Vista::mostrar();
		}

		public static function buscarPersonas(){
			$r=ServicioEstudiante::buscarPersonas();			
			Vista::asignarDato('estudiante',$r);
			Vista::asignarDato('estatus',1);
			Vista::mostrar();
		}

		public static function buscarDepartamentos(){
			$r=ServicioEstudiante::buscarDepartamentos();			
			Vista::asignarDato('estudiante',$r);
			Vista::asignarDato('estatus',1);
			Vista::mostrar();
		}

		public static function buscarEstado(){
			$r=ServicioEstudiante::buscarEstado();			
			Vista::asignarDato('estudiante',$r);
			Vista::asignarDato('estatus',1);
			Vista::mostrar();
		}
	}
?>
