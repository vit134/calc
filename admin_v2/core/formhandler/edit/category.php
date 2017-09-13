<?php
    include '../../../core/config.php';
    include '../../../core/functions.php';
    include '../../../../core/dbconnect.php';

    $func = new globalClass();

    $back = getenv("HTTP_REFERER");

    $insertArr = [];
    $publish = $_POST['publish'] == 'on' ? 1 : 0;
    $insertResult = true;

    $deleteQuery = "DELETE FROM `cat_vs_service` WHERE cat_id = " . $_POST['id'];
    $deleteResult = $mysqli->query($deleteQuery);


    if ($_POST['services'] != Null) {
        foreach ($_POST['services'] as $key => $value) {
            $insertArr[] = '(' . $_POST['id'] . ',' . $value . ')';
        }

        $insertQuery = "INSERT INTO `cat_vs_service`(`cat_id`, `serv_id`) VALUES " . implode(',', $insertArr);
        $insertResult = $mysqli->query($insertQuery);
    }

    $updateQuery = "UPDATE `categories` SET `name`='". $_POST['name'] ."',`publish`=". $publish ." WHERE id = " . $_POST['id'];
    $updateResult = $mysqli->query($updateQuery);

    if ($deleteResult && $insertResult && $updateResult) {
        header("Location: " . $links['category'] .  $_POST['id']);
    } else {
        echo $deleteResult . '<br>' . $insertResult . '<br>' . $updateResult;
    }
?>