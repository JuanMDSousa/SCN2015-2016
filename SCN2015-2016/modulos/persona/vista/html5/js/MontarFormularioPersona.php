<form class='form-horizontal' enctype="multipart/form-data" id="formper">
	<div class="container-fluid">		
				<div class="row-fluid">
					<h3><center>Datos Requeridos</center></h3>
							<div class="col-md-3">
								<div class="input-group">
									<span class="input-group-addon">Cédula:</span>
									<input type='text' name='cedula' onkeyup="validarSoloNumeros('#cedula',7,8,true)" id='cedula' maxlength='8' class='form-control' placeholder='Cedula'>
								</div>
							</div>					
							
								<div class="col-md-3">
								<div class="input-group">
									<span class="input-group-addon">Nombre:</span>
									<input type='text' name='nombre1' class='form-control' onkeyup="validarSoloTexto('#nombre1',2,30,true)" id='nombre1' placeholder='Primer Nombre'>
								</div>
							</div>	
							<div class="col-md-3">
								<div class="input-group">
									<span class="input-group-addon">Apellido:</span>
									<input type='text' name='apellido1' class='form-control' onkeyup="validarSoloTexto('#apellido1',2,30,true)" id='apellido1' placeholder='Primer Apellido'>
								</div>
							</div>
						<div class="col-md-3">				
								<div class="input-group">
								<span class="input-group-addon">Sexo:</span>
									<select name='sexo' class='form-control selectpicker' id='sexo'>
										<option value='M'>Masculino</option>
										<option value='F'>Femenino</option>
									</select>	
								</div>
						</div>				
			    </div><br><br><br>

			<h3><center>Datos No Requeridos</center></h3>
				<div class="row-fluid">		
						<div class="col-md-4">
							<div class="input-group">
								<span class="input-group-addon">Segundo Nombre:</span>
								<input type='text' name='nombre2' class='form-control' onkeyup="validarSoloTexto('#nombre2',2,30,false)" id='nombre2' placeholder='Segundo Nombre'>
							</div>
						</div>		
						<div class="col-md-4">
							<div class="input-group">
								<span class="input-group-addon">Segundo Apellido:</span>
								<input type='text' name='apellido2' class='form-control' onkeyup="validarSoloTexto('#apellido2',2,30,false)" id='apellido2' placeholder='Segundo Apellido'>
							</div>
						</div>	
						<div class="col-md-4">
							<div class="input-group">
								<span class="input-group-addon">Rif:</span>
								<input type='text' name='rif' class='form-control' onkeyup="validarRangos('#rif',2,30,false)" id='rif' placeholder='RIF'>
							</div>
						</div>	
						<br><br><br>
						<div class="col-md-3">
							
			                    <input type='text' class="form-control" name="fec_nacimiento"  onfocus='activarFecha("#fec_nacimiento")'  id="fec_nacimiento" placeholder='1990-02-22'>
			                  
			             
						</div>	
						<div class="col-md-4">				
								<div class="input-group">
								<span class="input-group-addon">Tipo de sangre</span>
								<select name="tip_sangre" id="tip_sangre" class="selectpicker" title="Tipo de Sangre">
									<option value="A+">A+</option>
									<option value="A-">A-</option>
									<option value="AB-">AB-</option>
									<option value="AB+">AB+</option>
									<option value="O+">O+</option>
									<option value="O+">O-</option>
									<option value="N/S" selected>N/S</option>
								</select>
								</div>				
						</div>
				</div>			
				<div class="row-fluid">		
						<div class="col-md-4">
						<div class="input-group">
							<span class="input-group-addon"> Telefono:</span>
							<input type='text' name='telefono1' class='form-control' onkeyup="validarTelefono('#telefono1',10,14,false)" id='telefono1' placeholder='####-#######'>
						</div>
					</div>
					<br><br><br>
					<div class="col-md-4">
						<div class="input-group">
							<span class="input-group-addon">Telefono Opcional:</span>
							<input type='text' name='telefono2' class='form-control' onkeyup="validarTelefono('#telefono2',10,14,false)" id='telefono2' placeholder='####-#######'>
						</div>
					</div>		
					<div class="col-md-4">
						<div class="input-group">
							 <span class="input-group-addon"> Correo</span>
							<input type='text' name='cor_personal' class='form-control' onkeyup="validarEmail('#cor_personal',5,50,false)" id='cor_personal' placeholder='ejemplo@correo.com'>
						</div>
					</div>		
					<div class="col-md-4">
						<div class="input-group">
							<span class="input-group-addon"> Correo Institucional:</span>
							<input type='text' name='cor_institucional' class='form-control' onkeyup="validarEmail('#cor_institucional',10,50,false)" id='cor_institucional' placeholder='ejemplo@correo.com'>
						</div>
					</div>
				</div><br><br><br>

				<div class="row-fluid">
					<div class="col-md-12">
						<div class="input-group">
							<span class="input-group-addon"> Dirección:</span>
							<input type='text' name='direccion' class='form-control' id='direccion' placeholder='Dirección'>
						</div>
					</div>				
				</div>
				</div>
				
				<div class="row-fluid">		
						<h3><center>Tipo</center></h3>
						<div class="col-md-5 col-md-offset-5">
							<div class="input-group">					
								<label class="checkbox-inline">
								<input type='checkbox' name='tipo1' id='tipo1' onchange="return actEstudiante();" value='E'>Estudiante 
								</label>
								<label class="checkbox-inline">
								<input type='checkbox' name='tipo2' id='tipo2' onchange="return actDocente();" value='D'>Docente
								</label>
							</div>
						</div>			
				</div><br>
				
				<div class="row-fluid">
					<div id="estudiante" class="col-md-6"></div>
					<div id="docente" class='col-md-6'></div>
				</div>   				    			
	</div>
</form>
	
	
	
	
	
	
	
	
