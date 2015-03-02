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

Nombre: UniCurricular.js
Diseñador: jhonny vielma
Programador: jhonny vielma
Fecha: enero de 2014
Descripción:  
	Este archivo contiene los códigos javascript necesarios y particulares
	del módulo Instituto, debe ser incluido en todas las vistas de este
	módulo. Contiene básicamente validaciones y configuraciones iniciales
	para llevar a cabo las acciones propias de este módulo tales como 
	agregar, modificar, eliminar, cosultar y listar trayectos

 * * * * * * * * Cambios/Mejoras/Correcciones/Revisiones * * * * * * * *
Diseñador - Programador /   Fecha   / Descripción del cambio
---                         ----      ---------

 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/


function validarFormularioUnidades(){

		
	$(function(){
		
		jQuery.validator.addMethod("lettersonly", function(value, element) {
			return this.optional(element) || /^[A-Za-z ()áéíóú]+$/i.test(value);
		}, "Solo letras");
		
        $('#frmunidades').validate({
            rules :{
				notMaximaA : {
                    required : true,
                    number : true
                },
				notMinimaA : {
                    required : true,
                    number : true
                },
				durSemanasA : {
                    required : true,
                    number : true
                },
				htaA : {
                    required : true,
                    number : true
                },
				htiA : {
                    required : true,
                    number : true
                },
                codUniMinisterioA : {
                    required : true,
                    minlength : 2,
                    maxlength : 20
                },
                nombreA : {
                    required : true,
                    minlength : 2,
                    maxlength : 100 
                },
                uniCreditoA : {
                    required : true,
                    number : true
                }
            },
            messages : {
				durSemanasA : {
                    required : "Este campo es obligatorio",
                    number    : "Debe ser numerico"
                },
                htaA : {
                    required : "Este campo es obligatorio",
                    number    : "Debe ser numerico"
                },
                htiA : {
                    required : "Este campo es obligatorio",
                    number    : "Debe ser numerico"
                },
				notMinimaA  : {
                    required : "Este campo es obligatorio",
                    number    : "Debe ser numerico"
                },
                notMaximaA : {
                    required : "Este campo es obligatorio",
                    number    : "Debe ser numerico"
                },
                codUniMinisterioA : {
                    required : "Debe ingresar un codigo",
                    minlength : "EL codigo  debe poseer minimo 2 caracteres",
                    maxlength : "EL codigo puede tener solo un maximo de 20 caracteres"
                },
                nombreA : {
                    required : "Debe ingresar un nombre",
                    minlength : "EL nombre  debe poseer minimo 2 caracteres",
                    maxlength : "EL nombre puede tener solo un maximo de 100 caracteres"
                },
                uniCreditoA : {
                    required : "minimo de unidades de crédito, no puede estar vacio ",
                     number    : "Debe ser numerico"
                }
            }
        });    
    });	
	
}


/* 	Función que permite obtener desde el servidor la lista de unidades de crédito
 * 	de un trayecto 	mediante una consulta ajax que permite traer la información sin
 * 	moverme de la pagina, en caso de ser exitosa la búsqueda de información en el 
 * 	servidor la función llama a cargarUnidadesCurricularesEnPantalla(unidades[],id_div)
 *  que se encargara de mostrar la información a la vista o pantalla.
  		Variables de entrada:
  			codigo: Código del trayecto.
			id_div: Identificar del div donde se montara la información.
  		Ejemplos: 
  			obtenerUnidadesCurriculares("1","uniCurrcular_0");
 */
 
function obtenerUnidadesCurriculares(codigo_pensum,codigo_trayecto,id_div){
	$("#" + id_div).html("cargando");
	
	$.ajax({                 //llamada ajax
		type:"post",
		dataType: "json",
		url: "index.php",
		data:{  m_modulo:"pensum",             //parámetros
				m_accion:"listarUC",
				m_vista:"unidadesListar", 
				m_formato:"json",
				codTrayecto: codigo_trayecto,
				codPensum: codigo_pensum
				},
		success: function (data){
						cargarUnidadesCurricularesEnPantalla(data,id_div);
				},
		error: function(data){ 
					alert("Error de comunicación con el servidor en obtener unidades curriculares");
				}
	});		
}

/*****************************************************************************************/

