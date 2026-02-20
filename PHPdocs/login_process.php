<?php
/**
 * Procesa el inicio de sesión del usuario.
 *
 * Este script gestiona la autenticación básica mediante credenciales fijas
 * y controla el número de intentos fallidos usando sesiones.
 * Si se superan los 3 intentos, el usuario es redirigido a una página
 * de bloqueo o contacto técnico.
 *
 * Medidas implementadas:
 *  - Control de intentos fallidos mediante $_SESSION.
 *  - Redirecciones seguras según el estado de autenticación.
 *  - Protección básica contra datos vacíos usando trim().
 *
 * @package SistemaLogin
 */

session_start();

/**
 * Nombre de usuario válido del sistema.
 *
 * @var string
 */
$USUARIO_CORRECTO = "Javier";

/**
 * Contraseña válida del sistema.
 *
 * @var string
 */
$PASS_CORRECTO = "12345";

/**
 * Inicializa el contador de intentos fallidos si no existe.
 *
 * Se utiliza la sesión para persistir los intentos entre peticiones
 * y evitar ataques de fuerza bruta simples.
 */
if (!isset($_SESSION['intentos'])) {
    $_SESSION['intentos'] = 0;
}

/**
 * Redirige al usuario si ha superado el número máximo de intentos.
 *
 * A partir de 3 intentos fallidos se bloquea el acceso.
 */
if ($_SESSION['intentos'] >= 3) {
    header("Location: bloqueo.php");
    exit;
}

/**
 * Usuario introducido en el formulario.
 *
 * @var string
 */
$usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';

/**
 * Contraseña introducida en el formulario.
 *
 * @var string
 */
$contrasenya = isset($_POST['contrasenya']) ? trim($_POST['contrasenya']) : '';

/**
 * Verificación de credenciales.
 *
 * Si las credenciales son correctas:
 *  - Se reinicia el contador de intentos.
 *  - Se guarda el usuario en la sesión.
 *  - Se redirige a la zona privada.
 *
 * Si son incorrectas:
 *  - Se incrementa el contador de intentos.
 *  - Se redirige al formulario o a la página de bloqueo.
 */
if ($usuario === $USUARIO_CORRECTO && $contrasenya === $PASS_CORRECTO) {

    // Login correcto
    $_SESSION['intentos'] = 0;
    $_SESSION['usuario'] = $usuario;

    header("Location: logueado.php");
    exit;

} else {

    // Login incorrecto
    $_SESSION['intentos']++;

    if ($_SESSION['intentos'] >= 3) {

        // Bloqueo tras 3 intentos fallidos
        header("Location: bloqueo.php");
        exit;

    } else {

        // Redirección al formulario con mensaje de error
        $restantes = 3 - $_SESSION['intentos'];
        header("Location: login.php?error=1&restantes=$restantes");
        exit;
    }
}
