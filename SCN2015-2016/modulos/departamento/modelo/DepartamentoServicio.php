<?php
/*
 * * * * * * * * * * LICENCIA * * * * * * * * * * * * * * * * * * * * *

Copyright(C) 2012
Instituto Universtiario de Tecnología Dr. Federico Rivero Palacio

Este programa es Software Libre y usted puede redistribuirlo y/o modificarlo
bajo los términos de la versión 3.0 de la Licencia Pública General (GPLv3)
publicada por la Free Software Foundation (FSF), es distribuido sin ninguna
garantía. Usted debe haber recibido una copia de la GPLv3 junto con este
programa, sino, puede encontrarlo en la página web de la FSF, 
específicamente en la dirección http://www.gnu.org/licenses/gpl-3.0.html

 * * * * * * * * * * ARCHIVO * * * * * * * * * * * * * * * * * * * * *

Nombre: DepartamentoSevicio.clase.php
Diseñador: Jhonny Vielma
Programador: Jhonny Vielma
Fecha: octubre del 2014
Descripción: 

	Esta clase ofrece el servicio de conexión a la base de datos, recibe 
	los parámetros, construye las consultas SQL, hace las peticiones a 
	la base de datos y retorna los objetos o datos correspondientes a la
	acción.

 * * * * * * * * Cambios/Mejoras/Correcciones/Revisiones * * * * * * * *
			/				      /			         
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/
	class DepartamentoServicio{
/*función que permite listar todos los cursos de un periodo académico.
	   Parámetros de entrada:
	     $codigo_periodo:tipo numérica.
	     Código del periodo académico.
	   Valor de retorno:
	     en caso de éxito:$cursos, una matriz asociativa.
	     Lista de cursos. Por ejemplo: [0]['nombreDelCurso'] o [0][1]repesenta el nombre del primer curso.
	     en caso de error:null. 
*/
		public static function obtenerPorInstituto($codigoInstituto){
			try{
				$conexion=Conexion::conectar();
				$consulta= "select  * from sis.t_departamento where cod_instituto=?";
							
				$ejecutar= $conexion->prepare($consulta);
				
				$ejecutar->execute(array($codigoInstituto));
				
				if($ejecutar->rowCount()!=0){
					return $ejecutar->fetchAll();
				}
				else
					return null;		
			}catch (Exception $e ){
				throw $e;
			}	
		}
