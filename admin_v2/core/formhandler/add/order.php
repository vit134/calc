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

    function getTotalPrice() {
        $totalWork = 0;
        $totalMaterials = 0;

        foreach ($_POST['service'] as $key => $value) {

        }
    }

    $insertQuery = "INSERT INTO `orders`(
        `id`,
        `client_id`,
        `manager_id`,
        `price_total`,
        `time_total`,
        `status`,
        `date_create`,
        `date_edit`
    ) VALUES (
        [value-1],
        [value-2],
        [value-3],
        [value-4],
        [value-5],
        [value-6],
        [value-7],
        [value-8]
    )";

    echo '<pre>';
    var_dump($_POST);
    echo '</pre>';



?>