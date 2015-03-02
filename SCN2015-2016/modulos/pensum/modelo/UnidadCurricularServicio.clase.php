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

Nombre: UnidadCurricularServicio.clase.php
Diseñador: Miguel Terrami (metsterrami@gmail.com)
Programador: Miguel Terrami
Fecha: Agosto de 2012
Descripción: 

	Esta clase ofrece el servicio de conexión a la base de datos, recibe 
	los parámetros, construye las consultas SQL, hace las peticiones a 
	la base de datos y retorna los objetos o datos correspondientes a la
	acción.

 * * * * * * * * Cambios/Mejoras/Correcciones/Revisiones * * * * * * * *
Diseñador - Programador /   Fecha   / Descripción del cambio
---                         ----      ---------

 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/


class uniCurricularServicio 
{
	function __construct() 
	{
	}
		
	/*Método genérico que permite hacer consultas complejas.
		Parámetros de entrada:
	    	campos: campos a consultar de la base de datos (opcional)
	    	where: condición where de la consulta (opcional)
	    	orderby: clausula order by de la consulta SQL (opcional)
	    	parametros: arreglo con los parámetros de la consulta (opcional)
		Valores de retorno:
			Un arreglo de objetos tipo UniCurricular.
	    	Null: En caso de no existir coincidencias.
		Excepciones que lanza.
			Exception: si ocurre un error en la base de datos.
	*/
	static function obteneruniCurricular($campos="*", $where=null, $orderBy=null, $parametros=null)
	{
		//instrucción para reconocer el objeto conexión
		global $gbConectorBD;
		//construcción de la consulta SQL
		$sql = "select $campos from ts_uni_curricular"
			. (($where!=null)? " where $where":"")
			. (($orderBy!=null)? " order by $orderBy":"")
			. ";";
			
		//ejecutar el select, con los parámetros correspondientes
		$result = $gbConectorBD->ejecutarDQLDirecto($sql,$parametros);

		if ($result === FALSE) 
			throw new Exception("Fallo la conexion a base de datos");//lanzado de Exception
		if ( $result === 0) 
			return null;

		for ($i = 0 ; $i < count($result); $i++){
			//retorna un arreglo de Unidad Curricular en caso de existir data
			$uniCurriculares[$i] = new UniCurricular();
			$uniCurriculares[$i]->asignarCodigo($result[$i]['codigo']);
			$uniCurriculares[$i]->asignarCodPensum($result[$i]['cod_pensum']);
			$uniCurriculares[$i]->asignarCodTrayecto($result[$i]['cod_trayecto']);
			$uniCurriculares[$i]->asignarCodUnidad($result[$i]['cod_uni_ministerio']);
			$uniCurriculares[$i]->asignarNombre($result[$i]['nombre']);
			$uniCurriculares[$i]->asignarTipo($result[$i]['tipo']);
			$uniCurriculares[$i]->asignarHti($result[$i]['hti']);
			$uniCurriculares[$i]->asignarHta($result[$i]['hta']);
			$uniCurriculares[$i]->asignarUniCredito($result[$i]['uni_credito']);
			$uniCurriculares[$i]->asignarDurSemana($result[$i]['dur_semanas']);
			$uniCurriculares[$i]->asignarNotMinima($result[$i]['not_min_aprobatoria']);
			$uniCurriculares[$i]->asignarNotMaxima($result[$i]['not_maxima']);
		}

			return $uniCurriculares;
		
	}			

	 /*	Metodo que  permite buscar una unidad curricular en específico.
		Parámetros de entrada:
	    	codigo: código de la unidad curricular a buscar.
		Valores de retorno:
			El objeto uniCurricular.
			null: En caso de no existir coincidencia.
	    Excepciones que lanza.
			Exception: si ocurre un error en la base de datos.
			Exception: si el codigo es null.
	 */
	static function obteneruniCurricularPorCodigo($codigo){
		if($codigo!=null){
			$unidades= uniCurricularServicio::obteneruniCurricular("*", "codigo = $1",null, array($codigo));
			if ($unidades!= null)
				return $unidades[0];
			else
				return null;
		}
		else 
			throw new Exception("el codigo enviado en la funcion obteneruniCurricularPorCodigo() es null");
	}
	
