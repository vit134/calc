<?php
    function route() {
        $url = $_SERVER['REQUEST_URI'];
        $result = array();

        if (stristr($url, '?') != '') {
            $url = explode('?', $url)[0];

            $result = explode('/', $url);

            $result['params'] = array_splice($_GET, 1);
        } else {
            $result = explode('/', $url);
        }

        return array_splice($result, 1);
    }


    function getAll() {
        global $mysqli;

        $arr = [];

        $catQuery = "SELECT * FROM `categories`";
        $resultCat = $mysqli->query($catQuery);

        foreach ($resultCat as $keyCal => $valCat) {

            $servQuery = "SELECT * FROM `services` WHERE `categoryId` = " . $valCat['id'];
            $resultServ = $mysqli->query($servQuery);

            $arr[$valCat['id']] = array(
                'id' => $valCat['id'],
                'name' => $valCat['name']
            );

            foreach ($resultServ as $keyServ => $valServ) {

                $subQuery = "SELECT * FROM `subservices` WHERE `serviceId` = " . $valServ['id'];
                $resultSub = $mysqli->query($subQuery);

                $arr[$valCat['id']]['service'][$valServ['id']] = array(
                    'id' => $valServ['id'],
                    'name' => $valServ['name']
                );

                foreach ($resultSub as $keySub => $valSub) {
                    $arr[$valCat['id']]['service'][$valServ['id']]['subservice'][] = $valSub;
                }
            }
        }

        return $arr;
    }

    function getCategory($id) {
        global $mysqli;

        $catQuery = "SELECT * FROM `categories` WHERE `id` = " . $id;
        $resultCat = $mysqli->query($catQuery);

        return $resultCat->fetch_assoc();
    }

    function getService($id) {
        global $mysqli;

        $catQuery = "SELECT * FROM `services` WHERE `id` = " . $id;
        $resultCat = $mysqli->query($catQuery);

        return $resultCat->fetch_assoc();
    }

    function getSubService($id) {
        global $mysqli;
        $arr = [];

        $catQuery = "SELECT * FROM `subservices` WHERE `serviceId` = " . $id;
        $resultCat = $mysqli->query($catQuery);

        foreach ($resultCat as $key => $value) {
            $arr[] = $value;
        }

        return $arr;
    }

?>