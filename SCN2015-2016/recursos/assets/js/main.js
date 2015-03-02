
;(function(){
	$('#menuToggle, .menu-close').on('click', function(){
		$('#menuToggle').toggleClass('active');
		$('body').toggleClass('body-push-toright');
		$('#theMenu').toggleClass('menu-open');
	});

	$('#menuToggleL, .menu-closeL').on('click', function(){
		$('#menuToggleL').toggleClass('active');
		$('body').toggleClass('body-push-toright');
		$('#theMenuL').toggleClass('menu-openL');
	});

	$('#btnD').on('click', function(){
								if($('#btnD').html() == '<span class="glyphicon glyphicon-chevron-up"></span>'){
									$('#desarrolladores').remove();
									$('<div id="desarrolladores"></div>').appendTo('#f').load('modulos/principal/vista/html5/desarrolladores.html');
									$('#btnD').html('<span class="glyphicon glyphicon-chevron-down"></span>');
									$('#f').css('height','825px').get(0).scrollIntoView(true);
								}
								else{
									$('#desarrolladores').remove();
									$('<div id="desarrolladores"></div>').appendTo('#f').load('modulos/principal/vista/html5/desarrolladoresI.html');
									$('#btnD').html('<span class="glyphicon glyphicon-chevron-up"></span>');
									$('#f').css('height','300px');
									$('.container').get(0).scrollIntoView(true);
								}
							});
										
	$('.carousel').carousel({
					  interval: 6000
					});
		
	$("#notificacion").on('click', function(){$("#notificaciones").remove()});

	// Menu settings
	

	
})(jQuery)


function activarSelect(){
	$(".selectpicker").selectpicker();
}

function cambiarTema(){
	if(document.getElementById('headerwrap').style.backgroundColor=='black'){
		document.getElementById('headerwrap').style.backgroundColor='white';
	}
	else{
		document.getElementById('headerwrap').style.backgroundColor='black';
	}
}
(function( factory ) {
if ( typeof define === "function" && define.amd ) {
// AMD. Register as an anonymous module.
define([ "../datepicker" ], factory );
} else {
// Browser globals
factory( jQuery.datepicker );
}
}(function( datepicker ) {
datepicker.regional['es'] = {
closeText: 'Cerrar',
prevText: '&#x3C;Ant',
nextText: 'Sig&#x3E;',
currentText: 'Hoy',
monthNames: ['enero','febrero','marzo','abril','mayo','junio',
'julio','agosto','septiembre','octubre','noviembre','diciembre'],
monthNamesShort: ['ene','feb','mar','abr','may','jun',
'jul','ago','sep','oct','nov','dic'],
dayNames: ['domingo','lunes','martes','miércoles','jueves','viernes','sábado'],
dayNamesShort: ['dom','lun','mar','mié','jue','vie','sáb'],
dayNamesMin: ['D','L','M','X','J','V','S'],
weekHeader: 'Sm',
dateFormat: 'dd/mm/yy',
firstDay: 1,
isRTL: false,
showMonthAfterYear: false,
yearSuffix: ''};
datepicker.setDefaults(datepicker.regional['es']);
return datepicker.regional['es'];
}));

$(document).ready(function() {

	activarFecha(elemento);
});
function activarFecha(elemento){
	$.datepicker.setDefaults($.datepicker.regional["es"]);	
	$(elemento).datepicker();
	$(elemento).datepicker( "show" );
}
function mostrarMensaje(mensaje, tipo){
	if(tipo==1){
		cad = 'success'; 
		cad2 = '¡Éxito!';
	}
	else if(tipo==2){ 
		cad = 'danger';
		cad2 = '¡Error!' 
	}
	else if(tipo==3){ 
		cad = 'warning';
		cad2 = '¡Advertencia!';
	}
	else if(tipo==4){ 
		cad = 'info';
		cad2 = '¡Información!'; 
	}

	var cont = $("<div class='alert alert-" + cad + " alert-dismissible alert-link fade in' role='alert'>"
					+ "<button type='button' class='close' data-dismiss='alert'>"
					+ "<span aria-hidden='true'>&times;</span>"
					+ "</button>"
					+ "<strong>"+ cad2 + "</strong> <a href=''>"+ mensaje+ "</a>"
					+ "</div>");
	
	$(cont).appendTo(".alerts");

	$(cont).fadeOut(10000, 0);

	$(cont).hover(
		function(){
			$(this).stop(true,true).fadeIn();

		},
		function(){
			$(this).fadeOut(4000, 0);
		}
	);

	agregarNotificacion(mensaje,tipo);
}


