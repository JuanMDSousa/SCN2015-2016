<!--
Este archivo es un formulario que se carga con un load en el archivo docente.js,
para poder montar el formulario de ver el docente y asi poder ver todos sus datos personales 
traidos de la base de datos
-->

<form class='form-horizontal' id='formulariopersona' method="post" action="...">
	<div class="container">	


	<div class="row-fluid">		
			<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon">Nombre:</span>
					<input type='text' name='nombre1' class='form-control' disabled="disabled" id='nombre1' placeholder='Nombre'>
				</div>
			</div>		
			<div class="col-md-6">
				<div class="input-group">
				<span class="input-group-addon">Apellido:</span>
					<input type='text' name='apellido1' class='form-control' disabled="disabled" id='apellido1' placeholder='Apellido'>
				</div>
			</div>											
		</div>	<br><br><br>

		<div class="row-fluid">		
			<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon">Cédula:</span>
					<input type='text' name='cedula' class='form-control' disabled="disabled" id='cedula' placeholder='Cédula'>
				</div>
			</div>		
			<div class="col-md-6">
				<div class="input-group">
				<span class="input-group-addon">Rif:</span>
					<input type='text' name='rif' class='form-control' disabled="disabled" id='rif' placeholder='Rif'>
				</div>
			</div>											
		</div>	<br><br><br>

	<div class="row-fluid">		
			<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon">Depto:</span>
					<div id="selectDep"></div>
					<input type='text' name='nom_departamento' class='form-control' disabled="disabled" id='departamentoDoc' placeholder='Departamento'>
				</div>
			</div>		
			<div class="col-md-6">
				<div class="input-group">
				<span class="input-group-addon">Estado:</span>
					<div id="selectEst"></div>
					<input type='text' name='estado' class='form-control' disabled="disabled" id='estadoDoc' placeholder='Estado'>
				</div>
			</div>											
		</div>	<br><br><br>

		<div class="row-fluid">		
			<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon">Telefono:</span>
					<input type='text' name='telefono1' class='form-control' disabled="disabled" id='telefono1' placeholder='Teléfono'>
				</div>
			</div>		
			<div class="col-md-6">
				<div class="input-group">
				<span class="input-group-addon">Correo Personal:</span>
					<input type='text' name='cor_personal' class='form-control' disabled="disabled" id='cor_personal' placeholder='Correo Personal'>
				</div>
			</div>											
		</div>	<br><br><br>
	
	<div class="row-fluid">		
			<div class="col-md-2 col-md-offset-4">
				<div class="input-group">				
					<input type='button' id="modificar" value="Activar Modificar" onclick='activarModificar()' class="btn btn-warning";>
				</div>
			</div>	
		</div>		

	</div>	
			
	
</form>
	
	
	
	
	
	
	
	
