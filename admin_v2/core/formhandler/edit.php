<?php

    include '../../core/config.php';
    include '../../../core/dbconnect.php';

    //var_dump($_POST);
    //echo $mysqli;

    switch ($_POST['form-type']) {

        case 'category':
            if (allreadyCat($_POST['name'])) {
                $query = "UPDATE `categories` SET `name`='". $_POST['name'] . "' WHERE `id` = " . $_POST['category-id'];
                //echo $mysqli;
                $result = $mysqli->query($query);

                if ($result) {
                    header("Location: ". $config['adminPath'] ."/categories?status=success");
                } else {
                    header("Location: /admin/categories?status=error");
                }
            } else {
                header("Location: /admin/categories?status=allready");
            }

            break;
         case 'service':
            if (allreadyService($_POST['name'])) {
                $query = "UPDATE `services` SET `name`='". $_POST['name'] . "' WHERE `id` = " . $_POST['service-id'];
                //echo $mysqli;
                $result = $mysqli->query($query);

                if ($result) {
                    header("Location: ". $config['adminPath'] ."/categories?status=success");
                } else {
                    header("Location: /admin/categories?status=error");
                }
            } else {
                header("Location: /admin/categories?status=allready");
            }

            break;

        default:
            # code...
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