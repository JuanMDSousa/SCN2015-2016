<?php
/**
 * @copyright 2014 - Instituto Universtiario de Tecnología Dr. Federico Rivero Palacio
 * @license GPLv3
 * @license http://www.gnu.org/licenses/gpl-3.0.html
 *
 * LoginServicio.php - Servicios de MVCRIVERO.
 *
 * Esta clase ofrece el servicio de conexión a la base de datos, recibe los
 * parámetros, construye las consultas SQL, hace las peticiones a la base de
 * datos y retorna los objetos o datos correspondientes a la acción.
 * 
 *  
 * @author JHONNY VIELMA 		(jhonnyvq1@gmail.com)
 * 
 * @link /base/clases/conexion/Conexion.php 	Clase Conexion
 * 
 * @link /negocio/login.php 					Clase Login
 * 
 * @package Servicios
 */
 

class LoginServicio{
	
	
	
	 /**
		 * Funcion estatica que permite obtener el login a la base de datos.
		 *
		 * Permite cosultar a la base de datos si el usuario pertenece al sistema
		 * y cosultar si su tipo de usuario corresponde a su usuario, se valida 
		 * todo los datos de logueo mediante una consulta.
		 *
		 * @param string  $usuario 				Usuario.
		 * @param string  $tipoU 				Tipo de usuario. 
		 * @param string  $codDepartamento		Codigo del departamento al que pertenece el usuario.
		 * @param string  $codInstituto			Codigo del instituto al que pertenece.
		 * 
		 * @return object|null 	                Objeto login de corresponder todos los datos o null de no corresponder.
		 * 
		 * @throws Exception 					Exceptiones capturas.
		 * 
		 */
	public static function obtenerLogin($usuario){
			try{
				
				$conexion=Conexion::conectar();
				$consulta= " select u.*, per.*,minis.codigo as ministerio,depar.codigo as departamento,
       							    depar.cod_departamento as codigo_departamento_depa,doce.codigo as docente,
       								doce.cod_departamento as codigo_departamento_doce, estudi.codigo as estudiante,
       								estudi.cod_pensum,estudi.cod_departamento as codigo_departamento_estu,
       								conEstudio.codigo as conEstudios,conEstudio.cod_instituto as cod_instituto_con,
      								departamento.nombre as nombre_departamento_depa,departamento1.nombre as nombre_departamento_doce,
      								departamento2.nombre as nombre_departamento_estu,
       								instituto.nombre as instituto_nombre_depa, instituto.codigo as instituto_codigo_depa,instituto1.nombre as instituto_nombre_doce,
       								instituto1.codigo as instituto_codigo_doce,instituto2.nombre as instituto_nombre_estu,instituto2.codigo as instituto_codigo_estu,
      							 	instituto3.nombre as instituto_nombre_con
							 from per.t_usuario as u
									left join sis.t_persona as per on (per.codigo=u.codigo)
       								left join sis.t_usu_ministerio as minis on (per.codigo=minis.codigo)
									left join sis.t_usu_departamento as depar on (per.codigo=depar.codigo)
									left join sis.t_usu_con_estudios as conEstudio on (per.codigo=conEstudio.codigo)
									left join sis.t_estudiante as estudi on (per.codigo=estudi.codigo)
									left join sis.t_docente as doce on (per.codigo=doce.codigo)
									left join sis.t_departamento as departamento on (depar.cod_departamento=departamento.codigo)
									left join sis.t_departamento as departamento1 on (doce.cod_departamento=departamento1.codigo)
									left join sis.t_departamento as departamento2 on (estudi.cod_departamento=departamento2.codigo)
									left join sis.t_instituto as instituto on (departamento.cod_instituto=instituto.codigo)
									left join sis.t_instituto as instituto1 on (departamento1.cod_instituto=instituto1.codigo)
									left join sis.t_instituto as instituto2 on (departamento2.cod_instituto=instituto2.codigo)
									left join sis.t_instituto as instituto3 on (conEstudio.cod_instituto=instituto3.codigo)
							where u.nombre=?" ;

				$ejecutar= $conexion->prepare($consulta);
				$ejecutar->execute(array($usuario));
				
				if($ejecutar->rowCount()!=0){
					$logueo=$ejecutar->fetchAll();

					//echo"<pre>";
					//var_dump($logueo);
					//echo"</pre>";
					if ($logueo[0]['ministerio']!=null){
						$login= new Login($logueo[0]['nombre1'],$logueo[0]['apellido1'],'M',$logueo[0]['codigo'],$logueo[0]['nombre'],null,
										  null,null,null,null,null);
						return $login;
					}
					else if ($logueo[0]['conestudios']!=null){
						$login= new Login($logueo[0]['nombre1'],$logueo[0]['apellido1'],"JC",$logueo[0]['codigo'],$logueo[0]['nombre'],null,
							              $logueo[0]['instituto_nombre_con'],$logueo[0]['cod_instituto_con'],null,null,null);
						return $login;
					}
					else if ($logueo[0]['departamento']!=null){
						$login= new Login($logueo[0]['nombre1'],$logueo[0]['apellido1'],"JD",$logueo[0]['codigo'],$logueo[0]['nombre'],null,
							              $logueo[0]['instituto_nombre_depa'],$logueo[0]['instituto_codigo_depa'],$logueo[0]['nombre_departamento_depa'],
							              $logueo[0]['codigo_departamento_depa'],null);
						return $login;
					}
					else if ($logueo[0]['docente']!=null){
						$login= new Login($logueo[0]['nombre1'],$logueo[0]['apellido1'],"D",$logueo[0]['codigo'],$logueo[0]['nombre'],null,
							              $logueo[0]['instituto_nombre_doce'],$logueo[0]['instituto_codigo_doce'],$logueo[0]['nombre_departamento_doce'],
							              $logueo[0]['codigo_departamento_doce'],null);
						return $login;
					}
					else if ($logueo[0]['estudiante']!=null){
						$login= new Login($logueo[0]['nombre1'],$logueo[0]['apellido1'],"E",$logueo[0]['codigo'],$logueo[0]['nombre'],null,
							              $logueo[0]['instituto_nombre_estu'],$logueo[0]['instituto_codigo_estu'],$logueo[0]['nombre_departamento_estu'],
							              $logueo[0]['codigo_departamento_estu'],$logueo[0]['cod_pensum']);
						return $login;
					}
					else
						return null;
				}
						
			}catch (Exception $e ){
				throw $e;
			}	
		}
		
		

}

?>
