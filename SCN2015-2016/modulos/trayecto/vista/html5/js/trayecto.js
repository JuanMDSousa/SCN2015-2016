function preAgregarTrayecto(codigopen){
	crearDialogo("VentanaFormularioTrayecto","<center><h2>Agregar Trayecto</h2></center>","<center></center>",1,"validarAgregarTrayecto("+codigopen+")","Agregar");
	$("#VentanaFormularioTrayecto .modal-body").load("modulos/pensum/vista/html5/js/AgregarTrayecto.php");
	$("#VentanaFormularioTrayecto").modal("show");
}

function validarAgregarTrayecto(codigopen){
	if(validarSoloNumeros("#num_trayecto",1,3,true) && validarSoloTexto("#certificado",5,50,false)&&validarSoloNumeros("#min_credito",1,3,true))
	{agregarTrayecto(codigopen);}
}

function agregarTrayecto(codigopen){
	var arr = Array ("m_modulo","trayecto",
					 "m_accion","agregarTrayecto",					
					 "codigo",codigopen,
					 "num_trayecto",$("#num_trayecto").val(),
					 "certificado",$("#certificado").val(), 
					 "min_credito",$("#min_credito").val());
	ajaxMVC(arr,succAgregarTrayecto,errorAgregarTrayecto);
}

function succAgregarTrayecto(data){
	console.log(data);
	if (data.estatus>0){
		mostrarMensaje("Trayecto Agregado",1);
		$("#VentanaFormularioTrayecto").modal('hide'); 
		$("#infoPensum .modal").remove();									
		recargarTrayecto();		
	}
	else
		mostrarMensaje("No pueden existir dos trayecto iguales.",2);
}

function errorAgregarTrayecto(){mostrarMensaje("No pueden existir dos trayecto iguales",2);}

function verTrayecto(codpen,numtray){
	var arr = Array ("m_modulo","trayecto",
					 "m_accion","verTrayecto",					 
					 "codigo", codpen,
					 "numtray", numtray);			
	ajaxMVC(arr,succVerTrayecto,errorVerTrayecto);
}

function succVerTrayecto(data){
	trayecto=data.pensum;
	crearDialogo("VentanaFormularioTrayecto","<center><h2>Trayecto "+trayecto[0]['num_trayecto']+"</h2></center>","<center></center>",1,"validarModificarTrayecto()","Guardar");
	$("#VentanaFormularioTrayecto .modal-body").load("modulos/pensum/vista/html5/js/AgregarTrayecto.php",function(){montarTrayecto();});
	$("#VentanaFormularioTrayecto").modal("show");
}

function errorVerTrayecto(){mostrarMensaje("No se puede ver el trayecto en este momento",2);}

function montarTrayecto(){
	$("#modificar").append("<center><button class='btn btn-warning' onclick='preModificarTrayecto()'>Modificar</button></center>");
	$("#num_trayecto,#certificado,#min_credito").attr('disabled',true);
	$("#num_trayecto").val(trayecto[0]['num_trayecto']);
	$("#certificado").val(trayecto[0]['certificado']);
	$("#min_credito").val(trayecto[0]['min_credito']);
}

function preModificarTrayecto(){
	$("#modificar").remove();
	$("#num_trayecto,#certificado,#min_credito").attr('disabled',false);
}

function validarModificarTrayecto(){
	if(validarSoloNumeros("#num_trayecto",1,3,true) && validarSoloTexto("#certificado",5,50,false)&&validarSoloNumeros("#min_credito",1,3,false))
	{modificarTrayecto();}
}

function modificarTrayecto(){
	if (confirm("¿Desea modificar este trayecto?")){
		var arr = Array ("m_modulo", "trayecto",
						 "m_accion", "modificarTrayecto",					 
						 "codigo",trayecto[0]['codigo'],
						 "num_trayecto",$("#num_trayecto").val(),
						 "certificado", $("#certificado").val(),
						 "min_credito", $("#min_credito").val());
		ajaxMVC(arr,succModificarTrayecto,errorModificarTrayecto);
	}
	else 
	return false;
}

function succModificarTrayecto(data){
	if (data.estatus>0){
		mostrarMensaje("Trayecto modificado",1);
		$("#VentanaFormularioTrayecto .modal").hide();	
		$("#infoPensum .modal").remove();
		recargarTrayecto();
	}
}

function errorModificarTrayecto(){mostrarMensaje("No pueden existir dos trayectos iguales",2);}

function eliminarTrayecto(codpen,numtray){
 	if (confirm("¿Desea eliminar el trayecto?")){
		var arr = Array ("m_modulo","trayecto",
						 "m_accion","eliminarTrayecto",
						 "codigo", codpen,
						 "numtray", numtray);			
		ajaxMVC(arr,succEliminarTrayecto,errorEliminarTrayecto);			
	}
	else
	return false;
}

function succEliminarTrayecto(){
	mostrarMensaje("Trayecto Eliminado satisfactoriamente",1);
	$("#infoPensum .modal").remove();
	recargarTrayecto();	
}

function errorEliminarTrayecto(){mostrarMensaje("No puede eliminar un trayecto con unidades curriculares inscritas",2);}

function recargarTrayecto(){
	var arr = Array("m_modulo", "pensum",
					"m_accion", "buscarTrayPen",
					"codigo", $("#inputPen").val());
	ajaxMVC(arr,succRecargarTrayecto,errorRecargarTrayecto);
}

function succRecargarTrayecto(data){
	if (data.estatus>0){		
		pensums=data.pensum;															
		crearDialogo("infoPensum2","<center>"+pensums['nombre']+"</center>","<center>Nombre Abreviado del Pensum: "+pensums['nombreCorto']+"<center>","","","");
		$("<div class='row'><div class='col-md-12'><div id='pensumV'></div></div></div>").appendTo("#infoPensum2 .modal-body");
		$("#pensumV").load("modulos/pensum/vista/html5/js/InformacionP.php",function(){infoTrayRecargar(pensums);});	
		$("#infoPensum").modal("show");		
	}
}

function errorRecargarTrayecto(){mostrarMensaje("No se pueden ver los trayectos en este momento",2);}