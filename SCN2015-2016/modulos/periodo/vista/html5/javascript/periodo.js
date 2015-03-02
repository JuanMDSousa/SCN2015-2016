$(document).ready(function(){construirSelects()});

function construirSelects(){
	if($('#hiddInst').val() != ''){
		construirInstituto();
	}
	else{
		if($('#hiddDep').val() == ''){
			construirDepartamento($('#hiddInst').val());
		}
		else{
			construirPensum($('#hiddInst').val());
		}
	}	
	construirEstado();	
}

function construirInstituto(){
	var arr = Array("m_modulo"	,	"instituto",
					"m_accion"	,	"listar");
					
	ajaxMVC(arr,succInst,error);
}

function succInst(data){
	if(data.estatus > 0){
		montarInstitutos(data.institutos);
	}
	else{
		$('#instituto').selectpicker('destroy');
		mostrarMensaje(data.mensaje,4);
	}
}

function montarInstitutos(institutos){
	if(institutos != null){
		 cadena = "<select class='selectpicker' id='instituto' data-live-search='true' data-size='auto' multiple data-max-options='1' title='Institutos' onchange='construirDepartamento()'>";
		 
		 for(var i = 0; i < institutos.length; i++){
			 cadena += "<option value='"+institutos[i]['codigo']+"'>"+institutos[i]['nombre']+"</option>";
		 }
		 
		 cadena += "</select>";
		
		$(cadena).appendTo("#inst");
		activarSelect();
	}
	else
		mostrarMensaje("No hay institutos en el sistema",4);
}

function construirDepartamento(){
	$('#departamento').selectpicker('destroy');
	$('#pensum').selectpicker('destroy');
	
	var arr = Array("m_modulo"	,	"departamento",
					"m_accion"	,	"listarPI",
					"codInstituto"	,	$("#instituto").val()[0]);
	
	ajaxMVC(arr, succDep, error);
}

function succDep(data){
	if(data.estatus > 0)
		montarDepartamentos(data.departamentos);
	else{
		$('#departamento').selectpicker('destroy');
		mostrarMensaje(data.mensaje,4);
	}
}

function montarDepartamentos(departamentos){
	$('#departamento').remove();
	if(departamentos != null){
		cadena = "<select class='selectpicker' id='departamento' data-live-search='true' data-size='auto' multiple data-max-options='1' title='Departamentos' onchange='construirPensum()'>";
		
		for(var i = 0; i < departamentos.length; i++){
		 cadena += "<option value='"+departamentos[i]['codigo']+"'>"+departamentos[i]['nombre']+"</option>";
		}
		 
		cadena += "</select>";	 
		$(cadena).appendTo("#dep");
		activarSelect();
	}
	else
		mostrarMensaje("No hay departamentos asociados a este instituto",4);
}

function construirPensum(){
	$('#pensum').selectpicker('destroy');
	var arr = Array("m_modulo"			,	"pensum",
					"m_accion"			,	"listarPorDepartamento",
					"codDepartamento"	,	$("#departamento").val()[0]);
	
	ajaxMVC(arr, succPen, error);
}

function listarPensums(){
	var arr = Array("m_modulo"			,	"pensum",
					"m_accion"			,	"listar");
	
	ajaxMVC(arr, succPen, error);
}

function succPen(data){
	if(data.estatus > 0){
		if(data.pensums != null)
			montarPensums(data.pensums);
		else
			montarPensums(data.pensum);
	}
	else{
		if(confirm("No hay pensums asociados a este departamento, ¿Desea agregar un periodo a este departamento?")){
			dialogoAgregar($("#instituto").val()[0],$("#departamento").val()[0],'','',true);
			
		}
	}
}

function montarPensums(pensums){
	if(pensums != null){
		if($(".modal-body").length != 0)
			cadena = "<select class='selectpicker' id='pensuma' data-live-search='true' data-size='auto' multiple data-max-options='1' title='Pensums'>";
		else
			cadena = "<select class='selectpicker' id='pensum' data-live-search='true' data-size='auto' multiple data-max-options='1' title='Pensums'>";
		for(var i = 0; i < pensums.length; i++)
		 cadena += "<option value='"+pensums[i]['codigo']+"'>"+pensums[i]['nombre']+"</option>";
		 
		cadena += "</select>";	 
		
		if($(".modal-body").length != 0)
			$(cadena).appendTo(".modal-body #pen");
		else
			$(cadena).appendTo("#pen");
		activarSelect();
	}
	else{
		mostrarMensaje("No hay pensums asociados a este departamento",4);
		dialogoAgregar($("#instituto").val()[0],$("#departamento").val()[0],'','',true);
	}
}

function construirEstado(){
	var arr = Array("m_modulo"	,	"periodo",
					"m_accion"	,	"obtenerEstado");
	
	ajaxMVC(arr, succEstado, error);
}

function succEstado(data){
	if(data.estatus > 0){
		montarEstado(data.estados);
	}
	else
		mostrarMensaje(data.mensaje,4);
}

