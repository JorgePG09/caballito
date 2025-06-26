<?php
// Paso 1: Iniciar la sesión existente.
// Es crucial llamar a session_start() al principio de cualquier script que maneje sesiones
// para poder acceder a la sesión actual y destruirla.
session_start();

// Paso 2: Destruir todas las variables de sesión.
// Esto elimina todos los datos almacenados en la variable superglobal $_SESSION.
$_SESSION = array();

// Paso 3: Si se utilizan cookies de sesión, también es buena práctica eliminar la cookie de sesión del navegador.
// Esto asegura que el navegador del usuario no tenga un ID de sesión inválido.
// Nota: Esto destruirá la sesión en el navegador, y no solo los datos de la sesión en el servidor.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params(); // Obtiene los parámetros actuales de la cookie de sesión
    setcookie(session_name(), '', time() - 42000, // Establece la cookie con una fecha de expiración en el pasado
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Paso 4: Finalmente, destruir la sesión.
// Esto elimina el archivo de sesión en el servidor.
session_destroy();

// Paso 5: Redirigir al usuario a la página de inicio de sesión o a la página principal.
// Es una buena práctica redirigir al usuario después de cerrar sesión para confirmar la acción
// y evitar que intente acceder a páginas protegidas con un ID de sesión expirado.
header("Location:../login.php"); // Puedes cambiar 'login.php' a la página que desees (ej. 'index.php')
exit(); // Es crucial usar exit() después de un header() para asegurar que el script se detiene
        // y la redirección se ejecuta inmediatamente.
?>