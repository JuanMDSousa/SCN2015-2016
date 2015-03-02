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

Nombre: Pensum.js
Diseñador: Jhonny Vielma
Programador: Jhonny Vielma
Fecha: Enero de 2014
Descripción:  
* 
	Este archivo contiene los códigos javascript necesarios y particulares
	del módulo Pensum, debe ser incluido en todas las vistas de este
	módulo. Contiene básicamente validaciones y configuraciones iniciales
	para llevar a cabo las acciones propias de este módulo tales como 
	agregar, modificar, eliminar, cosultar y listar pensums

 * * * * * * * * Cambios/Mejoras/Correcciones/Revisiones * * * * * * * *
Diseñador - Programador /   Fecha   / Descripción del cambio
---                         ----      ---------

 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/

/*********************************************************************************************/

function validarFormularioPensum(){
	
	$(function(){
		jQuery.validator.addMethod("lettersonly", function(value, element) {
			return this.optional(element) || /^[A-Za-z ()áéíóú]+$/i.test(value);
		}, "Solo letras");
        $('#frmPensumAdministrar').validate({
            rules :{
                nombreCorto : {
                    required : true,
                    minlength : 2,
                    maxlength : 20,
                    lettersonly: true 
                },
                Nombre : {
                    required : true,
                    minlength : 2,
                    maxlength : 100,
                    lettersonly: true 
                },
                observaciones : {
                    required : true,
                    maxlength : 200 
                }
            },
            messages : {
                nombreCorto : {
                    required : "Este campo es obligatorio",
                    minlength : "EL nombre corto debe poseer minimo 2 caracteres",
                    maxlength : "EL nombre corto puede tener solo un maximo de 20 caracteres",
                    lettersonly:     "Por Favor Solo escriba digitos disponibles"
                },
                Nombre : {
                    required : "Debe ingresar un nombre, de no tener coloque (No Posee)",
                    minlength : "EL nombre debe poseer minimo 2 caracteres",
                    maxlength : "EL nombre puede tener solo un maximo de 100 caracteres",
                    lettersonly:     "Por Favor Solo escriba digitos disponibles"
                },
                observaciones : {
                    required : "Debe ingresar observaciones de no poseer coloque (sin observaciones)",
                    maxlength : "Las observaciones puede tener solo un maximo de 200 caracteres",
                    lettersonly:     "Por Favor Solo escriba digitos disponibles"
                }
            }
        });    
    });	
	
}

/************************************************************************************/

/* 	El $(document).ready permite hacer modificaciones y cargar elementos en la 
 * 	despues de cargar el scrip de la pagina.
 * 	Procedimiento que se ejecuta cuando la página se ha cargado completamente.
 * 	Aquí se procederá a cargar la programación de cada botón del módulo Pensum
 * 	y funciones que se necesiten cargar despues de que la pagina este carga.
 **/

$(document).ready(function (){
	if (pensum_accion=='listar'){
		cargarFuncionAutocompletarPensum();
		cargarFuncionMostrarPensumHover();
		cargarFuncionEliminarPensum();
	}else if (pensum_accion=='administrar'){
		cargarFuncionEliminarPensum();
		cargarFuncionAnimarMostrarTrayecto();
	}	
});  // fin del $(ducument).ready();


/***********************************************************************************/

/* Funcion que permite crear el div y cargar el formulario de pensum donde
 * se llenaran los datos ya sea para agregar, modificar o mostrar; De ya 
 * existir el div y el dialogo creado la funcion llama directamente a administrar
 * Pensum,  pasandole por parametros el codigo y la accion antes pasada a dicha 
 * funcion.
 * variables de entrada: 
 * 		codigo: codigo del pensum de ser mostrar o modificar, si es agregar
 * 		dicho parametro se pasara en vacio.
 * 		accion: Accion a ejecutar ya sea (agregar,modificar,mostrar).
 * Ejemplo:
 * 		agregarVerModificarPensum("","agregar");
 * 		agregarVerModificarPensum("1","mostrar");
 * 		agregarVerModificarPensum("1","modificar");
 * */

function agregarVerModificarPensum(codigo,accion){
	$("#dialogoPensum").remove();
	$("<div id='dialogoPensum'></div>").appendTo("body");
	$("#dialogoPensum").load("modulos/pensum/vista/html5/JavaScript/dialogoPensum.php",
							function () { administrarPensum(codigo,accion); 
							
							
							}
						);	
}
/********************************************************************************/

