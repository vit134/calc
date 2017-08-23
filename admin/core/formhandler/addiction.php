<?php

    include '../../core/config.php';
    include '../../../core/dbconnect.php';

    //var_dump($_POST);

    $serviceId = $_POST['service_id'];
    unset($_POST['service_id']);
    unset($_POST['submit']);

    //$subservicesId = [];
    $queryVals = [];


    foreach ($_POST as $key => $value) {
        $subServiceId = str_replace('check_', '', $key);

        //$subservicesId[] = intval($subServiceId);

        $queryVals[] = '(' . $serviceId . ',' . intval($subServiceId) . ')';
    }

    //echo $serviceId . '<br>';
    //var_dump($subservicesId);

    $query = "INSERT INTO `serv_vs_subserv`(`serv_id`, `subserv_id`) VALUES " . implode(",", $queryVals);
    $result = $mysqli->query($query);

    if ($result) {
        header("Location: ". $config['adminPath'] . "/service/". $serviceId ."?status=success");
    } else {
        header("Location: ". $config['adminPath'] . "/service/". $serviceId ."?status=error");
    }
?>