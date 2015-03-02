/*
 * * * * * * * * * * LICENCIA * * * * * * * * * * * * * * * * * * * * *

Copyright(C) 2012
Instituto Universtiario de Tecnolog�a Dr. Federico Rivero Palacio

Este programa es Software Libre y usted puede redistribuirlo y/o modificarlo
bajo los t�rminos de la versi�n 3.0 de la Licencia P�blica General (GPLv3)
publicada por la Free Software Foundation (FSF), es distribuido sin ninguna
garant�a. Usted debe haber recibido una copia de la GPLv3 junto con este
programa, sino, puede encontrarlo en la p�gina web de la FSF, 
espec�ficamente en la direcci�n http://www.gnu.org/licenses/gpl-3.0.html

 * * * * * * * * * * ARCHIVO * * * * * * * * * * * * * * * * * * * * *

Nombre: UniCurricular.js
Dise�ador: jhonny vielma
Programador: jhonny vielma
Fecha: enero de 2014
Descripci�n:  
	Este archivo contiene los c�digos javascript necesarios y particulares
	del m�dulo Instituto, debe ser incluido en todas las vistas de este
	m�dulo. Contiene b�sicamente validaciones y configuraciones iniciales
	para llevar a cabo las acciones propias de este m�dulo tales como 
	agregar, modificar, eliminar, cosultar y listar trayectos

 * * * * * * * * Cambios/Mejoras/Correcciones/Revisiones * * * * * * * *
Dise�ador - Programador /   Fecha   / Descripci�n del cambio
---                         ----      ---------

 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/


function validarFormularioUnidades(){

		
	$(function(){
		
		jQuery.validator.addMethod("lettersonly", function(value, element) {
			return this.optional(element) || /^[A-Za-z ()�����]+$/i.test(value);
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
                    required : "minimo de unidades de cr�dito, no puede estar vacio ",
                     number    : "Debe ser numerico"
                }
            }
        });    
    });	
	
}


/* 	Funci�n que permite obtener desde el servidor la lista de unidades de cr�dito
 * 	de un trayecto 	mediante una consulta ajax que permite traer la informaci�n sin
 * 	moverme de la pagina, en caso de ser exitosa la b�squeda de informaci�n en el 
 * 	servidor la funci�n llama a cargarUnidadesCurricularesEnPantalla(unidades[],id_div)
 *  que se encargara de mostrar la informaci�n a la vista o pantalla.
  		Variables de entrada:
  			codigo: C�digo del trayecto.
			id_div: Identificar del div donde se montara la informaci�n.
  		Ejemplos: 
  			obtenerUnidadesCurriculares("1","uniCurrcular_0");
 */
 
function obtenerUnidadesCurriculares(codigo_pensum,codigo_trayecto,id_div){
	$("#" + id_div).html("cargando");
	
	$.ajax({                 //llamada ajax
		type:"post",
		dataType: "json",
		url: "index.php",
		data:{  m_modulo:"pensum",             //par�metros
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
					alert("Error de comunicaci�n con el servidor en obtener unidades curriculares");
				}
	});		
}

/*****************************************************************************************/

