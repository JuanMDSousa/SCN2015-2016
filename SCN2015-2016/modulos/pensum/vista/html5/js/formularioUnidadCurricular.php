<form class="form-horizontal"  enctype="multipart/form-data" id="formularioUC">	
	<div class="container-fluid">		
		<div class="row-fluid">
				<div class="col-md-10 col-md-offset-1">		
					<div class="input-group">									
							<span class="input-group-addon">Nombre:</span>
							<input type='text' onkeyup="validarRangos('#nombreUC',2,100,true)" name='nombreUC' id='nombreUC' class='form-control' placeholder='Unidad Curricular'>
						</div>
					</div>
		</div><br><br>
		<div class="row-fluid">
				<div class="col-md-10 col-md-offset-1">		
					<div class="input-group">									
							<span class="input-group-addon">Codigo de Ministerio:</span>
							<input type='text' name='codMinisterio' onkeyup="validarRangos('#codMinisterio',2,30,true)" id='codMinisterio' class='form-control'  placeholder='Codigo de ministerio'>
						</div>
					</div>
		</div><br><br>
		<div class="row-fluid">
				<div class="col-md-10 col-md-offset-1">		
					<div class="input-group" id="selectTipoUnidad">									
						
					</div>
		</div><br><br>
		<div class="row-fluid">
				<div class="col-md-10 col-md-offset-1">		
					<div class="input-group">									
							<span class="input-group-addon">Horas de trabajo acompañado:</span>
							<input type='text' onkeyup="validarSoloNumeros('#hta',1,2,true)" id='hta' class='form-control'  placeholder='Horas de trabajo acompañado'>
						</div>
					</div>
		</div><br><br>
		<div class="row-fluid">
				<div class="col-md-10 col-md-offset-1">		
					<div class="input-group">									
							<span class="input-group-addon">Horas de trabajo independente:</span>
							<input type='text' onkeyup="validarSoloNumeros('#hti',1,2,true)" id='hti' class='form-control' placeholder='Horas de trabajo independiente'>
						</div>
					</div>
		</div><br><br>
		<div class="row-fluid">
				<div class="col-md-10 col-md-offset-1">		
					<div class="input-group">									
							<span class="input-group-addon">Unidades de Crédito</span>
							<input type='text' onkeyup="validarSoloNumeros('#unidadesCredito',1,2,true)" id='unidadesCredito' class='form-control' placeholder='Unidades de credito'>
						</div>
					</div>
		</div><br><br>
		<div class="row-fluid">
			<div class="col-md-10 col-md-offset-1">		
				<div class="input-group">									
					<span class="input-group-addon">Duración en semanas</span>
					<input type='text' onkeyup="validarSoloNumeros('#duracionSemanas',1,3,true)" id='duracionSemanas' class='form-control' placeholder='Duracion en semanas'>
				</div>
			</div>
		</div><br><br>
		<div class="row-fluid">
			<div class="col-md-10 col-md-offset-1">		
				<div class="input-group">									
						<span class="input-group-addon">Nota minima aprobatoria</span>
						<input type='text' onkeyup="validarSoloNumeros('#notaMinima',1,2,true)" id='notaMinima' class='form-control' placeholder='Nota minima aprobatoria'>
					</div>
				</div>
		</div><br><br>
		<div class="row-fluid">
			<div class="col-md-10 col-md-offset-1">		
				<div class="input-group">									
					<span class="input-group-addon">Nota máxima</span>
					<input type='text' onkeyup="validarSoloNumeros('#notaMaxima',1,2,true)" id='notaMaxima' class='form-control' placeholder='Nota máxima'>
				</div>
			</div>
		</div><br><br>
		<div id="botonModificarUnidadCurricular"></div>
		<div><input type="hidden" id="codTray"></div>
		<div><input type="hidden" id="codUni"></div>
		<div><input type="hidden" id="numArrUC"></div>
		<div id="tituloUnidadCurricular"></div>
		<div id="divCheckUC"></div>
	</div>		
</form>	