/*	Funcion que permite buscar la informacion de un pensum en especifico, el del 
 * 	codigo pasado por parametro. Esta funcion logra buscar la informacion de un 
 * 	pensum mediante una consulta ajax sin necesidad de recargar la pagina, en caso 
 * 	de exito la funcion llama a montar_infomacion() y le pasa por parametro los datos
 * 	consultados al servidor.
 * 	Variables de entrada: 
 * 		Codigo: codigo del pensum a consultar.
 * 	ejemplo:
 * 		buscarInformacionPensum("2");
 * */

function buscarInformacionPensum(codigo){
	
	$.ajax({                 //llamada ajax
			type:"post",
			dataType: "json",
			url: "index.php",
			data:{  m_modulo:"pensum",             //parámetros
					m_accion:"mostrar", 
					m_vista:"pensumMostrar", 
					m_formato:"json", 
					codigo: codigo,
					},
			success: function(datos){ 
							montarInformacionPensum(datos.nombreCorto,datos.nombre,datos.observaciones);
					},
			error: function(data){ 
						alert("Error de comunicación con el servidor");
					}
		});	
	
}

/***********************************************************************************/

/*	Funcion que permite ejecutar una serie de acciones dependiendo del parametro
 * 	accion que le sea pasado agregar, modificar o mostrar. esta funcion ejecutara las
 * 	respectivas aciones para que la accion solicitada se ejecute con exito.
 * 	Varibles de entrada: 
 * 		codigo: codigo del pensum el cual se quiere modificar o mostrar, de la accion
 * 				ser agregar el parametro codigo se pasara en vacio.
 * 		accion: accion que se desea ejecutar ya sea mostar, agregar o modificar.
 * 	Ejemplo:
 * 		administrarPensum("2","mostrar");
 * 		administrarPensum("2","modificar");
 * 		administrarPensum("","agregar");
 * */
function administrarPensum(codigo,accion){
	
	
				validarFormularioPensum();
	
	if (accion == "agregar"){ // condicion de lineas que se ejecutaran segun la accion
		configurarDialogoPensum(accion);
		montarInformacionPensum('','','');
		mostrarDialogoPensum(accion,codigo);
	}else if (accion== "mostrar"){
		buscarInformacionPensum(codigo);
		configurarDialogoPensum(accion);
		mostrarDialogoPensum(accion,codigo);
	}else if (accion=="modificar"){
		buscarInformacionPensum(codigo);
		configurarDialogoPensum(accion);
		mostrarDialogoPensum(accion,codigo);	
	}
	
}

/********************************************************************************/

/*	Funcion que permite configurar el dialogo del formulario pensum, para gregarlo,
 * 	mostrarlo o modificarlo. Esta funcion permitira cambiarle el titulo y activar
 * 	o desactivar los imput del dialogo segun sea la accion.
 * 	variables de entrada:
 * 		accion: Accion a ejecutar ya sea agregar,mostrar o modificar.
 * 	ejemplos:
 * 		configurarDialogoPensum("mostrar");
 * 		configurarDialogoPensum("modificar");
 * 		configurarDialogoPensum("agregar");
 * */	
function configurarDialogoPensum(accion){
	$("#dialogoPensum").removeProp("title");	
	if (accion == "mostrar"){
		$("#dialogoPensum").attr("title", "Consultar Pensum");
		$("#nombreCorto").attr("disabled", true);
		$("#NombrePensum").attr("disabled", true);
		$("#observacionesPensum").attr("disabled", true);
	}else if (accion == "agregar"){
		$("#dialogoPensum").attr("title", "Agregar Pensum");
		$("#nombreCorto").attr("disabled", false);
		$("#NombrePensum").attr("disabled", false);
		$("#observacionesPensum").attr("disabled", false);
	}else if (accion == "modificar"){
		$("#dialogoPensum").attr("title", "Modificar Pensum");
		$("#nombreCorto").attr("disabled", false);
		$("#NombrePensum").attr("disabled", false);
		$("#observacionesPensum").attr("disabled", false);
	}	
}

/********************************************************************************/

