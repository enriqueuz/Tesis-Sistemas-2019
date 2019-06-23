<?php require('../sesion.php'); ?>
<?php require('../config.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Consulte información de un estudiante</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/jpg" href="../img/logo.jpg">
    <script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/responsive.bootstrap.min.css">
    <script type="text/javascript" language="javascript" src="../js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" language="javascript" src="../js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" language="javascript" src="../js/responsive.bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrapdt.min.css">
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
                    <li class="nav-item"><a class="nav-link text-light" href="../admin/registroUs.php">Usuario nuevo</a></li>
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
    <br>
    <?php if( isset($_GET['eliminado']) && $_GET['eliminado'] == 1): ?>
    <div class="alert alert-success container py-2 col-lg-4" align="center">Se eliminó exitosamente al estudiante</div>
    <?php endif; ?>
    <div class="container">
		<div class="row mt-5">
            <!-- Inicia tabla de consulta-->
            <table id="tablaestudiantes" class="table table-bordered table-hover">
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
                                    echo "<td>{$row['cedula']}</td>".PHP_EOL;
                                    echo "<td>{$row['nombre']} {$row['apellido']}</td>".PHP_EOL;
                                    echo "<td>". ((strtolower($row["sexo"]) == 'm') ? 'Masculino' : 'Femenino') .'</td>'.PHP_EOL;
                                    echo "<td>{$row['correo']}</td>".PHP_EOL;
                                    echo "<td>{$row['telefono']}</td>".PHP_EOL;
                                    echo "<td>{$row['fecha_nacimiento']}</td>".PHP_EOL;
                                    echo "<td>{$row['mencion_nombre']}</td>".PHP_EOL;
                                    echo "<td>{$row['carrera_nombre']}</td>".PHP_EOL;
                                    echo '<td>'.
                                        "<a class='btn btn-info' href='verEs.php?id={$row['id']}' role='button'><i class='fa fa-search'></i> Ver Datos</a>".
                                        "<a class='btn btn-danger confirma-eliminar' href='eliminarEs.php?id={$row['id']}' role='button'><i class='fa fa-times'></i> Eliminar</a>".
                                    '</td>'.PHP_EOL;
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
    <script> 
        $(document).ready(function() {
            $('#tablaestudiantes').DataTable({
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
        $('.confirma-eliminar').on('click', function () {
            return confirm('¿Confirma que desea eliminar al estudiante?');
        });
    </script>
</body>

</html>