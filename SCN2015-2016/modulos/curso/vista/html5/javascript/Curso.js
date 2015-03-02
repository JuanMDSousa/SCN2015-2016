//alter database  bd_scnfinal SET DateStyle to 'sql,dmy'
/*
 * * * * * * * * * * LICENCIA * * * * * * * * * * * * * * * * * * * * *

Copyright(C) 2012
pensum Universtiario de Tecnología Dr. Federico Rivero Palacio

Este programa es Software Libre y usted puede redistribuirlo y/o modificarlo
bajo los términos de la versión 3.0 de la Licencia Pública General (GPLv3)
publicada por la Free Software Foundation (FSF), es distribuido sin ninguna
garantía. Usted debe haber recibido una copia de la GPLv3 junto con este
programa, sino, puede encontrarlo en la página web de la FSF, 
específicamente en la dirección http://www.gnu.org/licenses/gpl-3.0.html

 * * * * * * * * * * ARCHIVO * * * * * * * * * * * * * * * * * * * * *

Nombre: Curso.js
Diseñador:Geraldine Castillo, Juan De Sousa.
Programador:Geraldine Castillo, Juan De Sousa.
Fecha:03-07-2014 
Descripción:  
	Este es el javascript del módulo curso, encargado de todas las 
	llamadas AJAX, objetos DOM y validaciones de dicho módulo. 

 * * * * * * * * Cambios/Mejoras/Correcciones/Revisiones * * * * * * * *
Diseñador - Programador /   Fecha   / Descripción del cambio
   

 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/


/*
 * Función al cargar el javascript. 
 */

$(document).ready(function() {
	verificarListar();
	buscarEstudiantes();
});


permiso=new Per();

function verificarListar(){
	instituto= $('#codInstituto').val();
	buscarInstitutos();
	buscarPensum();
	
}

function buscarInstitutos(){
	var a=Array("m_modulo","instituto","m_accion","listar",
				"m_vista","Listar");

	ajaxMVC(a,succInstitutos,error);
}

function buscarPensum(){
	var a=Array("m_modulo","pensum","m_accion","listar"
				);

	ajaxMVC(a,succPensum,error);
}
function succPensum(data){
	if(data.estatus>0){
		pensum=data.pensum;
		montarPensum(pensum);
	}
	else 
		mostrarMensaje(data.mensaje,2);
}
function buscarPeriodos(){
	$("#nombrePeriodo").remove();
	$("#botonAgregar").remove();
	if ($('#Sinstitutos').val()=='null'){
		mostrarMensaje('Seleccione un Instituto para buscar los periodos',3);
	}
	if ($('#Spensum').val()=='null'){
		mostrarMensaje('Seleccione un Pensum para buscar los periodos',3);
	}
	if ($('#Sinstitutos').val()!='null'){
		$("#nombreInstituto").remove();
		cadena="<h5 id='nombreInstituto'>Instituto: <small>"+$('#Sinstitutos option:selected').html()+"</small></h5>"; 
		$(cadena).appendTo("#nombreI");

	}
	if ($('#Spensum').val()!='null'){
		$("#nombrePensum").remove();
		cadena="<h5 id='nombrePensum'>Pensum: <small>"+$('#Spensum option:selected').html()+"</small></h5>"; 
		$(cadena).appendTo("#nombreP");

	}

	if (($('#Sinstitutos').val()!='null') && ($('#Spensum').val()!='null')){
		var a=Array("m_modulo","periodo","m_accion","listarPIP",
				'codInstituto',$('#Sinstitutos').val(),
				'codPensum',$('#Spensum').val());

		ajaxMVC(a,succPeriodos,error);
	}
	
	

}
function succPeriodos(data){

	if(data.estatus>0){
		periodos=data.periodos;
		montarPeriodo(periodos);
	}
	else{
		$("#SP").remove();
			$('#menCurso').remove();
		$('#tTabla').remove();
		mostrarMensaje(data.mensaje,2);
	}
}
function montarPensum(pensum){
	cadena="";
	cadena+="<select class='selectpicker' onchange='buscarPeriodos()' id='Spensum'   data-live-search='true' data-size='auto'  title='Pensum'>";
	cadena+="<option value='null'>Seleccione Pensum</option>";
	for(var i=0;i<pensum.length;i++){
		pen=pensum[i];
		cadena+="<option value="+pen["codigo"]+">"+pen["nombre"]+" ("+pen["nom_corto"]+ ")</option>";
	}
	cadena+="</select>";
	$(cadena).appendTo("#selectPensum");
	activarSelect();
}

function montarPeriodo(periodo=null){
	$("#SP").remove();
	$('#menCurso').remove();
		$('#tTabla').remove();
	$("<div id='SP'></div>").appendTo("#selectPeriodo");
	cadena="";
	cadena+="<select class='selectpicker' onchange='buscarCursosPeriodo()' id='Speriodo'   data-live-search='true' data-size='auto'  title='Periodo'>";
	cadena+="<option value='null'>Seleccione Periodo</option>";
	if (periodo!=null){
		for(var i=0;i<periodo.length;i++){
			pe=periodo[i];
			if (pe['cod_estado']=='A'){
				estado='Abierto';
			}
			else 
				estado='Cerrado';	
			cadena+="<option value="+pe["codigo"]+">"+pe["fec_inicio"]+"--"+pe["fec_final"]+"("+estado+ ")";
			cadena+="</option>";
		}
	}
	cadena+="</select>";
	$(cadena).appendTo("#SP");
	activarSelect();
}
function buscarCursosPeriodo(){

		$("#codPeriodo").val($("#Speriodo").val());
		$("#nombrePeriodo").remove();
		cadena="<h5 id='nombrePeriodo'>Periodo: <small>"+$('#Speriodo option:selected').html()+"</small></h5>"; 
		$(cadena).appendTo("#periodoN");
		ca=$('#Speriodo option:selected').html();

		if (ca=='Seleccione Periodo'){
			$("#botonAgregar").remove();
			$('#menCurso').remove();
			$('#tTabla').remove();
		}else{
			ca= ca.split('(');
			ca= ca[1].split(')');
			estado=ca[0];
			$("#estPeriodo").val(estado);
			$("#botonAgregar").remove();
			if (estado=='Abierto'){
				if ((permiso.curso.insert)&&(permiso.curso.delete)&&(permiso.curso.update)){
					cadena="";
					cadena+="<button type='button' id='botonAgregar' onClick='configurarSeccion(\"dialogoSeccion\",\"Agregar Sección\",\"agregar\")' class='btn btn-success' data-toggle='modal' data-target='#dialogoSeccion'>";
					cadena+="Agregar Sección</button>";
					$(cadena).appendTo("#botonAgregarSeccion");
				}
			}
			buscarListar("");
		}

}
function succInstitutos(data){

	if(data.estatus>0){
		institutos=data.institutos;
		montarInstitutos(institutos);
	}
	else 
		mostrarMensaje(data.mensaje,2);
}

function montarInstitutos(institutos){

	cadena="";
	cadena+="<select class='selectpicker' onchange='buscarPeriodos()' id='Sinstitutos'   data-live-search='true' data-size='auto'   title='Instituto'>";
	cadena+="<option value='null'>Introduzca instituto</option>";
	for(var i=0;i<institutos.length;i++){
		instituto=institutos[i];
		cadena+="<option value="+instituto["codigo"]+">"+instituto["nombre"]+"</option>";
	}
	cadena+="</select>";
	$(cadena).appendTo("#selectInstituto");
	activarSelect();
	if ($("#codInstituto").val()!=""){
		$("#Sinstitutos").selectpicker('val',$("#codInstituto").val());
	}
}
/*
 * Función que activa el autocompletar de docentes.
 * 
 * Hace un ajax a la base de datos y se trae todos los docentes
 * que coincidan con el patron.
 * 
 * De encontrarse coincidencia, muestra una lista con las mismas.
 * 
 * De no encontrarse, muestra "No hay coincidencias" en el campo.
 * 
 * Usa la función propia del MVC "ajaxMVC" para ejecutar la llamada
 * y retornar la data resultante o el mensaje de no encontrar.
 */ 

function buscarDocentesA(){
	$(".docente").autocomplete({
			delay: 200,  //milisegundos
			minLength: 1,
			source: function( request, response ) {
				var a=Array("m_modulo","docente",
							"m_accion","buscarDocentes",
							"m_vista","listarDocentesAuto",
							"tipoB","autocompletar",
							"patron",request.term
							);
				ajaxMVC(a,function(data){  
							return response(data);  
						  },
						  function(data){
							return response([{"label": "Error de conexión", "value": {"nombreCorto":""}}]); 
					
						   }
						);


			},
			select: function (event, ui){
				$(this).val(ui.item.label);
				event.preventDefault();
				$("#docente"+$(this).attr("id")).val(ui.item.value);
			},
			focus: function (event, ui){
				$(this).val(ui.item.label);
				event.preventDefault();
				$("#docente"+$(this).attr("id")).val(ui.item.value);
			}		
	});
}

/*
 * Función que activa el autocompletar de estudiantes.
 * 
 * Hace un ajax a la base de datos y se trae todos los estudiantes
 * que coincidan con el patron.
 * 
 * De encontrarse coincidencia, muestra una lista con las mismas.
 * 
 * De no encontrarse, muestra "No hay coincidencias" en el campo.
 * 
 * Usa la función propia del MVC "ajaxMVC" para ejecutar la llamada
 * y retornar la data resultante o el mensaje de no encontrar.
 */ 


function buscarEstudiantes(){

$("#estudiante").autocomplete({
			delay: 200,  //milisegundos
			minLength: 1,
			source: function( request, response ) {
				var a=Array("m_modulo","estudiante",
							"m_accion","buscarE",
							"tipoB","autocompletar",
							"patron",request.term
							);
				ajaxMVC(a,function(data){  
							return response(data);  
						  },
						  function(data){
							return response([{"label": "Error de conexión", "value": {"nombreCorto":""}}]); 
					
						   }
						);


			},
			select: function (event, ui){
				$(this).val(ui.item.label);
				event.preventDefault();
				$("#codEstudiante").val(ui.item.value);
				$("#cursosDisponibles").remove();
				$(".panelCursos").remove();
				
				/* SOLUCION AL ERROR DE LA CADENA */
				cursosInscritos = "";
				cursosAprobados="";
				cursosCursados="";
				cursosRetirados="";
				cursosReIn="";
				cursosPreinscritos="";
				cursosReprobados="";
				

				$("<div class='cursos' id='cursosDisponibles'> </div>").appendTo('#cur');
				$("#cursosInscribir").remove();
				$("<div class='cursos' id='cursosInscribir'> </div>").appendTo('#cur1');
				listarCursosPasadosDisponibles(ui.item.value);

			},
			focus: function (event, ui){
				$(this).val(ui.item.label);
				event.preventDefault();
				$("#codEstudiante").val(ui.item.value);
			}	
	});
}

/*
 * Función que activa en los div con clase "cursos" la 
 * propiedad de sortable o "arrastrable".
 * 
 * Dentro de la misma valida si la unidad curricular está repetida.
 * 
 * Permite arrastrar elementos de un div hacia otro, aumentando o
 * disminuyendo el tamaño en el proceso.
 */ 


