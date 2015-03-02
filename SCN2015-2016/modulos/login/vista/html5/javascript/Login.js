/*
 * * * * * * * * * * LICENCIA * * * * * * * * * * * * * * * * * * * * *

Copyright(C) 2012
docente Universtiario de Tecnología Dr. Federico Rivero Palacio

Este programa es Software Libre y usted puede redistribuirlo y/o modificarlo
bajo los términos de la versión 3.0 de la Licencia Pública General (GPLv3)
publicada por la Free Software Foundation (FSF), es distribuido sin ninguna
garantía. Usted debe haber recibido una copia de la GPLv3 junto con este
programa, sino, puede encontrarlo en la página web de la FSF, 
específicamente en la dirección http://www.gnu.org/licenses/gpl-3.0.html

 * * * * * * * * * * ARCHIVO * * * * * * * * * * * * * * * * * * * * *

Nombre: Login.js
Diseñador: Jhonny Vielma
Programador: Jhonny vielma
Fecha: octubre 2014
Descripción:  
	Este archivo contiene los códigos javascript necesarios y particulares
	del módulo login, debe ser incluido en todas las vistas de este
	módulo. Contiene básicamente validaciones y configuraciones iniciales
	para llevar a cabo las acciones propias de este módulo; es decir comprobaciones
	del formulario y la obtención del logeo en el SCN (Sistema de Control de notas)

 * * * * * * * * Cambios/Mejoras/Correcciones/Revisiones * * * * * * * *
Diseñador - Programador /   Fecha   / Descripción del cambio
---                         ----      ---------

 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/



/* Funcion que permite abrir el modal de sesion con su formularios cargados 
 * para que el usuario inicie sesion.
 * 		Parametros de entrada: 	No posee
 * 		valores de salida: 		No Posee
 * 		ejemplo: 				dialogoSesion();
 * 
 * */
function dialogoSesion(){
	crearDialogo('dialogoSesion','Iniciar Sesión', '<center>Ventana de acceso al SCN</center>',1, 'iniciarSesion()','Entrar al Sistema',true);
	montarInformacionDialogoSesion();
	
}
/* Funcion que monta el formulario de sesion en el modal, esta funciom
 * carga el formulario desde el servidor y busca la informacion que
 * requiere el modal como los institutos del sistema.
 * 		Parametros de entrada: 	No posee
 * 		valores de salida: 		No Posee
 * 		ejemplo: 				montarInformacionDialogoSesion();
 * 
 * */
function montarInformacionDialogoSesion(){
	$(".modal-body").load("modulos/login/vista/html5/FormularioIniciarSesion.html");
}


/* Funcion que busca los institutos que se encuentran en el sistema
 * mediante una peticion ajax para montar la informacion en el modal
 * de iniciar sesion.
 * 		Parametros de entrada: 	No posee
 * 		valores de salida: 		No Posee
 * 		ejemplo: 				buscarInformacionDialogoSesion();
 * 
 * */
//function buscarInformacionDialogoSesion(){
//	buscarInstitutos();
//}

/* Funcion que se ejecuta cuando el ajax de buscar los institos fue 
 * exitosa, esta funcion carga los institutos en el modal o manda un
 * mensaje que proviene del servidor.
 * 		Parametros de entrada: 	Data -> informacion de los institutos
 * 		valores de salida: 		No Posee
 * 		ejemplo: 				succInstitutos(data);
 * 
 * */
//function succInstitutos(data){
//	if(data.estatus>0){
//		institutos=data.institutos;
//		montarInstitutos(institutos);
//	}
//	else 
//		mostrarMensaje(data.mensaje,2);
//}

/* Funcion que monta los los institutos en el select de institutos
 * que se encuentra en el dialogo de iniciar sesion.
 * 		Parametros de entrada: 	institutos -> informacion de los institutos
 * 		valores de salida: 		No Posee
 * 		ejemplo: 				montarInstitutos(institutos);
 * 
 * */
//function montarInstitutos(institutos){
//	cadena="";
//	for(var i=0;i<institutos.length;i++){
//		instituto=institutos[i];
//		cadena+="<option value="+instituto["codigo"]+">"+instituto["nombre"]+"</option>";
//	}
//	$(cadena).appendTo("#Linstitutos");
//	activarSelect();
	
//}
/* Funcion que arma la consulta ajax para buscar los institutos en el servidor
 * y llama a ajax mvc que termina de armar la consulta.
 * 		Parametros de entrada: 	No posee
 * 		valores de salida: 		No Posee
 * 		ejemplo: 				buscarInstitutos();
 * 
 * */

