//==================AGREGAR PERSONA======================================================================

//funcion encargada de crear el dialogo con el que se agregaran los datos de persona para su manejo efectivo
function administrarPersona(){	
	//funcion de creacion de dialogo en el cual se le pasan los siguientes parametros
	//(data-target del listar.html.twig, Titulo, informacion debajo del titulo,1 para modal pequeño, 2 para modal grande,funcion de agregacion, boton de agregacion)
	$(".modal").remove();
	crearDialogo("preagregarpersona","<center>Agregar Persona</center>","<center>Formulario de Datos</center>",2,"validarAgregarPersona()","Agregar");		
	//append del modal body en el cual se insertara el formulario
	$("<div class='row'><div class='col-md-12'><div id='personasA'></div></div></div>").appendTo(".modal-body");	
	//load del formulario mandandole una funcion de activacion de selectpickers		
	$("#personasA").load("modulos/persona/vista/html5/js/MontarFormularioPersona.php",function(){activarSelect();});	
}	

function validarAgregarPersona(){
	if(
	validarSoloNumeros('#cedula',7,8,true)&&
	validarSoloTexto('#nombre1',2,30,true)&&
	validarSoloTexto('#apellido1',2,30,true)&&
	validarSoloTexto('#nombre2',2,30,false)&&
	validarSoloTexto('#apellido2',2,30,false)&&
	validarRangos('#rif',2,30,false)&&
	validarTelefono('#telefono1',10,14,false)&&
	validarTelefono('#telefono2',10,14,false)&&
	validarEmail('#cor_personal',5,50,false)&&
	validarEmail('#cor_institucional',10,50,false))
	{
		if($("#numeroEmpleadoDoc2").val()!=null){
			if(validarSoloNumeros('#numeroEmpleadoDoc2',0,5,false))
			{agregarPersona();}
		}else
		{agregarPersona();}
	}
}

function validarModificarPersona(){
	if(
	validarSoloNumeros('#cedula',7,8,true)&&
	validarSoloTexto('#nombre1',2,30,true)&&
	validarSoloTexto('#apellido1',2,30,true)&&
	validarSoloTexto('#nombre2',2,30,false)&&
	validarSoloTexto('#apellido2',2,30,false)&&
	validarRangos('#rif',2,30,false)&&
	validarTelefono('#telefono1',10,14,false)&&
	validarTelefono('#telefono2',10,14,false)&&
	validarEmail('#cor_personal',5,50,false)&&
	validarEmail('#cor_institucional',10,50,false))
	{modificar();}
}

function agregarPersona(){
	var arr = Array (        
					  "m_modulo", "persona",
					  "m_accion","agregar",
					  "m_vista","agregar",
					  "cedula",$("#cedula").val(),
					  "rif",$("#rif").val(),	
					  "nombre1",$("#nombre1").val(),
					  "nombre2",$("#nombre2").val(),	
					  "apellido1",$("#apellido1").val(),
					  "apellido2",$("#apellido2").val(),
					  "sexo",$("#sexo").val(),
					  "fec_nacimiento",$("#fec_nacimiento").val(),	
					  "tip_sangre",$("#tip_sangre").val()[0],	
					  "telefono1",$("#telefono1").val(),	
					  "telefono2",$("#telefono2").val(),
					  "cor_personal",$("#cor_personal").val(),		
					  "cor_institucional",$("#cor_institucional").val(),	
					  "direccion",$("#direccion").val());
	ajaxMVC(arr,succAgregarPer,errorPer);
}
	
function succAgregarPer(data){
	
	var arr = Array ("m_modulo","persona","m_accion","listar","m_vista","recargar");
	    ajaxMVC(arr,succRecargar,errorPer);
	if (data.estatus>0){
		personas=data.persona;		
		mostrarMensaje("El usuario ha sido agregado con exito",1);
		$("#preagregarpersona").modal('hide');
		if($("#estadoEst2").val()[0]!=null){
		  var arr = Array ("m_modulo", "estudiante",
					"m_accion","agregar",
					"m_vista","agregarEstudiante",
					"departamentoEst2",$("#departamentoEst2").val()[0],
					"estadoEst2",$("#estadoEst2").val()[0]);		
            ajaxMVC(arr,succAgregarE,errorPer);
		}
		
		if($("#estadoDoc2").val()[0]!=null){
			var arr2 = Array ("m_modulo", "docente",
					 "m_accion", "agregar",
					 "m_vista","agregarDocente",
					 "departamentoDoc2", $("#departamentoDoc2").val()[0],
					 "numeroEmpleadoDoc2", $("#numeroEmpleadoDoc2").val()[0],
					 "estadoDoc2", $("#estadoDoc2").val()[0]);	
			ajaxMVC(arr2,succAgregarDoc,errorPer);
		}
		var arr = Array ("m_modulo","persona","m_accion","listar","m_vista","recargar");
	    ajaxMVC(arr,succRecargar,errorPer);	
	}
	else{mostrarMensaje("Algun campo se encuentra vacio ó erroneo, revíse!",2);}
}	

