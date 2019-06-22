<?php require('../sesion.php'); ?>
<?php require('../config.php'); ?>


<?php 

    $error = '';
	$error_msgs = [];
    $error_query = [];

    if( isset($_GET['id']) && !empty($_GET['id']) ) {
    	$id_pago = $_GET['id'];
	} else {
		$error_msgs['id_pago'] = 'Debe especificar un ID de pago';
        $error_query[] = 'err_id_pago=1';
	}

    if(empty($error_msgs)) {
            // Borramos primero los pagos:
            $sql1 = "DELETE FROM `pagos` WHERE `id`=:id_pago";
            if($stmt1 = $pdo->prepare($sql1)) {

                $stmt1->bindParam(":id_pago", $param_id_pago, PDO::PARAM_INT);
                $param_id_pago = $_GET['id'];
                if ($stmt1->execute()) {
                	header("location: ConsultaPa.php?eliminado=1");
                }
            } else {
            	echo "No se pudo borrar el pago";
            }
	}           

 ?>