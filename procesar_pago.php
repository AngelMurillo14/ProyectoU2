<?php
session_start();

if (!isset($_POST['metodo']) || !isset($_SESSION['compra'])) {
    echo "Error al procesar el pago.";
    exit;
}

$metodo = $_POST['metodo'];
$_SESSION['compra']['metodo_pago'] = $metodo;

echo "<p>Procesando pago con <strong>" . strtoupper($metodo) . "</strong>...</p>";
echo '<meta http-equiv="refresh" content="2;url=generar_recibo.php">';
