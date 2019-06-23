<?php require('../sesion.php'); ?>
<?php require('../config.php'); ?>

<?php  


	$sql3 = "UPDATE `chequeo_pagos`
	            SET
	                `pago_t1`=0,
	                `pago_t2`=0,
	                `pago_t3`=0,
	                `pago_t4`=0
				WHERE 1";

	if ($stmt_update = $pdo->prepare($sql3)) {

                $stmt_update->bindParam(":pago_t1", $param_pago_t1, PDO::PARAM_INT);
                $stmt_update->bindParam(":pago_t2", $param_pago_t2, PDO::PARAM_INT);
                $stmt_update->bindParam(":pago_t3", $param_pago_t3, PDO::PARAM_INT);
                $stmt_update->bindParam(":pago_t4", $param_pago_t4, PDO::PARAM_INT);

                $param_pago_t1          = $pago_t1;
                $param_pago_t2          = $pago_t2;
                $param_pago_t3          = $pago_t3;
                $param_pago_t4          = $pago_t4;

                if ($stmt_update->execute()) {
                    header("location: chequeoPa.php?reiniciados=1");
                }else{
                    $error = 'Ocurrió un error al reiniciar los chequeos';
                }              
	}else{
		echo "No se pudo ejecutar MySQL";
	}

?>


                
            