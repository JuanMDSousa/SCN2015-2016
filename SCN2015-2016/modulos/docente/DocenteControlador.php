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
	    
	require_once("modulos/docente/modelo/serviciodocente.php");
	require_once("negocio/Docente.clase.php");

	class DocenteControlador{

		/*Funcion que se encarga de manejar los requiremientos necesarios para el sistema
		y que luego pasan al servicioDocente para ser manejador por otras funciones*/
		public static function manejarRequerimiento(){
		
			$accion = PostGet::obtenerPostGet('m_accion');
			if($accion == null)
				$accion = 'listar';		
			else if ($accion == 'listar')
				self::listar();
			else if($accion == 'agregarDocente')
				self::agregarDocente();
			else if($accion == 'agregar')
				self::agregar();
			else if ($accion == 'modificar')
				self::modificar();
			else if ($accion == 'retirar')
				self::retirar();
			else if ($accion == 'buscarDocenteCodigo')
				self::buscarDocenteCodigo();
			else if ($accion=='buscarDocentes')
				self::buscarDocentes();
			else if ($accion == 'buscarPersonas')
				self::buscarPersonas();
            else if($accion =='buscarDepartamentos')
				self::buscarDepartamentos();
            else if($accion =='buscarEstado')
				self::buscarEstado();
			else
			throw new Exception("(DocenteControlador) Acción $accion no es válida");
		}	

		/*Funcion que se encarga de listar a los docentes*/
		public static function listar(){
			$r=ServicioDocente::listar(PostGet::obtenerPostGet('patron'));
			Vista::asignarDato('docente',$r);
			Vista::asignarDato('estatus',1);
			Vista::mostrar();
		}

		/*Funcion que se encarga de traer un docente en especifico buscado por su codigo unico*/
		public static function buscarDocenteCodigo(){
			try{		
				$r=ServicioDocente::obtenerPorCodigo(PostGet::obtenerPostGet('codigo'));
			
					Vista::asignarDato('docente',$r);
					Vista::asignarDato('estatus',1);
					Vista::mostrar();
				
			}catch(Exception $e){
			throw $e;
			}
		}



		/*Funcion que retira a un docente, le cambia su estado a "Retirado"*/
		public static function retirar(){
			$r=ServicioDocente::retirarPorCodigo(PostGet::obtenerPostGet('codigo'));	
			Vista::asignarDato('estatus',1);		
			$mensaje = "Docente retirado con exito";
			Vista::asignarDato('mensaje',$mensaje);
			Vista::mostrar();
		}

		/*Funcion que se encarga de buscar a la personas en la base de datos que no son docentes para poder
		ser listados y agregados como nuevos docentes*/
		public static function buscarPersonas(){
			$r=ServicioDocente::buscarPersonas();			
			Vista::asignarDato('docente',$r);
			Vista::asignarDato('estatus',1);
			Vista::mostrar();
		}

		/*Funcion que se encarga de tomar nuevos datos de un docente y modificarlos en la base de datos*/
		public static function modificar(){		
			$docente = new Docente();				
			$docente->asignarCodDpto(PostGet::obtenerPostGet('departamentoDoc2'));	
			$docente->asignarCodEstado(PostGet::obtenerPostGet('estadoDoc2'));

			$r=ServicioDocente::modificarDocente(PostGet::obtenerPostGet('codigo'),$docente);			
			$mensaje = "Docente modificado con exito";
			Vista::asignarDato('mensaje',$mensaje);
			Vista::asignarDato('estatus',1);
			Vista::mostrar();
		}

		public static function buscarDocentes(){
			$patron = PostGet::obtenerPostGet("patron");

			$r=ServicioDocente::buscarDocentes($patron);			
			if ((PostGet::obtenerPostGet('m_formato')=="json")&&(PostGet::obtenerPostGet('tipoB')=="autocompletar")){
				$cad = "[";
				if ($r != null){
					$c = 0;
					foreach ($r as $docente) { 
						if ($c > 0) 
							$cad .= ",";
						$cad .= "{";
						$cad .= '"label": "' . $docente['nombre1']. ' ' . $docente['apellido1'] . '", ';
						$cad .= '"value": '.$docente['codigo'];
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
				Vista::asignarDato("docentes",$r);
				Vista::asignarDato("estatus",1);
			}
			Vista::mostrar();
		}

		/*Funcion que se encarga de agregar un nuevo docente a la base de datos mediante un objeto docente*/
		public static function agregar(){
			try{
				$docente = new Docente();				
				$docente->asignarCodDpto(PostGet::obtenerPostGet('departamentoDoc2'));	
					$docente->asignarNumEmpleado(PostGet::obtenerPostGet('numeroEmpleadoDoc2'));
				if (PostGet::obtenerPostGet('numeroEmpleadoDoc2') == '')
				$docente->asignarNumEmpleado(null);		
				$docente->asignarCodEstado(PostGet::obtenerPostGet('estadoDoc2'));							
				$r = ServicioDocente::agregarO($docente);				
				$mensaje = "Docente Agregado con exito";
				Vista::asignarDato('mensaje',$mensaje);
				Vista::asignarDato('estatus',1);
				Vista::mostrar();
			}catch (Exception $e){
			throw $e;
			}
		}

		public static function agregarDocente()
		{
			try{
				$docente = new Docente();				
				$docente->asignarCodDpto(PostGet::obtenerPostGet('departamentoDoc2'));	
					$docente->asignarNumEmpleado(PostGet::obtenerPostGet('numeroEmpleadoDoc2'));
				if (PostGet::obtenerPostGet('numeroEmpleadoDoc2') == '')
				$docente->asignarNumEmpleado(null);		
				$docente->asignarCodEstado(PostGet::obtenerPostGet('estadoDoc2'));
				$docente->asignarCodigo(PostGet::obtenerPostGet('selectNombre'));						
				$r = ServicioDocente::agregarDocente($docente);				
				$mensaje = "Docente Agregado con exito";
				Vista::asignarDato('mensaje',$mensaje);
				Vista::asignarDato('estatus',1);
				Vista::mostrar();
			}catch (Exception $e){
			throw $e;
			}

		}
        
        public static function buscarDepartamentos(){
			$r=ServicioDocente::buscarDepartamentos();			
			Vista::asignarDato('docente',$r);
			Vista::asignarDato('estatus',1);
			Vista::mostrar();
		}
        
        public static function buscarEstado(){
			$r=ServicioDocente::buscarEstado();			
			Vista::asignarDato('docente',$r);
			Vista::asignarDato('estatus',1);
			Vista::mostrar();
		}
	}
?>








