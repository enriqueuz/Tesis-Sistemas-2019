<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
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
        <?php if(isset($_SESSION['ppd_ingresado']) && $_SESSION['ppd_ingresado'] == true): ?>
            <!-- Puede ser que el usuario tenga una sesion iniciada en este punto, así que
                    se muestra si el usuario ya ingresó al sitio. -->
            <p>Bienvenido/a, <?php echo $_SESSION['usuario']; ?></p>
            <p>Para utilizar el sistema, continúe <a href="paginaP.php">aquí.</a></p>
            <p>Si desea cerrar su sesión, por favor haga <a href="salir.php">click aquí.</a></p>
        <?php else: ?>
            <?php if(isset($_GET['error']) && $_GET['error'] !== ''): ?>
            <div class="alert alert-danger mb-0" role="alert">
                <?php
                switch($_GET['error']) {
                    case 1:
                        echo 'Por favor introduzca un usuario';
                        break;
                    case 2:
                        echo 'Por favor introduzca la contraseña';
                        break;
                    case 3:
                        echo 'Por favor introduzca su usuario y contraseña.';
                        break;
                    case 4:
                        echo 'El usuario o clave que introdujo no es válido.';
                        break;
                    case 5:
                        echo 'No se encontró un usuario con ese nombre.';
                        break;
                    case 6:
                        echo '¡Ups! Algo salió mal. Por favor intente más tarde.';
                        break;
                    default:
                        echo 'Ocurrió un error inesperado. Por favor intente más tarde.';
                        break;
                }
                ?>
            </div>
            <?php endif; ?>
            <?php if(isset($_GET['salida']) && $_GET['salida'] == true): ?>
            <div class="alert alert-primary mb-0" role="alert">
                Ha salido del sistema. Puede ingresar nuevamente.
            </div>
            <?php endif; ?>
            <form action="ingresar.php" method="POST" class="form-check text-center border border-light p-5">
                <h1 class="h3 mb-3 font-weight-normal">Ingrese a su usuario</h1>
                <br>
                <div class="form-group">
                    <input type="text" name="usuario" placeholder="Nombre de usuario" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" name="clave" placeholder="Contraseña" class="form-control">
                </div>

                <input type="submit" class="btn btn-info btn-block my-4" name="ingresar" value="Ingresar">
            </form>
        <?php endif; ?>
        </div>
    </div>
</body>

</html>