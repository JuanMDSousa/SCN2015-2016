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

Nombre: Trayecto.js
Diseñador: Jhonny Vielma
Programador: Jhonny Vielma
Fecha: Agosto de 2012
Descripción:  
	Este archivo contiene los códigos javascript necesarios y particulares
	del módulo Pensum, debe ser incluido en todas las vistas de este
	módulo. Contiene básicamente validaciones y configuraciones iniciales
	para llevar a cabo las acciones propias de este módulo tales como 
	agregar, modificar, eliminar, cosultar y listar trayectos

 * * * * * * * * Cambios/Mejoras/Correcciones/Revisiones * * * * * * * *
Diseñador - Programador /   Fecha   / Descripción del cambio
---                         ----      ---------

 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/


/*********************************************************************************************/

function validarFormularioTrayecto(){

		
	$(function(){
		
		jQuery.validator.addMethod("lettersonly", function(value, element) {
			return this.optional(element) || /^[A-Za-z ()áéíóú]+$/i.test(value);
		}, "Solo letras");
		
        $('#frmTrayecto').validate({
            rules :{
                numTrayecto : {
                    required : true,
                    number : true
                },
                certificado : {
                    required : true,
                    minlength : 3,
                    maxlength : 150,
                    lettersonly: true 
                },
                minCredito : {
                    required : true,
                    number : true
                }
            },
            messages : {
                numTrayecto : {
                    required : "Este campo es obligatorio",
                    number    : "Debe ser numerico"
                },
                certificado : {
					lettersonly: "Introduzca solo letras de la a 'A' la 'z' ",
                    required : "Debe ingresar un certificado, de no tener coloque (No Posee)",
                    minlength : "EL certificado debe poseer minimo 3 caracteres",
                    maxlength : "EL certificado puede tener solo un maximo de 150 caracteres"
                },
                minCredito : {
                    required : "Debe ingresar un min Credito de no poseer coloque (0)",
                     number    : "Debe ser numerico"
                }
            }
        });    
    });	
	
}






/**********************************************************************************************/

/* 	El $(document).ready permite hacer modificaciones y cargar elementos
 *  en la hoja de estilo despues de cargar el scrip de la pagina.
 * */
$(document).ready(function (){
	cargarFuncionEliminarTrayecto();
	
	if (pensum_accion == 'administrar')
		obtenerTrayectos($("#codigo").val());
	
	$("#agregartrayectoajaxp").click(function (){ 
		alert('entro');
	});
});  //final del $(document).ready()
	
/*************************************************************************************/

/* 	Función que permite obtener desde el servior la lista de trayectos de un pensum
 * 	mediante una consulta ajax que que permite traer la informacion sin moverme de 
 * 	la pagina, en caso de ser exitosa la busqueda de informacion en el servidor la funcion
 * 	llama a mostrarTrayectosEnPantalla() que se encargara de mostar la informacion
 * 	a la vista o pantalla.
 * 	Variables de entrada:
 * 		codigo: Codigo del pensum.
 * 	Ejemplos: 
 * 		obtenerTrayectos("2");
 */
function obtenerTrayectos(cod_pensum){
	
	$.ajax({                 //llamada ajax
		type:"post",
		dataType: "json",
		url: "index.php",
		data:{  m_modulo:"pensum",             //parámetros
				m_accion:"listarT",
				m_vista:"trayectoListar", 
				m_formato:"json",
				codigo: cod_pensum
				},
		success: mostrarTrayectosEnPantalla,
		error: function(data){ 
					alert("Error de comunicación con el servidor");
				}
	});		
	
}
/**********************************************************************************************/

/* 	Permite cargar la lista de trayectos de un pensum  en especifico en la pantalla.
 * 	Variables de entrada:
 * 		data: Lista de trayectos la cual se mostrara por pantalla. 
 * 	Ejemplo:
 * 		mostrarTrayectosEnPantalla(trayectos[]);	
 */
