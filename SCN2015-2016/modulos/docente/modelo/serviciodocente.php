<?php
	class ServicioDocente{

		/*Funcion que se encarga de obtener el codigo mas alto de la tabla docentes de la base de datos*/
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

		/*Funcion que trae de la base de datos todos los datos de docentes con sus respectivas referencias
		de otras tablas para luego devolver los datos y asi poder ser listado todos los docentes guardados*/
		public static function listar($patron){
			try{
				$conexion = Conexion::conectar();
				
				$patron = "%".$patron."%";
				
				$consulta = "select 	vd.*,
										estado_docente.nombre as estado, 
										departamento.nombre as nom_departamento
													from sis.v_docente as vd 
														join sis.t_est_docente as estado_docente 
														on vd.cod_estado=estado_docente.codigo
														join sis.t_departamento as departamento
														on vd.cod_departamento=departamento.codigo
														where cast(cedula as varchar) like ?
															or upper(nombre1) like upper(?)
															or upper(nombre2) like upper(?)
															or upper(apellido1) like upper(?)
															or upper(apellido2) like upper(?)
															or upper(departamento.nombre) like upper(?)
															or upper(estado_docente.nombre) like upper(?)
															order by nombre1 asc";
				
				$ejecutar = $conexion->prepare($consulta);
				
				$ejecutar->execute(array($patron,$patron,$patron,$patron,$patron,$patron,$patron));
				
				$lista=$ejecutar->fetchAll();		
						
				if($ejecutar->rowCount()!=0)
					return $lista;
				else
				throw new Exception ("Error Al Listar Docente ".$codigo);
			}catch(Exception $e){
			throw $e;
			}
		}

		/*Funcion que se encarga de obtener todos los datos de un docente en especifico mediante su codigo unico*/
		public static function obtenerPorCodigo($codigo){
			try{
				$conexion = Conexion::conectar();
				$ejecutar = $conexion->prepare("select vd.*, estado_docente.nombre as estado, departamento.nombre as nom_departamento
												from sis.v_docente as vd 
												join 
												sis.t_est_docente as estado_docente 
												on vd.cod_estado=estado_docente.codigo
												join
												sis.t_departamento as departamento
												on vd.cod_departamento=departamento.codigo
												where vd.codigo=?");							
				$ejecutar->execute(array ($codigo));
				$lista= ($ejecutar->fetchAll());							
				if ($ejecutar->rowCount()==0)
				throw new Exception ("No existe el docente con el codigo: ".$codigo);		
				else 
				return $lista;
			}catch(Exception $e){
			throw $e;
			}
		}

		/*Funcion que se encarga de saber el numero de parametros pasados y ver si estan completos o no,
		para poder ser agregados a un objeto docente*/
		public static function agregar(){
			try{
				$nArg=func_num_args();
				if ($nArg==1){
					$p=func_get_arg(0);
					if ((is_object($p)) && (get_class($p)=='Docente'))
					self::agregarO($p);
				}
				else{
					if ($nArg!=7)
					throw new Exception ('Cantidad de parámetros incorrecta');
					else
					self::agregarE(func_get_arg(0),func_get_arg(1),func_get_arg(2),func_get_arg(3),
					func_get_arg(4),func_get_arg(5),func_get_arg(6));
				}
			}
			catch (Exception $e){
			throw $e;
			}
		}

		/*Funcion que agrega a un nuevo docente a la base de datos con todos sus parametros 
		pasaods por un objeto docente*/
		public static function agregarO($docente){
			try{
				$codigo= self::obtenerMayorCodigo();
				$conexion = Conexion::conectar();			
				$ejecutar = $conexion->prepare("insert into sis.t_docente (codigo,cod_departamento,num_empleado,cod_estado) values (?,?,?,?)");
				$ejecutar->execute(array ($codigo,
				$docente->obtenerCodDpto(),
				$docente->obtenerNumEmpleado(),
				$docente->obtenerCodEstado()));
				if ($ejecutar->rowCount()== 0)
				throw new Exception ("error al agregar el docente");		
			}
			catch (Exception $e){
			throw $e;
			}
		}

		public static function agregarDocente($docente)
		{
			try{
				$conexion = Conexion::conectar();			
				$ejecutar = $conexion->prepare("insert into sis.t_docente (codigo,cod_departamento,num_empleado,cod_estado) values (?,?,?,?)");
				$ejecutar->execute(array (
				$docente->obtenerCodigo(),
				$docente->obtenerCodDpto(),
				$docente->obtenerNumEmpleado(),
				$docente->obtenerCodEstado()));
				if ($ejecutar->rowCount()== 0)
				throw new Exception ("error al agregar el docente");		
			}
			catch (Exception $e){
			throw $e;
			}			
		}



		/*Funcion que se encarga de retirar a un docente especifico de la base de datos
		mediante su codigo unico, lo que hace es cambiar su estado a "Retirado"*/
		public static function retirarPorCodigo($codigo){
			try{
				$conexion = Conexion::conectar();
				$ejecutar = $conexion->prepare("update sis.t_docente set cod_estado='R' where codigo=?");						
				$ejecutar->execute(array($codigo));					
				if ($ejecutar->rowCount()== 0)
				throw new Exception ("Error al cambiar el estado del docente a retirado");
			}
			catch(Exception $e){
			throw $e;
			}											
		}

		/*Funcion que modifica los datos de un docente ya guardado, cambia los parametros de
		codigo de departamento y codigo de estado*/
		public static function modificarDocente($codigo,$docente)
			{
			try{
				$conexion = Conexion::conectar();
				$ejecutar = $conexion->prepare("update sis.t_docente set cod_estado=?,cod_departamento=? where codigo=?");						
				$ejecutar->execute(array($docente->obtenerCodEstado(),$docente->obtenerCodDpto(),$codigo));					
				if ($ejecutar->rowCount()== 0)
				throw new Exception ("Error al cambiar el modificar el docente");
			}
			catch(Exception $e){
			throw $e;
			}	
		}



		public static function buscarDocentes($patron){
			try{
				$conexion = Conexion::conectar();
				$ejecutar = $conexion->prepare("select 	per.codigo, 
														per.cedula, 
														per.nombre1, 
														per.apellido1 from sis.t_persona as per 
														inner join sis.t_docente as doc 
														on per.codigo = doc.codigo 
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
        
        /*Funcion que se trae de la base de datos la lista de las personas que no estan relacionadas
		sus codigos con docentes para asi poder ser listados y agregados como nuevos docentes*/
		public static function buscarPersonas(){
			try{
				$conexion = Conexion::conectar();
				$consulta = "select * from sis.t_persona where codigo not in (select codigo from sis.t_docente);";
				$ejecutar = $conexion->query($consulta);
				$lista=$ejecutar->fetchAll();				
				if($ejecutar->rowCount()!=0)
				return $lista;
				else
				return NULL;
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
				return NULL;
			}
			catch(Exception $e){
			throw $e;
			}
		}
        
        public static function buscarEstado(){
			try{
				$conexion = Conexion::conectar();
				$consulta = "select * from sis.t_est_docente";
				$ejecutar = $conexion->query($consulta);
				$lista=$ejecutar->fetchAll();				
				if($ejecutar->rowCount()!=0)
				return $lista;
				else
				return NULL;
			}
			catch(Exception $e){
			throw $e;
			}
		}


	}
?>

