<?php require('../sesion.php'); ?>
<?php require('../config.php'); ?>


<?php 

	$error_msgs = [];
    $error_query = [];

    if( isset($_GET['id']) && !empty($_GET['id']) ) {

    	$id_estudiante = $_GET['id'];
		echo $id_estudiante;
	}else{
		$error_msgs['id_estudiante'] = 'Debe especificar un ID de estudiante';
        $error_query[] = 'err_id_estudiante=1';

	}


    if(empty($error_msgs)) {
        try {
            $sql = "DELETE FROM `estudiantes` WHERE `id`=:id";            

            if($stmt = $pdo->prepare($sql)) {
                $stmt->bindParam(":id", $param_id_estudiante, PDO::PARAM_INT);

                $param_id_estudiante    = $_GET['id'];

                if($stmt->execute()) {
                    header("location: consultaEs.php?id={$id_estudiante}&eliminado=1");
                } else {
                    echo "Algo salió mal. Por favor intente más tarde.";
                }
            }
            unset($stmt);
        } catch (PDOException $e) {
            header("location: verEs.php?error=1&id={$id_estudiante}");
        }
    } else {
        header("location: verEs.php?" .implode('&', $error_query));
    }
    unset($pdo);






 ?>