<?php


require_once "negocio/Curso.php";
require_once "negocio/CurEstudiante.php";
//Clase que permite la comunicación con la base de datos
require_once  "modelo/CursoServicio.php";

/**
 * @copyright 2014 - Instituto Universtiario de Tecnología Dr. Federico Rivero Palacio
 * @license GPLv3
 * @license http://www.gnu.org/licenses/gpl-3.0.html
 *
 * CursoControlador.php - Controlador del módulo Curso.
 *
 * Este es el controlador del módulo curso, permite manejar las 
 * operaciones relacionadas con los cursos (agregar, modificar,
 * eliminar, consultar y buscar) además de las relacionadas
 * con los estudiantes de los cursos(agregar, modificar,eliminar,
 * consultar, buscar) 
 * Es el intermediario entre la base de datos y la vista.
 *  
 * @author Geraldine Castillo (geralcs94@gmail.com)
 * @author Juan M. De Sousa (juanmdsousa@gmail.com)
 * 
 * @package Controladores
 */

class CursoControlador {
	
	/**
	 * Función pública y estática que permite manejar el requerimiento
	 * (o acción) indicado por el usuario.
	 * 
	 * Todas las acciones de este módulo trabajan en conjunto con la clase Vista para 
     * mostrar el resultado de la petición del usuario y dicha interacción con la base de datos.
     * Para más información de esta clase, visite:
	 *
	 * @link /base/clases/vista/Vista.php 	Clase Vista.	
     *
	 * @var string $accion 					Acción requerida por el usuario.
	 *
	 * @throws Exception 					Si la acción no coincide con las predefinidas del módulo.
	 *
	 * @todo prueba
	*/
	
	public static function manejarRequerimiento(){
		try {
			//permite obtener la acción a realizar en este módulo
			$accion = PostGet::obtenerPostGet('m_accion');

			
			//Acciones de curso
			if (!$accion) 
				$accion = 'listar';
			
			if ($accion == 'listar') 			self::listar();
			else if ($accion == 'listarD')		self::listarD();	
			else if ($accion == 'preAgregar')	self::agregar();
			else if ($accion == 'agregar') 		self::agregar();		
			else if ($accion == 'preModificar') self::modificar();			
			else if ($accion == 'modificar') 	self::modificar();
			else if ($accion == 'mostrar')		self::mostrar();	
			else if ($accion == 'eliminar') 	self::eliminar();
			
			//Aciones de estudiantes del curso
			else if ($accion == 'listarE')		self::listarEstudiantes();
			else if ($accion == 'preAgregarE')	self::agregarEstudiante();							
			else if ($accion == 'agregarEst') 	self::agregarEstudiante();		
			else if ($accion == 'preModificarE')self::modificarEstudiante();
			else if ($accion == 'obtenerEstudiantesC')	self::obtenerEstudiantesC();

			else if ($accion == 'inscribirEst')self::cursosEstudiante();	
			else if ($accion == 'modificarNota')self::modificarEstudiante();
			else if ($accion == 'mostrarE')		self::mostrarEstudiante();
			else if ($accion == 'eliminarE')	self::eliminarEstudiante();
			
			
			else if ($accion == 'verEstudiantesPDF')	self::verEstudiantesPDF();
			else if ($accion == 'listaEstudiantesPDF')	self::listaEstudiantesPDF();
			
			//Acciones de los profesores del curso
			elseif ($accion == 'listarCursoDocente') 	self::listarCursosPorDocente();

			else if ($accion == 'listarCursosPeSec')	self::listarCursoPeSec();
			
			else if ($accion == 'listarSeccionYUniCurr')self::listarSeccioYUniCurr();

			else if ($accion == 'curDisCur')self::cursosDisponiblesCursados();
			
			else
				throw new Exception ("acción inválida en el controlador del curso: ".$accion);
		}catch (Exception $e){
				throw $e;
		}
	}
	
	
		/**
		 * Función pública y estática que permite listar los cursos de un periodo académico en específico.
		 * 
		 * Obtiene el código del periodo académico de la vista y el patrón con el que se mostrará, ambos
		 * se pasan como parámetros a la función obtenerPorPeriodoAcademico($codPeriodo, $patron) del servicio.
		 * 
		 * @var string $codPeriodo 	Código del Periodo Académico.
		 *
		 * @var string|null $patron Patrón de búsqueda en la base de datos.
		 *
		 * @throws Exception 		Si es capturada alguna excepción en el servicio.
		 */	

