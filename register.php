<?php
    require('config/database.php');

    $f_name=$_POST['fname'];
    $l_name=$_POST['lname'];
    $m_phone=$_POST['mphone'];
    $e_mail=$_POST['email'];
    $p_assword=$_POST['psw'];

   $hashed_password = md5($p_assword);

    $sql_val_email = "
        SELECT u.email FROM users u WHERE u.email = '$e_mail'
    ";
    $res_email = pg_query($supa_conn, $sql_val_email);

    $sql_val_phone = "
        SELECT u.mobile_phone FROM users u WHERE u.mobile_phone = '$m_phone'
    ";
    $res_phone = pg_query($supa_conn, $sql_val_phone);

    if(pg_num_rows($res_email) > 0){
        echo "<script>alert('User email already exists :::')</script>";
        header('refresh:0;url=register.html');
    }else if(pg_num_rows($res_phone) > 0){
        echo "<script>alert('User mobile phone already exists :::')</script>";
        header('refresh:0;url=register.html');
    }else{
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

        if($supa_res){
            echo "<script>alert('User has been created successfully into supabase database !!!')</script>";
            header('refresh:0;url=login.html');
        } else{
            echo "User hasn't been created into supabase database !!!<br>";
        }
    }
?>