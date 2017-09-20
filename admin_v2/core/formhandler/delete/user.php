<?php
    include '../../../core/config.php';
    include '../../../core/functions.php';
    include '../../../../core/dbconnect.php';

    $userId = $_GET['id'];

    $deleteFromUserQuery = "DELETE FROM `users` WHERE `id` = " . $userId;

    $result = $mysqli->query($deleteFromUserQuery);

    if ($result) {
        header("Location: " . $links['user'] . "?status=success" );
    }

?>