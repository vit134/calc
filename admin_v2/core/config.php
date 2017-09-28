<?php
    define('SITE_PATH', realpath(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR);
    setlocale(LC_TIME, 'ru_RU.UTF-8');

    $sitePath = 'http://calc/admin_v2/';

    $adminPath = '/admin_v2';

    $config = array(
        'adminPath' => $adminPath,
        'addCatgoryLink' => $adminPath . '/add/category',
        'addServiceLink' => $adminPath. '/add/service',
        'addSubserviceLink' => $adminPath . '/add/subservice',
        'addMaterialLink' => $adminPath . '/add/material',
        'assetsPath' => $adminPath . '/assets/',
        'corePath' => $adminPath . '/core/',
        'formhandlerPath' => $adminPath . '/core/formhandler/',
        'filterPath' => $adminPath . '/core/filter/'
    );

    $links = array(
        'category' => $adminPath . '/resourses/category/',
        'service' => $adminPath . '/resourses/service/',
        'subservice' => $adminPath . '/resourses/subservice/',
        'material' => $adminPath . '/resourses/material/',
        'editCategory' => $adminPath . '/edit/category/',
        'editService' => $adminPath . '/edit/service/',
        'editSubService' => $adminPath . '/edit/subservice/',
        'editMaterial' => $adminPath . '/edit/material/',
        'user' => $adminPath . '/user',
        'group' => $adminPath . '/group',
        'order' => $adminPath . '/order'
    );

    $searchConfig = array(
        'tables' => ['categories', 'services', 'subservices', 'materials']
    );

    $synonyms = array(
        'categories' => 'категории',
        'services' => 'услуги',
        'subservices' => 'виды работ',
        'materials' => 'материалы'
    );

    $uploadDir = "uploads/";

?>