<?php
/**
 * Este archivo comprueba que se haya iniciado sesión y que además se cuenta
 * con el nivel de acceso necesario para poder realizar dicha acción.
 */

require_once('sesion.php');

if(isset($_SESSION['rol']) && in_array($_SESSION['rol'], ['administrador'])) {
    header('location: admin/registroEs.php');
} else {
	header('location: paginaPNoAut.php');
}