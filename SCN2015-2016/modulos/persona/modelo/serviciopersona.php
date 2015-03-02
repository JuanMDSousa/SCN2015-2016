<?php	
	/**
	 * * * * * * * * * * LICENCIA * * * * * * * * * * * 

	Copyright(C) 2014
	Instituto Universtiario de Tecnología Dr. Federico Rivero Palacio

	Este programa es Software Libre y usted puede redistribuirlo y/o modificarlo
	bajo los términos de la versión 3.0 de la Licencia Pública General (GPLv3)
	publicada por la Free Software Foundation (FSF), es distribuido sin ninguna
	garantía. Usted debe haber recibido una copia de la GPLv3 junto con este
	programa, sino, puede encontrarlo en la página web de la FSF, 
	específicamente en la dirección http://www.gnu.org/licenses/gpl-3.0.html

	 * * * * * * * * * * ARCHIVO * * * * * * * * * * * * * * * * * * * * *

	Nombre: serviciopersona.php
	Diseñador: Hector Zea, Leonardo Camacaro (zea3471@gmail.com, leonardocamacaro@hotmail.com)
	Programador: Hector Zea, Leonardo Camacaro (zea3471@gmail.com, leonardocamacaro@hotmail.com)
	Fecha: Julio de 2014
	Descripción:  
		Manejo de todos los servicios del modulo de persona del sistema de control de notas del
		departamento de mecanica (SCN)
		
	 * * * * * * * * Cambios/Mejoras/Correcciones/Revisiones * * * * * * * *
	Diseñador - Programador /   Fecha   / Descripción del cambio
	---                         ----      ---------
	*/
	class ServicioPersona{
		
		public static function acomodarCadena($cadena){
			return $cadena;
		}

		public static function agregar(){
			try{
				$nArg=func_num_args();
				if ($nArg==1){
				$p=func_get_arg(0);
				if ((is_object($p)) && (get_class($p)=='Persona'))
				self::agregarO($p);
				}else{
				if ($nArg!=14)
					throw new Exception ('Cantidad de parámetros incorrecta');
				else
					self::agregarD(func_get_arg(0),func_get_arg(1),func_get_arg(2),func_get_arg(3),
					func_get_arg(4),func_get_arg(5),func_get_arg(6),func_get_arg(7),func_get_arg(8),func_get_arg(9),
					func_get_arg(10),func_get_arg(11),func_get_arg(12),func_get_arg(13));
				}
			}catch (Exception $e){
			throw $e;
			}
		}

		public static function agregarD($cedula,$rif,$nombre1,$nombre2,$apellido1,$apellido2,$sexo,$fec_nacimiento,$tip_sangre,$telefono1,$telefono2,$cor_personal,$cor_institucional,$direccion){
			try{
				$codigo= self::obtenerMayorCodigo () + 1;
				$conexion = Conexion::conectar();			
				$ejecutar = $conexion->prepare("insert into sis.t_persona (codigo,cedula,rif,nombre1,nombre2,apellido1,apellido2,sexo,fec_nacimiento,tip_sangre,telefono1,telefono2,cor_personal,cor_institucional,direccion) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
				$ejecutar->execute(array($codigo,$cedula,$rif,$nombre1,$nombre2,$apellido1,$apellido2,$sexo,$fec_nacimiento,$tip_sangre,$telefono1,$telefono2,$cor_personal,$cor_institucional,$direccion));
				if ($ejecutar->rowCount()== 0)
				throw new Exception ("error al agregar los datos");		
			}
			catch (Exception $e){
			throw $e;
			}
		}

		public static function agregarO($persona){
			try{
				$codigo= self::obtenerMayorCodigo () + 1;
				$conexion = Conexion::conectar();			
				$ejecutar = $conexion->prepare("insert into sis.t_persona (codigo,cedula,rif,nombre1,nombre2,apellido1,apellido2,sexo,fec_nacimiento,tip_sangre,telefono1,telefono2,cor_personal,cor_institucional,direccion) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
				$ejecutar->execute(array($codigo,
										$persona->obtenerCedula(),
										$persona->obtenerRif(),
										$persona->obtenerNombre1(),
										$persona->obtenerNombre2(),
										$persona->obtenerApellido1(),
										$persona->obtenerApellido2(),
										$persona->obtenerSexo(),
										$persona->obtenerFecNacimiento(),
										$persona->obtenerTipSangre(),
										$persona->obtenerTelefono1(),
										$persona->obtenerTelefono2(),
										$persona->obtenerCorreoPersonal(),
										$persona->obtenerCorreoInstitucional(),
										$persona->obtenerDireccion(),
										));
				if ($ejecutar->rowCount()== 0)
				throw new Exception ("error al agregar la persona");		
			}
			catch (Exception $e){
				throw $e;
			}
		}


		public static function modificar ($persona){
			try{
				$conexion = Conexion::conectar();
				$ejecutar = $conexion->prepare("update sis.t_persona set rif=?,nombre1=?,nombre2=?,apellido1=?,apellido2=?,sexo=?,fec_nacimiento=?,tip_sangre=?,telefono1=?,telefono2=?,cor_personal=?,cor_institucional=?,direccion=? where cedula=?" );	
				$ejecutar->execute(array (
				$persona->obtenerRif(),
				$persona->obtenerNombre1(),
				$persona->obtenerNombre2(),
				$persona->obtenerApellido1(),
				$persona->obtenerApellido2(),
				$persona->obtenerSexo(),
				$persona->obtenerFecNacimiento(),
				$persona->obtenerTipSangre(),
				$persona->obtenerTelefono1(),
				$persona->obtenerTelefono2(),
				$persona->obtenerCorreoPersonal(),
				$persona->obtenerCorreoInstitucional(),
				$persona->obtenerDireccion(),
				$persona->obtenerCedula()));
				if ($ejecutar->rowCount()== 0)
				throw new Exception ("Error al modificar el objeto");		
			}
			catch (Exception $e){
			throw $e;
			}
		}

		/*funcion encargada de obtener el codigo mayor de una persona
		de la base de datos
		*/
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

		public static function obtenerCodigoPorCedula($cedula){
			try{
				$conexion = Conexion::conectar();
				$consulta = "select * from sis.t_persona where cedula = ?";
				$ejecutar = $conexion->query($consulta);
				$consulta = $ejecutar->fetchAll();
				return $consulta;
			}catch(Exception $e){
			throw $e;
			}
		} 

		public static function eliminarPorCedula ($cedula){
			try{
				$conexion = Conexion::conectar();
				$ejecutar = $conexion->prepare("delete from sis.t_persona where cedula = ?");
				$ejecutar->execute(array ($cedula) );
				if ($ejecutar->rowCount()== 0)
				throw new Exception ("Error al eliminar persona por cedula ");
			}catch(Exception $e){
			throw $e;
			}
		}

		/**función que permite eliminar los datos una persona por su codigo en la base de datos	  
		Parámetros de entrada:	      
		$codigo: codigo de la persona	     
		Valor de retorno:
		- "Eliminacion exitosa en la base de datos"
		- Error en la Modificacion por codigo con su respectiva exception
		*/	
		public static function eliminarPorCodigo($codigo){
			try{
				$conexion = Conexion::conectar();
				$ejecutar = $conexion->prepare("delete from sis.t_persona where codigo= ?");							
				$ejecutar->execute(array ($codigo) );	

				if ($ejecutar->rowCount()== 0)
				throw new Exception ("Error al eliminar persona por codigo ");
			}catch(Exception $e){
			throw $e;
			}		
		}

		/**función que permite listar todas las personas en la base de datos     
		Valor de retorno:
		- retorno de todas las personas agregadas anteriormente.
		- retorno de null y la respectiva exception
		*/			
		public static function listarPersona($patron){
			try{
				$conexion = Conexion::conectar();
				$consulta = "select * from sis.t_persona where 	cast(cedula as varchar) like ?
														or upper(nombre1) like upper(?)
														or upper(apellido1) like upper(?)
														or (nombre2) like upper(?)
														or (apellido2) like upper(?)
														or upper(sexo) like upper(?)
													order by cedula asc;";
				$patron = "%".$patron."%";
				
				$ejecutar = $conexion->prepare($consulta);
				
				$ejecutar->execute(array($patron,$patron,$patron,$patron,$patron,$patron));
				
				$lista=$ejecutar->fetchAll();
				if($ejecutar->rowCount()!=0)
				return $lista;
				else
				return NULL;
			}catch(Exception $e){
			throw $e;
			}
		}

		/**función que permite listar todas las personas en la base de datos 
		por su codigo    
		Parametros de entrada:
		-$codigo.
		Valor de retorno:
		- retorno de persona por su codigo.
		- retorno de null y la respectiva exception
		*/				
		public static function obtenerPorCodigo($codigo){
			try{
				$conexion = Conexion::conectar();
				$ejecutar = $conexion->prepare("select * from sis.t_persona where codigo= ?");							
				$ejecutar->execute(array ($codigo) );
				$lista= ($ejecutar->fetchAll());							
				//si no existen personas la respectiva notificacion
				//exception lanzada.
				if ($ejecutar->rowCount()==0)
				throw new Exception ("No existe persona con el codigo: ".$codigo);		
				else 
				//retorno de lista si se encuentran personas por ese codigo.
				return $lista;
			}catch(Exception $e){
			throw $e;
			}
		}

		/**función que permite listar todas las personas en la base de datos 
		por su cedula    
		Parametros de entrada:
		-$cedula
		Valor de retorno:
		- retorno de persona por su cedula
		- retorno de null y la respectiva exception
		*/	
		public static function obtenerPorCedula($cedula){
			try{
				$conexion = Conexion::conectar();
				$ejecutar = $conexion->prepare("select * from sis.t_persona where cedula= ?");							
				$ejecutar->execute(array ($cedula) );
				$lista=($ejecutar->fetchAll());							
				if ($ejecutar->rowCount()==0)
				throw new Exception ("No existe persona con la cedula: ".$cedula);		
				else 
				return $lista;
			}catch(Exception $e){
			throw $e;
			}
		}

		/**función que permite buscar todas las personas en la base de datos 
		por medio de un patron, en este caso es el nombre o apellido de la persona.
		Parametros de entrada:
		-$patron.
		Valor de retorno:
		- retorno de persona por el patron introducido
		- retorno de null y la respectiva exception
		*/	
		public static function obtenerPersonaNombre($patron){
			try{
				$conexion = Conexion::conectar();
				$ejecutar = $conexion->prepare("select * from sis.t_persona where nombre1 like :patron or apellido1 like :patron");
				$parametros = array("patron" => "%".$patron."%");
				$ejecutar->execute($parametros);
				$lista = $ejecutar->fetchAll();
				if ($ejecutar->rowCount()==0)
				throw new Exception("No hay resultados");
				return $lista;
			}catch(Exception $e){
			throw $e;
			}
		}
	}	
?>