/*	Funcion que permite montar informacion en el formulario del pensum ya sea para
 * 	agregar un pensum, modificarlo o consultarlo. Esta funcion permite montar dicha 
 * 	informacion pasada por parametro en los imput del formulario del pensum.
 * 	Variables de entrada:
 * 		nombreCorto: Nombre Corto del pensum.
 * 		nombre: Nombre completo del pensum.
 * 		observaciones: Observaciones del pensum.
 * 	Ejemplo:
 * 		montarInformacionPensum("PNFA","Programa nacional de formacion de administracion","Administracon")
 * */

function montarInformacionPensum(nombreCorto,nombre,observaciones){
	$("#nombreCorto").val(nombreCorto);
	$("#NombrePensum").val(nombre);
	$("#observacionesPensum").val(observaciones);
}

/****************************************************************************************/

/*	Funcion que permite actualizar la informacion en los id correpsondientes de la vista pensumT
 * 	cuando se realiza una modificacion del pensum en dicha vista.
 * 	Variables de entrada:
 * 		nombreCorto: Nombre Corto del pensum.
 * 		nombre: Nombre completo del pensum.
 * 		observaciones: Observaciones del pensum.
 * 	Ejemplo:
 * 		actualizarPensum("PNFA","Programa nacional de formacion de administracion","Administracon")
 * */

function actualizarPensum(nombreCorto,nombre,observaciones){
	$("#nombreCortoPensum").html(nombreCorto);
	$("#nombreCompletoPensum").html(nombre);
	$("#observacionesPensum12").html(observaciones);
	$("#nombrePensumPrincipal").html("<h2>Informacion del Pensum "+nombre+" </h2>")
}

/*******************************************************************************************************/

/* 	Funcion que permite mostrar el dialogo que contiene el formulario del pensum
 * 	ya sea para agregar, mostrar o modificar la informacion del pensum, esta funcion
 * 	dependiendo de la accion configura los botones para que ejecute la accion correctamente
 * 	y abre el dialogo confgurada.
 * 	Variables de entrada:
 * 		accion: Accion a ejecutar ya sea modificar, agregar y mostrar.
 * 		codigo: Codigo del pensum a modificar o mostrar, en el caso de agregar este
 * 		parameto de pasara vacio ("").
 * 	Ejemplos:
 * 		mostrarDialogoPensum("mostrar","2");
 * 		mostrarDialogoPensum("modificar","2");
 * 		mostrarDialogoPensum("agregar",""); 
 * */

function mostrarDialogoPensum(accion,codigo){ 
	var botones;
	if (accion == "mostrar"){
		botones = {
			Cerrar: function() {
				$(this).dialog('close');
			}
		};		
	}else if (accion == "modificar") {
		botones = {
			Modificar: function() {
				jQuery.validator.setDefaults({
					debug: true,
					success: "valid"
				});
				var form = $("#frmPensumAdministrar");
				
				if (form.valid() == true){
					modificarPensum(codigo);
					$(this).dialog('close');
				}
				if (form.valid() == false){
					alert( "Formulario Invalido" );
				}
			},
			Cancelar: function() {
				$(this).dialog('close');
			}
		};
	}else if (accion == "agregar") {
		botones = {
			Agregar: function() {
				jQuery.validator.setDefaults({
					debug: true,
					success: "valid"
				});
				var form = $("#frmPensumAdministrar");
				
				if (form.valid() == true){
					agregarPensum();
					$(this).dialog('close');
				}
				if (form.valid() == false){
					alert( "Formulario Invalido" );
				}
			},
			Cancelar: function() {
				$(this).dialog('close');
			}
		};	
	}
	
	$('#dialogoPensum').dialog({
		autoOpen: false,
		height: 280,
		width: 450,
		modal: true,
		resizable: true,
		buttons: botones
	});
		
	$('#dialogoPensum').dialog('open');

}

/********************************************************************************************/

/*	Funcion que permite modificar un pensum, el del codigo pasado por parametro, esta funcion
 * 	construye una consulta ajax que ira al servidor sin recargar la pagina y enviara por post
 * 	el nombre corto, nombre y observaciones ambas agarradas del id de los imput del formulario
 *  del pensum y envia el codigo pasado por parametro a la funcion.
 * 	Variables de entrada:
 * 		codigo: Codigo del pensum a modificar.
 * 	Ejemplo:
 * 		modificarPensum("2"); 
 * */

