<?php
session_start();
require 'conexion.php';

// Verificar que el usuario sea admin
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Consulta para obtener las ventas con detalles de producto y cliente
$sql = "SELECT v.id, v.cliente_nombre, v.cliente_email, v.fecha, p.nombre AS producto_nombre
        FROM ventas v
        INNER JOIN productos p ON v.producto_id = p.id
        ORDER BY v.fecha DESC";

$stmt = $pdo->query($sql);
$ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Ventas</title>
    <link rel="stylesheet" href="admin_ventas.css">
</head>
<body>
    <div class="container">
        <h1>Listado de Ventas</h1>
        <a href="admin_panel.php" class="btn-volver">← Volver al panel</a>
        <?php if (count($ventas) === 0): ?>
            <p>No hay ventas registradas.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID Venta</th>
                        <th>Cliente</th>
                        <th>Email</th>
                        <th>Producto</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ventas as $venta): ?>
                        <tr>
                            <td><?= $venta['id'] ?></td>
                            <td><?= htmlspecialchars($venta['cliente_nombre']) ?></td>
                            <td><?= htmlspecialchars($venta['cliente_email']) ?></td>
                            <td><?= htmlspecialchars($venta['producto_nombre']) ?></td>
                            
                            <td><?= htmlspecialchars($venta['fecha']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
