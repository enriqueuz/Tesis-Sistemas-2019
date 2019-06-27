<?php require('../sesion.php'); ?>
<?php require('../config.php'); ?>
<?php
if( isset($_GET['id']) && !empty($_GET['id']) ) {
    $sql = "SELECT
                `estudiantes`.*,
                `carreras`.`id` AS `id_carrera`,
                `carreras`.`nombre` AS `carrera_nombre`,
                `menciones`.`id` AS `id_mencion`,
                `menciones`.`nombre` AS `mencion_nombre`
            FROM `estudiantes`
            JOIN `carreras` ON `estudiantes`.`id_carrera`=`carreras`.`id`
            JOIN `menciones` ON `carreras`.`id_mencion`=`menciones`.`id`
            WHERE `estudiantes`.`id`=:id_estudiante
            LIMIT 1";

    $estudiante = null;
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":id_estudiante", $param_usuario, PDO::PARAM_STR);
        $param_usuario = $_GET['id'];

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch()) {
                    $estudiante = $row;
                }
            } else {
                $error = 'No se encontró un estudiante con ese ID en la BD.';
            }
        } else {
            $error = 'Algo salió mal. Por favor intente más tarde.';
        }
    }
    unset($stmt);
} else {
    header("location: consultaEs.php?error=1");
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Imprimir pagos</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/jpg" href="../img/logo.jpg">
    <script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="../js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="../js/responsive.bootstrap4.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../css/responsive.bootstrap4.min.css">
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Estudiantes</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="../registroEs.php">Registre un estudiante</a>
                            <a class="dropdown-item" href="../consultaEs.php">Consulte un estudiante</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pagos</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="../registroPa.php">Registre un pago</a>
                            <a class="dropdown-item" href="../consultaPa.php">Consulte un pago</a>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link text-light" href="../admin/ChequeoPa.php">Chequear pagos</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="../admin/carreras/verCarreras.php">Carreras</a></li>
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


    <h1>Pagos</h1>
    <br>
    <div class="container">
        <div class="form-horizontal">

            <div class="form-group">
                <h2>Datos personales</h2>
                <div class="row">
                    <div class="col-sm">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="<?php echo $estudiante['nombre']; ?>" readonly>
                    </div>

                    <div class="col-sm">
                        <label for="apellido">Apellido</label>
                        <input type="text" name="apellido" class="form-control" value="<?php echo $estudiante['apellido']; ?>" readonly>
                    </div>
                </div>
                <br>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm">
                            <label for="cedula">Cédula de identidad</label>
                            <input type="number" name="cedula" class="form-control" value="<?php echo $estudiante['cedula']; ?>" readonly>
                        </div>

                        <div class="col-sm">
                            <label for="telefono">Número de teléfono</label>
                            <input type="tel" name="telefono" class="form-control" value="<?php echo $estudiante['telefono']; ?>" readonly>
                        </div>

                        <div class="col-sm" align="center">
                            <label for="sexo" class="form-check-label">Sexo</label><br><br>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="sexo" value="m" <?php echo (strtolower($estudiante['sexo']) == 'm') ? 'checked="checked"' : ''; ?> disabled> Masculino
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="sexo" value="f" <?php echo (strtolower($estudiante['sexo']) == 'f') ? 'checked="checked"' : ''; ?> disabled> Femenino
                            </div>
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm">
                            <label for="correo">Correo electrónico</label>
                            <input type="email" name="correo" class="form-control" value="<?php echo $estudiante['correo']; ?>" readonly>
                        </div>
                        <div class="col-sm">
                            <label for="fecha_nacimiento">Fecha de nacimiento</label>
                            <input type="date" name="fecha_nacimiento" class="form-control" value="<?php echo $estudiante['fecha_nacimiento']; ?>" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm">
                            <label for="mencion">Mención</label>
                            <select name="mencion" class="form-control select-mencion select2" readonly>
                                <option value="<?php echo $estudiante['id_mencion']; ?>"><?php echo $estudiante['mencion_nombre']; ?></option>
                            </select>
                        </div>
                        <div class="col-sm">
                            <label for="carrera">Título universitario</label>
                            <select name="carrera" class="form-control select-carrera select2" readonly>
                                <option value="<?php echo $estudiante['id_carrera']; ?>"><?php echo $estudiante['carrera_nombre']; ?></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <!-- Inicia tabla de consulta-->
            <table id="tablapagos" class="table table-bordered table-hover table-hover dt-responsive nowrap">
                <thead class="thead-dark">
                    <tr>
                        <th>Número de referencia</th>
                        <th>Monto total (Bs.)</th>
                        <th>Fecha de pago</th>
                        <th>Tipo de pago</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_pagos = "SELECT * FROM `pagos` WHERE `id_estudiante`=:id";

                    if ($stmt_pagos = $pdo->prepare($sql_pagos)) {

                        $stmt_pagos->bindParam(":id", $param_usuario, PDO::PARAM_STR);
                        $param_usuario = $_GET['id'];
                        if ($stmt_pagos->execute()) {
                            if ($stmt_pagos->rowCount() > 0) {
                                while ($row = $stmt_pagos->fetch()) {
                                    echo '<tr>' . PHP_EOL;
                                    echo "<td>{$row['referencia']}</td>" . PHP_EOL;
                                    echo "<td>{$row['monto']}</td>" . PHP_EOL;
                                    echo "<td>{$row['fecha']}</td>" . PHP_EOL;
                                    echo "<td>{$row['tipo']}</td>" . PHP_EOL;
                                    echo "</tr>" . PHP_EOL;
                                }
                            } else {
                                echo '<tr><td colspan="9">No se encontraron registros de pagos.</td></tr>' . PHP_EOL;
                            }
                        } else {
                            echo '<tr><td colspan="9">Ocurrió un error al acceder a la base de datos.</td></tr>' . PHP_EOL;
                        }
                    }
                    unset($stmt_pagos);
                    unset($pdo);
                    ?>
                </tbody>
            </table>
            <div class="form-horizontal d-print-none">
                <div class="form-group" align="center">
                    <button class="btn btn-primary" onclick="printPage()"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button>
                </div>
            </div>
        </div>
        <!--/.container-->
        <script>
            $(document).ready(function() {
                //$('#tablapagos').DataTable({
                //    "language": idioma_espanol
                //});
            });

            function printPage() {
                window.print();
            }

            var idioma_espanol = {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
            $('.confirma-eliminar').on('click', function() {
                return confirm('¿Confirma que desea eliminar el pago?');
            });
        </script>
</body>

</html>