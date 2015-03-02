<?php
$pensums = $this->obtenerDato('pensums');

?>
<table border="0px solid red" width="100%" align="center" height="100%">
	<tr><td align="center">
		<form id="frmPensum" method="post">
			<input type="hidden" name="modulo" />
			<input type="hidden" name="accion" />
			<input type="hidden" name="tipoVista" />
			<input type="hidden" name="codigo"  id="codigo"
				value="<?php echo $pensums->obtenerCodigo(); ?>" />
			<?php if (Sesion::esDocente())
						$usuario="docente";
			      else
						$usuario= "estudiante";
			 ?>
			<input type="hidden" name="usuario"  id="usuario"
				value="<?php echo $usuario ?>" />
			<div id="nombrePensumPrincipal" >
				<h2>Información del Pensum <?php echo $pensums->obtenerNombre(); ?> </h2>
			</div>
			<section class="submenu">
			<?php

			?>

			
			</section>
			<div>
				<table style="width:100%;">
				<tr>
					<td>
							Nombre Corto: <span id="nombreCortoPensum" ><?php echo $pensums->obtenerNombreCorto()?></span><br />
							Nombre: <span id="nombreCompletoPensum"><?php echo $pensums->obtenerNombre() ?></span><br />
							Observaciones:<span id="observacionesPensum12"> <?php echo $pensums->obtenerObservaciones() ?> </span>
							
						
					</td>
					<td>
						<div id="iconosPensum" style="text-align:right; display:inline"> 
							<?php if (Sesion::esDocente()) { ?>
								<a class="eliminarPensum" codigo="<?php echo $pensums->obtenerCodigo() ?>"><img src='base/imagenes/Delete.png' width="50px" height="50px" alt='Ver' title = "Eliminar Pensum" /></a>
								<a href="javascript:agregarVerModificarPensum('<?php echo $pensums->obtenerCodigo() ?>','modificar');"><img src="base/imagenes/Modify.png" alt="Ver"  width="50px" height="50px" title = "Modificar Pensum" /></a>
							<?php } ?>
							<a href='javascript:enviar("pensum","mostrar","pdf","pensumMostrarPDF",Array("codigo",1));'><img src="base/imagenes/pdf.jpeg" alt="Ver"  width="50px" height="50px" title = "Descargar en pdf" /> </a>
						</div>
					</td>
				</tr>
				</table>
			</div>


		</form>

	</td></tr>
</table>



<div id="bio">
	<table id="trayectos" style="border:1px solid black; width:100%;">
		<thead><td><h2>Trayectos correspondientes:
		<?php if (Sesion::esDocente()) { ?>
		 <a href="javascript:agregarVerModificarTrayecto('','agregar','<?=$pensums->obtenerCodigo() ?>');"><img src="base/imagenes/icono_mas.GIF" alt="Ver" width="3%" height="50" title = "Agregar Trayecto" /></a> <?php } ?> </h2></td></thead>
		
	</table>
</div>