function arrastrarCursos(){
    $(".cursos").sortable({
    connectWith: '.cursos',
    opacity: 0.5,
    tolerance: 'pointer',
    placeholder: 'place_holder_element',
                helper: function(event, el) {
                    var myclone = el.clone();
                    $('body').append(myclone);
                    return myclone;
                },
                receive: function( event, ui ) {
					var list=$(this).sortable().attr("id");
					var elemento=ui.item.attr("id");
					if (list=="cursosInscribir"){
						aumentarDisminuirTamañoDiv("cursosInscribir",$("#"+elemento).height(),"+");
						if ($("#cursosDisponibles").height()>90)
						aumentarDisminuirTamañoDiv("cursosDisponibles",$("#"+elemento).height(),"-");

					}
					else {
						aumentarDisminuirTamañoDiv("cursosDisponibles",$("#"+elemento).height(),"+");
						if ($("#cursosInscribir").height()>90)
						aumentarDisminuirTamañoDiv("cursosInscribir",$("#"+elemento).height(),"-");
					}
                },
                stop:	function( event, ui ) {
                	var elemento=ui.item.attr("id");
                	var list=$(this).sortable().attr("id");
                	var idPadre=$("#"+elemento).parent();
                	if (list=="cursosDisponibles"  &&   idPadre[0]['id']=="cursosInscribir"){
                		valiUniCurRepetida(elemento);
                	}	
                }
            }).disableSelection();   
}

/*
 * Valida que el id que entra como parámetro en la función
 * no esté repetida.
 * 
 * Para esto revisa cada elemento dentro del hijo de #cursosInscribir.
 * 
 * Parametro de entrada:
 * 	id: id del elemento.
 */ 


function valiUniCurRepetida(id){
	var cursos=$('#cursosInscribir').children('div.cur');
	var elemento=$('#'+id).children('input.codUni');
	var elementoHi=elemento[0]['value'];
	var curso,cursosHi,cursoBiNi;
	var divCur,mensaje="";
	var uniCurr;
	for (var i=0;i<cursos['length'];i++){
		curso=cursos[i]['id'];
		if (curso!=id){
			cursosHi=$('#'+curso).children('input.codUni');
			cursoBiNi=cursosHi[0]['value'];
			if (elementoHi==cursoBiNi){
				uniCurr=$('#'+curso).children('div.uniCur');
				divCur=cursoInscrito(id);
				$('#'+id).remove();
				
				$(divCur).appendTo('#cursosDisponibles');

			
				aumentarDisminuirTamañoDiv('cursosInscribir',$("#"+id).height(),"-");
				
				aumentarDisminuirTamañoDiv('cursosDisponibles',85,"+");
				mensaje="La unidad curricular "+uniCurr[0]['textContent']+" ya existe en la tabla de ";
				mensaje+="cursos inscritos, si desea agregar este curso arrastre el anterior a cursos disponibles"
				mostrarMensaje(mensaje,3);

			}
			
		}
	}
}

/*
 * Hace una llamda AJAX para obtener los cursos
 * pasados disponibles para ese estudiante.
 * 
 * Recibe el código del estudiante y de resultar bien
 * la llamada AJAX, va a la función sccCursosPasadosDisponibles,
 * de no hacerlo va a la función error.
 * 
 * En ambos casos retorna la data resultante del AJAX como parámetro.
 * 
 * Parametro de entrada:
 * 	codEstudiante: código del estudiante.
 */ 

function listarCursosPasadosDisponibles(codEstudiante){
	var a=Array(	"m_modulo"		,	"curso",
			"m_accion"		,	"curDisCur",
			"codEstudiante"		,	codEstudiante);
				
	ajaxMVC(a,succCursosPasadosDisponibles,error);
}


/*
 * Declaración de variables globales.
 */ 
  
var cursosAprobados="";
var cursosCursados="";
var cursosRetirados="";
var cursosInscritos="";
var cursosReIn="";
var cursosPreinscritos="";
var cursosReprobados="";

/*
 * Función que se realiza si la llamada AJAX se ejecuta correctamente.
 * 
 * Si el estatus es mayor a 0, revisa los cursos agregados y
 * los remueve del div.
 * 
 * Luego los clasifica en sus nuevos estados.
 * 
 * Parametro de entrada:
 * 	datos: datos provenientes del AJAX.
 */ 

function succCursosPasadosDisponibles(datos){
	cadena="";
	if(datos.estatus>0){
		var cursos=datos.cursos;
		var cursoPasa= new Array();
		if (cursos != null){
			arrastrarCursos();
			var ind=0;

			
			for (var i=0;i<cursos.length;i++){
				console.log(cursos[i]['estado']);

				if (cursos[i]['estado']=="A"){
					cursosAprobados+=armarCurso(cursos[i],"retornar");
					cursoPasa[cursos[i]['cod_uni']]=cursos[i]['cod_uni'];
				}
				if (cursos[i]['estado']=="C"){
					cursosCursados+=armarCurso(cursos[i],"retornar");
					cursoPasa[cursos[i]['cod_uni']]=cursos[i]['cod_uni'];
				}
				if (cursos[i]['estado']=="I"){
					cursos[i]['nota']=null;
					cursosInscritos+=armarCurso(cursos[i],"retornar");
					cursoPasa[cursos[i]['cod_uni']]=cursos[i]['cod_uni'];
				}
				if (cursos[i]['estado']=="P"){
					cursos[i]['nota']=null;
					cursosPreinscritos+=armarCurso(cursos[i],"retornar");
					cursoPasa[cursos[i]['cod_uni']]=cursos[i]['cod_uni'];
				}
				/*
				 * Cursos disponibles.
				 */
				if (cursos[i]['estado']==null){
					if (cursos[i]['cod_uni'] != (cursoPasa[cursos[i]['cod_uni']])){
						armarCurso(cursos[i],"agregar");
						height=$("#cursosDisponibles").height() +50;
						$("#cursosDisponibles").height(height);
					}
				}
				
				/*
				 * Otros cursos.
				 */ 
				if (cursos[i]['estado']=="E")
					cursosRetirados+=armarCurso(cursos[i],"retornar");			
				if (cursos[i]['estado']=="N")
					cursosReIn+=armarCurso(cursos[i],"retornar");
				if (cursos[i]['estado']=="R")
					cursosReprobados+=armarCurso(cursos[i],"retornar");	
			}
	
			var curDis=$('#cursosDisponibles').children('div.cur');
			if (curDis['length']!=0) 
				aumentarDisminuirTamañoDiv('cursosDisponibles',85,"+");
			
			mostrarMensaje("Arrastre cursos disponibles a la lista de cursos a inscribir",4)
			$("#botonA").remove();	
			cadena="<div class='col-lg-6' id='botonA'></div>"
			$(cadena).appendTo("#CurrIns");

			cadena="<button type='button' onClick='inscribirEsCursos("+'succInE'+")' class='btn btn-success'>Inscribir cursos</button>";
			$(cadena).appendTo("#botonA");
			armarPanelesCursos();	
		}
		else 
			mostrarMensaje("No hay cursos ",2);	
	} 	
	else 
		mostrarMensaje(datos.mensaje,2);

}

/*
 * Construye el panel para mostrar las unidades
 * según la clasificación.
 * 
 * Recibe como parámetro el estatus de la unidad
 * curricular, la clasifica y coloca donde ha de ir.
 * 
 * Añade el panel creado dependiendo del estatus.
 * 
 * Parametro de entrada:
 * 	estatus: estatus del elemento.
 */
  
function infPanel(estatus){
	/*
	 * Remueve el elemento si es que existe ya.
	 */ 
	
	$("#infoCurso").remove();
	
	/*
	 * Crea el div que contendrá la información
	 * de la unidad curricular.
	 */
	
	$("<div class='well' id='infoCurso'></div>").appendTo(".informacioCursos");
	
	/*
	 * Construye el encabezado para mostrar las 
	 * unidades curriculares.
	 */
	 
	encabe1="<div class='row titulo stCur'>";
	encabe1+="<div class='col-lg-3'>";
	encabe1+="<h4>Unidad Curricular</h4></div>";
	encabe1+="<div class='col-lg-2'>";
	encabe1+="<h4>Nota</h4></div>";
	encabe1+="<div class='col-lg-2'>";
	encabe1+="<h4>Trayecto</h4></div>";
	encabe1+="<div class='col-lg-2'>"
	encabe1+="<h4>Sección</h4></div>";
	encabe1+="<div class='col-lg-3'>"
	encabe1+="<h4>Docente</h4></div></div>";
	
	/*
	 * A diferencia de la primera, esta
	 * no incluye nota.
	 * 
	 * Se usa para las materias retiradas,
	 * inscritas y reprobadas por inasistencia.
	 */ 

	encabe2="<div class='row titulo stCur'>";
	encabe2+="<div class='col-lg-3'>";
	encabe2+="<h4>Unidad Curricular</h4></div>";
	encabe2+="<div class='col-lg-3'>";
	encabe2+="<h4>Trayecto</h4></div>";
	encabe2+="<div class='col-lg-3'>"
	encabe2+="<h4>Sección</h4></div>";
	encabe2+="<div class='col-lg-3'>"
	encabe2+="<h4>Docente</h4></div></div>";			
	
	/*
	 * Clasifica según el estado (que entró como parámetro)
	 * y añade el elemento antes creado (dependiendo del estatus)
	 * al div con id "infoCurso".
	 * 
	 * También añade los cursos según el antes mencionado estatus.
	 * 
	 * De esta forma se construye cada panel para mostrar la 
	 * información.
	 */
	
	if (estatus=="A"){
		$(encabe1).appendTo("#infoCurso");
		$(cursosAprobados).appendTo("#infoCurso");
	}
	if (estatus=="C"){
		$(encabe1).appendTo("#infoCurso");
		$(cursosCursados).appendTo("#infoCurso");
	}
	if (estatus=="E"){
		$(encabe1).appendTo("#infoCurso");
		$(cursosRetirados).appendTo("#infoCurso");
	}
	if (estatus=="I"){
		$(encabe2).appendTo("#infoCurso");
		$(cursosInscritos).appendTo("#infoCurso");
	}
	if (estatus=="N"){
		$(encabe1).appendTo("#infoCurso");
		$(cursosReIn).appendTo("#infoCurso");
	}
	if (estatus=="P"){
		$(encabe2).appendTo("#infoCurso");
		$(cursosPreinscritos).appendTo("#infoCurso");
	}
	if (estatus=="R"){
		$(encabe1).appendTo("#infoCurso");
		$(cursosReprobados).appendTo("#infoCurso");
	}
}

/*
 * La función armar curso recibe como parámetro el
 * curso y el tipo de respuesta.
 * 
 * Arma un div con la información de dicho curso y según
 * el tipo de respuesta, lo agrega o retorna la cadena armada.
 * 
 * Parametros de entrada:
 * 	curso: curso en cuestión.
 * 	tipo: "agregar" o "retornar" para saber la acción a tomar.
 * 
 * Parámetro de retorno:
 * 	cadena: cadena armada, en caso de que el tipo sea "retornar"
 */