//=============================================================================================

function succAgregarE(data){
	if (data.estatus>0){
		//mostrarMensaje(data.mensaje,1);
		}
	else{mostrarMensaje(data.mensaje,2);}
}

function succAgregarDoc(data){
	if (data.estatus>0){
		//mostrarMensaje(data.mensaje,1);
		}
	else{mostrarMensaje(data.mensaje,2);}
}
	
function errorPer(){		
mostrarMensaje("Error de comunicacion con el servidor.",2);}
  	
function eliminar(cedula){
	if (confirm("¿Desea eliminar a la siguente persona?")) {
		var arr = Array ("m_modulo", "persona",
					     "m_accion", "eliminar",
					     "m_vista", "eliminar",
					     "cedula", cedula);
		ajaxMVC(arr,succEliminar,errorEliminar);
	}	
	else 
	return false;		
}
	
function succEliminar(data){
	if (data.estatus>0){
		mostrarMensaje(data.mensaje,1);
		var arr = Array ("m_modulo", "persona",
				     "m_accion", "listar",
				     "m_vista", "recargar");
		ajaxMVC(arr,succRecargar,errorPer);
	}
	else{
		mostrarMensaje(data.mensaje,2);
	}
}

function errorEliminar(data)
{mostrarMensaje("No se puede eliminar ya que esta en uso esta persona",2);}


function succRecargar(data)
{
	if (data.estatus>0){	
		personas=data.persona;
		recargar(personas);
	}
	else{mostrarMensaje(data.mensaje,2);}
}

function recargar(personas){
	$("#tabla2").remove();
	personas=notNull1(personas);
	cadena="";
	cadena+="<table class='table' id='tabla2'>";
	cadena+="<tr class='titulo'>";
    cadena+="<td>Número</td>";
	cadena+="<td>Cédula</td>";
	cadena+="<td>Nombre Completo</td>";
	cadena+="<td>Sexo</td>";
	cadena+="<td>Teléfono</td>";
	cadena+="<td>Correo Personal</td>";
	cadena+="<td colspan='1'>";
	cadena+="<button class='btn btn-success' title='Agregar Persona' onclick='administrarPersona()' data-target='#preagregarpersona' data-toggle='modal'>";
	cadena+="Agregar Persona</button>";			
	cadena+="<td></td>";
	cadena+="<td></td>";
	cadena+="</tr>";
	for (var i=0; i<personas.length; i++){
		cadena+="<tr class='tr'>";
        var num=i+1;
        cadena+="<td>"+num+"</td>";
		cadena+="<td>"+personas[i]['cedula']+"</td>";
		cadena+="<td>"+personas[i]['nombre1']+" "+personas[i]['apellido1']+"</td>";
		cadena+="<td>"+personas[i]['sexo']+"</td>";
		cadena+="<td>"+personas[i]['telefono1']+"</td>";
		cadena+="<td>"+personas[i]['cor_personal']+"</td>";
		cadena+="<td>";
		cadena+="<button class='btn btn-warning' title='Ver Persona' onclick='obtenerPersona("+personas[i]['cedula']+")'>";
		cadena+="<i class='icon-eye-open'></i>";
		cadena+="</button>";	
		cadena+="<button class='btn btn-danger' title='Eliminar Persona' onclick='eliminar("+personas[i]['cedula']+");'>";
		cadena+="<i class='icon-remove'></i>";
		cadena+="</button>";
		cadena+="</td>";
		cadena+="</tr>";
	};
	cadena+="</table>";
	$(cadena).appendTo('#tabla1');
}