		static function listar() {
			try{
				$codPeriodo = PostGet::obtenerPostGet('codPeriodo');
				
				$patron = PostGet::obtenerPostGet('patron');
				
				if($patron == null)
					$patron = '';

				if ($codPeriodo!=null){
					$cursos=CursoServicio::obtenerPorPeriodoAcademico($codPeriodo,$patron)	;
				
					if ($cursos){
						Vista::asignarDato('cursos',$cursos);
						Vista::asignarDato('estatus',1);
					}
					else {
						$mensaje="no hay curso en este periodo";
						Vista::asignarDato('mensaje',$mensaje);
						Vista::asignarDato('estatus',-1);
					}
				
				}
				else {
					$mensaje="Seleccione un periodo para visualizar cursos";
					Vista::asignarDato('mensaje',$mensaje);
					Vista::asignarDato('estatus',-1);
				}
				Vista::mostrar();
			
			}catch(Exception $e){
				throw $e;
			}
		
		}

		/**
		*función que permite mostrar la vista de inscribir estudiante 
		*
		*/
		public static function cursosEstudiante(){
			try{
				Vista::mostrar();
			}catch (Exception $e){
				throw $e;
			}
		}

		/**
		 * Función pública y estática que permite listar los cursos dictados por un docente en específico.
		 *
		 * Obtiene el código del docente desde la clase Sesion (datos del logeo) y se pasa como parámetro
		 * a la función obtenerPorDocente($codDocente) del servicio.
		 *
		 * @var int $codDocente 		Código del docente logeado.
		 * 
		 * @throws Exception 			Si es capturada alguna excepcion en el servicio.
		 *
		 */
		public static function listarD(){
			try{
				$codDocente = Sesion::obtenerCodigo();

				$cursos = CursoServicio::obtenerPorDocente($codDocente);
				
				if($cursos){
					Vista::asignarDato('cursos',$cursos);
					Vista::asignarDato('estatus',1);
				}
				else{
					$mensaje = "Este docente no dicta cursos.";
					Vista::asignarDato('mensaje',$mensaje);
				}
				Vista::mostrar();
			}catch (Exception $e){
				throw $e;
			}
		}

		

