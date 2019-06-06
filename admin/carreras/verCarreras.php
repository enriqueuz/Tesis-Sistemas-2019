<?php require('../../sesion.php'); ?>
<?php require('../../config.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Ver carreras</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/jpg" href="../../img/logo.jpg">
    <script type="text/javascript" src="../../js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #AAA9AB">
            <a class="navbar-brand" href="../../paginaP.php">Programa de Profesionalización Docente de la ULA</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="falsse" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link text-light" href="../../registroEs.php">Registre un
							estudiante</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="../../consultaEs.php">Consulte la información
							de un estudiante</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="../../registroPa.php">Registre un pago</a></li>
                    <li class="nav-item"><a class="nav-link text-light disabled" href="../../consultaPa.php">Consulte un
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

    <h1>Consulte la información de las carreras registradas</h1>
    <div class="container">
        <br>
        <?php if( isset($_GET['eliminado']) && $_GET['eliminado'] == 1): ?>
        <div class="alert alert-success">Se ha eliminado la carrera exitosamente.</div>
        <?php endif; ?>
        <!-- Inicia tabla de consulta-->
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Mención</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // La consulta comienza acá:
                    $sql = "SELECT 
                        `carreras`.`id`,
                        `menciones`.`nombre` AS `nombre_mencion`,
                        `carreras`.`nombre`
                        FROM `carreras`
                        JOIN `menciones` ON `carreras`.`id_mencion`=`menciones`.`id`
                        ORDER BY `carreras`.`id`";

                    if($stmt = $pdo->prepare($sql)) {
                        if($stmt->execute()) {
                            if($stmt->rowCount() > 0){
                                while($row = $stmt->fetch()){
                                    echo '<tr>'.PHP_EOL;
                                    echo "\t<td>{$row['id']}</td>".PHP_EOL;
                                    echo "\t<td>{$row['nombre_mencion']}</td>".PHP_EOL;
                                    echo "\t<td>{$row['nombre']}</td>".PHP_EOL;
                                    echo "\t<td>".
                                        '<a href="editarCarrera.php?id='.$row["id"].'" class="btn btn-info" role="button">Editar</a>'.
                                        '<a href="borrarCarrera.php?id='.$row["id"].'" class="btn btn-danger confirma-carrera" role="button">Eliminar</a>'
                                    ."</td>".PHP_EOL;
                                    echo "</tr>".PHP_EOL;
                                    echo "</tr>".PHP_EOL;
                                }
                            } else {
                                echo '<tr><td colspan="4">No se encontraron carreras registradas.</td></tr>'.PHP_EOL;
                            }
                        } else {
                            echo '<tr><td colspan="4">Ocurrió un error al acceder a la base de datos.</td></tr>'.PHP_EOL;
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