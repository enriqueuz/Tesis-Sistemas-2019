<?php require('../sesion.php'); ?>
<?php require('../config.php'); ?>
<?php

$usuario = $clave = $confirmar_clave = "";
$usuario_err = $clave_err = $confirmar_clave_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["usuario"]))){
        $usuario_err = "Por favor introduzca un usuario.";
    } else{
        $sql = "SELECT id FROM usuarios WHERE nombre = :usuario";
        
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":usuario", $param_usuario, PDO::PARAM_STR);
            
            $param_usuario = trim($_POST["usuario"]);
            
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $usuario_err = 'Este nombre de usuario ya existe.';
                } else{
                    $usuario = trim($_POST["usuario"]);
                }
            } else{
                echo '¡Ups! Algo salió mal. Por favor intente más tarde.';
            }
        }
         
        unset($stmt);
    }
    
    if(empty(trim($_POST["clave"]))) {
        $clave_err = "Por favor introduzca la contraseña";
    } elseif(strlen(trim($_POST["clave"])) < 6) {
        $clave_err = "La contraseña debe tener al menos 6 caracteres.";
    } else {
        $clave = trim($_POST["clave"]);
    }

    if(empty(trim($_POST["confirmar_clave"]))) {
        $confirmar_clave_err = "Por favor confirme la contraseña.";     
    } else {
        $confirmar_clave = trim($_POST["confirmar_clave"]);
        if(empty($clave_err) && ($clave != $confirmar_clave)){
            $confirmar_clave_err = "La confirmación de contraseña no coincide.";
        }
    }

    if(empty($usuario_err) && empty($clave_err) && empty($confirmar_clave_err)) {
        
        $sql = "INSERT INTO usuarios (nombre, clave) VALUES (:usuario, :clave)";
         
        if($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":usuario", $param_usuario, PDO::PARAM_STR);
            $stmt->bindParam(":clave", $param_clave, PDO::PARAM_STR);
            
            $param_usuario = $usuario;
            $param_clave = password_hash($clave, PASSWORD_DEFAULT); // Creates a clave hash
            
            if($stmt->execute()){
                header("location: ../index.php");
            } else{
                echo "Algo salió mal. Por favor intente más tarde.";
            }
        }
         
        unset($stmt);
    }
    
    unset($pdo);
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <link rel="icon" type="image/jpg" href="../img/logo.jpg">
    <script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <title>Programa de Profesionalización Docente | Registrar un nuevo usuario</title>
</head>

<body>

    <div class="bg">
        <header class="container header">
            <span class="border-left-0">
				<div class="row">
					<div class="col-lg-3">
						<img src="../img/educacionula.png" width="180" height="180" class="logo">
					</div>
                    <div class="col-lg-9">
                        <h1 align="center">Programa de Profesionalización Docente de la Universidad de Los Andes</h1> 
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p> 
                    </div>
				</div>
			</span>
        </header>

        <br>
        <br>

        <div class="login rounded">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-check text-center border border-light p-5">
                <div class="form-group <?php echo (!empty($usuario_err)) ? 'has-error' : ''; ?>">
                    <label>Usuario</label>
                    <input type="text" name="usuario" class="form-control" value="<?php echo $usuario; ?>">
                    <span class="help-block"><?php echo $usuario_err; ?></span>
                </div>    
                <div class="form-group <?php echo (!empty($clave_err)) ? 'has-error' : ''; ?>">
                    <label>Clave</label>
                    <input type="clave" name="clave" class="form-control" value="<?php echo $clave; ?>">
                    <span class="help-block"><?php echo $clave_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($confirmar_clave_err)) ? 'has-error' : ''; ?>">
                    <label>Confirme Clave</label>
                    <input type="clave" name="confirmar_clave" class="form-control" value="<?php echo $confirmar_clave; ?>">
                    <span class="help-block"><?php echo $confirmar_clave_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-info btn-block my-4" value="Registrar">
                    <input type="reset" class="btn btn-default btn-block my-4" value="Reiniciar">
                </div>
                <p>¿Ya tiene una cuenta? Por favor <a href="../index.php">ingrese acá</a>.</p>
            </form>
        </div>
    </div>
</body>

</html>