		/**función que permite agregar un curso.
		* Obtiene la acción de la vista, si es agregar llamará la función agregar(objeto tipo curso)
		*	 del servicio de curso y le pasará un objeto tipo curso con la información
		*	 de la vista, si la acción es preAgregar abrirá la vista de agregar curso.  
		*		Parámetros de entrada:
		*			Ninguno.
		*		Valores de salida:
		*			Ninguno.
		*/
		static function listarCursoPeSec(){
			try{
				$codPeriodo = PostGet::obtenerPostGet('codPeriodo');
			
				$seccion=PostGet::obtenerPostGet('seccion');
				$cursos=CursoServicio::obtenerCursoPorSeccionPeriodo($codPeriodo,$seccion);
				
				if ($cursos){
					Vista::asignarDato('cursos',$cursos);	
				}
				else {
					$mensaje="no hay curso en este periodo";
					Vista::asignarDato('mensaje',$mensaje);
				}
				Vista::mostrar();
			}catch(Exception $e){
				throw $e;
			}


		}
		/**
		 * Función pública y estática que permite agregar un curso a la base de datos.
		 *
		 * Construye un objeto Curso y llena sus parámetros con los datos que vienen por el POST o el GET
		 * y se pasa como parámetro a la función agregar(Objeto $curso) del servicio.
		 * 
		 * Características del objeto:
		 * @var int $codPeriodo 			Código del Periodo al que pertenece el curso.
		 * @var int $codUniCurricular 		Código de la Unidad Curricular que se dictará en el curso.
		 * @var int $codDocente 			Código del Docente que dictará el curso.
		 * @var string $seccion 			Sección que tendrá el curso.	
		 * @var string|null $fec_inicio		Fecha de inicio del curso. 
		 * @var string|null $fec_final 		Fecha del fin del curso.
		 * @var int|null $capacidad 		Capacidad de alumnos que tendrá el curso.
		 * @var string|null $observaciones 	Observaciones del curso.
		 *
		 * @throws Exception 				Si se captura alguna excepción en el servicio.
		 */
		static function agregar(){
			try{
			
				$accion = PostGet::obtenerPostGet('m_accion');
				if ($accion=='agregar'){
					$curso=new Curso();

					$curso->asignarPeriodo(PostGet::obtenerPostGet('codPeriodo'));
					$curso->asignarCodUniCurricular(PostGet::obtenerPostGet('codUniCurricular'));
					$curso->asignarCodDocente(PostGet::obtenerPostGet('codDocente'));
					$curso->asignarSeccion(PostGet::obtenerPostGet('seccion'));
					$curso->asignarFecInicio(PostGet::obtenerPostGet('fechaInicio'));
					$curso->asignarFecFinal(PostGet::obtenerPostGet('fechaFinal'));
					$curso->asignarCapacidad(PostGet::obtenerPostGet('capacidad'));
					$curso->asignarObservaciones(PostGet::obtenerPostGet('observaciones'));
					self::convertirDatosVaciosEnNull($curso);
					CursoServicio::agregar($curso);
					$codigoCurso=CursoServicio::obtenerMaxCodCurso($curso->obtenerCodPeriodo(),
											$curso->obtenerCodUniCurricular(),$curso->obtenerSeccion());
					Vista::asignarDato('codigoUnidadCurri',$curso->obtenerCodUniCurricular());
					Vista::asignarDato('codigoCurso',$codigoCurso);
					Vista::asignarDato('mensaje','Se ha agregado el curso');	
					Vista::asignarDato('estatus',1);		
				}
				Vista::mostrar();
					
				
			}catch (Exception $e){
				throw $e;
			}
			
		}
		/**
		 * Función privada y estática que asigna "null" si algún atributo de la clase
		 * pasada por parámetro está vacío.
		 *
		 * Recibe un objeto Curso y evalúa cada uno de sus campos para luego realizar
		 * (cumplir alguna condición) el reemplazo en el atributo.
		 *
		 * @param object $curso 			Objeto Curso a evaluar.
		 *
		 */
		static function convertirDatosVaciosEnNull($curso){
				
				if ($curso->obtenerCapacidad()=="")
					$curso->asignarCapacidad(null);
				if ($curso->obtenerCodDocente()=="")
					$curso->asignarCodDocente(null);
				if ($curso->obtenerFecInicio()=="")
					$curso->asignarFecInicio(null);
				if ($curso->obtenerFecFinal()=="")
					$curso->asignarFecFinal(null);
		}
		/**
		 * Función pública y estática que permite modificar un curso en la base de datos.
		 *
		 * Construye un objeto Curso con los datos a reemplazarse en la base de datos y se pasa
		 * como parámetro a la función modificar(Objeto $curso) del servicio.
		 *
		 * Características del objeto:
		 * @var int $codigoCurso			Código del curso modificado.
		 * @var int $codPeriodo 			Código del Periodo a ser modificado.
		 * @var int $codUniCurricular 		Código de la Unidad Curricular a ser modificado.
		 * @var int $codDocente 			Código del Docente a ser modificado.
		 * @var string $seccion 			Sección a ser modificada.
		 * @var string|null $fec_inicio		Fecha de inicio a ser modificada.
		 * @var string|null $fec_final 		Fecha del fin a ser modificada.
		 * @var int|null $capacidad 		Capacidad de alumnos a ser modificada.
		 * @var string|null $observaciones 	Observaciones a ser modificadas.
		 *
		 * @throws Exception 				Si se captura alguna excepción en la base de datos.
		 */
		static function modificar(){
			try{
				$accion =PostGet::obtenerPostGet('m_accion');
				$codigo=PostGet::obtenerPostGet('codigo');
				if ($accion=='modificar'){
					$curso=new Curso();
					$curso->asignarCodigo($codigo);
					$curso->asignarPeriodo(PostGet::obtenerPostGet('codPeriodo'));
					$curso->asignarCodUniCurricular(PostGet::obtenerPostGet('codUniCurricular'));
					$curso->asignarCodDocente(PostGet::obtenerPostGet('codDocente'));
					$curso->asignarSeccion(PostGet::obtenerPostGet('seccion'));
					$curso->asignarFecInicio(PostGet::obtenerPostGet('fechaInicio'));
					$curso->asignarFecFinal(PostGet::obtenerPostGet('fechaFinal'));
					$curso->asignarCapacidad(PostGet::obtenerPostGet('capacidad'));
					$curso->asignarObservaciones(PostGet::obtenerPostGet('observaciones'));
					self::convertirDatosVaciosEnNull($curso);
					CursoServicio::modificar($curso);
					Vista::asignarDato('mensaje','Se ha modificado el curso');
					Vista::asignarDato('codigo',$curso->obtenerCodigo());
					Vista::asignarDato('estatus',1);

				}else if ($accion=='preModificar'){
					$curso=CursoServicio::obtener($codigo);
				}
					Vista::mostrar();
			}catch(Exception $e){
				throw $e;
			}
			
			
		}
		/**
		 * Función pública y estática que permite mostrar la información de un curso.
		 *
		 * Obtiene el código del curso que se quiere consultar y se pasa como parámetro al procedimiento
		 * obtener($codigo) del servicio.
		 *
		 * @var int $codigo 			Código del curso a ser consultado.
		 *
		 * @throws Exception 			Si se captura alguna excepción en la base de datos.
		 */
		static function mostrar(){
			try{
				$codigo=PostGet::obtenerPostGet('codigo');
				$curso=CursoServicio::obtener($codigo);
				Vista::asignarDato('curso',$curso);
				//Vista::mostar("mostrar");
				
			}catch(Exception $e){
				throw $e;
				
			}
			
		}

