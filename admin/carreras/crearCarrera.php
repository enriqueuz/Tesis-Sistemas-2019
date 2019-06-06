<?php require('../../sesion.php'); ?>
<?php require('../../config.php'); ?>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    /**
     * Manejo del formulario cuando se envían datos a la página:
     * ------------------------------------------------------------------------------
     */
    $error_msgs = [];
    $error_query = [];
    if( isset($_POST['mencion']) && !empty($_POST['mencion']) ) {
        $id_mencion = $_POST['mencion'];
    } else {
        $error_msgs['mencion'] = 'Debe seleccionar una mención';
        $error_query[] = 'err_mencion=1';
    }

    if( isset($_POST['nombre']) && !empty($_POST['nombre']) ) {
        $nombre = $_POST['nombre'];        
    } else {
        $error_msgs['nombre'] = 'El nombre es requerido';
        $error_query[] = 'err_nombre=1';
    }

    if(empty($error_msgs)) {
        try {
            $sql = "INSERT INTO `carreras` (id_mencion, nombre) VALUES (:id_mencion, :nombre)";

            if($stmt = $pdo->prepare($sql)) {
                $stmt->bindParam(":id_mencion", $param_id_mencion, PDO::PARAM_INT);
                $stmt->bindParam(":nombre", $param_nombre, PDO::PARAM_STR);

                $param_id_mencion   = $id_mencion;
                $param_nombre       = $nombre;

                if($stmt->execute()) {
                    header("location: crearCarrera.php?exito=1");
                } else {
                    echo "Algo salió mal. Por favor intente más tarde.";
                }
            }
            unset($stmt);
        } catch (PDOException $e) {
            return $e;
        }
    } else {
        header("location: crearCarrera.php?" .implode('&', $error_query));
    }
    unset($pdo);
} else {
    /**
     * Manejo del formulario cuando carga la página normalmente:
     * ------------------------------------------------------------------------------
     */
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
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Registre una carrera</title>
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
                    <li class="nav-item"><a class="nav-link text-light" href="../../registroEs.php">Registre un estudiante</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="../../consultaEs.php">Consulte la información de un estudiante</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="../../registroPa.php">Registre un pago</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="../../consultaPa.php">Consulte un pago</a></li>
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

    <h1>Registre una carrera</h1>

    <br>
    <div class="container py-5">
        <br>
        <?php if( isset($_GET['exito']) && $_GET['exito'] == 1): ?>
        <div class="alert alert-success">Se ha registrado la carrera exitosamente.</div>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form-horizontal"> 

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
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" class="form-control">
                    </div>
                </div>
            </div>

            <div class="form-group" align="center">
                <input type="submit" class="btn btn-primary" value="Registrar carrera">
            </div>

        </form>

    </div>
</body>
</html>