<?php require('../sesion.php'); ?>
<?php require('../config.php'); ?>


<?php 

    $error = '';
	$error_msgs = [];
    $error_query = [];

    if( isset($_GET['id']) && !empty($_GET['id']) ) {
    	$id_estudiante = $_GET['id'];
	} else {
		$error_msgs['id_estudiante'] = 'Debe especificar un ID de estudiante';
        $error_query[] = 'err_id_estudiante=1';
	}

    if(empty($error_msgs)) {
        try {
            // Borramos primero los pagos:
            $sql1 = "DELETE FROM `pagos` WHERE `id_estudiante`=:id_estudiante";
            if($stmt1 = $pdo->prepare($sql1)) {

                $stmt1->bindParam(":id_estudiante", $param_id_estudiante, PDO::PARAM_INT);
                $param_id_estudiante = $_GET['id'];
                if($stmt1->execute()) {

                    // Luego los chequeos de pagos:
                    $sql2 = "DELETE FROM `chequeo_pagos` WHERE `id_estudiante`=:id_estudiante";
                    if($stmt2 = $pdo->prepare($sql2)) {

                        $stmt2->bindParam(":id_estudiante", $param_id_estudiante, PDO::PARAM_INT);       
                        $param_id_estudiante = $_GET['id'];
                        if($stmt2->execute()) {

                            // Los documentos:
                            $sql3 = "DELETE FROM `documentos_estudiantes` WHERE `id_estudiante`=:id_estudiante";
                            if($stmt3 = $pdo->prepare($sql3)) {

                                $stmt3->bindParam(":id_estudiante", $param_id_estudiante, PDO::PARAM_INT);       
                                $param_id_estudiante = $_GET['id'];
                                if($stmt3->execute()) {

                                    // Finalmente, se borra al estudiante:
                                    $sql4 = "DELETE FROM `estudiantes` WHERE `id`=:id";
                                    if($stmt4 = $pdo->prepare($sql4)) {

                                        $stmt4->bindParam(":id", $param_id, PDO::PARAM_INT);
                                        $param_id = $_GET['id'];
                                        if($stmt4->execute()) {
                                            header("location: consultaEs.php?id={$id_estudiante}&eliminado=1");
                                        } else {    // $stm4->execute
                                            $error = "Algo salió mal al eliminar el estudiante. Por favor intente más tarde.";
                                            die($error);
                                        }
                                    }
                                    unset($stmt4);
                                } else {            // $stmt3->execute
                                    $error = "Algo salió mal al borrar los documentos del estudiante. Por favor intente más tarde.";
                                    die($error);
                                }
                            }
                            unset($stmt3);
                        } else {
                            $error = "Algo salió mal al borrar los pagos chequeados. Por favor intente más tarde.";
                            die($error);
                        }
                    }
                    unset($stmt2);
                } else {                            // $stmt1->execute
                    $error = "Algo salió mal al borrar los pagos. Por favor intente más tarde.";
                    die($error);
                }
            }
            unset($stmt1);
        } catch (PDOException $e) {
            die($e);
            header("location: verEs.php?error=1&id={$id_estudiante}");
        }
    } else {    // empty(error_msgs)
        header("location: verEs.php?" .implode('&', $error_query));
    }
    unset($pdo);
 ?>