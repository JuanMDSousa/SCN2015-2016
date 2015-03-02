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

Nombre: TrayectoServicio.clase.php
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
require_once "UnidadCurricularServicio.clase.php";

class TrayectoServicio 
{
	function __construct() 
	{
	}
		
	/*	Método genérico que permite hacer consultas complejas.
		Parámetros de entrada:
	    	campos: Campos a consultar de la base de datos (opcional)
	    	where: Condición where de la consulta (opcional)
	    	orderby: Clausula order by de la consulta SQL (opcional)
	    	parametros: Arreglo con los parámetros de la consulta (opcional)
		Valores de retorno:
			Un arreglo de objetos tipo Trayecto.
	    	Null: no trae ningun trayecto.
		Excepciones que lanza.
			Exception: Si ocurre un error en la base de datos.
	*/
	static function obtenerTrayecto($campos="*", $where=null, $orderBy=null, $parametros=null)
	{
		//instrucción para reconocer el objeto conexión
		global $gbConectorBD;
		//construcción de la consulta SQL
		$sql = "select $campos from ts_trayecto"
			. (($where!=null)? " where $where":"")
			. (($orderBy!=null)? " order by $orderBy":"")
			. ";";
		$result = $gbConectorBD->ejecutarDQLDirecto($sql,$parametros);

		if ($result === FALSE) 
			throw new Exception("Fallo la conexion a base de datos");
		if ( $result === 0) 
			return null;
			
			for ($i = 0 ; $i < count($result); $i++){
				//retorna un arreglo de Trayecto en caso de existir data
				$trayectos[$i] = new trayecto();
				$trayectos[$i]->asignarCodigo($result[$i]['codigo']);
				$trayectos[$i]->asignarCodPensum($result[$i]['cod_pensum']);
				$trayectos[$i]->asignarNumero($result[$i]['num_trayecto']);
				$trayectos[$i]->asignarCertificado($result[$i]['certificado']);
				$trayectos[$i]->asignarMinCredito($result[$i]['min_credito']);
			}

			return $trayectos;
	}			

	/*	Metodo que  permite buscar un trayecto en específico por su codigo,si
	    el parámetro completo se pasa con true trae un trayecto  unidades curriculares,
	    si pasa en false trae el objeto trayecto con su información básica sin unidades,
	    el parámetro completo esta en true predeterminado.
		Parámetros de entrada:
	    	codigo: código del trayecto a buscar.
		Valores de retorno:
			Arreglo cuya única posición (la 0) es el objeto trayecto.
			null: En caso de no existir coincidencia.
		Excepciones que lanza.
			Exception: si ocurre un error en la base de datos.
			Exception: si el codigo es null.
	*/
	static function obtenerTrayectoPorCodigo($codigo,$completo=TRUE){
		if($codigo === null)
			throw new Exception("el codigo enviado en la funcion obtenerTrayectoPorCodigo() es null");
			
		$trayectos= TrayectoServicio::obtenerTrayecto("*", "codigo = $1",null, array($codigo));
		if ($trayectos!= null)
			$trayecto =$trayectos[0];
		else
			return null;

		if ($completo==TRUE){
			$unidades=uniCurricularServicio::obteneruniCurricularPorTrayecto($codigo);
			if ($unidades!= FALSE)
				$trayecto->asignarUnidades($unidades);
			else
				return $trayecto;
		}
		else
			return $trayecto;
		return $trayecto;	
	}
	
	/*	Permite buscar un trayecto en especifico por numero y pensum.
		Parámetros de entrada:
			numTrayecto: numero  del trayecto a busca.
			CodPensum: el codigo del pensum al que pertenece 
		Valores de retorno:
			objeto tipo pensum.
			null: En caso de no existir coincidencia
	*/
	static function obtenerTrayectoPorNumero($numTrayecto,$codPensum){
		if ($numTrayecto==null)
			throw new Exception("el numTrayecto enviado en la funcion obtenerTrayectoPorNumero() es null");
		$parametros = array($numTrayecto,
							$codPensum
					  );
		return TrayectoServicio::obtenerTrayecto("*", "num_trayecto = $1 and cod_pensum = $2",null, $parametros);
	}
	
