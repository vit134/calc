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

            $arr['categories'][$valCat['id']] = array(
                'id' => $valCat['id'],
                'name' => $valCat['name']
            );

            foreach ($resultServ as $keyServ => $valServ) {

                $subQuery = "SELECT * FROM `subservices` WHERE `serviceId` = " . $valServ['id'];
                $resultSub = $mysqli->query($subQuery);

                $arr['categories'][$valCat['id']]['service'][$valServ['id']] = array(
                    'id' => $valServ['id'],
                    'name' => $valServ['name']
                );

                foreach ($resultSub as $keySub => $valSub) {
                    $arr['categories'][$valCat['id']]['service'][$valServ['id']]['subservice'][] = $valSub;
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

    function getServiceByCat($catId) {
        global $mysqli;

        $catQuery = "SELECT * FROM `services` WHERE `categoryId` = " . $catId;
        $resultCat = $mysqli->query($catQuery);

        foreach ($resultCat as $key => $value) {
            $arr[] = array(
                $value,
                'subservice' => getSubService($value['id'])
            );
        }

        return $arr;
    }

    function getSubService($id) {
        global $mysqli;
        $arr = [];

        $catQuery = "SELECT * FROM `subservices` WHERE `serviceId` = " . $id;
        $resultCat = $mysqli->query($catQuery);

        foreach ($resultCat as $key => $value) {
            $arr[] = array(
                $value,
                'materials' => getMaterialsBySsId($value['id'])
            );
        }

        return $arr;
    }

    function getSubServiceById($id) {
        global $mysqli;
        $arr = [];

        $catQuery = "SELECT * FROM `subservices` WHERE `id` = " . $id;
        $resultCat = $mysqli->query($catQuery);

        foreach ($resultCat as $key => $value) {
            $arr[] = $value;
        }

        return $arr;
    }

    function getAllCategories() {
        global $mysqli;
        $arr = [];

        $query = "SELECT * FROM categories";
        $result = $mysqli->query($query);

        foreach ($result as $key => $value) {

            $arr[$value['id']] = array(
                'id' => $value['id'],
                'name' => $value['name'],
                'service' => getServiceByCat($value['id'])
            );

        }

        return $arr;
    }

    function getServices() {
        global $mysqli;
        $arr = [];

        $query = "SELECT * FROM services";
        $result = $mysqli->query($query);

        foreach ($result as $key => $value) {

            /*$arr[$value['id']] = array(
                'id' => $value['id'],
                'name' => $value['name'],
                'subservice' => getServiceByCat($value['id'])
            );*/

            $arr[] = $value;

        }

        return $arr;
    }

    function getSubServices() {
        global $mysqli;
        $arr = [];

        $query = "SELECT * FROM subservices";
        $result = $mysqli->query($query);

        foreach ($result as $key => $value) {

            /*$arr[$value['id']] = array(
                'id' => $value['id'],
                'name' => $value['name'],
                'subservice' => getServiceByCat($value['id'])
            );*/

            $arr[] = $value;

        }

        return $arr;
    }

    function getFullCategories($id) {
        global $mysqli;
        $arr = [];

        $query = "SELECT * FROM categories WHERE `id` = " . $id;
        $result = $mysqli->query($query);

        foreach ($result as $key => $value) {

            $arr = array(
                'id' => $value['id'],
                'name' => $value['name'],
                'service' => getServiceByCat($value['id'])
            );

        }

        return $arr;
    }

    function getAllService() {
        global $mysqli;
        $arr = [];

        $query = "SELECT s.*, c.name AS cat_name, c.id AS cat_id FROM services s INNER JOIN categories c ON s.categoryId = c.id";
        $result = $mysqli->query($query);

        foreach ($result as $key => $value) {
            $arr[$value['id']] = array(
                'id' => $value['id'],
                'name' => $value['name'],
                'category_id' => $value['cat_id'],
                'category_name' => $value['cat_name'],
                'subservice' => getSubService($value['id'])
            );
        }

        /*echo '<pre>';
        var_dump($arr);
        echo '</pre>';*/
        return $arr;
    }

    function getAllSubService() {
        global $mysqli;
        $arr = [];

        $query = "SELECT ss.*, s.name AS serv_name, s.categoryId AS cat_id, c.name AS cat_name FROM  subservices ss INNER JOIN services s ON ss.serviceId = s.id INNER JOIN categories c ON s.categoryId = c.id";
        $result = $mysqli->query($query);

        foreach ($result as $key => $value) {
            $arr[] = $value;
        }

        /*echo '<pre>';
        var_dump($arr);
        echo '</pre>';*/
        return $arr;
    }

    function getMaterialsBySsId($id) {
        global $mysqli;
        $arr = [];

        $catQuery = "SELECT * FROM `materials` WHERE `subserv_id` = " . $id;
        $resultCat = $mysqli->query($catQuery);

        foreach ($resultCat as $key => $value) {
            $arr[] = $value;
        }

        return $arr;
    }

    function getLength() {
        global $mysqli;
        $arr = [];

        $catQuery = "SELECT * FROM `categories`";
        $resultCat = $mysqli->query($catQuery);

        $servQuery = "SELECT * FROM `services`";
        $resultServ = $mysqli->query($servQuery);

        $subQuery = "SELECT * FROM `subservices`";
        $resultSub = $mysqli->query($subQuery);

        return $arr = array(
            'categories' => $resultCat->num_rows,
            'service' => $resultServ->num_rows,
            'subservice' => $resultSub->num_rows,
        );
    }


    function search($val) {
        global $mysqli, $searchConfig;
        $arr = [];

        foreach ($searchConfig['tables'] as $key => $tableName) {
            $query = "SELECT * FROM `" . $tableName . "` WHERE `name` like '%" . $val . "%'";
            $result = $mysqli->query($query);
            //echo $query . '<br>';

            //$arr[$value][] = $result;
            foreach ($result as $key => $value) {
                $arr[$tableName]['result'][] = $value;
            }
        }

        return $arr;
    }

    function synonym($syn) {
        global $synonyms;

        foreach ($synonyms as $key => $value) {
            echo  $key;

            if ($syn == $key) {
                return $value;
            }
        }
    }

?>