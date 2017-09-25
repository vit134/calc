<?php

    include '../../../core/config.php';
    include '../../../../core/dbconnect.php';
    include '../../../core/functions.php';

    require_once '../../../../vendor/autoload.php';

    $func = new globalClass();

    $loader = new Twig_Loader_Filesystem('../../../tmp');
    $twig = new Twig_Environment($loader, array(
        'debug' => true
    ));

    $twig->addExtension(new Twig_Extension_Debug());

    $back = getenv("HTTP_REFERER");


    if ($_GET['preview']) {
        $data = array(
            'preview' => array(
                'order_num' => getLastOrderId() + 1,
                'date_create' => array(
                        'd' => date('d'),
                        'm' => date('M'),
                        'y' => date('Y')
                    ),
                'client' => $func->getOneClient($_POST['client']),
                'object_info' => array(
                        'type' => $_POST['object_type'],
                        'square' => $_POST['meters'],
                        'adress' => $_POST['adress']
                    ),
                'resourses' => $func->getServiceInOrderInfo($_POST['service'], $_POST['meters'])
            ),
            'settings' => $func->getSettings()
        );

        $html = $twig->render('blocks/preview/main.html', $data);

        $resp = array('data' => $data, 'html' => $html);

        echo json_encode($resp);

    } else {

        //echo json_encode(getTotalPrice());
        /*echo '<pre>';
        var_dump($_POST);
        echo '</pre>';*/

        $resourses = $func->getServiceInOrderInfo($_POST['service'], $_POST['meters']);

        $workPrice = $resourses['services']['price_total'];
        $materialPrice = $resourses['materials']['price_total'];

        $withoutMaterials = $_POST['without_materials'] == 'on' ? 1 : 0;

        $orderQuery = "INSERT INTO `orders`(
            `client_id`,
            `manager_id`,
            `obj_type`,
            `obj_adress`,
            `count_of_meters`,
            `work_price`,
            `material_price`,
            `status`,
            `date_create`,
            `date_edit`,
            `without_materials`
        ) VALUES (
            '" . $_POST['client'] . "',
            '" . $_POST['manager'] . "',
            '" . $_POST['object_type'] . "',
            '" . $_POST['adress'] . "',
            '" . $_POST['meters'] . "',
            '" . $workPrice . "',
            '" . $materialPrice . "',
            '" . 1 . "',
            NOW(),
            NOW(),
            " . $withoutMaterials . "
        )";

        $insertResult = $mysqli->query($orderQuery);

        $orderID = $mysqli->insert_id;

        $userVsOrdersQuery = "INSERT INTO `users_vs_orders`(
            `user_id`,
            `order_id`
        ) VALUES (
            '" . $_POST['manager'] . "',
            '" . $orderID . "'
        )";

        $uvoResult = $mysqli->query($userVsOrdersQuery);

        $clientVsordersQuery = "INSERT INTO `clients_vs_orders`(
            `client_id`,
            `order_id`
        ) VALUES (
            '" . $_POST['client'] . "',
            '" . $orderID . "'
        )";

        $cvoResult = $mysqli->query($clientVsordersQuery);

        $insertOVSArr = [];

        foreach ($_POST['service'] as $key => $value) {
            $insertOVSArr[] = "('" . $orderID . "','"  . $value . "')";
        }

        $orderVsServiceQuery = "INSERT INTO `orders_vs_service`(
            `order_id`,
            `service_id`
        ) VALUES " . implode(',', $insertOVSArr);


        $ovsResult = $mysqli->query($orderVsServiceQuery);

        if ($insertResult && $userVsOrdersQuery && $cvoResult && $ovsResult) {
            header("Location: " . $links['order'] . "?status=success" );
        } else {
            echo $mysqli->error;
        }


    }

    function getServices() {
        global $func;
        $arr = [];

        foreach ($_POST['service'] as $key => $value) {
            $arr[] = $func->getOneServiceWithPrice($value);
        }

        return $arr;
    }

    function getTotalPrice() {
        global $func;

        $totalWork = 0;
        $totalMaterials = 0;
        $totalTime = 0;

        foreach ($_POST['service'] as $key => $value) {
            $priceArr = $func->getOneServiceWithPrice($value);
            $totalWork = $totalWork + $priceArr['work'];
            $totalMaterials = $totalMaterials + $priceArr['material'];
            $totalTime = $totalTime + $priceArr['time'];
        }

        return array('total_work' => $totalWork, 'total_material' => $totalMaterials, 'total_time' => $totalTime);
    }

    function getLastOrderId() {
        global $mysqli;

        $query = "SELECT max(`id`) from `orders`";

        $result = $mysqli->query($query);

        if ($result) {
            return $result->fetch_array(MYSQLI_NUM)[0];
        }
    }

?>