<?php
    include '../../../core/config.php';
    include '../../../core/functions.php';
    include '../../../../core/dbconnect.php';

    $func = new globalClass();

    $back = getenv("HTTP_REFERER");

    $response = array(
        'status' => 'success'
    );

    $userId = $_POST['id'];

    $date = new DateTime($_POST['birth_date']);
    $birth_date = $date->format("Y-m-d H:i:s");

    $dateBirth_date = new DateTime($birth_date);
    $now = new DateTime();

    $interval = $dateBirth_date->diff($now);

    $updateArr = [];

    if ($_POST['old_pass'] != '') {
        $checkPassQuery = "SELECT pass FROM users WHERE id = " . $_POST['id'];
        $checkPassResult = $mysqli->query($checkPassQuery);

        if ($checkPassResult) {
            $passFromDB = $checkPassResult->fetch_array(MYSQLI_NUM)[0];


            if ($passFromDB == md5($_POST['old_pass'])) {
                if ($_POST['new_pass'] == $_POST['rep_pass']) {
                    $updateArr[] = "`pass`='" . md5($_POST['new_pass']) . "'";
               } else {
                    $response['status'] = 'error';
                    $response['message'] = 'not_confirm_pass';
               }
           } else {

                $response['status'] = 'error';
                $response['message'] = 'wrong_old_pass';
           }
       } else {
            echo 'checkPassQuery' . $checkPassQuery;
       }
   }

    if ($_POST['avatar'] != '') {
        $updateArr[] = "`avatar`='" . $_POST['avatar'] . "'";
    }

    $bd = date('Y-m-d H:i:s' ,strtotime($_POST['birth_date']));

    $updateQuery = "UPDATE `users` SET
                        `first_name`='{$_POST['first_name']}',
                        `second_name`='{$_POST['second_name']}',
                        `last_name`='{$_POST['last_name']}',
                        `birth_date`={$bd},
                        `years_old`={$interval->format('%y')},
                        `phone`={$_POST['phone']},
                        `email`='{$_POST['email']}', " . implode(',', $updateArr) . "
                    WHERE id = " . $userId;


    $result = $mysqli->query($updateQuery);

    if ($result) {
        header("Location: " . $links['user'] . http_build_query($response) );
   } else {
        echo $updateQuery;
   }



    echo '<pre>';
    var_dump($_POST);
    echo '</pre>';


    echo '-------' . '<br>';
    echo implode(',', $updateArr) . '<br>';
    echo http_build_query($response) . '<br>';
    echo '-------' . '<br>';

    /*$updateQuery = "UPDATE `users` SET
                        `id`=[value-1],
                        `first_name`=[value-2],
                        `second_name`=[value-3],
                        `last_name`=[value-4],
                        `birth_date`=[value-5],
                        `years_old`=[value-6],
                        `login`=[value-7],
                        `pass`=[value-8],
                        `phone`=[value-9],
                        `email`=[value-10],
                        `avatar`=[value-11],
                        `active`=[value-12],
                        `last_login`=[value-13]
                    WHERE 1"*/

?>