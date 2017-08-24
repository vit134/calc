<?php

    $adminPath = '/admin_v2';

    $config = array(
        'adminPath' => $adminPath,
        'addCatgoryLink' => $adminPath . '/add/category',
        'addServiceLink' => $adminPath. '/add/service',
        'addSubserviceLink' => $adminPath . '/add/subservice',
        'addMaterialLink' => $adminPath . '/add/material',
        'assetsPath' => $adminPath . '/assets/',
        'corePath' => $adminPath . '/core/'
    );

    $links = array(
        'category' => $adminPath . '/category/',
        'service' => $adminPath . 'service/',
        'subservice' => $adminPath . 'subservice/',
        'material' => $adminPath . 'material/',
        'categories' => $adminPath . 'categories/',
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