function notNull(variable){
	if (variable==null) {variable=" ";}
	return variable;
}

function notNull1(personas){
	for (var i=0; i<personas.length; i++) {
		personas[i]['rif']=notNull(personas[i]['rif']);
		personas[i]['nombre2']=notNull(personas[i]['nombre2']);
		personas[i]['apellido2']=notNull(personas[i]['apellido2']);
		personas[i]['fec_nacimiento']=notNull(personas[i]['fec_nacimiento']);
		personas[i]['tip_sangre']=notNull(personas[i]['tip_sangre']);
		personas[i]['telefono1']=notNull(personas[i]['telefono1']);
		personas[i]['telefono2']=notNull(personas[i]['telefono2']);
		personas[i]['cor_personal']=notNull(personas[i]['cor_personal']);
		personas[i]['cor_institucional']=notNull(personas[i]['cor_institucional']);
		personas[i]['direccion']=notNull(personas[i]['direccion']);
	}
	return personas;
}

function succModifPer (data){
	if (data.estatus>0){
		mostrarMensaje(data.mensaje,1);
		$("#obtenerPersona").modal('hide');
		var arr = Array ("m_modulo", "persona",
					     "m_accion", "listar",
					     "m_vista", "recargar");
		ajaxMVC(arr,succRecargar,errorPer);
		}
	else{mostrarMensaje(data.mensaje,2);}
}  	

function errorModif ()
{mostrarMensaje("Problema con modificar",2);}

function obtenerPersona(cedula){
	var arr = Array("m_modulo", "persona",
					"m_accion", "buscarPersonaCedula",
					"m_vista", "obtenerPersona",
					"cedula", cedula);		
	ajaxMVC(arr,succVerPer,errorPer);					
}

function actEstudiante(value){
	if($("#tipo1").is(':checked')){
		$("#estudiante").load("modulos/estudiante/vista/html5/js/MontarEstudiante2.php",function(){activarSelect();});
		actDepartamentoEst();
	}
	else{
		$("#formularioEstudiante,#departamentoEst,#estadoEst, .modal .btn-danger").remove();
		$(".modal-footer").append("<button class='btn btn-success' onclick='validarAgregarPersona()'>Guardar</button><button class='btn btn-danger' data-dismiss='modal'>Cerrar</button>");
	}
}

function actDepartamentoEst(){
	var arr = Array ("m_modulo", "estudiante",
					"m_accion", "buscarDepartamentos",
					"m_vista","buscarSelect");
	ajaxMVC(arr,succBuscarDepartamentosEst,errorPer);
}

function succBuscarDepartamentosEst(data){
	estudiantes=data.estudiante;
	$("#departamentoEst2,#divDepartamentoEst,#divEstadoEst,#estadoEst2,.modal .btn-success").remove();
	$("#departamentoEst").append('<div class="input-group" id="divDepartamentoEst"><span class="input-group-addon">Departamento:</span><select name="departamentoEst2" class="form-control selectpicker" id="departamentoEst2" data-live-search="true" data-size="auto" multiple data-max-options="1" title="Seleccione Dpto" onchange="actEstadoEst()"></select></div></div>');
	for (var i=0; i<estudiantes.length; i++) {
		$("#departamentoEst2").append("<option value="+estudiantes[i]['codigo']+">"+estudiantes[i]['nombre']+"</option>");
	}
	activarSelect();
}

function actEstadoEst(){
    var arr = Array ("m_modulo", "estudiante",
                    "m_accion", "buscarEstado",
                    "m_vista","buscarSelect");
    ajaxMVC(arr,succBuscarEstadoEst,errorPer);    
}

function succBuscarEstadoEst(data){
	estudiantes=data.estudiante;
    $("#divEstadoEst,#estadoEst2,.modal .btn-success").remove();
    $("#estadoEst").append("<div class='input-group' id='divEstadoEst'><span class='input-group-addon'>Estado:</span><select name='estadoEst2' class='form-control selectpicker' id='estadoEst2' class='selectpicker' data-live-search='true' data-size='auto' multiple data-max-options='1' title='Seleccione el Estado' onchange='actGuardar()'></select></div>");
	for (var i=0; i<estudiantes.length; i++) {
		$("#estadoEst2").append("<option value="+estudiantes[i]['codigo']+">"+estudiantes[i]['nombre']+"</option>");
	}	
    activarSelect();
}

