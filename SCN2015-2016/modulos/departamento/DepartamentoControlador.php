<?php
/*
 * * * * * * * * * * LICENCIA * * * * * * * * * * * * * * * * * * * * *

Copyright(C) 2012
pensum Universtiario de Tecnología Dr. Federico Rivero Palacio

Este programa es Software Libre y usted puede redistribuirlo y/o modificarlo
bajo los términos de la versión 3.0 de la Licencia Pública General (GPLv3)
publicada por la Free Software Foundation (FSF), es distribuido sin ninguna
garantía. Usted debe haber recibido una copia de la GPLv3 junto con este
programa, sino, puede encontrarlo en la página web de la FSF, 
específicamente en la dirección http://www.gnu.org/licenses/gpl-3.0.html

 * * * * * * * * * * ARCHIVO * * * * * * * * * * * * * * * * * * * * *

Nombre: DepartamentoControlador.php
Diseñador:Jhonny Vielma.
Programador:Jhonny Vielma.
Fecha:octubre del 2014 
Descripción:  
	Este es el controlador del módulo curso, permite manejar las 
	operaciones relacionadas con los cursos (agregar, modificar,
	eliminar, consultar y buscar) además de las relacionadas
	con los estudiantes de los cursos(agregar, modificar,eliminar,
	consultar, buscar),es el intermediario entre la base de datos y la vista. 
	
	


 * * * * * * * * Cambios/Mejoras/Correcciones/Revisiones * * * * * * * *
Diseñador - Programador /   Fecha   / Descripción del cambio
   

 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/

//require_once "negocio/Departamento.php";
//Clase que permite la comunicación con la base de datos
require_once  "modulos/departamento/modelo/DepartamentoServicio.php";

class DepartamentoControlador {
	
	
	
	public static function manejarRequerimiento(){
		try {
			//permite obtener la acción a realizar en este módulo
			$accion = PostGet::obtenerPostGet('m_accion');

			
			//Acciones de departamento
			if (!$accion) 
				$accion = 'listar';
			
			if ($accion == 'listar') 			self::listar();	
			else if ($accion == 'preAgregar')	self::agregar();
			else if ($accion == 'agregar') 		self::agregar();		
			else if ($accion == 'preModificar') self::modificar();			
			else if ($accion == 'modificar') 	self::modificar();
			else if ($accion == 'mostrar')		self::mostrar();	
			else if ($accion == 'eliminar') 	self::eliminar();
			
			//Aciones de estudiantes del curso
			else if ($accion == 'listarPI')		self::listarPorInstituto();	
			else
				throw new Exception ("acción inválida en el controlador del Departamento: ".$accion);
		}catch (Exception $e){
				throw $e;
		}
	}
	
	
/*función que permite listar los cursos de un periodo académico en específico.
	 obtiene el código del periodo académico de la vista y llama al servicio de curso 
	 a la función obtenerPorPeriodoAcademico(código del periodo académico) y abrirá la vista listar curso
	 correspondiente.
		Parámetros de entrada:
			Ninguno.
		Valores de salida:
			Ninguno.
*/
		static function listarPorInstituto() {
			try{
				$codInstituto = PostGet::obtenerPostGet('codInstituto');
			
				$departamentos=DepartamentoServicio::obtenerPorInstituto($codInstituto)	;
				
				if ($departamentos){
					Vista::asignarDato('departamentos',$departamentos);	
					Vista::asignarDato('estatus',1);	
				}
				else {
					$mensaje="no hay departamentos en este instituto";
					Vista::asignarDato('mensaje',$mensaje);
				}
				Vista::mostrar();
			}catch(Exception $e){
				throw $e;
			}
		
		}

	
}