function armarCurso(curso,tipo){
	var cadena="";
	var nombre="";
	var col="";
	
	/*
	 * Se construye la cadena en cuestión.
	 */
	console.log(curso);
	cadena+="<div class='row cur' id='"+curso['codigo']+"' style='text-align:center;'>";
	cadena+="<div class='col-lg-3 uniCur stiloCruso'><h5>"+curso['uni_curr']+"</h5></div>";
	
	/*
	 * De haber nota, se coloca en la cadena y se define la variable col como 2.
	 * De lo contrario, solo se define la variable col como 3.
	 */
	
	if (curso['nota']!=null){
		cadena+="<div class='col-lg-2 nota stiloCruso'><h5>"+curso['nota']+"</h5></div>";
		col="2";
	}
	else 
		col="3";	
		
	/*
	 * Se usa la variable col para definir cuánto espacio usará
	 * el trayecto y sección dentro del div.
	 */	
		
	cadena+="<div class='col-lg-"+col+" trayecto stiloCruso'><h5>"+curso['trayecto']+"</h5></div>";
	cadena+="<div class='col-lg-"+col+" seccion stiloCruso'><h5>"+curso['seccion']+"</h5></div>";
	
	/*
	 * Si no hay docente asignado, coloca "Sin asignar".
	 * De lo contrario, el nombre del docente.
	 */
	
	if ((curso['nombre'] && curso['apellido'])==null)
		nombre="<h5>Sin asignar</h5>";
	else 
		nombre="<h5>"+curso['nombre']+" "+curso['apellido']+"</h5>";
	
	
	cadena+="<div class='col-lg-3 nombre stiloCruso'>"+nombre+"</div>";
	cadena+="<input type='hidden' class='codUni' value='"+curso['cod_uni']+"'>";
	cadena+="</div>";
	
	if (tipo=="agregar")
		$(cadena).appendTo('#cursosDisponibles');
	if(tipo=="retornar")
		return cadena;
}

/*
 * Función que construye cada uno de los botones en el
 * panel y los añade al elemento con clase "estudiantepanelescurso"
 */

function armarPanelesCursos(){
	
	/*
	 * Botón de aprobados.
	 * 
	 * Muestra las materias aprobadas por el estudiante.
	 */
	
	cadena="<div class='col-xs-9 col-md-9 col-lg-9 panelCursos'><button class='btn btn-success' onClick=\"infPanel('A')\" type='button' data-toggle='collapse'";
	cadena+="data-target='#collapseExample1' aria-expanded='false' aria-controls='collapseExample'";
	cadena+=" toggle-boolean='true'>";
	cadena+="  Aprobados </button> ";
	
	/*
	 * Botón de cursando.
	 * 
	 * Muestra las materias que está cursando el estudiante.
	 */
	
	cadena+="<button class='btn btn-primary' onClick=\"infPanel('C')\" type='button' data-toggle='collapse'";
	cadena+="data-target='#collapseExample1' aria-expanded='false' aria-controls='collapseExample'";
	cadena+=" toggle-boolean='true'>";
	cadena+="Cursando </button> ";
	
	/*
	 * Botón de retirados.
	 * 
	 * Muestra las materias retiradas por el estudiante.
	 */

	cadena+="<button class='btn btn-warning' onClick=\"infPanel('E')\" type='button' data-toggle='collapse'";
	cadena+="data-target='#collapseExample1' aria-expanded='false' aria-controls='collapseExample'";
	cadena+=" toggle-boolean='true'>";
	cadena+=" Retirados </button> ";
	cadena+"<br>";
	
	/*
	 * Botón de isncritos.
	 * 
	 * Muestra las materias inscritas por el estudiante.
	 */
	
	cadena+="<button class='btn btn-primary' onClick=\"infPanel('I')\" type='button' data-toggle='collapse'";
	cadena+="data-target='#collapseExample1' aria-expanded='false' aria-controls='collapseExample'";
	cadena+=" toggle-boolean='true'>";
	cadena+=" Inscritos </button> ";
	
	/*
	 * Botón de reprobados por inasistencia.
	 * 
	 * Muestra las materias que reprobó por inasistencia el estudiante.
	 */
	
	cadena+="<button class='btn btn-danger' onClick=\"infPanel('N')\"  type='button' data-toggle='collapse'";
	cadena+="data-target='#collapseExample1' aria-expanded='false' aria-controls='collapseExample'";
	cadena+=" toggle-boolean='true'>";
	cadena+=" Reprobados por inasistencia </button> ";
	
	/*
	 * Botón de preinscritos.
	 * 
	 * Muestra las materias preinscritas por el estudiante.
	 */
	
	cadena+="<button class='btn btn-primary' onClick=\"infPanel('P')\" type='button' data-toggle='collapse'";
	cadena+="data-target='#collapseExample1' aria-expanded='false' aria-controls='collapseExample'";
	cadena+=" toggle-boolean='true'>";
	cadena+=" Preinscritos </button> ";
	
	/*
	 * Botón de reprobados.
	 * 
	 * Muestra las materias reprobadas por el estudiante.
	 */
	
	cadena+="<button class='btn btn-danger' onClick=\"infPanel('R')\"  type='button' data-toggle='collapse'";
	cadena+="data-target='#collapseExample1' aria-expanded='false' aria-controls='collapseExample'";
	cadena+=" toggle-boolean='true'>";
	cadena+="  Reprobados</button>";
		
	cadena+="<div class='collapse informacioCursos' id='collapseExample1'>";
	cadena+="<div class='well' id='infoCurso'>";
	cadena+="</div> </div>";

	/*
	 * Agrega los elementos a la clase.
	 */
	
	$(cadena).appendTo(".estudiantePanelesCurso");
	

}

/*
 * Función que aumenta o disminuye el tamaño del div.
 * 
 * recibe como parámetro el div en cuestión,
 * la cantidad y el tipo.
 * 
 * Si el tipo es "+" o es "-" aumentará o disminuirá el tamaño.
 * 
 * Cant es el tamaño a aumentar o reducir.
 * 
 * Div es el div a aplicar los cambios.
 * 
 * Parámetro de entrada:
 * 	div: div del elemento.
 * 	cant: cantidad a agregar o reducir.
 * 	tipo: "+" o "-" para saber si se debe agregar o reducir.
 * 
 * Parámetro de retorno:
 * 	función de jQuery para aumentar o disminuir el tamaño.
 */


function aumentarDisminuirTamañoDiv(div,cant,tipo){
	jQuery("#"+div).css("height",function() {
		if (tipo=="+")
			return jQuery(this).height() +cant+"px";
		if (tipo=="-")
			return jQuery(this).height() +-cant+"px";
	});
}

/*
 * Inscribe un estudiante en un curso.
 * 
 * Recibe como parámetro el código del estudiante,
 * el código del curso en el que será inscrito y la función
 * que realizará si se realiza la inscripción.
 * 
 * Realiza un for de todos los elementos que tenga el div
 * #cursosInscribir y utiliza la función inscribirEst.
 * 
 * Parametro de entrada:
 * 	succInE: función a ejecutar en la llamada de AJAX.
 * 
 */

function inscribirEsCursos(succInE){
	var elemento= $('#cursosInscribir').children('div.cur');
	var codigoC;
	for (var i=0;i<elemento['length'];i++){
		codigoC=elemento[i]["id"];
		inscribirEst($("#codEstudiante").val(),codigoC,succInE);
	}
}

/*
 * Función que se realizará si la inscripción se realiza.
 * 
 * Si el estatus es mayor a 0, muestra un mensaje para el usuario y agrega dicho curso
 * a los cursos inscritos. Luego de eso, lo remueve del div
 * de cursos a inscribir.
 * 
 * De no ser así, muestra un mensaje para el usuario con el problema.
 * 
 * Parametro de entrada:
 * 	data: data procedente del AJAX.
 */

function succInE(data){
	if(data.estatus>0){
		mostrarMensaje(data.mensaje+cadenaDatosCursoMens(data.codCurso),1);
		cursosInscritos+=cursoInscrito(data.codCurso);
		aumentarDisminuirTamañoDiv("cursosInscribir",$("#"+data.codCurso).height(),"-");
		$("#"+data.codCurso).remove();
		
	}
	else 
		mostrarMensaje(data.mensaje,2);
}

/*
 * Función que obtiene todo el texto que contiene el div "curso".
 * 
 * Luego llama la función armarCurso que arma el div de curso
 * inscrito y lo retorna.
 * 
 * Parametro de entrada:
 * 	curso: id del elemento a obtener.
 * 
 * Parametro de retorno:
 * 	armarCurso: función que arma el curso.
 */

function cursoInscrito(curso){
	var cursoI= new Array();
	cursoI['codigo']=curso;
	var elemento=$("#"+curso).children('div.uniCur');
	var elementoHi=elemento[0]['textContent'];

	cursoI['uni_curr']=elementoHi;

	elemento=$("#"+curso).children('div.trayecto');
	elementoHi=elemento[0]['textContent'];

	cursoI['trayecto']=elementoHi;

	cursoI['nota']=null;

	elemento=$("#"+curso).children('div.seccion');
	elementoHi=elemento[0]['textContent'];

	cursoI['seccion']=elementoHi;

	elemento=$("#"+curso).children('div.nombre');
	elementoHi=elemento[0]['textContent'];

	cursoI['nombre']=elementoHi;
	cursoI['apellido']="";

	elemento= $('#'+curso).children('input.codUni');
	elementoHi=elemento[0]['value'];

	cursoI['cod_uni']=elementoHi;
	return armarCurso(cursoI,"retornar");

}

/*
 * Función que construye un mensaje para el usuario
 * mostrando los datos de un curso.
 * Recibe como parámetro el id del curso.
 * 
 * Retorna la cadena armada.
 * 
 * Parametro de entrada:
 * 	id: id del elemento.
 * 
 * Parametro de retorno:
 * 	cadena: cadena armada.
 */

function cadenaDatosCursoMens(id){
	cadena="";
	
	var elemento= $('#'+id).children('div.uniCur');
	var elementoHi=elemento[0]['textContent'];
	
	cadena+=" en el curso "+elementoHi;
	
	elemento= $('#'+id).children('div.trayecto');
	elementoHi=elemento[0]['textContent'];
	
	cadena+=" trayecto "+elementoHi;
	
	elemento= $('#'+id).children('div.seccion');
	elementoHi=elemento[0]['textContent'];
	
	cadena+=" sección "+elementoHi;
	
	elemento= $('#'+id).children('div.nombre');
	elementoHi=elemento[0]['textContent'];
	
	if (elementoHi!="Sin asignar")
		cadena+=" con el profesor "+elementoHi;

	return cadena;
}

/*
 * Función que valida si el campo con id "#(id parámetro)"
 * está vacío, de estarlo asigna '' al campo "#docente(id parámetro)"
 * 
 * Parametro de entrada:
 * 	id: id del elemento.
 */


function validarDocente(id){
	if($("#"+id).val() == '')
		$("#docente"+id).val('');
}