/*	Función que permite montar información en el formulario de unidades curriculares ya sea 
 * 	para agregar una 	unidad curricular, modificarla o consultarla. Esta función permite 
 * 	montar dicha información pasada por parámetro en los imput del formulario de la unidad
 *  curricular.
  		Variables de entrada:
  			codMinisterio: Código del ministerio de la unidad.
  			nombre: Nombre de la unidad curricular.
  			tipo: Tipo de unidad curricular.
			uniCredito: Unidades de crédito de la unidad curricular.
			hti: Horas de trabajo independiente del estudiante.
			hta: Horas de trabajo con el docente del estudiante.
			durSemanas: Duración en semanas de la unidad curricular.
			notMinima:  Nota mínima aprobatoria de la unidad.
			notMaxima: Nota máxima con la que se puede aprobar la unidad
 	 	Ejemplo:
 			montarInformacionUnidad("D45E","Matemática","C","12","5","7","12","12","20").
*/

function montarInformacionUnidad(codMinisterio,nombre,tipo,uniCredito,hti,hta,durSemanas,notMinima,notMaxima){
		
	$("#codUniMinisterioA").val(codMinisterio);
	$("#nombreA").val(nombre);
	$("#tipoA").val(tipo);
	$("#uniCreditoA").val(uniCredito);
	$("#htiA").val(hti);
	$("#htaA").val(hta);
	$("#durSemanasA").val(durSemanas);
	$("#notMinimaA").val(notMinima);
	$("#notMaximaA").val(notMaxima);
}
 
 /*******************************************************************************/
/*	Función que permite configurar el dialogo del formulario de unidades curriculares,
* 	para agregarla, mostrarla o modificarla. Esta función permitirá cambiarle el titulo
*  	y activar o desactivar los 	input del dialogo según sea la acción.
  		variables de entrada:
  			accion: Acción a ejecutar ya sea agregar,mostrar o modificar.
  		Ejemplos:
 			configurar_diialogo_unidad("mostrar");
  			configurar_diialogo_unidad("modificar");
  			configurar_diialogo_unidad("agregar");
*/
function configurarDialogoUnidad(accion){
	
	if (accion == "mostrar"){
		$("#dialogoUnidad").attr("title", "Consultar unidad curricular");
		$("#codUniMinisterioA").attr("disabled", true);
		$("#nombreA").attr("disabled", true);
		$("#tipoA").attr("disabled", true);
		$("#uniCreditoA").attr("disabled", true);
		$("#htiA").attr("disabled", true);
		$("#htaA").attr("disabled", true);
		$("#durSemanasA").attr("disabled", true);
		$("#notMinimaA").attr("disabled", true);
		$("#notMaximaA").attr("disabled", true);
	}
	
	if (accion == "agregar"){
		$("#dialogoUnidad").attr("title", "Agregar unidad curricular");
		$("#codUniMinisterioA").attr("disabled", false);
		$("#nombreA").attr("disabled", false);
		$("#tipoA").attr("disabled", false);
		$("#uniCreditoA").attr("disabled", false);
		$("#htiA").attr("disabled", false);
		$("#htaA").attr("disabled", false);
		$("#durSemanasA").attr("disabled", false);
		$("#notMinimaA").attr("disabled", false);
		$("#notMaximaA").attr("disabled", false);
	}
	
	if (accion == "modificar"){
		$("#dialogoUnidad").attr("title", "Modificar unidad curricular");
		$("#codUniMinisterioA").attr("disabled", false);
		$("#nombreA").attr("disabled", false);
		$("#tipoA").attr("disabled", false);
		$("#uniCreditoA").attr("disabled", false);
		$("#htiA").attr("disabled", false);
		$("#htaA").attr("disabled", false);
		$("#durSemanasA").attr("disabled", false);
		$("#notMinimaA").attr("disabled", false);
		$("#notMaximaA").attr("disabled", false);
	
	}
	
}
 
 /*************************************************************************************/
/*	Función que permite buscar la 	información de una unidad en especifico, la del código
 *  pasado por parámetro. Esta función logra buscar la información de una unidad mediante una
 *  consulta ajax sin necesidad de recargar la pagina, en caso de éxito la función 	llama a 
 * 	montar_infomacionUnidad() y le pasa por parámetro los datos consultados al servidor.
 		Variables de entrada: 
  			codigo: código de la unidad  a consultar.
 		Ejemplo:
  			buscar_informacionUnidad("2");
 **/
