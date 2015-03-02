
<?php
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

Nombre: LoginMostrar.php
Diseñador: Katherine Rios (kathyr2d2@gmail.com)
Programador: Katherine Rios
Fecha: febrero de 2013
Descripción:  
	
	Es la vista utilizada para mostrar la pantalla de inicio de sesión 
	desde un computador, debe ser llamada desde un objeto VistaComputador,
	para que de esta forma se pueda acceder a la información
	agregada a esta	vista en el objeto LoginControlador.
	
	La información que se espera tener es la siguiente:
	 Iniciar sesión y entrar al sistema cargando los datos dependiendo de los permisos
	 de los usurarios (Administrador, básico, consultor) o en el caso opuesto, emitir un
	 mensaje de error si el usuario no existe en la base de datos
	  
 * * * * * * * * Cambios/Mejoras/Correcciones/Revisiones * * * * * * * *
Diseñador - Programador /   Fecha   / Descripción del cambio
---                         ----      ---------

 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/

$usuarioIncorrecto = $this->obtenerDato("usuarioIncorrecto");

?>

<div class='contenedor'>
	<div>
        <form name="frmLogin" id="frmLogin" method="post">
            <input type="hidden" name="m_modulo" />
            <input type="hidden" name="m_accion" />
            <input type="hidden" name="m_formato" />
             
			
			<div class="bienvenida">
				<center><h1>Bienvenido al Sistema Administrador<br> 
					de pensums para el departamento de Inform&aacute;tica </h1></center>
		    </div>

			<table class="datoSesion" cellspacing="10">
				<tr>
					<td>Cédula </td>
					<td><input type="text" class="obligatorio" onkeypress="return event.keyCode!=13" onkeyup="if(event.keyCode==13){javascript:obtenerLogin();}" name="login" id="login" size="25" maxlength="30"></td>
				</tr>
				<tr>
					<td>Contrase&ntilde;a</td>
					<td><input type="password" class="obligatorio" onkeypress="return event.keyCode!=13" onkeyup="if(event.keyCode==13){javascript:obtenerLogin();}" name="passwd" id="passwd" size="25" maxlength="25"></td>
				</tr>
				<tr>
					<td>Tipo de usuario</td>
					<td>
						<select name=tipo >
											
						<option value="D"> docente </option>
						<option value="E"> estudiante </option>
						</select>
					</td>
				</tr>
				<tr>
                	<th colspan="2">
                    	<a href=
								'javascript:enviarForm("frmLogin","login","iniciar","html5","index");'
			>iniciar sesión</a> 
     				</th>
                </tr>
			</table>
             <center style='padding-top: 5px;'>
				<?php 
					if (($usuarioIncorrecto) and ( ! is_null($usuarioIncorrecto)) ){
						echo "<script language='JavaScript'>";
						echo "alert('datos de autentificación incorrectos');";
						echo "</script>";
					}
						
				?>
			</center>		
        </form>    
	</div>	
		
</div>
