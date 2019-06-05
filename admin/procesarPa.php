<?php
require_once('../sesion.php');
require_once('../config.php');
 
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $error_msgs = [];
    $error_query = [];
    if( isset($_POST['id_estudiante']) && !empty($_POST['id_estudiante']) ) {
        $id_estudiante = $_POST['id_estudiante'];
    } else {
        $error_msgs['id_estudiante'] = 'Debe seleccionar un estudiante';
        $error_query[] = 'err_id_estudiante=1';
    }

    if( isset($_POST['referencia']) && !empty($_POST['referencia']) ) {
        $referencia = $_POST['referencia'];        
    } else {
        $error_msgs['referencia'] = 'La referencia es requerida';
        $error_query[] = 'err_referenciao=1';
    }

    if( isset($_POST['monto']) && !empty($_POST['monto']) ) {
        $monto = $_POST['monto'];
    } else {
        $error_msgs['monto'] = 'El monto es requerido';
        $error_query[] = 'err_monto=1';
    }

    if( isset($_POST['fecha_pago']) && !empty($_POST['fecha_pago']) ) {
        $fecha_pago = $_POST['fecha_pago'];
    } else {
        $error_msgs['fecha_pago'] = 'La fecha de pago es requerida';
        $error_query[] = 'err_fecha_pago=1';
    }

    if( isset($_POST['tipo_pago']) && !empty($_POST['tipo_pago']) ) {
        $tipo_pago = $_POST['tipo_pago'];
    } else {
        $error_msgs['tipo_pago'] = 'El tipo de pago es requerido';
        $error_query[] = 'err_tipo_pago=1';
    }

    if(empty($error_msgs)) {
        $sql = "INSERT INTO pagos (id_estudiante, referencia, monto, fecha, tipo)
        VALUES (:id_estudiante, :referencia, :monto, :fecha, :tipo)";

        if($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":id_estudiante", $param_id_estudiante, PDO::PARAM_INT);
            $stmt->bindParam(":referencia", $param_referencia, PDO::PARAM_STR);
            $stmt->bindParam(":monto", $param_monto, PDO::PARAM_STR);
            $stmt->bindParam(":fecha", $param_fecha, PDO::PARAM_STR);
            $stmt->bindParam(":tipo", $param_tipo, PDO::PARAM_STR);

            $param_id_estudiante    = $param_id_estudiante;
            $param_referencia       = $param_referencia;
            $param_monto            = $param_monto;
            $param_fecha            = $param_fecha;
            $param_tipo             = $param_tipo;

            if($stmt->execute()) {
                header("location: registroPa.php?exito=1");
            } else {
                echo "Algo salió mal. Por favor intente más tarde.";
            }
        }
        unset($stmt);
    } else {
        header("location: registroPä.php?" .implode('&', $error_query));
    }
    unset($pdo);
}
?>