function buscarInformacionUnidad(codigo){
	
	$.ajax({                 //llamada ajax
			type:"post",
			dataType: "json",
			url: "index.php",
			data:{  m_modulo:"pensum",             //parámetros
					m_accion:"mostrarUC", 
					m_vista:"ucMostrar", 
					m_formato:"json", 
					codigo: codigo
					},
			success: function(datos){  
							montarInformacionUnidad(datos.codUnidad,datos.nombre,datos.tipo,datos.uniCredito,datos.hti,datos.hta,datos.durSemana,datos.notMinima,datos.notMaxima)
					},
			error: function(data){ 
						alert("Error de comunicación con el servidor en buscar informacion de unidad curricular");
					}
	});	
	
}
 
 /**************************************************************************************/

/* 	Función que 	permite ejecutar una serie de acciones dependiendo del parámetro acción
 *  que le 	sea pasado agregar, modificar o mostrar. Esta función ejecutara las respectivas
 *  acciones para que 	la acción solicitada se ejecute con éxito.
 		Variables de entrada: 
 			codigo: Código de la unidad curricular la cual se quiere modificar o 				mostrar, de la acción ser agregar el parámetro código se pasara en 				vacío.
 			accion: Acción que se desea ejecutar ya sea mostrar, agregar o |					modificar.
			CodPensum:Código del pensum al que pertenece la unidad curricular.
			CodTrayecto:Código del trayecto al que pertenece la unidad 					curricular.
 		Ejemplo:
  			administrarUnidades("2","mostrar","1","1");
  			administrarUnidades("2","modificar","1","1");
  			administrarUnidades("","agregar","1","1");
 */
 
 function administrarUnidades(codigo,accion,codPensum,codTrayecto){
	validarFormularioUnidades()
	if (accion == "agregar"){
		configurarDialogoUnidad(accion);
		montarInformacionUnidad("","","","","","","","","");
		mostrarDialogoUnidades(accion,codPensum,codigo,codTrayecto);
	}
	
	if (accion== "mostrar"){
		buscarInformacionUnidad(codigo);
		configurarDialogoUnidad(accion);
		mostrarDialogoUnidades(accion,codPensum,codigo,codTrayecto);
	}
	
	if (accion=="modificar"){
		buscarInformacionUnidad(codigo);
		configurarDialogoUnidad(accion);
		mostrarDialogoUnidades(accion,codPensum,codigo,codTrayecto);	
	}
	
}

/*******************************************************************************************/

/*	Función que permite crear el div y cargar el formulario de unidades curriculares donde
 *  se llenaran los datos ya sea para agregar, modificar o mostrar; De ya existir el div y
 *  el dialogo creado la función llama directamente a administrarUnidades(codigo,accion,codPensum,codTrayecto),
 *  pasándole por parámetros el código, la acción, el código del pensum y el código del trayecto al que pertenece
 *  la unidad curricular antes pasada a dicha función.

		 variables de entrada: 
  			codigo: código del pensum de ser mostrar o modificar, si es
			accion: Acción a ejecutar ya sea (agregar,modificar,mostrar). 					agregar dicho parámetro se pasara en vacío.
			CodPensum: código del pensum al que pertenece la unidad curricular.
			CodTrayecto: Código del trayecto al que pertenece la unidad 					curricular.
  			
  		Ejemplo:
  			agregarVerModificarUnidades("","agregar","1","1");
  			agregarVerModificarUnidades("1","mostrar","1","1");
  			agregarVerModificarUnidades("1","modificar","1","1");
 * */ 
 
function agregarVerModificarUnidades(codigo,accion,codPensum,codTrayecto){
	$('#dialogoUnidad').remove();
	$("<div id='dialogoUnidad'></div>").appendTo("body");
	$("#dialogoUnidad").load("modulos/pensum/vista/html5/JavaScript/dialogoUnidades.php",
		function () { administrarUnidades(codigo,accion,codPensum,codTrayecto); }
	);
}
 
 
/**************************************************************************/