	/* 	Permite buscar unidades curriculares por pensum en específico.
		Parámetros de entrada:
			codPensu: codigo  del pensum a busca las unidades curriculares.
		Valores de retorno:
			Arreglo compuesto de objeto UniCurricular.
			null: Valor numérico 0 en caso de no existir coincidencia.
		Excepciones que lanza.
			Exception: Si ocurre un error en la base de datos.
			Exception: Si el codPensum  es null.
	*/
	static function obteneruniCurricularPorPensum($codPensum){
		if($codPensum!=null)
			return uniCurricularServicio::obteneruniCurricular("*", "cod_pensum = $1",null, array($codPensum));
		else
			throw new Exception("el codPensum enviado en la funcion obteneruniCurricularPorPensum() es null");
	}
	
	/*	Permite buscar las unidades curriculares de un pensum y un trayecto en especifico.
		Valores de entrada:
			codPensum: código del pensum a buscar las unidades curriculares.
			codTrayecto: código del trayecto a buscas las unidades curriculares.
		Valores de retorno:
			Arreglo de posiciones de tipo UniCurricular.
			Null: En caso de no existir coincidencia
		Excepciones que lanza.
			Exception: si ocurre un error en la base de datos.
			Exception: si el codPensum o codTrayecto es null.
	*/
	
	static function obteneruniCurricularPorPensumT($codPensum, $codTrayecto){
		if(($codPensum!=null) and ($codTrayecto!=null))
			return uniCurricularServicio::obteneruniCurricular("*", "cod_pensum = $1 and cod_trayecto = $2",null, array($codPensum,$codTrayecto));
		else 
			throw new Exception("el codPensum o el codTrayecto enviado en la funcion obteneruniCurricularPorPensumT() el codPensum o codTrayecto es null");
	}
	
	/*	Permite buscar las unidades curriculares de un trayecto en especifico.
		Valores de entrada:
			codTrayecto: código del trayecto a buscas las unidades curriculares.
		Valores de retorno:
			Arreglo de posiciones de tipo UniCurricular.
			Null: En caso de no existir coincidencia
		Excepciones que lanza.
			Exception: si ocurre un error en la base de datos.
			Exception: si el codTrayecto es null.
	*/
	static function obteneruniCurricularPorTrayecto($codTrayecto){
		if ($codTrayecto!=null)
			return uniCurricularServicio::obteneruniCurricular("*", "cod_trayecto = $1",null, array($codTrayecto));
		else 
			throw new Exception("El codTrayecto enviado en la funcion obteneruniCurricularPorTrayecto() es null");
	}
	
	
	/*	Permite buscar las unidades curriculares de un trayecto en especifico por codigo del ministerio.
		Valores de entrada:
			cod_Uni_Ministerio: código de unidades del ministerio a buscas las 		unidades curriculares.
		Valores de retorno:
			Objeto UniCurricular.
			Null: En caso de no existir coincidencia.
		Excepciones que lanza.
			Exception: si ocurre un error en la base de datos.
			Exception: si el cod_uni_ministerio es null.
	*/
	static function obteneruniCurricularPorCodUniMinisterio($cod_uni_ministerio){
		if ($cod_uni_ministerio!=null)
			return uniCurricularServicio::obteneruniCurricular("*", "cod_uni_ministerio = $1",null, array($cod_uni_ministerio));
		else 
			throw new Exception("El cod_uni_ministerio enviado en la funcion obteneruniCurricularPorCodUniMinisterio() es null");
	}

