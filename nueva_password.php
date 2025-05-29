<?php

require_once 'pdo_connection.php';
session_start();

$token = $_GET['token'] ?? '';

$stmt = $conn->prepare("SELECT * FROM temporal WHERE tokenRegistro = :token AND tokenCaducidad > NOW() AND tipo = 'reset'");
$stmt->bindParam(':token', $token, PDO::PARAM_STR);
$stmt->execute();
$reset = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reset) {
    echo "El enlace no es válido o ha caducado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include_once 'modulos/etiquetasMeta.php'; ?>
    <title>eytask // Reestablecer password </title>
    <link rel="shortcut icon" href="08_EJERCICIO_GESTOR/img/favicon.gif" type="image/x-icon"> 
    <link rel="stylesheet" href="08_EJERCICIO_GESTOR/css/copia.css">
</head>
<body>
    <?php
    include_once 'modulos/headercopy.php';
    ?>
    <main class="index-main">
    <section>
    <h2>Restablecer contraseña para <?= htmlspecialchars($reset['usuario']) ?></h2>
    <form action="actualizar_password.php" method="post">
        <fieldset class="crear-usuario">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <label>Nueva contraseña:</label>
        <input type="password" name="password" required>
        <br>
        <label>Repite la contraseña:</label>
        <input type="password" name="password2" required>
        <br>
        <button type="submit">Cambiar contraseña</button>
        </fieldset>
    </form>
    </section>
</body>
</html>