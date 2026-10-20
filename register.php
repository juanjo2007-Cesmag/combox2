<?php
    //Get data base connection
    require('config/database.php');

    //Get data from html form (client)
    $f_name=$_POST['fname'];
    $l_name=$_POST['lname'];
    $m_phone=$_POST['mphone'];
    $e_mail=$_POST['email'];
    $p_assword=$_POST['psw'];

    $hashed_password = password_hash($p_assword, PASSWORD_DEFAULT);

    $sql = "
        INSERT INTO users (
            firstname, lastname, mobile_phone, email, password
        )
        VALUES(
            '$f_name', '$l_name', '$m_phone', '$e_mail', '$hashed_password'
        )
    ";

    $local_res = pg_query($local_conn, $sql);
    $supa_res = pg_query($supa_conn, $sql);

    if($local_res && $supa_res){
        echo "<script>
                alert('User has been created successfully!');
                window.location.href = 'login.html';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Error: User hasn\'t been created.');
                window.location.href = 'register.html';
              </script>";
        exit();
    }
?>