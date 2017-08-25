<?php
    include '../../../core/config.php';
    include '../../../core/functions.php';
    include '../../../../core/dbconnect.php';

    $func = new globalClass();

    $already = $func->getOneCategoryWithSub($_POST['id'])['services'];
    $new = $_POST['services'];

    $newAlready = [];
    $newNew = [];
    $arr = [];

    foreach ($already as $key => $value) {
        $newAlready[$value['id']] = $value['id'];
    }

    if (count($new) > 0) {
        foreach ($new as $key => $value) {
            $newNew[$value] = $value;
        }


        foreach ($newNew as $key => $value) {
            $is = array_search($value, $newAlready);

            if (!$is) {
                $arr['new'] = $value;
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

        $res = 0;
        foreach ($arr['deleted'] as $key => $value) {
            $query = "DELETE FROM `cat_vs_service` WHERE `cat_id` =". $_POST['id'] ." AND `serv_id` = " . $value;
            $result = $mysqli->query($query);
            if ($result) {
                ++$res;
            }
        }
        $queryArr = [];

        foreach ($arr['new'] as $key => $value) {
            $queryArr[] = "(" . $_POST['id'] . "," . $value . ")";
        }


        if (count($res) == count($arr['deleted'])) {
            $query = "INSERT INTO `cat_vs_service`(`cat_id`, `serv_id`) VALUES " . implode(",", $queryArr);
            $result = $mysqli->query($query);
        }



    }

    echo '<pre>';
    var_dump($arr);
    echo '</pre>';
?>