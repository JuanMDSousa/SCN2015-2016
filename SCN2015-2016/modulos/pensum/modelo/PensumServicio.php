<?php
require_once "negocio/Pensum.clase.php";
require_once "negocio/Trayecto.clase.php";
require_once "negocio/UniCurricular.clase.php";


class PensumServicio
{
	private static function obtenerMayorCodigo (){
			try {
				$conexion = Conexion::conectar();
				$consulta = "select coalesce (max(codigo),0) from sis.t_pensum";
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

	public static function listarPensum($patron)
	{
		try{
				$conexion = Conexion::conectar();
				$consulta = "select * from sis.t_pensum where (nombre) like upper(?)
										or upper(nom_corto) like upper(?)
										or upper(observaciones) like upper(?)
										order by codigo asc;";

				$patron = "%".$patron."%";
				
				$ejecutar = $conexion->prepare($consulta);
				
				$ejecutar->execute(array($patron,$patron,$patron));
				
				$lista=$ejecutar->fetchAll();
				if($ejecutar->rowCount()!=0)
				return $lista;				
				else
				return NULL;
			}catch(Exception $e){throw $e;}
	}

	public static function agregar()
	{
		try{
				$nArg=func_num_args();
				if ($nArg==1){
				$p=func_get_arg(0);
				if ((is_object($p)) && (get_class($p)=='Pensum'))
				self::agregarO($p);
				}else{
				if ($nArg!=2)
					throw new Exception ('Cantidad de parámetros incorrecta');
				else
					self::agregarD(func_get_arg(0),func_get_arg(1),func_get_arg(2));
				}
			}catch (Exception $e){
			throw $e;
			}
	}

	public static function agregarO($pensum)
	{
		try
		{
			$codigo= self::obtenerMayorCodigo () + 1;
			$conexion = Conexion::conectar();	
			$ejecutar=$conexion->prepare("insert into sis.t_pensum (codigo,nombre,nom_corto,observaciones) values (?,?,?,?)");
			$ejecutar->execute(array($codigo,
									 $pensum->obtenerNombre(),
									 $pensum->obtenerNombreCorto(),
									 $pensum->obtenerObservaciones()));
	
			if ($ejecutar->rowCount()==0)
			throw new Exception ("error al agregar objeto pensum");
		}catch(Exception $e){throw $e;}	
	}
	
	public static function agregarD($nombre,$nom_corto,$observaciones)
	{
		try
		{
			$codigo= self::obtenerMayorCodigo () + 1;
			$conexion = Conexion::conectar();
			$ejecutar=$conexion->prepare("insert into sis.t_pensum (codigo,nombre,nom_corto,observaciones) values (?,?,?,?)");			
			$ejecutar->execute(array($codigo,$nombre,$nom_corto,$observaciones));
			if ($ejecutar->rowCount==0)
			throw new Exception ("error al agregar por param");
		}catch (Exception $e){throw $e;}
	}

	
	public static function modificar($pensum)
	{
		try
		{
			$conexion = Conexion::conectar();
			$ejecutar =$conexion->prepare("update sis.t_pensum set nombre=?,nom_corto=?,observaciones=? where codigo =?");
			$ejecutar->execute(array(
									 $pensum->obtenerNombre(),
									 $pensum->obtenerNombreCorto(),
								     $pensum->obtenerObservaciones(),
								     $pensum->obtenerCodigo()));
			if ($ejecutar->rowCount()==0)
				throw new Exception ("error al modificar pensum");
		}catch(Exception $e){throw $e;}	
	}

	public static function eliminarPorCodigo($codigo){
			try{
				$conexion = Conexion::conectar();
				$ejecutar = $conexion->prepare("delete from sis.t_pensum where codigo= ?");							
				$ejecutar->execute(array ($codigo) );	
				if ($ejecutar->rowCount()== 0)
				throw new Exception ("Error al eliminar persona por codigo ");
			}catch(Exception $e){
			throw $e;
			}		
		}

	public static function buscarPensum($codigo)
	{
		try
		{
			$conexion = Conexion::conectar();
			$ejecutar = $conexion->prepare("select * from sis.t_pensum where codigo= ?");							
			$ejecutar->execute(array ($codigo));
			$lista=($ejecutar->fetchAll());							
			if ($ejecutar->rowCount()==0)
			throw new Exception ("No existe pensum con el codigo: ".$codigo);		
			else 
			return $lista;
		}
		catch (Exception $e) {throw $e;}
	}	

	public static function buscarTrayPen($codigo)
	{
	  try
 	    {
	     $conexion = Conexion::conectar();
	     $ejecutar = $conexion->prepare("select pen.*,
										tray.codigo as cod_trayecto,
										tray.cod_pensum,
										tray.num_trayecto,
										tray.certificado,
										tray.min_credito,
										uni.codigo as codigounidad,
										uni.cod_uni_ministerio,
										uni.cod_trayecto as cod_tray_uni,
										uni.nombre as nombre_uniC,
										uni.cod_tipo,
										uni.hta,
										uni.hti,
										uni.uni_credito,
										uni.dur_semanas,
										uni.not_min_aprobatoria,
										uni.not_maxima,
										tipouc.codigo as codigotip,
										tipouc.nombre as nombretip
										from sis.t_pensum as pen
										left join sis.t_trayecto as tray on pen.codigo = tray.cod_pensum 
										left join sis.t_uni_curricular as uni on tray.codigo=uni.cod_trayecto
										left join sis.t_tip_uni_curricular as tipouc on uni.cod_tipo = tipouc.codigo
										where pen.codigo=?
										order by num_trayecto");				
	     $ejecutar->execute(array ($codigo));
	     $lista=($ejecutar->fetchAll());							
	     if ($ejecutar->rowCount()==0)
	     	throw new Exception ("No existe trayecto con el codigo: ".$codigo);
	     else 
				{	
				 	$pensum = new Pensum();
				 	$pensum->asignarCodigo($lista[0]['codigo']);
					$pensum->asignarNombre($lista[0]['nombre']);
					$pensum->asignarNombreCorto($lista[0]['nom_corto']);
					$pensum->asignarObservaciones($lista[0]['observaciones']);
					$numero_trayecto_init = $lista[0]['num_trayecto'];

					 for ($i=0; $i < count($lista); $i++)
					 {
					 	
					 	$numero_trayecto = $lista[$i]['num_trayecto'];
					 	if ($i==0)
					 	{
					 		$trayecto = new Trayecto();	
					 		$trayecto->asignarCodigo($lista[$i]['cod_trayecto']);
					 		$trayecto->asignarCodPensum($lista[$i]['cod_pensum']);
					 		$trayecto->asignarNumero($lista[$i]['num_trayecto']);
					 		$trayecto->asignarCertificado($lista[$i]['certificado']);
					 		$trayecto->asignarMinCredito($lista[$i]['min_credito']);	 		
					 		$unidadC = new UniCurricular();
					 		$unidadC->asignarCodigo($lista[$i]['codigounidad']);
					 		$unidadC->asignarCodPensum($lista[$i]['cod_pensum']);
					 		$unidadC->asignarCodTrayecto($lista[$i]['cod_tray_uni']);
					 		$unidadC->asignarCodUnidad($lista[$i]['cod_uni_ministerio']);
					 		$unidadC->asignarNombre($lista[$i]['nombre_unic']);
					 		$unidadC->asignarTipo($lista[$i]['nombretip']);
					 		$unidadC->asignarHti($lista[$i]['hti']);
					 		$unidadC->asignarHta($lista[$i]['hta']);
					 		$unidadC->asignarUniCredito($lista[$i]['uni_credito']);
					 		$unidadC->asignarDurSemana($lista[$i]['dur_semanas']);
					 		$unidadC->asignarNotMinima($lista[$i]['not_min_aprobatoria']);
					 		$unidadC->asignarNotMaxima($lista[$i]['not_maxima']);
					 		$unidades[]= $unidadC;					 		
					 	}
					 	else
					 	{
					 		if ($numero_trayecto_init == $numero_trayecto) 
					 		{	
						 		$unidadC = new UniCurricular();
						 		$unidadC->asignarCodigo($lista[$i]['codigounidad']);
						 		$unidadC->asignarCodPensum($lista[$i]['cod_pensum']);
						 		$unidadC->asignarCodTrayecto($lista[$i]['cod_tray_uni']);
						 		$unidadC->asignarCodUnidad($lista[$i]['cod_uni_ministerio']);
						 		$unidadC->asignarNombre($lista[$i]['nombre_unic']);
						 		$unidadC->asignarTipo($lista[$i]['nombretip']);
						 		$unidadC->asignarHti($lista[$i]['hti']);
						 		$unidadC->asignarHta($lista[$i]['hta']);
						 		$unidadC->asignarUniCredito($lista[$i]['uni_credito']);
						 		$unidadC->asignarDurSemana($lista[$i]['dur_semanas']);
						 		$unidadC->asignarNotMinima($lista[$i]['not_min_aprobatoria']);
						 		$unidadC->asignarNotMaxima($lista[$i]['not_maxima']);
						 		$unidades[]= $unidadC;
					 		}
					 		else
					 		{

					 			$trayecto->asignarUnidades($unidades);
					 			$trayectos[] = $trayecto;
					 			$unidades = null;					 			
					 			$trayecto = new Trayecto();	
						 		$trayecto->asignarCodigo($lista[$i]['cod_trayecto']);
						 		$trayecto->asignarCodPensum($lista[$i]['cod_pensum']);
						 		$trayecto->asignarNumero($lista[$i]['num_trayecto']);
						 		$trayecto->asignarCertificado($lista[$i]['certificado']);
						 		$trayecto->asignarMinCredito($lista[$i]['min_credito']);	 		
						 		$unidadC = new UniCurricular();
						 		$unidadC->asignarCodigo($lista[$i]['codigounidad']);
						 		$unidadC->asignarCodPensum($lista[$i]['cod_pensum']);
						 		$unidadC->asignarCodTrayecto($lista[$i]['cod_tray_uni']);
						 		$unidadC->asignarCodUnidad($lista[$i]['cod_uni_ministerio']);
						 		$unidadC->asignarNombre($lista[$i]['nombre_unic']);
						 		$unidadC->asignarTipo($lista[$i]['nombretip']);
						 		$unidadC->asignarHti($lista[$i]['hti']);
						 		$unidadC->asignarHta($lista[$i]['hta']);
						 		$unidadC->asignarUniCredito($lista[$i]['uni_credito']);
						 		$unidadC->asignarDurSemana($lista[$i]['dur_semanas']);
						 		$unidadC->asignarNotMinima($lista[$i]['not_min_aprobatoria']);
						 		$unidadC->asignarNotMaxima($lista[$i]['not_maxima']);
						 		$unidades[]= $unidadC;	
						 		$numero_trayecto_init =$numero_trayecto;
							 }							 
						   }
						     if ($i+1 == count($lista))
							 	{
							 		$trayecto->asignarUnidades($unidades);
							 		$trayectos[] = $trayecto;
							 	} 
					     }
					 }
					 $pensum->asignarTrayectos($trayectos);						 
					 return $pensum;
     }catch (Exception $e) {throw $e;}
}

	public static function listarPorDepartamento($codDepartamento){
		try{
			$conexion = Conexion::conectar();
			
			$consulta = "select distinct pen.* from sis.t_pensum as pen 
							inner join sis.t_periodo as per 
							on per.cod_pensum = pen.codigo 
						where per.cod_departamento = ?";
			
			$ejecutar =$conexion->prepare($consulta);
			
			$ejecutar->execute(array($codDepartamento));
			
			if($ejecutar->rowCount()!=0){
				return $ejecutar->fetchAll();
			}else 
				return null;
			
		}catch(Exception $e){
			throw $e;
		}	
	}
	
}
?>
