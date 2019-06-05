<?php require_once('sesion.php'); ?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/estilopp.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="icon" type="image/jpg" href="img/logo.jpg">
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <title>Programa de Profesionalización Docente</title>
</head>

<body>

    <div class="bg">

        <header class="container header">
            <span class="border-left-0">
				<div class="row">
					<div class="col-lg-3">
						<img src="img/educacionula.png" width="180" height="180" class="logo">
					</div>

						<div class="col-lg-9">
						    <h1 align="center">Programa de Profesionalización Docente de la Universidad de Los Andes</h1> 
						    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p> 
						</div>
				</div>
			</span>
        </header>

        <br>
        <br>
        <h2 class="subtitulo" align="center">¿Qué desea hacer?</h2>
        <br>
        <br>

        <div class="form-check">
            <nav align="center">
                <button class="btn btn-secondary" onclick="window.location.href='registroEs.php'">Registrar estudiante</button>
                <button class="btn btn-secondary" onclick="window.location.href='consultaEs.php'">Consultar información de un estudiante</button>
                <button class="btn btn-secondary" onclick="window.location.href='registroPa.php'">Registrar un pago</button>
                <button class="btn btn-secondary" onclick="window.location.href='consultaPa.php'">Consultar pagos</button>
                <button class="btn btn-secondary" onclick="window.location.href='salir.php'">Salir del sistema</button>
            </nav>
        </div>
    </div>
</body>

</html>