<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="login.css">
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

        <div class="login rounded">
            <form action=“ingresar.php” method=“POST” class="form-check text-center border border-light p-5">
                <h1 class="h3 mb-3 font-weight-normal">Ingrese a su usuario</h1>
                <br>
                <div class="form-group">
                    <input type="text" name="usuario" placeholder="Nombre de usuario" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" name="clave" placeholder="Contraseña" class="form-control">
                </div>

                <button type="submit" class="btn btn-info btn-block my-4" name="ingresar">Ingresar</button>
            </form>
        </div>
    </div>
</body>

</html>