	/*	Permite buscar todos los trayectos de un pensum, si el parámetro completo 
		se pasa con true trae un arreglo de trayecto con sus  unidades curriculares, 
		si pasa en false trae el objeto trayecto con su información básica sin unidades, 
		el parámetro completo esta en true predeterminado.
		Parámetros de entrada:
			codPensum: codigo  del pensum a busca.
			Completo: determina el trayecto a retornar true con unidades false 			       sin unidades.
		Valores de retorno:
			Arreglo de objetos pensum
			null: En caso de no existir coincidencia
	   	Excepciones que lanza.
			Exception: si ocurre un error en la base de datos.
			Exception: si el codPensum es null.
	*/
	static function obtenerTrayectoPorPensum($codPensum,$completo=TRUE){
		$orderby = "cod_pensum asc, num_trayecto asc";
		if($codPensum === null)
			throw new Exception("el codPensum enviado en la funcion obtenerTrayectoPorPensum() es null");
		$trayectos= TrayectoServicio::obtenerTrayecto("*", "cod_pensum = $1",$orderby, array($codPensum));
		if ($trayectos != null){
			if ($completo== true){
				for($i=0; $i<count($trayectos);$i++){
					$trayecto= TrayectoServicio::obtenerTrayectoPorCodigo($trayectos[$i]->obtenerCodigo(),true);
					$trayecto2[$i]=$trayecto;
				}
				return $trayecto2;
			}
			else
				return $trayectos;
		}
		else
			return null;
	}

	/*	Permite buscar varios trayectos según un patrón de búsqueda, buscará cualquier coincidencia en mayúscula y/o minúscula en cualquier parte  del código, codPensum, numTrayecto, certificado, min_credito.
		Parámetros de entrada:
	    	patron: patrón a buscar en los diferentes campos.
		Valores de retorno:
			Un arreglo de objetos tipo Trayecto.
			Null: En caso de no existir coincidencias.
	*/
	static function obtenerListaTrayecto($patron){
		$patron = "%" . $patron . "%";
		
		$where = "num_trayecto  (" . $patron . ") or 
		          cod_pensum (" . $patron . ") ";
		return TrayectoServicio::obtenerTrayecto("*", $where ,null, array($patron));	
	}
	
	/* 	Permite agregar un trayecto a la base de datos.
		Parámetros de entrada:
			trayecto: objeto tipo Trayecto.
		Valor de retorno:
			codigo del trayecto: en caso de éxito.
			False: en caso de error.
		Excepciones que lanza.
			Exception: si ocurre un error en la base de datos.
			Exception: si el trayecto es null.
	*/
	static function agregarTrayecto($trayecto){
		global $gbConectorBD;
		
		if ($trayecto === null) 
			throw new Exception("El objeto trayecto pasado por parametro en la funcion agregarTrayecto() es null");

		$sql = "insert into ts_trayecto ( cod_pensum,num_trayecto,certificado,min_credito) 
				values ($1 ,$2 , trim(upper($3)), $4);";
		
		
		$parametros = array($trayecto->obtenerCodPensum(),
							$trayecto->obtenerNumero(),
							$trayecto->obtenerCertificado(),
							$trayecto->obtenerMinCredito()
						);
				
		
		$result = $gbConectorBD->ejecutarDMLDirecto($sql,$parametros);		
		
		if ($result === FALSE) 
			throw new Exception("Fallo la conexion a base de datos");
		if ( $result === 0) 
			return false;
			
			$trayectos=TrayectoServicio::obtenerTrayectoPorNumero($trayecto->obtenerNumero(),$trayecto->obtenerCodPensum());
			$trayecto1=$trayectos[0];
			return $trayecto1->obtenerCodigo();
		
	}
	/*	Permite agregar un trayecto a la base de datos.
		Parámetros de entrada:
	     	codPensum: código del pensum al que pertenece.
			numero:numero del trayecto.
			certificado: certificado del trayecto.
			MinCredito:unidades de credito del trayecto.
		Valor de retorno:
			codigo del trayecto: en caso de éxito.
			False: en caso de error.
		Excepciones que lanza.
			Exception: si ocurre un error en la base de datos.
			Exception: si el cod pensum o numero es null.
	*/
	static function agregarTrayectoD($codPensum,$numero,$certificado,$minCredito){
		global $gbConectorBD;
		
		if (($codPensum === null) or ($numero === null))
			throw new Exception("Alguno de los parametros pasados a la funcion agregarTrayectot() estan en null verifique codPensum, numero, certificado y minCredito..");
		
		$trayecto = new trayecto();
		$trayecto->asignarCodPensum($codPensum);
		$trayecto->asignarNumero($numero);
		$trayecto->asignarCertificado($certificado);
		$trayecto->asignarMinCredito($minCredito);
		
		return TrayectoServicio::agregarTrayecto($trayecto);
		
	}
	
	
	/*	Permite modificar un trayecto en la base de datos.
		Parámetros de entrada:
			trayecto: objeto tipo Trayecto, la modificación se le hará
			al trayecto que tenga el mismo código de este objeto.
		Valor de retorno:
			True: en caso de éxito.
	     	False: en caso de error.
		Excepciones que lanza:
			Exception: si ocurre un error en la base de datos.
			Exception: si el trayecto es null.
	*/	
	static function modificarTrayecto($trayecto){
		global $gbConectorBD;
	
		if ($trayecto === null) 
			throw new Exception("El objeto trayecto pasado por parametro en la funcion modificarTrayecto() es null");
			
		$sql = "update ts_trayecto set num_trayecto = $2, certificado = trim(upper($3)), min_credito = $4
		         where codigo = $1;";

		$parametros = array($trayecto->obtenerCodigo(),
							$trayecto->obtenerNumero(),
							$trayecto->obtenerCertificado(),
							$trayecto->obtenerMinCredito()
						);
		$result = $gbConectorBD->ejecutarDMLDirecto($sql,$parametros);

		if ($result === FALSE) 
			throw new Exception("Fallo la conexion a base de datos");
		if ( $result === 0) 
			return false;
		return true;
	}
	
