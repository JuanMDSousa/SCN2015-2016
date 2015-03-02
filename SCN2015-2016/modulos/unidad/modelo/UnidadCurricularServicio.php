<?php
require_once "negocio/Pensum.clase.php";
require_once "negocio/Trayecto.clase.php";
require_once "negocio/UniCurricular.clase.php";


class UnidadServicio
{
	private static function obtenerMayorCodigoUniCurricular(){
		try {
			$conexion = Conexion::conectar();
			$consulta = "select coalesce (max(codigo),0) from sis.t_uni_curricular";
			$ejecutar = $conexion->query($consulta);
			$consulta=$ejecutar->fetchAll();
			return $consulta [0][0];  				
		}catch(Exception $e){
		throw $e;
		}						
	}
	
	private static function obtenerMayorCodigoPrelacion(){
		try {
		$conexion = Conexion::conectar();
		$consulta = "select coalesce (max(codigo),0) from sis.t_prelacion";
		$ejecutar = $conexion->query($consulta);
		$consulta=$ejecutar->fetchAll();
		return $consulta [0][0];
		}catch(Exception $e){
		throw $e;
		}
	}


	public static function listarUnidadesPorTrayecto($codTrayecto){
			try{
				$conexion=Conexion::conectar();
				$consulta="select * from sis.t_uni_curricular where cod_trayecto=?";
				$ejecutar=$conexion->prepare($consulta);
				$ejecutar->execute(array($codTrayecto));
				if($ejecutar->rowCount()!=0){
					return $ejecutar->fetchAll();
				
				}else 
					return null;
			}catch (Exception $e){
				throw $e;	
			}
		}

	public static function eliminarUnidadCurricular($codigo)
	{
		try{
				$conexion = Conexion::conectar();
				$ejecutar = $conexion->prepare("delete from sis.t_uni_curricular where codigo= ?");							
				$ejecutar->execute(array ($codigo) );	
				if ($ejecutar->rowCount()== 0)
				throw new Exception ("Error al eliminar unidad curricular por codigo ");
			}catch(Exception $e){
			throw $e;
			}	
	}

		public static function eliminarUnidadesPorTrayecto($codigo)
	{
		try{
				$conexion = Conexion::conectar();
				$ejecutar = $conexion->prepare("delete from sis.t_uni_curricular where cod_trayecto= ?");							
				$ejecutar->execute(array($codigo) );	
				if ($ejecutar->rowCount()== 0)
				throw new Exception ("Error al eliminar unidades curriculares del trayecto");
			}catch(Exception $e){
			throw $e;
			}	
	}	

		public static function modificarUnidadCurricular($UniCurricular){
		try{		
			$conexion = Conexion::conectar();	
			$ejecutar=$conexion->prepare("update sis.t_uni_curricular set cod_uni_ministerio=?,cod_trayecto=?,nombre=?,cod_tipo=?,hta=?,hti=?,uni_credito=?,dur_semanas=?,not_min_aprobatoria=?,not_maxima=? where codigo=?");
			$ejecutar->execute(array(
									 $UniCurricular->obtenerCodUnidad(),
									 $UniCurricular->obtenerCodTrayecto(),
									 $UniCurricular->obtenerNombre(),
									 $UniCurricular->obtenerTipo(),
									 $UniCurricular->obtenerHta(),
									 $UniCurricular->obtenerHti(),
									 $UniCurricular->obtenerUniCredito(),
									 $UniCurricular->obtenerDurSemana(),
									 $UniCurricular->obtenerNotMinima(),
									 $UniCurricular->obtenerNotMaxima(),
									 $UniCurricular->obtenerCodigo()));
			if ($ejecutar->rowCount()==0)
			throw new Exception ("Error al modificar Unidad Curricular");
		}catch(Exception $e){throw $e;}			
	}
	
	public static function buscarCodigoUnidadCurricular(){
		try {
				$conexion = Conexion::conectar();
				$consulta = "select * from sis.t_tip_uni_curricular";
				$ejecutar = $conexion->query($consulta);
				$lista=$ejecutar->fetchAll();				
				if($ejecutar->rowCount()!=0)
				return $lista;
				else
				return NULL;			
			}catch(Exception $e){
			throw $e;
			}		
	}

