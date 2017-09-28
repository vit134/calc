<?php
    session_start();
    include '../../core/config.php';
    include '../../../core/dbconnect.php';
    include '../../core/functions.php';
    require_once '../../../vendor/autoload.php';

    $func = new globalClass();

    $loader = new Twig_Loader_Filesystem('../../tmp');

    $twig = new Twig_Environment($loader, array(
        'debug' => true
    ));

    $twig->addExtension(new Twig_Extension_Debug());

    $paramsArr = $_GET;
    $paramsArrResult = [];

    foreach ($paramsArr as $key => $value) {

        if ($key == 'start' || $key == 'end') {

            if ($key == 'start' && $value != '') {
                $date_start = date('Y-m-d H:i:s', strtotime($value . " 23:59:59"));
                $paramsArrResult[] = "date_create >= '" . $date_start . "'";
            }

            if ($key == 'end' && $value != '') {
                $date_end = date('Y-m-d H:i:s', strtotime($value . " 23:59:59"));
                $paramsArrResult[] = "date_create <= '" . $date_end . "'";
            }
        } else if ($value != 0) {
            $paramsArrResult[] = "`" . $key . "` = '" . $value . "'";
        }
    }

    $params =  implode(' and ', $paramsArrResult);

    $login = $_SESSION['user_id'];

    $data = array(
        'access' => $func->getUserAccess($login),
        'user_info' => $func->getUserInfo($login),
        'all_orders' => $func->getAllOrdersFilter($params),
        'user_id' => $login,
        'route' => $func->route(),
        'config' => $config,
        'links' => $links,
        'user_id' => $login,
        'settings' => $func->getSettings()
    );

    $html = $twig->render('blocks/order/table-row/main.html', $data);

    echo json_encode(array('html' => $html, 'params' => $params));


    //WHERE `date` BETWEEN '2010-06-01' AND '2010-06-30'
?>