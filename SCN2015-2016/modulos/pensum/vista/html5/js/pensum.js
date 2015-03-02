permiso=new Per(); 

function administrarPensum(){
	crearDialogo("preagregarpensum","<center>Agregar Pensum</center>","",1,"validarAgregarPensum()","Agregar Pensum");
	$("<div class='row'><div class='col-md-12'><div id='pensumA'></div></div></div>").appendTo("#preagregarpensum .modal-body");
	$("#pensumA").load("modulos/pensum/vista/html5/js/FormularioPensum.php",function(){activarSelect();});	
	$('#preagregarpensum').modal('show');						
}

function validarAgregarPensum(){
	if(validarSoloTexto("#nombre",5,60,true) && validarSoloTexto("#nom_corto",2,6,true))
	{agregarPensum();}
}

function agregarPensum(){	
	var arr = Array ("m_modulo", "pensum",
					 "m_accion", "agregar",
					 "nombre", $("#nombre").val(),
					 "nom_corto", $("#nom_corto").val(), 
					 "observaciones", $("#observaciones").val());
	ajaxMVC(arr,succAgregarPensum,errorAgregarPensum);
}

function succAgregarPensum(data){
	if (data.estatus>0){		
		pensums=data.pensum; 
		$("#preagregarpensum").modal('hide');		
		mostrarMensaje("El pensum ha sido agregado satisfactoriamente!",1);
		recargarPensum();
	}
}

function errorAgregarPensum(){mostrarMensaje("No pueden existir dos pensum con nombres iguales",2);}

function eliminar(codigo){
	if (confirm("¿Desea eliminar el siguiente pensum?")){
		var arr = Array ("m_modulo","pensum",
						 "m_accion","eliminar",
						 "codigo", codigo);			
		ajaxMVC(arr,succEliminarPensum,errorEliminarPensum);			
	}
	else
	return false;	
}

function succEliminarPensum(data){
	if (data.estatus>0){
		mostrarMensaje(data.mensaje,1);
		recargarPensum();
	}
}

function errorEliminarPensum(data){mostrarMensaje("No se puede eliminar un pensum con trayectos activos",2);}

function verPensum(codigo){	
	var arr = Array ("m_modulo","pensum",
	 				 "m_accion","buscarPensum",
	 				 "codigo",codigo);
	ajaxMVC(arr,succBuscarPensum,errorBuscarPensum); 
}

function succBuscarPensum(data){
	if (data.estatus>0){
		$(".modal").remove();
		pensums=data.pensum;
		crearDialogo("verPensum","<center>"+pensums[0]['nombre']+"</center>","<center>Informacion del Pensum</center>",1,"modificar()","")
		$("<div class='row'><div class='col-md-12'><div id='pensumV'></div></div></div>").appendTo("#verPensum .modal-body");
		$("#pensumV").load("modulos/pensum/vista/html5/js/VerPensum.php",function(){montarPensum(pensums);});
		$('#verPensum').modal('show');
	}
}

function montarPensum(pensum){
	$('#codigo').val(pensum[0]['codigo']);
	$('#nombre').val(pensum[0]['nombre']);
	$('#nom_corto').val(pensum[0]['nom_corto']);
	$('#observaciones').val(pensum[0]['observaciones']);
}

function errorBuscarPensum(){mostrarMensaje("No se puede el pensum en este momento");}

function activarPensum(){
	$('#nombre').attr('disabled',false);
	$('#nom_corto').attr('disabled',false);
	$('#observaciones').attr('disabled',false); 
	$(".modal .btn-danger").remove();
    $(".modal-footer").append("<button class='btn btn-success' onclick='validarModificar()'>Guardar Pensum</button>");
    $(".modal-footer").append("<button class='btn btn-danger' data-dismiss='modal' type='button'>Cerrar</button>"); 
    $("#BotonModificar").remove();
}	

function validarModificar(){
	if(validarSoloTexto("#nombre",5,60,true) && validarSoloTexto("#nom_corto",2,6,true))
	{modificar();}
}

