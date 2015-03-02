<?php
require_once "negocio/Pensum.clase.php";
require_once "negocio/Trayecto.clase.php";
require_once "negocio/UniCurricular.clase.php";


class TrayectoServicio
{	
	private static function obtenerMayorCodigoTrayecto(){
		try {
			$conexion = Conexion::conectar();
			$consulta = "select coalesce (max(codigo),0) from sis.t_trayecto";
			$ejecutar = $conexion->query($consulta);
			$consulta=$ejecutar->fetchAll();
			return $consulta [0][0];  				
		}catch(Exception $e){
		throw $e;
		}						
	}

	public static function obtenerTrayectosPorCodigoPensum($codPensum)
	{
		try{
				$conexion = Conexion::conectar();
				
				$consulta = "select pen.*,tray.* from sis.t_pensum as pen
							inner join sis.t_trayecto as tray on pen.codigo = tray.cod_pensum
							where pen.codigo=?
							order by num_trayecto";				
				$ejecutar = $conexion->prepare($consulta);
				
				$ejecutar->execute(array($codPensum));
				
				if($ejecutar->rowCount() != 0)
					return $ejecutar->fetchAll();
				else
					return null;
			}
			catch(Exception $e){
				throw $e;
			}
		}

	public static function eliminarTrayecto($codigo,$numtray)
	{
		try{
				$conexion = Conexion::conectar();
				$ejecutar = $conexion->prepare("delete from sis.t_trayecto where cod_pensum=? and num_trayecto=?");							
				$ejecutar->execute(array ($codigo,
										  $numtray) );	
				if ($ejecutar->rowCount()== 0)
				throw new Exception ("Error al eliminar trayecto por codigo ");
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
	public static function buscarTrayecto($trayecto)
	{
		try
		{
			$conexion = Conexion::conectar();
			$ejecutar = $conexion->prepare("select * from sis.t_trayecto where cod_pensum=? and num_trayecto=?");							
			$ejecutar->execute(array ($trayecto->obtenerCodPensum(),
									  $trayecto->obtenerNumero()));
			$lista=($ejecutar->fetchAll());							
			if ($ejecutar->rowCount()==0)
				throw new Exception ("Error en la busqueda de Trayecto");		
			else 
				return $lista;
		}
		catch (Exception $e) {throw $e;}
	}
	
	public static function agregarTrayecto($trayecto)
	{
		try
		{
			$codigo= self::obtenerMayorCodigoTrayecto () + 1;
			$conexion = Conexion::conectar();	
			$ejecutar=$conexion->prepare("insert into sis.t_trayecto (codigo,cod_pensum,num_trayecto,certificado,min_credito) values (?,?,?,?,?)");
			$ejecutar->execute(array($codigo,
									 $trayecto->obtenerCodPensum(),
									 $trayecto->obtenerNumero(),
									 $trayecto->obtenerCertificado(),
									 $trayecto->obtenerMinCredito()
									 ));
			if ($ejecutar->rowCount()==0)
			throw new Exception ("Error al agregar objeto trayecto");
		}catch(Exception $e){throw $e;}	
	}

	public static function modificarTrayecto($trayecto){
		try{
			$conexion = Conexion::conectar();
			$ejecutar =$conexion->prepare("update sis.t_trayecto set num_trayecto=?,certificado=?,min_credito=? where codigo=?");
			$ejecutar->execute(array(
									 $trayecto->obtenerNumero(),
									 $trayecto->obtenerCertificado(),
								     $trayecto->obtenerMinCredito(),
								     $trayecto->obtenerCodigo(),
								     ));
			if ($ejecutar->rowCount()==0)
				throw new Exception ("Error al modificar trayecto");
		}catch(Exception $e){throw $e;}	
	}	
}
?>
