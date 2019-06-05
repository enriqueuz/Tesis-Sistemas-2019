<!DOCTYPE html>
<html>

<head>
    <title>Consulte información de un estudiante</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/jpg" href="../img/logo.jpg">
    <script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #AAA9AB">
            <a class="navbar-brand" href="../paginaP.php">Programa de Profesionalización Docente de la ULA</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="falsse" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link text-light" href="../registroEs.php">Registre un
							estudiante</a></li>
                    <li class="nav-item"><a class="nav-link disabled text-light" href="../consultaEs.php">Consulte la
							información de un estudiante</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="../registroPa.php">Registre un pago</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="../consultaPa.php">Consulte un pago</a></li>
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
		<!--TODO: Llenar datos de un estudiante particular. -->
        <!-- Inicia tabla de consulta-->
        <table class="table">
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Sexo</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Fecha de nacimiento</th>
                    <th>Título universitario</th>
                    <th>Mención</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div><!--/.container-->
</body>

</html>