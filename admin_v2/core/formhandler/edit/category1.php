<?php
    include '../../../core/config.php';
    include '../../../core/functions.php';
    include '../../../../core/dbconnect.php';

    $func = new globalClass();

    $already = $func->getOneCategoryWithSub($_POST['id'])['services'];
    $new = $_POST['services'];

    $name = $_POST['name'];
    $puplish = $_POST['publish'] == 'on' ? 1 : 0;

    $newAlready = [];
    $newNew = [];
    $queryArr = [];
    $arr = [];



    if ($already != Null) {
        foreach ($already as $key => $value) {
            $newAlready[$value['id']] = $value['id'];
        }
    } else {
        $newAlready = [];
    }

    if (count($new) > 0) {
        foreach ($new as $key => $value) {
            $newNew[$value] = $value;
        }


        foreach ($newNew as $key => $value) {
            $is = array_search($value, $newAlready);

            if (!$is) {
                $arr['new'][] = $value;
            }
        }
    }

    foreach ($newAlready as $key => $value) {
        $is = array_search($value, $newNew);

        if (!$is) {
            $arr['deleted'][] = $value;
        } else {
            unset($newAlready[$key]);
        }
    }

    if ($arr['deleted']) {
        foreach ($arr['deleted'] as $key => $value) {
            $query = "DELETE FROM `cat_vs_service` WHERE `cat_id` =". $_POST['id'] ." AND `serv_id` = " . $value;
            $result = $mysqli->query($query);

        }
    }

    /*echo '<pre>';
    var_dump($arr);
    echo '</pre>';*/

    if ($arr['new']) {
        foreach ($arr['new'] as $key => $value) {
            $queryArr[] = "(" . $_POST['id'] . "," . $value . ")";
        }
    }

    $query = "INSERT INTO `cat_vs_service`(`cat_id`, `serv_id`) VALUES " . implode(",", $queryArr);
    $result = $mysqli->query($query);

    $sumQuery = "UPDATE `categories` SET `name`='". $name ."',`publish`='". $puplish ."',`description`='' WHERE id = " . $_POST['id'];
    $sumResult = $mysqli->query($sumQuery);

    if ($sumResult) {
        header("Location: " . $links['category'] . "?status=success" );
    }

    /*echo '<pre>';
    var_dump($arr);
    echo '</pre>';*/
?>