function modificar(){
	if (confirm("¿Desea modificar el siguiente pensum?")){
		var arr = Array ("m_modulo", "pensum",
					 "m_accion", "modificar",
					 "codigo",$("#codigo").val(),
					 "nombre", $("#nombre").val(),
					 "nom_corto", $("#nom_corto").val(), 
					 "observaciones", $("#observaciones").val());
		ajaxMVC(arr,succModificar,errorModificar);
	}
	else 
	return false;
}

function succModificar(data){
	if (data.estatus>0){
		$("#verPensum").modal('hide');
		mostrarMensaje(data.mensaje,1);
		recargarPensum();
	}
}

function errorModificar(){mostrarMensaje("Problema al modificar",2);}

function agregarInfPen(codigo){
	var arr = Array ("m_modulo","pensum",
					 "m_accion","buscarTrayPen",
					 "codigo",codigo);
	ajaxMVC(arr,succInfoPen,errorInfoPen); 
}

function succInfoPen(data){
	if (data.estatus>0){
		$(".modal").remove()
		pensums=data.pensum;
		crearDialogo("infoPensum","<center>"+pensums['nombre']+"</center>","<center>Nombre Abreviado del Pensum: "+pensums['nombreCorto']+"<center>","","","")
		$("<div class='row'><div class='col-md-12'><div id='pensumV'></div></div></div>").appendTo("#infoPensum .modal-body");
		$("#pensumV").load("modulos/pensum/vista/html5/js/InformacionP.php",function(){infoTray(pensums);});
		$('#infoPensum').modal('show');
	}
}

function errorInfoPen(){mostrarMensaje("No se pudo agregar el pensum en este momento");}

