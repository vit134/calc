<?php
    session_start();
    include '../../core/config.php';
    include '../../../core/dbconnect.php';

    $back = getenv("HTTP_REFERER");

    if (!isset($__POST)) {
        $login = trim($_POST['login']);
        $pass = md5(trim($_POST['pass']));

        $query = "SELECT id, active FROM users WHERE login = '". $login ."' and pass = '". $pass ."' ";

        $result = $mysqli->query($query);
        //echo $login . '---' . $pass;


        if ($result->num_rows != 0) {
            //echo $result->fetch_array(MYSQLI_NUM)[1];
            $user = $result->fetch_array(MYSQLI_NUM);
            $active = $user[1];
            $id = $user[0];

            if ($active == 1) {

                $updateQuery = "UPDATE `users` SET `last_login`=NOW() WHERE id = " . $id;

                $resultUpdate = $mysqli->query($updateQuery);
                $_SESSION['user_id'] = $id;

                header("Location: " . $back . "?status=success");
            } else {
                header("Location: " . $config['adminPath'] . "?error=true&message=no-activate" );
            }
        } else {
            header("Location: " . $config['adminPath'] . "?error=true" );
        }
    }
?>