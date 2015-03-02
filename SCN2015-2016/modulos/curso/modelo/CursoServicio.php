<?php
/**
 * @copyright 2014 - Instituto Universtiario de Tecnología Dr. Federico Rivero Palacio
 * @license GPLv3
 * @license http://www.gnu.org/licenses/gpl-3.0.html
 *
 * CursoServicio.php - Servicio del módulo Curso.
 *
 * Esta clase ofrece el servicio de conexión a la base de datos, recibe 
 * los parámetros, construye las consultas SQL, hace las peticiones a 
 * la base de datos y retorna los objetos o datos correspondientes a la
 * acción. Todas las funciones de esta clase relanzan las excepciones si son capturadas.
 * Esto con el fin de que la clase manejadora de errores las capture y procese.
 * Esta clase trabaja en conjunto con la clase Conexion.
 *
 * @link /base/clases/Errores.php 		Clase manejadora de errores.
 * 
 * @link /base/clases/conexion/Conexion.php 	Clase Conexion
 *  
 * @author Geraldine Castillo (geralcs94@gmail.com)
 * @author Juan M. De Sousa (juanmdsousa@gmail.com)
 * 
 * @package Servicios
 */
	class CursoServicio{

		/**
		 * Función que permite listar todos los cursos de un periodo académico.
		 *
		 * Recibe como parámetro el código del periodo y un patrón a buscar. 
		 * Realiza la consulta a la base de datos y retorna un arreglo asociativo de los cursos o
		 * null si no se encontró coincidencia.
		 *
		 * @param int $codigoPeriodo 			Código del periodo con el que se listarán los cursos.
		 * @param string $patron 				Patrón a buscar coincidencias en algunos de los campos. 
		 * Es utilizado para filtrar la búsqueda.
		 * @return array|null					Retorna un arreglo de arreglos asociativos o null de no encontrarse coincidencias.								
		 *
		 * @throws Exception 					Si se producen errores en operaciones con la base de datos.
		 */

		public static function obtenerPorPeriodoAcademico($codigoPeriodo, $patron){
			try{
				
				$conexion=Conexion::conectar();
				$consulta= "select  c.codigo,
									c.capacidad, 
									c.fec_inicio,
									c.seccion,
									c.fec_final,
									c.cod_docente,
									uni.cod_trayecto, 
									uni.nombre,
									t.num_trayecto,
									coalesce(vd.nombre1 || ' ' || vd.apellido1 ,'Sin asignar') as nombrecompleto,
									(select count(*) 
										from sis.t_cur_estudiante as ce
									where ce.cod_curso = c.codigo) as cantidad_estudiantes
								from sis.t_curso as c  inner join sis.t_uni_curricular as uni on c.cod_uni_curricular = uni.codigo
										inner join sis.t_trayecto as t on uni.cod_trayecto = t.codigo
										left join sis.v_docente as vd on c.cod_docente = vd.codigo
								where c.cod_periodo = ?	and (upper(coalesce(vd.nombre1,'Sin asignar')) like upper(?)
												or	upper(coalesce(vd.apellido1,'Sin asignar')) like upper(?)
												or	upper(coalesce(uni.nombre,'Sin asignar')) like upper(?)
												or	upper(coalesce(c.seccion,'Sin asignar')) like upper(?)
												or	upper(upper('Trayecto' || ' ' ||t.num_trayecto)) like upper(?))
								order by t.num_trayecto,c.seccion;




								";
							
				$ejecutar= $conexion->prepare($consulta);
				
				$patron = "%".$patron."%";
								
				$parametros = array($codigoPeriodo,$patron,$patron,$patron,$patron,$patron);
				
				$ejecutar->execute($parametros);
				
				
				
				if($ejecutar->rowCount()!=0){					
					return $ejecutar->fetchAll();
				}
				else
					return null;		
			}catch (Exception $e ){
				throw $e;
			}	
		}
		/**
		 * Función pública y estática que permite eliminar un curso de la base de datos.
		 *
		 * Recibe como parámetro el código del curso a ser eliminado, de poseer éste estudiantes,
		 * se eliminarán antes de hacerlo con el curso.
		 *
		 * @param int $codigoCurso 			Código del Curso a ser eliminado de la base de datos.
		 * 
		 * @throws Exception 				Con el mensaje "Error al eliminar el curso" 
		 * si no se puede llevar a cabo la eliminación.
 		 */		public static function eliminar($codigoCurso){
			try{
				$conexion=Conexion::conectar();
				
				$consulta = " delete from sis.t_cur_estudiante where cod_curso = ?";
				
				$consulta2 = "delete from sis.t_curso where codigo = ?";
				
				$ejecutar = $conexion->prepare($consulta);
				
				$ejecutar2 = $conexion->prepare($consulta2);
				//inicia una transacción			
				$conexion->beginTransaction();
				
				$ejecutar->execute(array($codigoCurso));
				$ejecutar2->execute(array($codigoCurso));
				if ($ejecutar2->rowCount()==0){
				//revierte todas las acciones hasta el inicio de la transacción si hubo error al eliminar el curso
				$conexion->rollBack();
				throw new Exception ("Error al eliminar el curso ");
				}
				$conexion->commit();
			}catch (Exception $e){
				throw $e;
			}
			
		}
		/**
		 * Función pública y estática que permite obtener los cursos por código del docente.
		 *
		 * Recibe como parámetro el código del docente de haber coincidencias, retorna un arreglo
		 * de arreglos asociativos, sino, retorna null.
		 *
		 * @param int $codDocente 			Código del Docente.
		 *
		 * @return array|null				De haber coincidencias retorna un arreglo de arreglos asociativos,
		 * de no haberla, retorna null.
		 *
		 * @throws Exception 				Si se producen errores en operaciones con la base de datos.
		 */

		public static function obtenerPorDocente($codDocente){
			try{
				$conexion = Conexion::conectar();
				$consulta = "select c.codigo,
									c.capacidad, 
									c.fec_inicio,
									c.seccion,
									c.fec_final,
									c.cod_docente,
									uni.cod_trayecto, 
									uni.nombre,
									t.num_trayecto,
									vd.nombre1 || ' ' || vd.apellido1 as nombrecompleto,
									(select count(*) 
										from sis.t_cur_estudiante as ce
									where ce.cod_curso = c.codigo) as cantidad_estudiantes
							from sis.t_curso as c  inner join sis.t_uni_curricular as uni on c.cod_uni_curricular = uni.codigo
										inner join sis.t_trayecto as t on uni.cod_trayecto = t.codigo
										left join sis.v_docente as vd on c.cod_docente = vd.codigo
							where c.cod_docente =? 
							order by t.num_trayecto,c.seccion";

				$ejecutar = $conexion->prepare($consulta);
				$ejecutar->execute(array($codDocente));

				if($ejecutar->rowCount()==0)
					return null;
				else
					return $ejecutar->fetchAll();
			}catch (Exception $e){
				throw $e;
			}
		}
		/**
		 * Función pública y estática que permite obtener un curso por su código.
		 *
		 * Recibe el código del curso a consultar como parámetro. 
		 * De existir coincidencia retorna un arreglo de arreglos asociativos, 
		 * sino, retorna null.
		 *
		 * @param int $codigo 				Código del Curso a consultar.
		 *
		 * @return array|null				De existir coincidencia, retorna un arreglo de arreglos asociativos.
		 * De no haberla, retorna null.
		 *
		 * @throws Exception 				Si se producen errores en operaciones con la base de datos.
		 */

		public static function obtenerCursoPorCodigo($codigo){
			try{
				$conexion = Conexion::conectar();

				$consulta = "select c.codigo,
									c.capacidad, 
									c.fec_inicio,
									c.seccion,
									c.fec_final,
									uni.cod_trayecto, 
									uni.nombre,
									t.num_trayecto,
									vd.nombre1 || ' ' || vd.apellido1 as nombrecompleto,
									(select count(*) 
										from sis.t_cur_estudiante as ce
									where ce.cod_curso = c.codigo) as cantidad_estudiantes
							from sis.t_curso as c  inner join sis.t_uni_curricular as uni on c.cod_uni_curricular = uni.codigo
										inner join sis.t_trayecto as t on uni.cod_trayecto = t.codigo
										left join sis.v_docente as vd on c.cod_docente = vd.codigo
							where c.codigo =? 
							order by t.num_trayecto,c.seccion";

				$ejecutar = $conexion->prepare($consulta);
				$ejecutar = $conexion->execute($consulta);

				if($ejecutar->rowCount()==0)
					return null;
				else
					return $ejecutar->fetchAll();
			}catch (Exception $e){
				throw $e;
			}
		}
		/**
		 * Función pública y estática que permite obtener cursos por código de periodo y sección.
		 *
		 * Recibe el código del periodo y sección. 
		 * De existir coincidencia retorna un arreglo asociativo, 
		 * sino, retorna null.
		 *
		 * @param int $codPeriodo 				Código del periodo.
		 * @param int $seccion 				Código de la sección.
		 *
		 * @return array|null				De existir coincidencia, retorna un arreglo de arreglos asociativos.
		 * De no haberla, retorna null.
		 *
		 * @throws Exception 				Si se producen errores en operaciones con la base de datos.
		 */
	
		public static function obtenerCursoPorSeccionPeriodo($codPeriodo,$seccion){
			try{
				$conexion=Conexion::conectar();
				$consulta="select curso.* from sis.t_curso as curso where seccion=? and   cod_periodo=?"; 
				$ejecutar=$conexion->prepare($consulta);
				$ejecutar->execute(array($codPeriodo,$seccion));
				if ($ejecutar->rowCount() == 0)
					return null;
				else 
					return $ejecutar->fetchAll();
			}catch (Exception $e){
				throw $e; 
			}	
		}
		/**
		 * Función pública y estática que permite modificar un curso de la base de datos.
		 *
		 * Esta función es parte de un polimorfismo de modificar.
		 * Es la función encargada de modificar cursos cuando los parámetros sean variables.
		 *
		 * @param int $codigo 				Código del Curso a ser modificado.
		 * @param int $codPeriodo 			Código del Periodo del Curso a ser modificado.
		 * @param int $codUniCurricular 	Código de la Unidad Curricular del Curso a ser modificado.
		 * @param int $codDocente 			Código del Docente del Curso a ser modificado.
		 * @param string $seccion 			Sección del Curso a ser modificado.
		 * @param string $fechaInicio 		Fecha de Inicio del Curso a ser modificado.
		 * @param string $fechaFinal 		Fecha final del Curso a ser modificado.
		 * @param int $capacidad 			Capacidad del curso a ser modificado.
		 * @param string $observaciones 	Observaciones del Curso a ser modificado.
		 *
		 * @throws Exception 				Con el mensaje "No se puede modificar el curso"
		 * si la operación no se puede llevar a cabo.
		 */
	
		public static function modificarD($codigo,$codPeriodo,$codUniCurricular,$codDocente,$seccion,$fechaInicio,$fechaFinal,$capacidad,$observaciones){
			try{
				$conexion=Conexion::conectar();
				$consulta="update  sis.t_curso 
								set cod_periodo=?,
								cod_uni_curricular=?, cod_docente=?,
								seccion=?,fec_inicio=?,fec_final=?,
								capacidad=?,observaciones=? where codigo=?
								"; 
				$ejecutar=$conexion->prepare($consulta);
				$ejecutar->execute(array($codPeriodo,$codUniCurricular,
										 $codDocente,$seccion,$fechaInicio,
										 $fechaFinal,$capacidad,$observaciones,
										 $codigo));
				if ($ejecutar->rowCount() == 0)
					throw new Exception("No se puede modificar el curso");
			}catch (Exception $e){
				throw $e; 
			}	
		}
		/**
		 * Función pública y estática que permite modificar un curso de la base de datos.
		 *
		 * Esta función es parte de un polimorfismo de modificar.
		 * Es la función encargada de modificar cursos cuando el parámetro sea un objeto.
		 *
		 * @param object $curso 			Objeto Curso a ser modificado.
		 *
		 * @throws Exception 				Con el mensaje "No se puede modificar el curso"
		 * cuando la operación no se pueda llevar a cabo.
		 */
		public static function modificarO($curso){
			try{
				$conexion=Conexion::conectar();
				$consulta="update  sis.t_curso 
								set cod_periodo=?,
								cod_uni_curricular=?, cod_docente=?,
								seccion=?,fec_inicio=?,fec_final=?,
								capacidad=?,observaciones=? where codigo=?
								"; 
				$ejecutar=$conexion->prepare($consulta);
				$ejecutar->execute(array($curso->obtenerCodPeriodo(),
										 $curso->obtenerCodUniCurricular(),
										 $curso->obtenerCodDocente(),
										 $curso->obtenerSeccion(),
										 $curso->obtenerFecInicio(),
										 $curso->obtenerFecFinal(),
										 $curso->obtenerCapacidad(),
										 $curso->obtenerObservaciones(),
										 $curso->obtenerCodigo()
										));
				if ($ejecutar->rowCount() == 0)
					throw new Exception("No se puede modificar el curso");		
			}catch (Exception $e){
				throw $e;
			}	
		}

		/**
		 * Función pública y estática que permite modificar un curso de la base de datos.
		 *
		 * Esta función es el padre del polimorfismo de modificar y evalúa si los parámetros
		 * de entrada son variables o es un objeto de tipo Curso. Sea cualquiera de los dos casos, llama
		 * a sus respectivas funciones y le pasa los parámetros que recibe.
		 *
		 * @var array $p 				Arreglo de parámetros.
		 * @var int $nArg 				Cantidad de parámetros.
		 *
		 * @throws Exception 			Con el mensaje "Cantidad de parámetros incorrecta"
		 * si la cantidad de parámetros es diferente de 9.
		 */

		public static function modificar(){
			try{
				$nArg=func_num_args();
				if ($nArg==1){
					$p=func_get_arg(0);
					if ((is_object($p)) && (get_class($p)=='Curso'))
						self::modificarO($p);
				}else{
					if ($nArg!= 9)
						throw new Exception ('cantidad de parámetros incorrecta');
					else
						self::modificarD(func_get_arg(0),func_get_arg(1),func_get_arg(2),func_get_arg(3),
						func_get_arg(4),func_get_arg(5),func_get_arg(6),func_get_arg(7),func_get_arg(8));
				}
			}catch (Exception $e){
				throw $e;
			}
		}
		
		/**
		 * Función pública y estática que permite agregar un curso a la base de datos.
		 *
		 * Esta función es parte de un polimorfismo de agregar.
		 * Es la encargada de agregar un curso cuando los parámetros son variables.
		 *
		 * @param int $codPeriodo 				Código del Periodo del Curso a agregar.
		 * @param int $codUniCurricular 		Código de la Unidad Curricular del Curso a agregar.
		 * @param int $codDocente 				Código del Docente del Curso a agregar.
		 * @param string $seccion 				Sección del Curso a agregar.
		 * @param string $fechaInicio 			Fecha de Inicio del Curso a agregar.
		 * @param string $fechaFinal 			Fecha del Fin del Curso a agregar.
		 * @param int $capacidad 				Capacidad del Curso a agregar.
		 * @param string $observaciones 		Observaciones del Curso a agregar.
		 *
		 * @throws Exception 					Con el mensaje "No se puede agregar el curso"
		 * cuando no se haya llevado a cabo esta operación.
		 */	
		public static function agregarD($codPeriodo,$codUniCurricular,$codDocente,$seccion,$fechaInicio,$fechaFinal,$capacidad,$observaciones){
			try{
				$conexion=Conexion::conectar();
				$codigo=self::obtenerMaxCodCurso()+1;
				$consulta="insert into sis.t_curso (codigo, cod_periodo,cod_uni_curricular,cod_docente , seccion,
													fec_inicio,fec_final, capacidad,observaciones) 
													values (?,?,?,?,?,?,?,?,?)";
				$ejecutar=$conexion->prepare($consulta);
				$ejecutar->execute(array($codigo,$codPeriodo,$codUniCurricular,$codDocente,
										  $seccion,$fechaInicio,$fechaFinal,$capacidad,$observaciones));
				if ($ejecutar->rowCount()==0)
					throw new Exception("No se puede agregar el curso");											
			}catch (Exception $e){
					throw $e;
			}
		}

		/**
		 * Función pública y estática que permite obtener el máximo código de la tabla t_curso.
		 *
		 * Recibe como parámetro el Código del Periodo, el Código de la Unidad Curricular y la Sección.
		 * Retorna un entero con el máximo código.
		 * 
		 * @param int $codPeriodo 				Código del Periodo de los Cursos que se desean consultar.
		 * @param int $cod_uni_curricular 		Código de la Unidad Curricular de los cursos que se desean consultar.
		 * @param string $seccion 				Sección de los cursos que se desean consultar.
		 *
		 * @return int 							El máximo código de los cursos consultados.
		 *
		 * @throws Exception 					Si se producen errores en operaciones con la base de datos.
		 */
		public static function obtenerMaxCodCurso($codPeriodo,$cod_uni_curricular,$seccion){
				try{
					$conexion=Conexion::conectar();
					$consulta="select  codigo from sis.t_curso where cod_periodo=? and cod_uni_curricular=? and seccion=?";
					$ejecutar=$conexion->prepare($consulta);
					$ejecutar->execute(array($codPeriodo,$cod_uni_curricular,$seccion));
					$r= $ejecutar->fetchAll();
					return $r[0][0];
				}catch(Exception $e){
					throw $e; 
				}
		}
		/**
		 * Función pública y estática que permite agregar un curso a la base de datos.
		 *
		 * Esta función es parte de un polimorfismo de agregar.
		 * Es la encargada de agregar un curso cuando el parámetro de entrada es un objeto Curso.
		 *
		 * @param object Curso 					Objeto Curso que se desea agregar a la base de datos.
		 *
		 * @throws Exception 					Con el mensaje "No se puede agregar el curso"
		 * si no se pudo llevar a cabo la operación.
		 */
		public static function agregarO($curso){
			try{
				$conexion=Conexion::conectar();
				
				//$conexion->beginTransaction();
				
				$consulta="insert into sis.t_curso ( cod_periodo,cod_uni_curricular,cod_docente , seccion,
													fec_inicio,fec_final, capacidad,observaciones) 
													values (?,?,?,?,?,?,?,?)";
				$ejecutar=$conexion->prepare($consulta);
				$ejecutar->execute(array(//$codigo,	
										 $curso->obtenerCodPeriodo(),
										 $curso->obtenerCodUniCurricular(),
										 $curso->obtenerCodDocente(),
										 $curso->obtenerSeccion(),
										 $curso->obtenerFecInicio(),
										 $curso->obtenerFecFinal(),
										 $curso->obtenerCapacidad(),
										 $curso->obtenerObservaciones()
										));
				//$conexion->commit(); 
				if ($ejecutar->rowCount()==0)
					throw new Exception("No se puede agregar el curso");
					
					
			}catch(Exception $e){
				throw $e;
			}
		}
		/**
		 * Función pública y estática que permite agregar un curso a la base de datos.
		 *
		 * Esta función es el padre del polimorfismo de agregar y evalúa si los parámetros
		 * de entrada son variables o es un objeto de tipo Curso. Sea cualquiera de los dos casos,
		 * llama a la a sus respectivas funciones y le pasa los parámetros que recibe.
		 *
		 * @var array $p 					Parámetros de Entrada.
		 * @var int $nArg 					Cantidad de Parámetros.
		 *
		 * @throws Exception 				Con el mensaje "cantidad de parámetros incorrecta"
		 * si la cantidad de parámetros es diferente de 8.
		 */
		public static function agregar(){
			try{
				$nArg=func_num_args();
				if ($nArg==1){
					$p=func_get_arg(0);
					if ((is_object($p)) && (get_class($p)=='Curso'))
						self::agregarO($p);
				}else{
					if ($nArg!= 8)
						throw new Exception ('cantidad de parámetros incorrecta');
					else
						self::agregarD(func_get_arg(0),func_get_arg(1),func_get_arg(2),func_get_arg(3),
						func_get_arg(4),func_get_arg(5),func_get_arg(6),func_get_arg(7));
				}
			}catch (Exception $e){
				throw $e;
			}
		}
		/**
		 * Función pública y estática que permite obtener un curso de la base de datos.
		 *
		 * Recibe como parámetros el código del curso a consultar y el tipo de respuesta.
		 * $tipoRe de no recibir algún valor, será true por defecto.
		 *
		 * @param int $codigo 					Código del Curso a consultar.
		 * @param boolean $tipoRe 				True si se desea retornar un arreglo de objetos Curso y 
		 * false si se desea retornar un arreglo de arreglos asociativos.
		 *
		 * @return mixed 						Dependiendo del parámetro $tipoRe, retorna un arreglo de objetos Curso 
		 * o un arreglo de arreglos asociativos.
		 *
		 * @throws Exception 					Con el mensaje "no existe el curso" si la consulta no arrojó resultados.
		 */
		public static function obtener($codigo,$tipoRe=true){
			try{
				$conexion=Conexion::conectar();
				$consulta="select * from sis.t_curso where codigo=?";
				$ejecutar=$conexion->prepare($consulta);
				$ejecutar->execute(array($codigo));
	
				if($ejecutar->rowCount()!=0){
					$cursoA=$ejecutar->fetchAll();
					return self::retornarCursos($cursoA, $tipoRe);
				}		
				else
					throw new Exception("no existe el curso");		
			}catch(Exception $e){
				throw $e;
			}
		}
		/**
		 * Función pública y estática que permite eliminar un estudiante de un curso.
		 *
		 * Recibe como parámetros el código del curso y el código del estudiante a eliminar del curso.
		 *
		 * @param int $codCurso 				Código del Curso al que pertenece el estudiante.
		 * @param int $codestudiante 			Código del Estudiante a ser eliminado del curso.
		 *
		 * @throws Exception 					Con el mensaje "No se puede eliminar el curso"
		 * de no llevarse a cabo esta operación.
		 */
		public static function eliminarEstudiante($codCurso,$codEstudiante){
			try{
				$conexion=Conexion::conectar();
				$consulta="delete from sis.t_cur_estudiante where  cod_estudiante=? and cod_curso=?";
				$ejecutar=$conexion->prepare($consulta);
				$ejecutar->execute(array($codEstudiante,$codCurso));
				if ($ejecutar->rowCount()==0)
					throw new Exception("No se puede eliminar el curso");		 
			}catch (Exception $e){
				throw $e;
			}
		}
		
		/**
		 * Función pública y estática que permite agregar un estudiante a un curso.
		 *
		 * Esta función forma parte del polimorfismo agregarEstudiante.
		 * Es la encargada de agregar un estudiante a un curso cuando el parámetro es un objeto CurEstudiante.
		 *
		 * @param object $estCurso 					Objeto CurEstudiante a ser agregado a la base de datos.
		 *
		 * @throws Exception 						Con el mensaje "No se puede agregar el estudiante al curso"
		 * cuando no se puede llevar a cabo la operación.
		 */

		public static function agregarEstudianteO($estCurso){
			try{
				$codigo=self::obtenerMaxCodEstCurso()+1;
				$conexion=Conexion::conectar();
				$consulta="insert into sis.t_cur_estudiante 
								(codigo,cod_estudiante,cod_curso,
								por_asistencia,nota,cod_estado,observaciones)
								values
								(?,?,?,?,?,?,?)";
								
				$ejecutar=$conexion->prepare($consulta);
				$ejecutar->execute(array($codigo,
										$estCurso->obtenerCodEstudiante(),
										$estCurso->obtenerCodCurso(),
										$estCurso->obtenerPorAsistencia(),
										0,
										$estCurso->obtenerEstado(),
										$estCurso->obtenerObservaciones()
										));
				if ($ejecutar->rowCount()==0)
					throw new Exception("No se puede agregar el estudiante al curso");	
			}catch(Exception $e){
				throw $e;
			} 
		}
		/**
		 * Función pública y estática que permite obtener el máximo código de la tabla cur_estudiante.
		 *
		 * Retorna el máximo código de la tabla cur_estudiante, de estar vacía, retorna 0.
		 *
		 * @return int 						Máximo código de la tabla cur_estudiante.
		 *
		 * @throws Exception 				Si se producen errores en operaciones con la base de datos.
		 */
		public static function obtenerMaxCodEstCurso(){
				try{
					$conexion=Conexion::conectar();
					$consulta="select coalesce(max(codigo),0) from sis.t_cur_estudiante";
					$ejecutar=$conexion->query($consulta);
					$r= $ejecutar->fetchAll();
					return $r[0][0];
				}catch(Exception $e){
					throw $e;
				}
		}

		/**
		 * Función pública y estática que permite agregar un estudiante a un curso.
		 *
		 * Esta función forma parte del polimorfismo agregarEstudiante.
		 * Es la encargada de agregar un estudiante a un curso cuando los parámetros son variables.
		 *
		 * @param int $codigoEstudiante 			Código del Estudiante que será agregado al curso.
		 * @param int $codigoCurso 					Código del Curso donde será agregado el estudiante.
		 * @param int $porAsistencia 				Porcentaje de Asitencia del estudiante en el curso.
		 * @param int $nota 						Nota del estudiante en el curso.
		 * @param char $estado   					Estado del estudiante en el curso.
		 * @param string $observaciones 			Observaciones del estudiante en el curso.
		 *
		 * @throws Exception 						Con el mensaje "No se puede agregar el estudiante al curso"
		 * cuando no se puede llevar a cabo la operación.
		 */
		public static function agregarEstudianteD($codigoEstudiante,$codigoCurso,$porAsistencia,$nota,$estado,$observaciones){
				try{
				$codigo=self::obtenerMaxCodEstCurso()+1;
				$conexion=Conexion::conectar();
				$consulta="insert into sis.t_cur_estudiante 
								(codigo,cod_estudiante,cod_curso,
								por_asistencia,nota,cod_estado,observaciones)
								values
								(?,?,?,?,?,?,?)";
				$ejecutar=$conexion->prepare($consulta);
				$ejecutar->execute(array($codigo,
										$codigoEstudiante,
										$codigoCurso,
										$porAsistencia,
										0,
										$estado,
										$observaciones));
				if ($ejecutar->rowCount()==0)
					throw new Exception("No se puede agregar el estudiante al curso");	
			}catch(Exception $e){
				throw $e;
			} 
		}

		/**
		 * Función pública y estática que permite agregar un estudiante a un curso.
		 *
		 * Esta función es el padre del polimorfismo agregarEstudiante y evalúa si los parámetros
		 * de entrada son variables o un objeto CurEstudiante. Cualquiera de los dos casos, llama
		 * a su función respectiva y le pasa los parámetros que recibe.
		 *
		 * @var array $p 					Arreglo de parámetros.
		 * @var int $nArg 					Cantidad de parámetros.
		 *
		 * @throws Exception 				Con el mensaje "cantidad de parámetros incorrecta"
		 * si la cantidad de parámetros es diferente de 6.
		 */
		public static function agregarEstudiante(){
			try{
				$nArg=func_num_args();
				if ($nArg==1){
					$p=func_get_arg(0);
					if ((is_object($p)) && (get_class($p)=='CurEstudiante'))
						self::agregarEstudianteO($p);
				}else{
					if ($nArg!= 6)
						throw new Exception ('cantidad de parámetros incorrecta');
					else
						self::agregarEstudianteD(func_get_arg(0),func_get_arg(1),func_get_arg(2),func_get_arg(3),
						func_get_arg(4),func_get_arg(5));
				}
			}catch (Exception $e){
				throw $e;
			}
			
		}
		/**
		 * Función pública y estática que permite obtener un estudiante de un curso.
		 *
		 * Recibe como parámetros el código del estudiante, el código del curso y el tipo de retorno.
		 * $tipoRe de no recibir algún valor, será true por defecto.
		 *
		 * @param int $codigoEstudiante 				El código del estudiante a consultar.
		 * @param int $codigoCurso						El código del curso donde se encuentra el estudiante.
		 * @param boolean $tipoRe 						True cuando se quiere retornar un arreglo de objetos y
		 * false cuando se quiere un arreglo de arreglos asociativos.
		 *
		 * @throws Exception 							Con el mensaje "no existe el estudiante" en caso 
		 * que no hayan coincidencias.
		 */	
		public static function obtenerEstudiante($codigoEstudiante,$codigoCurso,$tipoRe=true){
			try{
				$conexion=Conexion::conectar();
				$consulta="select * from sis.t_cur_estudiante where cod_estudiante=? and cod_curso=?";
				$ejecutar=$conexion->prepare($consulta);
				$ejecutar->execute(array($codigoEstudiante,
										$codigoCurso));
				if ($ejecutar->rowCount()==0)
					throw new Exception ('no existe el estudiante');
				else {
					$curEstudiante=$ejecutar->fetchAll();
					return self::retornarEstudiantes($curEstudiante, $tipoRe);
				}
			}catch(Exception $e){
				throw $e;
			}
			
		}

		/**
		 * Función pública y estática que permite obtener los estudiantes de un curso.
		 * 
		 * Recibe como parámetros el código del curso del que se desea consultar los estudiantes
		 * y el tipo de retorno.
		 * $tipoRe de no recibir algún valor, será true por defecto.
		 *
		 * @param int $codigoCurso 					Código del Curso que se desean consultar sus estudiantes.
		 * @param boolean $tipoRe 					True si se desea retornar un arreglo de objetos y
		 * false si se desea retornar un arreglo de arreglos asociativos.
		 *
		 * @throws Exception 						Si se producen errores en operaciones con la base de datos.
		 */	
		public static function obtenerEstudiantes($codigoCurso,$tipoRe=true){
				try{
					$conexion=Conexion::conectar();
					$consulta="select 	cur.cod_curso,
										est.codigo,
										est.cedula, 
										est.nombre1, 
										est.apellido1, 
										cur.nota, 
										cur.por_asistencia,
										cur.observaciones,
										cur.cod_estado,
										sta.nombre from sis.t_cur_estudiante as cur
										inner join sis.t_persona as est 
											on (est.codigo = cur.cod_estudiante)
										inner join sis.t_est_cur_estudiante as sta 
											on (cur.cod_estado = sta.codigo) and cur.cod_curso = ? 
										order by sta.nombre,est.cedula,cur.nota";

					$ejecutar=$conexion->prepare($consulta);
					$ejecutar->execute(array($codigoCurso));

					if($ejecutar->rowCount()!=0){
						$estudiantes=$ejecutar->fetchAll();
						return self::retornarEstudiantes($estudiantes, $tipoRe);
					}
					else
						return null;	
					
				}catch (Exception $e){
						throw $e;
				}
		}

		/**
		 * Función pública y estática que permite modificar un estudiante de un curso.
		 *
		 * Esta función es parte del polimorfismo de modificarEstudiante.
		 * Es la encargada de modificar un estudiante cuando los parámetros de entrada son variables.
		 *
		 * @param int $codigoEstudiante 			Código del estudiante que se desea modificar.
		 * @param int $codigoCurso					Código del Curso del estudiante que se desea modificar.
		 * @param int $porAsistencia 				Porcentaje de Asistencia en el curso del estudiante que se desea modificar.
		 * @param int $nota 						Nota en el curso del estudiante que se desea modificar.
		 * @param char $codEstado 					Estado en el curso del estudiante que se desea modificar.
		 * @param string $observaciones 			Observaciones de el estudiante que se desea modificar.
		 *
		 * @throws Exception 						Con el mensaje "No se puede modificar el estudiante" cuando
		 * no se puede llevar a cabo la operación.
		 */
	
		public static function modificarEstudianteD($codigoEstudiante,$codigoCurso,$porAsistencia,$nota,$codEstado,$observaciones){
			try{
				$conexion=Conexion::conectar();
				$consulta="update sis.t_cur_estudiante set 	por_asistencia=?,
															nota=?,
															cod_estado=?,
															observaciones=? 
								where cod_estudiante=? and cod_curso=?";
				$ejecutar=$conexion->prepare($consulta);
				$ejecutar->execute(array($porAsistencia,
										$nota,
										$codEstado,
										$observaciones,
										$codigoEstudiante,
										$codigoCurso));
				if ($ejecutar->rowCount()==0)
					throw new Exception("No se puede modificar el estudiante");	
			}catch(Exception $e){
				throw $e;
			}
			
		}
		/**
		 * Función pública y estática que permite modiciar un estudiante de un curso.
		 *
		 * Esta función forma parte del polimorfismo de modificarEstudiante.
		 * Es la encargada de modificar un estudiante cuando el parámetro de entrada es un objeto CurEstudiante.
		 *
		 * @param object $curEstudiante  				Objeto CurEstudiante a modificar.
		 *
		 * @throws Exception 							Con el mensaje "No se puede modificar el estudiante" cuando
		 * no se puede llevar a cabo la operación.
		 */
		public static function modificarEstudianteO($curEstudiante){
			try{
				$conexion=Conexion::conectar();
				$consulta="update sis.t_cur_estudiante set 	por_asistencia=?,
															nota=?,
															cod_estado=?,
															observaciones=? 
								where cod_estudiante=? and cod_curso=?";
				$ejecutar=$conexion->prepare($consulta);
				$ejecutar->execute(array($curEstudiante->obtenerPorAsistencia(),
										$curEstudiante->obtenerNota(),
										$curEstudiante->obtenerEstado(),
										$curEstudiante->obtenerObservaciones(),
										$curEstudiante->obtenerCodEstudiante(),
										$curEstudiante->obtenerCodCurso()
									));
				if ($ejecutar->rowCount()==0)
					throw new Exception("No se puede modificar el estudiante");
			}catch(Exception $e){
				throw $e;
			}	
		}
		/**
		 * Función pública y estática que permite modificar un estudiante de un curso.
		 *
		 * Esta función es la padre del polimorfismo de modificarEstudiante y evalúa si los parámetros de
		 * entrada son variables o es un objeto CurEstudiante. En cualquiera de los dos casos, llama
		 * a la respectiva función y le pasa los parámetros que entraron.
		 *
		 * @var array $p 					Arreglo de parámetros.
		 * @var int $nArg 					Cantidad de parámetros.
		 *
		 * @throws Exception 				Con el mensaje "cantidad de parámetros incorrecta" si la 
		 * cantidad de parámtros es distinta de 6.
		 */
		public static function modificarEstudiante(){
			try{
				$nArg=func_num_args();
				if ($nArg==1){
					$p=func_get_arg(0);
					if ((is_object($p)) && (get_class($p)=='CurEstudiante'))
						self::modificarEstudianteO($p);
				}else{
					if ($nArg!= 6)
						throw new Exception ('cantidad de parámetros incorrecta');
					else
						self::modificarEstudianteD(func_get_arg(0),func_get_arg(1),func_get_arg(2),func_get_arg(3),
						func_get_arg(4),func_get_arg(5));
				}
			}catch (Exception $e){
				throw new Exception("Hubo un error al modificar el estudiante. Por favor, revise los datos.");
			}
		}
		/**
		 * Función pública y estática que permite obtener los cursos por el código del docente y el código del periodo.
		 *
		 * Recibe como parámetros el código del docente, el código del periodo y el tipo de respuesta.
		 * $tipoRe de no recibir algún valor, será true por defecto.
		 *
		 * @param int $codDocente 				Código del Docente por el que se buscarán los cursos.
		 * @param int $codPeriodo 				Código del Periodo por el que se buscarán los cursos.
		 * @param boolean $tipoRe				True si se desea retornar un arreglo de objetos Curso y
		 * false si se desea retornar un arreglo de arreglos asociativos.
		 *
		 * @return array|null 					Retorna un arreglo de objetos o un arreglo de arreglos asociativos
		 * de acuerdo al parámetro $tipoRe, de no haber coincidencias, retorna null.
		 *
		 */
		public static function obtenerCursosPorDocente($codDocente,$codPeriodo,$tipoRe=true){
			try{
				$conexion=Conexion::conectar();
				$consulta="select * from sis.t_curso where cod_docente=?and cod_periodo=?";
				$ejecutar=$conexion->prepare($consulta);
				$ejecutar->execute(array($codDocente,$codPeriodo));
				if($ejecutar->rowCount()!=0){
					$cursosM= $ejecutar->fetchAll();
					return self::retornarCursos($cursosM, $tipoRe);
				
				}else 
					return null;
			}catch (Exception $e){
				throw $e;	
			}
			
		}
		/**
		 * Función privada y estática que permite retornar estudiantes en un arreglo de objetos o de arreglos asociativos.
		 *
		 * Recibe como parámetros un arreglo de arreglos asociativos y el tipo de respuesta.
		 * Si el tipo de respuesta es true, los arreglos asociativos se recorren y se van creando
		 * objetos CurEstudiante que se llenan con la información del arreglo. Dichos objetos se almacenan en
		 * otro arreglo y éste es retornado.
		 * Si el tipo de respuesta es false, se retorna el arreglo de arreglos asociativos.
		 * $tipoRe de no recibir algún valor, será true por defecto.
		 *
		 * @param array $curEstudiante 				Arreglo de arreglos asociativos.
		 * @param boolean $tipoRe					Si es true, se retorna un arreglo con ojetos CurEstudiante, si
		 * es false, se retorna un arreglo de arreglos asociativos.
		 *
		 * @return array 							Dependiendo del tipo de respuesta, el arreglo contendrá objetos
		 * o arreglos asociativos.
		 */
		private static function retornarEstudiantes($curEstudiante, $tipoRe){
			if ($tipoRe){
					for($i = 0; $i < count($curEstudiante); $i++){
						$curEst = new CurEstudiante();
							
						$curEst->asignarCodigo($curEstudiante[$i]['codigo']);
						$curEst-> asignarCodEstudiante($curEstudiante[$i]['cod_estudiante']);
						$curEst->asignarCodCurso($curEstudiante[$i]['cod_curso']);
						$curEst->asignarPorAsistencia($curEstudiante[$i]['por_asistencia']);
						$curEst->asignarNota($curEstudiante[$i]['nota']);
						$curEst->asignarEstado($curEstudiante[$i]['cod_estado']);
						$curEst->asignarObservaciones($curEstudiante[$i]['observaciones']);
		
						$curEsts[]=$curEst;
					}
				return $curEsts;
			}
				else
					return $curEstudiante;
		}
		/**
		 * Función privada y estática que permite retornar cursos en un arreglo de objetos o de arreglos asociativos.
		 *
		 * Recibe como parámetros un arreglo de arreglos asociativos y el tipo de respuesta.
		 * Si el tipo de respuesta es true, los arreglos asociativos se recorren y se van creando
		 * objetos Curso que se llenan con la información del arreglo. Dichos objetos se almacenan en
		 * otro arreglo y éste es retornado.
		 * Si el tipo de respuesta es false, se retorna el arreglo de arreglos asociativos.
		 * $tipoRe de no recibir algún valor, será true por defecto.
		 *
		 * @param array $cursosA 					Arreglo de arreglos asociativos.
		 * @param boolean $tipoRe					Si es true, se retorna un arreglo con ojetos Curso, si
		 * es false, se retorna un arreglo de arreglos asociativos.
		 *
		 * @return array 							Dependiendo del tipo de respuesta, el arreglo contendrá objetos
		 * o arreglos asociativos.
		 */	
		private static function retornarCursos($cursosA, $tipoRe){
			if ($tipoRe){
					for($i = 0; $i < count($cursosA); $i++){
						$curso=new Curso();
						$curso->asignarCodigo($cursosA[$i][0]);
						$curso->asignarPeriodo($cursosA[$i][1]);
						$curso->asignarCodUniCurricular($cursosA[$i][2]);
						$curso->asignarCodDocente($cursosA[$i][3]);
						$curso->asignarSeccion($cursosA[$i][4]);
						$curso->asignarFecInicio($cursosA[$i][5]);
						$curso->asignarFecFinal($cursosA[$i][6]);
						$curso->asignarCapacidad($cursosA[$i][7]);
						$curso->asignarObservaciones($cursosA[$i][8]);
						$cursos[]=$curso;
		
					}
			return $cursos;
			}
			else
				return $cursosA;
		}
	
		/**
		 * Función pública y estática que obtiene un curso por código de periodo, trayecto y sección.
		 *
		 * Recibe como parámetros el código de peridoo, trayecto y sección del curso que se quiere consultar.
		 * De haber resultado, se retorna un arreglo de arreglos asociativos.
		 * De lo contrario se retorna null.
		 *
		 * @param int $codigoPeriodo 			Código del Periodo del curso a consultar.
		 * @param int $trayecto 				Número del Trayecto del curso a consultar.
		 * @param string $seccion 				Sección del curso a consultar.
		 *
		 * @return array|null 					De haber coincidencia, retorna un arreglo de arreglos asociativos.
		 * Sino, retorna null.
		 */
		public static function obtenerSeccionUnCurr($codigoPeriodo,$trayecto,$seccion){
			try{
				$conexion=Conexion::conectar();
				$consulta= "select c.*,uc.codigo as codigo_unidad,uc.nombre, coalesce(per.nombre1 || ' ' || per.apellido1,'') as nombrecompleto 
						from sis.t_uni_curricular as uc left join 
							(select cu.*
							from sis.t_curso as cu
							where cu.seccion= ?
							and cu.cod_periodo= ?) as c
							on uc.codigo=c.cod_uni_curricular
							left join sis.t_persona as per on c.cod_docente = per.codigo
						where uc.cod_trayecto= ? and exists(select codigo 
						from sis.t_periodo as pe where pe.codigo= ?);";
							
				$ejecutar= $conexion->prepare($consulta);
				
				$ejecutar->execute(array($seccion,$codigoPeriodo,$trayecto,$codigoPeriodo));
				
				if($ejecutar->rowCount()!=0){
					return $ejecutar->fetchAll();
				}
				else
					return null;		
			}catch (Exception $e){
				throw $e;
			}	
		}
		/**
		 * Función pública y estática que obtiene los cursos disponibles para un estudiante.
		 * 
		 * Recibe como parámetros un código de estudiante y retorna los cursos que puede
		 * cursar ese estudiante, sigue una regla de prelaciones y verifica que
		 * no esté inscrito en otros cursos donde dicten esa unidad curricular.
		 * 
		 * @param integer $cod_estudiante 		El código del estudiante en cuestión.
		 * 
		 * @return array|null					Retorna un arreglo asociativo de existir
		 * una respuesta, retorna null de no existir.
		 * 
		 */
		public static function cursosDisponiblesCursados($cod_estudiante){
			try{
				$conexion=Conexion::conectar();
				$consulta= "select curso.codigo ,persona.nombre1 as nombre ,persona.apellido1 as apellido,
							uni_cur.nombre as uni_curr,cur_estudiante.cod_estado as estado,
							trayecto.num_trayecto as trayecto,curso.seccion,cur_estudiante.nota,uni_cur.codigo
							as cod_uni, periodo.cod_estado
								from sis.t_curso as curso 
								left join (select cur_estud.* from sis.t_cur_estudiante as cur_estud 
										where cur_estud.cod_estudiante=?)as cur_estudiante 
								on curso.codigo= cur_estudiante.cod_curso
								inner join sis.t_uni_curricular as uni_cur
								on uni_cur.codigo=curso.cod_uni_curricular 
								left join sis.t_est_cur_estudiante as est_cur_est 
								on est_cur_est.codigo=cur_estudiante.cod_estado
								left join sis.t_persona  as persona on 
								persona.codigo=curso.cod_docente inner join 
								sis.t_trayecto as trayecto on 
								trayecto.codigo=uni_cur.cod_trayecto
								inner join sis.t_periodo as periodo on curso.cod_periodo=periodo.codigo 
							where curso.cod_uni_curricular in (select uni.codigo from sis.t_estudiante as estudiante 
													     inner join sis.t_trayecto as trayecto
													     on trayecto.cod_pensum=estudiante.cod_pensum
													     inner join sis.t_uni_curricular as uni 
													     on uni.cod_trayecto=trayecto.codigo
											   where estudiante.codigo=?) 
							and curso.cod_uni_curricular not in (select pre.cod_uni_cur_prelada from sis.t_prelacion as pre
											     where pre.cod_uni_curricular not in (select curso.cod_uni_curricular 
																  from sis.t_cur_estudiante as cur_es 
																  inner join sis.t_curso as curso 
																  on cur_es.cod_curso=curso.codigo
																  where cur_es.cod_estado='A' and 
												cur_es.cod_estudiante=?)
											     )and 
							curso.codigo in(select curso.codigo from sis.t_curso as curso 
											where curso.capacidad>(select count(cur_est.codigo) from sis.t_cur_estudiante as cur_est where cur_est.cod_curso=curso.codigo ))
							and (periodo.codigo in (select distinct curso.cod_periodo
								from sis.t_curso as curso 
									inner join sis.t_cur_estudiante as cur_estudiante 
									on curso.codigo= cur_estudiante.cod_curso
								where cur_estudiante.cod_estudiante=?
								)
								or 
								periodo.cod_estado='A')


							
							order by (cur_estudiante.nota) asc";
							
				$ejecutar= $conexion->prepare($consulta);
				
				$ejecutar->execute(array($cod_estudiante,$cod_estudiante,$cod_estudiante,$cod_estudiante));
				if($ejecutar->rowCount()!=0){
					return $ejecutar->fetchAll();
				}
				else
					return null;		
			}catch (Exception $e){
				throw $e;
			}	


		}
		/**
		 * Función pública y estática que obtiene los cursos disponibles según su cantidad y capacidad.
		 * 
		 * Obtiene el código del curso que tiene capacidad para inscribir un estudiante.
		 * 
		 * @param	$codCurso						Código del Curso en cuestión.
		 * 
		 * @return array|null						Retorna un arreglo asociativo de existir
		 * una respuesta, retorna null de no existir.
		 * 
		 */
		public static function cantidadEstudiantesCursoCapacidad($codCurso){
			try{
				$conexion=Conexion::conectar();
				$consulta= "select curso.codigo
								from sis.t_curso as curso 
							where curso.codigo=? and curso.capacidad>(select count(curso_es.codigo)
																			from sis.t_cur_estudiante as curso_es
																				where curso_es.cod_curso=?);";
							
				$ejecutar= $conexion->prepare($consulta);
				
				$ejecutar->execute(array($codCurso,$codCurso));
				
				if($ejecutar->rowCount()!=0){
					return $ejecutar->fetchAll();
				}
				else
					return null;		
			}catch (Exception $e){
				throw $e;
			}
		}	
		/**
		 * Función pública y estática que obtiene los estudiantes que pueden cursar dicho curso.
		 * 
		 * Recibe como parámetro el código del curso y el tipo de respuesta.
		 * Devuelve los estudiantes que pueden cursar dicho curso si la unidad que dicta
		 * no la están cursando, la tienen inscrita o preinscrita en otros cursos.
		 * 
		 * @param $codigo						El código del curso en cuestión.
		 * 
		 * @return $r							Tipo de respuesta.
		 * 
		 */
		public static function obtenerEstudiantesC($codigo, $r){
			try{
				$conexion = Conexion::conectar();
				
				$consulta = "select per.nombre1, 
				                    per.apellido1, 
				                    est.codigo, 
				                    per.cedula
	                                from sis.t_persona as per
	                                inner join sis.t_estudiante as est
	                                on (est.codigo = per.codigo)
	                                where est.codigo not in
		                                (select curest.cod_estudiante
		                                from sis.t_curso as cur 
		                                inner join sis.t_cur_estudiante as curest
		                                on (cur.codigo = curest.cod_curso)
		                                inner join sis.t_est_cur_estudiante as estado
		                                on (estado.codigo = curest.cod_estado)
		                                where cur.cod_uni_curricular = (select uni.codigo 
						                                from sis.t_curso as cur
							                                inner join sis.t_uni_curricular as uni
							                                on (cur.cod_uni_curricular = uni.codigo)
							                                where cur.codigo = ?) and (estado.codigo = 'I' or 
										                                estado.codigo = 'A' or
										                                estado.codigo = 'C' or
										                                estado.codigo = 'P'))";
										                                
			    $ejecutar=$conexion->prepare($consulta);
					
					$ejecutar->execute(array($codigo));
					
					if($ejecutar->rowCount()!=0){
						$estudiantes=$ejecutar->fetchAll();
						return self::retornarEstudiantes($estudiantes, $r);
					}
					else
						return null;	
					
			}
			catch(Exception $e){
				throw $e;
			}
		}
		/**
		 * Función pública y estática que dicta si un estudiante puede cursar el curso o no.
		 * 
		 * Recibe como parámetro el código del curso y el código del estudiante.
		 * Devuelve true o false dependiendo si el estudiante puede o no cursar el curso.
		 * Esto se determina si el estudiante no está cursando, aprobó, preinscribió o inscribió
		 * la unidad curricular que dicta el curso en otro.
		 * 
		 * @param $codEstudiante					El código del estudiante..
		 * 
		 * @param $codCurso							El códgio del curso en cuestión			
		 * 
		 * @return boolean							Retorna true si puede cursar el curso, false si no.
		 * 
		 */
		public static function cursoDisponibleEstudiante($codEstudiante, $codCurso){
		    try{
		        $conexion = Conexion::conectar();
		        
		        $consulta = "select est.codigo
                        from sis.t_persona as per
                        inner join sis.t_estudiante as est
                        on (est.codigo = per.codigo)
                        where ? not in
	                        (select curest.cod_estudiante
	                        from sis.t_curso as cur 
	                        inner join sis.t_cur_estudiante as curest
	                        on (cur.codigo = curest.cod_curso)
	                        inner join sis.t_est_cur_estudiante as estado
	                        on (estado.codigo = curest.cod_estado)
	                        where cur.cod_uni_curricular = (select uni.codigo 
					                        from sis.t_curso as cur
						                        inner join sis.t_uni_curricular as uni
						                        on (cur.cod_uni_curricular = uni.codigo)
						                        where cur.codigo = ?) and (estado.codigo = 'I' or 
									                        estado.codigo = 'A' or
									                        estado.codigo = 'C' or
									                        estado.codigo = 'P'))";
							                          
						 $ejecutar=$conexion->prepare($consulta);
					
					    $ejecutar->execute(array($codEstudiante,$codCurso));
					
					    if($ejecutar->rowCount()!=0)
						      return true;
					    else
						      return false;	
		    }
		    catch(Exception $e){
		        throw $e;
		    }
		}
		
		/*
		 * Función pública y estática devuelve los datos necesarios para armar un acta de notas.
		 * 
		 * Recibe como parámetro el código del curso.
		 * Devuelve todos los datos relacionados con el curso, instituto, pensum, departamento,
		 * trayecto, periodo y estudiantes que ven ese curso con notas, porcentaje de asistencia,
		 * y estado en el curso.
		 * 
		 * @param $codigo							El código del curso.
		 * 
		 * @return array|null						Retorna un arreglo asociativo de existir
		 * una respuesta, retorna null de no existir.
		 * 
		 */
		public static function obtenerEstConPensum($codigo){
			try{
				$conexion = Conexion::conectar();
				
				$consulta = "select 	pen.nombre as nombrepensum, 
										periodo.nombre as periodo,
										uni.nombre as nombreuni,
										uni.uni_credito,
										uni.not_min_aprobatoria,
										uni.not_maxima,
										persona.apellido1 || ' ' || persona.nombre1 as nombredocente,
										persona.cedula as ceduladoc,
										trayecto.num_trayecto,
										depar.nombre as nombredep,
										insti.nombre as insti,
										curest.nota,
										curest.por_asistencia,
										pers.apellido1 || ' ' || pers.nombre1 as nombreestudiante,
										pers.cedula,
										estado.codigo as codestado,
										estado.nombre as nombreestado

										from sis.t_curso as cur
										inner join sis.t_periodo as periodo
											on (periodo.codigo = cur.cod_periodo)
										inner join sis.t_pensum as pen
											on (periodo.cod_pensum = pen.codigo)
										inner join sis.t_cur_estudiante as curest
											on (cur.codigo = curest.cod_curso)
										inner join sis.t_persona as persona
											on (persona.codigo = cur.cod_docente)
										inner join sis.t_docente as docente
											on (cur.cod_docente = docente.codigo)
										inner join sis.t_departamento as depar
											on (docente.cod_departamento = depar.codigo)
										inner join sis.t_uni_curricular as uni
											on (cur.cod_uni_curricular = uni.codigo)
										inner join sis.t_instituto as insti
											on (insti.codigo = depar.cod_instituto)
										inner join sis.t_trayecto as trayecto
											on (uni.cod_trayecto = trayecto.codigo)
										inner join sis.t_persona as pers
											on (curest.cod_estudiante = pers.codigo)
										inner join sis.t_est_cur_estudiante as estado
											on (curest.cod_estado = estado.codigo)
										where cur.codigo = ?";
				
				$ejecutar = $conexion->prepare($consulta);
				
				$ejecutar->execute(array($codigo));
				
				if($ejecutar->rowCount() != 0)
					return $ejecutar->fetchAll();
				else
					return null;
			}
			catch(Exception $e){
				throw $e;
			}
		}
		
		/**
		 * Obtiene los estatus para la leyenda del PDF.
		 *
		 * Función que obtiene los estatus y sus códigos para armar la leyenda del PDF "ACTA DE NOTAS"
		 *
		 * @return array|null 		Retorna un arreglo asociativo o null de no encontrarse.
		 */
		
		public static function obtenerLeyendaEstatusCurso(){
			try{
				$conexion = Conexion::conectar();

				$consulta = "select * from sis.t_est_cur_estudiante order by codigo";

				$ejecutar = $conexion->prepare($consulta);
				
				$ejecutar->execute(array());

				if($ejecutar->rowCount() != 0)
					return $ejecutar->fetchAll();
				else
					return null;
			}
			catch(Exception $e){
				throw $e;
			}		
		}

		/*
		 * Obtiene todos los datos relacionados a un curso.
		 *
		 * Obtiene todos los datos relacionados a un curso, retorna un arreglo asociativo con
		 * el nombre del pensum, periodo académico, nombre de la unidad curricular, unidades de crédito,
		 * nota mínima aprobatoria, nota máxima, nombre y apellido del profesor, cédula del profesor,
		 * número del trayecto, nombre del departamento y nombre de instituto.
		 *
		 * @param int $codigoCurso 		Código del curso en cuestión
		 *
		 * @return array|null 			De existir coincidencia, retorna un arreglo asociativo, de no
		 * existir, retorna null.
		 *
		 * @throws Exception 			Si ocurre algún error en el query.
		 */
	
		
		public static function obtenerDatosCurso($codigoCurso){
			try{
				$conexion = Conexion::conectar();

				$consulta = "select 	pen.nombre as nombrepensum, 
										periodo.nombre as periodo,
										uni.nombre as nombreuni,
										uni.uni_credito,
										uni.not_min_aprobatoria,
										uni.not_maxima,
										persona.apellido1 || ', ' || persona.nombre1 as nombredocente,
										persona.cedula as ceduladoc,
										trayecto.num_trayecto,
										depar.nombre as nombredep,
										insti.nombre as insti,
										cur.seccion

										from sis.t_curso as cur
										inner join sis.t_periodo as periodo
											on (periodo.codigo = cur.cod_periodo)
										inner join sis.t_pensum as pen
											on (periodo.cod_pensum = pen.codigo)
										inner join sis.t_persona as persona
											on (persona.codigo = cur.cod_docente)
										inner join sis.t_docente as docente
											on (cur.cod_docente = docente.codigo)
										inner join sis.t_departamento as depar
											on (docente.cod_departamento = depar.codigo)
										inner join sis.t_uni_curricular as uni
											on (cur.cod_uni_curricular = uni.codigo)
										inner join sis.t_instituto as insti
											on (insti.codigo = depar.cod_instituto)
										inner join sis.t_trayecto as trayecto
											on (uni.cod_trayecto = trayecto.codigo)
										where cur.codigo = ?";

				$ejecutar = $conexion->prepare($consulta);

				$ejecutar->execute(array($codigoCurso));

				if($ejecutar->rowCount() != 0)
						return $ejecutar->fetchAll();
				return null;
			}
			catch(Exception $e){
				throw $e;
			}
		}
}
	
?>