function infoTray(pensum){
	cadena="";
	var trayectos = pensum['trayectos'];
	if(trayectos[0]['codigo']!=null){
		for (var i=0; i<trayectos.length; i++)		
			{
				var num=i+1;
				var trayecto = trayectos[i];
				var unidades = trayecto['unidades'];
				var unidad1 = unidades[0];
				var cod_trayecto = unidad1['codTrayecto'];			
					var num_unit = unidades.length;
			      cadena+="<div class='panel panel-default' id='idenueva"+num+"'>";
			      	cadena+="<div class='panel-heading' role='tab' id='headerT"+num+"'>";
				  		cadena+="<h4 class='panel-title'>"; 
				  			cadena+="<a data-toggle='collapse' data-parent='#accordion' href='#collapse"+num+"' aria-expanded='true' aria-controls='collapseOne'>";  											
							//=====================================================PANEL=============================================================================
							cadena+="<b><center>Trayecto "+trayecto['numTrayecto']+"</center></b>";
							if (permiso.pensum.insert)
							{
							cadena+="<button class='btn btn-danger pull-right' title='Eliminar Trayecto' onclick='eliminarTrayecto("+trayecto['codPensum']+","+trayecto['numTrayecto']+")'><i class='icon-remove'></i></button>";	
							cadena+="<button class='btn btn-primary pull-right' title='Ver Trayecto' onclick='verTrayecto("+trayecto['codPensum']+","+trayecto['numTrayecto']+")'><i class='icon-eye-open'></i></button>";	
							}							
							
							//=========================================================================================================================================		  				
				  		cadena+="</a>";
				 	 	cadena+="</h4>";
				  	cadena+="</div>";
				  	cadena+="<div id='collapse"+num+"' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingOne'>";
				  	cadena+="<div class='panel-body'>";		  	
				  	cadena+="<table class='table table-bordered'>";
				  	cadena+="<tr class='titulo'>";
					   				cadena+="<td>NOMBRE DE UNIDAD CURRICULAR</td>";
					   				cadena+="<td>CODIGO DE UNIDAD CURRICULAR</td>";
					   				cadena+="<td>HORAS DE TRABAJO INDEPENDIENTE</td>";
					   				cadena+="<td>HORAS DE TRABAJO ACOMPAÑADO</td>";					   				
					   				cadena+="<td>UNIDADES DE CREDITO</td>";	
					   				cadena+="<td>NOTA APROBATORIA</td>";					   							   				
					   				cadena+="<td>DURACION DE SEMANAS</td>";
					   				cadena+="<td>TIPO</td>";
					   				
					   				if (permiso.pensum.insert)
					   				{
					   					cadena+="<td>VER</td>";
					   				cadena+="<td><button class='btn btn-success' title='Agregar Unidad Curricular' onclick='preAgregarUnidadCurricular("+trayecto['codigo']+","+trayecto['numTrayecto']+","+trayecto['codPensum']+")'><i class='icon-plus'></i></button></td>";
					   				}
					   				
					   				
					   			cadena+="</tr>";

						for (j=0; j<unidades.length;j++)
						{				   			
							var unidad = unidades[j];						
							if (unidad['codigo'] != null)
							{					
								cadena+="<tr class='contenido'>";							
								cadena+="<td>"+unidad['nombre']+"</td>"; 
								cadena+="<td>"+unidad['codUnidad']+"</td>"; 
								cadena+="<td>"+unidad['hti']+"</td>";
								cadena+="<td>"+unidad['hta']+"</td>";								
								cadena+="<td>"+unidad['uniCredito']+"</td>"; 
								cadena+="<td>"+unidad['notMinima']+"/"+unidad['notMaxima']+"</td>"; 								
								cadena+="<td>"+unidad['durSemana']+"</td>";
								cadena+="<td>"+unidad['tipo']+"</td>"; 						   		
							    if (permiso.pensum.insert)
							    {
							    cadena+="<td><button class='btn btn-warning' title='Ver Unidad Curricular' onclick='verUnidadCurricular("+unidad['codigo']+","+trayecto['numTrayecto']+","+trayecto['codPensum']+","+trayecto['codigo']+")'><i class='icon-eye-open'></i></button></td>";
							   	cadena+="<td><button class='btn btn-danger' title='Eliminar Unidad Curricular' onclick='eliminarUnidadCurricular("+unidad['codigo']+")'><i class='icon-remove'></i></button></td>";   
							    }	
							   	
							}
						}
						cadena+="</tr>";
						cadena+="</tr>";
						cadena+="</table>";						
						cadena+="</div>";				
			  			cadena+="</div>";	  			
			  			cadena+="</div>";
			}
		cadena+="</div>";
		$(cadena).appendTo('#accordiontray');		
		if (permiso.pensum.insert){$("<div class='row'><div class='col-md-4' id='botones'><button class='btn btn-success' onclick='preAgregarTrayecto("+pensum['codigo']+")'>Agregar Trayecto</button></div></div>").appendTo("#divtrayecto");}
		$("<div class='col-md-6'><button class='btn btn-danger' onclick=\"window.location.assign('index.php?m_modulo=trayecto&m_accion=verTrayectosPensumPDF&m_vista=verPensumTrays&m_formato=pdf&codigoPensum="+trayecto['codPensum']+"')\"><i class='icon-book'></i> Exportar en PDF</button></div><br><br>").appendTo("#botones");
		$("<input type='text' value="+pensum['codigo']+" hidden='hidden' id='inputPen'>").appendTo("#inputPensum");
	}else{
		$("<div class='row'><div class='col-md-4' id='botones'><button class='btn btn-success' onclick='preAgregarTrayecto("+pensum['codigo']+")'>Agregar Trayecto</button></div></div>").appendTo("#divtrayecto");
		$("<input type='text' value="+pensum['codigo']+" hidden='hidden' id='inputPen'>").appendTo("#inputPensum");
		preAgregarTrayecto(pensum['codigo']);
	}
}

