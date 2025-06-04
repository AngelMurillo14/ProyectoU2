<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: admin_login.php');
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header('Location: admin_panel.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->execute([$id]);
$producto = $stmt->fetch();

if (!$producto) {
    header('Location: admin_panel.php');
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
        $update = $pdo->prepare("UPDATE productos SET nombre = ?, precio = ?, asientos_disponibles = ? WHERE id = ?");
        $update->execute([$nombre, $precio, $asientos, $id]);
        header('Location: admin_panel.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Vuelo</title>
</head>
<body>
<h2>Editar Vuelo</h2>

<?php if ($error): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required><br>

    <label>Precio:</label><br>
    <input type="number" name="precio" step="0.01" min="0.01" value="<?= htmlspecialchars($producto['precio']) ?>" required><br>

    <label>Asientos:</label><br>
    <input type="number" name="asientos" min="0" value="<?= (int)$producto['asientos_disponibles'] ?>" required><br><br>

    <button type="submit">Actualizar</button>
</form>

<p><a href="admin_panel.php">Volver al panel</a></p>
</body>
</html>
