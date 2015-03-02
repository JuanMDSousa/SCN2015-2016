<!--
Este archivo es un formulario que se carga con un load en el archivo estudiante.js,
para poder montar el formulario de ver el estudiante y asi poder ver todos sus datos personales 
traidos de la base de datos
-->

<form class='form-horizontal' id='formulariopersona' method="post" action="...">
	<div class="container">	
	<div class="row-fluid">		
			<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon">Nombre:</span>
					<input type='text' name='nombre1' class='form-control' disabled="disabled" id='nombre1' placeholder='Primer Nombre'>
				</div>
			</div>		
			<div class="col-md-6">
				<div class="input-group">
				<span class="input-group-addon">Apellido:</span>
					<input type='text' name='apellido1' class='form-control' disabled="disabled" id='apellido1' placeholder='Primer Apellido'>
				</div>
			</div>											
		</div>	<br><br><br>


	<div class="row-fluid">		
			<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon">Correo</span>
					<input type='text' name='cor_personal' class='form-control' disabled="disabled" id='cor_personal' placeholder='xxxxx@correo.com'>
				</div>
			</div>															
		</div>	
	
	<div class="row-fluid">		
			<div class="col-md-6">
				<div class="input-group">
					 <span class="input-group-addon">Departamento</span>
					 <div id="selectdep"></div>
					<input type='text' name='departamento' id='departamento' class='form-control' disabled='disabled'>
				</div>
			</div>										
		</div><br><br><br>	

	<div class="row-fluid">		
			<div class="col-md-6">
				<div class="input-group">
					 <span class="input-group-addon"> Estado:</span>
					  <div id="selectest"></div>
					<input type='text' name='estado' id='estado' class='form-control' disabled='disabled'>
				</div>
			</div>											
		</div>

		<div class="row-fluid">		
			<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon">Pensum:</span>
					 <div id="selectpen"></div>
					<input type='text' name='pensum' class='form-control' disabled="disabled" id='pensum' placeholder=''>
				</div>
			</div>															
		</div>	<br><br><br>
		
	<div class="row-fluid">		
			<div class="col-md-2 col-md-offset-4">
				<div class="input-group">				
					<input id='modificar' type='button' value="Activar Modificar" onclick='activarmodife()' class="btn btn-warning";>
				</div>
			</div>	
		</div>		
	</div>	
</form>
	
	
	
	
	
	
	
	
