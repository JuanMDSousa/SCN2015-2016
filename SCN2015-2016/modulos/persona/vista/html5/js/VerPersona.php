<form class='form-horizontal' id='formulariopersonaver'>

	<div class="container-fluid">	
		<h3><center>Información Personal</center></h3>
		<div class="row-fluid">
			<div class="col-md-4 col-md-offset-2">
				<div class="input-group">
					<span class="input-group-addon" title="Cédula">Cédula:</span>
					<input type='text' name='cedula' id='cedula' maxlength='8' class='form-control'  placeholder='Cedula' disabled='disabled'>
				</div>
			</div>	
			<div class="col-md-4">
					<div class="input-group">
						<span class="input-group-addon" title="Rif">Rif:</span>
						<input type='text' name='rif' onkeyup="validarRangos('#rif',2,30,false)" id='rif' maxlength='8' class='form-control'  placeholder='Rif' disabled='disabled'>
					</div>
			</div>	
			<br><br><br>
			<div class="col-md-4 col-md-offset-2">
				<div class="input-group">
					<span class="input-group-addon" title="Nombre">Nombre:</span>
					<input type='text' name='nombre1' class='form-control' onkeyup="validarSoloTexto('#nombre1',2,30,true)" id='nombre1' placeholder='Primer Nombre' disabled='disabled'>
				</div>
			</div>
				
			<div class="col-md-4">
				<div class="input-group">
					<span class="input-group-addon" title="Apellido">Apellido:</span>
					<input type='text' name='apellido1' class='form-control' onkeyup="validarSoloTexto('#apellido1',2,30,true)" id='apellido1' placeholder='Primer Apellido' disabled='disabled'>
				</div>
			</div>	
		</div>	
		<br><br><br>
		
		<div class="row-fluid">	
			<div class="col-md-4 col-md-offset-2">
				<div class="input-group">
					<span class="input-group-addon" title="Cédula">Segundo Nombre:</span>
					<input type='text' name='nombre2' class='form-control' onkeyup="validarSoloTexto('#nombre2',2,30,false)" id='nombre2' placeholder='Segundo Nombre' disabled='disabled'>
				</div>
			</div>		
			<div class="col-md-4">
				<div class="input-group">
					<span class="input-group-addon" title="Cédula">Segundo Apellido:</span>
					<input type='text' name='apellido2' class='form-control' onkeyup="validarSoloTexto('#apellido2',2,30,false)" id='apellido2' placeholder='Primer Apellido' disabled='disabled'>
				</div>
			</div>
			<br><br><br>
			<div class="col-md-4 col-md-offset-2">
				<div class="input-group">					
					<span class="input-group-addon" title="Sexo">Sexo:</span>
					<div id="selectSexo"></div>
					<input type='text' name='sexo' class='form-control' id='sexo' disabled='disabled'>					
				</div>
			</div>
			<div class="col-md-4">
				<div class="input-group">
					 <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
					<input type='text' name='fec_nacimiento' class='form-control' id='fec_nacimiento' placeholder='####-##-##' disabled='disabled'>
				</div>
			</div>		
		</div>
		<br><br><br>
		<div class="row-fluid">
			<div class="col-md-4 col-md-offset-2">
				<div class="input-group">
					<span class="input-group-addon" title="Cédula"> Telefono:</span>
					<input type='text' name='telefono1' class='form-control' onkeyup="validarTelefono('#telefono1',10,14,false)" id='telefono1' placeholder='####-#######' disabled='disabled'>
				</div>
			</div>
			<div class="col-md-4">
				<div class="input-group">
					<span class="input-group-addon" title="Cédula">Telefono 2:</span>
					<input type='text' name='telefono2' class='form-control' onkeyup="validarTelefono('#telefono2',10,14,false)" id='telefono2' placeholder='####-#######' disabled='disabled'>
				</div>
			</div>	
		</div>
		<br><br><br>
		<div class="row-fluid">		
			<div class="col-md-4 col-md-offset-2">
				<div class="input-group">
					 <span class="input-group-addon" title="Correo Personal">Correo Personal</span>
					<input type='text' name='cor_personal' class='form-control' onkeyup="validarEmail('#cor_personal',5,50,false)" id='cor_personal' placeholder='ejemplo@correo.com' disabled='disabled'>
				</div>
			</div>				
			<div class="col-md-4">
				<div class="input-group">
					<span class="input-group-addon" title="Cédula">Correo Institucional</span>
					<input type='text' name='cor_institucional' class='form-control' onkeyup="validarEmail('#cor_institucional',5,50,false)" id='cor_institucional' placeholder='ajemplo@correo.com' disabled='disabled'>
				</div>
			</div>		
			<br><br><br>
			<div class="col-md-4 col-md-offset-2">
				<div class="input-group">					
					<span class="input-group-addon" title="Cédula">Tipo Sangre</span>
					<div id="selectsang">
						<input type='text' name='tip_sangre' class='form-control' id='tip_sangre' placeholder='' disabled='disabled'>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="input-group">
					<span class="input-group-addon" title="Cédula"> Dirección:</span>
					<input type='text' name='direccion' class='form-control' id='direccion' placeholder='Dirección' disabled='disabled'>
				</div>
			</div>									
		</div>	
		<br><br><br>
		
		<div class="row-fluid">
			<div class="col-md-12"><center>
				<div class="input-group">				
					<input type='button' id="btnModificar" value="Activar Modificar" onclick="activarmodif()" class="btn btn-warning">
				</div></center>
			</div>
							
		</div>	
	</div>			
</form>
	
	
	
	
	
	
	
	
