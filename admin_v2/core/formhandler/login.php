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

            $id = $result->fetch_array(MYSQLI_NUM)[0];

            $updateQuery = "UPDATE `users` SET `last_login`=NOW() WHERE id = " . $id;

            $resultUpdate = $mysqli->query($updateQuery);

            $_SESSION['user_id'] = $id;

            header("Location: " . $config['adminPath'] );
        } else {
            header("Location: " . $config['adminPath'] . "?error=true" );
        }
    }
?>