/*	Funci�n que permite montar informaci�n en el formulario de unidades curriculares ya sea 
 * 	para agregar una 	unidad curricular, modificarla o consultarla. Esta funci�n permite 
 * 	montar dicha informaci�n pasada por par�metro en los imput del formulario de la unidad
 *  curricular.
  		Variables de entrada:
  			codMinisterio: C�digo del ministerio de la unidad.
  			nombre: Nombre de la unidad curricular.
  			tipo: Tipo de unidad curricular.
			uniCredito: Unidades de cr�dito de la unidad curricular.
			hti: Horas de trabajo independiente del estudiante.
			hta: Horas de trabajo con el docente del estudiante.
			durSemanas: Duraci�n en semanas de la unidad curricular.
			notMinima:  Nota m�nima aprobatoria de la unidad.
			notMaxima: Nota m�xima con la que se puede aprobar la unidad
 	 	Ejemplo:
 			montarInformacionUnidad("D45E","Matem�tica","C","12","5","7","12","12","20").
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
/*	Funci�n que permite configurar el dialogo del formulario de unidades curriculares,
* 	para agregarla, mostrarla o modificarla. Esta funci�n permitir� cambiarle el titulo
*  	y activar o desactivar los 	input del dialogo seg�n sea la acci�n.
  		variables de entrada:
  			accion: Acci�n a ejecutar ya sea agregar,mostrar o modificar.
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
/*	Funci�n que permite buscar la 	informaci�n de una unidad en especifico, la del c�digo
 *  pasado por par�metro. Esta funci�n logra buscar la informaci�n de una unidad mediante una
 *  consulta ajax sin necesidad de recargar la pagina, en caso de �xito la funci�n 	llama a 
 * 	montar_infomacionUnidad() y le pasa por par�metro los datos consultados al servidor.
 		Variables de entrada: 
  			codigo: c�digo de la unidad  a consultar.
 		Ejemplo:
  			buscar_informacionUnidad("2");
 **/
function buscarInformacionUnidad(codigo){
	
	$.ajax({                 //llamada ajax
			type:"post",
			dataType: "json",
			url: "index.php",
			data:{  m_modulo:"pensum",             //par�metros
					m_accion:"mostrarUC", 
					m_vista:"ucMostrar", 
					m_formato:"json", 
					codigo: codigo
					},
			success: function(datos){  
							montarInformacionUnidad(datos.codUnidad,datos.nombre,datos.tipo,datos.uniCredito,datos.hti,datos.hta,datos.durSemana,datos.notMinima,datos.notMaxima)
					},
			error: function(data){ 
						alert("Error de comunicaci�n con el servidor en buscar informacion de unidad curricular");
					}
	});	
	
}
 
 /**************************************************************************************/

/* 	Funci�n que 	permite ejecutar una serie de acciones dependiendo del par�metro acci�n
 *  que le 	sea pasado agregar, modificar o mostrar. Esta funci�n ejecutara las respectivas
 *  acciones para que 	la acci�n solicitada se ejecute con �xito.
 		Variables de entrada: 
 			codigo: C�digo de la unidad curricular la cual se quiere modificar o 				mostrar, de la acci�n ser agregar el par�metro c�digo se pasara en 				vac�o.
 			accion: Acci�n que se desea ejecutar ya sea mostrar, agregar o |					modificar.
			CodPensum:C�digo del pensum al que pertenece la unidad curricular.
			CodTrayecto:C�digo del trayecto al que pertenece la unidad 					curricular.
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

/*	Funci�n que permite crear el div y cargar el formulario de unidades curriculares donde
 *  se llenaran los datos ya sea para agregar, modificar o mostrar; De ya existir el div y
 *  el dialogo creado la funci�n llama directamente a administrarUnidades(codigo,accion,codPensum,codTrayecto),
 *  pas�ndole por par�metros el c�digo, la acci�n, el c�digo del pensum y el c�digo del trayecto al que pertenece
 *  la unidad curricular antes pasada a dicha funci�n.

		 variables de entrada: 
  			codigo: c�digo del pensum de ser mostrar o modificar, si es
			accion: Acci�n a ejecutar ya sea (agregar,modificar,mostrar). 					agregar dicho par�metro se pasara en vac�o.
			CodPensum: c�digo del pensum al que pertenece la unidad curricular.
			CodTrayecto: C�digo del trayecto al que pertenece la unidad 					curricular.
  			
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

/*	Funci�n que permite modificar una unidad curricular, el del c�digo pasado por
 *  par�metro, esta funci�n construye una consulta ajax que ira al servidor sin 
 * 	recargar la pagina y enviara por POST los datos de modificar de la unidad 
 * 	curricular que lo obtiene de el id de los 	imput del dialogo de unidades 
 * 	curriculares; el c�digo de la unidad curricular a modificar, el c�digo del 
 * 	pensum y el codigo del trayecto son pasados ambos tambi�n por POST pero son los
 *  par�metros de entrada de la funci�n.
 		Variables de entrada:
  			codPensum: C�digo del pensum al que pertenece la unidad curricular.
  			codigo: C�digo de la unidad curricular a modificar.
			CodTrayecto: Codigo del trayecto al que pertenece la unidad.
  		Ejemplo:
  			modificarUnidad("2","1","1"); 					 codigo del trayecto al que pertenece la unidad curricular.
*/ 
function modificarUnidad(codPensum,codigo,codTrayecto){
	
	$.ajax({                 //llamada ajax
			type:"post",
			dataType: "json",
			url: "index.php",
			data:{  m_modulo:"pensum",             //par�metros
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
						alert("Error de comunicaci�n con el servidor al modificar la unidad curricular");
					}
	});	

}

