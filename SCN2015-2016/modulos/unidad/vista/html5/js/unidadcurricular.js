function preAgregarUnidadCurricular(codTray,numTrayecto,codPensum){
	$("#modalAgregarUnidadCurricular .modal-body").remove();
	$("#verUnidadCurricular .modal-body").remove();
	crearDialogo("modalAgregarUnidadCurricular","<center><h3>Agregar Unidad Curricular</h3></center>","<center></center>",1,"validarAgregarUnidadCurricular()","Agregar");
	$("#modalAgregarUnidadCurricular .modal-body").load("modulos/pensum/vista/html5/js/formularioUnidadCurricular.php",function(){buscarTipoUnidadCurricular(codTray);buscarPrelacion(numTrayecto,codPensum);});
	$("#modalAgregarUnidadCurricular").modal("show");
}

function buscarPrelacion(numTrayecto,codPensum){
	if(numTrayecto>0){
		numTrayecto=numTrayecto-1;
		var arr = Array("m_modulo","unidad",
						"m_accion","listarPrelacion",
						"numtray",numTrayecto,
						"codigo",codPensum);
		ajaxMVC(arr,cargarUnidadCurricular,errorListarPrelacion);		
	}
}

function errorListarPrelacion(){mostrarMensaje("No pueden cargar las unidades para relacionar en este momento",2);}

function cargarUnidadCurricular(data){
	unidadCurricular=data.pensum;
	if (unidadCurricular!=null){
		$("#divCheckUC").hide();
		$("#tituloUnidadCurricular").append("<center><label class='checkbox-inline'><input type='checkbox' name='checkUnidadCurricular' id='checkUnidadCurricular' onchange='checkUC()'>Materias requeridas para cursar esta Unidad Curricular:</label></center><br><br>");
		for (var i=0;i<unidadCurricular.length;i++){
			$("#divCheckUC").append("<input type='checkbox' id='check"+i+"' value="+unidadCurricular[i]['codigo']+">"+unidadCurricular[i]['nombre']+"<br>");
		}	
		$("#numArrUC").val(i);
	}
}

function buscarTipoUnidadCurricular(codTray){
	$("#codTray").val(codTray);
	var arr =Array("m_modulo","unidad",
					"m_accion","buscarCodigoUnidadCurricular");
    ajaxMVC(arr,montarTipoUnidadCurricular,errorListarAjax);    
}

function montarTipoUnidadCurricular(data){	
	tipoUnidadCurricular=data.pensum;
	$("#selectTipoUnidad").append("<div class='input-group'><span class='input-group-addon'>Tipo de Unidad Curricular:</span><select class='form-control selectpicker' id='tipoUnidadCurricular' class='selectpicker' data-live-search='true'></select></div>");
	for (var i=0;i<tipoUnidadCurricular.length;i++){
		$("#tipoUnidadCurricular").append("<option value="+tipoUnidadCurricular[i]['codigo']+">"+tipoUnidadCurricular[i]['nombre']+"</option>");
	}
	activarSelect();
}

function checkUC(){
	if($('#checkUnidadCurricular').is(':checked')){
		$("#divCheckUC").show();
	}else{$("#divCheckUC").hide();}
}

function validarAgregarUnidadCurricular(){
	if(validarRangos('#nombreUC',2,100,true)&&
		validarRangos('#codMinisterio',2,30,true)&&
		validarSoloNumeros('#hti',1,2,true)&&
		validarSoloNumeros('#hta',1,2,true)&&
		validarSoloNumeros('#unidadesCredito',1,2,true)&&
		validarSoloNumeros('#duracionSemanas',1,3,true)&&
		validarSoloNumeros('#notaMinima',1,2,true)&&
		validarSoloNumeros('#notaMaxima',1,2,true)&&
		validarMayorMenor('#notaMaxima','#notaMinima'))
	{	
		agregarUnidadCurricular();}
}

function validarMayorMenor(mayor, menor){
	$(".popover").hide();	
	if($(mayor).val() <= $(menor).val()){
		detonarAdvertencia(menor,"La nota minima no puede ser mayor a la nota maxima");
		return false;
	}
	return true;
}

function agregarUnidadCurricular(){
	var arr = Array("m_modulo","unidad",
					"m_accion","agregarUnidadCurricular",					
					"nombreUC",$("#nombreUC").val(),
					"codMinisterio",$("#codMinisterio").val(),
					"codTrayecto",$("#codTray").val(),
					"tipoUnidadCurricular",$("#tipoUnidadCurricular").val()[0],
					"hta",$("#hta").val(),
					"hti",$("#hti").val(),
					"unidadesCredito",$("#unidadesCredito").val(),
					"duracionSemanas",$("#duracionSemanas").val(),
					"notaMinima",$("#notaMinima").val(),
					"notaMaxima",$("#notaMaxima").val());
	ajaxMVC(arr,succAgregarUC,errorAgregarUC);
}