/*	Función que permite modificar una unidad curricular, el del código pasado por
 *  parámetro, esta función construye una consulta ajax que ira al servidor sin 
 * 	recargar la pagina y enviara por POST los datos de modificar de la unidad 
 * 	curricular que lo obtiene de el id de los 	imput del dialogo de unidades 
 * 	curriculares; el código de la unidad curricular a modificar, el código del 
 * 	pensum y el codigo del trayecto son pasados ambos también por POST pero son los
 *  parámetros de entrada de la función.
 		Variables de entrada:
  			codPensum: Código del pensum al que pertenece la unidad curricular.
  			codigo: Código de la unidad curricular a modificar.
			CodTrayecto: Codigo del trayecto al que pertenece la unidad.
  		Ejemplo:
  			modificarUnidad("2","1","1"); 					 codigo del trayecto al que pertenece la unidad curricular.
*/ 
function modificarUnidad(codPensum,codigo,codTrayecto){
	
	$.ajax({                 //llamada ajax
			type:"post",
			dataType: "json",
			url: "index.php",
			data:{  m_modulo:"pensum",             //parámetros
					m_accion:"modificarUC", 
					m_vista:"ucModificar", 
					m_formato:"json", 
					codPensum: codPensum,
					codTrayecto: codTrayecto,
					codigo: codigo,
					codUniMinisterio: $("#codUniMinisterioA").val(),
					nombre: $("#nombreA").val() ,
					tipo: $("#tipoA").val(),
					hti: $("#htiA").val() ,
					hta: $("#htaA").val(),
					durSemanas: $("#durSemanasA").val(),
					uniCredito: $("#uniCreditoA").val(),
					notMinima: $("#notMinimaA").val(),
					notMaxima: $("#notMaximaA").val(),
					},
					
			success: function(data){  
							if (data == "1"){
								obtenerUnidadesCurriculares (codPensum,codTrayecto,"uniCurricular_" + codTrayecto);
								alert ("unidad Modificada con exito");
							}
							else
								alert ("Error al Modificar la unidad");  
					},
			error: function(data){ 
						alert("Error de comunicación con el servidor al modificar la unidad curricular");
					}
	});	

}

/******************************************************************************/

/*	Función que permite agregar una	unidad curricular, esta función construye una
 *  consulta ajax que ira al servidor sin 	recargar la pagina y enviara por POST
 *  los datos de la unidad curricular que son  	obtenidos del id  de los imput del 
 * 	formulario de unida curricular y, el código del pensum y codigo del trayecto  
 * 	pasado por parámetro.
 		Variables de entrada:
 			codPensum: Codigo del pemsum al que pertenece la unidad.
 			codTrayecto: Codigo del trayecto al que pertenece la unidad.
  		Ejemplo: agregarUnidad("2","2");
*/

function agregarUnidad(codPensum,codTrayecto){
	$.ajax({                 //llamada ajax
			type:"post",
			dataType: "json",
			url: "index.php",
			//m_modulo=pensum&m_accion=agregarUC&m_vista=ucAgregar&m_formato=json&codPensum=1&codTrayecto=1&codUniMinisterio=asdwdd&nombre=rgrsh&tipo=C&hti=7&hta=9&durSemanas=5&uniCredito=8&notMinima=10&notMaxima=11
			data:{  m_modulo:"pensum",             //parámetros
					m_accion:"agregarUC", 
					m_vista:"ucAgregar", 
					m_formato:"json", 
					codPensum:codPensum,
					codTrayecto: codTrayecto,
					codUniMinisterio: $("#codUniMinisterioA").val(),
					nombre: $("#nombreA").val() ,
					tipo: $("#tipoA").val(),
					hti: $("#htiA").val() ,
					hta: $("#htaA").val(),
					durSemanas: $("#durSemanasA").val(),
					uniCredito: $("#uniCreditoA").val(),
					notMinima: $("#notMinimaA").val(),
					notMaxima: $("#notMaximaA").val(),
					},
			success: function(data){  
							if (data == "1"){
								obtenerUnidadesCurriculares (codPensum,codTrayecto,"uniCurricular_" + codTrayecto);
								obtenerTrayectos($("#codigo").val());
								alert ("unidad Agregada con exito")
							}
							else
								alert ("Error al agregar la unidad");  
					},
			error: function(data){ 
						alert("Error de comunicación con el servidor en agregar unidad curricular");
					}
		});	
}
/*******************************************************************************/

/* Función que 	permite cargar la lista de unidades curriculares de un trayecto en
 * especifico en la pantalla.
  		Variables de entrada:
  			data: Lista de unidades  la cual se mostrara por pantalla.
			id_div : Id del div donde se cargaran dichas unidades.
  		Ejemplo:
  			cargarUnidadesCurricularesEnPantalla(unidades[],"unidades_0");
 */
