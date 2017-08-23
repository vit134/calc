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

    $func = new globalClass();

    echo '<pre>';
    var_dump($func->getUserAccess(1));
    echo '</pre>';
?>