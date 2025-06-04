<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: admin_login.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $precio = floatval($_POST['precio']);
    $asientos = intval($_POST['asientos']);

    if ($nombre === '' || $precio <= 0 || $asientos < 0) {
        $error = "Por favor, ingresa valores válidos.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO productos (nombre, precio, asientos_disponibles) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $precio, $asientos]);
        header('Location: admin_panel.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Vuelo</title>
</head>
<body>
<h2>Agregar Vuelo</h2>

<?php if ($error): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" required><br>

    <label>Precio:</label><br>
    <input type="number" name="precio" step="0.01" min="0.01" required><br>

    <label>Asientos:</label><br>
    <input type="number" name="asientos" min="0" required><br><br>

    <button type="submit">Guardar</button>
</form>
<p><a href="admin_panel.php">Volver al panel</a></p>
</body>
</html>
