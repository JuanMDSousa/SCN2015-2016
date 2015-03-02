<form id="frmunidades" method="post">
<form id="frmunidades" method="post">
<table id="formulario">
				<tr>
					<td><span style="color: red">*</span> Código ministerio:</td>
					<td>
						<input name="codUniMinisterioA" id="codUniMinisterioA" type="text"  class="obligatorio" value=""></input>
						<label id="codUniMinis"></label>
					</td>
				</tr>
				<tr>
					<td><span style="color: red">*</span> Nombre:</td>
					<td>
						<input name="nombreA" id="nombreA" type="text" class="obligatorio"  value=""></input>
						<label id="nomb"></label>
					</td>
				</tr>
				<tr>
					<td><span style="color: red">*</span> Tipo:</td>
					<td>
						<select name="tipoA" id="tipoA" >
								
							<option value="A">Actividades</option>
							<option value="C">Cursos</option>
							<option value="P">Proyectos</option>
							<option value="S">Seminarios</option>
							<option value="T">Talleres</option>
									
						</select>
							<label id="tip"></label>
					</td>
				</tr>
				<tr>
					<td><span style="color: red">*</span> Unidades de crédito:</td>
					<td>
						<input name="uniCreditoA" id="uniCreditoA" type="text" class="obligatorio" value=""></input>
						<label id="uniCre"></label>
					</td>
				</tr>
				<tr>
					<td><span style="color: red">*</span> Horas Trabajo Independiente:</td>
					<td>
						<input name="htiA" id="htiA" type="text" class="obligatorio" value=""></input>
						<label id="htIndepen"></label>
					</td>
				</tr>
				<tr>
					<td><span style="color: red">*</span> Horas Trabajo Acompañado:</td>
					<td>
						<input name="htaA" id="htaA" type="text" class="obligatorio"  value=""></input>
						<label id="htAcompa"></label>

					</td>
				</tr>
				<tr>
					<td><span style="color: red">*</span> Duración en semanas:</td>
					<td>
						<input name="durSemanasA" id="durSemanasA" type="text" class="obligatorio"  value=""></input>
						<label id="durSema"></label>

					</td>
				</tr>
				<tr>
					<td><span style="color: red">*</span> Nota Mínima:</td>
					<td>
						<input name="notMinimaA" id="notMinimaA" type="text" class="obligatorio"  value=""></input>
						<label id="notMini"></label>

					</td>
				</tr>
				<tr>
					<td><span style="color: red">*</span> Nota Máxima:</td>
					<td>
						<input name="notMaximaA" id="notMaximaA" type="text" class="obligatorio"  value=""></input>
						<label id="notMaxi"></label>

					</td>
				</tr>			
			</table>
			<input type="hidden" name="codigoTra"  id="codigoTra"
				value="<?php echo $trayecto->obtenerCodigo(); ?>" />
			
</form>
</form>
