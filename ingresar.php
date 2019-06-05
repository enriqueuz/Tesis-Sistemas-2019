<?php
session_start();
 
if(isset($_SESSION["ppd_ingresado"]) && $_SESSION["ppd_ingresado"] === true){
    header("location: paginaP.php");
    exit;
}
 
require_once('config.php');
 
$usuario = $clave = "";
$usuario_err = $clave_err = "";
$error = null;

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["usuario"]))){
        $usuario_err = "Por favor introduzca un usuario";
        $error = 1;
    } else{
        $usuario = trim($_POST["usuario"]);
    }

    if(empty(trim($_POST["clave"]))){
        $clave_err = "Por favor introduzca la contraseña";
        $error = 2;
    } else{
        $clave = trim($_POST["clave"]);
    }

    if(empty($usuario_err) && empty($clave_err)){
        $sql = "SELECT id, nombre, clave, rol FROM usuarios WHERE nombre = :usuario";

        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":usuario", $param_usuario, PDO::PARAM_STR);

            $param_usuario = trim($_POST["usuario"]);

            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row["id"];
                        $usuario = $row["nombre"];
                        $hash_clave = $row["clave"];
                        $rol = $row["rol"];
                        if(password_verify($clave, $hash_clave)){
                            session_start();

                            $_SESSION["ppd_ingresado"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["usuario"] = $usuario;
                            $_SESSION["rol"] = $rol;                        

                            header("location: paginaP.php");
                        } else {
                            $clave_err = "El usuario o clave que introdujo no es válido.";
                            $error = 4;
                        }
                    }
                } else {
                    $usuario_err = "No se encontró un usuario con ese nombre.";
                    $error = 5;
                }
            } else {
                $error = 6; // "¡Ups! Algo salió mal. Por favor intente más tarde.";
            }
        }       
        unset($stmt);
    } else {
        $error = 3; // "Por favor introduzca su usuario y contraseña."
    }
    unset($pdo);
}

if($error != null) {
    header('location: index.php?error='. $error);
}
?>