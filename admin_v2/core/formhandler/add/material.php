<?php
    include '../../../core/config.php';
    include '../../../../core/dbconnect.php';

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

        $uploadfile = date('d_m_y') . '-' . basename($_FILES['image']['name']);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploaddir . $uploadfile)) {

        } else {
            echo "File uploading failed.\n";
        }
    }

    $publish = $_POST['publish'] == 'on' ? 1 : 0;

    $query = "INSERT INTO `materials`
                (`name`, `image`, `price`, `unit`, `publish`)
              VALUES
                ('". $_POST['name'] ."','". $sitePath . 'uploads/' . addslashes($uploadfile) ."','". $_POST['price'] ."','". $_POST['unit'] ."',". $publish .")";

    $result = $mysqli->query($query);

    if ($result) {
        header("Location: " . $links['material'] . "?status=success" );
    }
?>