<?php
    include '../../../core/config.php';
    include '../../../../core/dbconnect.php';


    $back = getenv("HTTP_REFERER");

    if ($_POST['name'] != '') {
        $name = $_POST['name'];
        $publish = $_POST['publish'];

        if ($publish) {
            $publish = 1;
        }

        if (!checkRes($name)) {
            $query = "INSERT INTO `categories`(`name`, `publish`) VALUES ('". $name ."','". $publish ."')";
            $result = $mysqli->query($query);

            if (count($_POST['services']) != 0 ) {

                foreach ($_POST['services'] as $key => $value) {
                    $queryArr[] = "('" . $mysqli->insert_id . "','" . $value . "')";
                }

                $queryCatVsS = "INSERT INTO `cat_vs_service`(`cat_id`, `serv_id`) VALUES " . implode(",", $queryArr);
                $result = $mysqli->query($queryCatVsS);
            }

            if ($result) {
                header("Location: " . $links['category'] . "?status=success" );
            }
        } else {
            header("Location: " . $back . "?already=true&name=" . $name);
        }
    } else {
        header("Location: " . $back . "?error=true" );
    }


    function checkRes($name) {
        global $mysqli;

        $query = "SELECT * FROM categories WHERE name = '" . $name . "'";
        $result = $mysqli->query($query);


        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }


?>