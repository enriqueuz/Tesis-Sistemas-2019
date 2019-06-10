<?php require('../sesion.php'); ?>
<?php require('../config.php'); ?>
<?php
    // Buscar 'menciones' para llenar el select:
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

    if($stmt = $pdo->prepare($sql)) {      
        if($stmt->execute()) {
            if($stmt->rowCount() > 0){
                $estudiantes = [];
                while($row = $stmt->fetch()){
                    $estudiantes[ $row['id'] ] = [
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
    unset($pdo);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Registre un pago</title>
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
        <?php if( isset($_GET['exito']) && $_GET['exito'] == 1): ?>
        <div class="alert alert-success">Se ha registrado el pago exitosamente.</div>
        <?php endif; ?>
        <br>
        <form action="procesarPa.php" method="POST" name="fe" class="form-horizontal">

            <div class="form-group">

                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="referencia">Estudiante</label>
                            <select id="idEstudiante" name="id_estudiante" class="form-control select2" required="required">
                                <option>Seleccione un estudiante...</option>
                            <?php foreach($estudiantes as $id => $estudiante): ?>
                                <option value="<?php echo $id; ?>">
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
                            <input type="number" name="referencia" class="form-control">
                        </div>

                        <div class="col-sm">
                            <label for="monto">Monto total</label>
                            <input type="number" name="monto" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm">
                            <label for="fecha_pago">Fecha de pago</label>
                            <input type="date" name="fecha_pago" class="form-control">
                        </div>

                        <div class="col-sm">
                            <label for="tipo_pago">Tipo de pago</label>
                            <select id="tipo_pago" name="tipo_pago" class="form-control select2">
                                <option value="inscripcion">Inscripción</option>
                                <option value="t1">Primer trimestre</option>
                                <option value="t2">Segundo trimestre</option>
                                <option value="t3">Tercer trimestre</option>
                                <option value="t4">Cuarto trimestre</option>
                                <option value="mg">Memoria de grado</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group" align="center">
                <button class="btn btn-primary">Registrar un pago</button>
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