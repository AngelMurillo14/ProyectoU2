<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM productos");
$productos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
</head>
<body>
    <h2>Panel de Administración</h2>
    <a href="admin_agregar.php">Agregar Nuevo Vuelo</a> | 
    <a href="admin_logout.php">Cerrar sesión</a>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Asientos</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($productos as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['nombre']) ?></td>
            <td><?= $p['precio'] ?></td>
            <td><?= $p['asientos_disponibles'] ?></td>
            <td>
                <a href="admin_editar.php?id=<?= $p['id'] ?>">Editar</a> |
                <a href="admin_eliminar.php?id=<?= $p['id'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
