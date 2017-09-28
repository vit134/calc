<?php
    include '../../../core/config.php';
    include '../../../core/functions.php';
    include '../../../../core/dbconnect.php';

    $func = new globalClass();

    $back = getenv("HTTP_REFERER");

    $response = array(
        'status' => 'success'
    );

    //var_dump($_POST);

    $resourses = $func->getServiceInOrderInfo($_POST['service'], $_POST['meters']);

    $workPrice = $resourses['services']['price_total'];
    $materialPrice = $resourses['materials']['price_total'];

    $withoutMaterials = $_POST['without_materials'] == 'on' ? 1 : 0;

    $updateOrderQuery = "UPDATE `orders` SET
        `client_id`='". $_POST['client'] ."',
        `manager_id`='". $_POST['manager'] ."',
        `obj_type`='" . $_POST['object_type'] . "',
        `obj_adress`='" . $_POST['adress'] . "',
        `count_of_meters`='" . $_POST['meters'] . "',
        `work_price`='" . $workPrice . "',
        `material_price`='" . $materialPrice . "',
        `without_materials`=" . $withoutMaterials . ",
        `status`=" . $_POST['status'] . ",
        `date_edit`=NOW()
    WHERE id = " . $_POST['id'];
    if (!$updateOrdeResult = $mysqli->query($updateOrderQuery)) {
        $response['status'] = 'error';
        $response['query']['updateOrder'] = array(
            'message' => $mysqli->error,
            'query' => $updateOrderQuery
        );
    }

    $deleteServiceQuery = "DELETE FROM `orders_vs_service` WHERE order_id = " . $_POST['id'];
    if (!$deleteServiceResult =  $mysqli->query($deleteServiceQuery)) {
        $response['status'] = 'error';
        $response['query']['deleteServic'] = array(
            'message' => $mysqli->error,
            'query' => $deleteServiceQuery
        );
    }

    $insertOVSArr = [];

    foreach ($_POST['service'] as $key => $value) {
        $insertOVSArr[] = "('" . $_POST['id'] . "','"  . $value . "')";
    }

    $orderVsServiceQuery = "INSERT INTO `orders_vs_service`(
        `order_id`,
        `service_id`
    ) VALUES " . implode(',', $insertOVSArr);
    if (!$ovsResult = $mysqli->query($orderVsServiceQuery)) {
        $response['status'] = 'error';
        $response['query']['orderVsServic'] = array(
            'message' => $mysqli->error,
            'query' => $orderVsServiceQuery
        );
    }

    $updateClientQuery = "UPDATE `clients_vs_orders` SET
        `client_id`='". $_POST['client'] ."'
    WHERE order_id = " . $_POST['id'];
    if (!$updateClientResult = $mysqli->query($updateClientQuery)) {
        $response['status'] = 'error';
        $response['query']['updateClien'] = array(
            'message' => $mysqli->error,
            'query' => $updateClientQuery
        );
    }

    $updateUserQuery = "UPDATE `users_vs_orders` SET
        `user_id`='". $_POST['manager'] ."'
    WHERE order_id = " . $_POST['id'];
    if (!$updateClientResult = $mysqli->query($updateUserQuery)) {
        $response['status'] = 'error';
        $response['query']['updateUse'] = array(
            'message' => $mysqli->error,
            'query' => $updateUserQuery
        );
    }

    if ($response['status'] == 'success') {
        header("Location: " . $links['order'] . "/" . $_POST['id'] );
    } else {
        echo json_encode($response);
    }

?>