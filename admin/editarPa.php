<?php require('../sesion.php'); ?>
<?php require('../config.php'); ?>

<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {

    // Obtener todos los estudiantes con sus respectivas carreras/menciones:
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
    JOIN `menciones` ON `carreras`.`id_mencion`=`menciones`.`id`
    ORDER BY `estudiantes`.`cedula`";

    if ($stmt = $pdo->prepare($sql)) {
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $estudiantes = [];
                while ($row = $stmt->fetch()) {
                    $estudiantes[$row['id']] = [
                        'cedula' => $row['cedula'],
                        'nombre' => $row['nombre'],
                        'apellido' => $row['apellido'],
                        'sexo' => $row['sexo'],
                        'telefono' => $row['telefono'],
                        'correo' => $row['correo'],
                        'fecha_nacimiento' => $row['fecha_nacimiento'],
                        'mencion_nombre' => $row['mencion_nombre'],
                        'carrera_nombre' => $row['carrera_nombre'],
                    ];
                }
            } else {
                $error = 'No se encontraron menciones en la BD.';
            }
        } else {
            $error = 'Algo salió mal. Por favor intente más tarde.';
        }
    }
    unset($stmt);

    // Obtener los pagos:
    $sql2 = "SELECT 
        `pagos`.`id`,
        `id_estudiante`,
        `referencia`,
        `monto`,
        `fecha`,
        `tipo`
    FROM `pagos`
    JOIN `estudiantes` ON `pagos`.`id_estudiante`=`estudiantes`.`id`
    WHERE `pagos`.`id` =:id_pago
    LIMIT 1";

    $pago = null;
    if ($stmt2 = $pdo->prepare($sql2)) {
        $stmt2->bindParam(":id_pago", $param_pagos, PDO::PARAM_STR);
        $param_pagos = $_GET['id'];

        if ($stmt2->execute()) {
            if ($stmt2->rowCount() > 0) {
                while ($row = $stmt2->fetch()) {
                    $pago = $row;
                }
            } else {
                $error = 'No se encontró un pago con ese ID en la BD.';
            }
        } else {
            $error = 'Algo salió mal. Por favor intente más tarde.';
        }
    }
    unset($stmt2);
} else {
    // Garantizar que se está haciendo un POST a la página para que no hayan lazos de carga infinitos.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $error_msgs = [];
        $error_query = [];
        if (isset($_POST['id_pago']) && !empty($_POST['id_pago'])) {
            $id_pago = $_POST['id_pago'];
        } else {
            $error_msgs['id_pago'] = 'El ID del pago es requerido';
            $error_query[] = 'err_id_pago=1';
        }

        if (isset($_POST['id_estudiante']) && !empty($_POST['id_estudiante'])) {
            $id_estudiante = $_POST['id_estudiante'];
        } else {
            $error_msgs['id_estudiante'] = 'El ID del estudiante es requerido';
            $error_query[] = 'err_id_estudiante=1';
        }

        if (isset($_POST['referencia']) && !empty($_POST['referencia'])) {
            $referencia = $_POST['referencia'];
        } else {
            $error_msgs['referencia'] = 'El numero de referencia es requerido';
            $error_query[] = 'err_referencia=1';
        }

        if (isset($_POST['monto']) && !empty($_POST['monto'])) {
            $monto = $_POST['monto'];
        } else {
            $error_msgs['monto'] = 'El monto es requerido';
            $error_query[] = 'err_monto=1';
        }

        if (isset($_POST['fecha_pago']) && !empty($_POST['fecha_pago'])) {
            $fecha = $_POST['fecha_pago'];
        } else {
            $error_msgs['fecha_pago'] = 'La fecha es requerida';
            $error_query[] = 'err_fecha_pago=1';
        }

        if (isset($_POST['tipo_pago']) && !empty($_POST['tipo_pago'])) {
            $tipo = $_POST['tipo_pago'];
        } else {
            $error_msgs['tipo_pago'] = 'El tipo es requerido';
            $error_query[] = 'err_tipo_pago=1';
        }

        if (empty($error_msgs)) {

            $sql = "UPDATE pagos SET id_estudiante=:id_estudiante, referencia=:referencia, monto=:monto, fecha=:fecha, tipo=:tipo
            WHERE id=:id_pago";

            if ($stmt_update_1 = $pdo->prepare($sql)) {
                $stmt_update_1->bindParam(":id_estudiante", $param_id_estudiante, PDO::PARAM_INT);
                $stmt_update_1->bindParam(":referencia", $param_referencia, PDO::PARAM_STR);
                $stmt_update_1->bindParam(":monto", $param_monto, PDO::PARAM_STR);
                $stmt_update_1->bindParam(":fecha", $param_fecha, PDO::PARAM_STR);
                $stmt_update_1->bindParam(":tipo", $param_tipo, PDO::PARAM_STR);
                $stmt_update_1->bindParam(":id_pago", $param_id_pago, PDO::PARAM_INT);

                $param_id_estudiante    = $id_estudiante;
                $param_referencia       = $referencia;
                $param_monto            = $monto;
                $param_fecha            = $fecha;
                $param_tipo             = $tipo;
                $param_fecha_nacimiento = $fecha_nacimiento;
                $param_id_pago          = $id_pago;

                if ($stmt_update_1->execute()) {
                    header("location: editarPa.php?exito_edicion=1&id={$id_pago}");
                } else {
                    $error = "Algo salió mal. Por favor intente más tarde.";
                }
            }
            unset($stmt_update_1);
        }
    }
}
unset($pdo);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Editar un pago</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/jpg" href="../img/logo.jpg">
    <script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/select2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="../css/select2-bootstrap4.min.css">
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

    <h1>Registre un pago</h1>
    <br>
    <div class="container py-5">
        <?php if (isset($_GET['exito_edicion']) && $_GET['exito_edicion'] == 1) : ?>
            <div class="alert alert-success">Se ha modificado el pago exitosamente.</div>
        <?php endif; ?>
		<?php if( isset($error) && !empty($error) ): ?>
        <div class="alert alert-warning py-2 col-lg-4 text-center"><?php echo $error; ?></div>
        <?php endif; ?>
        <br>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" name="fe" class="form-horizontal">
            <input type="hidden" name="id_pago" value="<?php echo $pago['id']; ?>">
            <div class="form-group">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="referencia">Estudiante</label>
                            <select id="idEstudiante" name="id_estudiante" class="form-control select2" required="required">
                                <option>Seleccione un estudiante...</option>
                                <?php foreach ($estudiantes as $id => $estudiante) : ?>
                                    <option value="<?php echo $id; ?>" <?php if(isset($pago['id_estudiante'])) { echo ($pago['id_estudiante'] == $id) ? 'selected="selected"' : ''; } ?>>
                                        <?php echo "{$estudiante['cedula']} - {$estudiante['nombre']} {$estudiante['apellido']} -  {$estudiante['carrera_nombre']}"; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm">
                            <label for="referencia">Número de referencia</label>
                            <input type="number" name="referencia" class="form-control" value="<?php echo $pago['referencia']; ?>">
                        </div>

                        <div class="col-sm">
                            <label for="monto">Monto total</label>
                            <input type="number" name="monto" class="form-control" value="<?php echo $pago['monto']; ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm">
                            <label for="fecha_pago">Fecha de pago</label>
                            <input type="date" name="fecha_pago" class="form-control" value="<?php echo $pago['fecha']; ?>">
                        </div>

                        <div class="col-sm">
                            <label for="tipo_pago">Tipo de pago</label>
                            <select id="tipo_pago" name="tipo_pago" class="form-control select2">
                                <option value="inscripcion" <?php echo ($pago['tipo'] == 'inscripcion') ? 'selected="selected"' : ''; ?>>Inscripción</option>
                                <option value="t1" <?php echo ($pago['tipo'] == 't1') ? 'selected="selected"' : ''; ?>>Primer trimestre</option>
                                <option value="t2" <?php echo ($pago['tipo'] == 't2') ? 'selected="selected"' : ''; ?>>Segundo trimestre</option>
                                <option value="t3" <?php echo ($pago['tipo'] == 't3') ? 'selected="selected"' : ''; ?>>Tercer trimestre</option>
                                <option value="t4" <?php echo ($pago['tipo'] == 't4') ? 'selected="selected"' : ''; ?>>Cuarto trimestre</option>
                                <option value="mg" <?php echo ($pago['tipo'] == 'mg') ? 'selected="selected"' : ''; ?>>Memoria de grado</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group" align="center">
                <button class="btn btn-primary">Modificar pago</button>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $(".select2").select2({
                theme: "bootstrap"
            });
        });
    </script>
</body>

</html>