//function buscarInstitutos(){
//	var a=Array("m_modulo","instituto","m_accion","listar",
//				"m_vista","Listar");

//	ajaxMVC(a,succInstitutos,error);
//}
/* Funcion que arma la consulta ajax para buscar los departamentos
 * de un instituto en el servidor y llama a ajax mvc que termina de armar la consulta.
 * 		Parametros de entrada: 	codInstituto -> codigo del instituto 
 * 		valores de salida: 		No Posee
 * 		ejemplo: 				buscarDepartamentos(codInstituto);
 * 
 * */
//function buscarDepartamentos(codInstituto){
//	var a=Array("m_modulo","departamento","m_accion","listarPI",
//				"m_vista","ListarDepartamentoPorInstituto","codInstituto",codInstituto);
//	ajaxMVC(a,succDepartamentos,error);
//}
/* Funcion que se ejecuta cuando la consulta ajax de buscar departamentos 
 * falla por algun problema en el servidor.
 * 		Parametros de entrada: 	No posee 
 * 		valores de salida: 		No Posee
 * 		ejemplo: 				errorDepartamentos();
 * 
 * */
//function errorDepartamentos(){
//	mostrarMensaje("El instituto no posee departamentos",2);
//}
/* Funcion que se ejecuta cuando la una consulta ajax
 * falla por algun problema en el servidor.
 * 		Parametros de entrada: 	Data-> Informacion que proviene del servidor
 * 		valores de salida: 		No Posee
 * 		ejemplo: 				error(data);
 * 
 * */
function error(data){
		mostrarMensaje("error error: " + data.responseText,2);
}
/* Funcion que se ejecuta cuando se selenciona un instituto
 * en el select del dialogo de iniciar sesion con el onChange y
 * busca en el servidor los departamento de ese instituto.
 * 		Parametros de entrada: 	No Posee
 * 		valores de salida: 		No Posee
 * 		ejemplo: 				obtenerDepartamentos();
 * 
 * */
//function obtenerDepartamentos(){
//	if ($("#Linstitutos").val()=='null'){
//		mostrarMensaje("seleccione un instituto valido",3);
//		montarDepartamentos();
//	}
//	else
//		buscarDepartamentos($("#Linstitutos").val());
//}

/* Funcion que se ejecuta cuando la busqueda ajax de los departamentos
 * es satisfactoria y monta los departamentos en en select de departamentos
 * de el modal de iniciar sesion.
 * 		Parametros de entrada: 	Data-> Informacion de los departamentos
 * 		valores de salida: 		No Posee
 * 		ejemplo: 				succDepartamentos(data);
 * 
 * */	
//function succDepartamentos(data){
//	if(data.estatus>0){
//		montarDepartamentos(data.departamentos);
//	}
//	else 
//		mostrarMensaje(data.mensaje,2);
//}


/* Funcion que se ejecuta al selecionar un departamento y busca con un ajax
 * los periodos asociados a ese departamento mediante la funcion onchage de
 * los departamentos.
 * 		Parametros de entrada: 	No Posee
 * 		valores de salida: 		No Posee
 * 		ejemplo: 				obtenerPeriodo();
 * 
 * */
//function obtenerPeriodo(){
//	if ($("#Ldepartamentos").val()=='null'){
//		mostrarMensaje("seleccione un departamento valido",3);
//		montarPeriodos()
//	}
//	else 
//		buscarPeriodos($("#Ldepartamentos").val());
	
//}

/* Funcion que se cuando el succ de buscar periodos es exitosa
 * y monta los periodos en el select de periodos.
 * 		Parametros de entrada: 	Periodos-> informacion de periodos
 * 		valores de salida: 		No Posee
 * 		ejemplo: 				montarPeriodos(periodos);
 * 
 * */
//	function montarPeriodos(periodos=null){
//		$('#perio').remove();
//		cadena="";
//		cadena+="<div class='col-md-6 ' id='perio'>";
//		cadena+="<select class='selectpicker' id='Lperiodo' data-live-search='true' data-size='auto' multiple title='periodo academico'";
//		if (periodos){
//			cadena+="<option value='1000'>Periodos academicos</option>";
//			for(var i=0;i<periodos.length;i++){
//				cadena+="<option value='"+periodos[i]["codigo"]+"'> Periodo "+periodos[i]["fec_inicio"]+" - "+periodos[i]["fec_final"]+"</option>";
//			}
//		}
//		else {
//				cadena+="<option value='1000'>Periodos academicos</option>";
//				cadena+="<option value='null'>No posee Periodo</option>";
//		}
//		cadena+="</select>";	
//		cadena+="</div>";
//		$(cadena).appendTo("#seccionPeriodo");
//		activarSelect();
//	}

