<?php
    include '../../../core/config.php';
    include '../../../core/functions.php';
    include '../../../../core/dbconnect.php';

    $catId = $_GET['id'];

    $query = "DELETE FROM `categories` WHERE `categories`.`id` = " . $catId;

    $result = $mysqli->query($query);

    if ($result) {
        //echo $query;
        header("Location: " . $links['category'] . "?status=success" );
    }

?>