function mostrarTrayectosEnPantalla(data){
	$("#trayectos > tbody").html("");
	usuario= $("#usuario").val();

	for (i=0; i < data.cantidad; i++){
		//creación del tr/td del trayecto
		var h = $("<tr><td id='trayecto' codigo=" + data.trayectos[i].codigo  + "></td></tr>")
		.appendTo("#trayectos").children();
		
		//creación del Div del título del trayecto
		var d = $("<div id='titulotrayecto_"+ data.trayectos[i].numero +"'></div>")
		.css({"height":"40px",
			  "background-color":"#E5E5E5",
			  "border-bottom":"1px solid #fff",
			  "position":"relative",
			  "display":"block"
			})
		.html("");
		d.appendTo(h);
		
		//Accion que permite cambiar el color del tr de trayecto de color al colocar el 
		//puntero por el trayecto.
		$(d).hover(
			function(e){
				$(this).css({"background-color": "cyan"});
			},
			function(e){
				$(this).css({"background-color": "#E6E6FA"});
			}
		);
			  				
		var t = $("<table></table>").css({"height":"100%",
			  "margin":"0px 20px 10px 20px",
			  "padding-top":"10px",
			  "text-align":"center",
			  "border":"0px solid black",
			  "display":"block"
			});
		//crear fila
		var f = $("<tr></tr>").css({"width":"100%"});
		//crear columna número de trayecto
		var c = $("<td class='titulotrayecto' codigo='" + data.trayectos[i].codigo + "'></td>").css({"width":"10%"}).html("<a>Trayecto "+data.trayectos[i].numero + "</a>");
		c.appendTo(f);
		//crear columna título del trayecto
		var c = $("<td class='titulotrayecto' codigo='" + data.trayectos[i].codigo + "'></td>").css({"width":"50%"}).html("Certificado: "+data.trayectos[i].certificado);
		c.appendTo(f);

		var c = $("<td class='titulotrayecto' codigo='" + data.trayectos[i].codigo + "'></td>").css({"width":"30%"}).html("N° de unidades de Crédito "+data.trayectos[i].canUnidades);
		c.appendTo(f);
		
		//botón eliminar trayecto
		if (usuario=="docente"){
			var c = $("<td></td>").css({"width":"7%"}).html("<a id='eliminarTrayecto' codigo='"+data.trayectos[i].codigo+"'><img src='base/imagenes/Delete.png' alt='Ver' class='icono_pequenio' title = 'Eliminar Trayecto'/></a>");
			c.appendTo(f);
		}	
		//botón consultar trayecto
		var c = $("<td></td>")
			.css({"width":"7%"})
			.html("<a class='iconostrayecto' href='javascript:agregarVerModificarTrayecto(" + data.trayectos[i].codigo + ","+"\"mostrar\"" +",\"" + data.trayectos[i].codPensum + "\");'><img src='base/imagenes/lupita.png' alt='Ver' class='icono_pequenio' title = 'Mostrar Trayecto'/></a>");
		c.appendTo(f);
		//botón modificar trayecto		
		if (usuario=="docente"){
			var c = $("<td></td>").css({"width":"7%"}).html("<a class='iconostrayecto' href='javascript:agregarVerModificarTrayecto(" + data.trayectos[i].codigo + ","+"\"modificar\"" +",\"" + data.trayectos[i].codPensum + "\");'><img src='base/imagenes/Modify.png' alt='Ver' class='icono_pequenio' title = 'Modificar Trayecto'/></a>");
			c.appendTo(f);
		}
		f.appendTo(t);

		$("#titulotrayecto_" +data.trayectos[i].numero ).html(t);

		
		//creación del div de la información del trayecto
		$("<div id='uniCurricular_" + data.trayectos[i].codigo +"'></div>")
		.css({"height":"100%",
			  "background-color":"#ADD8E6",
			  "border-bottom":"1px solid #fff",
			  "position":"relative",
			  "display":"none"
			})
		.html("Lista de unidades curriculares aún no cargada")
		.appendTo(h);



		
		obtenerUnidadesCurriculares ($("#codigo").val(),data.trayectos[i].codigo, 
										"uniCurricular_" + data.trayectos[i].codigo);
	
	
	}
		
}