function cargarUnidadesCurricularesEnPantalla(data, id_div){
	$("#" + id_div).css({"text-align":"center"}).html("No posee unidades curriculares");
	usuario= $("#usuario").val();
	
	var botonAgregar = "<a href='javascript:agregarVerModificarUnidades(\"" + "\","+"\"agregar\"" +",\"" +data.codPensum + "\",\"" + data.codTrayecto  + "\");'><img src='base/imagenes/icono_mas.GIF' alt='Ver' class='icono_pequenio' title = 'Agregar unidad curricular'/></a> ";
	if (data.cantidad > 0){
	
		//creación de la tabla que contiene las unidades curriculares
		var t = $("<table></table>").css({"height":"100%",
				  "margin":"0px 20px 10px 20px",
				  "padding-top":"10px",
				  "text-align":"center",
				  "background-color":"#ADD8E6",
				  "border":"0px solid black",
				  "display":"block"
				});
		var f = $("<tr></tr>").css({"width":"100%"});
		var c = $("<td></td>").css({"width":"20%"}).html("Nombre");
		c.appendTo(f);
		var c = $("<td></td>").css({"width":"10%"}).html("Unidades de crédito");
		c.appendTo(f);
		var c = $("<td></td>").css({"width":"10%"}).html("Nota aprobatoria");
		c.appendTo(f);
		var c = $("<td></td>").css({"width":"10%"}).html("Horas con el docente");
		c.appendTo(f);
		var c = $("<td></td>").css({"width":"10%"}).html("Duración de Semanas");
		c.appendTo(f);
		var c = $("<td></td>").css({"width":"10%"}).html("");
		c.appendTo(f);
		var c = $("<td></td>").css({"width":"10%"}).html("");
		c.appendTo(f);
		
		if (usuario=="docente"){
			var c = $("<td></td>").css({"width":"10%"}).html(botonAgregar);
			c.appendTo(f);
		}	
		f.appendTo(t);	
		for (var i = 0 ; i < data.cantidad;i++){
			//creación de la fila 
			var f = $("<tr></tr>").css({"width":"100%"});
		
			//creación de la columna donde se mostrará el nombre de la unidad curricular
			var c = $("<td></td>").css({"width":"20%"}).html(data.unidades[i].nombre);
			c.appendTo(f);
			//Código de la unidad curricular	
			var c = $("<td></td>").css({"width":"10%"}).html(data.unidades[i].uniCredito);
			c.appendTo(f);
		
			var c = $("<td></td>").css({"width":"10%"}).html(data.unidades[i].notaMinima+"/"+data.unidades[i].notaMaxima);
			c.appendTo(f);
			var c = $("<td></td>").css({"width":"10%"}).html(data.unidades[i].hta);
			c.appendTo(f);
			var c = $("<td></td>").css({"width":"10%"}).html(data.unidades[i].durSemana);
			c.appendTo(f);
			
			if (usuario=="docente"){
				var c = $("<td></td>").css({"width":"10%"}).html("<a id='elimarUC' codigo='"+data.unidades[i].codigo+"'><img src='base/imagenes/Delete.png' alt='Ver' class='icono_pequenio' title = 'Eliminar unidad curricular' /></a>");
				c.appendTo(f);
				var c = $("<td></td>").css({"width":"10%"}).html("<a href='javascript:agregarVerModificarUnidades(\"" +data.unidades[i].codigo+ "\","+"\"modificar\"" +",\"" + data.unidades[i].codPensum + "\",\"" + data.unidades[i].codTrayecto + "\");'><img src='base/imagenes/Modify.png' alt='Ver' class='icono_pequenio'  title = 'Modificar unidad curricular'/></a> ");
				c.appendTo(f);
			}
			var c = $("<td></td>").css({"width":"10%"}).html("<a href='javascript:agregarVerModificarUnidades(\"" +data.unidades[i].codigo+ "\","+"\"mostrar\"" +",\"" + data.unidades[i].codPensum + "\",\"" + data.unidades[i].codTrayecto + "\");'><img src='base/imagenes/lupita.png' alt='Ver' class='icono_pequenio'title = 'Mostrar unidad curricular' /></a> ");
			c.appendTo(f);
		
			f.appendTo(t);	
		
		}
	
		$("#" + id_div).html(t);
		$("#" + id_div + " tr").css({"border":"1px solid black"});
	}else 
		$("#" + id_div).html("No Posee Unidades curriculares Precione para agregar una --> " + botonAgregar);
}


