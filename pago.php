<?php
session_start();
if (!isset($_SESSION['compra'])) {
    echo "No hay vuelo seleccionado para la compra.";
    exit;
}
$compra = $_SESSION['compra'];
?>

<h2>Elegir método de pago</h2>
<p>Vuelo: <?= htmlspecialchars($compra['nombre']) ?></p>
<p>Precio: $<?= $compra['precio'] ?></p>

<form action="procesar_pago.php" method="post">
    <label><input type="radio" name="metodo" value="paypal" required> PayPal</label><br>
    <label><input type="radio" name="metodo" value="tarjeta" required> Tarjeta</label><br><br>
    <button type="submit">Continuar con el pago</button>
</form>
