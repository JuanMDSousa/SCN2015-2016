<form class="form-horizontal"  enctype="multipart/form-data" id="formpen">	
	<div class="container-fluid">		
		<div class="row-fluid">
				<div class="col-md-10 col-md-offset-1">		
					<div class="input-group">									
							<span class="input-group-addon">Nombre Completo:</span>
							<input type='text' name='nombre' onkeyup='validarSoloTexto("#nombre",5,60,true)' id='nombre' maxlength='50' class='form-control'  placeholder='Nombre'>
						</div>
					</div>
		</div><br><br>
		<div class="row-fluid">
				<div class="col-md-10 col-md-offset-1">		
					<div class="input-group">									
							<span class="input-group-addon">Nombre Corto:</span>
							<input type='text' name='nom_corto' onkeyup='validarSoloTexto("#nom_corto",2,6,true)' id='nom_corto' maxlength='25' class='form-control'  placeholder='Nombre Corto'>
						</div>
					</div>
		</div><br><br>
		<div class="row-fluid">
				<div class="col-md-10 col-md-offset-1">		
					<div class="input-group">									
							<span class="input-group-addon">Observaciones:</span>
							<input type='text' name='observaciones' id='observaciones' maxlength='25' class='form-control'  placeholder='Observaciones'>
						</div>
					</div>
		</div><br>
	</div>		
</form>	
