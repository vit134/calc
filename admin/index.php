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
        'links' => $links,
        'data' => $all,
        'dataLength' => getLength(),
        'categories' => getAllCategories(),
        'services' => getServices(),
        'subservices' => getSubServices(),
    );

    /*echo '<pre>';
    var_dump(getServiceWithAddiction(2));
    echo '</pre>';*/

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

        $data['category'] = getFullCategories($route[2]);
        echo $twig->render('pages/category.html', $data);

    } else if ($route[1] == 'service') {

        /*$data['service'] = getService($route[2]);
        $data['service']['subservice'] = getSubService($route[2]);*/

        $data['service'] = getServiceWithAddiction($route[2]);
        echo $twig->render('pages/service.html', $data);

    } else if ($route[1] == 'services') {

        if ($route[2] == 'edit') {
            $servId = $route['params']['id'];

            $data['edit_serv'] = getService($servId);
            echo $twig->render('pages/edit/service.html', $data);
        } else {
            $data['allService'] = getServiceWithAddiction();
            echo $twig->render('pages/services.html', $data);
        }

    } else if ($route[1] == 'subservices') {

        $data['subservice'] =  getAllSubService();
        echo $twig->render('pages/subservices.html', $data);

    } else if ($route[1] == 'subservice') {

        $data['subservice'] =  array(
            getSubServiceById($route[2]),
            'materials' => getMaterialsBySsId($route[2])
        );
        echo $twig->render('pages/subservice.html', $data);

    } else if ($route[1] == 'add') {

        echo $twig->render('pages/add/'. $route[2] .'.html', $data);

    } else if ($route[1] == 'search') {
        $searchResult = search($route['params']['query']);

        foreach ($searchResult as $key => $value) {
            /*$searchResult[synonym($key)] = $searchResult[$key];
            unset($searchResult[$key]);*/
            $searchResult[$key]['synonym'] = synonym($key);
        }

        $data['search'] = $searchResult;
        echo $twig->render('pages/search.html', $data);

    } else if ($route[1] == 'test') {


        $data['test'] = getServiceWithAddiction(2);
        echo $twig->render('pages/test.html', $data);

    }else {

        echo $twig->render('pages/404.html', $data);

    }
?>