function succAgregarUC(data){
	var arrUC = new Array();
	if($("#numArrUC").val()!=0 && $("#numArrUC").val()!=null){
		for (var i=0;i<$("#numArrUC").val();i++){
			if($("#check"+i).is(":checked")){
				arrUC[i]=$("#check"+i).val();
				var arr = Array("m_modulo","unidad",
						"m_accion","agregarPrelacion",
						"unidadCurricularPrelada",arrUC[i]);
				ajaxMVC(arr,succAgregarPrelacion,errorAgregarPrelacion);
			}
		}
	}
	$("#modalAgregarUnidadCurricular").modal('hide');
	mostrarMensaje("Unidad Curricular agregada con exito",1);
	recargarUnidadCurricular();
}
function errorAgregarUC(){mostrarMensaje("No pueden existir 2 unidades curriculares con el mismo nombre o codigo",2);}

function errorAgregarPrelacion(){mostrarMensaje("No se pudo agregar las materias necesarias para la unidad curricular",2);}

function succAgregarPrelacion(data){}

function recargarUnidadCurricular(){
	var arr = Array("m_modulo", "pensum",
					"m_accion", "buscarTrayPen",
					"codigo", $("#inputPen").val());
	ajaxMVC(arr,succRecargarUnidadCurricular,errorRecargarUnidadCurricular);	
}

function succRecargarUnidadCurricular(data){
	if (data.estatus>0){	
		pensums=data.pensum;						
		$("#infoPensum .modal").remove();									
		crearDialogo("infoPensum2","<center>"+pensums['nombre']+"</center>","<center>Nombre Abreviado del Pensum: "+pensums['nombreCorto']+"<center>","","","");
		$("<div class='row'><div class='col-md-12'><div id='pensumV'></div></div></div>").appendTo("#infoPensum2 .modal-body");
		$("#pensumV").load("modulos/pensum/vista/html5/js/InformacionP.php",function(){infoTrayRecargar(pensums);});	
		$("#infoPensum").modal("show");		
	}
}

function errorRecargarUnidadCurricular(){mostrarMensaje("No se puede recargar el listado por el momento",2);}

function eliminarUnidadCurricular(codigo){	
	if (confirm("¿Desea eliminar la siguiente unidad curricular?")){
		var arr = Array ("m_modulo","unidad",
						 "m_accion","eliminarUnidadCurricular",
						 "codigo", codigo);			
		ajaxMVC(arr,succEliminarUC,errorEliminarUC);			
	}
	else
	return false;
}
function succEliminarUC(data){	
	if (data.estatus>0){
		mostrarMensaje("Unidad curricular eliminada con exito",1);
		$("#VentanaFormularioTrayecto").modal('hide'); 
		recargarUnidadCurricular();		
	}
}

function errorEliminarUC(){mostrarMensaje("No se puede eliminar unidades curricular que estan siendo usadas en el sistema",2);}

function eliminarUnidadesPorTrayecto(codigotrayecto){
	if (confirm("¿Para eliminar el siguiente trayecto debe eliminar todas las unidades curriculares de este,¿Está seguro?")){
			var arr = Array ("m_modulo","pensum",
							 "m_accion","eliminarUnidadesPorTrayecto",
							 "codigo", codigotrayecto);			
			ajaxMVC(arr,succEliminarUnidadesPorTrayecto,errorEliminarUnidadesPorTrayecto);
		}
	else
	return false;	
}

function succEliminarUnidadesPorTrayecto(){mostrarMensaje("unidades Curricular Eliminadas",1);}

function errorEliminarUnidadesPorTrayecto(){mostrarMensaje("No se puede eliminar unidades curricular que estan siendo usadas en el sistema",2);}

function verUnidadCurricular(codigo,numTrayecto,codPensum,codTray){
	$("#modalAgregarUnidadCurricular .modal-body").remove();
	$("#verUnidadCurricular .modal-body").remove();
	crearDialogo("verUnidadCurricular","<center><h2>Unidad Curricular</h2></center>","",1,"validarmodificarUnidadCurricular()","Modificar");		
	$("#verUnidadCurricular .modal-body").load("modulos/pensum/vista/html5/js/formularioUnidadCurricular.php",function(){ajaxVerUnidadCurricular(codigo);buscarCheckUnidadCurricular(numTrayecto,codPensum,codigo);$('#verUnidadCurricular').modal('show');});
}

