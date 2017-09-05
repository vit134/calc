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

            foreach ($result as $key => $value) {
                $arr[] = $value;
            }

            return $arr;
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
        public function getAllMaterials() {
            global $mysqli;
            $arr = [];

            $query = "SELECT * FROM materials";
            $result = $mysqli->query($query);

            foreach ($result as $key => $value) {
                $arr[] = $value;
            }

            return $arr;
        }

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
        //Получить все услуги включая подуслуги
        public function getAllServicesWithSub() {
            global $mysqli;

            $query = "SELECT
                          s.id,
                          s.name,
                          s.publish,
                          ss.id AS subserv_id,
                          ss.name AS subserv_name,
                          ss.publish AS subserv_publish,
                          c.id AS cat_id,
                          c.name AS cat_name
                      FROM `services` s
                      LEFT JOIN serv_vs_subserv svs ON s.id = svs.serv_id
                      LEFT JOIN subservices ss ON svs.subserv_id = ss.id
                      LEFT JOIN cat_vs_service cvs ON cvs.serv_id = s.id
                      LEFT JOIN categories c ON c.id = cvs.cat_id";

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
                    if ($value['subserv_id'] != NULL) {
                        $arr[$value['id']]['subservices'][$value['subserv_id']] = array(
                            'id' => $value['subserv_id'],
                            'name' => $value['subserv_name'],
                            'publish' => $value['subserv_publish']
                        );
                    }

                    if ($value['cat_id'] != NULL) {
                        $arr[$value['id']]['categories'][$value['cat_id']] = array(
                            'id' => $value['cat_id'],
                            'name' => $value['cat_name']
                        );
                    }
                }
            }

            return $arr;
        }
        //Получить все подуслуги включая материалы
        public function getAllSubServicesWithSub() {
            global $mysqli;

            $query = "SELECT ss.id,
                             ss.name,
                             ss.minute_for_unit,
                             ss.price_for_unit,
                             ss.publish,
                             s.id AS serv_id,
                             s.name AS serv_name,
                             s.publish AS serv_publish,
                             m.id AS material_id,
                             m.name AS material_name,
                             m.price AS material_price,
                             m.image AS material_image
                      FROM `subservices` ss
                          LEFT JOIN serv_vs_subserv svs ON ss.id = svs.subserv_id
                          LEFT JOIN `services` s ON s.id = svs.serv_id
                          LEFT JOIN `subserv_vs_materials` svm  ON ss.id = svm.subserv_id
                          LEFT JOIN `materials` m  ON m.id = svm.material_id";

            $result = $mysqli->query($query);

            if ($result) {
                foreach ($result as $key => $value) {

                    $arr[$value['id']]['main'] = array(
                        'id' => $value['id'],
                        'name' => $value['name'],
                        'publish' => $value['publish'],
                        'minute_for_unit' => $value['minute_for_unit'],
                        'price_for_unit' => $value['price_for_unit']
                    );
                    if ($value['serv_id'] != NULL) {
                        $arr[$value['id']]['services'][$value['serv_id']] = array(
                            'id' => $value['serv_id'],
                            'name' => $value['serv_name'],
                            'publish' => $value['serv_publish']
                        );
                    }

                    if ($value['material_id'] != NULL) {
                        $arr[$value['id']]['materials'][$value['material_id']] = array(
                            'id' => $value['material_id'],
                            'name' => $value['material_name'],
                            'price' => $value['material_price'],
                            'image' => $value['material_image']
                        );
                    }
                }
            }

            return $arr;
        }


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

        //Получить услугу, включая родительские категории и подуслуги, по её id
        public function getOneServiceWithSub($id) {
            global $mysqli;

            $query = "SELECT
                          s.id,
                          s.name,
                          s.publish,
                          ss.id AS subserv_id,
                          ss.name AS subserv_name,
                          ss.publish AS subserv_publish,
                          c.id AS cat_id,
                          c.name AS cat_name
                      FROM `services` s
                      LEFT JOIN serv_vs_subserv svs ON s.id = svs.serv_id
                      LEFT JOIN subservices ss ON svs.subserv_id = ss.id
                      LEFT JOIN cat_vs_service cvs ON cvs.serv_id = s.id
                      LEFT JOIN categories c ON c.id = cvs.cat_id
                      WHERE s.id = " . $id;

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
                    if ($value['subserv_id'] != NULL) {
                        $arr['subservices'][$value['subserv_id']] = array(
                            'id' => $value['subserv_id'],
                            'name' => $value['subserv_name'],
                            'publish' => $value['subserv_publish']
                        );
                    }

                    if ($value['cat_id'] != NULL) {
                        $arr['categories'][$value['cat_id']] = array(
                            'id' => $value['cat_id'],
                            'name' => $value['cat_name']
                        );
                    }
                }
            }

            return $arr;
        }

        //Получить вид работ, включая родительские услуги и мфтериалы, по её id
        public function getOneSubServiceWithSub($id) {
            global $mysqli;

            $query = "SELECT ss.id,
                             ss.name,
                             ss.minute_for_unit,
                             ss.price_for_unit,
                             ss.publish,
                             s.id AS serv_id,
                             s.name AS serv_name,
                             s.publish AS serv_publish,
                             m.id AS material_id,
                             m.name AS material_name,
                             m.price AS material_price,
                             m.image AS material_image
                      FROM `subservices` ss
                          LEFT JOIN serv_vs_subserv svs ON ss.id = svs.subserv_id
                          LEFT JOIN `services` s ON s.id = svs.serv_id
                          LEFT JOIN `subserv_vs_materials` svm  ON ss.id = svm.subserv_id
                          LEFT JOIN `materials` m  ON m.id = svm.material_id
                      WHERE ss.id = " . $id;

            $result = $mysqli->query($query);

            if ($result) {
                foreach ($result as $key => $value) {

                    $arr['main'] = array(
                        'id' => $value['id'],
                        'name' => $value['name'],
                        'publish' => $value['publish'],
                        'minute_for_unit' => $value['minute_for_unit'],
                        'price_for_unit' => $value['price_for_unit']
                    );
                    if ($value['serv_id'] != NULL) {
                        $arr['services'][$value['serv_id']] = array(
                            'id' => $value['serv_id'],
                            'name' => $value['serv_name'],
                            'publish' => $value['serv_publish']
                        );
                    }

                    if ($value['material_id'] != NULL) {
                        $arr['materials'][$value['material_id']] = array(
                            'id' => $value['material_id'],
                            'name' => $value['material_name'],
                            'price' => $value['material_price'],
                            'image' => $value['material_image']
                        );
                    }
                }
            }

            return $arr;
        }

        //Сравнить все услуги одной категории с уже добавленными в неё
        public function compareAlreadyServices($id) {
            $allready = $this->getOneCategoryWithSub($id)['services'];
            $all = $this->getAllServices();

            foreach ($all as $key => $value) {
                if ($allready != NULL) {
                    foreach ($allready as $arkey => $arvalue) {
                        if ($value['id'] == $arvalue['id']) {
                            unset($all[$key]);
                        }
                    }
                }
            }

            return $arr = array('already' => $allready, 'all' => $all);
        }

        //Сравнить все категории одной услуги с уже добавленными в неё по её id
        public function compareAlreadyCategories($id) {
            $allready = $this->getOneServiceWithSub($id)['categories'];
            $all = $this->getAllCategories();

            foreach ($all as $key => $value) {
                if ($allready != NULL) {
                    foreach ($allready as $arkey => $arvalue) {
                        if ($value['id'] == $arvalue['id']) {
                            unset($all[$key]);
                        }
                    }
                }
            }

            return $arr = array('already' => $allready, 'all' => $all);
        }

        //Сравнить все виды работ одной услуги с уже добавленными в неё по её id
        public function compareAlreadySubservices($serv_id) {
            $allready = $this->getOneServiceWithSub($serv_id)['subservices'];
            $all = $this->getAllSubServices();

            foreach ($all as $key => $value) {
                if ($allready != NULL) {
                    foreach ($allready as $arkey => $arvalue) {
                        if ($value['id'] == $arvalue['id']) {
                            unset($all[$key]);
                        }
                    }
                }
            }

            return $arr = array('already' => $allready, 'all' => $all);
        }

        //Сравнить все материалы одного вида работ с уже добавленными в него по её id
        public function compareAlreadyMaterials($mat_id) {
            $allready = $this->getOneSubServiceWithSub($mat_id)['materials'];
            $all = $this->getAllMaterials();

            foreach ($all as $key => $value) {
                if ($allready != NULL) {
                    foreach ($allready as $arkey => $arvalue) {
                        if ($value['id'] == $arvalue['id']) {
                            unset($all[$key]);
                        }
                    }
                }
            }

            return $arr = array('already' => $allready, 'all' => $all);
        }
    }

?>