	/*	Permite modificar un trayecto en la base de datos.
		Parámetros de entrada:
			codigo: código del pensum al que se modificara.
			numero:numero del trayecto.
			certificado: certificado del trayecto.
			MinCredito:unidades de credito del trayecto.
		Valor de retorno:
	     	True: en caso de éxito.
	     	False: en caso de error.
		Excepciones que lanza.
			Exception: si ocurre un error en la base de datos.
			Exception: si el codigo o numero es null.
	*/
	static function modificarTrayectoD($codigo,$numero,$certificado,$minCredito){
		global $gbConectorBD;
		
		if (($codigo === null) or ($numero === null))
			throw new Exception("Alguno de los parametros pasados a la funcion modificarTrayectot() estan en null verifique codPensum, numero, certificado y minCredito..");
		
		$trayecto = new trayecto();
		$trayecto->asignarCodigo($codigo);
		$trayecto->asignarNumero($numero);
		$trayecto->asignarCertificado($certificado);
		$trayecto->asignarMinCredito($minCredito);
		
		return TrayectoServicio::modificarTrayecto($trayecto);
	}
	
	
	/*	Permite eliminar un trayecto de la base de datos.
		Parámetros de entrada:
			codigo: código del trayecto a eliminar.
		Valor de retorno:
	    	True: en caso de éxito
			False: en caso de error
		Excepciones que lanza.
			Exception: si ocurre un error en la base de datos.
			Exception: si el codigo es null.
	*/	
	static function eliminarTrayecto($codigo){
		global $gbConectorBD;
			
		if ($codigo === null)
			throw new Exception("El codigo pasado a la funcion eliminarTrayecto() esta en null");
		
		$sql = "delete from ts_trayecto 
		         where codigo = $1;";
		$parametros = array($codigo);
		

		$result = $gbConectorBD->ejecutarDMLDirecto($sql,$parametros);

		if ($result === FALSE) 
			throw new Exception("Fallo la conexion a base de datos");
		if ( $result === 0) 
			return false;
		return true;
	}
	
	/*	Permite eliminar un 	trayecto de la base de datos.
		Parámetros de entrada:
			codPensum: código del pensum del que se eliminaran los trayecto.
		Valor de retorno:
			True: en caso de éxito
			False: en caso de error
		Excepciones que lanza.
			Exception: si ocurre un error en la base de datos.
			Exception: si el codPensum es null.
	*/
	static function eliminarTrayectoPorPensum($codPensum){
		global $gbConectorBD;
		
		if ($codPensum === null)
			throw new Exception("El codPensum pasado a la funcion eliminarTrayectoPorPensum() esta en null");
		
		
		$sql = "delete from ts_trayecto 
		         where cod_pensum = $1;";
		$parametros = array($codPensum);
		
		//conexión, ejecución y desconexión
		$result = $gbConectorBD->ejecutarDMLDirecto($sql,$parametros);

		if ($result === FALSE) 
			throw new Exception("Fallo la conexion a base de datos");
		if ( $result === 0) 
			return false;
		return true;
	}
	/*	Permite eliminar un trayecto de la base de datos.
		Parámetros de entrada:
			codPensum: código del pensum del que se eliminaran los trayecto.
			Numero:numero del trayecto que se eliminara el trayecto.
		Valor de retorno:
	    	True: en caso de éxito
			False: en caso de error
		Excepciones que lanza.
			Exception: si ocurre un error en la base de datos.
			Exception: si el codPensum o numero es null.
	*/
	static function eliminarTrayectoPorNumeroYPensum($numero,$codPensum){
		global $gbConectorBD;
		
		if (($codPensum === null) or ($numero=== null))
			throw new Exception("El codPensum o el numero pasado a la funcion eliminarTrayectoPorNumeroYPensum() esta en null");
			
		$sql = "delete from ts_trayecto 
		         where num_trayecto = $1 and cod_pensum=$2;";
		         
		$parametros = array($numero,
							$codPensum
							);
		
		//conexión, ejecución y desconexión
		$result = $gbConectorBD->ejecutarDMLDirecto($sql,$parametros);

		if ($result === FALSE) 
			throw new Exception("Fallo la conexion a base de datos");
		if ( $result === 0) 
			return false;
		return true;
	}
}