/*función que permite eliminar un curso, si el mismo posee estudiantes se 
  eliminarán anteriormente de eliminar éste.
	   Parámetros de entrada:
	     $codigo_curso:tipo numérica.
	     Código del curso a eliminar.
	   Valor de retorno:
	     ninguno
	   Excepciones que lanza:
		 Exception: en caso de error al eliminar el curso.
*/	
		public static function eliminar($codigoCurso){
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
/*función que permite modificar un curso 
	   Parámetros de entrada:
	     $codigo:tipo numérica.
	     Código del culso a modificar
	     $cod_periodo:tipo numérica.
	     Código del periodo acádemico al cual pertenece el curso.
	     $cod_uni_curricular:tipo numérica.
	     Código de la unidad curricular que dicta el curso.
	     $cod_docente:tipo numérica.
	     Código del docente que dicta el curso.
	     $seccion:tipo cadena.
	     Sección del curso. 
	     $fecha_inicio:tipo fecha.
	     Fecha de inicio del curso.
	     $fecha_final:tipo fecha.
	     Fecha final del curso.
	     $capacidad:tipo numérica.
	     Capacidad de estudiantes del curso.
	     $observaciones:tpo cadena.
	     Observaciones del curso
	   Valor de retorno:
	     ninguno
	   Excepciones que lanza:
		 Exception: en caso de error al modificar el curso.
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
/*función que permite modificar un curso 
	   Parámetros de entrada:
	     $curso:objeto tipo Curso.
	   Valor de retorno:
	     ninguno
	   Excepciones que lanza:
		 Exception: en caso de error al modificar el curso.
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
		
/*función que permite agregar un curso 
	   Parámetros de entrada:
	     $cod_periodo:tipo numérica.
	     Código del periodo acádemico al cual pertenece el curso.
	     $cod_uni_curricular:tipo numérica.
	     Código de la unidad curricular que dicta el curso.
	     $cod_docente:tipo numérica.
	     Código del docente que dicta el curso.
	     $seccion:tipo cadena.
	     Sección del curso. 
	     $fecha_inicio:tipo fecha.
	     Fecha de inicio del curso.
	     $fecha_final:tipo fecha.
	     Fecha final del curso.
	     $capacidad:tipo numérica.
	     Capacidad de estudiantes del curso.
	     $observaciones:tipo cadena.
	     Observaciones del curso
	   Valor de retorno:
	     ninguno
	   Excepciones que lanza:
		 Exception: en caso de error al agregar el curso.
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
/*función que permite obtener el máximo código de la tabla de curso.
	   Parámetros de entrada:
	     ninguno.
	   Valor de retorno:
	     Máximo código, tipo numérico . 
*/	

		public static function obtenerMaxCodCurso(){
				try{
					$conexion=Conexion::conectar();
					$consulta="select coalesce(max(codigo),0) from sis.t_curso";
					$ejecutar=$conexion->query($consulta);
					$r= $ejecutar->fetchAll();
					return $r[0][0];
				}catch(Exception $e){
					throw $e; 
				}
		}
/*función que permite agregar un curso 
	   Parámetros de entrada:
	     $curso:objeto tipo Curso.
	   Valor de retorno:
	     ninguno
	   Excepciones que lanza:
		 Exception: en caso de error al agregar el curso.
*/

		public static function agregarO($curso){
			try{
				$conexion=Conexion::conectar();
				
				//$conexion->beginTransaction();
				
				$codigo=self::obtenerMaxCodCurso()+ 1;
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
/*función que permite obtener un curso 
	   Parámetros de entrada:
	     $codigo:tipo numérico.
	     Código del curso a obtener.
	   Valor de retorno:
	     $curso:objeto tipo curso
	   Excepciones que lanza:
		 Exception: en caso de error al obtener el curso.
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
			
/*función que permite eliminar un estudiante del curso. 
	   Parámetros de entrada:
	     $cod_curso:tipo numérica.
	     Código del curso.
	     $cedEstudiante:tipo numérica.
	     Cédula del estudiante
	   Valor de retorno:
	     ninguno
	   Excepciones que lanza:
		 Exception: en caso de error al eliminar el curso.
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
/*función que permite agregar un estudiante a un curso y se coloca por defecto una nota de 0. 
	   Parámetros de entrada:
	     $estCurso:objeto CurEstudiante.
	   Valor de retorno:
	     ninguno
	   Excepciones que lanza:
		 Exception: en caso de error al agregar el estudiante al curso.
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
/*función que permite obtener el máximo código de la tabla de cur_ estudiante.
	   Parámetros de entrada:
	     ninguno.
	   Valor de retorno:
	     Máximo código, tipo numérica. 
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
		
/*función que permite agregar un estudiante a un curso y se coloca por defecto una nota de 0
	   Parámetros de entrada:
	     $codigoEstudiante:tipo numérica.
	     Código del estudiante.
	     $codigoCurso:tipo numérica.
	     Código del curso
	     $porAsistencia:tipo porcentaje.
	     Porcentaje de asistencia.
	     $nota:tipo numérica.
	     Nota del estudiante en el curso correspondiente.
	     $estado:tipo caracter.
	     Estado del estudiante: cursando, aprobado, retirado, etc.
	     $observaciones:tipo cadena.
	     Observaciones del curso
	   Valor de retorno:
	     ninguno
	   Excepciones que lanza:
		 Exception: en caso de error al agregar el estudiante al curso.
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
/*función que permite obtener un estudiante de un curso determinado.
	   Parámetros de entrada:
	     $codigoEstudiante:tipo numérica.
	     Código del estudiante a obtener.
	     $codigoCurso:tipo numérica.
	     Código del curso.
	   Valor de retorno:
	     objeto tipo CurEstudiante.
	   Excepciones que lanza:
		 Exception: en caso de error al mostar el estudiante del curso.
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
/*función que permite listar los estudiantes de un curso determinado.
	   Parámetros de entrada:
	     $codigoCurso:tipo numérica.
	     Código del curso.
	   Valor de retorno:
	     en caso de éxito:un arreglo de objetos CurEstudiante.
	     en caso de error:null.
*/	
		public static function obtenerEstudiantes($codigoCurso,$tipoRe=true){
				try{
					$conexion=Conexion::conectar();
					$consulta="select * from sis.t_cur_estudiante where cod_curso=?";
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
/*función que permite modificar un estudiante de un curso determinado.
	   Parámetros de entrada:
	     $codigoEstudiante:tipo numérica.
	     Código del estudiante.
	     $codigoCurso:tipo numérica.
	     Código del curso
	     $porAsistencia:tipo porcentaje.
	     Porcentaje de asistencia.
	     $nota:tipo numérica.
	     Nota del estudiante en el curso correspondiente.
	     $estado:tipo caracter.
	     Estado del estudiante: cursando, aprobado, retirado, etc.
	     $observaciones:tipo cadena.
	     Observaciones del curso
	   Valor de retorno:
	     ninguno
	   Excepciones que lanza:
		 Exception: en caso de error al modificar el estudiante.
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
/*función que permite modificar un estudiante de un curso determinado. 
	   Parámetros de entrada:
	     $curEstudiante:objeto CurEstudiante.
	   Valor de retorno:
	     ninguno
	   Excepciones que lanza:
		 Exception: en caso de error al modificar el estudiante.
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
				throw $e;
			}
		}
/*función que permite listar los cursos de un docente por periodo académico. 
	   Parámetros de entrada:
	     $cod_periodo:tipo numérica.
	     Código del periodo acádemico.
	     $cod_docente:tipo numérica.
	     Código del docente.
	   Valor de retorno:
	     en caso de éxito:un arreglo de objetos Curso.
	     en caso de error:null.
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
		
			
			
			
	}
	


	
?>
