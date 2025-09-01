<?php
session_start();

$conexion = new mysqli("fdb1034.awardspace.net", "4667283_usuarios", "zelda2323", "4667283_usuarios");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["correo"];
    $password = $_POST["password"];

    $stmt = $conexion->prepare("SELECT * FROM registros WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($password, $usuario["password"])) {
            $_SESSION["usuario_id"] = $usuario["id"];
            $_SESSION["correo"] = $usuario["correo"];

            header("Location: index.php");
            exit();
        } else {
            $mensaje = "Contraseña incorrecta.";
        }
    } else {
        $mensaje = "Usuario no encontrado.";
    }

    $stmt->close();
}
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/registro.css">
</head>
<body>
    <div class="login-container">
        <img src="img/STEM.png" alt="Academia STEM" class="logo">
        <h2>Iniciar sesión</h2>

        <?php if (!empty($mensaje)) : ?>
            <div class="mensaje-error"><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <input type="email" name="correo" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Entrar</button>
        </form>

        <small>¿Aún no tienes cuenta? <a href="registro.php">Regístrate aquí</a>.</small>
    </div>
</body>
</html>
