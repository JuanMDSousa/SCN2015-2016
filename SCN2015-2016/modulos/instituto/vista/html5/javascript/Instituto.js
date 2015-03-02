
permiso=new Per();
/*Funcion que permite abrir el dialogo de instituto con su formulario 
 * correspondiete si el parametro montar imput se pasa e true.
 * 		parametros de entrada: nombreDialogo-> id del dialogo a crear
 * 							   tituto-> titutlo para el dialogo.
 * 							   tipoAccion->accion a ejecutar.
 * 							   montarImput- > true o false para motar los imput
 * */
function  abrirDialogoInstituto(nombreDialogo,titulo,tipoAccion,montarImpu=true){
	$('.modal').remove();
	$('#'+nombreDialogo).remove();
	crearDialogo(nombreDialogo,titulo,'',1,tipoAccion);
	if (montarImpu==true)
		montarImput();
}
/*Funcion que arma y ejecuta la peticion ajax para agregar un instituto 
 * a la base de datos, esta funcion agarra los valores de los imput y los manda
 * al servidor meidante ajax.
 * */
function agregarInstituto(){
	
	if (validarCampos()){
		var a=Array("m_modulo","instituto","m_accion","agregar",
					"m_vista","Agregar","nombre",$("#nombreI").val(),"nombreC",$("#nombreCI").val(),
					"direccion",$("#direccionI").val() );
		ajaxMVC(a,succAgregar,error);	
	}
}
/*fucion cuando el agregar por ajax es exitoso, esta funcion
 * se encarga de darle el mensaje al usuario y procesar la data
* viene del servdor.
* 		Parametros de etrada: data-> arreglo de informacion
 * */
function succAgregar(data){
	if(data.estatus>0){
		mostrarMensaje(data.mensaje,1);
		actualizar();
		$("#dialogoInstituto").modal('hide');
	}
	else 
		mostrarMensaje(data.mensaje,2);
}
/*fucion que se ejecuta cuando ocurre un error en el servidor
 * y no se procesa la peticion ajax con exito.
 * 		Parametros de entrada: data->arreglo de errores.
 * */
function error(data){
		mostrarMensaje("error error: " + data.responseText,2);
}
/*funcion que valia los campos del formulario de instituto para no 
 * posser error al momento de agregarla, esta funcion obtiene los value de los
 * imput.
 * */
function validarCampos(){
	if ((validarRangos('#direccionI',1,200,false))  && (validarSoloTextoYCaracteres('#nombreCI',1,20,true)) && (validarSoloTextoYCaracteres('#nombreI',1,100,true)))
		return true
}
/*funcion que carga los imput desde el servidor y los carga en el modal
 * de instituto mediante un load.
 * */
function montarImput(){
	$(".modal-body").load("modulos/instituto/vista/html5/FormularioInstituto.html");

}
/*Funcion que arma y ejecuta la peticion ajax para modificar un instituto 
 * a la base de datos, esta funcion agarra los valores de los imput y los manda
 * al servidor meidante ajax.
 * 		Parametros de entrada: codigo->codigo del instituto
 * */
function modificarInstituto(codigo){
	abrirDialogoInstituto("dialogoInstituto","modificar Instituto","modificar()",true);
	
	var a=Array("m_modulo","instituto","m_accion","obtener",
					"m_vista","Obtener","codigo",codigo);
	ajaxMVC(a,succObtener,error);
	
}
/*Funcion que arma y ejecuta la peticion ajax para eliminar un instituto 
 * a la base de datos, esta funcion agarra los valores de los imput y los manda
 * al servidor meidante ajax.
 * 		Parametros de entrada: codigo-Zcodigo del instituto a eliminar.
 * */
 
function eliminarInstituto(codigo){
	abrirDialogoInstituto("dialogoInstituto","Eliminar Instituto","eliminar()",false);
	
	var a=Array("m_modulo","instituto","m_accion","obtener",
					"m_vista","Obtener","codigo",codigo);
	ajaxMVC(a,succObtenerE,error);
	
}
/*Funcion que arma y ejecuta la peticion ajax para modificar un instituto 
 * a la base de datos, esta funcion agarra los valores de los imput y los manda
 * al servidor meidante ajax.
 * */
function modificar(){
	if (validarCampos()){
		var a=Array("m_modulo","instituto","m_accion","modificar",
					"m_vista","Modificar","nombre",$("#nombreI").val(),"nombreC",$("#nombreCI").val(),
					"direccion",$("#direccionI").val(),"codigo",$("#codigoI").val() );
		ajaxMVC(a,succModificar,error);	
	}
	
}
/*fucion cuando el modificar por ajax es exitoso, esta funcion
 * se encarga de darle el mensaje al usuario y procesar la data
* viene del servdor.
 * */
function succModificar(data){
	if(data.estatus>0){
		mostrarMensaje(data.mensaje,1);
		actualizar();
		$("#dialogoInstituto").modal('hide');
	}
	else 
		mostrarMensaje(data.mensaje,2);
}

