<?php
    include '../../../core/config.php';
    include '../../../core/functions.php';
    include '../../../../core/dbconnect.php';

    $back = getenv("HTTP_REFERER");

    $insertArr = [];
    $publish = $_POST['publish'] == 'on' ? 1 : 0;

    foreach ($_POST['subservices'] as $key => $value) {
        $insertArr[] = '(' . $_POST['id'] . ',' . $value . ')';
    }


    $deleteQuery = "DELETE FROM `serv_vs_subserv` WHERE serv_id = " . $_POST['id'];
    $deleteResult = $mysqli->query($deleteQuery);

    $insertQuery = "INSERT INTO `serv_vs_subserv`(`serv_id`, `subserv_id`) VALUES " . implode(',', $insertArr);
    $insertResult = $mysqli->query($insertQuery);

    $updateQuery = "UPDATE `services` SET `name`='". $_POST['name'] ."',`publish`=". $publish ." WHERE id = " . $_POST['id'];
    $updateResult = $mysqli->query($updateQuery);

    if ($deleteResult && $insertResult && $updateResult) {
        header("Location: " . $links['service'] .  $_POST['id']);
    } else {
        echo $deleteResult . '<br>' . $insertResult . '<br>' . $updateResult;
    }
?>