function actDocente(value){
	if($("#tipo2").is(':checked')){
		$("#docente").load("modulos/docente/vista/html5/js/MontarFormularioDocente2.php",function(){activarSelect();});
		actDepartamentoDoc();
	}else{
		$("#formularioDocente,#departamentoDoc,#estadoDoc,#numeroEmpleadoDoc, .modal .btn-danger").remove();
		$(".modal-footer").append("<button class='btn btn-success' onclick='validarAgregarPersona()'>Guardar</button><button class='btn btn-danger' data-dismiss='modal'>Cerrar</button>");
	}
}

function actDepartamentoDoc()
{
	var arr = Array ("m_modulo", "docente",
					"m_accion", "buscarDepartamentos",
					"m_vista","buscarSelect");
	ajaxMVC(arr,succBuscarDepartamentosDoc,errorPer);
}

function succBuscarDepartamentosDoc(data){
	docentes=data.docente;
	$("#departamentoDoc2,#divDepartamentoDoc,#estadoDoc2,#divEstadoDoc,#divNumeroEmpleadoDoc,#numeroEmpleadoDoc2, .modal .btn-success").remove();
	$("#departamentoDoc").append('<div class="input-group" id="divDepartamentoDoc"><span class="input-group-addon">Departamento:</span><select name="departamentoDoc2" class="form-control selectpicker" id="departamentoDoc2" data-live-search="true" data-size="auto" multiple data-max-options="1" title="Seleccione Dpto" onchange="actEstadoDoc()"></select></div>');
    for (var i=0; i<docentes.length; i++) {
		$("#departamentoDoc2").append("<option value="+docentes[i]['codigo']+">"+docentes[i]['nombre']+"</option>");
     }
	activarSelect();
}

function actEstadoDoc(){
    var arr = Array ("m_modulo", "docente",
                    "m_accion", "buscarEstado",
                    "m_vista","buscarSelect");
    ajaxMVC(arr,succBuscarEstadoDoc,errorDoc); 
}

function succBuscarEstadoDoc(data){
    docentes=data.docente;
    $("#divEstadoDoc,#estadoDoc2,#divNumeroEmpleadoDoc,#numeroEmpleadoDoc2,.modal .btn-success").remove();
    $("#estadoDoc").append("<div class='input-group' id='divEstadoDoc'><span class='input-group-addon'>Estado:</span><select name='estadoDoc2' class='form-control selectpicker' id='estadoDoc2' class='selectpicker' data-live-search='true' data-size='auto' multiple data-max-options='1' title='Seleccione el Estado' onchange='actNumDocente()'></select></div>");
	for (var i=0; i<docentes.length; i++) {
		$("#estadoDoc2").append("<option value="+docentes[i]['codigo']+">"+docentes[i]['nombre']+"</option>");
	}	
    activarSelect();
}

function actNumDocente(){
    $("#numeroEmpleadoDoc2,#divNumeroEmpleadoDoc").remove();
    actGuardar();
    $("#numeroEmpleadoDoc").append("<div class='input-group' id='divNumeroEmpleadoDoc'><span class='input-group-addon' title='NumeroEmpleado'>Núm. Empleado:</span><input type='text' name='numeroEmpleadoDoc2' class='form-control' onkeyup=\"validarSoloNumeros('#numeroEmpleadoDoc2',0,5,false)\" id='numeroEmpleadoDoc2' placeholder='###'></div>");
}

function actGuardar()
{
    $(".modal .btn-success,.modal .btn-danger").remove();
    $(".modal-footer").append("<button class='btn btn-success' onclick='validarAgregarPersona()'>Guardar</button><button class='btn btn-danger' data-dismiss='modal'>Cerrar</button>");
}

function errorDoc(){mostrarMensaje("Problema al agregar.",2);}

function succVerPer(data){
	if (data.estatus>0){
		personas=data.persona;
		$(".modal").remove();
		crearDialogo("obtenerPersona","<h2><center>"+personas[0]['nombre1']+" "+personas[0]['apellido1']+"</center></h2>","<center></center>",2,"","");
		$("<div class='row'><div class='col-md-12'><div id='personasL'></div></div></div>").appendTo(".modal-body");
		$("#personasL").load("modulos/persona/vista/html5/js/VerPersona.php",function(){montarPersona(personas);});
		$('#obtenerPersona').modal('show');
	}
	else{mostrarMensaje(data.mensaje,2);}
}