/*fucion cuando el obtener por ajax es exitoso, esta funcion
 * se encarga de darle el mensaje al usuario y procesar la data
* viene del servdor.
 * */
function succObtener(data){
	if(data.estatus>0){
		$("#nombreI").val(data.instituto[0]['nombre']);
		$("#nombreCI").val(data.instituto[0]['nom_corto']);
		$("#direccionI").val(data.instituto[0]['direccion']);
		$("#codigoI").val(data.instituto[0]['codigo']);
	}
	else 
		mostrarMensaje(data.mensaje,2);
}
/*fucion cuando el eliminar por ajax es exitoso, esta funcion
 * se encarga de darle el mensaje al usuario y procesar la data
* viene del servdor.
 * */

function eliminar(){
	var a=Array("m_modulo","instituto","m_accion","eliminar",
					"m_vista","Eliminar","codigo",$("#codigoI").val());
		ajaxMVC(a,succEliminar,error);	
	
}
/*fucion que arma ua peticion ajax para traer la lista de institutos de la base de datas
 * para cargarlos a la pagina dinamicamente..
 * */
function actualizar(){
	var a=Array("m_modulo","instituto","m_accion","listar",
					"m_vista","Listar");
		ajaxMVC(a,succListar,error);	
}

/*fucion que se ejecuta cuiando la peticion ajax de actualizar ocurre perfectamente,
 * esta funcion se encarga de remover la lista vieja y agregarla a la pgina ya actualizada.
 * */

function succListar(data){
	
	if(data.estatus>0){
		$('#tTabla').remove();
		cadena="<table class='table' id='tTabla'>";
		cadena+="<tr class='titulo'>";
		cadena+=" <td>Nombre Instituto</td>";
		cadena+=" <td>Nombre Corto</td>";
		cadena+="<td>Direccion</td>";
		cadena+="<td></td>";
		cadena+="<td></td>";
		cadena+="</tr>";
		for (i=0;i<data.institutos.length;i++){
			cadena+="<tr>";
			cadena+=" <td style='text-align:left;'>"+data.institutos[i]['nombre']+"</td>";
			cadena+=" <td>"+data.institutos[i]['nom_corto']+"</td>";
			if (data.institutos[i]['direccion']=="")
				cadena+="<td>No asignada</td>";
			else
				cadena+="<td>"+data.institutos[i]['direccion']+"</td>";
			cadena+="<td>";
			if (permiso.instituto.update){
			cadena+="<button type='button' class='btn btn-primary' onClick='modificarInstituto("+data.institutos[i]['codigo']+")' data-toggle='modal' data-target='#dialogoInstituto' title='Modificar Instituto'>";
			cadena+="<i class='icon-pencil'></i>"
			cadena+="</button>";
			}
			cadena+="</td>";
			cadena+="<td>"
			if (permiso.instituto.delete){
			cadena+="<button type='button' class='btn btn-danger' onClick='eliminarInstituto("+data.institutos[i]['codigo']+")' data-toggle='modal' data-target='#dialogoInstituto' title='Eliminar Instituto'>"
			cadena+="<i class='icon-trash'></i>"
			cadena+="</button>";
		}
			cadena+="</td>";
			cadena+="</tr>";
		
		}
		cadena+="</table>";
		$(cadena).appendTo("#listarI");
	}
	else 
		mostrarMensaje(data.mensaje,2);
}
/*fucion que se ejecuta cuiando la peticion ajax de elimiar ocurre perfectamente,
 * y cerrar el modal del isntituto y se actualiza la pagina
 * */
function succEliminar(data){
	if(data.estatus>0){
		mostrarMensaje(data.mensaje,1);
		actualizar();
		$("#dialogoInstituto").modal('hide');
	}
	else 
		mostrarMensaje(data.mensaje,2);
}
/*fucion que se ejecuta cuiando la peticion ajax de obtener ocurre perfectamente,
 * esta para elimiar el instituto observando toda su data.
 * */
function succObtenerE(data){
	if(data.estatus>0){
		$("<h3> Esta seguro que quiere eliminar el instituto:</h3>").appendTo(".modal-body");
		cadena="<input type='hidden' value='"+data.instituto[0]['codigo']+"' class='form-control' placeholder='codigo Instituto' id='codigoI'>";
		$(cadena).appendTo(".modal-body");
		
		$("<br>").appendTo(".modal-body");
		cadena= "<h4>Nombre: "+data.instituto[0]['nombre']+"</h4>";
		$(cadena).appendTo(".modal-body");
		cadena= "<h4>Nombre Corto : "+data.instituto[0]['nom_corto']+"</h4>";
		$(cadena).appendTo(".modal-body");
		cadena= "<h4>Dirección : "+data.instituto[0]['direccion']+"</h4>";
		$(cadena).appendTo(".modal-body");
	}
	else 
		mostrarMensaje(data.mensaje,2);
}




