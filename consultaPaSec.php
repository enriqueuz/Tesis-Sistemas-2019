<?php require('config.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Consultar pagos</title>
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
                    <li class="nav-item"><a class="nav-link text-light disabled" href="registroEs.php">Registre un
							estudiante</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="consultaEs.php">Consulte la información
							de un estudiante</a></li>
                    <li class="nav-item"><a class="nav-link text-light disabled" href="registroPa.php">Registre un pago</a></li>
                    <li class="nav-item"><a class="nav-link text-light disabled" href="consultaPa.php">Consulte un
							pago</a></li>
					<li class="nav-item"><a class="nav-link text-light" href="admin/registroUs.php">Usuario nuevo</a></li>
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
            <tbody>
                <?php
                    // La consulta comienza acá:
                    $sql = "SELECT 
                        `pagos`.`id`,
                        `referencia`,
                        `monto`,
                        `fecha`,
                        `tipo`,
                        `estudiantes`.`correo`,
                        `estudiantes`.`telefono`
                        FROM `pagos`
                        JOIN `estudiantes` ON `pagos`.`id_estudiante`=`estudiantes`.`id`
                        ORDER BY `fecha`, `pagos`.`id_estudiante`";

                    if($stmt = $pdo->prepare($sql)) {
                        if($stmt->execute()) {
                            if($stmt->rowCount() > 0){
                                while($row = $stmt->fetch()){
                                    echo '<tr>'.PHP_EOL;
                                    echo "\t<td>{$row['referencia']}</td>".PHP_EOL;
                                    echo "\t<td>{$row['monto']}</td>".PHP_EOL;
                                    echo "\t<td>{$row['fecha']}</td>".PHP_EOL;
                                    echo "\t<td>{$row['correo']}</td>".PHP_EOL;
                                    echo "\t<td>{$row['telefono']}</td>".PHP_EOL;
                                    echo "\t<td>{$row['tipo']}</td>".PHP_EOL;
                                    echo "</tr>".PHP_EOL;
                                }
                            } else {
                                echo '<tr><td colspan="6">No se encontraron registros de pagos.</td></tr>'.PHP_EOL;
                            }
                        } else {
                            echo '<tr><td colspan="6">Ocurrió un error al acceder a la base de datos.</td></tr>'.PHP_EOL;
                        }
                    }       
                    unset($stmt);
                    unset($pdo);
                    ?>
            </tbody>
        </table>
    </div><!--/.container-->
</body>

</html>