	/*	Metodo que  permite buscar una unidad curricular en específico por nombre.
		Parámetros de entrada:
	    	nombre: nombre de la unidad curricular a buscar.
		Valores de retorno:
			Objeto uniCurricular.
			Null: En caso de no existir coincidencia.
		Excepciones que lanza.
			Exception: si ocurre un error en la base de datos.
			Exception: si el nombre es null.	
	 */
	static function obteneruniCurricularPorNombre($nombre){
		if ($nombre!=null)
			return uniCurricularServicio::obteneruniCurricular("*", "upper(nombre) = upper($1)",null, array($nombre));
		else 
			throw new Exception("El nombre enviado en la funcion obteneruniCurricularPorNombre() es null");
	}

	/*	Permite buscar varias unidades curriculares  según un patrón de búsqueda,
		buscará cualquier coincidencia en mayúscula y/o minúscula en cualquier parte 
		código, codPensum, codTrayecto, nombre, tipo, Hti, Hta, UniCredito, durSemana, 
		notMaxima, notMinima.

		Parámetros de entrada:
	    	patron: patrón a buscar en los diferentes campos.
		Valores de retorno:
			Un arreglo de objetos tipo UniCurricular.
			null: En caso de no existir coincidencias.
	*/
	static function obtenerListauniCurricular($patron){
		$patron = "%" . $patron . "%";
		$where = "upper(nombre)      (" . $patron . ") or 
		          tipo               (" . $patron . ") 
 		          cod_uni_ministerio (" . $patron . ") 
		          cod_pensum         (" . $patron . ") ";
		return uniCurricularServicio::obteneruniCurricular("*", $where, "codigo asc",array($patron));	
	}
	
	/*	Permite agregar una unidad curricular a la base de datos.
		Parámetros de entrada:
			uniCurricular: objeto tipo UniCurricular.
		Valor de retorno:
			Codigo de la unidad curricular: en caso de éxito.
			False: en caso de error.
		Excepciones que lanza.
			Exception: si ocurre un error en la base de datos.
			Exception: si la UnCurricular es null.
	*/	
	static function agregaruniCurricular($uniCurricular){
		global $gbConectorBD;
		
		if ($uniCurricular === null) 
			throw new Exception("El objeto uniCurricular pasado por parametro en la funcion agregaruniCurricular() es null");
		
		$sql = "insert into ts_uni_curricular (cod_uni_ministerio,nombre,tipo,
				hti,hta,uni_credito,dur_semanas,not_min_aprobatoria,not_maxima,cod_pensum,cod_trayecto) 
				values(trim(upper($1)), upper($2),  $3, $4, $5, $6, $7, $8, $9, $10, $11);";

		$parametros = array(							
							$uniCurricular->obtenerCodUnidad(),
							$uniCurricular->obtenerNombre(),
							$uniCurricular->obtenerTipo(),
							$uniCurricular->obtenerHti(),
							$uniCurricular->obtenerHta(),
							$uniCurricular->obtenerUniCredito(),
							$uniCurricular->obtenerDurSemana(),
							$uniCurricular->obtenerNotMinima(),
							$uniCurricular->obtenerNotMaxima(),
							$uniCurricular->obtenerCodPensum(),
							$uniCurricular->obtenerCodTrayecto()
						);
		
		$result = $gbConectorBD->ejecutarDMLDirecto($sql,$parametros);
		
		if ($result === FALSE) 
			throw new Exception("Fallo la conexion a base de datos");
		if ( $result === 0) 
			return false;
			
