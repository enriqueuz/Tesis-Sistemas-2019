<?php
require_once('../sesion.php');
require_once('../config.php');
$conexion=mysqli_connect("localhost","root","12345678","ppd");

if ($_POST['carrera']=="Seleccione una opcion...") {
	header("location: registroEs.php?faltaCa=1");
}
 
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $error_msgs = [];
    $error_query = [];
    if( isset($_POST['nombre']) && !empty($_POST['nombre']) ) {
        $nombre = $_POST['nombre'];
    } else {
        $error_msgs['nombre'] = 'El nombre es requerido';
        $error_query[] = 'err_nombre=1';
    }

    if( isset($_POST['apellido']) && !empty($_POST['apellido']) ) {
        $apellido = $_POST['apellido'];        
    } else {
        $error_msgs['apellido'] = 'El apellido es requerido';
        $error_query[] = 'err_apellido=1';
    }

    if( isset($_POST['cedula']) && !empty($_POST['cedula']) ) {
    	$cedulaPrueba = $_POST['cedula'];
    	$sql="SELECT * from estudiantes 
		WHERE cedula='$cedulaPrueba'";
		$result=mysqli_query($conexion,$sql);
		if(mysqli_num_rows($result) > 0){
			$cedulaRepetida = 1;
		}else{
			$cedula = $_POST['cedula'];
		}
    } else {
        $error_msgs['cedula'] = 'La cédula es requerida';
        $error_query[] = 'err_cedula=1';
    }

    if( isset($_POST['telefono']) && !empty($_POST['telefono']) ) {
        $telefono = $_POST['telefono'];
    } else {
        $error_msgs['telefono'] = 'El teléfono es requerido';
        $error_query[] = 'err_telefono=1';
    }

    if( isset($_POST['sexo']) && !empty($_POST['sexo']) ) {
        $sexo = $_POST['sexo'];
    } else {
        $error_msgs['sexo'] = 'El sexo es requerido';
        $error_query[] = 'err_sexo=1';
    }

    if( isset($_POST['correo']) && !empty($_POST['correo']) ) {
        $correo = $_POST['correo'];
    } else {
        $error_msgs['correo'] = 'El correo electrónico es requerido';
        $error_query[] = 'err_correo=1';
    }

    if( isset($_POST['fecha_nacimiento']) && !empty($_POST['fecha_nacimiento']) ) {
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
    } else {
        $error_msgs['fecha_nacimiento'] = 'La fecha de nacimiento es requerida';
        $error_query[] = 'err_fecha_nacimiento=1';
    }

    if( isset($_POST['carrera']) && !empty($_POST['carrera']) ) {
        $carrera = $_POST['carrera'];
    } else {
        $error_msgs['carrera'] = 'El título universitario es requerido';
        $error_query[] = 'err_id_carrera=1';
    }

	if ($cedulaRepetida==1) {
		header("location: registroEs.php?cedulaRep=1");
	}else{
	    if(empty($error_msgs)) {

	        $sql = "INSERT INTO estudiantes (id_carrera, cedula, nombre, apellido, sexo, telefono, correo, fecha_nacimiento)
	        VALUES (:id_carrera, :cedula, :nombre, :apellido, :sexo, :telefono, :correo, :fecha_nacimiento)";

	        if($stmt_insert_1 = $pdo->prepare($sql)){
	            $stmt_insert_1->bindParam(":id_carrera", $param_id_carrera, PDO::PARAM_INT);
	            $stmt_insert_1->bindParam(":cedula", $param_cedula, PDO::PARAM_STR);
	            $stmt_insert_1->bindParam(":nombre", $param_nombre, PDO::PARAM_STR);
	            $stmt_insert_1->bindParam(":apellido", $param_apellido, PDO::PARAM_STR);
	            $stmt_insert_1->bindParam(":sexo", $param_sexo, PDO::PARAM_STR);
	            $stmt_insert_1->bindParam(":telefono", $param_telefono, PDO::PARAM_STR);
	            $stmt_insert_1->bindParam(":correo", $param_correo, PDO::PARAM_STR);
	            $stmt_insert_1->bindParam(":fecha_nacimiento", $param_fecha_nacimiento, PDO::PARAM_STR);

	            $param_id_carrera       = $carrera;
	            $param_cedula           = $cedula;
	            $param_nombre           = $nombre;
	            $param_apellido         = $apellido;
	            $param_sexo             = $sexo;
	            $param_telefono         = $telefono;
	            $param_correo           = $correo;
	            $param_fecha_nacimiento = $fecha_nacimiento;

	            if($stmt_insert_1->execute()) {
	                $id_estudiante = $pdo->lastInsertId();

	                
	                if( isset($_POST['constancia_trabajo']) && !empty($_POST['constancia_trabajo']) ) {
	                    $constancia_trabajo = (strtolower($_POST['constancia_trabajo']) == 'si') ? true : false;
	                } else {
	                    $constancia_trabajo = false;
	                }

	                if( isset($_POST['curriculum']) && !empty($_POST['curriculum']) ) {
	                    $curriculum = (strtolower($_POST['curriculum']) == 'si') ? true : false;
	                } else {
	                    $curriculum = false;
	                }

	                if( isset($_POST['foto_carnet']) && !empty($_POST['foto_carnet']) ) {
	                    $foto_carnet = (strtolower($_POST['foto_carnet']) == 'si') ? true : false;
	                } else {
	                    $foto_carnet = false;
	                }

	                if( isset($_POST['copia_cedula']) && !empty($_POST['copia_cedula']) ) {
	                    $copia_cedula = (strtolower($_POST['copia_cedula']) == 'si') ? true : false;
	                } else {
	                    $copia_cedula = false;
	                }

	                if( isset($_POST['copia_partida_nacimiento']) && !empty($_POST['copia_partida_nacimiento']) ) {
	                    $copia_partida_nacimiento = (strtolower($_POST['copia_partida_nacimiento']) == 'si') ? true : false;
	                } else {
	                    $copia_partida_nacimiento = false;
	                }

	                if( isset($_POST['notas']) && !empty($_POST['notas']) ) {
	                    $notas = (strtolower($_POST['notas']) == 'si') ? true : false;
	                } else {
	                    $notas = false;
	                }

	                if( isset($_POST['fondo_negro']) && !empty($_POST['fondo_negro']) ) {
	                    $fondo_negro = (strtolower($_POST['fondo_negro']) == 'si') ? true : false;
	                } else {
	                    $fondo_negro = false;
	                }

	                $sql2 = "INSERT INTO documentos_estudiantes (id_estudiante, constancia_trabajo, curriculum, foto_carnet, copia_cedula, copia_partida_nacimiento, notas, fondo_negro)
	                        VALUES (:id_estudiante, :constancia_trabajo, :curriculum, :foto_carnet, :copia_cedula, :copia_partida_nacimiento, :notas, :fondo_negro)";
	                
	                if($stmt_insert_2 = $pdo->prepare($sql2)){

	                    $stmt_insert_2->bindParam(":id_estudiante", $param_id_estudiante, PDO::PARAM_INT);
	                    $stmt_insert_2->bindParam(":constancia_trabajo", $param_constancia_trabajo, PDO::PARAM_BOOL);
	                    $stmt_insert_2->bindParam(":curriculum", $param_curriculum, PDO::PARAM_BOOL);
	                    $stmt_insert_2->bindParam(":foto_carnet", $param_foto_carnet, PDO::PARAM_BOOL);
	                    $stmt_insert_2->bindParam(":copia_cedula", $param_copia_cedula, PDO::PARAM_BOOL);
	                    $stmt_insert_2->bindParam(":copia_partida_nacimiento", $param_copia_partida_nacimiento, PDO::PARAM_BOOL);
	                    $stmt_insert_2->bindParam(":notas", $param_notas, PDO::PARAM_BOOL);
	                    $stmt_insert_2->bindParam(":fondo_negro", $param_fondo_negro, PDO::PARAM_BOOL);

	                    $param_id_estudiante = $id_estudiante;
	                    $param_constancia_trabajo = $constancia_trabajo;
	                    $param_curriculum = $curriculum;
	                    $param_foto_carnet = $foto_carnet;
	                    $param_copia_cedula = $copia_cedula;
	                    $param_copia_partida_nacimiento = $copia_partida_nacimiento;
	                    $param_notas = $notas;
	                    $param_fondo_negro = $fondo_negro;

	                    if($stmt_insert_2->execute()) {
	                        $sql3 = "INSERT INTO chequeo_pagos (id_estudiante, pago_inscripcion, pago_t1, pago_t2, pago_t3, pago_t4, pago_mg)
	                        VALUES (:id_estudiante, 0, 0, 0, 0, 0, 0)";
	                
	                        if($stmt_insert_3 = $pdo->prepare($sql3)){

	                            $stmt_insert_3->bindParam(":id_estudiante", $param_id_estudiante, PDO::PARAM_INT);
	                            $param_id_estudiante = $id_estudiante;

	                            if($stmt_insert_3->execute()) {
	                                header("location: registroEs.php?exito=1");
	                            } else {
	                                echo "Algo salió mal. Por favor intente más tarde.";
	                            }
	                        }
	                        unset($stmt_insert_3);
	                    } else {
	                        echo "Algo salió mal. Por favor intente más tarde.";
	                    }
	                }
	                unset($stmt_insert_2);
	            } else {
	                echo "Algo salió mal. Por favor intente más tarde.";
	            }
	        }
	        unset($stmt_insert_1);
	    } else {
	        header("location: registroEs.php?" .implode('&', $error_query));
	    }

	    unset($pdo);
	}

}
?>