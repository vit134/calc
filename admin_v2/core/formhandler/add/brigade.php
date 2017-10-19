<?php

    include '../../../core/config.php';
    include '../../../../core/dbconnect.php';
    include '../../../core/functions.php';

    require_once '../../../../vendor/autoload.php';

    $func = new globalClass();
    $back = getenv("HTTP_REFERER");

    $data = $_POST;

    $response = array(
            'status' => 'error',
            'message' => 'empty'
    );

    echo '<pre>';
    var_dump($_POST);
    echo '</pre>';

    /*$checkQuery = "SELECT first_name, last_name FROM `clients` WHERE email = '" . $data['email'] . "'";
    $checkResult = $mysqli->query($checkQuery);

    if ($checkResult) {
        if ($checkResult->num_rows > 0) {
            $response['message'] = 'email_exists';
        } else {

            $login = mb_strtolower($func->rus2translit($data['first_name'])[0] . $func->rus2translit($data['second_name'])[0] . '_' . $func->rus2translit($data['last_name']));
            $pass = $func->randomString();



            $query = "INSERT INTO `clients`(
                `first_name`,
                `second_name`,
                `last_name`,
                `login`,
                `pass`,
                `phone`,
                `email`,
                `adress`
            ) VALUES (
                '" . $_POST['first_name'] . "',
                '" . $_POST['second_name'] . "',
                '" . $_POST['last_name'] . "',
                '" . $login . "',
                '" . $pass . "',
                '" . $_POST['phone'] . "',
                '" . $_POST['email'] . "',
                '" . $_POST['adress'] . "'
            )";

            if ($result = $mysqli->query($query)) {
                $response['status'] = 'success';
                $response['login'] = $login;
                $response['client_id'] = $mysqli->insert_id;
            } else {
                $response['message'] = $mysqli->error;
                $response['query'] = $query;
            }
        }
    } else {
        $response['message'] = '$mysqli->error';
        $response['query'] = $checkQuery;
    }





    echo json_encode($response);
    //echo json_encode($_POST);*/

?>