<?php
    include '../../../core/config.php';
    include '../../../core/functions.php';
    include '../../../../core/dbconnect.php';

    $back = getenv("HTTP_REFERER");
    $uploaddir = SITE_PATH . 'uploads/';


    $queryArr = [];

    foreach ($_POST as $key => $value) {
        if ($key == 'publish' && $value == 'on') {
            $value = 1;
        }

        $queryArr[] = "`" . $key . "`=" . "'" . $value . "'";
    }

    if ($_FILES['image']['tmp_name'] != '') {
        $uploadfile = date('d_m_y') . '-' . basename($_FILES['image']['name']);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploaddir . $uploadfile)) {
            $queryArr[] = "image='" . $sitePath . "uploads/"  . addslashes($uploadfile) . "'";
        } else {
            echo "File uploading failed.\n";
        }
    }

    echo '<pre>';
    var_dump($_POST);
    echo '</pre>';

    /*$query = "UPDATE `materials` SET " . implode(',', $queryArr) . " WHERE id = " . $_POST['id'];
    $result = $mysqli->query($query);

    if ($result) {
        header("Location: " . $links['material']);
    } else {
        header("Location: " . $back .  '?status=error');
    }*/

?>