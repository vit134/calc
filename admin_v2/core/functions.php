<?php

    include 'config.php';

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
        public $uploadDir;

        //свойства класса

        //Методы

        //Настройки
        public function getSettings() {
            global $mysqli;
            $arr = [];

            $query = "SELECT * FROM `settings`";

            if ($result = $mysqli->query($query)) {
                //$arr = $result->fetch_assoc();

                foreach ($result as $key => $value) {
                    $arr[$value['name']] = $value;
                }
            }

            return $arr;
        }

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

        //Получить все группы
        public function getAllgroup() {
            global $mysqli;

            $arr = [];

            $query = "SELECT * FROM `groups`";
            $result = $mysqli->query($query);

            foreach ($result as $key => $value) {
                $arr[] = $value;
            }

            return $arr;
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

        //получить группы пользователя по его id
        public function getUserGroup($id) {
            global $mysqli;

            $respose = [];

            $query = "SELECT g.* FROM `groups` g
                          LEFT JOIN `users_vs_groups` uvg ON g.id = uvg.group_id
                      WHERE uvg.user_id = " . $id;

            $result = $mysqli->query($query);

            if ($result) {
                foreach ($result as $key => $value) {
                    $respose[] = $value;
                }
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

        //получить всех пользователей
        public function getAllUsers() {
            global $mysqli;
            $respose = [];

            $query = "SELECT u.*,
                             g.name AS group_name,
                             g.access AS group_access
                          FROM `users` u
                          LEFT JOIN `users_vs_groups` uvg ON u.id = uvg.user_id
                          LEFT JOIN `groups` g ON uvg.group_id = g.id";

            $result = $mysqli->query($query);

            foreach ($result as $key => $value) {
                $respose[$value['id']]['main'] = array(
                    'id' => $value['id'],
                    'first_name' => $value['first_name'],
                    'second_name' => $value['second_name'],
                    'last_name' => $value['last_name'],
                    'login' => $value['login'],
                    'pass' => $value['pass'],
                    'phone' => $value['phone'],
                    'email' => $value['email'],
                    'avatar' => $value['avatar'],
                    'active' => $value['active'],
                    'last_login' => $value['last_login']
                );
                $respose[$value['id']]['group'][] = array(
                    'group_name' => $value['group_name'],
                    'group_access' => $value['group_access']
                );
            }

            return $respose;
        }

        //получить всех клиентов
        public function getAllClients() {
            global $mysqli;
            $respose = [];

            $query = "SELECT * FROM `clients`";
            $result = $mysqli->query($query);

            foreach ($result as $key => $value) {
                $respose[] = $value;
            }

            return $respose;

        }

        //получить одного клиента по его id
        public function getOneClient($id) {
            global $mysqli;
            $respose = [];

            $query = "SELECT * FROM `clients` WHERE id = " . $id;
            $result = $mysqli->query($query);

            foreach ($result as $key => $value) {
                $respose[] = $value;
            }

            return $respose[0];

        }

        //получить всех менеджером о продажам
        public function getSalesManager() {
            global $mysqli;

            $query = "SELECT u.* FROM `users` u
                          LEFT JOIN `users_vs_groups` uvg ON u.id = uvg.user_id
                          LEFT JOIN `groups` g ON uvg.group_id = g.id
                      WHERE g.id = 1";

            $result = $mysqli->query($query);

            foreach ($result as $key => $value) {
                $arr[] = $value;
            }

            return $arr;
        }

        //Получить все заказы
        public function getAllOrders() {
            global $mysqli;
            $arr = [];

            $query ="SELECT o.*, u.first_name AS manager_first_name, u.last_name AS manager_last_name, c.first_name AS client_first_name, c.last_name AS client_last_name FROM `orders` o
                     LEFT JOIN `users_vs_orders` uvo ON uvo.order_id = o.id
                     LEFT JOIN `users` u ON uvo.user_id = u.id
                     LEFT JOIN `clients_vs_orders` cvo ON cvo.order_id = o.id
                     LEFT JOIN `clients` c ON c.id = cvo.client_id";

            $result = $mysqli->query($query);

            if ($result) {
                foreach ($result as $key => $value) {
                    $arr[] = $value;
                }
            }

            return $arr;
        }

        //Получить заказ по id
        public function getOneOrders($id) {
            global $mysqli;
            $arr = [];

            /*$query ="SELECT o.*, u.first_name AS manager_first_name, u.last_name AS manager_last_name, c.first_name AS client_first_name, c.last_name AS client_last_name FROM `orders` o
                     LEFT JOIN `users_vs_orders` uvo ON uvo.order_id = o.id
                     LEFT JOIN `users` u ON uvo.user_id = u.id
                     LEFT JOIN `clients_vs_orders` cvo ON cvo.order_id = o.id
                     LEFT JOIN `clients` c ON c.id = cvo.client_id WHERE o.id = " . $id;*/

            $query = "SELECT * FROM `orders` WHERE id = " . $id;

            $result = $mysqli->query($query);

            $serviceQuery ="SELECT service_id FROM `orders_vs_service` WHERE order_id = " . $id;

            $serviceResult = $mysqli->query($serviceQuery);
            $services = [];

            if ($serviceResult) {
                foreach ($serviceResult as $key => $value) {
                    $services[] = $value['service_id'];
                }
            }

            if ($result) {
                foreach ($result as $key => $value) {
                    $arr = array(
                        'id' => $value['id'],
                        'obj_type' => $value['obj_type'],
                        'obj_adress' => $value['obj_adress'],
                        'count_of_meters' => $value['count_of_meters'],
                        'work_price' => $value['work_price'],
                        'material_price' => $value['material_price'],
                        'without_materials' => $value['without_materials'],
                        'date_create' => $value['date_create'],
                        'date_edit' => $value['date_edit'],
                        'client' => $this->getOneClient($value['client_id']),
                        'manager' => $this->getUserInfo($value['manager_id']),
                        'resourses' => $this->getServiceInOrderInfo($services, $value['count_of_meters'])
                    );
                }
            }

            return $arr;
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
        public function getOnematerial($id) {
            global $mysqli;
            $arr = [];

            $query = "SELECT * FROM materials WHERE id =" . $id;
            $result = $mysqli->query($query);

            foreach ($result as $key => $value) {
                $arr[] = $value;
            }

            return $arr;
        }

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
                          s.price,
                          ss.id AS subserv_id,
                          ss.name AS subserv_name,
                          ss.publish AS subserv_publish,
                          ss.price_for_unit AS subserv_price,
                          ss.minute_for_unit AS subserv_minute,
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
                        'publish' => $value['publish'],
                        'price' => $value['price']
                    );
                    if ($value['subserv_id'] != NULL) {
                        $arr[$value['id']]['subservices'][$value['subserv_id']] = array(
                            'id' => $value['subserv_id'],
                            'name' => $value['subserv_name'],
                            'publish' => $value['subserv_publish'],
                            'price' => $value['subserv_price'],
                            'minute' => $value['subserv_minute']
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

        //получить все услуги с итого
        public function getAllServiceWithPrice() {
            $data = $this->getAllServicesWithSub();
            $arr = [];

            foreach ($data as $key => $value) {
                if ($value['main']['price'] == 0) {
                    $arr[$key] = $value;

                    $priceOfWork = 0;
                    foreach ($value['subservices'] as $k => $val) {
                        $priceOfWork = $priceOfWork + intval($val['price']);
                    }

                    $arr[$key]['main']['price_of_work'] = $priceOfWork;
                } else {
                    $arr[$key] = $value;
                }
            }

            foreach ($arr as $key => $value) {
                foreach ($value['subservices'] as $keyS => $valueS) {
                    $materials = $this->getOneServiceWithSub($value['main']['id'])['materials'];

                    if ($materials) {
                        $priceOfMaterials = 0;

                        foreach ($materials as $keyM => $valueM) {
                            $priceOfMaterialsItem = intval($valueM['count']) * intval($valueM['price']);
                            $priceOfMaterials = $priceOfMaterials + $priceOfMaterialsItem;
                        }

                        $arr[$key]['main']['price_of_materials'] = $priceOfMaterials;
                        $arr[$key]['materials'] = $materials;
                    }
                }
            }

            return $arr;
        }

        //получить одну итого одной  услуги
        public function getOneServiceWithPrice($id) {
            $data = $this->getOneServiceWithSub($id);

            $workPrice = 0;
            $materialPrice = 0;
            $time = 0;

            if ($data['main']['price'] != 0) {
                $workPrice = $data['main']['price'];
            } else {
                if ($data['subservices']) {
                    foreach ($data['subservices'] as $key => $value) {
                        $workPrice = $workPrice + $value['price'];
                        $time = $time + $value['minute'];
                        $subservices[] = $value;
                    }
                }
            }

            if ($data['materials']) {
                foreach ($data['materials'] as $key => $value) {
                    $priceAllItem = $value['price'] * $value['count'];
                    $materialPrice = $materialPrice + $priceAllItem;
                    $materials[] = $value;
                }


            }



            //return $data;
            return array('work' => $workPrice, 'material' => $materialPrice, 'time' => $time, 'main' => $data['main'], 'subservices' => $subservices, 'materials' => $materials);
        }

        //получить итого услуг, материалы и их итого из массива услуг
        public function getServiceInOrderInfo($arr, $m) {
            $response = [];

            $allWorkPriceTotal = 0;
            $allWorkTimeTotal = 0;
            $materialPriceTotal = 0;

            foreach ($arr as $key => $id) {
                $servArr = $this->getOneServiceWithSub($id);

                $oneWorkPriceTotal = 0;
                $oneWorkTimeTotal = 0;

                if ($servArr['main']['price'] == 0) {
                    if ($servArr['subservices']) {
                        foreach ($servArr['subservices'] as $key => $subserv) {
                            $oneWorkPriceTotal = $oneWorkPriceTotal + $subserv['price'];
                        }
                    }
                } else {
                    $oneWorkPriceTotal = $oneWorkPriceTotal + $servArr['main']['price'];
                }

                $allWorkPriceTotal = $allWorkPriceTotal + $oneWorkPriceTotal;

                $response['services']['all'][] = array(
                    'id' => $servArr['main']['id'],
                    'name' => $servArr['main']['name'],
                    'price_for_one' => $oneWorkPriceTotal,
                    'price_total' => $oneWorkPriceTotal * $m
                );



                if ($servArr['materials']) {
                    foreach ($servArr['materials'] as $key => $value) {
                        $response['materials']['all'][] = array(
                            'id' =>$value['id'],
                            'name' => $value['name'],
                            'price_for_one' => $value['price'],
                            'count_total' => $value['count'] * $m,
                            'price_total' => $value['price'] * $value['count'] * $m,
                            'image' => $value['image']
                        );

                        $materialPriceTotal = $materialPriceTotal + $value['price'] * $value['count'];

                    }
                }
            }

            $response['services']['price_total'] = $allWorkPriceTotal * $m;
            $response['materials']['price_total'] = $materialPriceTotal * $m;

            return $response;
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

        //Получить все подуслуги включая материалы
        public function getAllMaterialsWithSub() {
            global $mysqli;

            $query = "SELECT
                        m.*,
                        s.id AS subserv_id,
                        s.name AS subserv_name
                      FROM `materials` m
                        LEFT JOIN `subserv_vs_materials` svm ON m.id = svm.material_id
                        LEFT JOIN `subservices` s ON s.id = svm.subserv_id";

            $result = $mysqli->query($query);

            if ($result) {
                foreach ($result as $key => $value) {

                    $arr[$value['id']]['main'] = array(
                        'id' => $value['id'],
                        'name' => $value['name'],
                        'publish' => $value['publish'],
                        'image' => $value['image'],
                        'price' => $value['price'],
                        'unit' => $value['unit']
                    );
                    if ($value['subserv_id'] != NULL) {
                        $arr[$value['id']]['subservices'][$value['subserv_id']] = array(
                            'id' => $value['subserv_id'],
                            'name' => $value['subserv_name']
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
                        $arr['services'][] = $this->getOneServiceWithSub($value['serv_id']);
                        /*$arr['services'][] = array(
                            'id' => $value['serv_id'],
                            'name' => $value['serv_name'],
                            'publish' => $value['serv_publish']
                        );*/
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
                          s.price,
                          ss.id AS subserv_id,
                          ss.name AS subserv_name,
                          ss.publish AS subserv_publish,
                          ss.price_for_unit AS subserv_price,
                          ss.minute_for_unit AS subserv_minute,
                          c.id AS cat_id,
                          c.name AS cat_name,
                          svm.count_of_unit AS count_unit,
                          m.id AS mat_id,
                          m.name AS mat_name,
                          m.image AS mat_image,
                          m.price AS mat_price,
                          m.unit AS mat_unit,
                          m.publish AS mat_publish
                      FROM `services` s
                      LEFT JOIN serv_vs_subserv svs ON s.id = svs.serv_id
                      LEFT JOIN subservices ss ON svs.subserv_id = ss.id
                      LEFT JOIN cat_vs_service cvs ON cvs.serv_id = s.id
                      LEFT JOIN categories c ON c.id = cvs.cat_id
                      LEFT JOIN subserv_vs_materials svm ON svm.subserv_id = ss.id
                      LEFT JOIN materials m ON m.id = svm.material_id
                      WHERE s.id = " . $id;

            $result = $mysqli->query($query);

            if ($result) {

                foreach ($result as $key => $value) {
                    $arr['main'] = array(
                        'id' => $value['id'],
                        'name' => $value['name'],
                        'price' => $value['price']
                    );
                    if ($value['subserv_id'] != NULL) {
                        $arr['subservices'][$value['subserv_id']] = array(
                            'id' => $value['subserv_id'],
                            'name' => $value['subserv_name'],
                            'publish' => $value['subserv_publish'],
                            'price' => $value['subserv_price'],
                            'minute' => $value['subserv_minute']
                        );
                    }

                    if ($value['mat_id'] != NULL) {
                        $arr['materials'][$value['mat_id']] = array(
                            'id' => $value['mat_id'],
                            'name' => $value['mat_name'],
                            'image' => $value['mat_image'],
                            'price' => $value['mat_price'],
                            'unit' => $value['mat_unit'],
                            'publish' => $value['mat_publish'],
                            'count' => $value['count_unit'],
                        );
                    }
                }
            }

            return $arr;
        }

        //Получить вид работ, включая родительские услуги и мфтериалы, по её id
        public function getOneSubServiceWithSub($id) {
            global $mysqli;

            $query = "SELECT
                          ss.id,
                          ss.name,
                          ss.publish,
                          ss.price_for_unit,
                          ss.minute_for_unit,
                          svm.count_of_unit AS count_unit,
                          m.id AS mat_id,
                          m.name AS mat_name,
                          m.image AS mat_image,
                          m.price AS mat_price,
                          m.unit AS mat_unit,
                          m.publish AS mat_publish
                      FROM `subservices` ss
                      LEFT JOIN serv_vs_subserv svs ON ss.id = svs.serv_id
                      LEFT JOIN subserv_vs_materials svm ON svm.subserv_id = ss.id
                      LEFT JOIN materials m ON m.id = svm.material_id
                      WHERE ss.id = " . $id;

            $result = $mysqli->query($query);

            if ($result) {

                foreach ($result as $key => $value) {
                    $arr['main'] = array(
                        'id' => $value['id'],
                        'name' => $value['name'],
                        'publish' => $value['publish'],
                        'price_for_unit' => $value['price_for_unit'],
                        'minute_for_unit' => $value['minute_for_unit']
                    );
                    if ($value['subserv_id'] != NULL) {
                        $arr['subservices'][$value['subserv_id']] = array(
                            'id' => $value['subserv_id'],
                            'name' => $value['subserv_name'],
                            'publish' => $value['subserv_publish']
                        );
                    }

                    if ($value['mat_id'] != NULL) {
                        $arr['materials'][$value['mat_id']] = array(
                            'id' => $value['mat_id'],
                            'name' => $value['mat_name'],
                            'image' => $value['mat_image'],
                            'price' => $value['mat_price'],
                            'unit' => $value['mat_unit'],
                            'publish' => $value['mat_publish'],
                            'count' => $value['count_unit'],
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
                        if ($value['id'] == $arvalue['main']['id']) {
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

        //Сравнить все группы пользователя  с уже добавленными в него по его id
        public function compareAlreadyGroup($user_id) {
            $allready = $this->getUserGroup($user_id);
            $all = $this->getAllgroup();

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

        //транслитерация
        public function rus2translit($string) {
            $converter = array(
                'а' => 'a',   'б' => 'b',   'в' => 'v',
                'г' => 'g',   'д' => 'd',   'е' => 'e',
                'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
                'и' => 'i',   'й' => 'y',   'к' => 'k',
                'л' => 'l',   'м' => 'm',   'н' => 'n',
                'о' => 'o',   'п' => 'p',   'р' => 'r',
                'с' => 's',   'т' => 't',   'у' => 'u',
                'ф' => 'f',   'х' => 'h',   'ц' => 'c',
                'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
                'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
                'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

                'А' => 'A',   'Б' => 'B',   'В' => 'V',
                'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
                'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
                'И' => 'I',   'Й' => 'Y',   'К' => 'K',
                'Л' => 'L',   'М' => 'M',   'Н' => 'N',
                'О' => 'O',   'П' => 'P',   'Р' => 'R',
                'С' => 'S',   'Т' => 'T',   'У' => 'U',
                'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
                'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
                'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
                'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
            );
            return strtr($string, $converter);
        }

        //crop изображений
        public function crop($image, $x, $y, $w, $h) {

            $success = false;
            $tmpFilename = $image['tmp_name'];
            $fileName = $image['name'];
            $fileType = exif_imagetype($tmpFilename);
            $imageSize = getimagesize($tmpFilename);
            $fileName = $this->rus2translit($fileName);

            $uploadDir = "uploads/";

            $new_filename = $uploadDir . intval($w) . "x" . intval($h) . "-" . $fileName;


            $new = imagecreate($w, $h);
            $back = imagecolorallocatealpha($new, 255, 255, 255, 127);
            imagefilledrectangle($new, 0, 0, $w, $h, $back);

            if ($fileType == IMAGETYPE_JPEG) {
                $current_image = imagecreatefromjpeg($tmpFilename);
            } else if ($fileType == IMAGETYPE_PNG) {
                $current_image = imagecreatefrompng($tmpFilename);
            }

            imagecopyresampled($new, $current_image, 0, 0, $x, $y, $w, $h, $w, $h);

            if ($fileType == IMAGETYPE_JPEG) {
                if (imagejpeg($new, SITE_PATH . $new_filename, 65)) {
                    $success = true;
                }

            } else if ($fileType == IMAGETYPE_PNG) {
                //imagetruecolortopalette($new, false, 255);

                if (imagepng($new, SITE_PATH . $new_filename, 6)) {
                    $success = true;
                }
            }

            if ($success) {
                return $new_filename;
            }
        }

        //получить все аватарки из папки assets/images/avatar
        public function getAvatar() {
            global $sitePath;

            $dir    = 'assets/images/avatar/';
            $files = scandir(SITE_PATH . $dir);

            unset($files[0]);
            unset($files[1]);

            foreach ($files as $key => $value) {
                $files[$key] = $sitePath . $dir . $value;
            }

            return $files;
        }

        //рандом
        public function randomString($length = 6) {
            $str = "";
            $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
            $max = count($characters) - 1;
            for ($i = 0; $i < $length; $i++) {
                $rand = mt_rand(0, $max);
                $str .= $characters[$rand];
            }
            return $str;
        }

    }

?>