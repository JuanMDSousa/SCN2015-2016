<?php
	/*Servicio del Modulo Estudiante donde se activan todas las funciones llamadas por el controlador*/
	class ServicioEstudiante{

		/*Función que obtiene el codigo mayor de todos los estudiante de la base de datos*/
		private static function obtenerMayorCodigo (){
			try {
				$conexion = Conexion::conectar();
				$consulta = "select coalesce (max(codigo),0) from sis.t_persona";
				$ejecutar = $conexion->query($consulta);
				$consulta=$ejecutar->fetchAll();
				return $consulta [0][0];  					
			}catch(Exception $e){
			throw $e;
			}						
		}
		/*Función que trae la lista completa de la tabla de base de datos de estudiante relacionado
		con sus departamentos y estados*/
		public static function listar($patron){
			try{
				$conexion = Conexion::conectar();
				
				$patron = "%".$patron."%";
				
				$consulta = "select 	ve.*,
										departamento.nombre,
										pensum.nom_corto,
										estado.nombre as nombre_estado from sis.v_estudiante as ve
											join sis.t_departamento as departamento
											on ve.cod_departamento=departamento.codigo
											join sis.t_pensum as pensum
											on ve.cod_pensum=pensum.codigo
											join sis.t_est_estudiante as estado
											on ve.cod_estado=estado.codigo 
											where cast(cedula as varchar) like ?
											or upper(nombre1) like upper(?)
											or upper(nombre2) like upper(?)
											or upper(apellido1) like upper(?)
											or upper(apellido2) like upper(?)
											or upper(departamento.nombre) like upper(?)
											or upper(estado.nombre) like upper(?)
											order by cedula asc";
				
				$ejecutar = $conexion->prepare($consulta);
				
				$ejecutar->execute(array($patron, $patron, $patron, $patron, $patron, $patron, $patron));
				
				$lista=$ejecutar->fetchAll();				
				
				if($ejecutar->rowCount()!=0)
					return $lista;
				else
					return NULL;
			}catch(Exception $e){
			throw $e;
			}
		}

		/*Función que obtiene todos los datos de un estudiante en especifico por su codigo unico*/
		public static function obtenerPorCodigo($codigo){
			try{
				$conexion = Conexion::conectar();
				$ejecutar = $conexion->prepare("select ve.*,departamento.nombre,pensum.nom_corto,estado.nombre as nombre_estado from sis.v_estudiante as ve
												join
												sis.t_departamento as departamento
												on ve.cod_departamento=departamento.codigo
												join
												sis.t_pensum as pensum
												on ve.cod_pensum=pensum.codigo
												join
												sis.t_est_estudiante as estado
												on ve.cod_estado=estado.codigo
												where ve.codigo=?");							
				$ejecutar->execute(array ($codigo) );
				$lista= ($ejecutar->fetchAll());							
				if ($ejecutar->rowCount()==0)
				throw new Exception ("No existe el estudiante con el codigo: ".$codigo);		
				else 
				return $lista;
			}catch(Exception $e){
			throw $e;
			}
		}

		/*Función que modifica por base de datos un estudiante en especifico con sus 3 datos a modificar
		(codigo de departamento, codigo de pensum y codigo de estado)*/
		public static function modificar($codigo,$estudiante){
			try{
				$conexion = Conexion::conectar();
				$ejecutar = $conexion->prepare("update sis.t_estudiante set cod_departamento=?,cod_pensum=?,cod_estado=? where codigo=?");						
				$ejecutar->execute(array($estudiante->obtenerCodDpto(),$estudiante->obtenerCodPensum(),$estudiante->obtenerCodEstado(),$codigo));					
				if ($ejecutar->rowCount()== 0)
			throw new Exception ("Error al modificar estudiante");
			}catch(Exception $e){
			throw $e;
			}	
		}

		/*Funcion que se encarga de saber el numero de parametros pasados y ver si estan completos o no,
		para poder ser agregados a un objeto estudiante*/
		public static function parametros(){
			try{
				$nArg=func_num_args();
				if ($nArg==1){
					$p=func_get_arg(0);
					if ((is_object($p)) && (get_class($p)=='Estudiante'))
					self::agregarO($p);
				}
				else{
					if ($nArg!=7)
					throw new Exception ('Cantidad de parámetros incorrecta');
					else
					self::agregarE(func_get_arg(0),func_get_arg(1),func_get_arg(2),func_get_arg(3),
					func_get_arg(4),func_get_arg(5),func_get_arg(6));
				}
			}catch (Exception $e){
			throw $e;
			}
		}

		/*Funcion que agrega a un nuevo estudiante a la base de datos con todos sus parametros 
		pasaods por numero especifico de parametros*/
		public static function agregarE($cod_departamento,$cod_pensum,$num_carnet,$num_expediente,$cod_rusnies,$cod_estado){
			try{
				$codigo= self::obtenerMayorCodigo();
				$conexion = Conexion::conectar();			
				$ejecutar = $conexion->prepare("insert into sis.t_estudiante (codigo,cod_departamento,cod_pensum,num_carnet,num_expediente,cod_rusnies,cod_estado) values (?,?,?,?,?,?,?)");
				$ejecutar->execute(array ($codigo,$cod_departamento,$cod_pensum,$num_carnet,$num_expediente,$cod_rusnies,$cod_estado));
				if ($ejecutar->rowCount()== 0)
				throw new Exception ("error al agregar los datos de estudiante");		
			}
			catch (Exception $e){
			throw $e;
			}
		}

		/*Funcion que agrega a un nuevo estudiante a la base de datos con todos sus parametros 
		pasaods por un objeto estudiante*/
		public static function agregar($estudiante){
			try{
				$codigo= self::obtenerMayorCodigo();
				$conexion = Conexion::conectar();
				$ejecutar = $conexion->prepare("insert into sis.t_estudiante (codigo,cod_departamento,cod_pensum,num_carnet,num_expediente,cod_rusnies,cod_estado) values (?,?,?,?,?,?,?)");
				$ejecutar->execute(array ($codigo,
										$estudiante->obtenerCodDpto(),
										$estudiante->obtenerCodPensum(),
										$estudiante->obtenerNumCarnet(),
										$estudiante->obtenerNumExp(),
										$estudiante->obtenerCodRusnies(),
										$estudiante->obtenerCodEstado()));
				if ($ejecutar->rowCount()== 0)
				throw new Exception ("error al agregar el objeto");		
			}
			catch (Exception $e){
			throw $e;
			}
		}
		
		public static function agregarEstudiante($estudiante){
			try{
				$conexion = Conexion::conectar();			
				$ejecutar = $conexion->prepare("insert into sis.t_estudiante (codigo,cod_departamento,cod_pensum,cod_estado) values (?,?,?,?)");
				$ejecutar->execute(array (
				$estudiante->obtenerCodigo(),
				$estudiante->obtenerCodDpto(),
				$estudiante->obtenerCodPensum(),
				$estudiante->obtenerCodEstado()));
				if ($ejecutar->rowCount()== 0)
				throw new Exception ("error al agregar el estudiante");		
			}
			catch (Exception $e){
			throw $e;
			}			
		}






		/*Funcion que se encarga de retirar a un etudiante especifico de la base de datos
		mediante su codigo unico, lo que hace es cambiar su estado a "Retirado"*/
		public static function retirarPorCodigo($codigo){
			try{
				$conexion = Conexion::conectar();
				$ejecutar = $conexion->prepare("update sis.t_estudiante set cod_estado='R' where codigo=?");						
				$ejecutar->execute(array($codigo));					
				if ($ejecutar->rowCount()== 0)
				throw new Exception ("Error al cambiar el estado del estudiante a retirado");
			}catch(Exception $e){
			throw $e;
			}											
		}

		public static function buscarPersonas(){
			try{
				$conexion = Conexion::conectar();
				$consulta = "select * from sis.t_persona where codigo not in (select codigo from sis.t_estudiante);";
				$ejecutar = $conexion->query($consulta);
				$lista=$ejecutar->fetchAll();				
				if($ejecutar->rowCount()!=0)
				return $lista;
				else
				throw new Exception ("No Existen personas que se puedan agregar a estudiante");
			}
			catch(Exception $e){
			throw $e;
			}
		}

		public static function buscarDepartamentos(){
			try{
				$conexion = Conexion::conectar();
				$consulta = "select * from sis.t_departamento";
				$ejecutar = $conexion->query($consulta);
				$lista=$ejecutar->fetchAll();				
				if($ejecutar->rowCount()!=0)
				return $lista;
				else
				throw new Exception ("No Existen departamentos");
			}
			catch(Exception $e){
			throw $e;
			}
		}

		public static function buscarEstado(){
			try{
				$conexion = Conexion::conectar();
				$consulta = "select * from sis.t_est_estudiante";
				$ejecutar = $conexion->query($consulta);
				$lista=$ejecutar->fetchAll();				
				if($ejecutar->rowCount()!=0)
				return $lista;
				else
				throw new Exception ("No hay estados");
			}
			catch(Exception $e){
			throw $e;
			}
		}

		public static function obtenerEstudiantes($cod){
			try{
				$conexion = Conexion::conectar();

				$ejecutar = $conexion->prepare("select per.codigo, per.cedula, per.nombre1, per.apellido1 
												from sis.t_persona as per 
												inner join sis.t_estudiante as est
												on (per.codigo = est.codigo) 
												where per.codigo not in 
												(select cod_estudiante from sis.t_cur_estudiante where cod_curso = ?)");

				$ejecutar->execute(Array($cod));

				if($ejecutar->rowCount() == 0)
					throw new Exception ("No Existe el estudiante");
				else
					return $ejecutar->fetchAll();
				
			}catch(Exception $e){
				throw $e;	
			}
		}

		public static function buscarEstudiantes($patron){
			try{
				$conexion = Conexion::conectar();
				$ejecutar = $conexion->prepare("select 	per.codigo, 
														per.cedula, 
														per.nombre1, 
														per.apellido1 from sis.t_persona as per 
														inner join sis.t_estudiante as est 
														on per.codigo = est.codigo 
														where 
														cast(per.cedula as varchar) like ?
														or
														upper(per.nombre1) like upper(?)
														or 
														upper(per.apellido1) like upper(?)
														;");	

				$ejecutar->execute(array("%".$patron."%","%".$patron."%","%".$patron."%"));					
				
				return $ejecutar->fetchAll();
					
			}
			catch(Exception $e){
				throw $e;
			}	
		}

}




?>