/*
 * Asigna la fecha en el campo #fecInicio.
 * 
 * Se usa para mostrar la fecha una vez seleccionada.
 * 
 * "datepicker" es un plugin de JQueryUI.
 */

function asignarFecha(){
	for ( var i=0;i< ($('#tablaUnidades >tbody >tr')).length;i++){
		$("#fecInicio"+i).datepicker('setDate',$("#fecInicio"+i).val( $("#fecInicio"+i).val()));
		$("#fecFinal"+i).datepicker('setDate',$("#fecFinal"+i).val( $("#fecFinal"+i).val()));		
	}	
}

/*
 * Función que se utiliza cuando una llamada ajax no puede
 * ser realizada. Recibe la data y muestra un mensaje 
 * al usuario.
 * 
 * Parametro de entrada:
 * 	data: data procedente del AJAX.
 */

function error(data){
	mostrarMensaje("Error de comunicación con el servidor",2);	
}

/*
 * Función que realiza una llamada AJAX con los datos
 * del arreglo.
 * 
 * De realizarse se ejecuta la función sccTrayectos, de no
 * hacerlo se ejecuta la función error.
 * 
 * Parametro de entrada:
 * 	codPeriodo: código del periodo.
 */
 
function buscarInformacionTrayectos(codPeriodo){
	var a=Array("m_modulo"	,	"periodo",
				"m_accion"	,	"listarTrayectos",
				"m_vista"	,	"listarTrayectos",
				"codPeriodo",	codPeriodo);
	
	ajaxMVC(a,succTrayectos,error);
}

/*
 * Función que verifica si el resultado de una llamada
 * AJAX trajo el estatus 1.
 * 
 * De ser así, asigna los trayectos que trae la llamada
 * y los pasa como parámetros a la función montarTrayectos.
 * 
 * De no ser así, muestra un mensaje al usuario construído en
 * el controlador.
 * 
 * Parametro de entrada:
 * 	datos: datos procedentes del AJAX.
 * 
 */

function succTrayectos(datos){
	if(datos.estatus>0){
		trayecto=datos.trayectos;
		montarTrayectos(trayecto);	
	} 	
	else 
		mostrarMensaje(data.mensaje,2);
}

/*
 * Función que realiza una llamada AJAX con los datos
 * del arreglo.
 * 
 * De realizarse se ejecuta la función sccUnnidadesCurriculares, de no
 * hacerlo se ejecuta la función error.
 * 
 * Parametro de entrada:
 * 	codPeriodo: código del periodo.
 * 	codTrayecto: código del trayecto.
 * 	seccion: sección.
 */

function buscarInformacionUnidadesCurricularesT(codPeriodo,codTrayecto,seccion=null){
	var a=Array("m_modulo"		,	"curso",
				"m_accion"		,	"listarSeccionYUniCurr",
				"m_vista"		,	"listarSeccionYUniCurr",
				"codTrayecto"	,	codTrayecto,
				"codPeriodo"	,	codPeriodo,
				"seccion"		,	seccion);
	
	ajaxMVC(a,succUnnidadesCurriculares,error);
}

/*
 * Función que verifica si el resultado de una llamada AJAX
 * trajo el estatus en 1.
 * 
 * De ser así, remueve el id "#tablaUnidades"
 * y llama a la función montarUnidades pasando como parámetro
 * las unidades que vinieron en el resultado del AJAX.
 * 
 * De no ser así, muestra un mensaje al usuario que se construye
 * en el controlador.
 * 
 * Parametro de entrada:
 * 	data: data proveniente del AJAX.
 * 
 */

function succUnnidadesCurriculares(data){
	if(data.estatus>0){
		$('#tablaUnidades').remove();
		unidades=data.seccionYUniCurr;
		montarUnidades(unidades);
	}
	else 
		mostrarMensaje(data.mensaje,2);
}

/*
 * Función que remueve el modal (diálogo) de existir,
 * y crea uno nuevo.
 * 
 * Luego de eso, monta la información en el nuevo diálogo.
 * 
 * Parametro de entrada:
 * 	nombreDialogo: nombre que tendrá el diálogo a crear.
 * 	titulo: titulo del diálogo.
 * 	tipoAccion: tipo de acción.
 * 	numTrayecto: número del trayecto.
 * 	seccion: sección.
 * 	codTrayecto: código del trayecto.
 * 
 */

function configurarSeccion(nombreDialogo,titulo,tipoAccion,numTrayecto=null,seccion=null,codTrayecto=null){
	$('.modal').remove();
	$('#'+nombreDialogo).remove();
	crearDialogo(nombreDialogo,titulo,'',2,'administrarSeccion()');
	
	montarInformacionDialogoSeccion(tipoAccion,numTrayecto,seccion,codTrayecto);	
}

/*
 * Función que carga un formulario html y lo coloca
 * dentro del modal (diálogo), cuando suceda esto
 * verifica si el tipo de acción (que entra como parámetro)
 * es "agregar" o "administrar".
 * 
 * De ser "agregar", llama a la función buscarInformaciónTrayectos.
 * 
 * De ser "administrar", llama a la función montarTrayectoYSeccion y
 * buscarInformacionUnidadesCurricularesT.
 * 
 * Parametro de entrada:
 * 	tipoAccion: tipo de acción.
 * 	numTrayecto: número del trayecto.
 * 	seccion: sección.
 * 	codTrayecto: código del trayecto.
 */

function montarInformacionDialogoSeccion(tipoAccion,numTrayecto=null,seccion=null,codTrayecto=null){
	$(".modal-body").load("modulos/curso/vista/html5/FormularioSeccion.html",
					function () {
							if (tipoAccion=='agregar')
								buscarInformacionTrayectos($('#codPeriodo').val());
							else if (tipoAccion=='administrar'){
								montarTrayectoYSeccion(numTrayecto,seccion);			
								buscarInformacionUnidadesCurricularesT($('#codPeriodo').val() ,codTrayecto,seccion);
							}
					}
						);
}

/*
 * Función que remueve el elemento "#trayectos",
 * crea uno con el atributo "disabled"
 * y coloca en "disabled" la sección.
 * 
 * Entran como parámetros el número de trayecto (numTrayecto)
 * y la sección (seccion)
 * 
 * Parametro de entrada:
 * 	numTrayecto: número del trayecto.
 * 	seccion: sección.
 * 
 */
 
function montarTrayectoYSeccion(numTrayecto,seccion){
	$('#trayectos').remove();
	var inputTrayecto="<div class='input-group'>";
		inputTrayecto+="<input type='text' disabled='dissabled' class='form-control' size='9' placeholder='Trayecto' id='trayectos' value=Trayecto:"+numTrayecto+"> ";
		inputTrayecto+="</div>";
	$(inputTrayecto).appendTo('#Trayectos');
	
	$('#seccion').val(seccion);
	
	$("#seccion").attr("disabled", true);
}

/*
 * Función que recorre la tabla de unidades curriculares
 * y compara si el código del curso es diferente de null,
 * de ser así, llama a la función checkear y le pasa el contador
 * del for.
 * 
 */

function checkearTabla(){
	for (var i=0;i<unidades.length;i++){
		if ($('#codCurso'+i).val() != 'null')
			checkear(i);
	}
}

/*
 * Función que activa la propiedad "checked" de un
 * elemento check, recibe como parámetro el id del check
 * a cambiar.
 * 
 * Parametro de entrada:
 * 	i: id del check a verificar.
 */

function checkear(i){
	$('#check'+i).prop("checked",true);
}	

/*
 * Función que recibe los trayectos que vienen
 * de una llamada AJAX, y los agrega a un
 * select con id "trayectos".
 * 
 * Luego de eso, activa el select el cuestión
 * para que tenga el estilo "selectpicker".
 * 
 * Este último es un plugin de bootstrap.
 * 
 * Parametro de entrada:
 * 	trayectos: matriz de trayectos.
 */
 
function montarTrayectos(trayectos){	
	cadena="";

	for(i=0;i<trayectos.length;i++){
		cadena+="<option value="+trayectos[i]['codigo']+" >Trayecto "+
		trayectos[i]['num_trayecto']+"</option>";
	}
	$(cadena).appendTo("#trayectos")
	activarSelect({width:"170"});
}

/*
 * Función que verifica que el trayecto seleccionado no esté
 * vacío y no exceda la cantidad de caracteres válidos.
 * 
 * De no cumplirse alguna de las anteriores validaciones, muestra
 * un mensaje al usuario.
 * 
 * De cumplirse ambas, llama a la función 
 * buscarInformacionUnidadesCurricularesT pasando como parámetros
 * el código del periodo, el trayecto y la sección.
 * 
 * 
 */

function cargarUnidades(){
	if($("#trayectos").val() == 'null'){
		mostrarMensaje("Seleccione un trayecto válido",3);	
	}else 
	if ($("#seccion").val().length >5)
		mostrarMensaje("Campo sección muy largo, solo 5 caracteres como máximo",3); 	
	else 
		buscarInformacionUnidadesCurricularesT($('#codPeriodo').val() ,$('#trayectos').val(),$('#seccion').val());
}

/*
 * Función que se ejecuta si se ejecuta correctamente una llamda
 * AJAX. Recibe las unidades a montar.
 * 
 * Si las unidades vienen vacías, muestra un mensaje al usuario.
 * 
 * De no estar vacías, construye una tabla con la información que viene
 * en unidades.
 * 
 * Una vez que la construya y llene, agrega la cadena al div
 * con id "unidadesT", luego llama a la función checkearTabla y
 * activarFecha.
 * 
 * Parametro de entrada:
 * 	unidad: unidades a montar.
 * 
 */

