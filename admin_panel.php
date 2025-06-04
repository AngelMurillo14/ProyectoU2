<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: admin_login.php');
    exit;
}

require 'conexion.php';

$stmt = $pdo->query("SELECT * FROM productos");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Panel de Administración</title>
<link rel="stylesheet" href="admin_styles.css" />
</head>
<body>

<nav class="sidebar">
  <h2>Admin Panel</h2>
  <a href="admin_panel.php">Productos</a>
  <a href="admin_usuarios.php">Usuarios</a>
  <a href="admin_ventas.php">Ventas</a>
  <div class="logout">
    <a href="logout.php">Cerrar sesión</a>
  </div>
</nav>

<main class="content">
  <h1>Gestión de Productos</h1>
  <a href="admin_producto_agregar.php" class="btn btn-add">+ Agregar Producto</a>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Asientos Disponibles</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($productos as $prod): ?>
      <tr>
        <td><?= htmlspecialchars($prod['id']) ?></td>
        <td><?= htmlspecialchars($prod['nombre']) ?></td>
        <td>$<?= number_format($prod['precio'], 2) ?></td>
        <td><?= (int)$prod['asientos_disponibles'] ?></td>
        <td>
          <a href="admin_editar.php?id=<?= (int)$prod['id'] ?>" class="btn btn-edit">Editar</a>
          <a href="admin_eliminar.php?id=<?= (int)$prod['id'] ?>" onclick="return confirm('¿Seguro que quieres eliminar este producto?');" class="btn btn-delete">Eliminar</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</main>

</body>
</html>
