<?php
    include '../../../core/config.php';
    include '../../../../core/dbconnect.php';


    $back = getenv("HTTP_REFERER");

    if ($_POST['name'] != '') {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $publish = $_POST['publish'] == 'on' ? 1 : 0;

        /*if ($publish) {
            $publish = 1;
        }*/

        if (!checkRes($name)) {
            $query = "INSERT INTO `services`(`name`, `publish`,`price`) VALUES ('". $name ."','". $publish ."','". $price ."')";
            $result = $mysqli->query($query);

            $serviceId = $mysqli->insert_id;

            if (count($_POST['categories']) != 0 ) {

                foreach ($_POST['categories'] as $key => $value) {
                    $queryArr[] = "('" . $serviceId . "','" . $value . "')";
                }

                $queryCatVsS = "INSERT INTO `cat_vs_service` ( `serv_id`, `cat_id` ) VALUES " . implode(",", $queryArr);
                $result = $mysqli->query($queryCatVsS);
            }

            if (count($_POST['subservices']) != 0 ) {

                foreach ($_POST['subservices'] as $key => $value) {
                    $queryArr[] = "('" . $serviceId . "','" . $value . "')";
                }

                $queryCatVsS = "INSERT INTO `serv_vs_subserv` ( `serv_id`, `subserv_id` ) VALUES " . implode(",", $queryArr);
                $result = $mysqli->query($queryCatVsS);
            }

            if ($result) {
                header("Location: " . $links['service'] . "?status=success" );
            }
        } else {
            header("Location: " . $back . "?already=true&name=" . $name);
        }
    } else {
        header("Location: " . $back . "?error=true" );
    }


    function checkRes($name) {
        global $mysqli;

        $query = "SELECT * FROM services WHERE name = '" . $name . "'";
        $result = $mysqli->query($query);


        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }


?>