function montarUnidades(unidad){
	cadena="";
	if (unidades==null){
		mostrarMensaje('No hay unidades',2)
	}else{
		
		/*
		 * Construye la tabla con su encabezado.
		 */
		
		cadena+="<table class='table table-hover' id='tablaUnidades'>";
		cadena+="<thead>";
		cadena+="<tr class='active ' >";
		cadena+="<td colspan='10'>Unidad curricular</td> " ;
		cadena+="<td colspan='10'>Capacidad máxima</td> " ;
		cadena+="<td colspan='10'>Fecha inicio</td> " ;
		cadena+="<td colspan='10'>Fecha final</td> " ;
		cadena+="<td colspan='10'>Docente</td> " ;
		cadena+="<td colspan='10'>Observaciones</td> " ;
		cadena+="</tr>";
		cadena+="</thead>";
		cadena+="<tbody>";
		
		/*
		 * Realiza un for de la cantidad de unidades que vengan de
		 * la llamada AJAX.
		 * 
		 * Si algún campo de la unidad viene en null,
		 * se reemplaza con ''.
		 */
		
		for (i=0;i<unidades.length;i++){
			
			if (unidades[i]['capacidad']==null) unidades[i]['capacidad']='';
				
			if (unidades[i]['fec_inicio']==null)unidades[i]['fec_inicio']='';
				
			if (unidades[i]['fec_final']==null)unidades[i]['fec_final']='';
				
			if (unidades[i]['cod_docente']==null)unidades[i]['cod_docente']='';
				
			if (unidades[i]['observaciones']==null)unidades[i]['observaciones']='';
			
			/*
			 * Se llenan las tablas con la información dentro de unidades. 
			 */
			
			cadena+="<tr class='active'>";
			cadena+="<div class='input-group'>";
			
			cadena+= "<td colspan='10'> <div class='input-group'>  <input type='checkbox'  id=check"+i+"  onchange='verChek(check"+i+")' > </input> <span id='nombreUni"+i+"'> "+unidades[i]['nombre'] +  "</span></div> </td>";
			 
			cadena+= "<td colspan='10'> <div class='input-group'>   <input type='text' class='form-control' placeholder='Cantidad máxima' id=capacidad"+i+"   value='"+ unidades[i]['capacidad'] +"' onkeyup=\"cambiarEstatus('m',"+ unidades[i]['codigo_unidad']+",'cambiarConCodUniCur');validarSoloNumeros('#capacidad"+i+"',1,3,false);\">  </div> </td>";

			cadena+= "<td colspan='10'> <div class='input-group '><input type='text' class='form-control fecha' onfocus=\"activarFecha('#fecInicio"+i+"')\" id='fecInicio"+i+"'    value='"+unidades[i]['fec_inicio']+"' onkeyup=\"validarFecha('#fecInicio"+i+"',false)\"  onchange=\"cambiarEstatus('m',"+ unidades[i]['codigo_unidad']+",'cambiarConCodUniCur')\"></div> </td>";
			
			cadena+= "<td colspan='10'> <div class='input-group '><input type='text' class='form-control fecha' onfocus=\"activarFecha('#fecFinal"+i+"')\" id='fecFinal"+i+"'      value='"+unidades[i]['fec_final']+"' onkeyup=\"validarFecha('#fecFinal"+i+"',false)\"  onchange=\"cambiarEstatus('m',"+ unidades[i]['codigo_unidad']+",'cambiarConCodUniCur')\" ></div> </td>";
		    cadena+= "<td colspan='10'> <div class='input-group'><input type='text' class='form-control docente' id='"+i+"' onFocus='buscarDocentesA()' placeholder='Docente' onchange=\"cambiarEstatus('m',"+ unidades[i]['codigo_unidad']+",'cambiarConCodUniCur')\" onkeyup=\"validarDocente("+i+");validarSoloTexto('#"+i+"',0,30,false)\" value='"+unidades[i]['nombrecompleto'] +"'>  </div> </td>";
		   
			cadena+= "<td colspan='10'> <div class='input-group'>   <input type='text' class='form-control' placeholder='Observaciones' id='observaciones"+i+"' value='"+unidades[i]['observaciones'] +"' onkeyup=\"validarRangos('#observaciones"+i+"',0,30,false);cambiarEstatus('m',"+ unidades[i]['codigo_unidad']+",'cambiarConCodUniCur')\">  </div> </td>";
			if (unidades[i]['codigo'])
			cadena+="<td> <input type='hidden' name='estatus' value='a' id='estatus"+i+"'>   </td>";
			else
			cadena+="<input type='hidden' name='estatus' value='n' id='estatus"+i+"'> ";
			cadena+="<input type='hidden' name='docente'  id='docente"+i+"' value='"+unidades[i]['cod_docente']+"'>";
			cadena+="<input type='hidden' name='unidad' value='"+unidades[i]['codigo_unidad'] + "' id='unidad"+i+"'> ";		
			cadena+="<input type='hidden' name='codCurso' value='"+unidades[i]['codigo'] + "' id='codCurso"+i+"'> ";	
			cadena+="</div>";
			cadena+="</tr>";

		}
		cadena+="</tbody>";
		cadena+="</table>";
	}
	
	$(cadena).appendTo('#unidadesT');
	checkearTabla();
	
	activarFecha();
}

/*
 * Función que recibe un id y verifica el estado del check de ese
 * id. De estar checkeado, devuelve true. 
 * De no estarlo, devuelve false.
 * 
 * Parametro de entrada:
 * 	idcheck: id del check a checkear.
 * 
 * Parámetro de retorno:
 * 	true: De estar checkeado.
 * 	false: De no estarlo.
 */

function verChek(idcheck){
    if($("#"+idcheck).is(':checked'))
    	return true;
	else 
		return false;
}

/*
 * Función que verifica el estatus y el check de cada unidad curricular.
 * 
 * Luego de eso, decide qué acción debe realizarse según su combinación.
 * 
 *
 * Tabla de acción en la base de datos según el chequeo y el status
 * 					Check \ Estado   ===>  Accion
 * 
 * 		 |	agregado(A)    |   Modificado (M)   | NO agregdo (N)  
 *   Si  |     ---         |    Update - A      |  Insert - A
 *   No  |   Delete - N    |    Delete - N      |    ----
 * 	
 * Tabla de acción según el cambio de los textos y el estatus
 * Cuando se hace modifica cualquier texto debe pasar a un nuevo estatus
 * 
 * Estatus actual  ======> Nuevo Estatus
 *    A             ==>        M   
 *    M             ==>        M
 *    N             ==>        N
 * 
 */
 
function administrarSeccion(){
	var cad ='';
	if ($("#seccion").val()=="")
		mostrarMensaje("El campo sección es obligatorio",3);
	else{
		/*
		 * Recorre cada elemento de la tabla y compara el check
		 * y el valor del estatus.
		 * 
		 * De ser agregar o modificar la acción a realizar,
		 * llama a validarTodoCurso, dicha función valida que 
		 * todos los campos a validar o modificar estén correctos.
		 */
		
		for ( var i=0;i< ($('#tablaUnidades >tbody >tr')).length;i++){
			if ((verChek('check'+i)) && ($('#estatus'+i).val()=='n')){	
				if(validarTodoCurso(i))
					agregarCurso(i);
				else
					break;
			}
			if ((! verChek('check'+i)) && ($('#estatus'+i).val()=='a')){
				if (confirm ("Está seguro que desea eliminar el curso"+ $('#nombreUni'+i).html()))
					eliminarCurso(i);
			}
			if ((verChek('check'+i)) && ($('#estatus'+i).val()=='m')){
				if(validarTodoCurso(i))
					modificarCurso(i);
				else
					break;
			}
			if ((! verChek('check'+i)) && ($('#estatus'+i).val()=='m')){
				if (confirm ("Está seguro que desea eliminar el curso "+ $('#nombreUni'+i).html()  ))
					eliminarCurso(i);
			}
		}
	}
}

/*
 * Función que realiza una llamada AJAX con los datos
 * del arreglo.
 * 
 * De realizarse se ejecuta la función succModificar, de no
 * hacerlo se ejecuta la función error.
 * 
 * Parametro de entrada:
 * 	i: índice del elemento a modificar.
 */


function modificarCurso(i){
	var a=Array("m_modulo"			,		"curso",
				"m_accion"			,		"modificar",
				"m_vista"			,		"Modificar",
				"codPeriodo"		,		$('#codPeriodo').val(),
				"codUniCurricular"	,		$('#unidad'+i).val(),
				"codDocente"		,		$('#docente'+i).val(),
				"seccion"			,		$('#seccion').val(),
				"fechaInicio"		,		$('#fecInicio'+i).val(),
				"fechaFinal"		,		$('#fecFinal'+i).val(),
				"capacidad"			,		$('#capacidad'+i).val(),
				"observaciones"		,		$('#observaciones'+i).val(),
				"codigo"			,		$('#codCurso'+i).val()
				);	
					
	ajaxMVC(a,succModificar,error);	
}

/*
 * Función que se ejecuta si una llamada AJAX se realizó
 * correctamente, recibe la data y compara el estatus.
 * 
 * De tener estatus mayor a 0, verifica el trayecto seleccionado
 * para luego mostrar un mensaje al usuario.
 * 
 * De tener no tener estatus mayor a 0, muestra un mensaje al usuario.
 * 
 * Parametro de entrada:
 * 	data: data proveniente del AJAX.
 */
 
function succModificar(data){
	if (data.estatus>0){
		var i= obtenerIndiceDeTabla(data.codigo,"#codCurso");
		var mostrar = "";
		if($("#trayectos option:selected").text() != ''){
			mostrar =  $("#trayectos option:selected").text();
		}
		else{
			$("#trayectos").attr("disabled",false);
			mostrar = $("#trayectos").val();
		}
		mostrarMensaje(data.mensaje + $('#nombreUni'+i).html()+" en la sección "+$('#seccion').val() +
		" en "+ mostrar,1);
		cambiarEstatus("a",data.codigo,'cambiarConCodCur');
		buscarCursosSecciones();
	}
	else 
		mostrarMensaje(data.mensaje,2);
}

/*
 * Función que obtiene el indice de la tabla.
 * 
 * Recibe como parámetros el código y el tipo.
 * 
 * Compara el código y el tipo, de ser iguales,
 * devuelve el número del índice.
 * 
 * Parametro de entrada:
 * 	cod: código a comparar.
 * 	tipo: tipo a comparar.
 * 
 * Parámetro de retorno:
 * 	i: índice de la tabla.
 */

function obtenerIndiceDeTabla(cod,tipo){
	for (i=0; i <unidades.length; i++)
		if ($(tipo+i).val() == cod)
			return i;
}

/*
 * Obtiene el índice de la tabla por unidad curricular.
 * 
 * Recibe como parámetro el código y llama a la función
 * obtenerIndiceDeTabla.
 * 
 * Parametro de entrada:
 * 	cod: código de la unidad.
 * 
 * Parámetro de retorno:
 * 	Índice de la tabla.
 */

function obtenerIndiceDeTablaPorCodUnidad(cod){
	return obtenerIndiceDeTabla(cod, "#unidad");
}

/*
 * Obtiene el índice de la tabla por código del curso.
 * 
 * Recibe como parámetro el código y llama a la función
 * obtenerIndiceDeTabla.
 * 
 * Parametro de entrada:
 * 	cod: código del curso.
 * 
 * Parámetro de retorno:
 * 	Índice de la tabla.
 */

function obtenerIndiceDeTablaPorCodCurso(cod){
	return obtenerIndiceDeTabla(cod, "#codCurso");
}

/*
 * Función que cambia el valor del estatus.
 * 
 * Recibe como parámetros el valor actual del estatus,
 * el código y el tipo.
 * 
 * De ser el tipo "cambiarConCodUniCur", obtiene
 * el índice con la función obtenerIndiceDeTablaPorCodUnidad
 * y le pasa como parámetro el código.
 * 
 * De ser el tipo "cambiarConCodCur", obtiene el índice
 * con la función obtenerIndiceDeTablaPorCodCurso y le pasa
 * como parámetro el código.
 * 
 * Si el estatus es "n" y el valor es "m", cambia el estatus
 * a "n".
 * 
 * De no ser así, lo cambia por el valor.
 * 
 * Parametro de entrada:
 * 	valor: valor del estatus.
 * 	codigo: codigo del elemento.
 * 	tipo: tipo de acción.
 */
 
