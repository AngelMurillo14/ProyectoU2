<?php
session_start();
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Mostrar formulario para elegir producto y datos comprador (si no logueado)
    if (!isset($_GET['id'])) {
        echo "No se especificó producto.";
        exit;
    }
    $id = intval($_GET['id']);
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ? AND asientos_disponibles > 0");
    $stmt->execute([$id]);
    $producto = $stmt->fetch();

    if (!$producto) {
        echo "Producto no disponible.";
        exit;
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head><title>Comprar vuelo</title></head>
    <body>
        <h1>Comprar vuelo: <?= htmlspecialchars($producto['nombre']) ?></h1>
        <p>Precio: $<?= number_format($producto['precio'], 2) ?></p>
        <p>Asientos disponibles: <?= (int)$producto['asientos_disponibles'] ?></p>

        <form method="POST" action="comprar.php">
            <input type="hidden" name="id" value="<?= (int)$producto['id'] ?>" />
            
            <?php if (!isset($_SESSION['usuario_id'])): ?>
                <label>Nombre completo:</label><br>
                <input type="text" name="nombre_cliente" required><br>
                <label>Email:</label><br>
                <input type="email" name="email_cliente" required><br>
            <?php else: ?>
                <p>Comprando como usuario: <?= htmlspecialchars($_SESSION['usuario_nombre']) ?></p>
            <?php endif; ?>

            <label>Metodo de pago:</label><br>
            <select name="metodo_pago" required>
                <option value="tarjeta">Tarjeta</option>
                <option value="paypal">PayPal</option>
            </select><br><br>

            <button type="submit">Pagar y Comprar</button>
        </form>
    </body>
    </html>
    <?php
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar compra
    $id = intval($_POST['id']);
    $metodo_pago = $_POST['metodo_pago'];

    // Validar producto y disponibilidad
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ? AND asientos_disponibles > 0");
    $stmt->execute([$id]);
    $producto = $stmt->fetch();

    if (!$producto) {
        die("Lo sentimos, no hay asientos disponibles para este vuelo.");
    }

    // Obtener datos comprador
   if (isset($_SESSION['usuario_id'])) {
    $cliente_id = $_SESSION['usuario_id'];
    $cliente_nombre = $_SESSION['usuario_nombre'];

    // Obtener el email del usuario desde la base de datos
    $stmt = $pdo->prepare("SELECT email FROM usuarios WHERE id = ?");
    $stmt->execute([$cliente_id]);
    $cliente_email = $stmt->fetchColumn();
} else {

        $cliente_nombre = trim($_POST['cliente_nombre'] ?? '');
        $cliente_email = trim($_POST['cliente_email'] ?? '');

        if (!$cliente_nombre || !$cliente_email || !filter_var($cliente_email, FILTER_VALIDATE_EMAIL)) {
            die("Datos de cliente inválidos.");
        }
        $cliente_id = null; // compra sin usuario registrado
    }

    // Simular proceso de pago
    // (aquí solo aceptamos cualquier método sin error)
    $pago_exitoso = true;

    if ($pago_exitoso) {
        // Disminuir asiento disponible
        $update = $pdo->prepare("UPDATE productos SET asientos_disponibles = asientos_disponibles - 1 WHERE id = ?");
        $update->execute([$id]);

        // Guardar compra en tabla ventas
        $stmt = $pdo->prepare("INSERT INTO ventas (usuario_id, cliente_nombre, cliente_email, producto_id, precio, metodo_pago, fecha) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$cliente_id, $cliente_nombre, $cliente_email, $id, $producto['precio'], $metodo_pago]);

        // Guardar datos para el recibo en sesión
        $_SESSION['compra'] = [
            'nombre_producto' => $producto['nombre'],
            'precio' => $producto['precio'],
            'cliente_nombre' => $cliente_nombre,
            'cliente_email' => $cliente_email,
            'metodo_pago' => $metodo_pago,
            'fecha' => date('Y-m-d H:i:s')
        ];

        // Redirigir para generar recibo PDF
        header('Location: generar_recibo.php');
        exit;
    } else {
        die("Error en el pago. Intente nuevamente.");
    }
}

?>