function modificarPensum(codigo){
	
	$.ajax({                 //llamada ajax
			type:"post",
			dataType: "json",
			url: "index.php",
			data:{  m_modulo:"pensum",             //parámetros
					m_accion:"modificar",
					m_vista:"pensumModificar", 
					m_formato:"json",
					codigo: codigo,
					nombreCorto: $("#nombreCorto").val(),
					nombre:$("#NombrePensum").val() ,
					observaciones: $("#observacionesPensum").val()
					},
			success: function(data){  
								if (data == "1"){
								alert ("Pensum modificado con éxito")
								actualizarPensum($("#nombreCorto").val(),$("#NombrePensum").val(),$("#observacionesPensum").val());
							}else
								alert ("Error al modificar el pensum");  
					},
			error: function(data){ 
						alert("Error de comunicación con el servidor");
					}
		});	
	
}

/******************************************************************************************/

/*	Funcion que permite agregar un pensum, esta funcion construye una consulta ajax
 *  que ira al servidor sin recargar la pagina y enviara por post el nombre corto, 
 * 	nombre y observaciones ambas agarradas del id de los imput del formulario
 *  del pensum.
 * 	Variables de entrada:
 * 		No posee
 * 	Ejemplo:
 * 		agregarPensum(); 
 * */
function agregarPensum(){

	$.ajax({                 //llamada ajax
			type:"post",
			dataType: "json",
			url: "index.php",
			data:{  m_modulo:"pensum",             //parámetros
					m_accion:"agregar", 
					m_vista:"pensumAgregar", 
					m_formato:"json", 
					nombreCorto: $("#nombreCorto").val(),
					nombre:$("#NombrePensum").val() ,
					observaciones: $("#observacionesPensum").val()
			},
			success: function(datos){  
							if (datos.exito == 1){
							
								if (confirm ("¿Desea agregarle trayectos y unidades curriculares al nuevo Pensum (" + $("#nombreCorto").val()  + ")?"))
									enviar('pensum','administrar','html5','pensumt',Array('codigo',datos.codigo));
								else
									enviar('pensum','listar','html5','pensumListar');
							}else
								alert ("Error al agregar el pensum");  
					},
			error: function(data){ 
						alert("Error de comunicación con el servidor");
					}
	});
}

/************************************************************************************/


/*	Funcion que permite agregarle animacion al Div donde se escuentran los trayectos
 * 	al precionar un click sobre el numero de trayecto se desplegara la lista de unidades
 *  curriculares.
 * 	Variables de entrada: 
 * 		no tiene.
 * 	Ejemplos:
 * 		cargarFuncionAnimarMostrarTrayecto();
 * */
function cargarFuncionAnimarMostrarTrayecto(){
	// Esconder los páneles de contenido al abrir
	//bio es el div que contiene dentro los trayectos
	$( '#bio > div' ).hide();

  
	//click sobre el trayecto
	$( "table" ).delegate( ".titulotrayecto", "click", function() {	
		//mostrar u ocultar la lista de unidades curriculares
		
		$("#uniCurricular_" + $(this).attr("codigo")   )
		.animate( 
			{'height':'toggle'}, 'slow', 'easeOutBounce'
		);
		
	}); 
}

/***********************************************************************************/


/*	Función que le agrega al cuadro de texto de búsqueda de Pensums la función de 
* 	autocompletar. Al introducir una letra en el cuadro de texto, se desplegará una
*  	lista de coincidencia de pensums, ya sea por nombre corto, nombre largo u observaciones.
* 	Variables de entrada:
* 		No posee.
* 	Ejemplos:
* 		cargarFuncionAutocompletarPensum();
*/
function cargarFuncionAutocompletarPensum(){

	$( "#patronbusqueda" ).autocomplete({
		delay: 200,  //milisegundos
		minLength: 1,
		source: function( request, response ) {
			$.ajax({                 //llamada ajax
				type:"post",
				dataType: "json",
				url: "index.php",
				data:{	m_modulo:"pensum",             //parámetros
						m_accion:"listar", 
						m_vista:"pensumListar", 
						m_formato:"json", 
						patron: request.term  //el valor del input al que se le aplica el autocomplete,
						//equivalente a document.getElementById("#patronbusqueda").value
						//equivalente a $("#patronbusqueda").val()
				},
				success: function(data){  
					return response(data);  
				},
				error: function(data){ 
					return response([{"label": "Error de conexión", "value": {"nombreCorto":""}}]); 
				}
			});	
		},
		select: function (event, ui){
			$("#patronbusqueda").val(ui.item.value.nombreCorto);
			event.preventDefault();
		},
		focus: function (event, ui){
			event.preventDefault();
			$("#patronbusqueda").val(ui.item.value.nombreCorto);
		}		
	});	

}

