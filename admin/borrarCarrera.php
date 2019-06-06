<?php
require_once('../sesion.php');
require_once('../config.php');
 
if($_SERVER["REQUEST_METHOD"] == "GET") {

    $error_msgs = [];
    $error_query = [];
    if( isset($_GET['id']) && !empty($_GET['id']) ) {
        $id_carrera = $_GET['id'];
    } else {
        $error_msgs['id_carrera'] = 'Debe especificar un ID de carrera';
        $error_query[] = 'err_id_carrera=1';
    }

    if(empty($error_msgs)) {
        try {
            $sql = "DELETE FROM `carreras` WHERE `id`=:id";

            if($stmt = $pdo->prepare($sql)) {
                $stmt->bindParam(":id", $param_id_carrera, PDO::PARAM_INT);

                $param_id_carrera    = $_GET['id'];

                if($stmt->execute()) {
                    header("location: verCarreras.php?eliminado=1");
                } else {
                    echo "Algo salió mal. Por favor intente más tarde.";
                }
            }
            unset($stmt);
        } catch (PDOException $e) {
            header("location: verCarreras.php?error=1");
        }
    } else {
        header("location: verCarreras.php?" .implode('&', $error_query));
    }
    unset($pdo);
}
?>