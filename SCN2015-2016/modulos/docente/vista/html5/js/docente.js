/*Funcion que obtiene los datos de un docente seleccionado en la opcion ver docente,
donde crea un modal con la informacion personal del docente de la base de datos,
cargando con un load el formulario donde se va a ver los datos personales (VerDocente.php)*/
function obtenerDocente(codigo){
	var arr = Array("m_modulo", "docente",
	"m_accion", "buscarDocenteCodigo",
	"m_vista", "obtenerDocente",
	"codigo", codigo);
	ajaxMVC(arr,succVerDoc,errorDoc);		
}

/*Funcion que se ejecuta al ser exitoso el ajax de la funcion obtenerDocente*/
function succVerDoc(data){
	if (data.estatus>0){
		docentes=data.docente;
		$(".modal").remove();
		crearDialogo("obtenerDocente","<center>Informacion Personal<center>","<center>"+docentes[0]['nombre1']+" "+docentes[0]['apellido1']+"<center>",1,"modificar("+docentes[0]['codigo']+");","Modificar");
		$("<div class='row'><div class='col-md-12'><div id='EstudiantesF'></div></div></div>").appendTo(".modal-body");	
		$("#EstudiantesF").load("modulos/docente/vista/html5/js/VerDocente.php",function(){montarDocente(docentes);});
		$('#obtenerDocente').modal('show');
	}
	else{mostrarMensaje(data.mensaje,2);}
}

/*Funcion que se encarga de pasar los valores traido de la base de datos del docente a los id's del formulario ver docente
*/
function montarDocente(docentes){
	docentes=notNull1(docentes);
	$('#nombre1').val(docentes[0]['nombre1']);
	$('#apellido1').val(docentes[0]['apellido1']);
	$('#cedula').val(docentes[0]['cedula']);
	$('#rif').val(docentes[0]['rif']);
	$('#nom_departamento').val(docentes[0]['nom_departamento']);
	$('#telefono1').val(docentes[0]['telefono1']);
	$('#estado').val(docentes[0]['estado']);
	$('#cor_personal').val(docentes[0]['cor_personal']);
}

/*Funcion que se encarga de tomar una variable y si es null transformarla a cadena vacia,
para que en la tabla listar no se muestre el valor como "null"
*/
function notNull(variable){
	if (variable==null) {variable=" ";}
	return variable;
}

/*Funcion que se encarga de pasar los datos de un docente a la funcion notNull y que los devuelva como
cadena vacia en caso de que sean null
*/
function notNull1(docentes){
	for (var i=0; i<docentes.length; i++) {
		docentes[i]['rif']=notNull(docentes[i]['rif']);
		docentes[i]['nombre2']=notNull(docentes[i]['nombre2']);
		docentes[i]['apellido2']=notNull(docentes[i]['apellido2']);
		docentes[i]['fec_nacimiento']=notNull(docentes[i]['fec_nacimiento']);
		docentes[i]['tip_sangre']=notNull(docentes[i]['tip_sangre']);
		docentes[i]['telefono1']=notNull(docentes[i]['telefono1']);
		docentes[i]['telefono2']=notNull(docentes[i]['telefono2']);
		docentes[i]['cor_personal']=notNull(docentes[i]['cor_personal']);
		docentes[i]['cor_institucional']=notNull(docentes[i]['cor_institucional']);
		docentes[i]['direccion']=notNull(docentes[i]['direccion']);
	}
	return docentes;
}

/*Funcion que se encarga de montar el modal del formulario de agregar docente individualmente*/
function preAgregar(){
	$(".modal").remove();
	crearDialogo("preAgregarDocente","<center>Agregar Docente</center>","<center>Información del Docente</center>",1,"","");
	$("<div class='row'><div class='col-md-12'><div id='docentesA'></div></div></div>").appendTo(".modal-body");

	var arr = Array ("m_modulo", "docente",
	"m_accion", "buscarPersonas",
	"m_vista","buscarSelect");
	ajaxMVC(arr,succBuscarPersona,errorDoc);
}

function agregarDocente(){
		var arr = Array ("m_modulo", "docente",
					 "m_accion", "agregarDocente",
					 "m_vista","agregarDocente",
					 "departamentoDoc2", $("#departamentoDoc2").val()[0],
					 "numeroEmpleadoDoc2", $("#numeroEmpleadoDoc2").val()[0],
					 "estadoDoc2", $("#estadoDoc2").val()[0],
					 "selectNombre", $("#selectNombre").val()[0]);		
			ajaxMVC(arr,succAgregarD,errorDoc);
}

/*Funcion que se encarga de agregar los datos de un nuevo docente agregado a la base de datos*/
function succBuscarPersona(data){
	docentes=data.docente;
	$("#docentesA").load("modulos/docente/vista/html5/js/MontarFormularioDocente.php",function(){cargarSelect(docentes);activarSelect();});
}