function infoTrayRecargar(pensum){
	cadena="";
	var trayectos = pensum['trayectos'];
	if(trayectos[0]['codigo']!=null){
		for (var i=0; i<trayectos.length; i++)		
			{
				var num=i+1;
				var trayecto = trayectos[i];
				var unidades = trayecto['unidades'];
				var unidad1 = unidades[0];
				var cod_trayecto = unidad1['codTrayecto'];			
					var num_unit = unidades.length;
			      cadena+="<div class='panel panel-default' id='idenueva"+num+"'>";
			      	cadena+="<div class='panel-heading' role='tab' id='headerT"+num+"'>";
				  		cadena+="<h4 class='panel-title'>"; 
				  			cadena+="<a data-toggle='collapse' data-parent='#accordion' href='#collapse"+num+"' aria-expanded='true' aria-controls='collapseOne'>";  											
							//=====================================================PANEL=============================================================================
								cadena+="<b><center>Trayecto "+trayecto['numTrayecto']+"</center></b><button class='btn btn-danger pull-right' title='Eliminar Trayecto' onclick='eliminarTrayecto("+trayecto['codPensum']+","+trayecto['numTrayecto']+")'><i class='icon-remove'></i></button>"+"<button class='btn btn-primary pull-right' title='Ver Trayecto' onclick='verTrayecto("+trayecto['codPensum']+","+trayecto['numTrayecto']+")'><i class='icon-eye-open'></i></button>";	
							//=========================================================================================================================================		  				
				  		cadena+="</a>";
				 	 	cadena+="</h4>";
				  	cadena+="</div>";
				  	cadena+="<div id='collapse"+num+"' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingOne'>";
				  	cadena+="<div class='panel-body'>";		  	
				  	cadena+="<table class='table table-bordered'>";
				  	cadena+="<tr class='titulo'>";
					   			
					   				cadena+="<td>NOMBRE DE UNIDAD CURRICULAR</td>";
						   				cadena+="<td>CODIGO DE UNIDAD CURRICULAR</td>";
						   				cadena+="<td>HORAS DE TRABAJO INDEPENDIENTE</td>";
						   				cadena+="<td>HORAS DE TRABAJO ACOMPAÑADO</td>";					   				
						   				cadena+="<td>UNIDADES DE CREDITO</td>";	
						   				cadena+="<td>NOTA APROBATORIA</td>";					   							   				
						   				cadena+="<td>DURACION DE SEMANAS</td>";
						   				cadena+="<td>TIPO</td>";
						   				cadena+="<td>VER</td>";
					   				cadena+="<td><button class='btn btn-success' title='Agregar Unidad Curricular' onclick='preAgregarUnidadCurricular("+trayecto['codigo']+","+trayecto['numTrayecto']+","+trayecto['codPensum']+")'><i class='icon-plus'></i></button></td>";
					   			cadena+="</tr>";

						for (j=0; j<unidades.length;j++)
						{				   			
							var unidad = unidades[j];						
							if (unidad['codigo'] != null)
							{					
								cadena+="<tr class='contenido'>";
								
								cadena+="<td>"+unidad['nombre']+"</td>"; 
									cadena+="<td>"+unidad['codUnidad']+"</td>"; 
									cadena+="<td>"+unidad['hti']+"</td>";
									cadena+="<td>"+unidad['hta']+"</td>";								
									cadena+="<td>"+unidad['uniCredito']+"</td>"; 
									cadena+="<td>"+unidad['notMinima']+"/"+unidad['notMaxima']+"</td>"; 								
									cadena+="<td>"+unidad['durSemana']+"</td>";
									cadena+="<td>"+unidad['tipo']+"</td>"; 								   		
							   	cadena+="<td><button class='btn btn-warning' title='Ver Unidad Curricular' onclick='verUnidadCurricular("+unidad['codigo']+","+trayecto['numTrayecto']+","+trayecto['codPensum']+","+trayecto['codigo']+")'><i class='icon-eye-open'></i></button></td>";
							   	cadena+="<td><button class='btn btn-danger' title='Eliminar Unidad Curricular' onclick='eliminarUnidadCurricular("+unidad['codigo']+")'><i class='icon-remove'></i></button></td>";   
							}
						}
						cadena+="</tr>";
						cadena+="</tr>";
						cadena+="</table>";						
						cadena+="</div>";				
			  			cadena+="</div>";	  			
			  			cadena+="</div>";
			}
		cadena+="</div>";
		$(cadena).appendTo('#accordiontray2');	
		$("<div class='row'><div class='col-md-4' id='botones'><button class='btn btn-success' onclick='preAgregarTrayecto("+pensum['codigo']+")'>Agregar Trayecto</button></div></div>").appendTo("#divtrayecto");	
		$("<div class='col-md-6'><button class='btn btn-danger' onclick=\"window.location.assign('index.php?m_modulo=trayecto&m_accion=verTrayectosPensumPDF&m_vista=verPensumTrays&m_formato=pdf&codigoPensum="+trayecto['codPensum']+"')\"><i class='icon-book'></i> Exportar en PDF</button></div><br><br>").appendTo("#botones");
		$("<input type='text' value="+pensum['codigo']+" hidden='hidden' id='inputPen'>").appendTo("#inputPensum");
	}else{
		$("<div class='row'><div class='col-md-4' id='botones'><button class='btn btn-success' onclick='preAgregarTrayecto("+pensum['codigo']+")'>Agregar Trayecto</button></div></div>").appendTo("#divtrayecto");
		$("<input type='text' value="+pensum['codigo']+" hidden='hidden' id='inputPen'>").appendTo("#inputPensum");
		preAgregarTrayecto(pensum['codigo']);
	}
}

