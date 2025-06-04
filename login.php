<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="styles_login.css">
</head>
<body>

<div class="login-container">
    <h2>Iniciar Sesión</h2>

    <?php if (isset($_SESSION['error_login'])): ?>
        <div class="error-msg"><?= $_SESSION['error_login'] ?></div>
        <?php unset($_SESSION['error_login']); ?>
    <?php endif; ?>

    <form action="login_validar.php" method="POST">
        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Iniciar sesión</button>
    </form>

    <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
</div>

</body>
</html>