/***********************************************************************************/

/*	Función que muestra la información completa del Pensum al colocar
* 	el puntero del ratón sobre un pensum de la lista. Esta funcion arma
* 	una consulta ajax que le permite interactuar con el servidor sin 
* 	recargar la pagina. y lo monta en un cuadrito que se desvanece al quitar
* 	el maus sobre el pensum.
* 	variables de entrada:
* 		No posee.
* 	ejemplo:
* 		cargarFuncionMostrarPensumHover();
*/

function cargarFuncionMostrarPensumHover(){

	$(".pensum").hover(
		function(e){
			var codigo = $(this).attr('codigo');
			$(this).css({"background-color": "gray"});
			$.ajax({
				type:"post",
				dataType: "json",
				url: "index.php",
				data:{m_modulo:"pensum",
						m_accion:"administrar", 
						m_vista:"pensumMostrar", 
						m_formato:"json", 
						codigo: codigo
						},
				success: function(datos, textStatus, jqXHR ){  
							$("body > #detallepensum").remove(); //borrar div
							$("<div id='detallepensum'></div>")  //crear div
							.css({"background-color": "white",
								  "color":"black",
								  "border":"3px solid black",
								  "position":"absolute",
								  "width":"400px",
								  "height":"250px",
								  "top":(e.pageY + 20) + 'px',
								  "left":(e.pageX + 30) + 'px',
								  "opacity": "0.90",
								  "font-weight":"bold",
								  "display":"none"
								})
							.html( "DETALLE DEL PENSUM <br><br>" //Creacion del cuadro de informacion del pensum
							    +  "Código: " + datos.codigo + "<br>"
								+  "Nombre Corto: " + datos.nombreCorto + "<br>"
								+  "Nombre: " + datos.nombre + "<br>"
								+  "N° Trayectos: " + datos.trayect + "<br>"
								+  "N° UC: " + datos.uc + "<br>"
								+  "N° HT Independiente: " + datos.hti + "<br>"
								+  "N° HT Acompañado: " + datos.hta + "<br>"
								+  "N°UniCredito x P: " + datos.unidades + "<br>"
								+  "Observaciones " + datos.observaciones
							)
							.appendTo("body").stop().slideDown(); //agregar div de manera animada
						}
						,
				error: function(){  
							
						}
			});
		}
		,
		function(e){
			$(this).css({"background-color": "transparent"}); //restaurar fondo
			$("body > #detallepensum").fadeOut();    //eliminar div de forma animada
			
		}
	);
	
}

/***********************************************************************************/

/* 	Función ajax que le aplica la programacion a todos los elementos que tengan como
*	clase eliminarPensum, al hacer el boton que pertenezca a esta clase hay que anexarle 
* 	el código del pensum que desea eliminar al bóton
* 	Variables de entrada:
* 		No posee.
* 	ejemplo: 
* 		Llamado de funcion: cargarFuncionEliminarPensum();
* 		Como utilizarla: <a href="" class="eliminarPensum" id="elimajaxp" codigo="2">
							<img src='base/imagenes/Delete.png' alt='Ver' 
							class='icono_pequenio' title = "Eliminar pensum" />
						</a>  
*/

function cargarFuncionEliminarPensum(){
	$(".eliminarPensum").click(function (){
		if (confirm("¿Está seguro que desea eliminar el Pensum " + $("#nombreCorto").val() 
		+ " cuyo código es " + $(this).attr('codigo') + "?")){
			
			$.ajax({                 //llamada ajax
				type:"post",
				dataType: "json",
				url: "index.php",
				data:{  m_modulo:"pensum",             //parámetros
						m_accion:"eliminar", 
						m_vista:"pensumEliminar", 
						m_formato:"json", 
						codigo: $(this).attr('codigo')
						},
				success: function(data){  
								if (data == "1"){
									alert ("Pensum eliminado con éxito")
									enviar('pensum','listar','html5','pensumListar');
								}else
									alert ("Error al eliminar el pensum");  
						},
				error: function(data){ 
							alert("Error de comunicación con el servidor al eliminar el Pensum, revise si el pensum no contiene trayecto, de contenerlos elimine los trayectos primero!");
						}
			});	
		}
	});

}

