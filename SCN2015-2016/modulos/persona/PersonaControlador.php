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
Hector Zea                    15oct        Entrega del primer avance
Leonardo Camacaro              15oct        Entrega del primer avance
*/

    require_once("modulos/persona/modelo/serviciopersona.php");
	require_once("negocio/PersonaClase.php");

	/*Persona Controlador:
	Esta clase permite el manejo de todas las funciones del modulo
	Persona, comenzando con una funcion manejadora de requerimientos
	que se llama desde la principal vista, si es NULL automaticamente
	se irá al listar persona*/

	class PersonaControlador{

		/**Funcion encargada de manejar todos los servicios
		o requerimientos del sistema*/
		public static function manejarRequerimiento(){
			$accion = PostGet::obtenerPostGet('m_accion');
			if($accion == null)
				$accion = 'listar';				
			else if($accion == 'listar')
				self::listar();			
			else if($accion == 'agregar')
				self::agregar();			
			else if($accion == 'modificar')
				self::modificar();
			else if ($accion == 'agregarTrayecto')
				self::agregarTrayecto();
			else if($accion == 'eliminar')
				self::eliminar();
			else if($accion == 'buscarPersonaCedula')
				self::buscarPersonaCedula();	
			else
			throw new Exception("(PersonaControlador) Acción $accion no es válida");
		}

		/** Funcion encargada de manejar el servicio de reporte
		de persona en la base de datos*/
		public static function listar(){
			try{
				$patron = PostGet::obtenerPostGet('patron');
				$r = ServicioPersona::listarPersona($patron);
				Vista::asignarDato('persona',$r);
				Vista::asignarDato('estatus',1);
				Vista::mostrar();				
			}catch(Exception $e)
			{throw $e;}
		}
		
		public static function agregarTrayecto()
		{
			try
			{
				$trayecto = new Trayecto ();
				$trayecto->asignarCodPensum(PostGet::obtenerPostGet('codigoPensum'));
				$trayecto->asignarCodigo(PostGet::obtenerPostGet('codigoTrayecto'));
				$trayecto->asignarNumero(PostGet::obtenerPostGet('numeroTrayecto'));
				$trayecto->asignarCertificado(PostGet::obtenerPostGet('certificadoTrayecto'));
				$trayecto->asignarMinCredito(PostGet::obtenerPostGet('minCreditoTrayecto'));			
				 $r = PensumServicio::agregarTrayecto($trayecto);
				 var_dump($r);
			}catch (Exception $e) {throw $e;}
		} 
		
		

		/*funcion encarga de agregar una persona al sistema
		los datos traidos por POST desde el formulario.
		luego son asignados el objeto persona
		si los datos vienen vacios desde el formulario
		automaticamente se les asignará null*/
		public static function agregar(){
			try{
				$persona = new Persona();
				$persona->asignarCedula(PostGet::obtenerPostGet('cedula'));
				$persona->asignarRif(PostGet::obtenerPostGet('rif'));
				if (PostGet::obtenerPostGet('rif') === '')
				$persona->asignarRif(null);
				$persona->asignarNombre1(serviciopersona::acomodarCadena(PostGet::obtenerPostGet('nombre1')));
				$persona->asignarNombre2(serviciopersona::acomodarCadena(PostGet::obtenerPostGet('nombre2')));
				if (PostGet::obtenerPostGet('nombre2') === '')
				$persona->asignarNombre2(null);
				$persona->asignarApellido1(serviciopersona::acomodarCadena(PostGet::obtenerPostGet('apellido1')));
				$persona->asignarApellido2(serviciopersona::acomodarCadena(PostGet::obtenerPostGet('apellido2')));
				if (PostGet::obtenerPostGet('apellido2') === '')
				$persona->asignarApellido2(null);
				$persona->asignarSexo(PostGet::obtenerPostGet('sexo'));
				$persona->asignarFecNacimiento(PostGet::obtenerPostGet('fec_nacimiento'));
				if (PostGet::obtenerPostGet('fec_nacimiento') === '')
				$persona->asignarFecNacimiento(null);
				$persona->asignarTipSangre(PostGet::obtenerPostGet('tip_sangre'));
				if (PostGet::obtenerPostGet('tip_sangre') === '')
				$persona->asignarTipSangre(null);
				$persona->asignarTelefono1(PostGet::obtenerPostGet('telefono1'));
				if (PostGet::obtenerPostGet('telefono1') === '')
				$persona->asignarTelefono1(null);
				$persona->asignarTelefono2(PostGet::obtenerPostGet('telefono2'));
				if (PostGet::obtenerPostGet('telefono2') === '')
				$persona->asignarTelefono2(null);
				$persona->asignarCorreoPersonal(PostGet::obtenerPostGet('cor_personal'));
				if (PostGet::obtenerPostGet('cor_personal') === '')
				$persona->asignarCorreoPersonal(null);
				$persona->asignarCorreoInstitucional(PostGet::obtenerPostGet('cor_institucional'));
				if (PostGet::obtenerPostGet('cor_institucional') === '')
				$persona->asignarCorreoInstitucional(null);
				$persona->asignarDireccion(PostGet::obtenerPostGet('direccion'));
				if (PostGet::obtenerPostGet('direccion') === '')
				$persona->asignarDireccion(null);				
				$r = serviciopersona::agregar($persona);

				Vista::asignarDato('estatus',1);
				Vista::asignarDato('mensaje',"Agregado con éxito.");

				//$mensaje = "Agregado con exito";
				//Vista::asignarDato('mensaje',$mensaje);
				Vista::mostrar();
				//self::listar();
			}catch (Exception $e){
				throw $e;
			}
		}

		/*funcion encargada de eliminar una persona del sistema si no se encuentra
		utilizada por las tablas estudiantes y docentes
		una una persona puede ser estudiante y a la vez docente*/
		public static function eliminar(){		
			try{		
				$r=ServicioPersona::eliminarPorCedula(PostGet::obtenerPostGet('cedula'));
				$mensaje = "Eliminado satisfactoriamente.";
				Vista::asignarDato('mensaje',$mensaje);
				Vista::asignarDato('estatus',1);
				Vista::mostrar();
			}
			catch(Exception $e){
				throw $e;
			}
		}

		/*Fucion que modifica a una persona obteniendo los datos desde ub objeto persona*/
		public static function modificar()
		{
			$persona = new Persona();
			$persona->asignarCedula(PostGet::obtenerPostGet('cedula'));
			$persona->asignarRif(PostGet::obtenerPostGet('rif'));
			if (PostGet::obtenerPostGet('rif') === '')
			$persona->asignarRif(null);
			$persona->asignarNombre1(serviciopersona::acomodarCadena(PostGet::obtenerPostGet('nombre1')));
			$persona->asignarNombre2(serviciopersona::acomodarCadena(PostGet::obtenerPostGet('nombre2')));
			if (PostGet::obtenerPostGet('nombre2') === '')
			$persona->asignarNombre2(null);
			$persona->asignarApellido1(serviciopersona::acomodarCadena(PostGet::obtenerPostGet('apellido1')));
			$persona->asignarApellido2(serviciopersona::acomodarCadena(PostGet::obtenerPostGet('apellido2')));
			if (PostGet::obtenerPostGet('apellido2') === '')
			$persona->asignarApellido2(null);
			$persona->asignarSexo(PostGet::obtenerPostGet('sexo'));
			$persona->asignarFecNacimiento(PostGet::obtenerPostGet('fec_nacimiento'));
			if (PostGet::obtenerPostGet('fec_nacimiento') === '')
			$persona->asignarFecNacimiento(null);
			$persona->asignarTipSangre(PostGet::obtenerPostGet('tip_sangre'));
			if (PostGet::obtenerPostGet('tip_sangre') === '')
			$persona->asignarTipSangre(null);
			$persona->asignarTelefono1(PostGet::obtenerPostGet('telefono1'));
			if (PostGet::obtenerPostGet('telefono1') === '')
			$persona->asignarTelefono1(null);
			$persona->asignarTelefono2(PostGet::obtenerPostGet('telefono2'));
			if (PostGet::obtenerPostGet('telefono2') === '')
			$persona->asignarTelefono2(null);
			$persona->asignarCorreoPersonal(PostGet::obtenerPostGet('cor_personal'));
			if (PostGet::obtenerPostGet('cor_personal') === '')
			$persona->asignarCorreoPersonal(null);
			$persona->asignarCorreoInstitucional(PostGet::obtenerPostGet('cor_institucional'));
			if (PostGet::obtenerPostGet('cor_institucional') === '')
			$persona->asignarCorreoInstitucional(null);
			$persona->asignarDireccion(PostGet::obtenerPostGet('direccion'));
			if (PostGet::obtenerPostGet('direccion') === '')
			$persona->asignarDireccion(null);	
			$r = ServicioPersona::modificar($persona);
			$mensaje = "Modificado con exito";
			Vista::asignarDato('mensaje',$mensaje);
			Vista::asignarDato('estatus',1);
			Vista::mostrar();														
		}

		/*Fucion que busca una persona en la base de datos pasando por parametro la cedula unica que corresponda*/
		public static function buscarPersonaCedula(){
			try{
				$r=ServicioPersona::obtenerPorCedula(PostGet::obtenerPostGet('cedula'));
				Vista::asignarDato('persona',$r);
				$mensaje = "No se encontrò la info";
				Vista::asignarDato('mensaje',$mensaje);
				Vista::asignarDato('estatus',1);

				Vista::mostrar();
			}
			catch(Exception $e){
				throw $e;
			}
		}
	}
?>