		$codUnidadBuscar = strtoupper($uniCurricular->obtenerCodUnidad());
		$unidades=uniCurricularServicio::obteneruniCurricularPorCodUniMinisterio($codUnidadBuscar);
		$unidad=$unidades[0];
		return $unidad->obtenerCodigo();
	}


	/*	Permite 	agregar una unidad curricular a la base de datos.
		Parámetros de entrada:
	     	Nombre: nombre de la unidad.
			Tipo:tipo de unidad.
			Hti:horar de trabajo independiente.
			Hta:horas de trabajo acompañado.
			UniCredito:unidades de credito.
			DurSemana:Duracion de semanas.
			NotMinima:nota minima.
			NotMaxima:nota maxima.
			CodUnidad.codigo del ministerio.
			CodPensum.Codigo del pensum.
			CodTrayecto:codigo del trayecto.
		Valor de retorno:
	    	 Codigo de la unidad curricular: en caso de éxito.
	    	 False: en caso de error.
		Excepciones que lanza.
			Exception: si ocurre un error en la base de datos.
			Exception: si el codTrayecto,CodPensum,tipo o CodUnidad es null.
	*/
	static function agregarUniCurricularD($codUnidad,$nombre,$tipo,$hti,$hta,$uniCredito,$durSemana,$notMinima,$notMaxima,$codPensum,$codTrayecto){
		global $gbConectorBD;
		
		if (($codUnidad === null) or ($codPensum === null) or ($codTrayecto === null) or ($tipo === null))
			throw new Exception("Alguno de los parametros pasados a la funcion agregaruniCurricularc() estan en null verifique codPensum, codTrayecto, tipo y codUnidad..");
			
		$uniCurricular = new UniCurricular();
		$uniCurricular->asignarCodPensum($codPensum);
		$uniCurricular->asignarCodTrayecto($codTrayecto);
		$uniCurricular->asignarCodUnidad($codUnidad);
		$uniCurricular->asignarNombre($nombre);
		$uniCurricular->asignarTipo($tipo);
		$uniCurricular->asignarHti($hti);
		$uniCurricular->asignarHta($hta);
		$uniCurricular->asignarUniCredito($uniCredito);
		$uniCurricular->asignarDurSemana($durSemana);
		$uniCurricular->asignarNotMinima($notMinima);
		$uniCurricular->asignarNotMaxima($notMaxima);
	
		return uniCurricularServicio::agregaruniCurricular($uniCurricular);
	}



	/* 	Permite modificar una unidad curricular en la base de datos.
		Parámetros de entrada:
			uniCurricular: objeto tipo UniCurricular, la modificación se le hará
	        a la unidad curricular  que tenga el mismo código de este objeto.
		Valor de retorno:
	     	True: en caso de éxito.
	     	False: en caso de error.
		Excepciones que lanza.
			Exception: si ocurre un error en la base de datos.
			Exception: si la unicurricular es null.
	*/	
	static function modificaruniCurricular($uniCurricular){
		global $gbConectorBD;
		
		if ($uniCurricular === null) 
			throw new Exception("El objeto uniCurricular pasado por parametro en la funcion modificarniCurricular() es null");
		
		$sql = "update ts_uni_curricular set nombre = $2, tipo = trim(upper($3)), 
				hti = $4, hta = $5, uni_credito = $6, dur_semanas = $7, 
				not_min_aprobatoria = $8, not_maxima = $9, cod_uni_ministerio = $10, 
				cod_pensum = $11, cod_trayecto = $12
		         where codigo = $1;";

		$parametros = array($uniCurricular->obtenerCodigo(),
							$uniCurricular->obtenerNombre(),
							$uniCurricular->obtenerTipo(),
							$uniCurricular->obtenerHti(),
							$uniCurricular->obtenerHta(),
							$uniCurricular->obtenerUniCredito(),
							$uniCurricular->obtenerDurSemana(),
							$uniCurricular->obtenerNotMinima(),
							$uniCurricular->obtenerNotMaxima(),
							$uniCurricular->obtenerCodUnidad(),
							$uniCurricular->obtenerCodPensum(),
							$uniCurricular->obtenerCodTrayecto()
						);
		//$gbConectorPostgre->conectar();
		$result = $gbConectorBD->ejecutarDMLDirecto($sql,$parametros);
		//$gbConectorPostgre->desconectar();

		if ($result === FALSE) 
			throw new Exception("Fallo la conexion a base de datos");
		if ( $result === 0) 
			return false;
		return true;
	}
	
	
	/*	Permite modificar una unidad curricular en la base de 	datos.
		Parámetros de entrada:
			codigo:codigo de la unidad curricular a modificar.
			Nombre: nombre de la unidad.
			Tipo:tipo de unidad.
			Hti:horar de trabajo independiente.
			Hta:horas de trabajo acompañado.
			UniCredito:unidades de credito.
			DurSemana:Duracion de semanas.
			NotMinima:nota minima.
			NotMaxima:nota maxima.
			CodUnidad.codigo del ministerio.
			CodPensum.Codigo del pensum.
			CodTrayecto:codigo del trayecto.
		Valor de retorno:
	     	True: en caso de éxito.
			False: en caso de error.
		Excepciones que lanza.
			Exception: si ocurre un error en la base de datos.
			Exception: si el codTrayecto,codPensum,Codigo o codUnidad es null.
	  
	 */
	static function modificarUniCurricularD($codigo,$nombre,$tipo,$hti,$hta,$uniCredito,$durSemana,$notMinima,$notMaxima,$codUnidad,$codPensum,$codTrayecto){
		global $gbConectorBD;
		
		if (($codigo === null) or ($codPensum === null) or ($codTrayecto === null) or ($tipo === null) or ($codUnidad === null))
			throw new Exception("Alguno de los parametros pasados a la funcion modificaruniCurricularc() estan en null verifique codPensum, codTrayecto, tipo, codUnidad y codigo..");
		
		$uniCurricular->asignarCodigo($codigo);	
		$uniCurricular->asignarCodPensum($codPensum);
		$uniCurricular->asignarCodTrayecto($codTrayecto);
		$uniCurricular->asignarCodUnidad($codUnidad);
		$uniCurricular->asignarNombre($nombre);
		$uniCurricular->asignarTipo($tipo);
		$uniCurricular->asignarHti($hti);
		$uniCurricular->asignarHta($hta);
		$uniCurricular->asignarUniCredito($uniCredito);
		$uniCurricular->asignarDurSemana($durSemana);
		$uniCurricular->asignarNotMinima($notMinima);
		$uniCurricular->asignarNotMaxima($notMaxima);
		
		return uniCurricularServicio::modificaruniCurricular($uniCurricular);
	}
	
	
	/*	Permite eliminar una unidad curricular de la base de datos.
		Parámetros de entrada:
			codigo: código de la unidad curricular a eliminar.
		Valor de retorno:
	    	True: en caso de éxito.
			False: en caso de error.
		Excepciones que lanza.
			Exception: si ocurre un error en la base de datos.
			Exception: si el codigo es null.	
	*/ 
	static function eliminaruniCurricular($codigo){
		global $gbConectorBD;
		
		if ($codigo === null)
			throw new Exception("Elcodigo pasados a la funcion eliminarCurricular() estan en null");
			
		$sql = "delete from ts_uni_curricular 
		         where codigo = $1;";
		$parametros = array($codigo);
		
		$result = $gbConectorBD->ejecutarDMLDirecto($sql,$parametros);

		if ($result === FALSE) 
			throw new Exception("Fallo la conexion a base de datos");
		if ( $result === 0) 
			return false;
		return true;
	}
	
	/*	Permite eliminar una unidad curricular de la base de datos.
		Parámetros de entrada:
			cod_uni_ministerio: código del  ministerio de la unidad curricular a 	eliminar.
		Valor de retorno:
	    	True: en caso de éxito.
			False: en caso de error.
		Excepciones que lanza.
			Exception: si ocurre un error en la base de datos.
			Exception: si el cod_uni_ministerio es null.
	*/
	static function eliminaruniCurricularPorCodMinisterio($cod_uni_ministerio){
		global $gbConectorBD;
		
		if ($cod_uni_ministerio === null)
			throw new Exception("El cod_uni_ministerio pasados a la funcion eliminarCurricular1() estan en null");
			
		$sql = "delete from ts_uni_curricular 
		         where cod_uni_ministerio = $1;";
		$parametros = array($cod_uni_ministerio);
		
		$result = $gbConectorBD->ejecutarDMLDirecto($sql,$parametros);

		if ($result === FALSE) 
			throw new Exception("Fallo la conexion a base de datos");
		if ( $result === 0) 
			return false;
		return true;
	}
}
?>