function cargarSelect(docentes){
	$("#selectPersona").append('<select id="selectNombre" class="form-control selectpicker" data-live-search="true" data-size="auto" multiple data-max-options="1" title="Seleccione el Docente" onchange="actDepartamento()"></select>');
	for (var i=0; i<docentes.length; i++) {
		$("#selectNombre").append("<option value="+docentes[i]['codigo']+">"+docentes[i]['nombre1']+" "+docentes[i]['apellido1']+"</option>");
	};
}

function actDepartamento()
{
	var arr = Array ("m_modulo", "docente",
					"m_accion", "buscarDepartamentos",
					"m_vista","buscarSelect");
	ajaxMVC(arr,succBuscarDepartamentos,errorDoc);
}

function succBuscarDepartamentos(data){
	docentes=data.docente;
	$("#departamentoDoc2,#divDepartamentoDoc,#estadoDoc2,#divEstadoDoc,#divNumeroEmpleadoDoc,#numeroEmpleadoDoc2, .modal .btn-success").remove();
	$("#departamentoDoc").append('<div class="input-group" id="divDepartamentoDoc"><span class="input-group-addon">Departamento:</span><select name="departamentoDoc2" class="form-control selectpicker" id="departamentoDoc2" data-live-search="true" data-size="auto" multiple data-max-options="1" title="Seleccione Dpto" onchange="actEstado()"></select></div>');
    for (var i=0; i<docentes.length; i++) {
		$("#departamentoDoc2").append("<option value="+docentes[i]['codigo']+">"+docentes[i]['nombre']+"</option>");
     }
	activarSelect();
}

function actEstado(){
    var arr = Array ("m_modulo", "docente",
                    "m_accion", "buscarEstado",
                    "m_vista","buscarSelect");
    ajaxMVC(arr,succBuscarEstado,errorDoc); 
}

function succBuscarEstado(data){
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
    $(".modal-footer").append("<button class='btn btn-success' onclick='validarAgregarDocente()'>Guardar</button><button class='btn btn-danger' data-dismiss='modal'>Cerrar</button>");
}

function validarAgregarDocente(){
		if(validarSoloNumeros('#numeroEmpleadoDoc2',0,5,false)){agregarDocente();}
}

/*Funcion que se activa en caso de ser agregado con exito un nuevo docente
y luego se crea el ajax de recargar docente para tener la lista nueva de docentes
*/
function succAgregarD(data){
	if (data.estatus>0){
		
		$("#preAgregarDocente").modal('hide');
		mostrarMensaje(data.mensaje,1);
		var arr = Array ("m_modulo", "docente",
		"m_accion", "listar",
		"m_vista", "recargar");
		ajaxMVC(arr,succRecargar,errorDoc);
	}
	else
	{mostrarMensaje(data.mensaje,2);}
}

/*Funcion que se activa en caso de que la funcion en ajax de error
*/
function errorDoc(){mostrarMensaje("Problema con docente.",2);}

/*Funcion que se encarga de retirar docentes, cambia su estado a "Retirado"
*/
function retirar(codigo,estado){
	if (estado=='Retirado'){
		alert('Este Docente ya esta retirado');}
		else{
			if (confirm("¿Desea retirar al siguiente docente?")) {
			var arr = Array ("m_modulo", "docente",
			"m_accion", "retirar",
			"m_vista", "retirarDocente",
			"codigo", codigo);
			ajaxMVC(arr,succRetirarD,errorDoc);
		}	
		else 
		return false;	
	}	
}

/*Funcion que se activa cuando se logra con exito retirar un docente
*/
function succRetirarD(data){
	if (data.estatus>0){
		mostrarMensaje(data.mensaje,1);
		var arr = Array ("m_modulo", "docente",
		"m_accion", "listar",
		"m_vista", "recargar");
		ajaxMVC(arr,succRecargar,errorDoc);
	}
	else{mostrarMensaje(data.mensaje,2);}
}

/*Funcion que se activa cuando se logra con exito recargar la tabla de docentes traidos de la base de datos
*/
function succRecargar(data){
	if (data.estatus>0){
		docentes=data.docente;
		recargar(docentes);
	}
	else{mostrarMensaje(data.mensaje,2);}
}

