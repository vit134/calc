<?php

    include '../../core/config.php';
    include '../../../core/dbconnect.php';

    //var_dump($_POST);
    //echo $mysqli;
    switch ($_POST['form-type']) {

        case 'category':
            if (allreadyCat($_POST['name'])) {
                $query = "INSERT INTO `categories`( `name`) VALUES ('". $_POST['name'] ."')";
                //echo $mysqli;
                $result = $mysqli->query($query);

                if ($result) {
                    header("Location: ". $config['adminPath'] ."/categories?status=success");
                } else {
                    header("Location: /admin?status=error");
                }
            } else {
                header("Location: /admin?status=allready");
            }

            break;

        case 'service':
            if (allreadyCat($_POST['name'])) {
                $query = "INSERT INTO `services` (`name`, `categoryId`) VALUES ('". $_POST['name'] ."', '". $_POST['category_id'] ."')";

                $result = $mysqli->query($query);

                if ($result) {
                    if ($_POST['loacation']) {
                        header("Location: ". $config['adminPath'] . "/" . $_POST['loacation'] . "?status=success");
                    } else {
                        header("Location: ". $config['adminPath'] ."/services?status=success");
                    }
                } else {
                    header("Location: /admin?status=error");
                }
            } else {
                header("Location: /admin?status=allready");
            }
            break;

        case 'subservice':
            if (allreadyCat($_POST['name'])) {
                $query = "INSERT INTO `subservices` (
                    `serviceId`,
                    `name`,
                    `price_for_unit`,
                    `minute_for_unit`
                ) VALUES (
                    '". $_POST['service_id'] ."',
                    '". $_POST['name'] ."',
                    '". $_POST['price'] ."',
                    '". $_POST['time'] ."'
                )";
                //echo $mysqli;
                $result = $mysqli->query($query);

                if ($result) {
                    if ($_POST['loacation']) {
                        header("Location: ". $config['adminPath'] . "/" . $_POST['loacation'] . "?status=success");
                    } else {
                        header("Location: ". $config['adminPath'] ."/services?status=success");
                    }
                } else {
                    header("Location: /admin?status=error");
                }
            } else {
                header("Location: /admin?status=allready");
            }
            break;
    }

    function allreadyCat($name) {
        global $mysqli;

        $catQuery = "SELECT * FROM `categories` WHERE `name` like " . $name;
        $resultCat = $mysqli->query($catQuery);

        if ($resultCat->num_rows != 0) {
            return false;
        } else {
            return true;
        }
    }

    function allreadyService($name) {
        global $mysqli;

        $catQuery = "SELECT * FROM `services` WHERE `name` like " . $name;
        $resultCat = $mysqli->query($catQuery);

        if ($resultCat->num_rows != 0) {
            return false;
        } else {
            return true;
        }
    }

    function allreadySubService($name) {
        global $mysqli;

        $catQuery = "SELECT * FROM `subservices` WHERE `name` like " . $name;
        $resultCat = $mysqli->query($catQuery);

        if ($resultCat->num_rows != 0) {
            return false;
        } else {
            return true;
        }
    }

?>