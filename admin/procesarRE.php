<?php
// Include config file
require_once('../sesion.php');
require_once('../config.php');
 
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
        $cedula = $_POST['cedula'];
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

    // Check input errors before inserting in database
    if(empty($error_msgs)) {

        // Prepare an insert statement
        $sql = "INSERT INTO estudiantes (id_carrera, cedula, nombre, apellido, sexo, telefono, correo, fecha_nacimiento)
        VALUES (:id_carrera, :cedula, :nombre, :apellido, :sexo, :telefono, :correo, :fecha_nacimiento)";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id_carrera", $param_id_carrera, PDO::PARAM_INT);
            $stmt->bindParam(":cedula", $param_cedula, PDO::PARAM_STR);
            $stmt->bindParam(":nombre", $param_nombre, PDO::PARAM_STR);
            $stmt->bindParam(":apellido", $param_apellido, PDO::PARAM_STR);
            $stmt->bindParam(":sexo", $param_sexo, PDO::PARAM_STR);
            $stmt->bindParam(":telefono", $param_telefono, PDO::PARAM_STR);
            $stmt->bindParam(":correo", $param_correo, PDO::PARAM_STR);
            $stmt->bindParam(":fecha_nacimiento", $param_fecha_nacimiento, PDO::PARAM_STR);

            // Set parameters
            $param_id_carrera       = $carrera;
            $param_cedula           = $cedula;
            $param_nombre           = $nombre;
            $param_apellido         = $apellido;
            $param_sexo             = $sexo;
            $param_telefono         = $telefono;
            $param_correo           = $correo;
            $param_fecha_nacimiento = $fecha_nacimiento;

            if($stmt->execute()) {
                // Retrieve the inserted object:
                $row = $stmt->fetch();
                $id_estudiante = $row['id'];

                // TODO: Esto maneja radio buttons tal como está. Se puede modificar para manejar checkboxes.
                // Para checkboxes, la expresion interna del if pasa a ser directamente: $variable = true; 
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

                if(empty($usuario_err) && empty($clave_err) && empty($confirmar_clave_err)){
                    
                    // Prepare an insert statement
                    $sql = "INSERT INTO documentos_estudiantes (id_estudiante, constancia_trabajo, curriculum, foto_carnet, copia_cedula, copia_partida_nacimiento, notas, fondo_negro)
                            VALUES (:id_estudiante, :constancia_trabajo, :curriculum, :foto_carnet, :copia_cedula, :copia_partida_nacimiento, :notas, :fondo_negro)";
                    
                    if($stmt2 = $pdo->prepare($sql)){
                        // Bind variables to the prepared statement as parameters
                        $stmt->bindParam(":id_estudiante", $param_id_estudiante, PDO::PARAM_INT);
                        $stmt->bindParam(":constancia_trabajo", $param_constancia_trabajo, PDO::PARAM_BOOL);
                        $stmt->bindParam(":curriculum", $param_curriculum, PDO::PARAM_BOOL);
                        $stmt->bindParam(":foto_carnet", $param_foto_carnet, PDO::PARAM_BOOL);
                        $stmt->bindParam(":copia_cedula", $param_copia_cedula, PDO::PARAM_BOOL);
                        $stmt->bindParam(":copia_partida_nacimiento", $param_copia_partida_nacimiento, PDO::PARAM_BOOL);
                        $stmt->bindParam(":notas", $param_notas, PDO::PARAM_BOOL);
                        $stmt->bindParam(":fondo_negro", $param_fondo_negro, PDO::PARAM_BOOL);
                        
                        // Set parameters
                        $param_id_estudiante = $id_estudiante;
                        $param_constancia_trabajo = $constancia_trabajo;
                        $param_curriculum = $curriculum;
                        $param_foto_carnet = $foto_carnet;
                        $param_copia_cedula = $copia_cedula;
                        $param_copia_partida_nacimiento = $copia_partida_nacimiento;
                        $param_notas = $notas;
                        $param_fondo_negro = $fondo_negro;
                        
                        // Attempt to execute the prepared statement
                        if($stmt2->execute()) {
                            // Redirect to login page
                            header("location: ../index.php");
                        } else {
                            echo "Algo salió mal. Por favor intente más tarde.";
                        }
                    }
                    
                    // Close statement
                    unset($stmt2);
                }
            } else {
                echo "Algo salió mal. Por favor intente más tarde.";
            }
        }
         
        // Close statement
        unset($stmt);
    } else {
        header("location: registroEs.php?" .implode('&', $error_query));
    }
    
    // Close connection
    unset($pdo);
}
?>