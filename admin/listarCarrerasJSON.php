<?php
require_once('../config.php');

$data = [];

if( isset($_POST['id_mencion']) && !empty($_POST['id_mencion']) ) {
    $sql = "SELECT * FROM carreras WHERE id_mencion=:id_mencion";

    try {
        if($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":id_mencion", $param_id_mencion, PDO::PARAM_INT);

            $param_id_mencion = intval($_POST['id_mencion']);

            if($stmt->execute()) {
                $carrerasDB = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if( count($carrerasDB) > 0 ) { 
                    $carreras = [];
                    foreach($carrerasDB as $row => $carrera){
                        $carreras[] = [
                            'id'        => $carrera['id'],
                            'nombre'    => $carrera['nombre'],
                        ];
                    }
                    $data['result'] = $carreras;
                } else {
                    $data['error'] = 'No se encontraron carreras en la BD.';
                    $data['result'] = false;
                }
            } else {
                $data['error'] = 'Algo salió mal';
                $data['result'] = false;
            }
        }
    } catch (PDOException $e) {
        echo json_encode(['pdo_error' => $e]);
    }
    unset($stmt);
    unset($pdo);
} else {
    $data['error'] = 'No se especificó mención a obtener';
    $data['result'] = false;
}
echo json_encode($data);