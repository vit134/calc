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

?>