/**********************************************************************************************/

/*	Función ajax que le anexa al botón eliminar trayecto (eliminarTA) la programación
* 	necesaria para hacer la eliminación de un trayecto en especifico. se le debe anexar 
* 	el codigo del  trayecto a la construccion del boton.
* 	Variables de entrada:
* 		No pose.
* 	Ejemplo:
* 		Al cargar la funcion: cargarFuncionEliminarTrayecto();
* 		Al cosntruir el boton: <a id='elimarTA' codigo='"+data.trayectos[i].codigo+"'>
* 									<img src='base/imagenes/Delete.png' alt='Ver' 
* 									class='icono_pequenio' title = 'Eliminar Trayecto'/>
* 								</a>
*/
function cargarFuncionEliminarTrayecto(){
	
	$("table").delegate("#eliminarTrayecto","click",function (){
		if (confirm("¿Está seguro que desea eliminar el Trayecto cuyo código es " 
								+ $(this).attr('codigo') + "?")){
			$.ajax({                 //llamada ajax
				type:"post",
				dataType: "json",
				url: "index.php",
				data:{  m_modulo:"pensum",             //parámetros
						m_accion:"eliminarT", 
						m_vista:"trayectoEliminar", 
						m_formato:"json",
						codigo: $(this).attr('codigo')
						},
				success: function(data){  
								if (data == "1"){
									obtenerTrayectos($("#codigo").val());						
									alert ("Trayecto eliminado con exito")
								}else
									alert ("Error al eliminar el trayecto");  
						},
				error: function(data){ 
							alert("Error de comunicación con el servidor, revise si el trayecto no contiene unidades curriculares, de poserlas elimine primero las unidades curriculares");
						}
			});	
		};
		this.preventDefault();
		
	});
}

/**************************************************************************************/

/* 	Función que permite crear el div y cargar el formulario de trayecto donde
 * 	se llenarán los datos ya sea para agregar, modificar o mostrar; De ya 
 * 	existir el div y el dialogo creado la funcion llama directamente a 
 * 	administrar_trayecto(), pasandole por parametros el codigo, el codigo del 
 * 	pensum y la accion antes pasada a dicha funcion.
 * 	variables de entrada: 
 * 		codigo: Codigo del trayecto de ser mostrar o modificar, si es agregar
 * 				dicho parametro se pasara en vacio.
 * 		codPensum: Codigo del pensum al que pertenece el trayecto.
 * 		accion: Accion a ejecutar ya sea (agregar,modificar,mostrar).
 * 	Ejemplo:
 * 		agregarVerModificar("","agregar","1");
 * 		agregarVerModificar("1","mostrar","1");
 * 		agregarVerModificar("1","modificar""1");
 * */
function agregarVerModificarTrayecto(codigo,accion,codPensum){
		$('#dialogoTrayecto').remove();
		$("<div id='dialogoTrayecto'></div>").appendTo("body");
		$("#dialogoTrayecto").load("modulos/pensum/vista/html5/JavaScript/dialogoTrayecto.php",
					 function () { administrarTrayecto(codigo,accion,codPensum); }
				);
}

/************************************************************************************/

/*	Funcion que permite ejecutar una serie de acciones dependiendo del parametro
 * 	accion que le sea pasado agregar, modificar o mostrar. esta funcion ejecutara las
 * 	respectivas aciones para que la accion solicitada se ejecute con exito.
 * 	Varibles de entrada: 
 * 		codigo: Codigo del trayecto el cual se quiere modificar o mostrar, de la accion
 * 				ser agregar el parametro codigo se pasara en vacio.
 * 		accion: Accion que se desea ejecutar ya sea mostar, agregar o modificar.
 * 		codPensum: Codigo del pensum al cual pertenece el trayecto. 
 * 	Ejemplo:
 * 		administrarTrayecto("2","mostrar","1");
 * 		administrarTrayecto("2","modificar","1");
 * 		administrarTrayecto("","agregar","1");
 */
