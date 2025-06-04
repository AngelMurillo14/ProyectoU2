<?php
require 'conexion.php';
session_start();

// Consulta de vuelos
$stmt = $pdo->query("SELECT * FROM productos WHERE asientos_disponibles > 0");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Vuelos</title>
</head>
<body>
    <h1>Vuelos Disponibles</h1>
    <?php foreach ($productos as $vuelo): ?>
        <div style="border: 1px solid #ccc; padding: 10px; margin: 10px;">
            <h2><?= htmlspecialchars($vuelo['nombre']) ?></h2>
            <p>Precio: $<?= number_format($vuelo['precio'], 2) ?></p>
            <p>Asientos disponibles: <?= $vuelo['asientos_disponibles'] ?></p>
            <form method="POST" action="comprar.php">
                <input type="hidden" name="id" value="<?= $vuelo['id'] ?>">
                <button type="submit">Comprar</button>
            </form>
        </div>
    <?php endforeach; ?>
</body>
</html>
