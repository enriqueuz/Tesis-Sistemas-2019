<?php require('config.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Consulte información de un estudiante</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/jpg" href="img/logo.jpg">
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="js/responsive.bootstrap4.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="css/responsive.bootstrap4.min.css"> 
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
                    <li class="nav-item"><a class="nav-link disabled text-light" href="consultaEs.php">Consulte la
							información de un estudiante</a></li>
                    <li class="nav-item"><a class="nav-link text-light disabled" href="registroPa.php">Registre un pago</a></li>
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

    <h1>Consulte la información de un estudiante</h1>
    <div class="container">
		<div class="row mt-5">
            <!-- Inicia tabla de consulta-->
            <table id="example" class="table table-bordered table-striped dt-responsive nowrap">
                <thead>
                    <tr>
                        <th>Cédula</th>
                        <th>Nombre</th>
                        <th>Sexo</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Fecha de nacimiento</th>
                        <th>Mención</th>
                        <th>Título universitario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    // La consulta comienza acá:
                    $sql = "SELECT 
                        `estudiantes`.`id`,
                        `estudiantes`.`cedula`,
                        `estudiantes`.`nombre`,
                        `estudiantes`.`apellido`,
                        `sexo`,
                        `telefono`,
                        `correo`,
                        `fecha_nacimiento`,
                        `menciones`.`nombre` AS `mencion_nombre`,
                        `carreras`.`nombre` AS `carrera_nombre`
                        FROM `estudiantes`
                        JOIN `carreras` ON `estudiantes`.`id_carrera`=`carreras`.`id`
                        JOIN `menciones` ON `carreras`.`id_mencion`=`menciones`.`id`";

                    if($stmt = $pdo->prepare($sql)) {
                        if($stmt->execute()) {
                            if($stmt->rowCount() > 0){
                                while($row = $stmt->fetch()){
                                    echo '<tr>'.PHP_EOL;
                                    echo "\t<td>{$row['cedula']}</td>".PHP_EOL;
                                    echo "\t<td>{$row['nombre']} {$row['apellido']}</td>".PHP_EOL;
                                    echo "\t<td>". ((strtolower($row["sexo"]) == 'm') ? 'Masculino' : 'Femenino') .'</td>'.PHP_EOL;
                                    echo "\t<td>{$row['correo']}</td>".PHP_EOL;
                                    echo "\t<td>{$row['telefono']}</td>".PHP_EOL;
                                    echo "\t<td>{$row['fecha_nacimiento']}</td>".PHP_EOL;
                                    echo "\t<td>{$row['mencion_nombre']}</td>".PHP_EOL;
                                    echo "\t<td>{$row['carrera_nombre']}</td>".PHP_EOL;
                                    echo "\t<td><a class='btn btn-info' href='verEsSec.php?id={$row['id']}'>Ver Datos</a></td>".PHP_EOL;
                                    echo "</tr>".PHP_EOL;
                                }
                            } else {
                                echo '<tr><td colspan="9">No se encontraron registros de estudiantes.</td></tr>'.PHP_EOL;
                            }
                        } else {
                            echo '<tr><td colspan="9">Ocurrió un error al acceder a la base de datos.</td></tr>'.PHP_EOL;
                        }
                    }       
                    unset($stmt);
                    unset($pdo);
                    ?>
                </tbody>
            </table>
        </div><!--/.row-->
    </div><!--/.container-->
    <br>
    <script> 
			$(document).ready(function() {
		    $('#example').DataTable({
		    	"language": idioma_espanol
		    });
		} );
		var idioma_espanol = {
		    "sProcessing":     "Procesando...",
		    "sLengthMenu":     "Mostrar _MENU_ registros",
		    "sZeroRecords":    "No se encontraron resultados",
		    "sEmptyTable":     "Ningún dato disponible en esta tabla",
		    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
		    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
		    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
		    "sInfoPostFix":    "",
		    "sSearch":         "Buscar:",
		    "sUrl":            "",
		    "sInfoThousands":  ",",
		    "sLoadingRecords": "Cargando...",
		    "oPaginate": {
		        "sFirst":    "Primero",
		        "sLast":     "Último",
		        "sNext":     "Siguiente",
		        "sPrevious": "Anterior"
		    },
		    "oAria": {
		        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
		        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
}
    </script>
</body>

</html>