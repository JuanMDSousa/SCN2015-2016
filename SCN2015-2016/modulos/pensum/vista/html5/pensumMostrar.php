<?php
/*
 * * * * * * * * * * LICENCIA * * * * * * * * * * * * * * * * * * * * *

Copyright(C) 2012
Pensum Universtiario de Tecnología Dr. Federico Rivero Palacio

Este programa es Software Libre y usted puede redistribuirlo y/o modificarlo
bajo los términos de la versión 3.0 de la Licencia Pública General (GPLv3)
publicada por la Free Software Foundation (FSF), es distribuido sin ninguna
garantía. Usted debe haber recibido una copia de la GPLv3 junto con este
programa, sino, puede encontrarlo en la página web de la FSF, 
específicamente en la dirección http://www.gnu.org/licenses/gpl-3.0.html

 * * * * * * * * * * ARCHIVO * * * * * * * * * * * * * * * * * * * * *

Nombre: PensumMostrar.php
Diseñador: 
Programador: 
Fecha: Agosto de 2012
Descripción:  
	Es la vista utilizada para mostrar la información de un pensum en
	particular desde un computador, debe ser llamada desde un objeto
	VistaComputador, para que de esta forma se pueda acceder a la información
	agregada a esta	vista en el objeto PensumControlador.
	
	La información que se espera tener es la siguiente:
	  pensums: arreglo con el único objeto Pensum a mostrar
	 
	  
 * * * * * * * * Cambios/Mejoras/Correcciones/Revisiones * * * * * * * *
Diseñador - Programador /   Fecha   / Descripción del cambio
---                         ----      ---------

 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/

//extracción del pensum para un manejo simplificado
$pensums = $this->obtenerDato('pensums');
$trayecto = $this->obtenerDato('obtenerTrayecto');
$UC = $this->obtenerDato('obtenerUC');
$pensum = $pensums;
$patron = $pensum->obtenerCodigo();

?>

<div class="contenido">
	<div class="cont">

		<form name="frmPensum" method="post">
		
			<input type="hidden" name="modulo" />
			<input type="hidden" name="accion" />
			<input type="hidden" name="tipoVista" />
			<input type="hidden" name="codigo" />
			<input type="hidden" name="buscar" />
			<input type="hidden" name="codPensum" />
			
			
			<input type="hidden" name="codigoPensumAModificar" 
				value="<?php echo $pensum ? $pensum->obtenerCodigo(): ''; ?>" 
			/>
			<input type="hidden" name="nombreCortoPensum" 
				id="nombreCortoPensum" 
				value="<?php echo $pensum ? $pensum->obtenerNombreCorto(): ''; ?>" 
			/>

			<h1>Informaci&oacute;n del pensum</h1>

			
			<p class="menucentro">
				

						<a href='javascript:enviar("pensum","premodificar","html5","PensumAgregarModificar",Array("codigo","<?php echo $pensum->obtenerCodigo() ?>"))'> Modificar Pensum</a>
						&nbsp; &nbsp; | &nbsp;&nbsp;
						<a href='javascript:pensumEliminar("<?php echo $pensum->obtenerCodigo() ?>", "<?php echo  $pensum->obtenerNombre() ?>")'> Eliminar Pensum</a>
						&nbsp; &nbsp; | &nbsp;&nbsp;
				
				<a href='javascript:enviar("pensum","listar","html5","PensumListar");'>Ver todos</a>
				&nbsp; &nbsp; | &nbsp;&nbsp;
<?php //if($_SESSION['tipo']== 'A'){ ?>			
	<a href=
			'javascript:enviar("pensum","preagregar","html5","PensumAgregarModificar");'
			>Agregar nuevo</a>
				&nbsp; &nbsp; | &nbsp;&nbsp;
<?php //} ?>
<a href='javascript:enviar("pensum","listarT","html5","TrayectoListar",Array("codigo",<?php echo $pensum->obtenerCodigo();?>));'> Listar trayectos</a>
				&nbsp; &nbsp; | &nbsp;&nbsp;	
						

			
			</p>

			<table id="formulario">
				<?php				
					if ($pensum) {
						
						echo "<tr>
								<td>Nombre corto:</td>
								<td>" . $pensum->obtenerNombreCorto() . "</td>
							  </tr>";
						echo "<tr>
								<td>Nombre:</td>
								<td>" . $pensum->obtenerNombre() . "</td>
							  </tr>";
						echo "<tr>
								<td>Observaciones:</td>
								<td>" . $pensum->obtenerObservaciones() . "</td>
							  </tr>";
					}else
						echo "<tr><td><p class=\"mensaje\">Pensum no v&aacute;lido</p></td></tr>";
				?>
			</table>
			<center>
			<br>
			Informaci&oacute;n de Trayectos Correspondientes al <?php echo $pensum->obtenerNombreCorto(); ?>
			<br>
			</center>
			<table id="formulario">
				<!--<tr>
					<td align="center">Trayecto </td>					
					 <td align="center">Certificado</td> 
				</tr>z				-->
				<?php
				
				if(($trayecto != NULL)){
						
					$UC = $this->obtenerDato('obtenerUC');		
						for($i=0;$i<count($trayecto);$i++){	
							echo "<tr><th>Trayecto ". $trayecto[$i]->obtenerNumero() ."</th></tr>";						
								for($x = 0 ; $x < count($UC[$i]);$x++){
									if(is_object($UC[$i][$x])){								
													
										echo "<tr><td><a href=\"javascript:enviar('pensum','mostrarUC','html5','uniCurricularMostrar',Array('codigo'," . $UC[$i][$x]->obtenerCodigo() . ",'codPensum',".$pensum->obtenerCodigo()."));\">". $UC[$i][$x]->obtenerNombre(). "</td></tr>";						
									}else{							
										echo "<tr><td>No Hay Unidades Curriculares Cargadas Para este trayecto</td></tr>";								

										}		
								}  
						} 
				}else{
					echo "<br><div align='center'>Este Pensum no posee trayectos y/o unidades curriculares agregadas</div>";
					}	
				?>
			</table>
		</form>
	</div>
</div>