function buscarListar(patron){
	var arr = Array("m_modulo"	,	"pensum",
					"m_accion"	,	"listar",
					"patron"	,	patron);
	ajaxMVC(arr,successListarAjax,errorListarAjax);
}

function successListarAjax(data){
	if(data.estatus > 0){
		recargar(data.pensum);
	}
}

function errorListarAjax(data){}

function recargarPensum(){
	var arr = Array ("m_modulo", "pensum",
				     "m_accion", "listar");
	ajaxMVC(arr,succRecargarPensum,errorRecargarPensum);
}

function errorRecargarPensum(data){mostrarMensaje("Error al recargar la pagina",2);}

function succRecargarPensum(data){
	if (data.estatus>0){
		pensum=data.pensum;
		$("#tabla2").remove();
		cadena="";
	    cadena+="<div id='tabla2'>";
		cadena+="<table class='table' id='tablapensum'>";
	    cadena+="<tr class='titulo'>";
	    cadena+="<td>Número</td>";
	    cadena+="<td>Nombre Pensum</td>";
	    cadena+="<td>Nombre Corto</td>";
	    cadena+="<td colspan='2'>";
	    cadena+="<button class='btn btn-success' title='Agregar Pensum' onclick='administrarPensum()' data-target='#preagregarpensum' data-toggle='modal'>Agregar Pensum</button>";		
	    cadena+="</td></tr>";
		for (var i=0; i<pensum.length; i++){
	        cadena+="<tr class='tr'>";
	        var num=i+1;
	        cadena+="<td>"+num+"</td>";
	        cadena+="<td>"+pensum[i]['nombre']+"</td>";
	        cadena+="<td>"+pensum[i]['nom_corto']+"</td>";
	        cadena+="<td colspan='2'>";
	        cadena+="<button class='btn btn-warning' title='Ver Pensum' onclick='verPensum("+pensum[i]['codigo']+");'>";
	        cadena+="<i class='icon-eye-open'></i>";
	        cadena+="</button>";	
	        cadena+="<button class='btn btn-info' title='Modificar Pensum' onclick='agregarInfPen("+pensum[i]['codigo']+");'>";
	        cadena+="<i class='icon-pencil'></i>";
	        cadena+="</button>";
	        cadena+="<button class='btn btn-danger' title='Eliminar Pensum' onclick='eliminar("+pensum[i]['codigo']+");'>";
	        cadena+="<i class='icon-remove'></i>";
	        cadena+="</button>";
	        cadena+="<button class='btn btn-danger' title='Reporte en PDF' onclick=\"window.location.assign('index.php?m_modulo=pensum&m_accion=buscarTrayPen&m_vista=verUnicTray&m_formato=pdf&codigo="+pensum[i]['codigo']+"')\"><i class='icon-book'></i></button>";      																
	       	cadena+="<button class='btn btn-primary' title='Reporte en PDF' onclick=\"window.location.assign('index.php?m_modulo=pensum&m_accion=buscarTrayPen&m_vista=verUnicTray2&m_formato=pdf&codigo="+pensum[i]['codigo']+"')\"><i class='icon-book'></i></button>";												
	        cadena+="</td>";			
	        cadena+="</tr>";  
		};
	    cadena+="</table></div>";
		$(cadena).appendTo('#tabla1');
	}
}