function cambiarEstatus(valor, codigo, tipo){
	
	if (tipo=='cambiarConCodUniCur')
		var i=obtenerIndiceDeTablaPorCodUnidad(codigo);
	if (tipo=='cambiarConCodCur')
		var i=obtenerIndiceDeTablaPorCodCurso(codigo)
		
	var status=$("#estatus"+i).val();
	if ((status=='n') && (valor=='m'))
		$("#estatus"+i).val('n');
	else 
		$("#estatus"+i).val(valor);
}

/*
 * Función que realiza una llamada AJAX con los datos
 * del arreglo.
 * 
 * De realizarse se ejecuta la función succAgregar, de no
 * hacerlo se ejecuta la función error.
 * 
 * Parametro de entrada:
 * 	i: índice del elemento a agregar.
 */

function agregarCurso(i){
	var a=Array("m_modulo"			,		"curso",
				"m_accion"			,		"agregar",
				"m_vista"			,		"Agregar",
				"codPeriodo"		,		$('#codPeriodo').val(),
				"codUniCurricular"	,		$('#unidad'+i).val(),
				"codDocente"		,		$('#docente'+i).val(),
				"seccion"			,		$('#seccion').val(),
				"fechaInicio"		,		$('#fecInicio'+i).val(),
				"fechaFinal"		,		$('#fecFinal'+i).val(),
				"capacidad"			,		$('#capacidad'+i).val(),
				"observaciones"		,		$('#observaciones'+i).val()
				);
	
	ajaxMVC(a,succAgregar,error);	
}

/*
 * Función que se ejecuta cuando una llamada AJAX se realizó
 * correctamente. 
 * 
 * Si el estatus viene mayor a 0, obtiene el obtiene el índice
 * de la tabla, asigna el código del curso con lo que viene
 * en los datos del AJAX y construye un mensaje.
 * 
 * Muestra el mensaje construído al usuario.
 * 
 * Parametro de entrada:
 * 	datos: datos provenientes del AJAX.
 */

function succAgregar(datos){ 
	if (datos.estatus>0){
		var i= obtenerIndiceDeTabla(datos.codigoUnidadCurri,"#unidad");
		$('#codCurso'+i).val(datos.codigoCurso);
		
		var mostrar = "";
		if($("#trayectos option:selected").text() != ''){
			mostrar =  $("#trayectos option:selected").text();
		}
		else{
			$("#trayectos").attr("disabled",false);
			mostrar = $("#trayectos").val();
		}
		
		mostrarMensaje(datos.mensaje + "<a href=\"javascript:configurarSeccion('dialogoSeccion','Administrar Sección','administrar','0','a','1')\"' data-toggle='modal' data-target='#dialogoSeccion'>" + $('#nombreUni'+i).html()+"</a> en la sección "+$('#seccion').val()+ 
		" en "+ mostrar,1);
		
		cambiarEstatus("a",datos.codigoUnidadCurri,'cambiarConCodUniCur');
		
		buscarCursosSecciones();
	}
	else 
		mostrarMensaje(datos.mensaje,2);
}

/*
 * Función que realiza una llamada AJAX con los datos
 * del arreglo.
 * 
 * De realizarse se ejecuta la función succEliminar, de no
 * hacerlo se ejecuta la función error.
 * 
 * Parametro de entrada:
 * 	i: índice del elemento a eliminar.
 */

function eliminarCurso(i){
	var a=Array("m_modulo"		,		"curso",
				"m_accion"		,		"eliminar",
				"m_vista"		,		"Eliminar",
				"codigo"		,		$('#codCurso'+i).val()
				);
				
	ajaxMVC(a,succEliminar,error);	
}

/*
 * Función que se ejecuta cuando una llamada AJAX se realiza
 * correctamente.
 * 
 * Si el estatus es mayor a 0, construye un mensaje y lo muestra
 * al usuario, cambia el valor a "eliminar", cambia el estatus
 * y busca los cursos.
 * 
 * Si el estatus no es mayor a 0, muestra un mensaje al usuario
 * con el error.
 * 
 * Parametro de entrada:
 * 	datos: datos provenientes del AJAX.
 * 
 */

function succEliminar(datos){
	if (datos.estatus>0){
		var mostrar = "";
		if($("#trayectos option:selected").text() != ''){
			mostrar =  $("#trayectos option:selected").text();
		}
		else{
			$("#trayectos").attr("disabled",false);
			mostrar = $("#trayectos").val();
		}
		var i= obtenerIndiceDeTabla(datos.codigo,"#codCurso");
		mostrarMensaje(datos.mensaje+ $('#nombreUni'+i).html()+" en la sección "+$('#seccion').val()+
		" en "+ mostrar,1);

		cambiarValAlEliminar(i);
		cambiarEstatus("n", datos.codigo,'cambiarConCodCur');
		buscarCursosSecciones();
	}
	else 
		mostrarMensaje(datos.mensaje,2);
}

/*
 * Función que recibe como parámetro un índice y reemplaza todos los
 * campos de dicha fila con "".
 * 
 * Parametro de entrada:
 * 	i: índice del elemento a cambiar el valor.
 */

function cambiarValAlEliminar(i){
	$('#capacidad'+i).val("");
	$('#fecInicio'+i).val("");
	$('#fecFinal'+i).val("");
	$('#'+i).val("");
	$('#observaciones'+i).val("");
}	

/*
 * Función que realiza una llamada AJAX con los datos
 * del arreglo.
 * 
 * De realizarse se ejecuta la función succVerEst, de no
 * hacerlo se ejecuta la función error.
 * 
 * Parametro de entrada:
 * 	codigoCurso: código del curso.
 * 	nombre: nombre del curso.
 * 	otroTitulo: título para el díalogo.
 */

function verEstudiantes(codigoCurso,nombre,otroTitulo){
	var arr = Array(
					"m_modulo" 		, 	"curso",
					"m_accion" 		, 	"listarE",
					"m_vista"  		, 	"verEstudiantes",
					"codigoCurso" 	, 	codigoCurso
					);
	$(".modal").remove();
	crearDialogo("verEstudiantes", nombre, otroTitulo, 1 ,'', '',true);
	
	$("<input id='codigoCurso' type='hidden' value='"+codigoCurso+"'>").appendTo(".modal-header");
	
	ajaxMVC(arr,succVerEst,errorEst);
}

/*
 * Función que se ejecuta cuando una llamada AJAX se realiza
 * correctamente.
 * 
 * Si el estatus es mayor a 0, llama a la función montarEstudiantes
 * y le pasa como parámetro los estudiantes que vienen de la 
 * llamada AJAX.
 * 
 * Si el estatus es menor a 0, esconde el modal y muestra un mensaje
 * al usuario.
 * 
 * Parametro de entrada:
 * 	data: data proveniente del AJAX.
 */

function succVerEst(data){
	if(data.estatus>0){
		estudiantes = data.estudiante;
		montarEstudiantes(estudiantes);
	}
	else {
		mostrarMensaje(data.mensaje,4);
	}
}

/*
 * Función que se ejecuta si la llamada AJAX no se realizó
 * correctamente.
 * 
 * Muestra un mensaje al usuario.
 * 
 */

function errorEst(){
	mostrarMensaje("El curso no posee estudiantes",2);
}

/*
 *
 *
 *
 *
 *
 *
 *
 *
 */

 function funcionPDF(){
 	window.location.assign($("#selectPDF").val());
 }

/*
 * Función que construye la cadena necesaria para mostrar
 * los estudiantes provenientes de la llamada AJAX.
 * 
 * Recibe como parámetro los estudiantes resultantes de la 
 * llamada AJAX, de venir en null muestra un mensaje al usuario.
 * 
 * De no ser así, construye una tabla y la llena con todos
 * los datos que vienen como parámetros.
 * 
 * Al terminar de recorrer todos los estudiantes, añade la
 * cadena construída al modal y lo muestra.
 * 
 * Parametro de entrada:
 * 	estudiantes: matriz de estudiantes provenientes del AJAX.
 */
function montarEstudiantes(estudiantes){
	cadena="";
	if (estudiantes==null){
		mostrarMensaje('El curso elegido no posee estudiantes',2);

	}else{	
		$("<div id='estudiantesT'></div>").appendTo(".modal-body");

		$("<div class='row'><div class='col-md-6'></div><div class='col-md-6'><select class='selectpicker' id='selectPDF' data-style='btn-danger' data-live-search='true' data-size='auto' multiple data-max-options='1' title='Exportar...' onchange='funcionPDF()'>" +
		  "<option value=\"index.php?m_modulo=curso&m_accion=verEstudiantesPDF&m_vista=verEstudiantes&m_formato=pdf&codigoCurso="+$('#codigoCurso').val()+"\">Acta de Notas (PDF)</option>" +
		  "<option value=\"index.php?m_modulo=curso&m_accion=listarE&m_vista=listaAsistencia&m_formato=pdf&codigoCurso="+$('#codigoCurso').val()+"\">Lista de Asistencia (PDF)</option>"+
		  "<option value=\"index.php?m_modulo=curso&m_accion=listarE&m_vista=listaAsistencia&m_formato=odt&codigoCurso="+$('#codigoCurso').val()+"\">Lista de Asistencia (ODT)</option>"+
		  "</select></div></div>").appendTo(".modal-header");

		activarSelect();

		cadena+="<table class='table' id='tablaEstudiantes'>";
		cadena+="<tr class='titulo'>";
		cadena+="<td>Cédula</td> " ;
		cadena+="<td>Nombre</td> " ;
		cadena+="<td>Apellido</td> " ;
		cadena+="<td>Nota</td> " ;
		cadena+="<td>% Asistencia</td> " ;
		cadena+="<td>Estado</td> " ;
		cadena+="</tr>";

		for (i=0;i<estudiantes.length;i++){
			
			cadena+="<tr>";
			cadena+="<td>"+estudiantes[i]['cedula']+"</td>";
			cadena+="<td>"+estudiantes[i]['nombre1']+"</td>";
			cadena+="<td>"+estudiantes[i]['apellido1']+"</td>";

			if(estudiantes[i]['nota']===null)
				cadena+="<td>"+'N/A'+"</td>";
			else
				cadena+="<td>"+estudiantes[i]['nota']+"</td>";

			if(estudiantes[i]['por_asistencia']===null)
				cadena+="<td>"+'N/A'+"</td>";
			else
				cadena+="<td>"+estudiantes[i]['por_asistencia']+"</td>";

			cadena+="<td>"+estudiantes[i]['nombre']+"</td>";
			cadena+="</tr>";
		}
	cadena+="</table>";

	$(cadena).appendTo('#estudiantesT');
	
	$("#verEstudiantes").modal("show");
	}
}
/*
 * Función que realiza una llamada AJAX con los datos
 * del arreglo.
 * 
 * De realizarse se ejecuta la función succCargarNotas, de no
 * hacerlo se ejecuta la función error.
 * 
 * Parametro de entrada:
 * 	codigo: código del curso.
 * 	nombre: nombre del curso.
 * 	nombreP: nombre del profesor.
 */
 
