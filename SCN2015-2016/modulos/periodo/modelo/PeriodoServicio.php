<?php
class PeriodoServicio{

public static function cargarTrayectosPorPeriodo($codPeriodo){
			try{
				$conexion=Conexion::conectar();
				$consulta="select tr.* from sis.t_periodo as pe inner join sis.t_trayecto as tr 
											on pe.cod_pensum=tr.cod_pensum 
							where pe.codigo=?";
				$ejecutar=$conexion->prepare($consulta);
				$ejecutar->execute(array($codPeriodo));
				if($ejecutar->rowCount()!=0){
					return $ejecutar->fetchAll();
				
				}else 
					return null;
			}catch (Exception $e){
				throw $e;	
			}


		}
		
	public static function obtenerMax(){
		try{
			$conexion=Conexion::conectar();
			$consulta="select max(codigo) from sis.t_periodo";
			
			$ejecutar=$conexion->prepare($consulta);
			
			$ejecutar->execute(array());
			
			if($ejecutar->rowCount()!=0){
				return $ejecutar->fetchAll()[0][0];
			}else 
				return 0;
		}
		catch(Exception $e){
			throw $e;
		}
	}

	public static function agregarPeriodo($per){
		try{
			$conexion=Conexion::conectar();
			$consulta="insert into sis.t_periodo(	codigo, 
													nombre, 
													cod_departamento, 
													cod_pensum, 
													fec_inicio, 
													fec_final, 
													observaciones, 
													cod_estado) 
						values (?,?,?,?,?,?,?,?)";
			
			$ejecutar=$conexion->prepare($consulta);
			
			$ejecutar->execute(array(	self::obtenerMax() + 1,
										$per->obtenerNombre(),
										$per->obtenerCodDepartamento(),
										$per->obtenerCodPensum(),
										$per->obtenerFecInicio(),
										$per->obtenerFecFinal(),
										$per->obtenerObservaciones(),
										$per->obtenerCodEstado()
									));
		}
		catch(Exception $e){
			throw $e;
		}
	}
	
	public static function modificarPeriodo($per){
		try{
			$conexion=Conexion::conectar();
			$consulta="	update sis.t_periodo set nombre = ?, 
												cod_departamento = ?, 
												cod_pensum = ?, 
												fec_inicio = ?, 
												fec_final = ?, 
												observaciones = ?, 
												cod_estado = ? 
						where codigo = ?";
			
			$ejecutar=$conexion->prepare($consulta);
			
			$ejecutar->execute(array(	$per->obtenerNombre(),
										$per->obtenerCodDepartamento(),
										$per->obtenerCodPensum(),
										$per->obtenerFecInicio(),
										$per->obtenerFecFinal(),
										$per->obtenerObservaciones(),
										$per->obtenerCodEstado(),
										$per->obtenerCodigo()
									));
		}
		catch(Exception $e){
			throw $e;
		}
	}

	public static function listarPorDepartamento($codDepartamento){
		try{
			$conexion=Conexion::conectar();
			$consulta="select * from sis.t_periodo where cod_departamento=?;";
			$ejecutar=$conexion->prepare($consulta);
			$ejecutar->execute(array($codDepartamento));
			if($ejecutar->rowCount()!=0){
				return $ejecutar->fetchAll();
			}else 
				return null;
		}catch (Exception $e){
			throw $e;	
		}
	}
	
	public static function obtenerEstado(){
		try{
			$conexion=Conexion::conectar();
			
			$consulta="select * from sis.t_est_periodo";
			
			$ejecutar=$conexion->prepare($consulta);
			
			$ejecutar->execute(array());
			
			if($ejecutar->rowCount()!=0){
				return $ejecutar->fetchAll();
			}else 
				return null;
		}
		catch(Exception $e){
			throw $e;
		}
	}
	
	public static function listar($inst, $estado, $departamento, $pensum, $codigo){
		try{
			$arr = array();
			
			$conexion=Conexion::conectar();
			
			$consulta="select 	per.*, 
								est.nombre as nombreestado,
								pen.nombre as nombrepensum,
								dep.nombre as nombredep,
								inst.nombre as nombreinst,
								inst.codigo as codinst	
								from sis.t_periodo as per
								inner join sis.t_est_periodo as est
									on per.cod_estado = est.codigo
								inner join sis.t_pensum as pen
									on per.cod_pensum = pen.codigo
								inner join sis.t_departamento as dep
									on per.cod_departamento = dep.codigo
								inner join sis.t_instituto as inst
									on dep.cod_instituto = inst.codigo
							";
			if($inst != ''){
				$consulta .= " where dep.cod_instituto = ?";
				$arr[count($arr)] = $inst;
			}
			
			if($estado != ''){
				if($arr[count($arr)] != 0)
					$consulta .= " where per.cod_estado = ? ";
				else
					$consulta .= " and per.cod_estado = ? ";
				$arr[count($arr)] = $estado; 
			}
			
			if($departamento != ''){
				$consulta .= " and dep.codigo = ? ";
				$arr[count($arr)] = $departamento;
			}
			
			if($pensum != '')	{
				$consulta .= " and per.cod_pensum = ?";
				$arr[count($arr)] = $pensum;
			}
			
			if($codigo != '')	{
				$consulta .= " and per.codigo = ?";
				$arr[count($arr)] = $codigo;
			}
				
			$consulta .= " order by dep.nombre, per.nombre ";
			
			$ejecutar=$conexion->prepare($consulta);
			
			$ejecutar->execute($arr);
			
			if($ejecutar->rowCount()!=0){
				return $ejecutar->fetchAll();
			}else 
				return null;
		}catch (Exception $e){
			throw $e;	
		}
	}
	
	public static function listarPorInstitutoPensum($codPensum,$codInstituto){
		try{
				$conexion=Conexion::conectar();
				$consulta="select p.*,de.nombre as nombre_departamento,de.cod_instituto,ins.nombre as nombre_instituto
						   from sis.t_periodo as p
								inner join sis.t_departamento as de on (p.cod_departamento=de.codigo)
								inner join sis.t_instituto as ins on (de.cod_instituto= ins.codigo)
							where ins.codigo=? and p.cod_pensum=?";
				$ejecutar=$conexion->prepare($consulta);
				$ejecutar->execute(array($codInstituto,$codPensum));
				if($ejecutar->rowCount()!=0){
					return $ejecutar->fetchAll();
				
				}else 
					return null;
			}catch (Exception $e){
				throw $e;	
			}

	}
}

?>
