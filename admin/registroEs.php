<?php require('../sesion.php'); ?>
<?php require('../config.php'); ?>
<?php
    // Buscar 'menciones' para llenar el select:
    $sql = "SELECT * from `menciones`";

    if($stmt = $pdo->prepare($sql)) {      
        if($stmt->execute()) {
            if($stmt->rowCount() > 0){
                $menciones = [];
                while($row = $stmt->fetch()){
                    $menciones[ $row['id'] ] = $row['nombre'];
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

    <!-- Inicia formulario de registro-->

    <h1>Registre un estudiante</h1>

    <div class="container py-5">
		<?php if( isset($_GET['exito']) && $_GET['exito'] == 1): ?>
        <div class="alert alert-success py-2 col-lg-5" align="center">Se ha registrado el estudiante exitosamente.</div>
        <?php elseif( isset($_GET['err_nombre']) && $_GET['err_nombre'] == 1): ?>
        <div class="alert alert-warning py-2 col-lg-3" align="center">Ingrese el nombre del estudiante.</div>
		<?php elseif( isset($_GET['err_apellido']) && $_GET['err_apellido'] == 1): ?>
        <div class="alert alert-warning py-2 col-lg-3" align="center">Ingrese el apellido del estudiante.</div>
		<?php elseif( isset($_GET['err_cedula']) && $_GET['err_cedula'] == 1): ?>
        <div class="alert alert-warning py-2 col-lg-3" align="center">Ingrese la cédula del estudiante.</div>
		<?php elseif( isset($_GET['err_telefono']) && $_GET['err_telefono'] == 1): ?>
        <div class="alert alert-warning py-2 col-lg-3" align="center">Ingrese el teléfono del estudiante.</div>
		<?php elseif( isset($_GET['err_sexo']) && $_GET['err_sexo'] == 1): ?>
        <div class="alert alert-warning py-2 col-lg-3" align="center">Seleccione el sexo del estudiante.</div>
       	<?php elseif( isset($_GET['cedulaRep']) && $_GET['cedulaRep'] == 1): ?>
        <div class="alert alert-warning py-2 col-lg-3" align="center">El número de cédula ya existe</div>
       	<?php elseif( isset($_GET['faltaCa']) && $_GET['faltaCa'] == 1): ?>
        <div class="alert alert-warning py-2 col-lg-3" align="center">Seleccione mención y carrera del estudiante</div>
        <?php endif; ?>
        <form action="procesarRE.php" method="POST" name="fe" class="form-horizontal"> 

            <div class="form-group">
            	<br>
                <h2>Datos personales</h2>
                <br>
                <div class="row">
                    <div class="col-sm">					
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required="required">
                    </div>

                    <div class="col-sm">					
                        <label for="apellido">Apellido</label>
                        <input type="text" name="apellido" class="form-control" required="required">
                    </div>
                </div>
                <br>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm">
                            <label for="cedula">Cédula de identidad</label>
                            <input type="number" name="cedula" class="form-control" required="required">
                        </div>	
                        
                        <div class="col-sm">
                            <label for="telefono">Número de teléfono</label>
                            <input type="tel" name="telefono" class="form-control" required="required">
                        </div>

                        <div class="col-sm" align="center">
                            <label for="sexo" class="form-check-label">Sexo</label><br><br>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="sexo" value="m" required="required"> Masculino
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="sexo" value="f"> Femenino
                            </div>	
                        </div>

                    </div>
                </div>	

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm">	
                            <label for="correo">Correo electrónico</label>
                            <input type="email" name="correo" class="form-control" required="required">
                        </div>
                        <div class="col-sm">
                            <label for="fecha_nacimiento">Fecha de nacimiento</label>
                            <input type="date" name="fecha_nacimiento" class="form-control" required="required">
                        </div>	
                    </div>
                </div>			

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm">
                            <label for="mencion">Mención</label>
                            <select name="mencion" class="form-control select-mencion">
                                <option>Seleccione una opcion...</option>
                            <?php foreach($menciones as $id => $nombre): ?>
                                <option value="<?php echo $id; ?>"><?php echo $nombre; ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>


                        <div class="col-sm">
                            <label for="carrera">Título universitario</label>
                            <select name="carrera" class="form-control select-carrera">
                                <option>Seleccione una opcion...</option>
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
                                <input type="radio" class="form-check-input" name="constancia_trabajo" value="Si">Sí
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="constancia_trabajo" value="No">No
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="curriculum" class="form-check-label">Currículum</label>
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="curriculum" value="Si">Sí
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="curriculum" value="No">No
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="foto_carnet" class="form-check-label">Fotografía carnet</label>
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="foto_carnet" value="Si">Sí
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="foto_carnet" value="No">No
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="copia_cedula" class="form-check-label">Fotocopia de la cédula</label>
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="copia_cedula" value="Si">Sí
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="copia_cedula" value="No">No
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="copia_partida_nacimiento" class="form-check-label">Fotocopia de la partida de nacimiento</label>
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="copia_partida_nacimiento" value="Si">Sí
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="copia_partida_nacimiento" value="No">No
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="notas" class="form-check-label">Fotocopia de las notas certificadas</label>
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="notas" value="Si">Sí
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="notas" value="No">No
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="fondo_negro" class="form-check-label">Fondo negro del título</label>
                    <div class="form-check">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="fondo_negro" value="Si">Sí
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="fondo_negro" value="No">No
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group" align="center">
                <input type="submit" class="btn btn-primary" value="Registrar estudiante">
            </div>

        </form>
        <button class="btn btn-secondary" onclick="window.location.href='../admin/carreras/crearCarrera.php'">Crear carrera</button>

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
                            console.log('i, item:', i, item);
                            console.log('item.id:',item.id);
                            console.log('item.nombre:', item.nombre);
                            $('.select-carrera').append($('<option>', { 
                                value: item.id,
                                text : item.nombre 
                            }));
                        });
                    }
                });
        });
        $( document ).ready(function() {
            $( ".select2" ).select2({
                theme: "bootstrap4"
            });
        });
    </script>
</body>
</html>