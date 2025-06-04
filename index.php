<?php
session_start();
require_once 'conexion.php';

try {
    // Consulta productos con una imagen (primera imagen encontrada por producto)
    $sql = "SELECT p.*, i.nombre_archivo 
            FROM productos p
            LEFT JOIN imagenes i ON i.producto_id = p.id
            GROUP BY p.id";
    $stmt = $pdo->query($sql);
    $vuelos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al consultar vuelos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tienda de Boletos de Avión</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="#inicio">Inicio</a></li>
                <li><a href="#quienes-somos">Quiénes Somos</a></li>
                <li><a href="#catalogo">Catálogo</a></li>
                <li><a href="#registro">Registro</a></li>
                <li><a href="#contacto">Contacto</a></li>
                <?php if (isset($_SESSION['usuario_nombre'])): ?>
                    <?php if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin'): ?>
                        <li><a href="admin_panel.php">Panel Admin</a></li>
                    <?php endif; ?>
                    <li><a href="logout.php">Cerrar sesión (<?= htmlspecialchars($_SESSION['usuario_nombre']) ?>)</a></li>
                <?php else: ?>
                    <li><a href="login.php">Iniciar sesión</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <section id="inicio">
        <div class="container">
            <h1>Bienvenido a Palmaire</h1>
            <p>Encuentra tus boletos para el destino de tus sueños</p>
        </div>
    </section>

    <section id="quienes-somos">
        <div class="container">
            <h2>Quiénes Somos</h2>
            <p>Somos una empresa líder en la venta de boletos de avión en línea, comprometida con brindar a nuestros clientes la mejor experiencia de compra y viaje. Nuestro equipo de expertos en viajes trabaja arduamente para ofrecerte las mejores opciones de vuelos, precios competitivos y un servicio al cliente excepcional.</p>
        </div>
    </section>

    <section id="catalogo">
        <div class="container">
            <h2>Catálogo de Boletos</h2>
            <div class="productos">
                <?php if (empty($vuelos)): ?>
                    <p>No hay vuelos disponibles por el momento.</p>
                <?php else: ?>
                    <?php foreach ($vuelos as $vuelo): ?>
                        <div class="producto">
                            <?php if (!empty($vuelo['nombre_archivo'])): ?>
                                <img src="images/<?= htmlspecialchars($vuelo['nombre_archivo']) ?>" alt="Vuelo a <?= htmlspecialchars($vuelo['nombre']) ?>" class="producto-img" />
                            <?php else: ?>
                                <img src="images/default.jpg" alt="Imagen no disponible" class="producto-img" />
                            <?php endif; ?>
                            <h3><?= htmlspecialchars($vuelo['nombre']) ?></h3>
                            <p>Precio: $<?= number_format($vuelo['precio'], 2) ?></p>
                            <p>Asientos disponibles: <?= (int)$vuelo['asientos_disponibles'] ?></p>

                            <?php if ((int)$vuelo['asientos_disponibles'] > 0): ?>
                                <a href="comprar.php?id=<?= (int)$vuelo['id'] ?>"><button>Comprar</button></a>
                            <?php else: ?>
                                <button disabled>Agotado</button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section id="registro">
        <div class="container">
            <h2>Registro</h2>
            <form action="registro.php" method="post">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Registrar</button>
            </form>
        </div>
    </section>

    <section id="contacto">
        <div class="container">
            <h2>Contacto</h2>
            <p>Para más información, contáctanos al: <a href="mailto:Palmaire@outlook.com">Palmaire@outlook.com</a></p>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 Tienda de Boletos de Avión</p>
    </footer>
</body>
</html>
