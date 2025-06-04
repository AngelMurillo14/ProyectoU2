<?php
$host = 'localhost';
$db = 'boletos';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // errores como excepciones
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // obtener resultados como arreglo asociativo
    PDO::ATTR_EMULATE_PREPARES   => false,                  // usar consultas preparadas reales
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // En producción se recomienda **no mostrar** errores sensibles
    die("Error de conexión a la base de datos.");
}
?>
