<?php require('../sesion.php'); ?>
<?php require('../config.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Registre un pago</title>
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
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link text-light" href="../registroEs.php">Registre un
							estudiante</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="../consultaEs.php">Consulte la información
							de un estudiante</a></li>
                    <li class="nav-item"><a class="nav-link disabled text-light" href="../registroPa.php">Registre un
							pago</a></li>
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

    <h1>Registre un pago</h1>
    <br>
    <div class="container py-5">
        <br>
        <form action="procesarPa.php" method="POST" name="fe" class="form-horizontal">

            <div class="form-group">

                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="referencia">Estudiante</label>
                            <select id="idEstudiante" name="id_estudiante" class="form-control" required="required">
                                <option>Seleccione un estudiante...</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm">
                            <label for="referencia">Número de referencia</label>
                            <input type="number" name="referencia" class="form-control">
                        </div>

                        <div class="col-sm">
                            <label for="monto">Monto total</label>
                            <input type="number" name="monto" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm">
                            <label for="fecha_pago">Fecha de pago</label>
                            <input type="date" name="fecha_pago" class="form-control">
                        </div>

                        <div class="col-sm">
                            <label for="tipo_pago">Tipo de pago</label>
                            <select id="tipo_pago" name="tipo_pago" class="form-control">
                                <option value="inscripcion">Inscripción</option>
                                <option value="t1">Primer trimestre</option>
                                <option value="t2">Segundo trimestre</option>
                                <option value="t3">Tercer trimestre</option>
                                <option value="t4">Cuarto trimestre</option>
                                <option value="mg">Memoria de grado</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group" align="center">
                <button class="btn btn-primary">Registrar un pago</button>
            </div>
        </form>
    </div>
</body>

</html>