function modificar() { 
	if (confirm("¿Desea modificar estos datos?")) {
		var arr = Array ("m_modulo", "persona",
					  "m_accion", "modificar",
					  "m_vista", "modificar",
					  "cedula",$("#cedula").val(),
					  "rif",$("#rif").val(),	
					  "nombre1",$("#nombre1").val(),
					  "nombre2",$("#nombre2").val(),	
					  "apellido1",$("#apellido1").val(),
					  "apellido2",$("#apellido2").val(),
					  "sexo",$("#sexo").val(),	
					  "fec_nacimiento",$("#fec_nacimiento").val(),	
					  "tip_sangre",$("#tip_sangre").val(),	
					  "telefono1",$("#telefono1").val(),	
					  "telefono2",$("#telefono2").val(),
					  "cor_personal",$("#cor_personal").val(),		
					  "cor_institucional",$("#cor_institucional").val(),	
					  "direccion",$("#direccion").val());	
		ajaxMVC(arr,succModifPer,errorModif);
		} 
		else 
	return false;
}

function montarPersona(persona){
	$('#cedula').val(persona[0]['cedula']);
	$('#nombre1').val(persona[0]['nombre1']);
	$('#rif').val(persona[0]['rif']);
	$('#nombre2').val(persona[0]['nombre2']);
	$('#apellido1').val(persona[0]['apellido1']);
	$('#apellido2').val(persona[0]['apellido2']);
	$('#fec_nacimiento').val(persona[0]['fec_nacimiento']);
	$('#tip_sangre').val(persona[0]['tip_sangre']);
	$('#telefono1').val(persona[0]['telefono1']);
	$('#telefono2').val(persona[0]['telefono2']);
	$('#cor_institucional').val(persona[0]['cor_institucional']);
	$('#cor_personal').val(persona[0]['cor_personal']);
	$('#direccion').val(persona[0]['direccion']);
	$("#sexo").val(persona[0]['sexo']);
	if($("#sexo").val()=='M')
	{$('#sexo').val("Masculino");}
	else{$('#sexo').val("Femenino");}
}	

function activarmodif (value){
	$("#rif").attr('disabled',false);
	$("#nombre1").attr('disabled',false);
	$("#nombre2").attr('disabled',false);
	$("#apellido1").attr('disabled',false);
	$("#apellido2").attr('disabled',false);
	$("#sexo").attr('disabled',false);
	$("#tip_sangre").attr('disabled',false);
	$("#telefono1").attr('disabled',false);
	$("#telefono2").attr('disabled',false);
	$("#fec_nacimiento").attr('disabled',false);
	$("#cor_institucional").attr('disabled',false);
	$("#cor_personal").attr('disabled',false);
	$("#direccion").attr('disabled',false);
	$(".modal .btn-danger").remove();
    $(".modal-footer").append("<button class='btn btn-success' onclick='validarModificarPersona()'>Guardar Datos</button>");
    $(".modal-footer").append("<button class='btn btn-danger' data-dismiss='modal' type='button'>Cerrar</button>"); 
    $("#sexo,#tip_sangre").remove();
    $("#selectSexo").append("<select name='sexo' class='form-control selectpicker' id='sexo'><option value='M'>Masculino</option><option value='F'>Femenino</option></select>");
    $("#selectsang").append('<select name="tip_sangre" id="tip_sangre" class="selectpicker" title="Tipo de Sangre"><option value="A+">A+</option><option value="A-">A-</option><option value="AB-">AB-</option><option value="AB+">AB+</option><option value="O+">O+</option><option value="O+">O-</option><option value="N/S" selected>N/S</option></select>');
    activarSelect();
    $("#btnModificar").remove();
}

function buscarListar(patron){	
	var arr = Array("m_modulo"	,	"persona",
					"m_accion"	,	"listar",
					"m_vista"	,	"recargar",
					"patron"	,	patron);

	ajaxMVC(arr,successListarAjax,errorListarAjax);
}

function successListarAjax(data){
	if(data.estatus > 0){
		recargar(data.persona);
	}
}

function errorListarAjax(data){
	console.log(data);
}
