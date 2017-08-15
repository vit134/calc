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
        'config' => $config,
        'data' => $all,
        'dataLength' => getLength()
    );

    if ($route[1] == '') {

        echo $twig->render('pages/index.html', $data);

    } else if ($route[1] == 'categories') {

        if ($route[2] == 'edit') {
            $catId = $route['params']['id'];

            $data['edit_cat'] = getCategory($catId);
            echo $twig->render('pages/edit/category.html', $data);
        } else {
            $data['category'] = getAllCategories();
            echo $twig->render('pages/categories.html', $data);
        }



    } else if ($route[1] == 'category') {

        //$data['category'] = getCategory($route[2]);
        $data['category'] = getFullCategories($route[2]);
        echo $twig->render('pages/category.html', $data);

    } else if ($route[1] == 'service') {
        $data['service'] = getService($route[2]);
        $data['service']['subservice'] = getSubService($route[2]);

        echo $twig->render('pages/service.html', $data);

    } else if ($route[1] == 'services') {

        $data['allService'] = getAllService();
        echo $twig->render('pages/services.html', $data);

    } else if ($route[1] == 'subservices') {
        $data['subservice'] =  getAllSubService();
        echo $twig->render('pages/subservices.html', $data);

    } else if ($route[1] == 'add') {

        echo $twig->render('pages/add/'. $route[2] .'.html', $data);

    }
?>