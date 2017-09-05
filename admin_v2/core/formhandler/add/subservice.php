<?php
    include '../../../core/config.php';
    include '../../../../core/dbconnect.php';


    $back = getenv("HTTP_REFERER");

    if ($_POST['name'] != '') {
        $name = $_POST['name'];
        $publish = $_POST['publish'] == 'on' ? 1 : 0;
        $price = $_POST['price'];
        $time = $_POST['time'];

        if (!checkRes($name)) {

            $query = "INSERT INTO `subservices`(`name`, `price_for_unit`, `minute_for_unit`, `publish`) VALUES ('". $name ."','". $price ."','". $time ."',". $publish .")";
            $result = $mysqli->query($query);

            $subservId = $mysqli->insert_id;

            if (count($_POST['services']) > 0) {

                foreach ($_POST['services'] as $key => $value) {
                    $queryArr[] = "('" . $value . "','" . $subservId . "')";
                }

                $queryServVsSubserv = "INSERT INTO `serv_vs_subserv` ( `serv_id`, `subserv_id` ) VALUES " . implode(",", $queryArr);
                $result = $mysqli->query($queryServVsSubserv);
            }

            if (count($_POST['materials']) > 0) {

                foreach ($_POST['materials'] as $key => $value) {
                    $queryArr[] = "('" . $subservId . "','" . $value . "')";
                }

                $querySubservVsMat = "INSERT INTO `subserv_vs_materials` ( `subserv_id`, `material_id` ) VALUES " . implode(",", $queryArr);
                $result = $mysqli->query($querySubservVsMat);
            }

            if ($result) {
                header("Location: " . $links['subservice'] . "?status=success" );
            }
        } else {
            header("Location: " . $back . "?already=true&name=" . $name);
        }
    } else {
        header("Location: " . $back . "?error=true" );
    }


    function checkRes($name) {
        global $mysqli;

        $query = "SELECT * FROM subservices WHERE name = '" . $name . "'";
        $result = $mysqli->query($query);


        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }


?>