function cargarNotas(codigo,nombre,nombreP){	
	var arr = Array("m_modulo"  	, "curso",
					"m_accion"  	, "listarE",
					"m_vista"   	, "verEstudiantes",
					"codigoCurso"	, codigo);
					
	$('#estudiantesT').remove();
	
	if($('#estudiantesTa').length == 0){
		$(".modal").remove();
		
		crearDialogo('cargarNotas','Cargar Notas',nombreP,2,'administrarNotas()','Cargar Notas');
	}
	$('#codCurso').remove();
	$("<input type='hidden' id='codCurso' value="+codigo+">").appendTo('.modal-header');
	$('#row-header').remove();
	
//	if (Per.estudianteCurso.insert)
	$("<div class='row' id='row-header'><div class='col-md-2 col-md-offset-7'><button class='btn btn-info' onclick='listarEst()'>Agregar Estudiante</button></div><div class='col-md-2'><div id='buscador'></div></div></div>").appendTo(".modal-header");
	
	if($('#estudiantesTa').length == 0);
		$("<div id='estudiantesTa'></div>").appendTo(".modal-body");

	ajaxMVC(arr,succCargarNotas,error);
}

/*
 * Función que se ejecuta cuando la llamada AJAX se realiza
 * correctamente.
 * 
 * Si el estatus es mayor a 0, llama a montarEstudiantesNotas y le 
 * pasa como parámetro los estudiantes que vienen de la llamada AJAX.
 * Llama además a la función selectEstudiantes para asignar el
 * valor a los select.
 * 
 * Si el estatus es menos a 0, muestra un mensaje al usuario.
 * 
 * Parametro de entrada:
 * 	data: data proveniente del AJAX.
 */

function succCargarNotas(data){
	if(data.estatus>0){
		estudiantes = data.estudiante;
		montarEstudiantesNotas(estudiantes);
		activarSelect();
		selectEstudiantes(estudiantes);
	}
	else
		mostrarMensaje(data.mensaje,2);
}

/*
 * Función que asignar el valor a todos los select
 * con los datos que vienen desde el parámetro.
 * 
 * Recibe como parámetro todos los registros de estudiantes para luego
 * obtener el estado de ese estudiante en el curso.
 * 
 * Parametro de entrada:
 * 	estudiantes: matriz de estudiantes.
 */

function selectEstudiantes(estudiantes){
	for (i=0;i<estudiantes.length;i++){
		$('#estado'+i).selectpicker('val',estudiantes[i]['cod_estado']);
	}
}

/*
 * Función que recibe una matriz de estudiantes
 * y construye una tabla con los datos de los mismos en el curso.
 * 
 * Si los estudiantes vienen en null, sólo construye el encabezado
 * de la tabla.
 * 
 * De no ser así, llena la tabla con la información.
 * 
 * Luego agrega lo construído al div con id "estudiantesT".
 * 
 * Parametro de entrada:
 * 	estudiantes: matriz de estudiantes.
 */

function montarEstudiantesNotas(estudiantes){
	cadena="";
		if (estudiantes==null){
			cadena+="<table class='table' id='tablaEstudiantes'>";
			cadena+="<thead>";
			cadena+="<tr class='titulo'>";
			cadena+="<td>Cédula</td> " ;
			cadena+="<td>Nombre</td> " ;
			cadena+="<td>Apellido</td> " ;
			cadena+="<td>Nota</td> " ;
			cadena+="<td>% Asistencia</td> " ;
			cadena+="<td>Estado</td> " ;
			cadena+="<td>Observaciones</td> " ;
			cadena+="</tr>";
			cadena+="</thead>";
			cadena+="<tbody>";
			cadena+="</tbody>";
			cadena+="</table>";
			mostrarMensaje('El curso elegido no posee estudiantes',4);
		}else{
			cadena+="<table class='table' id='tablaEstudiantes'>";
			cadena+="<thead>";
			cadena+="<tr class='titulo'>";
			cadena+="<td>Cédula</td> " ;
			cadena+="<td>Nombre</td> " ;
			cadena+="<td>Apellido</td> " ;
			cadena+="<td>Nota</td> " ;
			cadena+="<td>% Asistencia</td> " ;
			cadena+="<td>Estado</td> " ;
			cadena+="<td>Observaciones</td> " ;
			cadena+="</tr>";
			cadena+="</thead>";
			opc ='';
			cadena+="<tbody>";
			for (i=0;i<estudiantes.length;i++){
				cadena+="<input type='hidden' id='estatus"+i+"' value='n'>";
				cadena+="<input type='hidden' id='codigo"+i+"' value='"+estudiantes[i]['codigo']+"''>";
				cadena+="<tr>";
				cadena+="<td class='col-md-1'><input class='form-control' id='cedula"+i+"' value='"+estudiantes[i]['cedula']+"' disabled></td>";
				cadena+="<td class='col-md-2'><input class='form-control' id='nombre"+i+"' value='"+estudiantes[i]['nombre1']+"' disabled></td>";
				cadena+="<td class='col-md-2'><input class='form-control' id='apellido"+i+"' value='"+estudiantes[i]['apellido1']+"' disabled></td>";
				cadena+="<td class='col-md-1'><input type='text' class='form-control' onkeyup=\"validarSoloNumeros('#nota"+i+"',0,3,false)\" onchange='cambiarEstatusNotas("+i+")' id='nota"+i+"' value='"+estudiantes[i]['nota']+"'>";	
				cadena+="<td class='col-md-1'><input type='text' id='por_asistencia"+i+"' onkeyup=\"validarSoloNumeros('#por_asistencia"+i+"',0,3,false)\" onchange='cambiarEstatusNotas("+i+")' class='form-control' value='"+estudiantes[i]['por_asistencia']+"'></td>";
				cadena+="<td class='col-md-1'><select id='estado"+i+"' onchange='cambiarEstatusNotas("+i+")' class='selectpicker' data-live-search='true' data-size='auto' multiple data-max-options='1' title='Seleccione Estudiante'>";
				cadena += "<option value='A'>Aprobado</option>";
				cadena += "<option value='C'>Cursando</option>";
				cadena += "<option value='E'>Retirado</option>";
				cadena += "<option value='I'>Inscrito</option>";
				cadena += "<option value='N'>Reprobado por Inasistencia</option>";
				cadena += "<option value='P'>Preinscrito</option>";
				cadena += "<option value='R'>Reprobado</option>";
				cadena+="</select></td>";
				cadena+="<td class='col-md-3'><input type='text' id='observaciones"+i+"' onkeyup=\"validarRangos('#observaciones"+i+"',0,30,false)\" onchange='cambiarEstatusNotas("+i+")' class='form-control' value='"+estudiantes[i]['observaciones']+"'></td>";
				cadena+="</tr>";
			}			
			cadena+="</tbody>";
			cadena+="</table>";
		}

		$('#estudiantesT').remove();
		
		$("<div id='estudiantesT'></div>").appendTo(".modal-body");
		
		$(cadena).appendTo('#estudiantesT');
}

/*
 * Función que cambia el estatus de un índice.
 * 
 * Recibe el índice y cambia el estatus de ese índice a "m".
 * 
 * Parametro de entrada:
 * 	i: índice del elemento a cambiar el estatus.
 */

function cambiarEstatusNotas(i){
	$('#estatus'+i).val('m');
}

/*
 * Función que realiza una llamada AJAX con los datos
 * del arreglo.
 * 
 * De realizarse se ejecuta la función succListarE, de no
 * hacerlo se ejecuta la función error.
 * 
 */

function listarEst(){
	var codigo = $('#codCurso').val();
	var arr = Array("m_modulo"	,  "curso",
					"m_accion"	,  "obtenerEstudiantesC",
					"codCurso"	,  codigo);

	ajaxMVC(arr,succListarE,error);	
}

/*
 * Función que se ejecuta cuando una llamada AJAX
 * se realiza correctamente.
 * 
 * Si el estatus es mayor a 0, llama a la función montarEstSelect
 * y le pasa como parámetro los estudiantes que vienen del
 * AJAX y llama a la función activarSelect.
 * 
 * Si el estatus es menor a 0, muestra un mensaje al usuario.
 * 
 * Parametro de entrada:
 * 	data: data proveniente del AJAX.
 */

function succListarE(data){
	if(data.estatus>0){
		estudiantes = data.estudiante;
		montarEstSelect(estudiantes);
		activarSelect();
	}else{
		mostrarMensaje("No hay estudiantes disponibles para este curso.",4);
	}
}

/*
 * Función que recibe como parámetro una matriz de estudiantes,
 * de estar vacía muestra un mensaje al usuario. De lo contrario,
 * crea una cadena de options con los nombres y cédulas de los estudiantes.
 * 
 * Parametro de entrada:
 * 	estudiantes: matriz de estudiantes.
 */

function montarEstSelect(estudiantes){	
	if(estudiantes == null)
		mostrarMensaje("No hay estudiantes disponibles para este curso",4);
	else{
		if($('#buscEst').length == 0){
			cadena = '';
			cadena += '<select id="buscEst" class="selectpicker"  onchange="preInsEst()" data-live-search="true" data-size="auto" multiple data-max-options="1" title="Seleccione Estudiante">';
			
			if(estudiantes == null){
				cadena += '<option value="null">No se encontraron estudiantes.</option>';
			}
			else{
				for(var i=0; i<estudiantes.length; i++){
					cadena += '<option value="'+estudiantes[i].codigo+'" data-subtext="'+"C.I.: "+estudiantes[i].cedula+'">'+estudiantes[i].nombre1+' '+estudiantes[i].apellido1+'</option>';
				}
			cadena += '</select>';
			$("#buscador").append(cadena);
			}
		}
		else
			mostrarMensaje("Presione aceptar una vez que haya seleccionado un estudiante.",3);
	}
}

/*
 * Función que obtiene el código del estudiante, el código
 * del curso y llama a la función inscribirEst pasando
 * como parámetro ambos códigos y la función a ejecutar si se
 * realiza la llamada AJAX.
 * 
 */

function  preInsEst(){
	var codigo = $('#buscEst').val()[0];
	var codCurso = $('#codCurso').val();
	inscribirEst(codigo,codCurso,succInscribirEst);
}

/*
 * Función que realiza una llamada AJAX con los datos
 * del arreglo.
 * 
 * De realizarse se ejecuta la función funcSuc que entra 
 * como parámetro, de no hacerlo se ejecuta la función error.
 * 
 * Parametro de entrada:
 * 	codigo: código del estudiante.
 * 	codCurso: código del curso.
 * 	funcSuc: función a realizarse en el ajax.
 */

function inscribirEst(codigo,codCurso,funcSuc){	
	var arr = Array("m_modulo"		,	"curso",
					"m_accion"		,	"agregarEst",
					"m_vista" 		, 	"AgregarEst",
					"codEstudiante" , 	codigo,
					"codCurso"		, 	codCurso,
					"porAsistencia"	, 	0,
					"estado"		, 	'I',
					"observaciones"	,	""
					);
	console.log(arr);
	ajaxMVC(arr,funcSuc,error);
}

/*
 * Función que se ejecuta si la llamada AJAX se realizó correctamente.
 * 
 * Si el estatus es mayor a 0, carga las notas de un curso y muestra
 * un mensaje al usuario.
 * 
 * Si no es así, muestra un mensaje al usuario.
 * 
 * En ambos casos ejecuta la función buscarCursosSecciones.
 * 
 * Parametro de entrada:
 * 	data: data proveniente del AJAX.
 */

