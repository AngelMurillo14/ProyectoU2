<?php
session_start();
require 'conexion.php';

$stmt = $pdo->query("SELECT * FROM productos");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener imágenes agrupadas por producto
$stmtImgs = $pdo->query("SELECT * FROM imagenes");
$imagenes = [];
foreach ($stmtImgs as $img) {
    $imagenes[$img['producto_id']][] = $img['nombre_archivo'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Catálogo de Boletos</title></head>
<body>
<h1>Catálogo de Boletos</h1>

<?php if (isset($_SESSION['usuario_nombre'])): ?>
    <p>Bienvenido, <?=htmlspecialchars($_SESSION['usuario_nombre'])?> | <a href="logout.php">Cerrar sesión</a></p>
<?php else: ?>
    <p><a href="registro.php">Regístrate</a> o <a href="login.php">Inicia sesión</a> para comprar más fácil</p>
<?php endif; ?>

<ul>
<?php foreach ($productos as $p): ?>
    <li>
        <h2><?=htmlspecialchars($p['nombre'])?></h2>
        <p>Precio: $<?=$p['precio']?></p>
        <p>Asientos disponibles: <?=$p['asientos_disponibles']?></p>

        <?php
        // Mostrar múltiples imágenes si existen
        if (!empty($imagenes[$p['id']])) {
            foreach ($imagenes[$p['id']] as $img) {
                echo '<img src="images/' . htmlspecialchars($img) . '" style="max-width:150px;margin:5px;">';
            }
        }
        ?>

        <?php if ($p['asientos_disponibles'] > 0): ?>
            <br><a href="comprar.php?id=<?=$p['id']?>">Comprar</a>
        <?php else: ?>
            <br><span>Agotado</span>
        <?php endif; ?>
    </li>
<?php endforeach; ?>

</ul>

<?php if (isset($_SESSION['es_admin']) && $_SESSION['es_admin']): ?>
    <p><a href="admin.php">Ir al panel administrador</a></p>
<?php endif; ?>

</body>
</html>
