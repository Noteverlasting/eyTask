<?php
require_once 'pdo_connection.php';
session_start();

$token = $_POST['token'] ?? '';
$password = $_POST['password'] ?? '';
$password2 = $_POST['password2'] ?? '';

if ($password !== $password2 || strlen($password) < 6) {
    echo "Las contraseñas no coinciden o son demasiado cortas.";
    exit();
}

$stmt = $conn->prepare("SELECT * FROM temporal WHERE tokenRegistro = :token AND tokenCaducidad > NOW() AND tipo = 'reset'");
$stmt->bindParam(':token', $token, PDO::PARAM_STR);
$stmt->execute();
$reset = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reset) {
    echo "El enlace no es válido o ha caducado.";
    exit();
}

// Actualizar la contraseña
$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("UPDATE usuarios SET password = :password WHERE usuario = :usuario");
$stmt->bindParam(':password', $hash, PDO::PARAM_STR);
$stmt->bindParam(':usuario', $reset['usuario'], PDO::PARAM_STR);
$stmt->execute();

// Borra el token
$stmt = $conn->prepare("DELETE FROM temporal WHERE tokenRegistro = :token AND tipo = 'reset'");
$stmt->bindParam(':token', $token, PDO::PARAM_STR);
$stmt->execute();

echo "Contraseña actualizada correctamente. Ya puedes iniciar sesión.";
header('Location:index.php?formulario=login&mensaje=registro_ok');