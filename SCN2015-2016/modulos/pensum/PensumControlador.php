<?php
	require_once("modulos/pensum/modelo/PensumServicio.php");
	require_once("negocio/Pensum.clase.php");
	require_once("negocio/Trayecto.clase.php");
	require_once("negocio/UniCurricular.clase.php");


	class  PensumControlador
	{
		public static function manejarRequerimiento(){		
		
				//permite obtener la acción a realizar en este módulo
				$accion = PostGet::obtenerPostGet('m_accion');
	
				//Acciones de curso
				if ($accion == null) 					
					$accion = 'listar';			
				else if ($accion == 'listar') 	
					self::listar();
				else if ($accion == 'agregar')					
					self::agregar();
				else if ($accion == 'listarUnidadesPorTrayecto') 	
					self::listarUnidadesPorTrayecto();
				else if ($accion == 'buscarPensum')
					self::buscarPensum();
				else if ($accion =='modificar')				
					self::modificar();
				else if ($accion =='buscarTrayPen')
					self::buscarTrayPen();			
				else if ($accion == 'eliminar')
					self::eliminar();		
				else if ($accion == 'listarPorDepartamento')
					self::listarPorDepartamento();
				else if ($accion == 'verUnidadesCurricularesTrayectoPDF')
					self::verUnidadesCurricularesTrayectoPDF();	
				else
				throw new Exception ("(PensumControlador) Accion $accion no es valida");
			
		}

		public static function listar(){
			try{
				$patron = PostGet::obtenerPostGet('patron');
				$r = PensumServicio::listarPensum($patron);
				Vista::asignarDato('pensum',$r);
				Vista::asignarDato('estatus',1);
				Vista::mostrar();
			}catch(Exception $e)
			{throw $e;}
		}

		public static function verUnidadesCurricularesTrayectoPDF()
		{
			try{
				
				$codPensum = PostGet::obtenerPostGet('codigoPensum');				
				$codTrayecto= PostGet::obtenerPostGet('codigoTrayecto');
			
				$r = PensumServicio::obtenerUnidadesPorTrayecto($codPensum,$codTrayecto);
				
				if($r){
					Vista::asignarDato('estatus',1);
					Vista::asignarDato('pensum',$r);
				}
				else{
					Vista::asignarDato("mensaje", "Hubo un error");
				}
				Vista::mostrar();
			}catch(Exception $e){
				throw $e;
			}
		}
		public static function agregar()
		{
			try
			{
				$pensum = new Pensum ();
				$pensum->asignarNombre(PostGet::obtenerPostGet('nombre'));			
				$pensum->asignarNombreCorto(PostGet::obtenerPostGet('nom_corto'));			
				$pensum->asignarObservaciones(PostGet::obtenerPostGet('observaciones'));
				if (PostGet::obtenerPostGet('observaciones')==='')
					$pensum->asignarObservaciones(null);
				$r=PensumServicio::agregar($pensum);			
				$mensaje= "Pensum Agregado";
				Vista::asignarDato('pensum',$r);
				Vista::asignarDato('estatus',1);
				Vista::asignarDato('mensaje',$mensaje);
				Vista::mostrar();
			}
			catch (Exception $e) 
			{
				throw $e;
			}
		}

		static function listarUnidadesPorTrayecto(){
			try{
				$codTrayecto=PostGet::obtenerPostGet('codTrayecto');
				$unidades=PensumServicio::listarUnidadesPorTrayecto($codTrayecto);
				Vista::asignarDato('unidades',$unidades);
				$mensaje="Unidades";
				Vista::asignarDato('pensum',$r);
				Vista::asignarDato('estatus',1);
				Vista::asignarDato('mensaje',$mensaje);
				Vista::mostrar();
			}catch(Exception $e){
				throw $e;
			}
		}

		public static function eliminar()
		{
			try
			{
				$r=PensumServicio::eliminarPorCodigo(PostGet::obtenerPostGet('codigo'));
				$mensaje="Pensum Eliminado";
				Vista::asignarDato('pensum',$r);
				Vista::asignarDato('estatus',1);
				Vista::asignarDato('mensaje',$mensaje);
				Vista::mostrar();
			}
			catch (Exception $e){throw $e;}
		}

		public static function buscarPensum()
		{
			try
			{
				$r=PensumServicio::buscarPensum(PostGet::obtenerPostGet('codigo'));
				$mensaje="Pensum";
				Vista::asignarDato('pensum',$r);
				Vista::asignarDato('estatus',1);
				Vista::asignarDato('mensaje',$mensaje);
				Vista::mostrar();
			}
			catch (Exception $e) {throw $e;}
		}

	public static function buscarTrayPen()
		{
			try
			{		
				$r=PensumServicio::buscarTrayPen(PostGet::obtenerPostGet('codigo'));
				$mensaje= "Informaciond de Pensum";
				Vista::asignarDato('pensum',$r);
				Vista::asignarDato('estatus',1);
				Vista::asignarDato('mensaje',$mensaje);									
				Vista::mostrar();
			}
			catch (Exception $e) {throw $e;}
		}


		public static function modificar ()
		{
			try
			{
			 $pensum = new Pensum();
			 $pensum->asignarCodigo(PostGet::obtenerPostGet('codigo'));
			 $pensum->asignarNombre(PostGet::obtenerPostGet('nombre'));
				if (PostGet::obtenerPostGet('nombre')==='')
					$pensum->asignarNombre(null);
				$pensum->asignarNombreCorto(PostGet::obtenerPostGet('nom_corto'));
				if (PostGet::obtenerPostGet('nom_corto')==='')
					$pensum->asignarNombre(null);
				$pensum->asignarObservaciones(PostGet::obtenerPostGet('observaciones'));
				if (PostGet::obtenerPostGet('observaciones')==='')
					$pensum->asignarObservaciones(null);
				$r = PensumServicio::modificar($pensum);
				$mensaje= "Pensum Modificado";
				Vista::asignarDato('pensum',$r);
				Vista::asignarDato('estatus',1);
				Vista::asignarDato('mensaje',$mensaje);;
				Vista::mostrar();		
			}catch (Exception $e) {throw $e;}
		}
		
		public static function listarPorDepartamento(){
			try{
				$r = PensumServicio::listarPorDepartamento(PostGet::obtenerPostGet('codDepartamento'));
				
				if($r != NULL){
					Vista::asignarDato('pensums',$r);
					Vista::asignarDato('estatus',1);
				}
				else{
					Vista::asignarDato('mensaje',"No hay pensums asociados al departamento");
				}
				Vista::mostrar();
			}
			catch (Exception $e){
				throw $e;
			}
		}
	}
?>
