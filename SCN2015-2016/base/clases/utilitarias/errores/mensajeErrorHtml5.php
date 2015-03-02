<html>
<head>
	<meta charset="UTF-8">

	<link href="recursos/assets/css/bootstrap.css" rel="stylesheet">
	
	<link href="recursos/select/bootstrap-select.css" rel="stylesheet">
	
	<link href="recursos/date/bootstrap-datetimepicker.css" rel="stylesheet">
					
	<link rel="stylesheet" href="recursos/assets/css/font-awesome.min.css">
	
	<link href="recursos/assets/css/main.css" rel="stylesheet">
	
	<style>
		body{
			background-color:white;
			color:red;
			text-align:center;
		}
		h1,h3,h4{
			color:black;
		}
		h1{
			font-size:40px;
		}
		i{
			color:red;
		}
		.container{
			background: white;
			border:5px solid black;
		}
		a{
			color:blue;
		}
	</style>
</head>
<body>		
			<br>
					<br>
					<br>
					<br>
			<div class="container" style="height:fixed">
				<div class="row" id="alertas">
					<br>
					<br>
					<h3><?=$mensaje?></h3>
					<br>
					<br>
					<h4>Codigo del problema: </h4><?=$codigo?></h4>
					<br>
					<br>
					<br>
					<a href='index.php'>Volver a la pantalla de Inicio</a>
					<br>
					<br>
					<br>
				</div>
			</div>    
</body>
</html>
