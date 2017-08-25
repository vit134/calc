<?php
    /*function route() {
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
    }*/

    class globalClass {
        //переменные из вне
        //global $mysqli;

        //свойства класса

        //Методы

        //Роутинг
        public function route() {
            $url = $_SERVER['REQUEST_URI'];
            $result = array();


            if (stristr($url, '?') != '') {
                $url = explode('?', $url)[0];

                $result = explode('/', $url);
                $result['params'] = $_GET;
            } else {
                $result = explode('/', $url);
            }

            return array_splice($result, 1);
        }

        //получить досуп пользователя по его id
        public function getUserAccess($id) {
            global $mysqli;

            $respose = [];

            $query = "SELECT g.access FROM `users_vs_groups` uvg LEFT JOIN groups g ON uvg.group_id = g.id WHERE uvg.user_id = " . $id;
            $result = $mysqli->query($query);

            foreach ($result as $key => $value) {
                $respose[$value['access']] = $value['access'];
            }

            return $respose;
        }

        //получить информацию о пользователе по его id
        public function getUserInfo($id) {
            global $mysqli;

            $query = "SELECT * FROM `users` WHERE id = " . $id;
            $result = $mysqli->query($query);

            foreach ($result as $key => $value) {
                $respose[$key] = $value;
            }

            return $respose[0];
        }

        //Получить все из категорий
        public function getAllCategories() {
            global $mysqli;
            $query = "SELECT * FROM categories";
            $result = $mysqli->query($query);

            return $result;
        }
        //Получить все из услуг
        public function getAllServices() {
            global $mysqli;
            $arr = [];

            $query = "SELECT * FROM services";
            $result = $mysqli->query($query);

            foreach ($result as $key => $value) {
                $arr[] = $value;
            }

            return $arr;
        }
        //Получить все из подуслуг
        public function getAllSubServices() {
            global $mysqli;
            $arr = [];

            $query = "SELECT * FROM subservices";
            $result = $mysqli->query($query);

            foreach ($result as $key => $value) {
                $arr[] = $value;
            }

            return $arr;
        }
        //Получить все из материалов
        public function getAllMaterials() {}

        //Получить одну категорию по её id
        public function getOneCategory($id) {}
        //Получить одну услугу по её id
        public function getOneService($id) {}
        //Получить одну подуслугу по её id
        public function getOneSubService($id) {}
        //Получить один материал по его id
        public function getOnematerial($id) {}

        //Получить все категории включая услуги и подуслуги
        public function getAllCategoriesWithSub() {
            global $mysqli;

            $query = "SELECT
                        c.*,
                        cvs.serv_id,
                        s.name AS serv_name,
                        s.publish AS serv_publish
                    FROM `categories` c
                    LEFT JOIN `cat_vs_service` cvs ON c.id = cvs.cat_id
                    LEFT JOIN `services` s ON cvs.serv_id = s.id";

            $result = $mysqli->query($query);

            if ($result) {
                foreach ($result as $key => $value) {
                    $servArr = array(
                        'id' => $value['serv_id'],
                        'name' => $value['serv_name']
                    );
                    $arr[$value['id']]['main'] = array(
                        'id' => $value['id'],
                        'name' => $value['name'],
                        'publish' => $value['publish']
                    );
                    if ($value['serv_id'] != NULL) {
                        $arr[$value['id']]['services'][] = array(
                            'id' => $value['serv_id'],
                            'name' => $value['serv_name'],
                            'publish' => $value['serv_publish']
                        );
                    }
                }
            }

            return $arr;
        }
        //Получить все услуги включая подуслуги и материалы
        public function getAllServicesWithSub($id) {}
        //Получить все подуслуги включая материалы
        public function getAllSubServicesWithSub($id) {}


        //Получить категорию включая услуги и подуслуги по её id
        public function getOneCategoryWithSub($id) {
            global $mysqli;

            $query = "SELECT
                        c.*,
                        cvs.serv_id,
                        s.name AS serv_name,
                        s.publish AS serv_publish
                    FROM `categories` c
                    LEFT JOIN `cat_vs_service` cvs ON c.id = cvs.cat_id
                    LEFT JOIN `services` s ON cvs.serv_id = s.id  WHERE c.id = " . $id;

            $result = $mysqli->query($query);

            if ($result) {
                foreach ($result as $key => $value) {
                    $servArr = array(
                        'id' => $value['serv_id'],
                        'name' => $value['serv_name']
                    );
                    $arr['main'] = array(
                        'id' => $value['id'],
                        'name' => $value['name'],
                        'publish' => $value['publish']
                    );
                    if ($value['serv_id'] != NULL) {
                        $arr['services'][] = array(
                            'id' => $value['serv_id'],
                            'name' => $value['serv_name'],
                            'publish' => $value['serv_publish']
                        );
                    }
                }
            }

            return $arr;
        }

        //Сравнить все улуги одной категории с уже добавленными в неё
        public function compareAllreadyServices($id) {
            $allready = $this->getOneCategoryWithSub($id)['services'];
            $all = $this->getAllServices();

            foreach ($all as $key => $value) {
                foreach ($allready as $arkey => $arvalue) {
                    if ($value['id'] == $arvalue['id']) {
                        unset($all[$key]);
                    }
                }
            }

            return $arr = array('already' => $allready, 'all' => $all);
        }

    }

?>