/*******************************************************************************/

/*	Función que permite mostrar el dialogo que contiene el formulario de unidades 
 * 	curriculares ya sea para agregar, mostrar o modificar la información de la unidad
 *  curricular, esta función dependiendo de la acción configura los botones para que 
 * 	ejecute la acción correctamente y abre el dialogo configurado.
 		Variables de entrada:
 			accion: Acción a ejecutar ya sea modificar, agregar y mostrar.
  			codigo: Código de la unidad curricular a modificar o mostrar, en el 				caso de agregar este parameto de pasara vacío ("").
			codPensum: Código del pensum al que pertenece la unidad.
			CodTrayecto: Coodigo del trayecto al que pertenece la unidad.
 		Ejemplos:
  			mostrarDialogoUnidades("mostrar","2","1","1");
  			mostrarDialogoUnidades("modificar","2","1","1");
  			mostrarDialogoUnidades("agregar","2"," ","1");
**/
 
function mostrarDialogoUnidades(accion,codPensum,codigo,codTrayecto){
	
	$('#dialogoUnidad').dialog({
    autoOpen: false,
    height: 560,
    width: 450,
    modal: true,
    resizable: true,
    buttons: {
		Aceptar: function() {
			
			if (accion=="agregar"){
				jQuery.validator.setDefaults({
					debug: true,
					success: "valid"
				});
				var form = $("#frmunidades");
				
				if (form.valid() == true){
					agregarUnidad(codPensum,codTrayecto);
					$(this).dialog('close');
				}
				if (form.valid() == false){
					alert( "Formulario Invalido" );
				}
				
			}
		
			if (accion == "modificar"){
				jQuery.validator.setDefaults({
					debug: true,
					success: "valid"
				});
				var form = $("#frmunidades");
				
				if (form.valid() == true){
					modificarUnidad(codPensum,codigo,codTrayecto);
					$(this).dialog('close');
				}
				if (form.valid() == false){
					alert( "Formulario Invalido" );
				}
			}
			

		},
		Cancelar: function() {
			$(this).dialog('close');
			// Update Rating
        }
   }
  });
  
  $('#dialogoUnidad').dialog('open');
}

/**********************************************************************************************/

/*	Función ajax que le anexa al botón 	eliminar unidad curricular (elimarUC) la programación 
* 	necesaria para hacer la 	eliminación de una unidad curricular en especifico. se le debe anexar
* 	el código de  la unidad a la construcción del botón.
 		Variables de entrada:
 			No pose.
 		Ejemplo:
 			Al cargar la función: cargarFuncionEliminarUnidad();
 			Al construir el botón: 	<a 	id='elimarUC' codigo='1' >
										<im src='base/imagenes/Delete.png'
										 alt='Ver' class='icono_pequenio' 
										 title = 'Eliminar Unidad'/>
									</a>
*/

function cargarFuncionEliminarUnidad(){

	$("table").delegate("#elimarUC","click",function (){
		if (confirm("¿Está seguro que desea eliminar la unidad curricular cuyo código es " + $(this).attr('codigo') + "?")){
			$.ajax({                 //llamada ajax
				type:"post",
				dataType: "json",
				url: "index.php",
				data:{  m_modulo:"pensum",             //parámetros
						m_accion:"eliminarUC", 
						m_vista:"ucEliminar", 
						m_formato:"json",
						codigo: $(this).attr('codigo')
						},
				success: function(data){  
								if (data == "1"){
									obtenerTrayectos($("#codigo").val());						
									alert ("Unidad de credito eliminado con exito")
								}else
									alert ("Error al eliminar la unidad de credito");  
						},
				error: function(data){ 
							alert("Error de comunicación con el servidor al eliminar la unidad curricular");
						}
			});	
		};
		
		
	});
}
/*******************************************************************************/
/* El $(document).ready permite hacer modificaciones y cargar elementos en la hoja de estilo
 * despues de cargar el scrip de la pagina.
 * */

$(document).ready(function (){
	
	cargarFuncionEliminarUnidad();

});