/* Funcion que se ejecuta cuando el succ de buscar departamento es exitosa
 * y monta los departamentos en el select de departamentos con toda su
 * información.
 * 		Parametros de entrada: 	Departamentos-> informacion de los departamentos
 * 		valores de salida: 		No Posee
 * 		ejemplo: 				montarDepartamentos(departamentos);
 * 
 * */
//	function montarDepartamentos(departamentos=null){
//		if (($("#Ltipo").val()!="A")&&($("#Ltipo").val()!="JC")){
//			$('#departamen').remove();
//			cadena="";
//			cadena+="<div class='col-md-6' id='departamen'>";
//			cadena+="<select class='selectpicker' id='Ldepartamentos' onchange='obtenerPeriodo()' data-live-search='true' data-size='auto' title='Departamento'>";
//			cadena+="<option value='null'>Departamentos</option>";
//			if (departamentos){
//				for(var i=0;i<departamentos.length;i++){
//					cadena+="<option value='"+departamentos[i]["codigo"]+"'>"+departamentos[i]["nombre"]+"</option>";
//				}
//			}
//			else 
//				cadena+="<option value='null'>No posee departamentos</option>";
//			cadena+="</select>";	
//			cadena+="</div>";$(cadena).appendTo("#seccionDepartamento");
//			activarSelect();
//		}
//	}
/* Funcion que se cuando el usuario a colocado todo los datos de autentificacion y 
 * preciona el boton de iniciar sesion.
 * 		Parametros de entrada: 	No Posee
 * 		valores de salida: 		No Posee
 * 		ejemplo: 				iniciarSesion();
 * 
 * */	
	function iniciarSesion(){
			if (verificarDatos()){
				conectar();
			}
	}
	
	/* Funcion que se cuando el usuario a precionado el boton de cerrar sesion,
	 * esta funcio envia una peticion ajax de para cerrar la sesion .
	 *  Parametros de entrada: 	No Posee
     * 	valores de salida: 		No Posee
     * 	ejemplo: 				cerrarSesion();
     * 
     * */	
	function cerrarSesion(){
			var a=Array("m_modulo","login","m_accion","cerrar",
					"m_vista","Cerrar");
		ajaxMVC(a,succCerrar,error);
	}

	/* Funcion que realiza la peticion ajax al servidor para conectarse 
	 * y hacer todos los ajustes de sesion en el servidor .
	 *  Parametros de entrada: 	No Posee
     * 	valores de salida: 		No Posee
     * 	ejemplo: 				conectar();
     * 
     * */
	function conectar(){
		var a=Array("m_modulo","login","m_accion","iniciar",
					"m_vista","Iniciar","usuario",$("#Lusuario").val(),"pass",$("#Lcontraseña").val()
					);
		ajaxMVC(a,succConectar,error);
	}
	/* Funcion que realiza cuando la peticion de iniciar sesion es exitosa
	 * cuando los datos del usuario son correctos se adacta su pagina para que realize
	 * todoas sus peticiones necesarias.
	 *  Parametros de entrada: 	data->informacion de login
     * 	valores de salida: 		No Posee
     * 	ejemplo: 				succConectar(data);
     * 
     * */
	function succConectar(data){
		if(data.estatus>0){
			console.log(data);
			mostrarMensaje(data.mensaje,1);
			$("#nombreUsuario").remove();
			cadena="";
			cadena+="<li id='nombreUsuario' class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown'>Usuario: "+data.login.nombre +" "+data.login.apellido+"<span class='caret'></span></a>";
			cadena+="<ul class='dropdown-menu' role='menu'>";
			cadena+="<li><a href='#'>Ver Perfil</a></li>";
			cadena+="<li><a href='#'>Configuración</a></li>";
			cadena+="<li><a href='#'>Cambiar Contraseña</a></li>";
			cadena+="<li><a  onclick='cerrarSesion()'>Cerrar Sesión</a></li></ul>";					
			cadena+="</li>";					
			$(cadena).appendTo("#userD");
			$("#dialogoSesion").modal('hide');
			$("<li><a href='index.php?m_modulo=curso&m_formato=html5&m_accion=inscribirEst&m_vista=CursosEstudiante'>Inscribir estudiante</a></li>").appendTo("#infoC");
			

		}
		else 
			mostrarMensaje(data.mensaje,2);
	}
	/* Funcion que realiza cuando la peticion de cerrar sesion es exitosa
	 * esta funcion cambia el entorno grafico del cliente y le loquea los 
	 * accesos.
	 *  Parametros de entrada: 	data->informacion de login
     * 	valores de salida: 		No Posee
     * 	ejemplo: 				succCerrar(data);
     * 
     * */
	function succCerrar(data){
		if(data.estatus>0){
			mostrarMensaje(data.mensaje,1);
			
			$("#nombreUsuario").remove();
			cadena="";
			cadena+="<li id='nombreUsuario' class='dropdown'>";
			cadena+="<a>";
			cadena+="<button onclick='dialogoSesion()' title='Iniciar Sesión' class='login' data-toggle='modal' data-target='#dialogoSesion' >";
			cadena+="<i class='icon-off'></i> Iniciar Sesión";
			cadena+="</button>";				
			cadena+="</a>";							
			cadena+="</li>";							
									
			$(cadena).appendTo("#userD");
			window.location.assign("index.php"); 
		}
		else 
			mostrarMensaje(data.mensaje,2);
	}

	/* Funcion que armar ua peticion ajax y la ejecuta para buscar los 
	 * periodos referente a un departamento.
	 *  Parametros de entrada: 	departamento->codigo del departamento
     * 	valores de salida: 		No Posee
     * 	ejemplo: 				succConectar(data);
     * 
     * */
