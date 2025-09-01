<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['exito' => false, 'mensaje' => 'No ha iniciado sesión.']);
    exit();
}

$conexion = new mysqli("fdb1034.awardspace.net", "4667283_usuarios", "zelda2323", "4667283_usuarios");

if ($conexion->connect_error) {
    echo json_encode(['exito' => false, 'mensaje' => 'Error de conexión.']);
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$universidad = $_POST['universidad'] ?? '';

$universidades_validas = ['ITCJ', 'TEC', 'URN', 'UACJ', 'UACH'];
if (!in_array($universidad, $universidades_validas)) {
    echo json_encode(['exito' => false, 'mensaje' => 'Universidad no permitida.']);
    exit();
}

$verificar = $conexion->prepare("SELECT id FROM votos WHERE usuario_id = ?");
$verificar->bind_param("i", $usuario_id);
$verificar->execute();
$resultado = $verificar->get_result();

if ($resultado->num_rows > 0) {
    echo json_encode(['exito' => false, 'mensaje' => 'Ya ha votado anteriormente.']);
    exit();
}

$insertar = $conexion->prepare("INSERT INTO votos (usuario_id, universidad) VALUES (?, ?)");
$insertar->bind_param("is", $usuario_id, $universidad);

if ($insertar->execute()) {
    $contar = $conexion->prepare("SELECT COUNT(*) AS total FROM votos WHERE universidad = ?");
    $contar->bind_param("s", $universidad);
    $contar->execute();
    $resultadoConteo = $contar->get_result();
    $fila = $resultadoConteo->fetch_assoc();

    echo json_encode([
        'exito' => true,
        'votos' => $fila['total'],
        'mensaje' => "Usted ha votado por $universidad"
    ]);
    exit();
} else {
    echo json_encode(['exito' => false, 'mensaje' => 'Error al registrar el voto.']);
    exit();
}

$conexion->close();
?>