		/**
		 * Función pública y estática que permite eliminar un curso de la base de datos.
		 *
		 * Obtiene el código del curso a ser eliminado y se pasa como parámetro
		 * a la función eliminar($codigo) del servicio.
		 *
		 * @var int $codigo 			Código del Curso a ser eliminado.
		 *
		 * @throws Exception 			Si se captura alguna excepción en el servicio.
		 */

		static function eliminar(){
			try{
					$codigo=PostGet::obtenerPostGet('codigo');
					$elimi=CursoServicio::eliminar($codigo);
					Vista::asignarDato("mensaje","Curso eliminado");
					Vista::asignarDato("codigo",$codigo);
					Vista::asignarDato("estatus",1);
					Vista::mostrar();
				
			}catch (Exception $e){
				throw $e;
			}
		}
		
		
		/**
		 * Función pública y estática que permite listar a los estudiantes de un curso.
		 *
		 * Obtiene el código del curso y se pasa como parámetro a la función
		 * obtenerEstudiantes($codigoCurso, boolean) del servicio.
		 *
		 * @var int $codigoCurso 			Código del Curso donde se consultarán sus estudiantes.
		 * @var boolean $obj 				True si se desea obtener un arreglo de objetos y False si se desea un arreglo de arreglos asociativos.
		 *									
		 * 
		 * @throws Exception 				Si se captura alguna excepción en el servicio.
		 */
		static function listarEstudiantes(){
			try{

				$codigoCurso=PostGet::obtenerPostGet('codigoCurso');
				$r=CursoServicio::obtenerEstudiantes($codigoCurso,false);
				
				if($r){
					Vista::asignarDato('datocurso',CursoServicio::obtenerDatosCurso($codigoCurso));
					Vista::asignarDato('estudiante',$r);
					Vista::asignarDato('estatus',1);
				}
				else{
					$mensaje = "No hay estudiantes en ese curso";
					Vista::asignarDato('mensaje',$mensaje);
				}
				Vista::mostrar();
			}catch (Exception $e){
				throw $e;	
			}
		}
		/**
		 * Función pública y estática que permite agregar estudiantes a un curso.
		 *
		 * Construye un objeto CurEstudiante y se definen sus atributos con los datos que vienen
		 * desde el POST o el GET y se pasa como parámetro a la función agregarEstudiante(Objeto $curEstudiante)
		 * del servicio.
		 * 
		 * Características del Objeto:
		 * @var int $codEstudiante 			Código del Estudiante (en la tabla t_estudiante) que será agregado al curso.
		 * @var int $codCurso 				Código del Curso al que será agregado el estudiante.
		 * @var int $porAsistencia 			Porcentaje de Asistencia que tiene el estudiante en dicho curso.
		 * @var char $estado 				Estado que posee el estudiante en ese curso.					
		 * @var string|null $objervaciones	Observaciones del estudiante en ese curso.				
		 *
		 * @throws Exception 				Si se captura alguna excepción en el servicio.
		 */
		static function agregarEstudiante(){
			try{
				$curEstudiante=new CurEstudiante();
				$curEstudiante->asignarCodEstudiante(PostGet::obtenerPostGet('codEstudiante'));
				$curEstudiante->asignarCodCurso(PostGet::obtenerPostGet('codCurso'));
				$curEstudiante->asignarPorAsistencia(PostGet::obtenerPostGet('porAsistencia'));
				$curEstudiante->asignarEstado(PostGet::obtenerPostGet('estado'));
				$curEstudiante->asignarObservaciones(PostGet::obtenerPostGet('observaciones'));
			
				$curso=$curEstudiante->obtenerCodCurso();
				$codCurso=CursoServicio::cantidadEstudiantesCursoCapacidad($curEstudiante->obtenerCodCurso());
				$curDisponibleEst = CursoServicio::cursoDisponibleEstudiante($curEstudiante->obtenerCodEstudiante(), $curEstudiante->obtenerCodCurso());
				//var_dump(PostGet::obtenerPostGet('codCurso'));
				if(($curso==$codCurso[0][0])&&($curDisponibleEst)){ 
					CursoServicio::agregarEstudiante($curEstudiante);
					Vista::asignarDato('estatus',1);
					Vista::asignarDato('codCurso',$curso);
					$mensaje = "Estudiante inscrito con éxito";
					Vista::asignarDato('mensaje',$mensaje);
				}
				else{
					Vista::asignarDato('estatus',-1);
					if(!($curDisponibleEst))
					  $mensaje = "No se puede estar inscrito en dos cursos distintos con la misma unidad curricular. Retire al estudiante de alguno para proceder a inscribirlo en el otro.";
					else
					  $mensaje = "No se pudo inscribir el estudiante en el curso, excede la capacidad del mismo";
					Vista::asignarDato('mensaje',$mensaje);
				}

			
				Vista::mostrar();		
			}catch(Exception $e){
				throw  $e;
				
			}		
		}
		/**
		 * Función pública y estática que permite modificar un estudiante de un curso.
		 *
		 * Obtiene el código del curso y el código del estudiante a modificar, se construye
		 * un objeto CurEstudiante, se definen sus atributos con los datos que vienen desde el POST
		 * o el GET y se pasa como parámetro a la función modificar(Objeto $curEstudiante) del servicio.
		 *
		 * Características del Objeto:
		 * @var int $codEstudiante 				Código del Estudiante a modificar.
		 * @var int $asignarCodCurso 			Código del Curso al que pertenece el estudiante a ser modificado.
		 * @var int $porAsistencia				Porcentaje de Asistencia a modificar.
		 * @var int $nota 						Nota del estudiante a modificar.
		 * @var char $estado 					Estado del estudiante a modificar.
		 * @var string|null $observaciones		Observaciones del estudiante a modificar.
		 *
		 * @throws Exception 					Si se captura alguna excepción en el servicio.
		 */
		static function modificarEstudiante(){
			try{
				$codCurso=PostGet::obtenerPostGet('codCurso');
				$codEstudiante=PostGet::obtenerPostGet('codigo');
				$nombre = PostGet::obtenerPostGet('nombre');

					$curEstudiante=new CurEstudiante();
					$curEstudiante->asignarCodEstudiante($codEstudiante);
					$curEstudiante->asignarCodCurso($codCurso);
					$curEstudiante->asignarPorAsistencia(PostGet::obtenerPostGet('porAsistencia'));
					$curEstudiante->asignarNota(PostGet::obtenerPostGet('nota'));
					$curEstudiante->asignarEstado(PostGet::obtenerPostGet('estado'));
					$curEstudiante->asignarObservaciones(PostGet::obtenerPostGet('observaciones'));
					
					CursoServicio::modificarEstudiante($curEstudiante);

					Vista::asignarDato('mensaje','Se ha modificado el estudiante ');
					Vista::asignarDato('nombre',$nombre);
					Vista::asignarDato('estatus',1);
					Vista::mostrar();

			}catch (Exception $e){
				throw $e;
			}	
		}
		/**
		 * Función pública y estática que permite mostrar los estudiantes de un curso.
		 *
		 * Obtiene el código de un estudiante y llama a la función
		 * obtenerEstudiantes del servicio, le pasa como parámetro el código del curso.
		 *
		 * @var int $codCurso 				Código del curso a consultar.
		 *
		 * @throws Exception 				Si se captura alguna excepción en el servicio.
		 */
		static function mostrarEstudiante(){
			try{
				$codCurso=PostGet::obtenerPostGet('codCurso');
				$r=CursoServicio::obtenerEstudiantes($codCurso);
				//Vista::mostar(listarE);
				
			}catch (Exception $e){
				throw $e;
			}
			
			
		}
		/**
		 * Función pública y estática que permite eliminar un estudiante de un curso.
		 *
		 * Obtiene el código del estudiante y el código del curso al que pertenece y
		 * del que será eliminado, luego llama a la función eliminarEstudiante
		 * del servicio y le pasa como parámetros el código del curso y el del estudiante.
		 *
		 * @var int $codCurso 				Código del curso en cuestión.
		 * @var int $codestudiante 			Código del estudiante a ser eliminado del curso.
		 *
		 * @throws Exception 				Si se captura alguna excepción en el servicio.
		 */
		static function eliminarEstudiante(){
			try{
				$codCurso=PostGet::obtenerPostGet('codCurso');
				$codEstudiante=PostGet::obtenerPostGet('codEstudiante');
				CursoServicio::eliminarEstudiante($codCurso,$codEstudiante);
				
				
			}catch(Exception $e){
				echo $e;
				
			}
		}
		/**
		 * Función pública y estática que permite listar los cursos por código de docente.
		 *
		 * Obtiene el código del docente y el código del periodo,
		 * luego lo pasa como parámetro a la función obtenerCursosPorDocente del servicio.
		 *
		 * @var int $codDocente 				Código del docente.
		 * @var int $codPeriodo					Código del del periodo.
		 *
		 * @throws Exception 					Si se captura alguna excepción en el servicio.
		 */
		static function listarCursosPorDocente(){
			try{
				var_dump($codDocente=PostGet::obtenerPostGet('codDocente'));
				var_dump($codPeriodo=PostGet::obtenerPostGet('codPeriodo'));
				var_dump($r=CursoServicio::obtenerCursosPorDocente($codDocente,$codPeriodo));
				//Vista::mostrar(listaDocente);
			}catch(Exception $e){
				echo $e;	
			}
			
			
		}
		/**
		 * Función pública y estática que permite listar los cursos por sección, 
		 * código de periodo y código de trayecto.
		 *
		 * Obtiene el código del periodo, la sección y el código del trayecto y se pasan como
		 * parámetros a la función obtenerSeccionUnCurr($codPeriodo, $codTrayecto, $seccion)
		 *
		 * @var int $codPeriodo 			Código del Periodo de los cursos a consultar.
		 * @var int $codTrayecto 			Código del Trayecto de los cursos a consultar.
		 * @var string|null $seccion 		Sección de los cursos a consultar.
		 *
		 * @throws Exception 				Si se captura alguna excepción en el servicio.
		 */
		static function listarSeccioYUniCurr() {
			try{
			
				$codPeriodo = PostGet::obtenerPostGet('codPeriodo');
				$seccion = PostGet::obtenerPostGet('seccion');
				$codtrayecto=PostGet::obtenerPostGet('codTrayecto');
				$seccionYUniCurr=CursoServicio::obtenerSeccionUnCurr($codPeriodo,$codtrayecto,$seccion);
				
				if ($seccionYUniCurr){
					Vista::asignarDato('seccionYUniCurr',$seccionYUniCurr);	
					Vista::asignarDato('estatus',1);
				}	
				else {
					$mensaje="no hay unidades curriculares";
					Vista::asignarDato('mensaje',$mensaje);
				}
				Vista::mostrar();
			}catch(Exception $e){
				throw $e;
			}
		
		}
		/**
		 * Función pública y estática que obtiene los cursos disponibles cursados.
		 * 
		 * Obtiene el código del estudiante y lo pasa como parámetro a la función
		 * cursosDisponiblesCursados, de retornar algo, se lo asigna a la vista y
		 * coloca el estatus como 1.
		 * De retornar null, asigna un mensaje.
		 * 
		 * @var int $codEstudiante					Código del Estudiante.
		 * 
		 * @throws Exception 					Si se captura alguna excepción en el servicio.
		 */
		static function cursosDisponiblesCursados(){
			try{
			
				$codEstudiante= PostGet::obtenerPostGet('codEstudiante');
				$cursos=CursoServicio::cursosDisponiblesCursados($codEstudiante);
				
				if ($cursos){
					Vista::asignarDato('cursos',$cursos);	
					Vista::asignarDato('estatus',1);
				}	
				else {
					$mensaje="no hay cursos";
					Vista::asignarDato('mensaje',$mensaje);

				}
				Vista::mostrar();
			}catch(Exception $e){
				throw $e;
			}
		}
		/**
		 * Función pública y estática que obtiene los estudiantes que pueden cursar el curso.
		 * 
		 * Obtiene el código del curso y se lo pasa como parámetro a la función
		 * obtenerEstudiantesC del servicio, ésta retornará los estudiantes que pueden
		 * inscribirse en ese curso, teniendo como criterio que el estudiante
		 * no esté cursando, haya aprobado, esté preinscrito o inscrito en otro curso
		 * que dicte la misma unidad curricular.
		 * 
		 * @var int $codCurso				Código del curso en cuestión.
		 * 
		 * @throws Exception 					Si se captura alguna excepción en el servicio.
		 * 
		 */
		public static function obtenerEstudiantesC(){
			try{
				$codCurso = PostGet::obtenerPostGet('codCurso');

				$r=CursoServicio::obtenerEstudiantesC($codCurso,false);
         
				if($r){
					Vista::asignarDato('estudiante',$r);
					Vista::asignarDato('estatus',1);
				}
				else{
					$mensaje = "No hay estudiantes disponibles para este curso.";
					Vista::asignarDato($mensaje,$mensaje);
				}
				Vista::mostrar();
			}catch (Exception $e){
				throw $e;	
			}
		}
		/**
		 * Función pública y estática que que obtiene los datos necesarios para el acta de notas.
		 * 
		 * Obtiene el código del curso y lo pasa como parámetro a la función obtenerEstConPensum,
		 * que retornará los datos necesarios o null.
		 * De retornar algo, lo asigna a la vista y coloca el estatus en 1, de no hacerlo asigna un mensaje.
		 * 
		 * @var int $codCurso 				Código del curso.
		 * 
		 * @throws Exception 				Si se captura alguna excepción en el servicio.
		 * 
		 */
		public static function verEstudiantesPDF(){
			try{
				$codCurso = PostGet::obtenerPostGet('codigoCurso');
				
				$r = CursoServicio::obtenerEstConPensum($codCurso);
				$l = CursoServicio::obtenerLeyendaEstatusCurso();
				if($r){
					Vista::asignarDato('estatus',1);
					Vista::asignarDato('leyenda',$l);
					Vista::asignarDato('estudiante',$r);
				}
				else{
					Vista::asignarDato("mensaje", "Hubo un error al generar el PDF. Revise los datos del curso.");
				}
				Vista::mostrar();
			}catch(Exception $e){
				throw $e;
			}
		}
}
