<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

$conexion = new mysqli("fdb1034.awardspace.net", "4667283_usuarios", "zelda2323", "4667283_usuarios");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$usuario_id = $_SESSION["usuario_id"];
$universidadVotada = null;

$query = $conexion->prepare("SELECT universidad FROM votos WHERE usuario_id = ?");
$query->bind_param("i", $usuario_id);
$query->execute();
$resultado = $query->get_result();

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $universidadVotada = $fila['universidad'];
}

$conteos = [];
$consultaConteo = $conexion->query("SELECT universidad, COUNT(*) as total FROM votos GROUP BY universidad");
while ($row = $consultaConteo->fetch_assoc()) {
    $conteos[$row['universidad']] = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Academia STEM</title>
</head>
<body>
    <header>
        <h1 id="titulo">Torneo Academia STEM</h1>
        <br><br>
        <img src="img/STEM.png" alt="ACADEMIA STEM" width="700" />
        <br><br>
        <h2 id="subtitulo">Votos por proyecto</h2>
        <h3 id="categoria">Categoria IOT</h3>
        <?php if ($universidadVotada): ?>
    		<p><strong>Usted ha votado por <?= htmlspecialchars($universidadVotada) ?>.</strong></p>
		<?php endif; ?>

    </header>
    
    <main class="proyectos">
        <div class="tarjeta">
            <p class="contador">Votos: <span id="contador1"><?= $conteos['ITCJ'] ?? 0 ?></span></p>
            <img class="imagenes" src="img/ITCJ_LOGO.png" alt="ACADEMIA STEM"/>
            <h4>ITCJ</h4>
            <button id="miBoton1" class="boton-votar" <?= $universidadVotada ? 'disabled' : '' ?> onclick="votar('ITCJ')">
                <?= $universidadVotada === 'ITCJ' ? 'Votado' : 'Votar' ?>
            </button>
        </div>

        <div class="tarjeta">
            <p class="contador">Votos: <span id="contador2"><?= $conteos['TEC'] ?? 0 ?></span></p>
            <img class="imagenes" src="img/TEC_LOGO.png" alt="ACADEMIA STEM"/>
            <h4>TEC</h4>
            <button id="miBoton2" class="boton-votar" <?= $universidadVotada ? 'disabled' : '' ?> onclick="votar('TEC')">
                <?= $universidadVotada === 'TEC' ? 'Votado' : 'Votar' ?>
            </button>
        </div>

        <div class="tarjeta">
            <p class="contador">Votos: <span id="contador3"><?= $conteos['URN'] ?? 0 ?></span></p>
            <img class="imagenes" src="img/URN_LOGO.png" alt="ACADEMIA STEM"/>
            <h4>URN</h4>
            <button id="miBoton3" class="boton-votar" <?= $universidadVotada ? 'disabled' : '' ?> onclick="votar('URN')">
                <?= $universidadVotada === 'URN' ? 'Votado' : 'Votar' ?>
            </button>
        </div>

        <div class="tarjeta">
            <p class="contador">Votos: <span id="contador4"><?= $conteos['UACJ'] ?? 0 ?></span></p>
            <img class="imagenes" src="img/UACJ_LOGO.png" alt="ACADEMIA STEM"/>
            <h4>UACJ</h4>
            <button id="miBoton4" class="boton-votar" <?= $universidadVotada ? 'disabled' : '' ?> onclick="votar('UACJ')">
                <?= $universidadVotada === 'UACJ' ? 'Votado' : 'Votar' ?>
            </button>
        </div>

        <div class="tarjeta">
            <p class="contador">Votos: <span id="contador5"><?= $conteos['UACH'] ?? 0 ?></span></p>
            <img class="imagenes" src="img/UACH_LOGO.png" alt="ACADEMIA STEM"/>
            <h4>UACH</h4>
            <button id="miBoton5" class="boton-votar" <?= $universidadVotada ? 'disabled' : '' ?> onclick="votar('UACH')">
                <?= $universidadVotada === 'UACH' ? 'Votado' : 'Votar' ?>
            </button>
        </div>
    </main>



    <script src="js/script.js"></script>
</body>
</html>