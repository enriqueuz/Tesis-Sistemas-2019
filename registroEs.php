<!DOCTYPE html>
<html>
<head>
	<title>Registre un estudiante</title>
	<meta charset="utf-8">
	<link rel="icon" type="image/jpg" href="img/logo.jpg">
	<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">


</head>
<body>

	<header>
		<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #AAA9AB">
		  	<a class="navbar-brand" href="paginaP.php">Programa de Profesionalización Docente de la ULA</a>
		  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="falsse" aria-label="Toggle navigation">
		    	<span class="navbar-toggler-icon"></span>
		  	</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
		    	<ul class="navbar-nav mr-auto">
			      	<li class="nav-item"><a class="nav-link disabled text-light" href="registroEs.php">Registre un estudiante</a></li>
	   			    <li class="nav-item"><a class="nav-link text-light" href="consultaEs.php">Consulte la información de un estudiante</a></li>
	   			    <li class="nav-item"><a class="nav-link text-light" href="registroPa.php">Registre un pago</a></li>
	   			    <li class="nav-item"><a class="nav-link text-light" href="consultaPa.php">Consulte un pago</a></li>
		    	</ul>
            <!--
                <form class="form-inline my-2 my-lg-0">
		            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
		            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            -->
		  </div>
		</nav>
	</header>

<!-- Inicia formulario de registro-->

	<h1>Registre un estudiante</h1>

	<br>
	<div class="container py-5">
		<br> 
		<form action="procesarRE.php" method="POST" name="fe" class="form-horizontal"> 

			<div class="form-group">
				<h2>Datos personales</h2>
				<div class="row">
					<div class="col-sm">					
						<label for="nombre">Nombre</label>
						<input type="text" name="nombre" class="form-control">
					</div>

					<div class="col-sm">					
						<label for="apellido">Apellido</label>
						<input type="text" name="apellido" class="form-control">
					</div>
				</div>
				<br>


				<div class="form-group">
					<div class="row">
						<div class="col-sm">
							<label for="cedula">Cédula de identidad</label>
							<input type="number" name="cedula" class="form-control">
						</div>	
						
						<div class="col-sm">
							<label for="telefono">Número de teléfono</label>
							<input type="tel" name="telefono" class="form-control">
						</div>

						<div class="col-sm" align="center">

							<label for="sexo" class="form-check-label">Sexo</label><br><br>
							<div class="form-check form-check-inline">
								<input type="radio" name="sexo" value="masculino"> Masculino
							</div>
							<div class="form-check form-check-inline">
								<input type="radio" name="sexo" value="femenino"> Femenino
							</div>	
						</div>

					</div>
				</div>	

				<div class="form-group">
					<div class="row">
						<div class="col-sm">	
							<label for="correo">Correo electrónico</label>
							<input type="email" name="correo" class="form-control">
						</div>
						<div class="col-sm">
							<label for="fecha_n">Fecha de nacimiento</label>
							<input type="date" name="fecha_n" class="form-control">
						</div>	
					</div>
				</div>


				

				<div class="form-group">
					<div class="row">
						<div class="col-sm">
							<label for="titulo">Título universitario</label>
							<input type="text" name="titulo" class="form-control">
						</div>
						<div class="col-sm">
							<label for="mencion">Mención</label>
							<select class="form-control"> 
								<option value="Educación Integral">Educación Integral</option>
								<option value="Ciencias Sociales">Ciencias Sociales</option>
								<option value="Ciencias Naturales, Matemática y Tecnología">Ciencias Naturales, Matemática y Tecnología</option>
								<option value="Lenguaje, Cultura e Idiomas">Lenguaje, Cultura e Idiomas</option>
								<option value="Ecología y Educación Ambiental">Ecología y Educación Ambiental</option>
								<option value="Educación para el Trabajo y Desarrollo Endógeno">Educación para el Trabajo y Desarrollo Endógeno</option>
								<option value="Ciencias de Salud">Ciencias de Salud</option>
							</select>
						</div>	
					</div>	
				</div>		

			</div>	


			<h2>Documentos Consignados</h2>
			<div class="btn-group" data-toggle="buttons">
				<div class="form-check">

					<label for="cons_tr" class="form-check-label">Constancia de trabajo (Si aplica)</label>
					<input type="radio" name="cons_tr" value="Si">Si
					<input type="radio" name="cons_tr" value="No">No
					
				</div>	

				<div class="form-check">
					<label for="curriculum" class="form-check-label">Currículum</label>	
					<input type="radio" name="curriculum" value="Si">Si				
					<input type="radio" name="curriculum" value="No">No	
				</div>

				<div class="form-check">	
					<label for="foto_c" class="form-check-label">Fotografía carnet</label>
					<input type="radio" name="foto_c" value="Si">Si
					<input type="radio" name="foto_c" value="No">No
				</div>	

				<div class="form-check">
					<label for="copia_ced" class="form-check-label">Fotocopia de la cédula</label>
					<input type="radio" name="copia_ced" value="Si">Si
					<input type="radio" name="copia_ced" value="No">No
				</div>	

				<div class="form-check">	
					<label for="copia_part" class="form-check-label">Fotocopia de la partida de nacimiento</label>
					<input type="radio" name="copia_part" value="Si">Si
					<input type="radio" name="copia_part" value="No">No
				</div>	

				<div class="form-check">	
					<label for="notas" class="form-check-label">Fotocopia de las notas certificadas</label>
					<input type="radio" name="notas" value="Si">Si
					<input type="radio" name="notas" value="No">No		
				</div>	

				<div class="form-check">	
					<label for="fondo_n" class="form-check-label">Fondo negro del título</label>
					<input type="radio" name="fondo_n" value="Si">Si
					<input type="radio" name="fondo_n" value="No">No
				</div>	
			</div>	
		</div>


			<div class="form-group" align="center">
				<button class="btn btn-primary">Registrar estudiante</button>
			</div>




		</form>

	</div>

</body>
</html>