/******************************************************************************/

/*	Funci�n que permite agregar una	unidad curricular, esta funci�n construye una
 *  consulta ajax que ira al servidor sin 	recargar la pagina y enviara por POST
 *  los datos de la unidad curricular que son  	obtenidos del id  de los imput del 
 * 	formulario de unida curricular y, el c�digo del pensum y codigo del trayecto  
 * 	pasado por par�metro.
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
			data:{  m_modulo:"pensum",             //par�metros
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
						alert("Error de comunicaci�n con el servidor en agregar unidad curricular");
					}
		});	
}
/*******************************************************************************/

/* Funci�n que 	permite cargar la lista de unidades curriculares de un trayecto en
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
	
		//creaci�n de la tabla que contiene las unidades curriculares
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
		var c = $("<td></td>").css({"width":"10%"}).html("Unidades de cr�dito");
		c.appendTo(f);
		var c = $("<td></td>").css({"width":"10%"}).html("Nota aprobatoria");
		c.appendTo(f);
		var c = $("<td></td>").css({"width":"10%"}).html("Horas con el docente");
		c.appendTo(f);
		var c = $("<td></td>").css({"width":"10%"}).html("Duraci�n de Semanas");
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
			//creaci�n de la fila 
			var f = $("<tr></tr>").css({"width":"100%"});
		
			//creaci�n de la columna donde se mostrar� el nombre de la unidad curricular
			var c = $("<td></td>").css({"width":"20%"}).html(data.unidades[i].nombre);
			c.appendTo(f);
			//C�digo de la unidad curricular	
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

/*	Funci�n que permite mostrar el dialogo que contiene el formulario de unidades 
 * 	curriculares ya sea para agregar, mostrar o modificar la informaci�n de la unidad
 *  curricular, esta funci�n dependiendo de la acci�n configura los botones para que 
 * 	ejecute la acci�n correctamente y abre el dialogo configurado.
 		Variables de entrada:
 			accion: Acci�n a ejecutar ya sea modificar, agregar y mostrar.
  			codigo: C�digo de la unidad curricular a modificar o mostrar, en el 				caso de agregar este parameto de pasara vac�o ("").
			codPensum: C�digo del pensum al que pertenece la unidad.
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

/*	Funci�n ajax que le anexa al bot�n 	eliminar unidad curricular (elimarUC) la programaci�n 
* 	necesaria para hacer la 	eliminaci�n de una unidad curricular en especifico. se le debe anexar
* 	el c�digo de  la unidad a la construcci�n del bot�n.
 		Variables de entrada:
 			No pose.
 		Ejemplo:
 			Al cargar la funci�n: cargarFuncionEliminarUnidad();
 			Al construir el bot�n: 	<a 	id='elimarUC' codigo='1' >
										<im src='base/imagenes/Delete.png'
										 alt='Ver' class='icono_pequenio' 
										 title = 'Eliminar Unidad'/>
									</a>
*/

function cargarFuncionEliminarUnidad(){

	$("table").delegate("#elimarUC","click",function (){
		if (confirm("�Est� seguro que desea eliminar la unidad curricular cuyo c�digo es " + $(this).attr('codigo') + "?")){
			$.ajax({                 //llamada ajax
				type:"post",
				dataType: "json",
				url: "index.php",
				data:{  m_modulo:"pensum",             //par�metros
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
							alert("Error de comunicaci�n con el servidor al eliminar la unidad curricular");
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


