/*Funcion que obtiene los datos de un estudiante seleccionado en la opcion ver estudiante,
donde crea un modal con la informacion personal del docente de la base de datos, cargando con un load
el formulario donde se va a ver los datos personales (VerEstudiante.php)*/
function obtenerEstudiante(codigo){
	var arr = Array("m_modulo", "estudiante",
	"m_accion", "buscarEstudianteCodigo",
	"m_vista", "obtenerEstudiante",
	"codigo", codigo);	
	ajaxMVC(arr,succVerEst,errorEst);					
}

/*Función que se activa al ser exitoso la funcion obtenerEstudiante*/
function succVerEst(data){
	if (data.estatus>0){
		estudiantes=data.estudiante;
		$(".modal").remove();
		crearDialogo("obtenerEstudiante","<center>Información Personal</center>","<center>"+estudiantes[0]['nombre1']+" "+estudiantes[0]['apellido1']+"</center>",1,"modificar("+estudiantes[0]['codigo']+");","Modificar");
		$("<div class='row'><div class='col-md-12'><div id='EstudiantesF'></div></div></div>").appendTo(".modal-body");	
		$("#EstudiantesF").load("modulos/estudiante/vista/html5/js/VerEstudiante.php",function(){montarEstudiante(estudiantes);});
		$('#obtenerEstudiante').modal('show');
	}
	else{mostrarMensaje(data.mensaje,2);}
}

/*Funcion que se encarga de pasar los valores de estudiante traidos de la base de datos
a los nuevos id's para montarlos en el formulario de ver estudiante*/
function montarEstudiante(estudiantes){
	$('#departamento').val(estudiantes[0]['nombre']);
	$('#pensum').val(estudiantes[0]['nom_corto']);
	$('#estado').val(estudiantes[0]['nombre_estado']);			
	$('#nombre1').val(estudiantes[0]['nombre1']);
	$('#apellido1').val(estudiantes[0]['apellido1']);
	$('#cor_personal').val(estudiantes[0]['cor_personal']);
}	

/*Función que modifica un estudiante, llamando a las funciones correspondientes
en el controlador de estudiante, pasando por parametros los nuevos datos a modificar*/
function modificar(codigo){	
	if (confirm("¿Desea modificar este estudiante?")){
		var arr = Array ("m_modulo","estudiante",
		"m_accion","modificar",
		"m_vista","modificar",
		"codigo",codigo,
		"departamento",$("#departamento").val(),
		"pensum",$("#pensum").val(),
		"estado",$("#estado").val());
		ajaxMVC(arr,succModifEst,errorModifEst);		
	}else
	return false;	
}

/*Función que se activa al ser exitoso el modificar estudiante y luego recarga la pagina para ver la
actualizacion*/
function succModifEst(data){
	if (data.estatus>0){
		mostrarMensaje(data.mensaje,1);
		$("#obtenerEstudiante").modal('hide');
		var arr = Array ("m_modulo", "estudiante",
		"m_accion", "listar",
		"m_vista", "recargar");
		ajaxMVC(arr,succRecargar,errorEst);
		}
	else{mostrarMensaje(data.mensaje,2);}
}

/*Función que se activa al haber algun error en el modificar estudiante*/
function errorModifEst(data){
	mostrarMensaje("Problema con modificar estudiante",2);
}

/*Función que se activa con un boton de modificar para poder quitar los input del ver estudiante 
y crear los select para poder esocger los nuevos datos a modificar*/
function activarmodife(value){
	$("#departamento").remove();
	$("#selectdep").append('<select id="departamento" class="selectpicker col-md-offset-3" data-toggle="dropdown" type="button"></select>');
	$("#departamento").append('<option value="2">Informática</option> <option value="1">Mecánica</option>');
	$("#estado").remove();
	$("#selectest").append('<select id="estado" class="selectpicker col-md-offset-2" data-toggle="dropdown" type="button"></select>');
	$("#estado").append('<option value="A">Activo</option> <option value="R">Retirado</option> <option value="C">Congelado</option> <option value="G">Graduado</option>');
	$("#pensum").remove();
	$("#selectpen").append('<select id="pensum" class="selectpicker col-md-offset-2" data-toggle="dropdown" type="button"></select>');
	$("#pensum").append('<option value="1">PNFI</option> <option value="2">PNFA</option>');
	$("#modificar").remove();
}



/*Funcion que agrega los estudiantes pasando los tres parametros necesarios 
(codigo de departamento, codigo de pensum y codigo de estado)*/
function agregarEstudiante(){
	var arr = Array ("m_modulo", "estudiante",
					"m_accion","agregarEstudiante",
					"m_vista","agregarEstudiante",
					"departamentoEst2",$("#departamentoEst2").val()[0],
					"estadoEst2",$("#estadoEst2").val()[0],	
					"selectNombre", $("#selectNombre").val()[0]											 
	);	
	ajaxMVC(arr,succAgregarE,errorEst);
}

