<?php

    $config = array(
        'adminPath' => '/admin',
        'addCatgoryLink' => '/admin/add/category',
        'addServiceLink' => '/admin/add/service',
        'addSubserviceLink' => '/admin/add/subservice',
        'addMaterialLink' => '/admin/add/material',
        'assetsPath' => '/admin/assets/'
    );

    $links = array(
        'category' => $congig['adminPath'] . '/category/',
        'service' => $congig['adminPath'] . 'service/',
        'subservice' => $congig['adminPath'] . 'subservice/',
        'material' => $congig['adminPath'] . 'material/',
        'categories' => $congig['adminPath'] . 'categories/',
        'services' => $congig['adminPath'] . 'services/',
        'subservices' => $congig['adminPath'] . 'subservices/',
        'materials' => $congig['adminPath'] . 'materials/'
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