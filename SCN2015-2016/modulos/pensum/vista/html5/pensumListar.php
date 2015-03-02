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

Nombre: pensumListar.php
Diseñador: Jhonny Vielma
Programador: Jhonny Vielma
Fecha: Enero de 2014
Descripción:  
	Es la vista utilizada para mostrar una lista de pensums desde un
	computador, debe ser llamada desde un objeto VistaComputador, para 
	que de esta forma se pueda acceder a la información agregada a esta
	vista en el objeto PensumControlador.
	
	La información que se espera tener es la siguiente:
	  pensums: arreglo con la lista de pensums según el patrón de
				búsqueda aplicado, o la lista de todos los pensums si 
				es primera vez que entra a la vista
				* 
 * * * * * * * * Cambios/Mejoras/Correcciones/Revisiones * * * * * * * *
Diseñador - Programador /   Fecha   / Descripción del cambio
---                         ----      ---------

 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/

//se extrae la información dela vista para un manejo simplificado
$pensums = $this->obtenerDato('pensums');
$patron = $this->obtenerDato("patron");


?>

<form id="frmPensum" method="post">
	<h2>Lista de Pensum</h2>
	<section class="submenu">
			Buscar: 
			<input type="text" name="patron" id="patronbusqueda" value="<?php echo $patron; ?>" /> &nbsp; 
			<a href=
			'javascript:enviarForm("frmPensum","pensum","listar","html5","pensumListar");'
			>Buscar</a>
			&nbsp; | &nbsp; 
			<a href=
			'javascript:enviarForm("frmPensum","pensum","listar","pdf","PensumListar");'
			><img src="base/imagenes/pdf.jpeg" alt="Ver" width="4%" height="50" title = "Descargar en pdf"/></a>
			&nbsp; | &nbsp; 
			
			<a href=
			'javascript:enviarForm("frmPensum","pensum","listar","txt","PensumListar");'
			><img src="base/imagenes/txt.jpeg" alt="Ver" width="4%" height="50" title = "Descargar en txt"/></a>
			&nbsp; | &nbsp; 
			<a href=
			'javascript:enviarForm("frmPensum","pensum","listar","json","pensumListar");'
			><img src="base/imagenes/json.png" alt="Ver" width="4%" height="50" title = "Descargar en json" /></a>
			&nbsp; | &nbsp; 
			<?php if (Sesion::esDocente()) { ?>
			<a href="javascript:agregarVerModificarPensum('','agregar');"><img src="base/imagenes/icono_mas.GIF" alt="Ver" width="4%" height="50" title = "Agregar nuevo pensum"/></a>
			<?php } ?>
	</section>
	<?php
		if ($pensums != false ) {   ?>
			
			<table style="border:1px solid black; width:100%;">
			
			<thead><!--<td style='text-align:center; width:30%; font-weight:bold;'>Nombre</td> -->
			<td style='text-align:center;font-weight:bold;'>Descripci&oacute;n</td>
			</thead>
			<?php
			foreach ($pensums as $pensum) { ?>
				<tr class="pensum" codigo="<?=$pensum->obtenerCodigo()?>">
				<!--<td >
					<?php echo $pensum->obtenerNombreCorto(); ?>
				</td>   -->
				
				<td> 
					<a href='javascript:enviar("pensum","administrar","html5","pensumt",Array("codigo","<?php echo $pensum->obtenerCodigo(); ?>"))'>
					<?php echo  $pensum->obtenerNombre()  ?>
					</a>
				</td>
					<?php if (Sesion::esDocente()) { ?>
				<td>
					<a href="javascript:agregarVerModificarPensum('<?php echo $pensum->obtenerCodigo() ?>','modificar');"><img src="base/imagenes/Modify.png" alt="Ver" class="icono_pequenio" title = "Modificar pensum" /></a>
					
				</td>
					<?php } ?>
				<td>
					<td>
					<a href="javascript:agregarVerModificarPensum('<?php echo $pensum->obtenerCodigo() ?>','mostrar');"><img src="base/imagenes/lupita.png" alt="Ver" class="icono_pequenio" title = "Mostrar pensum" /></a>
				
					</td>
					<?php if (Sesion::esDocente()) { ?>
					<td>
						<a href="" class="eliminarPensum" id="elimajaxp" codigo="<?php echo $pensum->obtenerCodigo() ?>">
							<img src='base/imagenes/Delete.png' alt='Ver' class='icono_pequenio' title = "Eliminar pensum" />
						</a>
					</td>
					<?php } ?>
				</tr>
				<?php
			}	
			?>
			</table>
			
		<?php
		}else
			echo "<p class=\"mensaje\">No se encontraron coincidencias</p>";
	?>
</form>