/*Funcion que se activa cuando es exitosa la funcion de agregarEstudiante*/
function succAgregarE(data){
	if (data.estatus>0){		
		$("#preAgregar").modal('hide');
		mostrarMensaje(data.mensaje,1);
		var arr = Array ("m_modulo", "estudiante",
						 "m_accion", "listar",
						 "m_vista", "recargar");
		ajaxMVC(arr,succRecargar,errorEst);
	}
	else
	{mostrarMensaje(data.mensaje,2);}
}

/*Funcion que se activa cuando los ajax dan error*/
function errorEst(){mostrarMensaje("Problema con estudiante.",2);}

/*Funcion que monta un modal con la informacion adentro de un formulario (MontarEstudiante.php)
 con un load para poder pedir todos los datos necesarios para agregar un nuevo estudiante*/
function administrarEstudiante(){
	$(".modal").remove();
	crearDialogo("preAgregar","<center>Agregar Estudiante</center>","<center>Información</center>",1,'', '',true);
	$("<div class='row'><div class='col-md-12'><div id='estudianteA'></div></div></div>").appendTo(".modal-body");
	
	var arr = Array ("m_modulo", "estudiante",
					"m_accion", "buscarPersonas",
					"m_vista","buscarSelect");
	ajaxMVC(arr,succBuscarPersona,errorEst);
}

function succBuscarPersona(data){
	estudiantes=data.estudiante;
	$("#estudianteA").load("modulos/estudiante/vista/html5/js/MontarEstudiante.php",function(){cargarSelect(estudiantes);activarSelect();});
}

function cargarSelect(estudiantes){
	$("#selectPersona").append('<select id="selectNombre" class="selectpicker" data-live-search="true" data-size="auto" multiple data-max-options="1" title="Seleccione Estudiante" onchange="actDepartamento();"></select>');
	for (var i=0; i<estudiantes.length; i++) {
		$("#selectNombre").append("<option value="+estudiantes[i]['codigo']+">"+estudiantes[i]['nombre1']+" "+estudiantes[i]['apellido1']+"</option>");
	};
	activarSelect();
	$('#preAgregar').modal('show');
}

function actDepartamento(){
	var arr = Array ("m_modulo", "estudiante",
					"m_accion", "buscarDepartamentos",
					"m_vista","buscarSelect");
	ajaxMVC(arr,succBuscarDepartamentos,errorEst);
}

function succBuscarDepartamentos(data){
	estudiantes=data.estudiante;
	$("#departamentoEst2,#divDepartamentoEst,#divEstadoEst,#estadoEst2,.modal .btn-success").remove();
	$("#departamentoEst").append('<div class="input-group" id="divDepartamentoEst"><span class="input-group-addon">Departamento:</span><select name="departamentoEst2" class="form-control selectpicker" id="departamentoEst2" data-live-search="true" data-size="auto" multiple data-max-options="1" title="Seleccione Dpto" onchange="actEstado()"></select></div></div>');
	for (var i=0; i<estudiantes.length; i++) {
		$("#departamentoEst2").append("<option value="+estudiantes[i]['codigo']+">"+estudiantes[i]['nombre']+"</option>");
	}
	activarSelect();
}

function actEstado()
{
    var arr = Array ("m_modulo", "estudiante",
                    "m_accion", "buscarEstado",
                    "m_vista","buscarSelect");
    ajaxMVC(arr,succBuscarEstado,errorEst);    
}

function succBuscarEstado(data){
	estudiantes=data.estudiante;
    $("#divEstadoEst,#estadoEst2,.modal .btn-success").remove();
    $("#estadoEst").append("<div class='input-group' id='divEstadoEst'><span class='input-group-addon'>Estado:</span><select name='estadoEst2' class='form-control selectpicker' id='estadoEst2' class='selectpicker' data-live-search='true' data-size='auto' multiple data-max-options='1' title='Seleccione el Estado' onchange='actGuardar()'></select></div>");
	for (var i=0; i<estudiantes.length; i++) {
		$("#estadoEst2").append("<option value="+estudiantes[i]['codigo']+">"+estudiantes[i]['nombre']+"</option>");
	}	
    activarSelect();
}

function actGuardar()
{
    $(".modal .btn-danger").remove();
    $(".modal-footer").append("<button class='btn btn-success' onclick='agregarEstudiante()'>Guardar</button><button class='btn btn-danger'data-dismiss='modal'>Cerrar</button>");
}

/*Funcion que retira a un estudiante por su codigo unico*/
function retirar(codigo){
	if (confirm("¿Desea retirar al siguiente estudiante?")) {
		var arr = Array ("m_modulo", "estudiante",
		"m_accion", "retirar",
		"m_vista", "retirarEstudiante",
		"codigo", codigo);
		ajaxMVC(arr,succRetirarE,errorEst);
	}	
	else 
	return false;		
}

