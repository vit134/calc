<?php
    session_start();
    include 'core/config.php';
    include '../core/dbconnect.php';
    include 'core/functions.php';

    require_once '../vendor/autoload.php';

    $loader = new Twig_Loader_Filesystem('tmp');
    $twig = new Twig_Environment($loader, array(
        'debug' => true
    ));

    $twig->addExtension(new Twig_Extension_Debug());

    $func = new globalClass();

    $route = $func->route();

    $login = false;

    if ($_SESSION['user_id'] != '') {
        $login = $_SESSION['user_id'];
    }


    $data = array(
        'route' => $route,
        'config' => $config,
        'links' => $links,
        'user_id' => $login
    );

    if ($login) {
        $data['access'] = $func->getUserAccess($login);
        $data['user_info'] = $func->getUserInfo($login);

        /*echo '<pre>';
        var_dump($func->getUserInfo($login));
        echo '</pre>';*/

        switch ($route[1]) {
            case '':
                echo $twig->render('pages/index.html', $data);
                break;
            case 'resourses':
                switch ($route[2]) {
                    case 'category':
                        if ($route[3] == '') {
                            $data['all_categories'] = $func->getAllCategoriesWithSub();
                            echo $twig->render('pages/'. $route[1]. '/category.html', $data);
                        } else {
                            $data['one_category'] = $func->getOneCategoryWithSub($route[3]);
                            echo $twig->render('pages/'. $route[1]. '/one-category.html', $data);
                        }
                        break;
                    case 'service':
                        echo $twig->render('pages/'. $route[1]. '/service.html', $data);
                        break;
                    case 'subservice':
                        echo $twig->render('pages/'. $route[1]. '/subservice.html', $data);
                        break;
                    default:
                        echo $twig->render('pages/404.html', $data);
                };
                break;
            case 'add':
                switch ($route[2]) {
                    case 'category':
                        $data['all_services'] = $func->getAllServices();
                        echo $twig->render('pages/'. $route[1]. '/category.html', $data);
                        break;
                    case 'service':
                        $data['all_categories'] = $func->getAllCategories();
                        $data['all_subservices'] = $func->getAllSubServices();
                        echo $twig->render('pages/'. $route[1]. '/service.html', $data);
                        break;
                    case 'subservice':
                        $data['all_services'] = $func->getAllServices();
                        $data['all_materials'] = $func->getAllMaterials();
                        echo $twig->render('pages/'. $route[1]. '/subservice.html', $data);
                        break;
                    default:
                        echo $twig->render('pages/404.html', $data);
                };
                break;
            case 'edit':
                switch ($route[2]) {
                    case 'category':
                        $data['all_services'] = $func->getAllServices();
                        $data['one_category'] = $func->getOneCategoryWithSub($route[3]);
                        $data['diff'] = $func->compareAllreadyServices($route[3]);
                        echo $twig->render('pages/'. $route[1]. '/category.html', $data);
                        break;
                    case 'service':
                        $data['all_categories'] = $func->getAllCategories();
                        $data['all_subservices'] = $func->getAllSubServices();
                        echo $twig->render('pages/'. $route[1]. '/service.html', $data);
                        break;
                    case 'subservice':
                        echo $twig->render('pages/'. $route[1]. '/subservice.html', $data);
                        break;
                    default:
                        echo $twig->render('pages/404.html', $data);
                };
                break;
            case 'test':
                $data['test'] = $func->compareAllreadyServices(39);
                echo $twig->render('pages/test.html', $data);
                break;
            default:
                echo $twig->render('pages/404.html', $data);
        };

        /*if ( $route[1] == '' ) {
            echo $twig->render('pages/index.html', $data);
        } else if () {
            echo $twig->render('pages/404.html', $data);
        } else {
            echo $twig->render('pages/404.html', $data);
        }*/
    } else {
        echo $twig->render('pages/login.html', $data);
    }
?>