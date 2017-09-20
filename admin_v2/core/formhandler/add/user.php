<?php

    include '../../../core/config.php';
    include '../../../../core/dbconnect.php';
    include '../../../core/functions.php';

    require_once '../../../../vendor/autoload.php';

    $func = new globalClass();

    $loader = new Twig_Loader_Filesystem('../../../tmp');
    $twig = new Twig_Environment($loader, array(
        'debug' => true
    ));

    $twig->addExtension(new Twig_Extension_Debug());

    $back = getenv("HTTP_REFERER");

    /*echo '<pre>';
    var_dump($_POST);
    echo '</pre>';*/

    $date = new DateTime($_POST['birth_date']);
    $birth_date = $date->format("Y-m-d H:i:s");
    $pass = md5($_POST['pass']);
    $publish = $_POST['publish'] == 'on' ? 1 : 0;
    $tmpPass = $func->randomString();

    $dateBirth_date = new DateTime($birth_date);
    $now = new DateTime();

    $interval = $dateBirth_date->diff($now);

    $insertQuery = "INSERT INTO `users`(
        `first_name`,
        `second_name`,
        `last_name`,
        `birth_date`,
        `years_old`,
        `login`,
        `phone`,
        `email`,
        `avatar`,
        `pass`
    ) VALUES (
        '". $_POST['first_name'] ."',
        '". $_POST['second_name'] ."',
        '". $_POST['last_name'] ."',
        '" . date('Y-m-d H:i:s' ,strtotime($_POST['birth_date'])) . "',
        " . $interval->format('%y') . ",
        '". $_POST['login'] ."',
        '". $_POST['phone'] ."',
        '". $_POST['email'] ."',
        '". $_POST['avatar'] ."',
        '". md5($tmpPass) ."'
    )";




    $resultInsert = $mysqli->query($insertQuery);

    if ($resultInsert) {
        $userid = $mysqli->insert_id;

        if (count($_POST['role']) != 0) {
            $roleArr = [];

            foreach ($_POST['role'] as $key => $value) {
                $roleArr[] = "('" . $userid . "','" . $value . "')";
            }

            $groupInsert = "INSERT INTO `users_vs_groups`(`user_id`, `group_id`) VALUES " . implode(',', $roleArr);
            $resultGroup = $mysqli->query($groupInsert);

            /*if (!$resultGroup) {
                header("Location: " . $back . "?status=error&message=no_group_insert" );
            } else {
                header("Location: " . $links['user'] . "?status=success" );
            }*/
        }

        $forMail = $_POST;
        $forMail['link'] = $sitePath . 'core/formhandler/activate_user.php?id=' . $userid . '&secret=' . md5($_POST['login'] . $_POST['email']);
        $forMail['tmpPass'] = $tmpPass;
        $forMail['login'] = $_POST['login'];

        $html = $twig->render('blocks/mail/activate_user.html', $forMail);
        mail($_POST['email'], 'My Subject', $html);

        header("Location: " . $links['user'] . "?status=success" );
    } else {
        echo $insertQuery;
        header("Location: " . $back . "?status=error&message=no_user_insert" );
    }

?>