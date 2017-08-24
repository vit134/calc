<?php
    session_start();
    include '../../core/config.php';
    include '../../../core/dbconnect.php';

    if (!isset($__POST)) {
        $login = trim($_POST['login']);
        $pass = md5(trim($_PSOT));

        $query = "SELECT id FROM users WHERE login = '". $login ."' and pass = '". $pass ."' ";

        $result = $mysqli->query($query);
        //echo $login . '---' . $pass;

        if ($result && $result->num_rows != 0) {
            //var_dump($result->fetch_array(MYSQLI_NUM));
            $_SESSION['user_id'] = $result->fetch_array(MYSQLI_NUM)[0];
            header("Location: " . $config['adminPath'] );
        } else {
            header("Location: " . $config['adminPath'] . "?error=true" );
        }
    }
?>