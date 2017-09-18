<?php
    session_start();
    include '../../core/config.php';
    include '../../../core/dbconnect.php';
    include '../../core/functions.php';


    //var_dump($_GET);
    $id = $_GET['id'];
    $secret = $_GET['secret'];

    $selectQuery = "SELECT * FROM `users` WHERE id = " . $id;
    $selectResult = $mysqli->query($selectQuery);

    if ($selectResult) {
        $result = $selectResult->fetch_array();

        $selectSecret = md5($result['login'] . $result['email']);

        if ($secret == $selectSecret) {


            $updateQuery = "UPDATE `users` SET `active`=1 WHERE id = " . $id;

            $updateResult = $mysqli->query($updateQuery);

            //$_SESSION['user_id'] = $id;
            if ($updateResult) {
                header("Location: " . $config['adminPath'] . '/user/lk' );
            } else {
                echo $updateQuery;
            }
        }
    }

?>