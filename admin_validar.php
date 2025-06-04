<?php
session_start();
require 'conexion.php';

$usuario = $_POST['usuario'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->execute([$usuario]);
$user = $stmt->fetch();

if ($user && password_verify($contrasena, $user['password']) && $user['es_admin']) {
    $_SESSION['admin'] = true;
    $_SESSION['usuario_nombre'] = $user['nombre'];
    $_SESSION['usuario_rol'] = 'admin';
    header('Location: admin_panel.php');
    exit;
} else {
    $_SESSION['error_admin'] = "Usuario o contraseña incorrectos, o no es administrador.";
    header('Location: admin_login.php');
    exit;
}