function montarEstado(estados){
	if(estados != null){
		if($(".modal-body").length != 0)
			cadena = "<select class='selectpicker' id='estadoa' data-live-search='true' data-size='auto' multiple data-max-options='1' title='Estado del Periodo'>";
		else
			cadena = "<select class='selectpicker' id='estado' data-live-search='true' data-size='auto' multiple data-max-options='1' title='Estado del Periodo'>";
		for(var i = 0; i < estados.length; i++)
		 cadena += "<option value='"+estados[i]['codigo']+"'>"+estados[i]['nombre']+"</option>";
		 
		cadena += "</select>";
		if($(".modal-body").length != 0) 
			$(cadena).appendTo(".modal-body #est");
		else
			$(cadena).appendTo("#est");
		activarSelect();
	}
	else
		mostrarMensaje("No hay estados.",4);
}


function listar(){
	
	var inst = '';
	var est = '';
	var dep = '';
	var pen = '';
	
	if($('#instituto').val() != null)
		inst = $('#instituto').val()[0];
	
	if($('#estado').val() != null)
		est = $('#estado').val()[0];
		
	if($('#departamento').val() != null)
		dep = $('#departamento').val()[0];
		
	if($('#pensum').val() != null)
		pen = $('#pensum').val()[0];
	
	var arr = Array("m_modulo"		,		"periodo",
					"m_accion"		,		"listar",
					"m_vista"		,		"Listar",
					"instituto"		,		inst,
					"estado"		,		est,
					"departamento"	,		dep,
					"pensum"		,		pen);

	
	ajaxMVC(arr,succListar,error);
}

function succListar(data){
	if(data.estatus > 0){
		montarListar(data.periodos);
	}
	else{
		$('#tablaPeriodos').remove();
		mostrarMensaje(data.mensaje,4);
	}
}

function montarListar(periodos){
	if(periodos != null){
		$('#tablaPeriodos').remove();
		
		cadena = "<table id='tablaPeriodos' class='table'>";
		
		var inst = '';
		var dep = '';
		var codigoinst;
		var codigodep;
		
		for(var i = 0; i < periodos.length; i++){
			if(inst != periodos[i]['nombreinst']){
				inst = periodos[i]['nombreinst'];
				codigoinst = periodos[i]['codinst'];
				cadena += "<tr class='titulo'>";
				cadena += "<td colspan='7'>"+periodos[i]['nombreinst']+"</td>";
				cadena += "</tr>";
				
			}
			
			if(dep != periodos[i]['nombredep']){
				dep = periodos[i]['nombredep'];
				codigodep = periodos[i]['cod_departamento'];
				cadena += "<tr class='titulo'>";
				cadena += "<td colspan='6' style='text-align:left'>&nbsp;&nbsp;Departamento: "+periodos[i]['nombredep']+"</td>";
				cadena += "<td > <button class='btn btn-success' style='height:33px' onclick='dialogoAgregar(\""+codigoinst+"\",\""+codigodep+"\",\""+inst+"\",\""+dep+"\",true)'>Agregar Periodo </button> </td>";
				cadena += "</tr>";
				
				cadena += "<tr class='active'>";
				
				cadena += "<td>Nombre del Periodo</td>";
				
				cadena += "<td>Fecha de Inicio</td>";
				
				cadena += "<td>Fecha Final</td>";
				
				cadena += "<td>Estado</td>";
				
				cadena += "<td>Observaciones</td>";
				
				cadena += "<td>Pensum</td>";
				
				cadena += "<td></td>";
				
				cadena += "</tr>";
			}
			
			cadena += "<tr>";
			
			cadena += "<td> "+periodos[i]['nombre']+" </td>";
			
			cadena += "<td> "+periodos[i]['fec_inicio']+" </td>";
			
			cadena += "<td> "+periodos[i]['fec_final']+" </td>";
			
			cadena += "<td> "+periodos[i]['nombreestado']+" </td>";
			
			cadena += "<td> "+periodos[i]['observaciones']+" </td>";
			
			cadena += "<td> "+periodos[i]['nombrepensum']+" </td>";
			
			cadena += "<td> <button class='btn btn-primary' title='Modificar Periodo' onclick='obtener(\""+periodos[i]['codigo']+"\")'><i class='icon-pencil'></i></button> </td>";
			
			cadena += "</tr>";
			
		}
		
		cadena += "</table>";
		
		$(cadena).appendTo("#listaPeriodos");
	}
	else{
		$('#tablaPeriodos').remove();
		mostrarMensaje("No hay periodos con esos criterios",4);
	}
}



