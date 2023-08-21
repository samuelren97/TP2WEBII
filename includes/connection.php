<?php
include("param.php");

$dsn = "mysql:host=$host;dbname=$db;charset=utf8";
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
);

try {
    $conn = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    exit("Erreur lors de la connexion à la BD: " . $e->getMessage());
}
