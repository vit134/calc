<?php
    include '../../../core/config.php';
    include '../../../core/functions.php';
    include '../../../../core/dbconnect.php';

    $back = getenv("HTTP_REFERER");

    $insertArr = [];
    $publish = $_POST['publish'] == 'on' ? 1 : 0;

    foreach ($_POST['materials'] as $key => $value) {
        $insertArr[] = '(' . $_POST['id'] . ',' . $value . ')';
    }


    $deleteQuery = "DELETE FROM `subserv_vs_materials` WHERE subserv_id = " . $_POST['id'];
    $deleteResult = $mysqli->query($deleteQuery);

    $insertQuery = "INSERT INTO `subserv_vs_materials`(`subserv_id`, `material_id`) VALUES " . implode(',', $insertArr);
    $insertResult = $mysqli->query($insertQuery);

    $updateQuery = "UPDATE `subservices`
                    SET `name`='". $_POST['name'] ."',
                        `publish`=". $publish .",
                        `price_for_unit`='". $_POST['price_for_unit'] ."',
                        `minute_for_unit`='". $_POST['minute_for_unit'] ."'
                    WHERE id = " . $_POST['id'];

    $updateResult = $mysqli->query($updateQuery);

    if ($deleteResult && $insertResult && $updateResult) {
        header("Location: " . $links['subservice'] .  $_POST['id']);
    } else {
        echo $deleteResult . '<br>' . $insertResult . '<br>' . $updateResult;
    }
?>