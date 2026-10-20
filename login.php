<?php
    // Conexión a la base de datos
    require('config/database.php');

    // Recibir los datos del formulario de login
    $e_mail = $_POST['email'];
    $p_assword_ingresada = $_POST['psw']; // El usuario escribe "123456"

    // 1. Buscamos al usuario SOLO por su correo electrónico
    $sql = "SELECT * FROM users WHERE email = '$e_mail'";
    $resultado = pg_query($local_conn, $sql);

    // 2. Verificamos si el correo existe en la base de datos
    if (pg_num_rows($resultado) > 0) {
        
        // Extraemos los datos del usuario, incluyendo su contraseña encriptada
        $usuario = pg_fetch_assoc($resultado);
        $hash_de_la_bd = $usuario['password']; // Esta es la cadena larga "$2y$10$..."

        // 3. Comparamos la contraseña normal con la encriptada usando password_verify
        if (password_verify($p_assword_ingresada, $hash_de_la_bd)) {
            // ¡Las contraseñas coinciden! El login es exitoso
            echo "<script>
                    alert('¡Bienvenido!');
                    window.location.href = 'index.html'; // Redirige a la página principal
                  </script>";
        } else {
            // La contraseña es incorrecta
            echo "<script>
                    alert('Contraseña incorrecta.');
                    window.location.href = 'login.html';
                  </script>";
        }

    } else {
        // El correo no existe
        echo "<script>
                alert('El usuario no existe.');
                window.location.href = 'login.html';
              </script>";
    }
?>