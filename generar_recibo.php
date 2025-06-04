<?php
ob_start();
session_start();
require('fpdf/fpdf.php');

// Verificar que haya datos de compra en la sesión
if (!isset($_SESSION['compra'])) {
    echo "No hay datos de compra disponibles.";
    exit;
}

$compra = $_SESSION['compra'];
$cliente = $compra['cliente_nombre'] ?? 'Cliente registrado';
$email = $compra['cliente_email'] ?? 'No registrado';
$producto = $compra['nombre_producto'];
$precio = $compra['precio'];
$metodo = ucfirst($compra['metodo_pago']);
$fecha = $compra['fecha'];

class PDF extends FPDF {
    function Header() {
        // Logo
        if (file_exists('images/logo.png')) {
            $this->Image('images/logo.png', 10, 10, 30);
        }

        // Título
        $this->SetFont('Arial', 'B', 16);
        $this->SetTextColor(40, 40, 100);
        $this->Cell(0, 10, 'Recibo de Compra - Palmaire', 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-20);
        $this->SetFont('Arial', 'I', 10);
        $this->SetTextColor(100);
        $this->Cell(0, 10, utf8_decode('Gracias por su compra. ¡Buen viaje con Palmaire!'), 0, 1, 'C');
        $this->Cell(0, 10, 'www.palmaire.com', 0, 0, 'C');
    }
}

// Crear PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0);

// Tabla de datos
$pdf->Cell(50, 10, 'Cliente:', 0, 0);
$pdf->Cell(0, 10, utf8_decode($cliente), 0, 1);

$pdf->Cell(50, 10, 'Email:', 0, 0);
$pdf->Cell(0, 10, $email, 0, 1);

$pdf->Cell(50, 10, 'Vuelo:', 0, 0);
$pdf->Cell(0, 10, utf8_decode($producto), 0, 1);

$pdf->Cell(50, 10, 'Precio:', 0, 0);
$pdf->Cell(0, 10, '$' . number_format($precio, 2), 0, 1);

$pdf->Cell(50, 10, 'Método de pago:', 0, 0);
$pdf->Cell(0, 10, $metodo, 0, 1);

$pdf->Cell(50, 10, 'Fecha de compra:', 0, 0);
$pdf->Cell(0, 10, $fecha, 0, 1);

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, '¡Gracias por elegir Palmaire!', 0, 1, 'C');

// Salida PDF
$pdf->Output('I', 'recibo.pdf');
exit;