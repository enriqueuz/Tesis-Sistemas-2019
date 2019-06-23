<?php require('sesion.php'); ?>
<?php require('config.php'); ?>
<?php
// Buscar 'estudiantes' para llenar el select en la primera carga:
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
            $error = 'No se encontraron estudiantes en la BD.';
        }
    } else {
        $error = 'Algo salió mal. Por favor intente más tarde.';
    }
}
unset($stmt);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $error_msgs = [];
    $error_query = [];
    if (isset($_POST['id_estudiante']) && !empty($_POST['id_estudiante'])) {
        $id_estudiante = $_POST['id_estudiante'];
    } else {
        $error_msgs['id_estudiante'] = 'El ID del estudiante es requerido';
        $error_query[] = 'err_id_estudiante=1';
    }
    if (isset($_POST['buscar'])) {
        // Buscar
        $sql1 = "SELECT * FROM `chequeo_pagos` WHERE `id_estudiante`=:id_estudiante LIMIT 1";

        $pago = null;
        if ($stmt_pagos = $pdo->prepare($sql1)) {
            $stmt_pagos->bindParam(":id_estudiante", $param_id_estudiante, PDO::PARAM_INT);

            $param_id_estudiante = $id_estudiante;

            if ($stmt_pagos->execute()) {
                if ($stmt_pagos->rowCount() > 0) {
                    while ($row = $stmt_pagos->fetch()) {
                        $pago = [
                            'pago_inscripcion' => $row['pago_inscripcion'],
                            'pago_t1' => $row['pago_t1'],
                            'pago_t2' => $row['pago_t2'],
                            'pago_t3' => $row['pago_t3'],
                            'pago_t4' => $row['pago_t4'],
                            'pago_mg' => $row['pago_mg'],
                        ];;
                    }
                } else {
                    $error = 'No se encontraron chequeos de pago en la BD.';
                }
            } else {
                $error = 'Algo salió mal. Por favor intente más tarde.';
            }
            unset($stmt_pagos);
        }
    } else {
        // Guardar
        $resultado = false;
        if (isset($_POST['id_estudiante']) && !empty($_POST['id_estudiante'])) {
            $id_estudiante = $_POST['id_estudiante'];
        } else {
            $error_msgs['id_estudiante'] = 'El ID del estudiante es requerido';
            $error_query[] = 'err_id_estudiante=1';
        }

        if (isset($_POST['pago_inscripcion']) && !empty($_POST['pago_inscripcion'])) {
            $pago_inscripcion = $_POST['pago_inscripcion'];
        } else {
            $pago_inscripcion = 0;
        }

        if (isset($_POST['pago_t1']) && !empty($_POST['pago_t1'])) {
            $pago_t1 = $_POST['pago_t1'];
        } else {
            $pago_t1 = 0;
        }

        if (isset($_POST['pago_t2']) && !empty($_POST['pago_t2'])) {
            $pago_t2 = $_POST['pago_t2'];
        } else {
            $pago_t2 = 0;
        }

        if (isset($_POST['pago_t3']) && !empty($_POST['pago_t3'])) {
            $pago_t3 = $_POST['pago_t3'];
        } else {
            $pago_t3 = 0;
        }

        if (isset($_POST['pago_t4']) && !empty($_POST['pago_t4'])) {
            $pago_t4 = $_POST['pago_t4'];
        } else {
            $pago_t4 = 0;
        }

        if (isset($_POST['pago_mg']) && !empty($_POST['pago_mg'])) {
            $pago_mg = $_POST['pago_mg'];
        } else {
            $pago_mg = 0;
        }

        $pago = [
            'pago_inscripcion' => $pago_inscripcion,
            'pago_t1' => $pago_t1,
            'pago_t2' => $pago_t2,
            'pago_t3' => $pago_t3,
            'pago_t4' => $pago_t4,
            'pago_mg' => $pago_mg
        ];

        if (empty($error_msgs)) {
            $sql2 = "UPDATE `chequeo_pagos`
            SET
                `pago_inscripcion`=:pago_inscripcion,
                `pago_t1`=:pago_t1,
                `pago_t2`=:pago_t2,
                `pago_t3`=:pago_t3,
                `pago_t4`=:pago_t4,
                `pago_mg`=:pago_mg
            WHERE `id_estudiante`=:id_estudiante";

            if ($stmt_update = $pdo->prepare($sql2)) {
                $stmt_update->bindParam(":pago_inscripcion", $param_pago_inscripcion, PDO::PARAM_INT);
                $stmt_update->bindParam(":pago_t1", $param_pago_t1, PDO::PARAM_INT);
                $stmt_update->bindParam(":pago_t2", $param_pago_t2, PDO::PARAM_INT);
                $stmt_update->bindParam(":pago_t3", $param_pago_t3, PDO::PARAM_INT);
                $stmt_update->bindParam(":pago_t4", $param_pago_t4, PDO::PARAM_INT);
                $stmt_update->bindParam(":pago_mg", $param_pago_mg, PDO::PARAM_INT);
                $stmt_update->bindParam(":id_estudiante", $param_id_estudiante, PDO::PARAM_INT);

                $param_pago_inscripcion = $pago_inscripcion;
                $param_pago_t1          = $pago_t1;
                $param_pago_t2          = $pago_t2;
                $param_pago_t3          = $pago_t3  ;
                $param_pago_t4          = $pago_t4;
                $param_pago_mg          = $pago_mg;
                $param_id_estudiante    = $id_estudiante;

                if ($stmt_update->execute()) {
                    //die( $stmt_update->debugDumpParams() );
                    $resultado = true;
                } else {
                    $error = 'Ocurrió un error al guardar los datos.';
                }
            }
        } else {
            $error = implode(PHP_EOL, $error_msgs);
        }
    }
}
unset($pdo);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Chequear pagos</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/jpg" href="img/logo.jpg">
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/select2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="css/select2-bootstrap4.min.css">
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
                    <li class="nav-item"><a class="nav-link text-light disabled" href="registroEs.php">Registre un estudiante</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="consultaEs.php">Consulte la información de un estudiante</a></li>
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
    <!-- Inicia formulario de chequeo de pagos-->
    <h1>Chequee los pagos de un estudiante</h1>
    <div class="container py-5">
        <br>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" name="buscar_usuario" class="form">
            <div class="form">
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm">
                            <label for="id_estudiante" class="col-form-label-md">Estudiante:</label>
                            <select id="idEstudiante" name="id_estudiante" class="form-control select2" required="required">
                                <option>Busque aquí un estudiante...</option>
                                <?php foreach ($estudiantes as $id => $estudiante) : ?>
                                    <option value="<?php echo $id; ?>" <?php if(isset($id_estudiante)) { echo ($id_estudiante == $id) ? 'selected="selected"' : ''; } ?>>
                                        <?php echo "{$estudiante['cedula']} - {$estudiante['nombre']} {$estudiante['apellido']} -  {$estudiante['carrera_nombre']}"; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-sm">
                            <input type="submit" name="buscar" class="btn btn-success" value="Confime aquí una vez haya seleccionado">
                        </div>
                    </div>
                </div>
            </div><!--/.form-->
        </form>
        <br>
        <?php if(isset($resultado) && $resultado): ?>
        <div class="alert alert-success">El/los pago(s) fueron chequeados correctamente.</div>
        <?php endif; ?>
        <?php if(isset($error) && $error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" name="chequear_pago" class="form-horizontal">
            <input type="hidden" id="pago_id_estudiante" name="id_estudiante" value="<?php if(isset($id_estudiante)) { echo $id_estudiante; } ?>">
        <h2>Marque los pagos que desee chequear</h2>
            <div class="row">
                <div class="col">
                    <label for="pago_inscripcion" class="form-check-label">Inscripción</label>
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" style="width: 30px; height: 30px;" name="pago_inscripcion" <?php if(isset($pago) && $pago['pago_inscripcion']){echo 'checked="checked"'; } ?> value="1">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="pago_t1" class="form-check-label">Primer trimestre</label>
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" style="width: 30px; height: 30px;" name="pago_t1" <?php if(isset($pago) && $pago['pago_t1']){echo 'checked="checked"'; } ?> value="1">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="pago_t2" class="form-check-label">Segundo trimestre</label>
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" style="width: 30px; height: 30px;" name="pago_t2" <?php if(isset($pago) && $pago['pago_t2']){echo 'checked="checked"'; } ?> value="1">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="pago_t3" class="form-check-label">Tercer trimestre</label>
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" style="width: 30px; height: 30px;" name="pago_t3" <?php if(isset($pago) && $pago['pago_t3']){echo 'checked="checked"'; } ?> value="1">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="pago_t4" class="form-check-label">Cuarto trimestre</label>
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" style="width: 30px; height: 30px;" name="pago_t4" <?php if(isset($pago) && $pago['pago_t4']){echo 'checked="checked"'; } ?> value="1">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <label for="pago_mg" class="form-check-label">Memoria de grado</label>
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" style="width: 30px; height: 30px;" name="pago_mg" <?php if(isset($pago) && $pago['pago_mg']){echo 'checked="checked"'; } ?> value="1">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="form-group" align="center">
                <input type="submit" class="btn btn-primary" name="registrar" value="Registrar pagos">
            </div>
        </form>
    </div>
    <script>
        $( document ).ready(function() {
            $( ".select2" ).select2({
                theme: "bootstrap"
            });
        });
    </script>
</body>
</html>