<?php
/**
 * Procesa el inicio de sesión del usuario con mejoras de seguridad.
 *
 * Medidas implementadas adicionales:
 *  - Limpiar entradas con trim() y htmlspecialchars().
 *  - Simulación de hash de contraseña.
 *  - Bloqueo temporal tras superar intentos fallidos.
 *  - Mensajes de error claros con número de intentos restantes.
 */

session_start();

// Credenciales válidas (en producción usar base de datos y hash)
$USUARIO_CORRECTO = "Javier";
$PASS_CORRECTO_HASH = password_hash("12345", PASSWORD_DEFAULT); // simula hash

// Inicializa contador de intentos y tiempo de bloqueo
if (!isset($_SESSION['intentos'])) {
    $_SESSION['intentos'] = 0;
}
if (!isset($_SESSION['bloqueo'])) {
    $_SESSION['bloqueo'] = 0; // timestamp del bloqueo
}

// Comprobar bloqueo temporal (5 min)
if ($_SESSION['bloqueo'] > time()) {
    $restante = $_SESSION['bloqueo'] - time();
    die("Acceso bloqueado temporalmente. Intenta nuevamente en $restante segundos.");
}

// Recoger datos de formulario de forma segura
$usuario = isset($_POST['usuario']) ? htmlspecialchars(trim($_POST['usuario'])) : '';
$contrasenya = isset($_POST['contrasenya']) ? trim($_POST['contrasenya']) : '';

// Verificar credenciales
if ($usuario === $USUARIO_CORRECTO && password_verify($contrasenya, $PASS_CORRECTO_HASH)) {

    // Login correcto
    $_SESSION['intentos'] = 0;
    $_SESSION['usuario'] = $usuario;

    header("Location: logueado.php");
    exit;

} else {

    // Login incorrecto
    $_SESSION['intentos']++;

    if ($_SESSION['intentos'] >= 3) {
        // Bloqueo temporal de 5 minutos
        $_SESSION['bloqueo'] = time() + 300; // 300 segundos = 5 minutos
        header("Location: bloqueo.php");
        exit;
    } else {
        // Redirigir con mensaje de error y número de intentos restantes
        $restantes = 3 - $_SESSION['intentos'];
        header("Location: login.php?error=1&restantes=$restantes");
        exit;
    }
}
