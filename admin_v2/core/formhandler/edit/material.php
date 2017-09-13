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

        $tmpFilename = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileType = exif_imagetype($tmpFilename);
        $imageSize = getimagesize($tmpFilename);
        $fileName = $func->rus2translit($fileName);

        $x = $_POST['x'];
        $y = $_POST['y'];
        $w = $_POST['width'];
        $h = $_POST['height'];

        $new_filename = "uploads/" . intval($w) . "x" . intval($h) . "-" . $fileName;


        $new = imagecreatetruecolor($w, $h);
        if ($fileType == IMAGETYPE_JPEG) {
            $current_image = imagecreatefromjpeg($tmpFilename);
        } else if ($fileType == IMAGETYPE_PNG) {
            $current_image = imagecreatefrompng($tmpFilename);
        }


        imagecopyresampled($new, $current_image, 0, 0, $x, $y, $w, $h, $w, $h);

        if ($fileType == IMAGETYPE_JPEG) {
            if (!imagejpeg($new, SITE_PATH . $new_filename, 95)) {
                header("Location: " . $back .  '?status=error');
            }

        } else if ($fileType == IMAGETYPE_PNG) {
            imagepng($new, SITE_PATH . $new_filename, 9);
        }

        $queryArr[] = "`image`='" . $sitePath . $new_filename ."'";
    }

    /*echo implode(',', $queryArr);

    echo '<pre>';
    var_dump($_POST);
    var_dump($_FILES);
    echo '</pre>';*/

    $query = "UPDATE `materials` SET " . implode(',', $queryArr) . " WHERE id = " . $_POST['id'];
    $result = $mysqli->query($query);

    if ($result) {
        header("Location: " . $links['material']);
    } else {
        header("Location: " . $back .  '?status=error');
    }

?>