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

Nombre: Unidad Curricular.clase.php
Diseñador: Miguel Terrami
Programador: Miguel Terrami
Fecha: Julio de 2012
Descripción:  
	Este archivo contiene la implementación del objeto Unidad Curricular, el cual
	consta de su constructor y de los atributos siguientes
				$codigo;
				$codPensum;
				$codTrayecto;
				$codUnidad;
				$nombre;
				$tipo;
				$hti;
				$hta;
				$uniCredito;
				$durSemana;
				$notMinima;
				$notMaxima;
	
	Se corresponde con la siguiente estructura de la base de datos 
		CREATE TABLE ts_uni_curricular
			(				
				codigo smallint NOT NULL,
				cod_unidad character varying(100) NOT NULL,
				cod_trayecto smallint NOT NULL,
				cod_pensum smallint NOT NULL,
				nombre character varying(100) NOT NULL,
				tipo character(1) NOT NULL,
				hti double precision NOT NULL, -- Atributo para las horas de trabajo independiente
				hta integer NOT NULL, -- Atributo para las horas de trabajo acompanado
				uni_credito smallint NOT NULL,
				dur_semanas smallint NOT NULL,
				not_min_aprobatoria smallint NOT NULL,
				not_maxima smallint NOT NULL,
			CONSTRAINT cp_uni_curricular PRIMARY KEY (codigo ),
			CONSTRAINT cf_uni_curicular__pensum FOREIGN KEY (cod_pensum)
				REFERENCES ts_pensum (codigo) MATCH SIMPLE
				ON UPDATE NO ACTION ON DELETE NO ACTION,
			CONSTRAINT cf_uni_curicular__trayecto FOREIGN KEY (cod_trayecto)
				REFERENCES ts_trayecto (codigo) MATCH SIMPLE
				ON UPDATE NO ACTION ON DELETE NO ACTION,
			CONSTRAINT cf_uni_curricular__uni_cur_tipo FOREIGN KEY (tipo)
				REFERENCES ts_uni_cur_tipo (tipo) MATCH SIMPLE
				ON UPDATE NO ACTION ON DELETE NO ACTION,
			CONSTRAINT ca_uni_curricular UNIQUE (cod_unidad , cod_pensum )
			)	

 * * * * * * * * Cambios/Mejoras/Correcciones/Revisiones * * * * * * * *
Diseñador - Programador /   Fecha   / Descripción del cambio
---                         ----      ---------

 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/


class UniCurricular { 
	//atributos de la clase
	public $codigo;
	public $codPensum;
	public $codTrayecto;
	public $codUnidad;
	public $nombre;
	public $tipo;
	public $hti;
	public $hta;
	public $uniCredito;
	public $durSemana;
	public $notMinima;
	public $notMaxima;


	public function __construct($codigo=NULL, $codPensum=NULL, 
	$codTrayecto=NULL, $codUnidad=NULL, $nombre=NULL, $tipo=NULL, 
	$hti=NULL, $hta=NULL, $uniCredito=NULL, $durSemana=NULL, 
	$notMinima=NULL, $notMaxima=NULL)
	{
		$this->asignarCodigo($codigo);
		$this->asignarCodPensum($codPensum);
		$this->asignarCodTrayecto($codTrayecto);
		$this->asignarCodUnidad($codUnidad);
		$this->asignarNombre($nombre);
		$this->asignarTipo($tipo);
		$this->asignarHti($hti);
		$this->asignarHta($hta);
		$this->asignarUniCredito($uniCredito);
		$this->asignarDurSemana($durSemana);
		$this->asignarNotMinima($notMinima);
		$this->asignarNotMaxima($notMaxima);

	}


	//Coloque aquí los métodos y operaciones de la clase


	//Asignar y obtener de cada atributo
	public function asignarCodigo($codigo){
		$this->codigo = $codigo;
	}
	public function obtenerCodigo(){
		return $this->codigo;
	}

	public function asignarCodPensum($codPensum){
		$this->codPensum = $codPensum;
	}
	public function obtenerCodPensum(){
		return $this->codPensum;
	}

	public function asignarCodTrayecto($codTrayecto){
		$this->codTrayecto = $codTrayecto;
	}
	public function obtenerCodTrayecto(){
		return $this->codTrayecto;
	}
	public function asignarCodUnidad($codUnidad){
		$this->codUnidad = $codUnidad;
	}
	public function obtenerCodUnidad(){
		return $this->codUnidad;
	}
	public function asignarNombre($nombre){
		$this->nombre = $nombre;
	}
	public function obtenerNombre(){
		return $this->nombre;
	}
	public function asignarTipo($tipo){
		$this->tipo = $tipo;
	}
	public function obtenerTipo(){
		return $this->tipo;
	}
	public function asignarHti($hti){
		$this->hti = $hti;
	}
	public function obtenerHti(){
		return is_null($this->hti)? 0: $this->hti;
	}
	public function asignarHta($hta){
		$this->hta = $hta;
	}
	public function obtenerHta(){
		return is_null($this->hta)? 0: $this->hta;
	}
	public function asignarUniCredito($uniCredito){
		$this->uniCredito = $uniCredito;
	}
	public function obtenerUniCredito(){
		return is_null($this->uniCredito)? 0: $this->uniCredito;
	}
	public function asignarDurSemana($durSemana){
		$this->durSemana = $durSemana;
	}
	public function obtenerDurSemana(){
		return is_null($this->durSemana)? 0: $this->durSemana;
	}
	public function asignarNotMinima($notMinima){
		$this->notMinima = $notMinima;
	}
	public function obtenerNotMinima(){
		return is_null($this->notMinima)? 0: $this->notMinima;
	}
	public function asignarNotMaxima($notMaxima){
		$this->notMaxima = $notMaxima;
	}
	public function obtenerNotMaxima(){
		return is_null($this->notMaxima)? 0: $this->notMaxima;
	}
	
	/*Método que permite obtener la cantidad de horas de trabajo independiente que tiene 
	* la unidad curricular. Se multiplica   las  horas hta  por la duracion de semanas
	* de la unidad curricular, retorna un valor tipo entero.*/
	public function obtenerTotalHorasHta(){
		return $this->obtenerHta() * $this->obtenerDurSemana();
	}
	
	/*Método que permite obtener la cantidad de horas de trabajo independiente que tiene 
	* la unidad curricular. Se multiplica   las  horas hti  por la duracion de semanas
	* de la unidad curricular, retorna un valor tipo entero.*/
	public function obtenerTotalHorasHti(){
		return $this->obtenerHti() * $this->obtenerDurSemana();
	}
	
}

?>
