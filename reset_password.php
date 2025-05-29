<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'pdo_connection.php';
session_start();

$userInput = trim($_POST['usuario'] ?? '');

if (empty($userInput)) {
    $_SESSION['resetMsg'] = 'Introduce tu usuario o email.';
    header('Location: index.php?formulario=reset');
    exit();
}

// Buscar usuario por nombre o email
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = :usuario OR email = :email");
$stmt->bindParam(':usuario', $userInput, PDO::PARAM_STR);
$stmt->bindParam(':email', $userInput, PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['resetMsg'] = 'Si el usuario existe, recibirás un email.';
    header('Location: index.php?formulario=reset');
    exit();
}

// Generar token y caducidad
$token = bin2hex(random_bytes(64));
$caducidad = (new DateTime())->add(new DateInterval('PT1H'))->format('Y-m-d H:i:s');
$tipo = 'reset';

// Insertar en temporal
$insert = "INSERT INTO temporal (usuario, email, telefono, password, tokenRegistro, tokenCaducidad, tipo)
           VALUES (:usuario, :email, '', '', :token, :caducidad, :tipo)";
$stmt = $conn->prepare($insert);
$stmt->bindParam(':usuario', $user['usuario'], PDO::PARAM_STR);
$stmt->bindParam(':email', $user['email'], PDO::PARAM_STR);
$stmt->bindParam(':token', $token, PDO::PARAM_STR);
$stmt->bindParam(':caducidad', $caducidad, PDO::PARAM_STR);
$stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
$stmt->execute();

// Enviar email con el enlace
$link = "http://colores-omarfb.byethost5.com/nueva_password.php?token=$token";
$bodyAsunto = "<h1>Recupera tu contraseña</h1>
<p>Haz clic en el siguiente enlace para restablecer tu contraseña:</p>
<a href='$link'>$link</a>
<p>Este enlace caduca en 1 hora.</p>";

$email = $user['email'];
$usuario = $user['usuario'];
error_log("Intentando enviar email a: " . $user['email']);


// Incluir el archivo de envío de email y verificar que existe
ob_clean();

include 'email_validacion.php';

// Verificar si el email se envió correctamente
if(!isset($mailEnviado) || !$mailEnviado) {
    $_SESSION['resetMsg'] = 'Error al enviar el email. Inténtalo de nuevo más tarde.';
} else {
    $_SESSION['resetMsg'] = 'Si el usuario existe, recibirás un email con las instrucciones.';
}

header('location: index.php?formulario=revisar');
exit();