function ajaxVerUnidadCurricular(codigo){
	var arr = Array ("m_modulo","unidad",
		 			 "m_accion","verUnidadCurricular",
		 			 "codigo",codigo);
	ajaxMVC(arr,montarUnidadCurricular,errorVerUnidadCurricular);
}

function errorVerUnidadCurricular(data){mostrarMensaje("No se puede ver la unidad curricular en este momento",2);}

function montarUnidadCurricular(data){
	if (data.estatus>0){
		pensums=data.pensum;
		$("#selectTipoUnidad").append("<span class='input-group-addon' id='tituloinput'>Tipo de Unidad Curricular:</span><input type='text' id='tipoUnidadCurricular' class='form-control' value=''>");
		$("#botonModificarUnidadCurricular").append("<center><button id='botonModif' class='btn btn-warning' onclick='preModificarUnidadCurricular()'>Modificar Unidad Curricular</button></center>");
		$("#nombreUC,#codMinisterio,#tipoUnidadCurricular,#hta,#hti,#unidadesCredito,#duracionSemanas,#notaMinima,#notaMaxima").attr('disabled',true);
		$("#codUni").val(pensums[0]['cod_unidad']);
		$("#codTray").val(pensums[0]['cod_trayecto']);
		$("#nombreUC").val(pensums[0]['nombre_unidad']);
		$("#codMinisterio").val(pensums[0]['cod_uni_ministerio']);
		$("#tipoUnidadCurricular").val(pensums[0]['nombre_tipo']);
		$("#hta").val(pensums[0]['hta']);
		$("#hti").val(pensums[0]['hti']);
		$("#unidadesCredito").val(pensums[0]['uni_credito']);
		$("#duracionSemanas").val(pensums[0]['dur_semanas']);
		$("#notaMinima").val(pensums[0]['not_min_aprobatoria']);
		$("#notaMaxima").val(pensums[0]['not_maxima']);
		$("#tituloUnidadCurricular").hide();
		$("#divCheckUC").hide();
	}
}

function buscarCheckUnidadCurricular(numTrayecto,codPensum,codigo){
	if(numTrayecto>0){
		numTrayecto=numTrayecto-1;
		var arr = Array("m_modulo","unidad",
						"m_accion","listarPrelacion",
						"numtray",numTrayecto,
						"codigo",codPensum);
		ajaxMVC(arr,cargarCheckModificarUnidadCurricular,errorCargarCheckUnidadCurricular);
	}
}

function errorCargarCheckUnidadCurricular(){mostrarMensaje("No se pueden cargar unidades para relacionar en este momento",2);}

function cargarCheckModificarUnidadCurricular(data){
	unidadCurricular=data.pensum;
	if (unidadCurricular!=null){
		$("#divCheckUC").hide();
		$("#tituloUnidadCurricular").append("<center><label class='checkbox-inline'><input type='checkbox' name='checkUnidadCurricular' id='checkUnidadCurricular' onchange='checkUC()'>Materias requeridas para cursar esta Unidad Curricular:</label></center><br><br>");
		for (var i=0;i<unidadCurricular.length;i++){
			$("#divCheckUC").append("<input type='checkbox' id='check"+i+"' value="+unidadCurricular[i]['codigo']+">"+unidadCurricular[i]['nombre']+"<br>");
			$("#divCheckUC").append("<input type='hidden' id='status"+i+"' value='0'><br>");
		}	
		$("#numArrUC").val(i);
		ajaxCheckModificarUnidadCirrucular();
	}
}

function ajaxCheckModificarUnidadCirrucular(){
	var arr = Array("m_modulo","unidad",
					"m_accion","buscarPrelacionUnidadCurricular",
					"codigo",$("#codUni").val());
	ajaxMVC(arr,actCheckModificarUnidadCirrucular,errorCargarCheckUnidadCurricular);
}

function actCheckModificarUnidadCirrucular(data){
	if (data.estatus>0){
		prelacion=data.pensum;
		for (var i=0; i<prelacion.length;i++){
			for (var j=0; j<$("#numArrUC").val(); j++){
				if (prelacion[i]['cod_uni_cur_prelada']==$("#check"+j).val()){
					$("#check"+j).prop("checked",true);
					$("#status"+j).val(1);
				}
			}
		}
	}
}

