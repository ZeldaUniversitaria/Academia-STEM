<?php
$conexion = new mysqli("fdb1034.awardspace.net", "4667283_usuarios", "zelda2323", "4667283_usuarios");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $passwordEncriptada = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO registros (correo, password) VALUES (?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $correo, $passwordEncriptada);

    if ($stmt->execute()) {
        header("Location: index.html");
        exit();
    } else {
        echo "Error al registrar: " . $stmt->error;
    }

    $stmt->close();
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="css/registro.css">
</head>
<body>
    <div class="login-container">
        <img src="img/STEM.png" alt="Academia STEM" class="logo">
        <h2>Registro al Torneo Academia STEM</h2>
        <form method="POST" action="registro.php">
            <input type="email" name="correo" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Registrarse</button>
        </form>
        <small>¿Ya estás registrado? <a href="login.php">Inicia sesión aquí</a>.</small>

    </div>
</body>
</html>
