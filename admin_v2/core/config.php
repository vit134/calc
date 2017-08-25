<?php
    define('SITE_PATH', realpath(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR);

    $adminPath = '/admin_v2';

    $config = array(
        'adminPath' => $adminPath,
        'addCatgoryLink' => $adminPath . '/add/category',
        'addServiceLink' => $adminPath. '/add/service',
        'addSubserviceLink' => $adminPath . '/add/subservice',
        'addMaterialLink' => $adminPath . '/add/material',
        'assetsPath' => $adminPath . '/assets/',
        'corePath' => $adminPath . '/core/',
        'formhandlerPath' => $adminPath . '/core/formhandler/'
    );

    $links = array(
        'category' => $adminPath . '/resourses/category/',
        'service' => $adminPath . '/resourses/service/',
        'subservice' => $adminPath . '/resourses/subservice/',
        'material' => $adminPath . '/resourses/material/',
        'editCategory' => $adminPath . '/edit/category/',
        'services' => $adminPath . 'services/',
        'subservices' => $adminPath . 'subservices/',
        'materials' => $adminPath . 'materials/'
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

?>