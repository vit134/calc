<?php
    session_start();
    include 'core/config.php';
    include '../core/dbconnect.php';
    include 'core/functions.php';

    require_once '../vendor/autoload.php';
    $func = new globalClass();

    $loader = new Twig_Loader_Filesystem('tmp');

    $twig = new Twig_Environment($loader, array(
        'debug' => true
    ));

    $twig->addExtension(new Twig_Extension_Debug());

    $route = $func->route();

    $login = false;

    if ($_SESSION['user_id'] != '') {
        $login = $_SESSION['user_id'];
    }


    $data = array(
        'route' => $route,
        'config' => $config,
        'links' => $links,
        'user_id' => $login,
        'settings' => $func->getSettings()
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
                        if ($route[3] == '') {
                            $data['all_services'] = $func->getAllServicesWithSub();
                            echo $twig->render('pages/'. $route[1]. '/service.html', $data);
                        } else {
                            $data['one_service'] = $func->getOneServiceWithSub($route[3]);
                            echo $twig->render('pages/'. $route[1]. '/one-service.html', $data);
                        }
                        break;
                    case 'subservice':
                        $data['all_subservices'] = $func->getAllSubServicesWithSub();
                        echo $twig->render('pages/'. $route[1]. '/subservice.html', $data);
                        break;
                    case 'material':
                        $data['all_materials'] = $func->getAllMaterialsWithSub();
                        echo $twig->render('pages/'. $route[1]. '/material.html', $data);
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
                    case 'material':
                        $data['all_subservices'] = $func->getAllSubServices();
                        $data['all_materials'] = $func->getAllMaterials();
                        echo $twig->render('pages/'. $route[1]. '/material.html', $data);
                        break;
                    case 'user':
                        $data['avatar'] = $func->getAvatar();
                        $data['group'] = $func->getAllgroup();
                        echo $twig->render('pages/'. $route[1]. '/user.html', $data);
                        break;
                    case 'order':
                        $data['all_services'] = $func->getAllServiceWithPrice();
                        $data['managers'] = $func->getSalesManager();
                        $data['clients'] = $func->getAllClients();
                        echo $twig->render('pages/'. $route[1]. '/order.html', $data);
                        break;
                    case 'brigade':
                        $data['all_workers'] = $func->getAllWorkers();
                        echo $twig->render('pages/'. $route[1]. '/brigade.html', $data);
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
                        $data['diff'] = $func->compareAlreadyServices($route[3]);
                        echo $twig->render('pages/'. $route[1]. '/category.html', $data);
                        break;
                    case 'service':
                        $data['one_service'] = $func->getOneServiceWithSub($route[3]);
                        $data['diff_cat'] = $func->compareAlreadyCategories($route[3]);
                        $data['diff_subserv'] = $func->compareAlreadySubservices($route[3]);

                        echo $twig->render('pages/'. $route[1]. '/service.html', $data);
                        break;
                    case 'subservice':
                        $data['one_subservice'] = $func->getOneSubServiceWithSub($route[3]);
                        $data['diff'] = $func->compareAlreadyMaterials($route[3]);
                        echo $twig->render('pages/'. $route[1]. '/subservice.html', $data);
                        break;
                    case 'material':
                        $data['one_material'] = $func->getOnematerial($route[3]);
                        echo $twig->render('pages/'. $route[1]. '/material.html', $data);
                        break;
                    case 'user':
                        $data['user'] = $func->getUserInfo($route[3]);
                        $data['user']['group'] = $func->getUserGroup($route[3]);
                        $data['diff'] = $func->compareAlreadyGroup($route[3]);
                        $data['avatar'] = $func->getAvatar();
                        echo $twig->render('pages/'. $route[1]. '/user.html', $data);
                        break;
                    case 'order':
                        $data['all_services'] = $func->getAllServiceWithPrice();
                        $data['managers'] = $func->getSalesManager();
                        $data['clients'] = $func->getAllClients();
                        $data['order'] = $func->getOneOrders($route[3]);
                        $data['diff'] = $func->compareAlreadyServiceInOrder($route[3]);
                        $data['statuses'] = $func->getStatuses();
                        echo $twig->render('pages/'. $route[1]. '/order.html', $data);
                        break;
                    default:
                        echo $twig->render('pages/404.html', $data);
                };
                break;
            case 'user':
                if ($route[2] == 'lk') {
                    //$data['user'] = $func->getOneSubServiceWithSub($login);
                    if ($route[3] == '') {
                        $data['user'] = $func->getUserInfo($login);
                        $data['user']['group'] = $func->getUserGroup($login);
                        echo $twig->render('pages/user/lk.html', $data);
                    } else {
                        $data['user'] = $func->getUserInfo($route[3]);
                        $data['user']['group'] = $func->getUserGroup($route[3]);
                        echo $twig->render('pages/user/lk.html', $data);
                    }
                } else {
                    $data['all_users'] = $func->getAllUsers();
                    echo $twig->render('pages/user/users.html', $data);
                }
                break;
            case 'order':
                if ($route[2] == '') {
                    $data['all_orders'] = $func->getAllOrders();
                    $data['managers'] = $func->getSalesManager();
                    $data['clients'] = $func->getAllClients();
                    $data['statuses'] = $func->getStatuses();
                    echo $twig->render('pages/order/orders.html', $data);
                } else {

                    $data['preview'] = $func->getOneOrders($route[2]);
                    echo $twig->render('pages/order/one-order.html', $data);
                }
                break;
            case 'brigade':
                if ($route[2] == '') {
                    $data['all_brigade'] = $func->getAllBrigade();

                    echo $twig->render('pages/brigade/all.html', $data);
                } else {

                    $data['preview'] = $func->getOneOrders($route[2]);
                    echo $twig->render('pages/order/one-order.html', $data);
                }
                break;
            case 'create_pass':
                if ($route[3] == '') {
                    $data['all_users'] = $func->getAllUsers();
                    echo $twig->render('pages/create_pass.html', $data);
                } else {
                    $data['user'] = $func->getOneSubServiceWithSub(39);
                    echo $twig->render('pages/test.html', $data);
                }
                break;

            case 'test':

                $data = $func->getOneOrders(14);

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
    } else  {
        switch ($route[1]) {
            case 'forgot_pass':
                echo $twig->render('pages/forgot_pass.html', $data);
                break;
            default:
                echo $twig->render('pages/login.html', $data);
        }

    }
?>