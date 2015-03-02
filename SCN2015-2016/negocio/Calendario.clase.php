<?php

class Calendario { 
	//atributos de la clase
	private $CalendarioID;
	private $Fecha;
	private $Descripcion;
	private $Anual;
	private $UsuarioCreador;
	private $FechaCreacion;
	private $UsuarioModificador;
	private $FechaModificacion;


	public function __construct($CalendarioID=NULL, $Fecha=NULL, $Descripcion=NULL, $Anual=NULL, $UsuarioCreador=NULL, $FechaCreacion=NULL, $UsuarioModificador=NULL, $FechaModificacion=NULL)
	{
		$this->asignarCalendarioID($CalendarioID);
		$this->asignarFecha($Fecha);
		$this->asignarDescripcion($Descripcion);
		$this->asignarAnual($Anual);
		$this->asignarUsuarioCreador($UsuarioCreador);
		$this->asignarFechaCreacion($FechaCreacion);
		$this->asignarUsuarioModificador($UsuarioModificador);
		$this->asignarFechaModificacion($FechaModificacion);

	}


	//Coloque aquí los métodos y operaciones de la clase


	//Asignar y obtener de cada atributo
	public function asignarCalendarioID($CalendarioID){
		$this->CalendarioID = $CalendarioID;
	}
	public function obtenerCalendarioID(){
		return $this->CalendarioID;
	}

	public function asignarFecha($Fecha){
		$this->Fecha = $Fecha;
	}
	public function obtenerFecha(){
		return $this->Fecha;
	}

	public function asignarDescripcion($Descripcion){
		$this->Descripcion = $Descripcion;
	}
	public function obtenerDescripcion(){
		return $this->Descripcion;
	}

	public function asignarAnual($Anual){
		$this->Anual = $Anual;
	}
	public function obtenerAnual(){
		return $this->Anual;
	}

	public function asignarUsuarioCreador($UsuarioCreador){
		$this->UsuarioCreador = $UsuarioCreador;
	}
	public function obtenerUsuarioCreador(){
		return $this->UsuarioCreador;
	}

	public function asignarFechaCreacion($FechaCreacion){
		$this->FechaCreacion = $FechaCreacion;
	}
	public function obtenerFechaCreacion(){
		return $this->FechaCreacion;
	}

	public function asignarUsuarioModificador($UsuarioModificador){
		$this->UsuarioModificador = $UsuarioModificador;
	}
	public function obtenerUsuarioModificador(){
		return $this->UsuarioModificador;
	}

	public function asignarFechaModificacion($FechaModificacion){
		$this->FechaModificacion = $FechaModificacion;
	}
	public function obtenerFechaModificacion(){
		return $this->FechaModificacion;
	}

}

?>