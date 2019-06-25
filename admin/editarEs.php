<?php require('../sesion.php'); ?>
<?php require('../config.php'); ?>
<?php
$conexion=mysqli_connect("localhost","root","12345678","ppd");
    // Al cargar normalmente la página.
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

        $estudiante = $mencion_actual = $carrera_actual = null;
        if($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":id_estudiante", $param_usuario, PDO::PARAM_STR);
            $param_usuario = $_GET['id'];

            if($stmt->execute()) {
                if($stmt->rowCount() > 0){
                    while($row = $stmt->fetch()){
                        $estudiante = $row;
                        $mencion_actual = $row['id_mencion'];
                        $carrera_actual = $row['id_carrera'];
                    }
                } else {
                    $error = 'No se encontró un estudiante con ese ID en la BD.';
                }
            } else {
                $error = 'Algo salió mal. Por favor intente más tarde.';
            }
        }
        unset($stmt);

        // Buscar 'menciones' para llenar el select:
        $sql = "SELECT * from `menciones`";

        $menciones = [];
        if($stmt = $pdo->prepare($sql)) {
            if($stmt->execute()) {
                if($stmt->rowCount() > 0) {
                    while($row = $stmt->fetch()){
                        $menciones[ $row['id'] ] = [
                            'nombre' => $row['nombre'],
                            'codigo' => $row['codigo'],
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

        // Buscar 'menciones' para llenar el select:
        $sql = "SELECT * from `carreras` WHERE `id_mencion`=:id_mencion";

        $carreras = [];
        if($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":id_mencion", $param_id_mencion, PDO::PARAM_STR);
            $param_id_mencion = $mencion_actual;
            if($stmt->execute()) {
                if($stmt->rowCount() > 0) {
                    while($row = $stmt->fetch()) {
                        $carreras[ $row['id'] ] = [
                            'nombre' => $row['nombre'],
                        ];
                    }
                } else {
                    $error = 'No se encontraron carreras en la BD.';
                }
            } else {
                $error = 'Algo salió mal. Por favor intente más tarde.';
            }
        }
        unset($stmt);

        unset($pdo);
    } else {
        // Garantizar que se está haciendo un POST a la página para que no hayan lazos de carga infinitos.
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $error_msgs = [];
            $error_query = [];
            if( isset($_POST['id_estudiante']) && !empty($_POST['id_estudiante']) ) {
                $id_estudiante = $_POST['id_estudiante'];
            } else {
                $error_msgs['id_estudiante'] = 'El ID del estudiante es requerido';
                $error_query[] = 'err_id_estudiante=1';
            }

            if( isset($_POST['nombre']) && !empty($_POST['nombre']) ) {
                $nombre = $_POST['nombre'];
            } else {
                $error_msgs['nombre'] = 'El nombre es requerido';
                $error_query[] = 'err_nombre=1';
            }

            if( isset($_POST['apellido']) && !empty($_POST['apellido']) ) {
                $apellido = $_POST['apellido'];        
            } else {
                $error_msgs['apellido'] = 'El apellido es requerido';
                $error_query[] = 'err_apellido=1';
            }

            if( isset($_POST['cedula']) && !empty($_POST['cedula']) ) {
		    	$cedulaPrueba = $_POST['cedula'];
		    	$sql="SELECT * from estudiantes
				WHERE id != '$id_estudiante' AND cedula='$cedulaPrueba'";
				$result=mysqli_query($conexion,$sql);
				if(mysqli_num_rows($result) > 0){
					$cedulaRepetida = 1;
				}else{
					$cedula = $_POST['cedula'];
				}
            } else {
                $error_msgs['cedula'] = 'La cédula es requerida';
                $error_query[] = 'err_cedula=1';
            }

            if( isset($_POST['telefono']) && !empty($_POST['telefono']) ) {
                $telefono = $_POST['telefono'];
            } else {
                $error_msgs['telefono'] = 'El teléfono es requerido';
                $error_query[] = 'err_telefono=1';
            }

            if( isset($_POST['sexo']) && !empty($_POST['sexo']) ) {
                $sexo = $_POST['sexo'];
            } else {
                $error_msgs['sexo'] = 'El sexo es requerido';
                $error_query[] = 'err_sexo=1';
            }

            if( isset($_POST['correo']) && !empty($_POST['correo']) ) {
                $correo = $_POST['correo'];
            } else {
                $error_msgs['correo'] = 'El correo electrónico es requerido';
                $error_query[] = 'err_correo=1';
            }

            if( isset($_POST['fecha_nacimiento']) && !empty($_POST['fecha_nacimiento']) ) {
                $fecha_nacimiento = $_POST['fecha_nacimiento'];
            } else {
                $error_msgs['fecha_nacimiento'] = 'La fecha de nacimiento es requerida';
                $error_query[] = 'err_fecha_nacimiento=1';
            }

            if( isset($_POST['carrera']) && !empty($_POST['carrera']) ) {
                $carrera = $_POST['carrera'];
            } else {
                $error_msgs['carrera'] = 'El título universitario es requerido';
                $error_query[] = 'err_id_carrera=1';
            }

            if ($cedulaRepetida==1) {
		header("location: editarEs.php?editar=1&cedulaRep=1&id=".$id_estudiante);
			}else{
	            if(empty($error_msgs)) {

	                $sql = "UPDATE estudiantes SET id_carrera=:id_carrera, cedula=:cedula, nombre=:nombre, apellido=:apellido, sexo=:sexo, telefono=:telefono, correo=:correo, fecha_nacimiento=:fecha_nacimiento
	                WHERE id=:id_estudiante";

	                if($stmt_update_1 = $pdo->prepare($sql)){
	                    $stmt_update_1->bindParam(":id_carrera", $param_id_carrera, PDO::PARAM_INT);
	                    $stmt_update_1->bindParam(":cedula", $param_cedula, PDO::PARAM_STR);
	                    $stmt_update_1->bindParam(":nombre", $param_nombre, PDO::PARAM_STR);
	                    $stmt_update_1->bindParam(":apellido", $param_apellido, PDO::PARAM_STR);
	                    $stmt_update_1->bindParam(":sexo", $param_sexo, PDO::PARAM_STR);
	                    $stmt_update_1->bindParam(":telefono", $param_telefono, PDO::PARAM_STR);
	                    $stmt_update_1->bindParam(":correo", $param_correo, PDO::PARAM_STR);
	                    $stmt_update_1->bindParam(":fecha_nacimiento", $param_fecha_nacimiento, PDO::PARAM_STR);
	                    $stmt_update_1->bindParam(":id_estudiante", $param_id_estudiante, PDO::PARAM_INT);

	                    $param_id_carrera       = $carrera;
	                    $param_cedula           = $cedula;
	                    $param_nombre           = $nombre;
	                    $param_apellido         = $apellido;
	                    $param_sexo             = $sexo;
	                    $param_telefono         = $telefono;
	                    $param_correo           = $correo;
	                    $param_fecha_nacimiento = $fecha_nacimiento;
	                    $param_id_estudiante    = $id_estudiante;

	                    if($stmt_update_1->execute()) {
	                        // TODO: Esto maneja radio buttons tal como está. Se puede modificar para manejar checkboxes.
	                        // Para checkboxes, la expresion interna del if pasa a ser directamente: $variable = true; 
	                        if( isset($_POST['constancia_trabajo']) && !empty($_POST['constancia_trabajo']) ) {
	                            $constancia_trabajo = (strtolower($_POST['constancia_trabajo']) == 'si') ? true : false;
	                        } else {
	                            $constancia_trabajo = false;
	                        }

	                        if( isset($_POST['curriculum']) && !empty($_POST['curriculum']) ) {
	                            $curriculum = (strtolower($_POST['curriculum']) == 'si') ? true : false;
	                        } else {
	                            $curriculum = false;
	                        }

	                        if( isset($_POST['foto_carnet']) && !empty($_POST['foto_carnet']) ) {
	                            $foto_carnet = (strtolower($_POST['foto_carnet']) == 'si') ? true : false;
	                        } else {
	                            $foto_carnet = false;
	                        }

	                        if( isset($_POST['copia_cedula']) && !empty($_POST['copia_cedula']) ) {
	                            $copia_cedula = (strtolower($_POST['copia_cedula']) == 'si') ? true : false;
	                        } else {
	                            $copia_cedula = false;
	                        }

	                        if( isset($_POST['copia_partida_nacimiento']) && !empty($_POST['copia_partida_nacimiento']) ) {
	                            $copia_partida_nacimiento = (strtolower($_POST['copia_partida_nacimiento']) == 'si') ? true : false;
	                        } else {
	                            $copia_partida_nacimiento = false;
	                        }

	                        if( isset($_POST['notas']) && !empty($_POST['notas']) ) {
	                            $notas = (strtolower($_POST['notas']) == 'si') ? true : false;
	                        } else {
	                            $notas = false;
	                        }

	                        if( isset($_POST['fondo_negro']) && !empty($_POST['fondo_negro']) ) {
	                            $fondo_negro = (strtolower($_POST['fondo_negro']) == 'si') ? true : false;
	                        } else {
	                            $fondo_negro = false;
	                        }

	                        $sql2 = "UPDATE documentos_estudiantes SET constancia_trabajo=:constancia_trabajo, curriculum=:curriculum, foto_carnet=:foto_carnet, copia_cedula=:copia_cedula, copia_partida_nacimiento=:copia_partida_nacimiento, notas=:notas, fondo_negro=:fondo_negro
	                                WHERE id_estudiante=:id_estudiante";
	                        
	                        if($stmt_update_2 = $pdo->prepare($sql2)){

	                            $stmt_update_2->bindParam(":constancia_trabajo", $param_constancia_trabajo, PDO::PARAM_BOOL);
	                            $stmt_update_2->bindParam(":curriculum", $param_curriculum, PDO::PARAM_BOOL);
	                            $stmt_update_2->bindParam(":foto_carnet", $param_foto_carnet, PDO::PARAM_BOOL);
	                            $stmt_update_2->bindParam(":copia_cedula", $param_copia_cedula, PDO::PARAM_BOOL);
	                            $stmt_update_2->bindParam(":copia_partida_nacimiento", $param_copia_partida_nacimiento, PDO::PARAM_BOOL);
	                            $stmt_update_2->bindParam(":notas", $param_notas, PDO::PARAM_BOOL);
	                            $stmt_update_2->bindParam(":fondo_negro", $param_fondo_negro, PDO::PARAM_BOOL);
	                            $stmt_update_2->bindParam(":id_estudiante", $param_id_estudiante, PDO::PARAM_INT);

	                            $param_constancia_trabajo       = $constancia_trabajo;
	                            $param_curriculum               = $curriculum;
	                            $param_foto_carnet              = $foto_carnet;
	                            $param_copia_cedula             = $copia_cedula;
	                            $param_copia_partida_nacimiento = $copia_partida_nacimiento;
	                            $param_notas                    = $notas;
	                            $param_fondo_negro              = $fondo_negro;
	                            $param_id_estudiante            = $id_estudiante;

	                            if($stmt_update_2->execute()) {
	                                header("location: verEs.php?exito_edicion=1&id={$id_estudiante}");
	                            } else {
	                                echo "Algo salió mal. Por favor intente más tarde.";
	                            }
	                        }

	                        unset($stmt_update_2);
	                    } else {
	                        echo "Algo salió mal. Por favor intente más tarde.";
	                    }
	                }

	                unset($stmt_update_1);
	            } else {
	                header("location: editarEs.php?" .implode('&', $error_query));
	            }
	            unset($pdo);
	        }
	        
	    }
	}   
?>
<!DOCTYPE html>
<html>

<head>
    <title>Modificar un estudiante</title>
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

    <!-- Inicia formulario de edición-->

    <h1>Datos del estudiante</h1>

    <br>
    <div class="container py-5">
        <br>
        <?php if( isset($_GET['exito_edicion']) && $_GET['exito_edicion'] == 1): ?>
        <div class="alert alert-success">Se ha editado al estudiante de forma exitosa.</div>
        <?php elseif( isset($_GET['cedulaRep']) && $_GET['cedulaRep'] == 1): ?>
        <div class="alert alert-warning py-2 col-lg-5" align="center">La cédula ingresada pertenece a otro estudiante</div>        
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" name="fee" class="form-horizontal"> 
            <input type="hidden" name="id_estudiante" value="<?php echo $estudiante['id']; ?>">

            <div class="form-group">
                <h2>Datos personales</h2>
                <div class="row">
                    <div class="col-sm">
                        <label for="nombre">Nombre</label>
                        <input type="hidden" name="nombre_anterior" value="<?php echo $estudiante['nombre']; ?>">
                        <input type="text" name="nombre" class="form-control" value="<?php echo $estudiante['nombre']; ?>">
                    </div>

                    <div class="col-sm">
                        <label for="apellido">Apellido</label>
                        <input type="hidden" name="apellido_anterior" value="<?php echo $estudiante['apellido']; ?>">
                        <input type="text" name="apellido" class="form-control" value="<?php echo $estudiante['apellido']; ?>">
                    </div>
                </div>
                <br>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm">
                            <label for="cedula">Cédula de identidad</label>
                            <input type="hidden" name="cedula_anterior" value="<?php echo $estudiante['cedula']; ?>">
                            <input type="number" name="cedula" class="form-control" value="<?php echo $estudiante['cedula']; ?>">
                        </div>	
                        
                        <div class="col-sm">
                            <label for="telefono">Número de teléfono</label>
                            <input type="hidden" name="telefono_anterior" value="<?php echo $estudiante['telefono']; ?>">
                            <input type="tel" name="telefono" class="form-control" value="<?php echo $estudiante['telefono']; ?>">
                        </div>

                        <div class="col-sm" align="center">
                            <label for="sexo" class="form-check-label">Sexo</label><br><br>
                            <input type="hidden" name="sexo" value="<?php echo $estudiante['sexo']; ?>">
                            <div class="form-check form-check-inline">
                                <input type="radio" name="sexo" value="m" <?php echo (strtolower($estudiante['sexo']) == 'm') ? 'checked="checked"' : ''; ?>> Masculino
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="sexo" value="f" <?php echo (strtolower($estudiante['sexo']) == 'f') ? 'checked="checked"' : ''; ?>> Femenino
                            </div>	
                        </div>

                    </div>
                </div>	

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm">
                            <label for="correo">Correo electrónico</label>
                            <input type="hidden" name="correo_anterior" value="<?php echo $estudiante['correo']; ?>">
                            <input type="email" name="correo" class="form-control" value="<?php echo $estudiante['correo']; ?>">
                        </div>
                        <div class="col-sm">
                            <label for="fecha_nacimiento">Fecha de nacimiento</label>
                            <input type="hidden" name="fecha_nacimiento_anterior" value="<?php echo $estudiante['fecha_nacimiento']; ?>">
                            <input type="date" name="fecha_nacimiento" class="form-control" value="<?php echo $estudiante['fecha_nacimiento']; ?>">
                        </div>	
                    </div>
                </div>			

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm">
                            <label for="mencion">Mención</label>
                            <input type="hidden" name="mencion_anterior" value="<?php echo $estudiante['id_mencion']; ?>">
                            <select name="mencion" class="form-control select-mencion select2">
                                <option>Seleccione una opción...</option>
                            <?php foreach($menciones as $id => $mencion): ?>
                                <option value="<?php echo $id; ?>" <?php echo ($id == $mencion_actual) ? 'selected' : ''; ?>><?php echo $mencion['nombre']; ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm">
                            <label for="carrera">Título universitario</label>
                            <input type="hidden" name="carrera_anterior" value="<?php echo $estudiante['id_carrera']; ?>">
                            <select name="carrera" class="form-control select-carrera select2">
                                <option>Seleccione una opción...</option>
                                <?php foreach($carreras as $id => $carrera): ?>
                                    <option value="<?php echo $id; ?>" <?php echo ($id == $carrera_actual) ? 'selected' : ''; ?>><?php echo $carrera['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>	
                </div>		

            </div>

            <h2>Documentos Consignados</h2>
            <div class="row">
                <div class="col">
                    <label for="constancia_trabajo" class="form-check-label">Constancia de trabajo (Si aplica)</label>
                    <input type="hidden" name="constancia_trabajo_anterior" value="<?php echo $estudiante['constancia_trabajo']; ?>">
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="constancia_trabajo" value="Si" <?php echo ($estudiante['constancia_trabajo'] == 1) ? 'checked="checked"' : ''; ?>>Sí
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="constancia_trabajo" value="No" <?php echo ($estudiante['constancia_trabajo'] == 0) ? 'checked="checked"' : ''; ?>>No
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="curriculum" class="form-check-label">Currículum</label>
                    <input type="hidden" name="curriculum_anterior" value="<?php echo $estudiante['curriculum']; ?>">
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="curriculum" value="Si" <?php echo ($estudiante['curriculum'] == 1) ? 'checked="checked"' : ''; ?>>Sí
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="curriculum" value="No" <?php echo ($estudiante['curriculum'] == 0) ? 'checked="checked"' : ''; ?>>No
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="foto_carnet" class="form-check-label">Fotografía carnet</label>
                    <input type="hidden" name="foto_carnet_anterior" value="<?php echo $estudiante['foto_carnet']; ?>">
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="foto_carnet" value="Si" <?php echo ($estudiante['foto_carnet'] == 1) ? 'checked="checked"' : ''; ?>>Sí
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="foto_carnet" value="No" <?php echo ($estudiante['foto_carnet'] == 0) ? 'checked="checked"' : ''; ?>>No
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="copia_cedula" class="form-check-label">Fotocopia de la cédula</label>
                    <input type="hidden" name="copia_cedula_anterior" value="<?php echo $estudiante['copia_cedula']; ?>">
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="copia_cedula" value="Si" <?php echo ($estudiante['copia_cedula'] == 1) ? 'checked="checked"' : ''; ?>>Sí
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="copia_cedula" value="No" <?php echo ($estudiante['copia_cedula'] == 0) ? 'checked="checked"' : ''; ?>>No
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="copia_partida_nacimiento" class="form-check-label">Fotocopia de la partida de nacimiento</label>
                    <input type="hidden" name="copia_partida_nacimiento_anterior" value="<?php echo $estudiante['copia_partida_nacimiento']; ?>">
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="copia_partida_nacimiento" value="Si" <?php echo ($estudiante['copia_partida_nacimiento'] == 1) ? 'checked="checked"' : ''; ?>>Sí
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="copia_partida_nacimiento" value="No" <?php echo ($estudiante['copia_partida_nacimiento'] == 0) ? 'checked="checked"' : ''; ?>>No
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="notas" class="form-check-label">Fotocopia de las notas certificadas</label>
                    <input type="hidden" name="notas_anterior" value="<?php echo $estudiante['notas']; ?>">
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="notas" value="Si" <?php echo ($estudiante['notas'] == 1) ? 'checked="checked"' : ''; ?>>Sí
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="notas" value="No" <?php echo ($estudiante['notas'] == 0) ? 'checked="checked"' : ''; ?>>No
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="fondo_negro" class="form-check-label">Fondo negro del título</label>
                    <input type="hidden" name="fondo_negro_anterior" value="<?php echo $estudiante['fondo_negro']; ?>">
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="fondo_negro" value="Si" <?php echo ($estudiante['fondo_negro'] == 1) ? 'checked="checked"' : ''; ?>>Sí
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="fondo_negro" value="No" <?php echo ($estudiante['fondo_negro'] == 0) ? 'checked="checked"' : ''; ?>>No
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group" align="center">
                <input type="submit" class="btn btn-primary" value="Modificar estudiante">
            </div>

        </form>

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