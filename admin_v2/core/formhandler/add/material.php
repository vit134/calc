<?php
    include '../../../core/config.php';
    include '../../../core/functions.php';
    include '../../../../core/dbconnect.php';

    $func = new globalClass();

    $back = getenv("HTTP_REFERER");
    $uploaddir = SITE_PATH . 'uploads/';

    $uploadfile = "https://www.clker.com/cliparts/B/u/S/l/W/l/no-photo-available-hi.png";

    if ($_FILES['image']['tmp_name'] != '') {
        $imageinfo = getimagesize($_FILES['image']['tmp_name']);

        if ($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png') {
            echo "Sorry, we only accept GIF and JPEG images\n";
            exit;
        }

        $blacklist = array(".php", ".phtml", ".php3", ".php4");
        foreach ($blacklist as $item) {
            if (preg_match("/$item\$/i", $_FILES['userfile']['name'])) {
                echo "We do not allow uploading PHP files\n";
                exit;
            }
        }

        $x = $_POST['x'];
        $y = $_POST['y'];
        $w = $_POST['width'];
        $h = $_POST['height'];

        $uploadfile = $func->crop($_FILES['image'], $x, $y, $w, $h);
    }

    $publish = $_POST['publish'] == 'on' ? 1 : 0;

    $query = "INSERT INTO `materials`
                (`name`, `image`, `price`, `unit`, `publish`)
              VALUES
                ('". $_POST['name'] ."','". $sitePath . $uploadfile ."','". $_POST['price'] ."','". $_POST['unit'] ."',". $publish .")";

    $result = $mysqli->query($query);

    $materialId = $mysqli->insert_id;

    if (count($_POST['subservices']) != 0 ) {

        foreach ($_POST['subservices'] as $key => $value) {
            $queryArr1[] = "('" . $value . "','" . $materialId . "')";
        }

        $queryCatVsS = "INSERT INTO `subserv_vs_materials` ( `subserv_id`, `material_id` ) VALUES " . implode(",", $queryArr1);
        $result = $mysqli->query($queryCatVsS);
    }

    if ($result) {
        header("Location: " . $links['material'] . "?status=success" );
    } else {
        header("Location: " . $back . "?status=error" );
    }
?>