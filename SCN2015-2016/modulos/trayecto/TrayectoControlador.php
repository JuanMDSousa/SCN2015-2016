<?php
	require_once("modulos/trayecto/modelo/TrayectoServicio.php");
	require_once("negocio/Pensum.clase.php");
	require_once("negocio/Trayecto.clase.php");
	require_once("negocio/UniCurricular.clase.php");


	class  TrayectoControlador{
		public static function manejarRequerimiento(){		
				$accion = PostGet::obtenerPostGet('m_accion');	
				if ($accion =='agregarTrayecto')
					self::agregarTrayecto();
				else if ($accion == 'verTrayecto')
					self::verTrayecto();
				else if ($accion == 'modificarTrayecto')
					self::modificarTrayecto();				
				else if ($accion == 'eliminarTrayecto')
					self::eliminarTrayecto();
				else if ($accion == 'eliminarUnidadesPorTrayecto')
					self::eliminarUnidadesPorTrayecto();				
				else if ($accion == 'verTrayectosPensumPDF')
					self::verTrayectosPensumPDF();
				else
				throw new Exception ("(TrayectoControlador) Accion $accion no es valida");			
		}
		
		public static function verTrayectosPensumPDF()
		{
			try{
				$codPensum = PostGet::obtenerPostGet('codigoPensum');
				$r = TrayectoServicio::obtenerTrayectosPorCodigoPensum($codPensum);
				if($r){
					Vista::asignarDato('estatus',1);
					Vista::asignarDato('pensum',$r);
				}
				else{
					Vista::asignarDato("mensaje", "No se puede ver en PDF.");
				}
				Vista::mostrar();
			}catch(Exception $e){
				throw $e;
			}
		}
		public static function eliminarTrayecto()
		{
			try
			{
				$codigopen=PostGet::obtenerPostGet('codigo');
				$numtray=PostGet::obtenerPostGet('numtray');
				$r=TrayectoServicio::eliminarTrayecto($codigopen,$numtray);
				$mensaje = "Trayecto Eliminado";
				Vista::asignarDato('mensaje',$mensaje);
				Vista::asignarDato('pensum',$r);
				Vista::asignarDato('estatus',1);
				Vista::mostrar();
			}
			catch (Exception $e){throw $e;}
		}

		public static function eliminarUnidadesPorTrayecto()
		{
			try
			{
				$r=TrayectoServicio::eliminarUnidadesPorTrayecto(PostGet::obtenerPostGet('codigo'));
				$mensaje = "Unidades Curriculares Eliminadas";
				Vista::asignarDato('mensaje',$mensaje);
				Vista::asignarDato('pensum',$r);
				Vista::asignarDato('estatus',1);
				Vista::mostrar();
			}
			catch (Exception $e){throw $e;}
		}
		
		public static function agregarTrayecto()
		{
			try
			{
				$trayecto = new Trayecto ();				
				$trayecto->asignarCodPensum(PostGet::obtenerPostGet('codigo'));
				$trayecto->asignarNumero(PostGet::obtenerPostGet('num_trayecto'));
				$trayecto->asignarCertificado(PostGet::obtenerPostGet('certificado'));
				$trayecto->asignarMinCredito(PostGet::obtenerPostGet('min_credito'));							
				$r=TrayectoServicio::agregarTrayecto($trayecto);
				$mensaje="Trayecto Agregado";
				Vista::asignarDato('pensum',$r);
				Vista::asignarDato('estatus',1);
				Vista::asignarDato('mensaje',$mensaje);
				Vista::mostrar();
				 
			}catch (Exception $e) {throw $e;}
		} 

		public static function verTrayecto()
		{
			try{
				$trayecto=new Trayecto();
				$trayecto->asignarCodPensum(PostGet::obtenerPostGet('codigo'));
				$trayecto->asignarNumero(PostGet::obtenerPostGet('numtray'));
				$r=TrayectoServicio::buscarTrayecto($trayecto);
				$mensaje="Trayecto";
				Vista::asignarDato('pensum',$r);
				Vista::asignarDato('estatus',1);
				Vista::asignarDato('mensaje',$mensaje);
				Vista::mostrar();
			}catch (Exception $e) {throw $e;}
		}


		public static function modificarTrayecto()
		{
			try{
				$trayecto=new Trayecto();
				$trayecto->asignarCodigo(PostGet::obtenerPostGet('codigo'));
				$trayecto->asignarNumero(PostGet::obtenerPostGet('num_trayecto'));
				$trayecto->asignarCertificado(PostGet::obtenerPostGet('certificado'));
				$trayecto->asignarMinCredito(PostGet::obtenerPostGet('min_credito'));
				$r=TrayectoServicio::modificarTrayecto($trayecto);
				$mensaje="Trayecto modificado";
				Vista::asignarDato('pensum',$r);
				Vista::asignarDato('estatus',1);
				Vista::asignarDato('mensaje',$mensaje);
				Vista::mostrar();		
			}catch (Exception $e) {throw $e;}
		}

		static function listarUnidadesPorTrayecto(){
			try{
				$codTrayecto=PostGet::obtenerPostGet('codTrayecto');
				$unidades=TrayectoServicio::listarUnidadesPorTrayecto($codTrayecto);
				$mensaje="Unidades";
				Vista::asignarDato('unidades',$unidades);
				Vista::asignarDato('estatus',1);
				Vista::asignarDato('mensaje',$mensaje);
				Vista::mostrar();
			}catch(Exception $e){
				throw $e;
			}
		}
	}
?>