<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Login Administrador</title>
    <link rel="stylesheet" href="admin_styles.css" />
</head>
<body>

<div class="login-container">
    <h2>Inicio de Sesión - Administrador</h2>

    <?php if (isset($_SESSION['error_admin'])): ?>
        <div class="error-msg"><?= $_SESSION['error_admin'] ?></div>
        <?php unset($_SESSION['error_admin']); ?>
    <?php endif; ?>

    <form action="admin_validar.php" method="POST">
        <label for="usuario">Correo electrónico:</label>
        <input type="text" name="usuario" id="usuario" required />

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" id="contrasena" required />

        <button type="submit">Ingresar</button>
    </form>
</div>

</body>
</html>
