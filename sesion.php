<?php
/**
 * Siempre que se requiera este archivo, el sistema prevendra a cualquier usuario
 * no-ingresado a visitar otra pagina que no sea index.php.
 */
session_start();
if (isset($_SESSION['ppd_ingresado']) && $_SESSION['ppd_ingresado'] == true) {
    // continuar, al menos la sesión iniciada es válida.
} else {
    // regresar al usuario a la página principal.
    header('location: index.php');
    exit;
}