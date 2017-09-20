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

    /*echo $_POST['old_pass'] . '<br>';
    echo $_POST['new_pass'] . '<br>';
    echo $_POST['old_pass'] . '<br>';*/

    if ($_POST['old_pass'] != '') {
        $checkPassQuery = "SELECT pass FROM users WHERE id = " . $_POST['id'];
        $checkPassResult = $mysqli->query($checkPassQuery);

        if ($checkPassResult) {
            $passFromDB = $checkPassResult->fetch_array(MYSQLI_NUM)[0];

            /*echo md5('134vit134') , '<br>';
            echo $passFromDB , '<br>';
            echo md5($_POST['old_pass']) , '<br>';
            echo $_POST['old_pass'] , '<br>';*/

            if ($passFromDB == md5($_POST['old_pass'])) {
                if ($_POST['new_pass'] == $_POST['rep_pass']) {
                    $updateArr[] = "`pass`='" . md5($_POST['new_pass']) . "'";
               } else {
                    $response['status'] = 'error';
                    $response['message'] = 'not_confirm_pass';
                    header("Location: " . $links['user'] . "/". $userId ."?" . http_build_query($response) );
               }
           } else {
                $response['status'] = 'error';
                $response['message'] = 'wrong_old_pass';
                header("Location: " . $back ."?" . http_build_query($response) );
           }
       } else {
            echo 'checkPassQuery' . $checkPassQuery;
       }
   }

    if ($_POST['avatar'] != '') {
        $updateArr[] = "`avatar`='" . $_POST['avatar'] . "'";
    }

    if (count($_POST['group']) > 0 ) {
        $uvgDeleteQuery = "DELETE FROM `users_vs_groups` WHERE user_id = " . $userId;

        if ($mysqli->query($uvgDeleteQuery)) {
            $uvgInsertArr = [];

            foreach ($_POST['group'] as $key => $value) {
                $uvgInsertArr[] = "(" . $userId . "," . $value . ")";
            }

            $uvgQuery = "INSERT INTO `users_vs_groups`(`user_id`, `group_id`) VALUES " . implode(',', $uvgInsertArr);

            if (!$mysqli->query($uvgQuery)) {
                echo $uvgQuery;
            }
        }
    }

    $bd = date('Y-m-d H:i:s' ,strtotime($_POST['birth_date']));

    $updateString = count($updateArr) > 0 ? "," . implode(',', $updateArr) : "";

    $firstName = $_POST['first_name'] ? "`first_name`='{$_POST['first_name']}'," : '';
    $secondName = $_POST['second_name'] ? "`second_name`='{$_POST['second_name']}'," : '';
    $lastName = $_POST['last_name'] ? "`last_name`='{$_POST['last_name']}'," : '';

    $active = '';
    if ($_POST['active']) {
        $active = $_POST['active'] == 'on' ? ",`active`=1" : ",`active`=0";
    }

    $updateQuery = "UPDATE `users` SET
                        ". $firstName ."
                        ". $secondName ."
                        ". $lastName ."
                        `birth_date`='{$bd}',
                        `years_old`={$interval->format('%y')},
                        `phone`='{$_POST['phone']}',
                        `email`='{$_POST['email']}'
                        " . $active . $updateString . "
                    WHERE id = " . $userId;

    $result = $mysqli->query($updateQuery);

    if ($result) {
        header("Location: " . $links['user'] . "?" . http_build_query($response) );
   } else {
        echo $updateQuery;
   }

    /*echo '<pre>';
    var_dump($_POST);
    echo '</pre>';*/


    /*echo '-------' . '<br>';
    echo implode(',', $updateArr) . '<br>';
    echo http_build_query($response) . '<br>';
    echo '-------' . '<br>';*/

?>