/*Funcion que se activa cuando se retira con exito un estudiante y luego recarga la pagina
para ver el nuevo listar de estudiante*/
function succRetirarE(data){
	if (data.estatus>0){
		mostrarMensaje(data.mensaje,1);
		var arr = Array ("m_modulo", "estudiante",
		"m_accion", "listar",
		"m_vista", "recargar");
		ajaxMVC(arr,succRecargar,errorEst);
	}
	else{mostrarMensaje(data.mensaje,2);}
}

/*Funcion que se activa cuando se logra recargar con exito la tabla estudiante con sus nuevos datos*/
function succRecargar(data){
	if (data.estatus>0){
		estudiantes=data.estudiante;
		recargar(estudiantes);
	}else{
	mostrarMensaje(data.mensaje,2);
	}
}

/*Funcion que se encarga de recargar la tabla estudiante
se le hace un remove de la tabla vieja y luego de hace el appendTo a la tabla con los nuevos datos*/
function recargar(estudiantes){
	$( "#tabla2" ).remove();
	estudiantes=notNull1(estudiantes);
	cadena="";
	cadena+="<table class='table' id='tabla2'>",
	cadena+="<tr class='titulo'>";
	cadena+="<td>Número</td>";
	cadena+="<td>Cédula</td>";
	cadena+="<td>Nombre</td>";
	cadena+="<td>Departamento</td>";
	cadena+="<td>Pensum</td>";
	cadena+="<td>Estado</td>";
	cadena+="<td>Correo Personal</td>";
	cadena+="<td>";
	cadena+="<button class='btn btn-success' title='Agregar Estudiante' onclick='administrarEstudiante()'' data-target='#preagregarest' data-toggle='modal'>";
	cadena+="Agregar Estudiante</button>";	
	cadena+="</td>";
	cadena+="</td>";
	cadena+="<td></td>";
	cadena+="</tr>";
	var cont=1;
	for (var i=0; i<estudiantes.length; i++){
		cadena+="<tr class='tr'>";
		cadena+="<td>"+cont+"</td>";
		cont++;
		cadena+="<td>"+estudiantes[i]['cedula']+"</td>";			
		cadena+="<td>"+estudiantes[i]['nombre1']+" "+estudiantes[i]['apellido1']+"</td>";
		completo=estudiantes[i]['nombre1']+" "+estudiantes[i]['apellido1'];
		cadena+="<td>"+estudiantes[i]['nombre']+"</td>";
		cadena+="<td>"+estudiantes[i]['nom_corto']+"</td>";
		cadena+="<td>"+estudiantes[i]['nombre_estado']+"</td>";
		cadena+="<td>"+estudiantes[i]['cor_personal']+"</td>";
		cadena+="<td>";
		cadena+="<button class='btn btn-warning' title='Ver Docente' onclick='obtenerEstudiante("+estudiantes[i]['codigo']+")'>";
		cadena+="<i class='icon-eye-open'></i>";
		cadena+="</button>";
		cadena+="<button class='btn btn-danger' title='Retirar Estudiante' onclick='retirar("+estudiantes[i]['codigo']+");'>";
		cadena+="<i class='icon-remove'></i>";
		cadena+="</button>";
		cadena+="</td>";
		cadena+="</tr>";
	}
	cadena+="</table>";
	$(cadena).appendTo('#tablaEst');
}	

/*Funcion que se encarga de tomar una variable y si es null transformarla a cadena vacia,
para que en la tabla listar no se muestre el valor como "null"*/
function notNull(variable){
	if (variable==null) {variable=" ";}
	return variable;
}

/*Funcion que se encarga de pasar los datos de un estudiante a la funcion notNull y que los devuelva como
cadena vacia en caso de que sean null*/
function notNull1(estudiantes){
	for (var i=0; i<estudiantes.length; i++){
		estudiantes[i]['rif']=notNull(estudiantes[i]['rif']);
		estudiantes[i]['nombre2']=notNull(estudiantes[i]['nombre2']);
		estudiantes[i]['apellido2']=notNull(estudiantes[i]['apellido2']);
		estudiantes[i]['fec_nacimiento']=notNull(estudiantes[i]['fec_nacimiento']);
		estudiantes[i]['tip_sangre']=notNull(estudiantes[i]['tip_sangre']);
		estudiantes[i]['telefono1']=notNull(estudiantes[i]['telefono1']);
		estudiantes[i]['telefono2']=notNull(estudiantes[i]['telefono2']);
		estudiantes[i]['cor_personal']=notNull(estudiantes[i]['cor_personal']);
		estudiantes[i]['cor_institucional']=notNull(estudiantes[i]['cor_institucional']);
		estudiantes[i]['direccion']=notNull(estudiantes[i]['direccion']);
	}
	return estudiantes;
}


function buscarListar(patron){
	
	var arr = Array("m_modulo"	,	"estudiante",
					"m_accion"	,	"listar",
					"m_vista"	,	"recargar",
					"patron"	,	patron);
	
	ajaxMVC(arr,successListarAjax,errorListarAjax);
}

function successListarAjax(data){
	if(data.estatus > 0){
		recargar(data.estudiante);
	}
}

function errorListarAjax(data){
	console.log(data);
}
