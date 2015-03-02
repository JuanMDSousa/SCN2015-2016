<?php
	require_once("modulos/unidad/modelo/UnidadCurricularServicio.php");
	require_once("negocio/Pensum.clase.php");
	require_once("negocio/Trayecto.clase.php");
	require_once("negocio/UniCurricular.clase.php");


	class  UnidadControlador
	{
		public static function manejarRequerimiento(){		
		
				//permite obtener la acción a realizar en este módulo
				$accion = PostGet::obtenerPostGet('m_accion');
	
			   	if ($accion == 'listarUnidadesPorTrayecto') 	
					self::listarUnidadesPorTrayecto();									
				else if ($accion == 'eliminarUnidadCurricular')
					self::eliminarUnidadCurricular();
				else if ($accion == 'buscarCodigoUnidadCurricular')
					self::buscarCodigoUnidadCurricular();				
				else if ($accion == 'agregarUnidadCurricular')					
					self::agregarUnidadCurricular();
				else if ($accion == 'agregarPrelacion')					
					self::agregarPrelacion();
				else if ($accion =='verUnidadCurricular')
					self::verUnidadCurricular();
				else if ($accion =='modificarUnidadCurricular')
					self::modificarUnidadCurricular();			
				else if ($accion =='listarPrelacion')
					self::listarPrelacion();
				else if ($accion =='buscarPrelacionUnidadCurricular')
					self::buscarPrelacionUnidadCurricular();
				else if ($accion =='eliminarPrelacion')
					self::eliminarPrelacion();
				else if ($accion == 'agregarPrelacionModificar')				
					self::agregarPrelacionModificar();
				else
				throw new Exception ("(PensumControlador) Accion $accion no es valida");	
		}

		public static function modificarUnidadCurricular(){
			try{
				$UniCurricular=new UniCurricular();
				$UniCurricular->asignarCodigo(PostGet::obtenerPostGet('codigo'));
				$UniCurricular->asignarCodUnidad(PostGet::obtenerPostGet('codMinisterio'));
				$UniCurricular->asignarCodTrayecto(PostGet::obtenerPostGet('codTrayecto'));
				$UniCurricular->asignarNombre(PostGet::obtenerPostGet('nombreUC'));				
				$UniCurricular->asignarTipo(PostGet::obtenerPostGet('tipoUnidadCurricular'));
				$UniCurricular->asignarHta(PostGet::obtenerPostGet('hta'));
				$UniCurricular->asignarHti(PostGet::obtenerPostGet('hti'));
				$UniCurricular->asignarUniCredito(PostGet::obtenerPostGet('unidadesCredito'));
				$UniCurricular->asignarDurSemana(PostGet::obtenerPostGet('duracionSemanas'));
				$UniCurricular->asignarNotMinima(PostGet::obtenerPostGet('notaMinima'));
				$UniCurricular->asignarNotMaxima(PostGet::obtenerPostGet('notaMaxima'));
				$mensaje="se ha Modificado la unidad curricular";
				$r=UnidadServicio::modificarUnidadCurricular($UniCurricular);
				Vista::asignarDato('mensaje',$mensaje);
				Vista::asignarDato('estatus',1);
				Vista::mostrar();
			}
			catch (Exception $e) {throw $e;}
		}


		static function listarUnidadesPorTrayecto(){
			try{
				$codTrayecto=PostGet::obtenerPostGet('codTrayecto');
				$unidades=UnidadServicio::listarUnidadesPorTrayecto($codTrayecto);
				$mensaje="Unidades";
				Vista::asignarDato('unidades',$unidades);
				Vista::asignarDato('mensaje',$mensaje);
				Vista::asignarDato('estatus',1);
				Vista::mostrar();
			}catch(Exception $e){
				throw $e;
			}
		}		
		
		public static function eliminarUnidadCurricular()
		{
			try
			{
				$r=UnidadServicio::eliminarUnidadCurricular(PostGet::obtenerPostGet('codigo'));
				$mensaje="Unidad Curricular Eliminada";
				Vista::asignarDato('pensum',$r);
				Vista::asignarDato('mensaje',$mensaje);
				Vista::asignarDato('estatus',1);
				Vista::mostrar();
			}
			catch (Exception $e){throw $e;}
		}
		
		public static function buscarCodigoUnidadCurricular(){
			try
			{
				$r=UnidadServicio::buscarCodigoUnidadCurricular();
				$mensaje="Codigo";
				Vista::asignarDato('pensum',$r);
				Vista::asignarDato('mensaje',$mensaje);
				Vista::asignarDato('estatus',1);
				Vista::mostrar();
			}
			catch (Exception $e) {throw $e;}
		}

		public static function agregarUnidadCurricular(){
			try{
				$UniCurricular=new UniCurricular();
				$UniCurricular->asignarCodUnidad(PostGet::obtenerPostGet('codMinisterio'));
				$UniCurricular->asignarNombre(PostGet::obtenerPostGet('nombreUC'));
				$UniCurricular->asignarCodTrayecto(PostGet::obtenerPostGet('codTrayecto'));
				$UniCurricular->asignarTipo(PostGet::obtenerPostGet('tipoUnidadCurricular'));
				$UniCurricular->asignarHta(PostGet::obtenerPostGet('hta'));
				$UniCurricular->asignarHti(PostGet::obtenerPostGet('hti'));
				$UniCurricular->asignarUniCredito(PostGet::obtenerPostGet('unidadesCredito'));
				$UniCurricular->asignarDurSemana(PostGet::obtenerPostGet('duracionSemanas'));
				$UniCurricular->asignarNotMinima(PostGet::obtenerPostGet('notaMinima'));
				$UniCurricular->asignarNotMaxima(PostGet::obtenerPostGet('notaMaxima'));
				$r=UnidadServicio::agregarUnidadCurricular($UniCurricular);
				$mensaje="Unidad Curricular Agregada";
				Vista::asignarDato('pensum',$r);
				Vista::asignarDato('mensaje',$mensaje);
				Vista::asignarDato('estatus',1);
				Vista::mostrar();
			}
			catch (Exception $e) {throw $e;}
		}

		public static function agregarPrelacion(){
			try{
				$unidadCurricularPrelada=PostGet::obtenerPostGet('unidadCurricularPrelada');
				$r=UnidadServicio::agregarPrelacion($unidadCurricularPrelada);
				$mensaje="Prelacion Agregada";
				Vista::asignarDato('pensum',$r);
				Vista::asignarDato('mensaje',$mensaje);
				Vista::asignarDato('estatus',1);
				Vista::mostrar();
			}
			catch (Exception $e) {throw $e;}
		}

		public static function verUnidadCurricular()
		{
			try{
				$r=UnidadServicio::verUnidadCurricular(PostGet::obtenerPostGet('codigo'));
				$mensaje="Unidad Curricular";
				Vista::asignarDato('pensum',$r);
				Vista::asignarDato('mensaje',$mensaje);
				Vista::asignarDato('estatus',1);
				Vista::mostrar();
			}
			catch (Exception $e) {throw $e;}	
		}
		public static function listarPrelacion()
		{
			try{
				$r=UnidadServicio::listarPrelacion(PostGet::obtenerPostGet('codigo'),PostGet::obtenerPostGet('numtray'));
				$mensaje="Prelaciones";
				Vista::asignarDato('pensum',$r);
				Vista::asignarDato('mensaje',$mensaje);
				Vista::asignarDato('estatus',1);
				Vista::mostrar();
			}
			catch (Exception $e) {throw $e;}	
		}
		
		public static function buscarPrelacionUnidadCurricular()
		{
			try{
				$r=UnidadServicio::buscarPrelacionUnidadCurricular(PostGet::obtenerPostGet('codigo'));
				$mensaje="Prelacion de Unidad Curricular";
				Vista::asignarDato('mensaje',$mensaje);
				Vista::asignarDato('pensum',$r);
				Vista::asignarDato('estatus',1);
				Vista::mostrar();
			}
			catch (Exception $e) {throw $e;}	
		}

		public static function eliminarPrelacion(){
			try{
				$unidadCurricularPrelada=PostGet::obtenerPostGet('codigoPrelada');
				$unidadCurricular=PostGet::obtenerPostGet('codigoUnidad');
				$r=UnidadServicio::eliminarPrelacion($unidadCurricular,$unidadCurricularPrelada);
				$mensaje="Prelacion Eliminada";
				Vista::asignarDato('pensum',$r);
				Vista::asignarDato('mensaje',$mensaje);
				Vista::asignarDato('estatus',1);
				Vista::mostrar();
			}
			catch (Exception $e) {throw $e;}
		}

		public static function agregarPrelacionModificar(){
			try{
				$unidadCurricularPrelada=PostGet::obtenerPostGet('codigoPrelada');
				$unidadCurricular=PostGet::obtenerPostGet('codigoUnidad');
				$r=UnidadServicio::agregarPrelacionModificar($unidadCurricular,$unidadCurricularPrelada);
				$mensaje="Prelacion Agregada";
				Vista::asignarDato('pensum',$r);
				Vista::asignarDato('mensaje',$mensaje);
				Vista::asignarDato('estatus',1);
				Vista::mostrar();
			}
			catch (Exception $e) {throw $e;}
		}

	}
?>