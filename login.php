<?php
    session_start();
    // Ruta corregida según la estructura de tu proyecto:
    require('config/database.php');

    $email  = $_POST['email'] ?? '';
    // Lee 'psw' (que es el name que tiene tu login.html) o 'passwd'
    $passwd = $_POST['psw'] ?? $_POST['passwd'] ?? '';
    $pass_enc = md5($passwd);

    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$pass_enc'";
    $res = pg_query($supa_conn, $sql);

    if($res && pg_num_rows($res) > 0){
        $user = pg_fetch_assoc($res);

        // Guardamos los nombres en la sesión
        $_SESSION['user_name'] = $user['firstname'];
        $_SESSION['user_lname'] = $user['lastname'];

        // Redirige al nuevo index.php
        header('Location: index.php');
        exit;
    }else{
        echo "<script>alert('Invalid email or password :::'); window.location.href='login.html';</script>";
        exit;
    }
?>