function crearDialogo(id, titulo, segundoTitulo, size, accion, boton = 'Aceptar', tipo = true){
	if($('.modal').length==0){
		if(size==1)
			cad = '<div class="modal-dialog">';
		else
			cad = '<div class="modal-lg">';

		if(tipo==true)
			cad2 = '<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>';
		else
			cad2 = '';

		if(boton!='')
			cad3 = '<button type="button" class="btn btn-success" onclick="'+accion+'">'+boton+'</button>';
		else
			cad3 = '';

		$('#'+id).remove();
		$(".modal-content").remove();

		$('<div class="modal fade" id="'+id+'">'+
			cad +
				'<div class="modal-content">'+
					'<div class="modal-header">'+
						'<button type="button" class="close" data-dismiss="modal">'+
						'<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'+
						'<h3 class="modal-title" id="myModalLabel">'+titulo+'</h4>'+
						'<h4 class="modal-title" id="myModalLabel">'+segundoTitulo+'</h4>'+
					'</div>'+
					'<div class="modal-body">'+
					

					'</div>'+
					'<div class="modal-footer">'+
						cad3+
						cad2+
					'</div>'+
				'</div>'+
			'</div>'+
		'</div>').appendTo("body");
	}
	else{
		$('#'+id).remove();
		$("#"+id+" .modal-content").remove();
		if(size==1)
			cad = '<div class="modal-dialog">';
		else
			cad = '<div class="modal-lg">';

		if(tipo==true)
			cad2 = '<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>';
		else
			cad2 = '';

		if(boton!='')
			cad3 = '<button type="button" class="btn btn-success" onclick="'+accion+'">'+boton+'</button>';
		else
			cad3 = '';

		$('<div class="modal fade" id="'+id+'" data-backdrop="static">'+
			cad +
				'<div class="modal-content">'+
					'<div class="modal-header">'+
						'<button type="button" class="close" data-dismiss="modal">'+
						'<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'+
						'<h3 class="modal-title" id="myModalLabel">'+titulo+'</h4>'+
						'<h4 class="modal-title" id="myModalLabel">'+segundoTitulo+'</h4>'+
					'</div>'+
					'<div class="modal-body">'+
					

					'</div>'+
					'<div class="modal-footer">'+
						cad3+
						cad2+
					'</div>'+
				'</div>'+
			'</div>'+
		'</div>').appendTo("body");
	}
}



function crearConfirm(titulo,boton,tituloBoton){
	$("<div class='alert alert-black alert-dismissible alert-link fade in' role='alert'>"
					+ "<button type='button' class='close' data-dismiss='alert'>"
					+ "<span aria-hidden='true'>&times;</span>"
					+ "</button>"
					+ "<span id='mensajeConfirm'><strong>"+titulo+"</strong></span>"
					+ "<div id='confirmBtn'>"
					+ "<button class='btn btn-success' onclick="+boton+" class='close' data-dismiss='alert'>"+tituloBoton+"</button>"
					+ "<button type='button' onclick='cancelConfirm()' class='btn btn-danger' class='close' data-dismiss='alert'>Cancelar</button>"
					+ "</div>"
					+ "</div>").appendTo(".alerts");
}

function cancelConfirm(){
	$('#mensajeConfirm').html("<strong>HA DECIDIDO NO ELIMINAR</strong>");
	agregarNotificacion('Se ha cancelado la eliminación',3);
}

function agregarNotificacion(error,tipo){
	
		var elementos = parseInt($("#notificaciones").html());

	console.log(elementos);

	if($('#notificaciones').length)
		$('#notificaciones').html(elementos+1);
	else
		$('<div id="notificaciones">1</div>').appendTo('#notificacion');
	

	if(tipo===1)
		$('<li><a href="#" id="noti'+elementos+'" style="color:green"> <i class="icon-ok"></i> '+error+'</a></li>').appendTo('#notMensaje');
	else if(tipo===2)
		$('<li><a href="#" id="noti'+elementos+'" style="color:red;"> <i class="icon-remove"></i> '+error+'</a></li>').appendTo('#notMensaje');
	else if(tipo===4)
		$('<li><a href="#" id="noti'+elementos+'" style="color:#428BCA;"> <i class="icon-info"></i> '+error+'</a></li>').appendTo('#notMensaje');
	else if(tipo===3)
		$('<li><a href="#" id="noti'+elementos+'" style="color:#FFE13A;text-shadow:0.5px 0.5px black;"> <i class="icon-info-sign"></i> '+error+'</a></li>').appendTo('#notMensaje');
}

function eliminarNotificacion(noti){
	$(noti).remove();
}

function activarCal(){
	$('.date').datetimepicker();
          
}
