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
                    <li class="nav-item"><a class="nav-link text-light" href="registroEs.php">Registre un
							estudiante</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="consultaEs.php">Consulte la información
							de un estudiante</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="registroPa.php">Registre un pago</a></li>
                    <li class="nav-item"><a class="nav-link text-light disabled" href="consultaPa.php">Consulte un
							pago</a></li>
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

    <h1>Consulte la información de un estudiante</h1>
    <div class="container">
        <br>
        <!-- Inicia tabla de consulta-->
		<!--TODO: Llenar datos de pagos hechos por un estudiante particular. -->
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Número de referencia</th>
                    <th>Monto total</th>
                    <th>Fecha de pago</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Tipo de pago</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div><!--/.container-->
</body>

</html>