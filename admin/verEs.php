<?php require('../sesion.php'); ?>
<?php require('../config.php'); ?>
<?php
    if( isset($_GET['id']) && !empty($_GET['id']) ) {
        $sql = "SELECT
                `estudiantes`.*,
                `carreras`.`id` AS `id_carrera`,
                `carreras`.`nombre` AS `carrera_nombre`,
                `menciones`.`id` AS `id_mencion`,
                `menciones`.`nombre` AS `mencion_nombre`,
                `documentos_estudiantes`.`constancia_trabajo`,
                `documentos_estudiantes`.`curriculum`,
                `documentos_estudiantes`.`foto_carnet`,
                `documentos_estudiantes`.`copia_cedula`,
                `documentos_estudiantes`.`copia_partida_nacimiento`,
                `documentos_estudiantes`.`notas`,
                `documentos_estudiantes`.`fondo_negro`
            FROM `estudiantes`
            JOIN `carreras` ON `estudiantes`.`id_carrera`=`carreras`.`id`
            JOIN `menciones` ON `carreras`.`id_mencion`=`menciones`.`id`
            JOIN `documentos_estudiantes` ON `estudiantes`.`id`=`documentos_estudiantes`.`id_estudiante`
            WHERE `estudiantes`.`id`=:id_estudiante
            LIMIT 1";

        $estudiante = null;
        if($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":id_estudiante", $param_usuario, PDO::PARAM_STR);
            $param_usuario = $_GET['id'];

            if($stmt->execute()) {
                if($stmt->rowCount() > 0){
                    while($row = $stmt->fetch()){
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
        unset($pdo);
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Registre un estudiante</title>
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
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="falsse" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link text-light" href="../registroEs.php">Registre un estudiante</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="../consultaEs.php">Consulte la información de un estudiante</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="../registroPa.php">Registre un pago</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="../consultaPa.php">Consulte un pago</a></li>
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

    <!-- Inicia formulario de registro-->

    <h1>Datos del estudiante</h1>

    <br>
    <div class="container py-5">
        <br>
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

            <h2>Documentos Consignados</h2>
            <div class="row">
                <div class="col">
                    <label for="constancia_trabajo" class="form-check-label">Constancia de trabajo (Si aplica)</label>
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="constancia_trabajo" value="Si" <?php echo ($estudiante['constancia_trabajo'] == 1) ? 'checked="checked"' : ''; ?> disabled>Sí
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="constancia_trabajo" value="No" <?php echo ($estudiante['constancia_trabajo'] == 0) ? 'checked="checked"' : ''; ?> disabled>No
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="curriculum" class="form-check-label">Currículum</label>
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="curriculum" value="Si" <?php echo ($estudiante['curriculum'] == 1) ? 'checked="checked"' : ''; ?> disabled>Sí
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="curriculum" value="No" <?php echo ($estudiante['curriculum'] == 0) ? 'checked="checked"' : ''; ?> disabled>No
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="foto_carnet" class="form-check-label">Fotografía carnet</label>
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="foto_carnet" value="Si" <?php echo ($estudiante['foto_carnet'] == 1) ? 'checked="checked"' : ''; ?> disabled>Sí
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="foto_carnet" value="No" <?php echo ($estudiante['foto_carnet'] == 0) ? 'checked="checked"' : ''; ?> disabled>No
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="copia_cedula" class="form-check-label">Fotocopia de la cédula</label>
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="copia_cedula" value="Si" <?php echo ($estudiante['copia_cedula'] == 1) ? 'checked="checked"' : ''; ?> disabled>Sí
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="copia_cedula" value="No" <?php echo ($estudiante['copia_cedula'] == 0) ? 'checked="checked"' : ''; ?> disabled>No
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="copia_partida_nacimiento" class="form-check-label">Fotocopia de la partida de nacimiento</label>
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="copia_partida_nacimiento" value="Si" <?php echo ($estudiante['copia_partida_nacimiento'] == 1) ? 'checked="checked"' : ''; ?> disabled>Sí
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="copia_partida_nacimiento" value="No" <?php echo ($estudiante['copia_partida_nacimiento'] == 0) ? 'checked="checked"' : ''; ?> disabled>No
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="notas" class="form-check-label">Fotocopia de las notas certificadas</label>
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="notas" value="Si" <?php echo ($estudiante['notas'] == 1) ? 'checked="checked"' : ''; ?> disabled>Sí
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="notas" value="No" <?php echo ($estudiante['notas'] == 0) ? 'checked="checked"' : ''; ?> disabled>No
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="fondo_negro" class="form-check-label">Fondo negro del título</label>
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="fondo_negro" value="Si" <?php echo ($estudiante['fondo_negro'] == 1) ? 'checked="checked"' : ''; ?> disabled>Sí
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="fondo_negro" value="No" <?php echo ($estudiante['fondo_negro'] == 0) ? 'checked="checked"' : ''; ?> disabled>No
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group" align="center">
                <button class="btn btn-primary" onclick="window.location.href='editarEs.php?editar=1&id=<?php echo $estudiante["id"]; ?>'">Editar estudiante</button>
            </div>

        </div>

    </div>
    <script>
        $('.select-mencion').on('change', function(event){
            var mencion = $(this).children("option:selected").val();
            $.post( "carreras/listarCarrerasJSON.php", { id_mencion: mencion })
                .done(function( result ) {
                    data = $.parseJSON(result);
                    if(data) {
                        $('.select-carrera option').remove();
                        $('.select-carrera').append($('<option>', { 
                            value: undefined,
                            text : 'Seleccione una opcion...'
                        }));
                        $.each(data.result, function (i, item) {
                            $('.select-carrera').append($('<option>', { 
                                value: item.id,
                                text : item.nombre 
                            }));
                        });
                        $('.select-carrera').trigger('change');
                    }
                });
        });
        $( document ).ready(function() {
            $( ".select2" ).select2({
                theme: "bootstrap"
            });
        });
    </script>
</body>
</html>