function dialogoAgregar(codInst, codDep, inst, dep, open){
	if(open)
		crearDialogo("agregarPeriodo","Administrar Periodo",inst+" Departamento: "+dep,1,"agregarPeriodo("+codDep+")");
	
	cadena = "<div class='row'>";
	
	cadena += "<div class='col-md-12'><div class='input-group'><span class='input-group-addon'>Nombre del Periodo</span><input type='text' class='form-control' onkeyup='validarRangos(\"#nombre\",4,10,true)' id='nombre' placeholder='Nombre del Periodo'></div></div><br>";
	cadena += "<div class='col-md-12'><div class='input-group'><span class='input-group-addon'>Fecha de Inicio</span><input type='text' class='form-control fecha hasDatePicker' onkeyup='validarRangos(\"#fecinicio\",4,10,true)' onfocus='activarFecha(\"#fecinicio\")' id='fecinicio' placeholder='Fecha de Inicio'></div></div><br>";
	cadena += "<div class='col-md-12'><div class='input-group'><span class='input-group-addon'>Fecha de Fin</span><input type='text' class='form-control fecha hasDatePicker' onkeyup='validarFecha(\"#fecfinal\",4,10,true)' onfocus='activarFecha(\"#fecfinal\")' id='fecfinal' placeholder='Fecha de Fin '></div></div><br>";
	cadena += "<div class='col-md-12'><div class='input-group'><span class='input-group-addon'>Observaciones</span><input type='text' class='form-control' onkeyup='validarRangos(\"#observaciones\",4,30,false)' id='observaciones' placeholder='Observaciones'></div></div><br>";
	cadena += "<div class='col-md-6'><div id='est'></div></div>";
	cadena += "<div class='col-md-6'><div id='pen'></div></div>";
	cadena += "</div>";
	
	$(".modal-body").append(cadena);
	
	construirEstado();
	listarPensums();
	
	activarSelect();
	if(open)
		$("#agregarPeriodo").modal("show");
}

function agregarPeriodo(dep){
	var arr = Array("m_modulo"		,	"periodo",
					"m_accion"		,	"agregar",
					"codPensum"		,	$("#pensuma").val()[0],
					"codDepartamento",	dep,
					"nombre"		,	$("#nombre").val(),
					"fecinicio"		,	$("#fecinicio").val(),
					"fecfinal"		,	$("#fecfinal").val(),
					"observaciones"	,	$("#observaciones").val(),
					"codEstado"		,	$("#estadoa").val()[0]);
	
	ajaxMVC(arr, succAgregar, error);
}

function succAgregar(data){
	if(data.estatus > 0){
		mostrarMensaje("Periodo: "+data.nombre+" agregado con éxito",1);
		$('#agregarPeriodo').modal('hide');
		$('.modal-body').remove();
		listar();
	}
	else{
		mostrarMensaje(data.mensaje,4);
	}
}

function obtener(codigo){
	var arr = Array("m_modulo"	,	"periodo",
					"m_accion"	,	"listar",
					"codigo"	,	codigo);
					
	ajaxMVC(arr, succObtener, error);
}

function succObtener(data){
	if(data.estatus > 0){
		montarInfo(data.periodos);
	}
	else{
		mostrarMensaje(data.menasje,4);
	}
}

function montarInfo(periodos){
	if(periodos != null){
		crearDialogo("agregarPeriodo","Administrar Periodo",periodos[0]['nombreinst']+" Departamento: "+periodos[0]['nombredep'],1,"modificarPeriodo()");
		
		dialogoAgregar("","","","",false);
		alert("Alamo, ayudame");
		
		$("<input type='hidden' id='codigohidd' value='"+periodos[0]['codigo']+"' >").appendTo(".modal-body");
		$("<input type='hidden' id='dephidd' value='"+periodos[0]['cod_departamento']+"' >").appendTo(".modal-body");
		
		$("#nombre").val(periodos[0]['nombre']);
		$("#fecinicio").val(periodos[0]['fec_inicio']);
		$("#fecfinal").val(periodos[0]['fec_final']);
		$("#observaciones").val(periodos[0]['observaciones']);
		$("#nombre").val(periodos[0]['nombre']);
		
		$("#agregarPeriodo").modal("show");
		
		$("#pensuma").selectpicker('val',periodos[0]['cod_pensum']);
		$("#estadoa").selectpicker('val',periodos[0]['cod_estado']);
	}
}

function modificarPeriodo(){
	var arr = Array("m_modulo"	,	"periodo",
					"m_accion"	,	"modificar",
					"codigo"	,	$('#codigohidd').val(),
					"nombre"	,	$('#nombre').val(),
					"fecinicio"	,	$('#fecinicio').val(),
					"fecfinal"	,	$('#fecfinal').val(),
					"observaciones"	,	$('#observaciones').val(),
					"codPensum"	,	$('#pensuma').val()[0],
					"codEstado"	,	$('#estadoa').val()[0],
					"codDepartamento"	,	$('#dephidd').val()[0]);
					
	ajaxMVC(arr, succModificar, error);
					
}

function succModificar(data){
	if(data.estatus > 0){
		mostrarMensaje("Periodo: "+data.nombre+" modificado con éxito",1);
		$('#agregarPeriodo').modal('hide');
		$('.modal-body').remove();
		listar();
	}
	else{
		mostrarMensaje(data.mensaje,4);
	}
}

function error(data){
	mostrarMensaje("Error de comunicación con el servidor",2);
}


