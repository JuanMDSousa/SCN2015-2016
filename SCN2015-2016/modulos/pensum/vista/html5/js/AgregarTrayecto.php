<form class="form-horizontal"  enctype="multipart/form-data" id="formpen">	
	<div class="container-fluid">		
		
		<div class="row-fluid">
				<div class="col-md-10 col-md-offset-1">		
					<div class="input-group">									
							<span class="input-group-addon">Número de Trayecto</span>
							<input type='text' name='num_trayecto' onkeyup='validarSoloNumeros("#num_trayecto",1,3,true)' id='num_trayecto' maxlength='3' class='form-control'  placeholder='#' >
						</div>
					</div>
		</div><br><br>
		

		<div class="row-fluid">
				<div class="col-md-10 col-md-offset-1">		
					<div class="input-group">									
							<span class="input-group-addon">Certificado</span>
							<input type='text' name='certificado' onkeyup='validarSoloTexto("#certificado",5,50,false)' id='certificado' maxlength='50' class='form-control'  placeholder='Licenciatura'>
						</div>
					</div>
		</div><br><br>
		
		<div class="row-fluid">
				<div class="col-md-10 col-md-offset-1">		
					<div class="input-group">									
							<span class="input-group-addon">Mínimo de Crédito</span>
							<input type='text' name='min_credito' onkeyup='validarSoloNumeros("#min_credito",1,3,true)' id='min_credito' maxlength='3' class='form-control'  placeholder='#'>
						</div>
					</div>
		</div><br><br>
		<div id="modificar" onclick="preModificarTrayecto()"></div>
	</div>		
</form>	
