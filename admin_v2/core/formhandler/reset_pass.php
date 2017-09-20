<?php

    include '../../core/config.php';
    include '../../../core/dbconnect.php';
    include '../../core/functions.php';

    require_once '../../../vendor/autoload.php';

    $func = new globalClass();
    $loader = new Twig_Loader_Filesystem('../../tmp');
    $twig = new Twig_Environment($loader, array(
        'debug' => true
    ));

    $twig->addExtension(new Twig_Extension_Debug());

    $back = getenv("HTTP_REFERER");

    //echo $_POST['login'];


    $query = "SELECT * FROM `users` WHERE login = '" . $_POST['login'] . "'";
    $result = $mysqli->query($query);

    if ($result) {
        if ($result->num_rows) {
            $forMail = $resArr = $result->fetch_assoc();
            $email = $resArr['email'];

            $forMail['tmpPass'] = $func->randomString();
            $forMail['link'] = $links['user'] . '/lk';

            $updateQuery = "UPDATE `users` SET `pass`='" . md5($forMail['tmpPass']) . "' WHERE id = " . $resArr['id'];

            if ($mysqli->query($updateQuery)) {
                $html = $twig->render('blocks/mail/reset_pass.html', $forMail);
                mail($email, 'My Subject', $html);
                header("Location: " . $config['adminPath']);
            } else {
                echo $updateQuery;
            }

        } else {
            echo 'такого логина не найдено';
        }
    } else {
        echo $mysqli->error;
    }
?>