//	function buscarPeriodos(departamento){
//		var a=Array("m_modulo","periodo","m_accion","listarPD",
//					"m_vista","ListarPorDepartamento","codDepartamento",departamento);
//		ajaxMVC(a,succPeriodos,error);
//	}
	/* Funcion que se ejecuta cuando la busqueda de periodos en el servidos
	 * es exitosa y maneja la informacion que llegada del servidor de los 
	 * periodos.
	 *  Parametros de entrada: 	data->informacion de los periodos
     * 	valores de salida: 		No Posee
     * 	ejemplo: 				succPeriodos(data);
     * 
     * */
//	function succPeriodos(data){
//		if(data.estatus>0){
//			montarPeriodos(data.periodos);
//		}
//		else 
//			mostrarMensaje(data.mensaje,2);
//	}
	/* Funcion que valida todos los imput del dialogo de iniciar sesion 
	 * para que no ocurra error al enviar la informacion al servidor.
	 *  Parametros de entrada: 	No posee
     * 	valores de salida: 		No Posee
     * 	ejemplo: 				verificarDatos();
     * 
     * */
	function verificarDatos(){
		if ($("#Lusuario").val()=="")
			mostrarMensaje("Introduzca usuario",2);
		else if ($("#Lcontraseña").val()=="")
			mostrarMensaje("Introduzca contraseña",2);
		else 
			return true;
	}
	/* Funcion que dependiendo del tipo de usuario remueve o agrega campos 
	 * que solo necesite ese tipo de usuario.
	 *  Parametros de entrada: 	No posee
     * 	valores de salida: 		No Posee
     * 	ejemplo: 				administrarUsuarios();
     * 
     * */
//	function administrarUsuarios(){
//		$('#institu').remove();
//		if ($("#Ltipo").val()=="A"){
//			$('#departamen').remove();
//			$('#perio').remove();
//		}
//		if($("#Ltipo").val()=="JC"){
//			$('#departamen').remove();
//			$('#perio').remove();
//		}
//		if ($("#Ltipo").val()!="A"){
//			crearInstituto();
//		}
//	}
	/* Funcion que carga el select de institutos al dialogo de iniciar 
	 * sesion.
	 *  Parametros de entrada: 	No posee
     * 	valores de salida: 		No Posee
     * 	ejemplo: 				administrarUsuarios();
     * 
     * */
//	function crearInstituto(){
//		cadena="";
//		cadena+="<div class='col-md-6' id='institu'>";
//		cadena+="<select class='selectpicker' onchange='obtenerDepartamentos()' id='Linstitutos'   data-live-search='true' data-size='auto'  title='Instituto'>";
//    	cadena+="<option value='null'>Introduzca instituto</option>";
//    	cadena+="</select>";
//		cadena+="</div>";		
//		$(cadena).appendTo("#seccionInstitutos");
//		buscarInstitutos()
//	}

