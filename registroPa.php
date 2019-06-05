<?php
/**
 * Este archivo comprueba que se haya iniciado sesión y que además se cuenta
 * con el nivel de acceso necesario para poder realizar dicha acción.
 */

require_once('sesion.php');

if(isset($_SESSION['rol']) && in_array($_SESSION['rol'], ['administrador'])) {
    header('location: admin/registroPa.php');
} else {
    echo 'Error: El usuario actual no está autorizado para realizar esta acción.';
    // Datos de sesión para buscar errores.
    print_r($_SESSION);
}