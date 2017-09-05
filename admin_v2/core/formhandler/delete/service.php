<?php
    include '../../../core/config.php';
    include '../../../core/functions.php';
    include '../../../../core/dbconnect.php';

    $servId = $_GET['id'];

    $deleteFromServQuery = "DELETE FROM `services` WHERE `id` = " . $servId;

    $result = $mysqli->query($deleteFromServQuery);

    if ($result) {
        header("Location: " . $links['service'] . "?status=success" );
    }

?>