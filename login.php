<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cargar la configuración de conexiones
require('config/database.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.html');
    exit();
}

// Capturar credenciales enviadas desde el formulario
$e_mail = trim($_POST['email'] ?? '');
$p_assword = trim($_POST['psw'] ?? $_POST['password'] ?? '');

if (empty($e_mail) || empty($p_assword)) {
    echo "<script>
            alert('Por favor complete todos los campos');
            window.location.href = 'login.html';
          </script>";
    exit();
}

// Verificar conexión a Supabase
if (!$supa_conn) {
    echo "<script>
            alert('Error crítico: No se pudo conectar al servidor de Supabase.');
            window.location.href = 'login.html';
          </script>";
    exit();
}

// Escapar caracteres para prevenir inyecciones
$safe_email = pg_escape_string($supa_conn, $e_mail);
$safe_password = pg_escape_string($supa_conn, $p_assword);

// Consulta ÚNICAMENTE a la tabla users de SUPABASE
$sql = "SELECT * FROM users WHERE email = '$safe_email' AND password = '$safe_password' LIMIT 1";
$supa_res = pg_query($supa_conn, $sql);

if ($supa_res && pg_num_rows($supa_res) > 0) {
    $user = pg_fetch_assoc($supa_res);

    $_SESSION['user_id']    = $user['id'] ?? null;
    $_SESSION['user_email'] = $user['email'] ?? $e_mail;
    $_SESSION['user_fname'] = $user['firstname'] ?? '';
    $_SESSION['user_lname'] = $user['lastname'] ?? '';

    echo "<script>
            alert('Inicio de sesión exitoso. ¡Bienvenido!');
            window.location.href = 'index.html';
          </script>";
    exit();
} else {
    echo "<script>
            alert('Error: Correo o contraseña incorrectos.');
            window.location.href = 'login.html';
          </script>";
    exit();
}
?>