	public static function agregarUnidadCurricular($UniCurricular){
		try{
			$codigo= self::obtenerMayorCodigoUniCurricular()+1;
			$conexion = Conexion::conectar();	
			$ejecutar=$conexion->prepare("insert into sis.t_uni_curricular 
										(codigo,cod_uni_ministerio,cod_trayecto,nombre,cod_tipo,hta,hti,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima) 
										values(?,?,?,?,?,?,?,?,?,?,?)");
			$ejecutar->execute(array($codigo,
									 $UniCurricular->obtenerCodUnidad(),
									 $UniCurricular->obtenerCodTrayecto(),
									 $UniCurricular->obtenerNombre(),
									 $UniCurricular->obtenerTipo(),
									 $UniCurricular->obtenerHta(),
									 $UniCurricular->obtenerHti(),
									 $UniCurricular->obtenerUniCredito(),
									 $UniCurricular->obtenerDurSemana(),
									 $UniCurricular->obtenerNotMinima(),
									 $UniCurricular->obtenerNotMaxima()
									 ));
			if ($ejecutar->rowCount()==0)
			throw new Exception ("Error al agregar Unidad Curricular");
		}catch(Exception $e){throw $e;}			
	}	

	public static function agregarPrelacion($uniCurricularPrelada){
		try{
		$codPrelacion= self::obtenerMayorCodigoPrelacion()+1;
		$codUnidadCurricular= self::obtenerMayorCodigoUniCurricular();
		$conexion = Conexion::conectar();
		$ejecutar=$conexion->prepare("insert into sis.t_prelacion (codigo,cod_uni_curricular,cod_uni_cur_prelada) values(?,?,?)");
		$ejecutar->execute(array($codPrelacion,
								$codUnidadCurricular,
								$uniCurricularPrelada));
		if ($ejecutar->rowCount()==0)
		throw new Exception ("Error al guardar tabla prelacion");
		}catch(Exception $e){throw $e;}
	}

	public static function verUnidadCurricular($codigo)
	{
		try
		{
			$conexion = Conexion::conectar();
			$ejecutar = $conexion->prepare("select *, 
											uc.codigo as cod_unidad,
											uc.nombre as nombre_unidad,
											tipo.nombre as nombre_tipo, tipo.codigo as cod_tipo
											from sis.t_uni_curricular as UC
											join sis.t_tip_uni_curricular as tipo
											on UC.cod_tipo=tipo.codigo
											where uc.codigo=?
											");							
			$ejecutar->execute(array ($codigo));
			$lista=($ejecutar->fetchAll());							
			if ($ejecutar->rowCount()==0)
			throw new Exception ("No existe pensum con el codigo: ".$codigo);		
			else 
			return $lista;
		}
		catch (Exception $e) {throw $e;}
	}
	public static function listarPrelacion($codigo,$numTrayecto)
	{
		try
		{
			$conexion = Conexion::conectar();
			$ejecutar = $conexion->prepare("select curricular.* from sis.t_uni_curricular as curricular 
											inner join sis.t_trayecto as trayecto on curricular.cod_trayecto=trayecto.codigo
											where trayecto.cod_pensum=? and
											trayecto.num_trayecto=?");							
			$ejecutar->execute(array ($codigo,$numTrayecto));
			$lista=($ejecutar->fetchAll());							
			if ($ejecutar->rowCount()==0)
			throw new Exception ("No existe la prelacion con este codigo");		
			else 
			return $lista;
		}
		catch (Exception $e) {throw $e;}
	}
	public static function buscarPrelacionUnidadCurricular($codigo)
	{
		try{
			$conexion = Conexion::conectar();
			$ejecutar = $conexion->prepare("select * from sis.t_prelacion where cod_uni_curricular=?");							
			$ejecutar->execute(array ($codigo));
			$lista=($ejecutar->fetchAll());							
			if ($ejecutar->rowCount()==0)
			throw new Exception ("No existe la prelacion con este codigo");		
			else 
			return $lista;
		}
		catch (Exception $e) {throw $e;}
	}
	public static function eliminarPrelacion($unidadCurricular,$uniCurricularPrelada){
		try{
		$conexion = Conexion::conectar();
		$ejecutar=$conexion->prepare("delete from sis.t_prelacion where cod_uni_curricular=? and cod_uni_cur_prelada=?");
		$ejecutar->execute(array($unidadCurricular,
								$uniCurricularPrelada));
		if ($ejecutar->rowCount()==0)
		throw new Exception ("Error al eliminar tabla prelacion");
		}catch(Exception $e){throw $e;}
	}

	public static function agregarPrelacionModificar($unidadCurricular,$uniCurricularPrelada){
		try{
		$codPrelacion= self::obtenerMayorCodigoPrelacion()+1;
		$conexion = Conexion::conectar();
		$ejecutar=$conexion->prepare("insert into sis.t_prelacion (codigo,cod_uni_curricular,cod_uni_cur_prelada) values(?,?,?)");
		$ejecutar->execute(array($codPrelacion,
								$unidadCurricular,
								$uniCurricularPrelada));
		if ($ejecutar->rowCount()==0)
		throw new Exception ("Error al guardar tabla prelacion");
		}catch(Exception $e){throw $e;}
	}
}
?>
