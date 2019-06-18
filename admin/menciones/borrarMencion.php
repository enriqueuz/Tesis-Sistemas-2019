<?php
require_once('../../sesion.php');
require_once('../../config.php');
 
if($_SERVER["REQUEST_METHOD"] == "GET") {

    $error_msgs = [];
    $error_query = [];
    if( isset($_GET['id']) && !empty($_GET['id']) ) {
        $id_mencion = $_GET['id'];
    } else {
        $error_msgs['id_mencion'] = 'Debe especificar un ID de mención';
        $error_query[] = 'err_id_mencion=1';
    }

    if(empty($error_msgs)) {
        try {
            // Primero hay que borrar las carreras que dependen de esta mencion:
            $sql1 = "DELETE FROM `carreras` WHERE `id_mencion`=:id_mencion";

            if($stmt1 = $pdo->prepare($sql1)) {
                $stmt1->bindParam(":id_mencion", $param_id_mencion, PDO::PARAM_INT);

                $param_id_mencion = $_GET['id'];

                if($stmt1->execute()) {
                    $sql2 = "DELETE FROM `menciones` WHERE `id`=:id";

                    if($stmt2 = $pdo->prepare($sql2)) {
                        $stmt2->bindParam(":id", $param_id, PDO::PARAM_INT);
        
                        $param_id   = $_GET['id'];
        
                        if($stmt2->execute()) {
                            header("location: verMenciones.php?eliminado=1");
                        } else {
                            echo "Algo salió mal. Por favor intente más tarde.";
                        }
                    }
                    unset($stmt2);        
                } else {
                    echo "Algo salió mal. Por favor intente más tarde.";
                }
            }
            unset($stmt1);
        } catch (PDOException $e) {
            header("location: verMenciones.php?error=1");
        }
    } else {
        header("location: verMenciones.php?" .implode('&', $error_query));
    }
    unset($pdo);
}
?>