function administrarTrayecto(codigo,accion,codPensum){
	validarFormularioTrayecto();
	if (accion == "agregar"){ // condicion de lineas que se ejecutaran segun la accion
		configurarDialogoTrayecto(accion);
		montarInformacionTrayecto("","","");
		mostrarDialogoTrayecto(accion,codPensum,codigo);
	}else if (accion== "mostrar"){
		buscarInformacionTrayecto(codigo);
		configurarDialogoTrayecto(accion);
		mostrarDialogoTrayecto(accion,codPensum,codigo);
	}else if (accion=="modificar"){
		buscarInformacionTrayecto(codigo);
		configurarDialogoTrayecto(accion);
		mostrarDialogoTrayecto(accion,codPensum,codigo);	
	}
	
}
/*************************************************************************************/

/*	Función que permite montar información en el formulario del trayecto ya sea para
*  	agregar un trayecto, modificarlo o consultarlo. Esta función permite montar dicha 
* 	información pasada por parámetro en los imput del formulario del trayecto.
*		Variables de entrada:
*  			numTrayecto: Numero de trayecto.
*  			certificado: Certificado del trayecto.
* 			minCredito: Mínimo de crédito del trayecto.
*	 	Ejemplo:
* 			montarInformacionTrayecto("2","TSU Informatica","0");
*  
 */

function montarInformacionTrayecto(numTrayecto,certificado,minCredito){
		$("#numTrayecto").val(numTrayecto);
		$("#certificado").val(certificado);
		$("#minCredito").val(minCredito);
}

/*******************************************************************************/
/* 	Función que permite configurar el dialogo del formulario del trayecto ,
 * 	para agregarlo,	mostrarlo o modificarlo. 	Esta 	función permitirá 
 * 	cambiarle el titulo y activar o desactivar los input del 	dialogo según
 *  sea la acción.
  		variables de entrada:
  			accion: Acción a ejecutar ya sea agregar,mostrar o modificar.
  		Ejemplos:
 			configurarDialogoTrayecto("mostrar");
  			configurarDialogoTrayecto("modificar");
  			configurarDialogoTrayecto("agregar");
 * */

function configurarDialogoTrayecto(accion){
	
	if (accion == "mostrar"){
		$("#dialogoTrayecto").attr("title", "Consultar trayecto");
		$("#numTrayecto").attr("disabled", true);
		$("#certificado").attr("disabled", true);
		$("#minCredito").attr("disabled", true);
	}else if (accion == "agregar"){
		$("#dialogoTrayecto").attr("title", "Agregar trayecto");
		$("#numTrayecto").attr("disabled",false);
		$("#certificado").attr("disabled", false);
		$("#minCredito").attr("disabled", false);
	}else if (accion == "modificar"){
		$("#dialogoTrayecto").attr("title", "Modificar trayecto");
		$("#numTrayecto").attr("disabled", false);
		$("#certificado").attr("disabled", false);
		$("#minCredito").attr("disabled", false);
	}	
}

/*************************************************************************************/

/* 	Función que permite buscar la información de un trayecto en especifico, el del código
 * 	pasado por parámetro. Esta función logra buscar la información de un trayecto mediante
 *  una consulta ajax sin necesidad de recargar la pagina, en caso de éxito la función 	llama
 *  a montar_infomacionTrayecto() y le pasa por parámetro los datos consultados al servidor.
 		Variables de entrada: 
  			codigo: código del trayecto a consultar.
 		Ejemplo:
  			buscarInformacionTrayecto("2");
 * */

