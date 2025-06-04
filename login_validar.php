<?php
session_start();
require 'conexion.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->execute([$email]);
$usuario = $stmt->fetch();

if ($usuario && password_verify($password, $usuario['password'])) {
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nombre'] = $usuario['nombre'];
    $_SESSION['usuario_rol'] = $usuario['es_admin'] ? 'admin' : 'cliente';
    header('Location: index.php');
    exit;
} else {
    $_SESSION['error_login'] = "Correo o contraseña incorrectos.";
    header('Location: login.php');
    exit;
}
