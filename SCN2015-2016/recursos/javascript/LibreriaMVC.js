
/*Función que permite convertir una matriz en un formato json, es especialmente
 * utilizada para hacer llamadas ajax al servidor. 
 * parámetros de entrada:
 * 		m: arreglo con los datos a convertir
 * valor de salida:
 * 		un objeto json.
 * 
 * ejemplo:
 * 		entrada
 * 			Array("m_modulo","periodo", "m_vista","listarTrayectos","codPeriodo", 101);
 * 
 * 		salida:
 * 			{m_modulo:"periodo", m_vista:"listarTrayectos",codPeriodo: 101}
 */
function armarDato(m){
	var data = {m_formato: "json"};
	for (var i = 0 ; i < m.length; i+= 2)
		data[m[i]]  = m[i+1];
	return data;
}
/* Función que permite hacer una llamada ajax al servidor. Es específica del MVC
 * Parámtros de entrada:
 * a: arreglo que contiene los parámetros a enviar al servidor, las posiciones
 *    impares representan el nombre del parámetro, las posiciones pares 
 * 	  representan el valor del parámetro de la posición anterior
 * 		ejemplo: 
 * 		var m = Array("m_modulo","periodo",
						"m_accion","listarTrayectos",
						"m_vista","listarTrayectos",
						"codPeriodo", 101);
	funcSucc: parámetro que representa la función que se ejecutará cuando 
 *         la llamada ajax tenga éxito. 
 *	funcErr: parámetro que representa la función que se ejecutará cuando 
 * 			la llamada ajax presente un error.
 */ 
var ajaxMVC=function (a, funcSucc, funcErr){
	$.ajax({
			type:"post",
			dataType:"json",
			url: "index.php",
			data: armarDato(a),
			success: funcSucc,
			error: funcErr
		});	
}