function buscarInformacionTrayecto(codigo){
	
	$.ajax({                 //llamada ajax
			type:"post",
			dataType: "json",
			url: "index.php",
			data:{  m_modulo:"pensum",             //parámetros
					m_accion:"mostrarT", 
					m_vista:"trayectoMostrar", 
					m_formato:"json", 
					codigo: codigo,
					numTrayecto: $("#numTrayecto").val(),
					certificado:$("#certificado").val() ,
					minCredito: $("#minCredito").val()
					},
			success: function(datos){  
							montarInformacionTrayecto(datos.numero,datos.certificado,datos.minCredito);
					},
			error: function(data){ 
						alert("Error de comunicación con el servidor");
					}
		});	
	
}
/**************************************************************************/
/* 	Función que permite modificar un trayecto, el del código pasado por parámetro,
 *	esta función construye una consulta ajax que ira al servidor sin recargar la 
 * 	pagina y enviara por post el numero de trayecto,  el certificado y el minimo de 
 * 	credito que lo obtiene de el id de los imput del dialogo de trayecto; el codigo
 *  del trayecto a modificar y el codigo del pensum son pasados ambos tambn por POST
 * 	pero son los parametros de entrada de la funcion.
 		Variables de entrada:
  			codPensum: Código del pensum al que pertenece el trayecto.
  			codigo: Código del trayecto a modificar.
  		Ejemplo:
  			modificarTrayecto("2","1"); 

*/

function modificarTrayecto(codPensum,codigo){
	
	$.ajax({                 //llamada ajax
			type:"post",
			dataType: "json",
			url: "index.php",
			data:{  m_modulo:"pensum",             //parámetros
					m_accion:"modificarT",
					m_vista:"trayectoModificar", 
					m_formato:"json",
					codPensum: codPensum,
					numTrayecto: $("#numTrayecto").val(),
					certificado:$("#certificado").val() ,
					codigo: codigo,
					minCredito: $("#minCredito").val()
					},
			success: function(data){  
							if (data == "1"){
								obtenerTrayectos(codPensum);
								alert ("Trayecto Modificado con exito")
							}
							else
								alert ("Error al Modificar el trayecto");  
					},
			error: function(data){ 
						alert("Error de comunicación con el servidor");
					}
		});	
	
}
/******************************************************************************/

/*	Función que permite agregar un trayecto, esta 	función construye una consulta
 *  ajax que ira al servidor sin recargar la pagina y 	enviara por POST el numero
 *  de trayecto, certificado y mínimo de crédito  ambas obtenidas del id  de los 
 * 	imput del formulario del trayecto y el código del pensum pasado por parámetro.
 		Variables de entrada:
 			codPensum: Codigo del pensum al cual pertenece el nuevo trayecto.
  		Ejemplo: agregarTrayecto(“2”);
*/
function agregarTrayecto(codPensum){
	$.ajax({                 //llamada ajax
			type:"post",
			dataType: "json",
			url: "index.php",
			data:{  m_modulo:"pensum",             //parámetros
					m_accion:"agregarT", 
					m_vista:"trayectoAgregar", 
					m_formato:"json", 
					codigo: codPensum,
					numTrayecto: $("#numTrayecto").val(),
					certificado:$("#certificado").val() ,
					minCredito: $("#minCredito").val()
					},
			success: function(data){  
							if (data == "1"){
								obtenerTrayectos(codPensum);
								alert ("Trayecto Agregado con exito")
							}
							else
								alert ("Error al agregar el trayecto");  
					},
			error: function(data){ 
						alert("Error de comunicación con el servidor");
					}
		});
	
}
/*******************************************************************************/
/* Funcion que permite mostrar el dialogo de agregar, mostrar o modificar
 * parametros de entrada: accion a realizar mostrar, agregar o modificar,
 * 						  codigo del pensum al que perteece el trayecto y
 * 						  codigo del pensum  modificar o mostrar.
 * */
 
function mostrarDialogoTrayecto(accion,codPensum,codigo){ 
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
				var form = $("#frmTrayecto");
				
				if (form.valid() == true){
					modificarTrayecto(codPensum,codigo);
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
				var form = $("#frmTrayecto");
				
				if (form.valid() == true){
					agregarTrayecto(codPensum);
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
		
	$('#dialogoTrayecto').dialog({
		autoOpen: false,
		height: 280,
		width: 450,
		modal: true,
		resizable: true,
		buttons: botones
	});
		
	$('#dialogoTrayecto').dialog('open');


}




