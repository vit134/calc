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
        public function getAllCategories() {}
        //Получить все из услуг
        public function getAllServices() {}
        //Получить все из подуслуг
        public function getAllSubServices() {}
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
        public function getAllCategoriesWithSub($id) {}
        //Получить все услуги включая подуслуги и материалы
        public function getAllServicesWithSub($id) {}
        //Получить все подуслуги включая материалы
        public function getAllSubServicesWithSub($id) {}



    }

?>