function preModificarUnidadCurricular(){	
	$("#botonModif").remove();	
	var arr = Array("m_modulo","unidad",
					"m_accion","buscarCodigoUnidadCurricular");
    ajaxMVC(arr,montarPreModificarUnidadCurricular,errorPreModificarUnidadCurricular);	
}

function montarPreModificarUnidadCurricular(data){
	$("#nombreUC,#codMinisterio,#tipoUnidadCurricular,#hta,#hti,#unidadesCredito,#duracionSemanas,#notaMinima,#notaMaxima").attr('disabled',false);
	$("#tituloinput").remove();
	$("#tipoUnidadCurricular").remove();
	$("#tituloUnidadCurricular").show();
	$("#checkUnidadCurricular").attr("checked",true);
	$("#divCheckUC").show();
	tipoUnidadCurricular=data.pensum;
	$("#selectTipoUnidad").append("<div class='input-group'><span class='input-group-addon'>Tipo de Unidad Curricular:</span><select class='form-control selectpicker' id='tipoUnidadCurricular' class='selectpicker' data-live-search='true'></select></div>");
	for (var i=0;i<tipoUnidadCurricular.length;i++){
		$("#tipoUnidadCurricular").append("<option value="+tipoUnidadCurricular[i]['codigo']+">"+tipoUnidadCurricular[i]['nombre']+"</option>");
	}
	activarSelect();
}

function errorPreModificarUnidadCurricular(){mostrarMensaje("No se puede modificar la unidad en este momento",2);}

function validarmodificarUnidadCurricular(){
	if(validarSoloTexto('#nombreUC',2,100,true)&&
		validarRangos('#codMinisterio',2,30,true)&&
		validarSoloNumeros('#hti',1,2,true)&&
		validarSoloNumeros('#hta',1,2,true)&&
		validarSoloNumeros('#unidadesCredito',1,2,true)&&
		validarSoloNumeros('#duracionSemanas',1,3,true)&&
		validarSoloNumeros('#notaMinima',1,2,true)&&
		validarSoloNumeros('#notaMaxima',1,2,true)&&
		validarMayorMenor('#notaMaxima','#notaMinima'))
	{modificarUnidadCurricular();}
}
function modificarUnidadCurricular(){	
	if (confirm("¿Desea modificar esta unidad curricular?")){
		var arr = Array ("m_modulo","unidad",
						 "m_accion","modificarUnidadCurricular",
						 "codigo", $("#codUni").val(),
						 "codMinisterio", $("#codMinisterio").val(),
						 "codTrayecto",$("#codTray").val(),
						 "nombreUC",$("#nombreUC").val(),							 
						 "tipoUnidadCurricular",$("#tipoUnidadCurricular").val()[0],
						 "hta",$("#hta").val(),
						 "hti",$("#hti").val(),
						 "unidadesCredito",$("#unidadesCredito").val(),
						 "duracionSemanas",$("#duracionSemanas").val(),
						 "notaMinima",$("#notaMinima").val(),
						 "notaMaxima",$("#notaMaxima").val());			
		ajaxMVC(arr,modificarPrelacionUnidadCurricular,errorModificarUnidadCurricular);					
	}
	else
	return false;
}

function modificarPrelacionUnidadCurricular(data){
	if (data.estatus>0){
		mostrarMensaje("Trayecto modificado a este pensum satisfactoriamente",1);
		$("#verUnidadCurricular").modal('hide');
		for (var i=0; i<$("#numArrUC").val(); i++){
			if($("#status"+i).val()==1 && !$("#check"+i).is(':checked')){
				var arr = Array("m_modulo","unidad",
								"m_accion","eliminarPrelacion",
								"codigoUnidad",$("#codUni").val(),
								"codigoPrelada",$("#check"+i).val());
    			ajaxMVC(arr,succEliminarPrelacion,errorModificarUnidadCurricular);
			}
			if($("#status"+i).val()==0 && $("#check"+i).is(':checked')){
				var arr = Array("m_modulo","unidad",
								"m_accion","agregarPrelacionModificar",
								"codigoUnidad",$("#codUni").val(),
								"codigoPrelada",$("#check"+i).val());
    			ajaxMVC(arr,succAgregarPrelacionModificar,errorModificarUnidadCurricular);
			}
		}
		recargarUnidadCurricular();
	}
}
function succEliminarPrelacion(data){}
function succAgregarPrelacionModificar(data){}

function errorModificarUnidadCurricular(){mostrarMensaje("No se ha podido modificar esta unidad curricular",2);}

function errorListarAjax(){mostrarMensaje("Ha ocurrido un eror en la conexion a base de datos",2);}