<?php

// Servidor de base de datos:
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'ppd');
define('DB_PASSWORD', 'BBLD3pgQD4P5m2Ix');
define('DB_NAME', 'ppd');

try{
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: No se pudo conectar al servidor: " . $e->getMessage());
}