/*Funcion que se encarga de montar de nuevo la tabla de docentes con los nuevos valores 
traidos de a base de datos
*/
function recargar(docentes){
	$( "#tabla2" ).remove();
	docentes=notNull1(docentes);
	cadena="";
	cadena+="<table class='table' id='tabla2'>";
	cadena+="<tr class='titulo'>";
	cadena+="<td>Número</td>";
	cadena+="<td>Cédula</td>";
	cadena+="<td>Nombre</td>";
	cadena+="<td>Departamento</td>";
	cadena+="<td>Estado</td>";
	cadena+="<td>Teléfono</td>";
	cadena+="<td>Correo Personal</td>";
	cadena+="<td colspan='1'>";
	cadena+="<button class='btn btn-success' title='Agregar Docente' onclick='preAgregar()' data-target='#preAgregarDocente' data-toggle='modal'>Agregar Docente</button>";
	cadena+="</td>";
	cadena+="<td>";
	cadena+="</td>";
	cadena+="</tr>";
	var cont=1;
	for (var i=0; i<docentes.length; i++){
		cadena+="<tr class='tr'>";
		cadena+="<td>"+cont+"</td>";
		cont++;
		cadena+="<td>"+docentes[i]['cedula']+"</td>";
		cadena+="<td>"+docentes[i]['nombre1']+" "+docentes[i]['apellido1']+"</td>";
		completo=docentes[i]['nombre1']+" "+docentes[i]['apellido1'];
		cadena+="<td>"+docentes[i]['nom_departamento']+"</td>";
		cadena+="<td>"+docentes[i]['estado']+"</td>";
		cadena+="<td>"+docentes[i]['telefono1']+"</td>";
		cadena+="<td>"+docentes[i]['cor_personal']+"</td>";
		cadena+="<td>";
		cadena+="<button class='btn btn-warning' title='Ver Docente' onclick='obtenerDocente("+docentes[i]['codigo']+")'>";
		cadena+="<i class='icon-eye-open'></i>";
		cadena+="</button>";
		cadena+="<button class='btn btn-danger' title='Retirar Docente' onclick='retirar("+docentes[i]['codigo']+");'>";
		cadena+="<i class='icon-remove'></i>";
		cadena+="</button>";
		cadena+="</td>";
		cadena+="</tr>";
	};
	cadena+="</table>";
	$(cadena).appendTo('#tablaDoc');
}	

/*Funcion que activa el boton modificar y desactiva los input, transformandolos en select 
para que pueden ser introducido los nuevos datos a modificar
*/
function activarModificar(value){
    $("#departamentoDoc,#estadoDoc,#modificar").remove();
    
    var arr = Array ("m_modulo", "docente",
                    "m_accion", "buscarDepartamentos",
                    "m_vista","buscarSelect");
    ajaxMVC(arr,buscarDepartamentoModificar,errorDoc);

    var arr = Array ("m_modulo", "docente",
                    "m_accion", "buscarEstado",
                    "m_vista","buscarSelect");
    ajaxMVC(arr,buscarEstadoModificar,errorDoc); 
}

function buscarDepartamentoModificar(data){
        docentes=data.docente;
        $("#selectDep").append('<select name="departamentoDoc2" class="form-control selectpicker" id="departamentoDoc2" data-live-search="true" data-size="auto" multiple data-max-options="1" title="Seleccione Dpto" onchange=""></select>');
        for (var i=0; i<docentes.length; i++) {
            $("#departamentoDoc2").append("<option value="+docentes[i]['codigo']+">"+docentes[i]['nombre']+"</option>");
         }
        activarSelect(); 
}

function buscarEstadoModificar(data){
        docentes=data.docente;
        $("#selectEst").append("<select name='estadoDoc2' class='form-control selectpicker' id='estadoDoc2' class='selectpicker' data-live-search='true' data-size='auto' multiple data-max-options='1' title='Seleccione Estado' onchange=''></select>");
        for (var i=0; i<docentes.length; i++) {
            $("#estadoDoc2").append("<option value="+docentes[i]['codigo']+">"+docentes[i]['nombre']+"</option>");
        }	
        activarSelect();
}


/*Funcion que se encarga de modificar los nuevos datos de un docente
*/
function modificar(codigo){ 
	if (confirm("¿Desea modificar este docente?")){
            var arr = Array ("m_modulo", "docente",
                            "m_accion", "modificar",
                            "m_vista", "modificarDocente",
                            "codigo",codigo,
                            "departamentoDoc2",$("#departamentoDoc2").val()[0],
                            "estadoDoc2",$("#estadoDoc2").val()[0]);
            ajaxMVC(arr,succModificarD,errorDoc);
	} 
	else 
	return false;
}

/*Funcion que se activa al ser exitoso la funcion modificar de docente
*/
function succModificarD(data)
{
	if (data.estatus>0)	{
        mostrarMensaje(data.mensaje,1);
        $("#obtenerDocente").modal('hide');
        var arr = Array ("m_modulo", "docente",
                        "m_accion", "listar",
                        "m_vista", "recargar");
        ajaxMVC(arr,succRecargar,errorDoc);
	}
	else{mostrarMensaje(data.mensaje,2);}
}


function buscarListar(patron){
	
	var arr = Array("m_modulo"	,	"docente",
					"m_accion"	,	"listar",
					"m_vista"	,	"recargar",
					"patron"	,	patron);
	
	ajaxMVC(arr,successListarAjax,errorListarAjax);
}

function successListarAjax(data){
	if(data.estatus > 0){
		recargar(data.docente);
	}
}

function errorListarAjax(data){
	console.log(data);
}