function succInscribirEst(data){
	if(data.estatus>0){
		cargarNotas($('#codCurso').val());
		mostrarMensaje("Se ha agregado el estudiante",1);
	}
	else {
		mostrarMensaje("No hay capacidad para inscribir estudiantes",4);
	}
	buscarCursosSecciones();
}

/*
 * Función que busca en cada fila de la tabla los elementos que
 * deban modificarse, si encuentra alguno con dicho estatus
 * procede a hacer la validación de todos los elementos.
 * Si ésta devuelve un true, se modifica.
 * 
 */

function administrarNotas(){	
	for(var i = 0; i < ($('#tablaEstudiantes >tbody >tr')).length; i++){
		if($('#estatus'+i).val()=='m'){
			if((validarSoloNumeros('#nota'+i,0,3,false))&&(validarSoloNumeros('#por_asistencia'+i,0,3,false))&&(validarRangos('#observaciones'+i,0,30,false)))
				modificarNota(i);
		}
		$('#estatus'+i).val('n');
	}
}

/*
 * Función que realiza una llamada AJAX con los datos
 * del arreglo.
 * 
 * De realizarse se ejecuta la función succModificarNota, de no
 * hacerlo se ejecuta la función error.
 * 
 * Parametro de entrada:
 * 	i: índice del elemento a modificar.
 */

function modificarNota(i){

	if($('#nota'+i).val()=="")
		nota = undefined;
	else
		nota = $('#nota'+i).val();

	var arr = Array("m_modulo"		,	"curso",
					"m_accion"		,	"modificarNota",
					"m_vista"		,	"modificarNota",
					"codigo"		,	$('#codigo'+i).val(),
					"codCurso"		,	$('#codCurso').val(),
					"porAsistencia"	,	$('#por_asistencia'+i).val(),
					"nota"			,	nota,
					"estado"		,	$('#estado'+i).val()[0],
					"observaciones"	,	$('#observaciones'+i).val(),
					"nombre"		,	$('#nombre'+i).val() + " " + $('#apellido'+i).val()
					);

	ajaxMVC(arr,succModificarNota,error);
}

/*
 * Función que se ejecuta cuando una llamada AJAX se realiza 
 * correctamente.
 * 
 * Si el estatus es mayor a 0, manda un mensaje al usuario.
 * 
 * De no ser así, manda un mensaje al usuario.
 * 
 * Parametro de entrada:
 * 	data: data proveniente del AJAX.
 * 
 */

function succModificarNota(data){
	if(data.estatus>0){
		mostrarMensaje(data.mensaje+" "+data.nombre,1);
	}
	else{
		mostrarMensaje(data.mensaje+" "+data.nombre,2);
	}	
}

/*
 * Función que realiza una llamada AJAX con los datos
 * del arreglo.
 * 
 * De realizarse se ejecuta la función succBuscarCursosSecciones, de no
 * hacerlo se ejecuta la función error.
 */

function buscarCursosSecciones(){
	if($('#prof').val() == '1'){
		var arr = Array("m_modulo"	,	"curso",
						"m_accion"	,	"listarD",
						"m_vista"	,	"buscarCursosSecciones",
						"codPeriodo",	101,
						"codDocente",	1
						);
	}else{
		var arr = Array("m_modulo"	,	"curso",
						"m_accion"	,	"listar",
						"m_vista"	,	"buscarCursosSecciones",
						"codPeriodo",	$("#codPeriodo").val()
						);
	}
					
	ajaxMVC(arr,succBuscarCursosSecciones,error);
}

/*
 * Función que se ejecuta cuando una llamada AJAX se realiza 
 * correctamente.
 * 
 * Si el estatus es mayor a 0, llama a actualizarListarCursos.
 * 
 * De no ser así, manda un mensaje al usuario.
 * 
 * Parametro de entrada:
 * 	data: data proveniente del AJAX.
 */


function succBuscarCursosSecciones(data){
	if(data.estatus>0 ){
		actualizarListarCursos(data.cursos);
	}
	else{
		mostrarMensaje(data.mensaje,3);
	}
	if (data.cursos==null){
		$('#tTabla').remove();
		cadena="<div id='menCurso'>No hay cursos</div>";
		$(cadena).appendTo('#listarC');
	}
}

/*
 * Función que recibe como parámetros los cursos a mostrar,
 * y crea una tabla con la información de cada curso.
 * 
 * Cuando es construída, se agrega al div con id ListarC
 * 
 * Parametro de entrada:
 * 	cursos: matriz de cursos.
 */

function actualizarListarCursos(cursos){
	cadena="";
		$('#menCurso').remove();
		$('#tTabla').remove();

		cadena += '<table class="table" id="tTabla">';

		var trayecto = '';

		var seccion = '';
		//$('#botonAgregar').remove();
		//if((permiso.curso.insert)&&(permiso.curso.delete)&&(permiso.curso.update)){
		//	boton="<button type='button' id='botonAgregar' onClick=\"configurarSeccion('dialogoSeccion','Agregar Sección','agregar')\" class='btn btn-success' data-toggle='modal' data-target='#dialogoSeccion'>Agregar Sección</button>";	
		//	$(boton).appendTo('#botonAgregarSeccion');						
		//}
		for(var i=0;i<cursos.length;i++){
			if ((trayecto != cursos[i].num_trayecto) || (seccion != cursos[i].seccion)){
				var trayecto = cursos[i].num_trayecto;
				var seccion = cursos[i].seccion;
			

			cadena += '<tr class="titulo">';
			cadena += '<td  colspan="100">';

			cadena += '<div class="col-md-8 col-md-offset-2">';
			cadena += 'Trayecto: '+ trayecto +' - Sección: '+ seccion;

			cadena += '</div>';
			cadena += '<div class="col-md-2">';
			permiso=new Per();
			if ($("#estPeriodo").val()=="Abierto"){
				if ((permiso.curso.insert)&&(permiso.curso.delete)&&(permiso.curso.update)){
					cadena += "<button type='button' onClick=\"configurarSeccion('dialogoSeccion','Administrar Sección','administrar','"+cursos[i].num_trayecto+"','"+cursos[i].seccion+"','"+cursos[i].cod_trayecto+"')\" class='btn btn-warning' data-toggle='modal' data-target='#dialogoSeccion'>";
					cadena += "Administrar Sección";
				}
			}
			cadena += "<div>";
											
			cadena += "</td>";	
			cadena += "</tr>";
			cadena += '<tr class="active">';
			cadena +="<td>Unidad Curricular</td>";
			
			if($('#prof').val() != '1')
				cadena +="<td>Profesor</td>";
			
			cadena +="<td>Cantidad de Estudiantes</td>";
			cadena +="<td>Capacidad</td>";
			cadena +="<td>Fecha de Inicio</td>";
			cadena +="<td>Fecha de Fin</td> ";
			cadena +="<td></td>";
			cadena +="<td></td> ";
			cadena +="</tr>";

			}	    			
			cadena +="<tr>";
			cadena +="<td>";
			cadena += cursos[i].nombre; 
			cadena +="</td>";
			
			if($('#prof').val() != '1'){
				cadena +="<td>";
					cadena += cursos[i].nombrecompleto; 
				cadena +="</td>";
			}
			
			cadena +="<td>"
			cadena +=cursos[i].cantidad_estudiantes;   
			cadena +="</td>"
			cadena +="<td> "
			if(cursos[i].capacidad != null)
				cadena += cursos[i].capacidad;   
			else
				cadena += 'No asignado';			
			cadena +="</td>"

			cadena +="<td> "
			if(cursos[i].fec_inicio != null)
				cadena +=cursos[i].fec_inicio;
			else
				cadena += 'No definida';
			cadena +="</td>"
			cadena +="<td> "
			if(cursos[i].fec_final != null)
				cadena +=cursos[i].fec_final;
			else
				cadena += 'No definida';			
			cadena +="</td>"
			cadena +="<td>"
			cadena +="	<button type='button' class='btn btn-primary' onClick=\"verEstudiantes("+cursos[i].codigo+",'"+cursos[i].nombre+"','Profesor: "+cursos[i].nombrecompleto+"','Aceptar')\" data-toggle='modal' data-target='#verEstudiantes' title='Ver Estudiantes'>";
			cadena +='		<i class="icon-group"></i>';
			cadena +="	</button>";
			cadena +="</td>";
			cadena +="<td>";
			if ($("#estPeriodo").val()=="Abierto"){
				cadena +="	<button type='button' class='btn btn-info' onClick=\"cargarNotas("+cursos[i].codigo+",'"+cursos[i].nombre+"','Profesor: "+cursos[i].nombrecompleto+"')\" class='btn btn-info' data-toggle='modal' data-target='#cargarNotas' title='Cargar Notas'>";
				cadena +='<i class="icon-book"></i><i class="icon-pencil"></i>';
				cadena +="	</button>"
			}
			cadena +="</td>";
			cadena +="</tr>	";
			
			
		}
		cadena +="</table>";
		$(cadena).appendTo('#listarC');
}

/*
 * Función que realiza una llamada AJAX con los datos
 * del arreglo.
 * 
 * A diferencia de las demás, esta función recibe como parámetro
 * el patrón con el que filtrará los resultados.
 * 
 * De realizarse se ejecuta la función succBuscarListar, de no
 * hacerlo se ejecuta la función error.
 * 
 * Parametro de entrada:
 * 	patron: patron de búsqueda.
 */

function buscarListar(patron){
	var arr = Array("m_modulo"	,	"curso",
					"m_accion"	,	"listar",
					"m_vista"	,	"buscarCursosSecciones",
					"patron"	,	patron,
					"codPeriodo",	$("#codPeriodo").val());
	
	ajaxMVC(arr,succBuscarListar,error);
}

/*
 * Función que se ejecuta cuando una llamada AJAX se realiza 
 * correctamente.
 * 
 * Si el estatus es mayor a 0, llama a actualizarListarCursos.
 * 
 * De no ser así, manda un mensaje al usuario.
 * 
 * Parametro de entrada:
 * 	data: data proveniente del AJAX.
 */


function succBuscarListar(data){
	if(data.estatus > 0){
		actualizarListarCursos(data.cursos);
	}
	else{
		mostrarMensaje("No hay cursos disponibles",2);
		$('#tTabla').remove();
	}
}

/*
 * Función que valida todos los campos del formulario
 * de cursos.
 * 
 * Si pasa todas las validaciones, retorna true.
 * 
 * Si no pasa alguna, retorna false.
 * 
 * Parametro de entrada:
 * 	i: índice del elemento a validar.
 * 
 * Parámetro de retorno:
 * 	true: si está correcta la información.
 * 	false: si no está correcta la información.
 */

function validarTodoCurso(i){
	return((validarSoloNumeros('#capacidad'+i,1,3,false))&&(validarFecha('#fecInicio'+i,false))&&(validarFecha('#fecFinal'+i,false))&&(validarRangos('#observaciones'+i,0,30,false))&&(validarSoloTexto("#"+i,0,40,false)));
}
