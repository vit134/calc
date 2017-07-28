<?php
    include 'core/config.php';
    include '../core/dbconnect.php';
    include 'core/functions.php';

    require_once '../vendor/autoload.php';

    $loader = new Twig_Loader_Filesystem('tmp');
    $twig = new Twig_Environment($loader, array(
        'debug' => true
    ));

    $twig->addExtension(new Twig_Extension_Debug());

    $all = getAll();

    $route = route();

    $data = array(
        'route' => $route,
        'config' => array(
            'adminPath' => $adminPath
        ),
        'data' => $all
    );

    if ($route[1] == '') {

        echo $twig->render('pages/index.html', $data);

    } else if ($route[1] == 'categories') {

        $data['category'] = getCategory($route[2]);
        echo $twig->render('pages/categories.html', $data);

    } else if ($route[1] == 'services') {

        $data['service'] = getService($route[2]);
        $data['service']['subservice'] = getSubService($route[2]);



        echo $twig->render('pages/services.html', $data);

    }else if ($route[1] == 'subcategories') {

        echo $twig->render('pages/subcategories.html', $data);

    }
?>