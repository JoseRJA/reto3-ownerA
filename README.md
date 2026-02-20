# Sistema de Login en PHP con Control de Intentos

Proyecto en PHP que implementa un sistema de inicio de sesión básico utilizando sesiones, con control de intentos fallidos para prevenir accesos no autorizados por fuerza bruta.

El sistema valida credenciales fijas y bloquea el acceso tras 3 intentos fallidos, redirigiendo al usuario a una página de bloqueo.

---

## Funcionalidades

- Autenticación de usuarios mediante usuario y contraseña.
- Control de intentos fallidos usando `$_SESSION`.
- Bloqueo automático tras 3 intentos incorrectos.
- Redirecciones seguras según el estado del login.
- Limpieza básica de datos de entrada con `trim()`.

---

## Requisitos previos

Antes de ejecutar el proyecto debes tener instalado:

- PHP >= 7.4
- Servidor web (Apache o Nginx)
- Navegador web moderno
- Git (opcional, para clonar el repositorio)

---

## Instalación

1. Clonar el repositorio:

```bash
git clone https://github.com/usuario/sistema-login-php.git
```

2. Copiar los archivos al directorio público del servidor web (por ejemplo `htdocs` o `www`).

3. Asegurarse de que las sesiones están habilitadas en PHP.

---

## Uso

1. Acceder al formulario de inicio de sesión:

```
http://localhost/login.php
```

2. Introducir las credenciales correctas:

- Usuario: **Javier**
- Contraseña: **12345**

3. Si el login es correcto, el usuario será redirigido a `logueado.php`.

4. Tras 3 intentos fallidos, el acceso se bloquea y se redirige a `bloqueo.php`.

---

## Estructura del Proyecto

```text
/proyecto-login
 ├── login.php              # Formulario de inicio de sesión
 ├── login_process.php      # Procesamiento del login y control de intentos
 ├── logueado.php           # Zona privada tras login correcto
 ├── bloqueo.php            # Página de bloqueo por intentos fallidos
 └── README.md              # Documentación del proyecto
```

---

## Acceso y Credenciales

Las credenciales están definidas de forma fija en el archivo `login_process.php`:

```php
$USUARIO_CORRECTO = "Javier";
$PASS_CORRECTO = "12345";
```

---

## Seguridad Implementada

- Control de intentos fallidos mediante sesiones.
- Bloqueo tras superar el límite de intentos.
- Redirecciones controladas con `header()` y `exit`.
- Limpieza básica de datos con `trim()`.

---

## Contribución

1. Hacer un fork del repositorio.
2. Crear una nueva rama para la funcionalidad o corrección:

```bash
git checkout -b mejora-login
```

3. Realizar los cambios y hacer commit.
4. Enviar un Pull Request.

---

## Autor

Proyecto desarrollado con fines educativos como práctica de PHP y control de sesiones.
