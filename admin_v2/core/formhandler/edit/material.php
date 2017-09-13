<?php
    include '../../../core/config.php';
    include '../../../core/functions.php';
    include '../../../../core/dbconnect.php';

    $func = new globalClass();

    $back = getenv("HTTP_REFERER");
    $uploaddir = SITE_PATH . 'uploads/';

    $queryArr = [];

    foreach ($_POST as $key => $value) {
        if ($key != 'x' && $key != 'y' && $key != 'width' && $key != 'height') {
            if ($key == 'publish' && $value == 'on') {
                $value = 1;
            }

            $queryArr[] = "`" . $key . "`=" . "'" . $value . "'";
        }
    }

    if ($_FILES['image']['tmp_name'] != '') {

        $x = $_POST['x'];
        $y = $_POST['y'];
        $w = $_POST['width'];
        $h = $_POST['height'];

        $new_filename = $func->crop($_FILES['image'], $x, $y, $w, $h);

        $queryArr[] = "`image`='" . $sitePath . $new_filename ."'";
    }

    $query = "UPDATE `materials` SET " . implode(',', $queryArr) . " WHERE id = " . $_POST['id'];
    $result = $mysqli->query($query);

    if ($result) {
        header("Location: " . $links['material']);
    } else {
        header("Location: " . $back .  '?status=error');
    }

?>