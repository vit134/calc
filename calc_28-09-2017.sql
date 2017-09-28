-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Время создания: Сен 28 2017 г., 16:02
-- Версия сервера: 5.5.53-log
-- Версия PHP: 7.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `calc`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `publish` tinyint(1) NOT NULL DEFAULT '0',
  `description` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `publish`, `description`) VALUES
(39, 'Полы', 1, ''),
(40, 'Стены', 1, ''),
(44, 'Ванная', 1, ''),
(45, 'Электрика', 1, ''),
(46, 'Потолки', 1, '');

-- --------------------------------------------------------

--
-- Структура таблицы `cat_vs_service`
--

CREATE TABLE `cat_vs_service` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `serv_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cat_vs_service`
--

INSERT INTO `cat_vs_service` (`id`, `cat_id`, `serv_id`) VALUES
(117, 39, 48),
(118, 39, 49),
(119, 39, 47);

-- --------------------------------------------------------

--
-- Структура таблицы `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `second_name` varchar(20) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `login` varchar(20) NOT NULL,
  `pass` varchar(200) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `adress` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `clients`
--

INSERT INTO `clients` (`id`, `first_name`, `second_name`, `last_name`, `login`, `pass`, `phone`, `email`, `adress`) VALUES
(5, '123', '', '123', '1_123', 'nrZ70d', '', 'фыв', ''),
(9, 'Виталий', '', 'Andryushkov', 'v_andryushkov', 'C7k6yz', '+7 (963) 6', 'vandryushkov@rbc.ru', ''),
(10, 'проверка ', '', 'Andryushkov', 'p_andryushkov', 'pKEOgz', '+7 (963) 9', 'vit134256@gmail.com', ''),
(11, 'asdasd', 'asdasd1', '123123', 'aa_123123', 'wxhBTU', '+7 (965) 1', 'vit@mail.ru', '123123asdfasd asdasd '),
(12, '', '', '', '_', 'PDnukT', '', '', ''),
(13, 'Иван', 'Иванович', 'Иванов', 'ii_ivanov', 'd3S63i', '+7 (916) 0', 'vit134@mail.ru', 'г. Москва,  ул. Профсоюзная, д. 78'),
(14, 'Виталий', 'бла', 'Королёва', 'vb_koroleva', 'HWAyQ2', '+7 (651) 651-6516', 'iv@e-o.ru', '');

-- --------------------------------------------------------

--
-- Структура таблицы `clients_vs_orders`
--

CREATE TABLE `clients_vs_orders` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `clients_vs_orders`
--

INSERT INTO `clients_vs_orders` (`id`, `client_id`, `order_id`) VALUES
(9, 13, 14),
(10, 10, 15),
(11, 13, 16);

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `comment` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `access` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `name`, `access`) VALUES
(1, 'sales manager', 's'),
(2, 'warehouseman', 'w'),
(3, 'worker', 'wk'),
(4, 'admin', 'a');

-- --------------------------------------------------------

--
-- Структура таблицы `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(200) NOT NULL DEFAULT '',
  `price` varchar(20) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `publish` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `materials`
--

INSERT INTO `materials` (`id`, `name`, `image`, `price`, `unit`, `publish`) VALUES
(24, 'Стяжка пола \"Gerkules GF-17\"', 'http://calc/admin_v2/uploads/235x235-stiajka-dlia-pola-gf-17-gerkules-25-kg.png', '250', 'мешок', 1),
(25, 'Сухая стяжка «Knauf»', 'http://calc/admin_v2/uploads/812x812-dsc07455.jpg', '300', 'мешок', 1),
(26, 'Саморезы для ГВЛ', 'http://calc/admin_v2/uploads/300x300-samorez_gvl2-300x300.jpg', '1', 'шт', 1),
(27, 'Плиты \"Knauf\"', 'http://calc/admin_v2/uploads/260x260-element-pola-knauf (1).d5aa863b.jpg', '360', 'шт', 1),
(28, 'test', 'http://calc/admin_v2/uploads/668x668-oplacheno.png', '123', '123', 1),
(29, 'test update1', 'http://calc/admin_v2/uploads/768x768-Lighthouse.jpg', '123', 'м', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `manager_id` int(11) NOT NULL,
  `obj_type` varchar(20) NOT NULL,
  `obj_adress` varchar(100) NOT NULL,
  `count_of_meters` int(11) NOT NULL,
  `work_price` int(11) NOT NULL,
  `material_price` int(11) NOT NULL,
  `without_materials` tinyint(1) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL,
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_edit` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `client_id`, `manager_id`, `obj_type`, `obj_adress`, `count_of_meters`, `work_price`, `material_price`, `without_materials`, `status`, `date_create`, `date_edit`) VALUES
(14, 13, 40, 'Квартира', 'г. Москва,  ул. Профсоюзная, д. 78', 10, 4230, 406000, 1, 2, '2017-09-26 15:21:58', '2017-09-26 15:21:58'),
(15, 10, 2, '', 'Люберцы строителей 6 кв 134', 4, 3692, 162400, 1, 1, '2017-09-26 15:48:33', '2017-09-26 15:48:33'),
(16, 13, 40, 'Загородный дом', 'г. Королев ул янгеля д.56', 100, 42300, 4060000, 0, 1, '2017-09-28 08:30:26', '2017-09-28 08:30:26');

--
-- Триггеры `orders`
--
DELIMITER $$
CREATE TRIGGER `update_order` AFTER UPDATE ON `orders` FOR EACH ROW IF (OLD.status<>NEW.status) THEN
    INSERT INTO `order_events`(`order_id`,`old`, `new`) VALUES (OLD.id, OLD.status, NEW.status);
END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `orders_vs_service`
--

CREATE TABLE `orders_vs_service` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders_vs_service`
--

INSERT INTO `orders_vs_service` (`id`, `order_id`, `service_id`) VALUES
(77, 14, 48),
(78, 15, 48),
(79, 15, 49),
(80, 16, 48);

-- --------------------------------------------------------

--
-- Структура таблицы `order_events`
--

CREATE TABLE `order_events` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `old` int(11) NOT NULL,
  `new` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `order_events`
--

INSERT INTO `order_events` (`id`, `order_id`, `old`, `new`) VALUES
(3, 14, 1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `services`
--

CREATE TABLE `services` (
  `id` int(100) NOT NULL,
  `categoryId` int(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `publish` tinyint(1) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `services`
--

INSERT INTO `services` (`id`, `categoryId`, `name`, `publish`, `price`) VALUES
(47, 0, 'Бетонная стяжка', 1, 1000),
(48, 0, 'Сухая стяжка «Knauf»', 0, 0),
(49, 0, 'Укладка ламината', 0, 500);

-- --------------------------------------------------------

--
-- Структура таблицы `serv_vs_materials`
--

CREATE TABLE `serv_vs_materials` (
  `id` int(11) NOT NULL,
  `serv_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `count_unit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `serv_vs_subserv`
--

CREATE TABLE `serv_vs_subserv` (
  `id` int(11) NOT NULL,
  `serv_id` int(11) DEFAULT NULL,
  `subserv_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `serv_vs_subserv`
--

INSERT INTO `serv_vs_subserv` (`id`, `serv_id`, `subserv_id`) VALUES
(123, 47, 35),
(124, 47, 36),
(125, 47, 37),
(129, 49, 35),
(130, 49, 36),
(134, 48, 35),
(135, 48, 36),
(136, 48, 38),
(137, 48, 39);

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`id`, `name`, `alias`, `value`) VALUES
(1, 'date_format', 'Формат даты', 'd M Y'),
(2, 'company_name', 'название компании', 'Студия ремонта \"Прорабыч\"'),
(3, 'ip', 'ИП', 'ИП Прораб Прорабович Прорабов'),
(4, 'inn', 'ИНН', '505009147272'),
(5, 'okpo', 'ОКПО', '0175085693'),
(6, 'compnay_phone', 'телефон компании', '+7 (495) 995-88-77');

-- --------------------------------------------------------

--
-- Структура таблицы `statuses`
--

CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `alias` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `statuses`
--

INSERT INTO `statuses` (`id`, `name`, `alias`, `description`) VALUES
(1, 'Новый', 'new', 'Присваивается сразу после создания заказа, если у заказа нет менеджера'),
(2, 'В работе', 'in_process', 'Присваивается заказу в статусе \"новый\", которому назначили менеджера'),
(3, 'Приостановлен', 'pause', 'Присваивается заказу, работа по которому, по каким-либо причинам приостановлена'),
(4, 'Отменен', 'cansel', 'Присваивается заказу который был отменен'),
(5, 'Выполенен', 'ready', 'Присваивается выполненному заказу');

-- --------------------------------------------------------

--
-- Структура таблицы `subservices`
--

CREATE TABLE `subservices` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price_for_unit` int(11) NOT NULL,
  `minute_for_unit` int(11) NOT NULL,
  `publish` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `subservices`
--

INSERT INTO `subservices` (`id`, `name`, `price_for_unit`, `minute_for_unit`, `publish`) VALUES
(35, 'Очистка пола от мусора', 100, 60, 1),
(36, 'Подъем материалов на этаж', 50, 10, 1),
(37, 'Заливка пола раствором', 300, 30, 1),
(38, 'Засыпка материала', 150, 30, 1),
(39, 'Укладка плит «Knauf»', 123, 10, 1),
(40, 'test', 123, 123, 1),
(42, 'проверка создания вида работ', 100, 55, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `subserv_vs_materials`
--

CREATE TABLE `subserv_vs_materials` (
  `id` int(11) NOT NULL,
  `subserv_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `count_of_unit` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `subserv_vs_materials`
--

INSERT INTO `subserv_vs_materials` (`id`, `subserv_id`, `material_id`, `count_of_unit`) VALUES
(41, 38, 25, 10),
(92, 39, 26, 1000),
(93, 39, 24, 150),
(94, 39, 25, 7),
(95, 42, 24, 4),
(96, 42, 25, 500),
(97, 42, 26, 1000),
(98, 37, 24, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `second_name` varchar(20) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `birth_date` date NOT NULL,
  `years_old` int(11) DEFAULT NULL,
  `login` varchar(30) NOT NULL,
  `pass` varchar(200) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `avatar` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `first_name`, `second_name`, `last_name`, `birth_date`, `years_old`, `login`, `pass`, `phone`, `email`, `avatar`, `active`, `last_login`) VALUES
(1, 'Виталий', 'Игоревич', 'Андрюшков', '1990-05-12', 27, 'admin', '61329b692a763d4b8615f692f5826b42', '123123123', 'vit134@mail.ru', 'http://calc/admin_v2/assets/images/avatar/if_rockn_roll_66277.png', 1, '2017-09-27 10:36:21'),
(2, 'Игорь', 'Иванович', 'Андрюшков', '1963-03-02', 54, 'admin2', '8ed3ddd3263f84d1a7793f36a2a2bad6', '9169900696', 'luber.igor@gmail.com', 'http://www.designshock.com/wp-content/uploads/2016/04/man-17-200.jpg', 1, '2017-09-20 16:56:52'),
(40, 'Ольга', 'Анатольевна', 'Королёва', '1969-04-09', 48, 'asd', '61329b692a763d4b8615f692f5826b42', '+7 (916) 051-51-65', 'vit134@mail.ru', 'http://calc/admin_v2/assets/images/avatar/if_supportfemale_403018.svg', 1, '2017-09-28 13:03:11');

-- --------------------------------------------------------

--
-- Структура таблицы `users_vs_groups`
--

CREATE TABLE `users_vs_groups` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users_vs_groups`
--

INSERT INTO `users_vs_groups` (`id`, `user_id`, `group_id`) VALUES
(66, 2, 2),
(67, 2, 1),
(72, 40, 1),
(73, 40, 2),
(74, 1, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `users_vs_orders`
--

CREATE TABLE `users_vs_orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users_vs_orders`
--

INSERT INTO `users_vs_orders` (`id`, `user_id`, `order_id`) VALUES
(11, 40, 14),
(12, 2, 15),
(13, 40, 16);

-- --------------------------------------------------------

--
-- Структура таблицы `_log_orders`
--

CREATE TABLE `_log_orders` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `manager_id` int(11) NOT NULL,
  `obj_type` varchar(20) NOT NULL,
  `obj_adress` varchar(100) NOT NULL,
  `count_of_meters` int(11) NOT NULL,
  `work_price` int(11) NOT NULL,
  `material_price` int(11) NOT NULL,
  `without_materials` tinyint(1) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL,
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_edit` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `_log_order_status`
--

CREATE TABLE `_log_order_status` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `old_status` int(11) NOT NULL,
  `new_status` int(11) NOT NULL,
  `date_edit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `manager` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cat_vs_service`
--
ALTER TABLE `cat_vs_service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `serv_id` (`serv_id`);

--
-- Индексы таблицы `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `clients_vs_orders`
--
ALTER TABLE `clients_vs_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders_vs_service`
--
ALTER TABLE `orders_vs_service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Индексы таблицы `order_events`
--
ALTER TABLE `order_events`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Индексы таблицы `serv_vs_materials`
--
ALTER TABLE `serv_vs_materials`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `serv_vs_subserv`
--
ALTER TABLE `serv_vs_subserv`
  ADD PRIMARY KEY (`id`),
  ADD KEY `serv_id` (`serv_id`);

--
-- Индексы таблицы `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `subservices`
--
ALTER TABLE `subservices`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `subserv_vs_materials`
--
ALTER TABLE `subserv_vs_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subserv_id` (`subserv_id`),
  ADD KEY `material_id` (`material_id`),
  ADD KEY `material_id_2` (`material_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users_vs_groups`
--
ALTER TABLE `users_vs_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_id_2` (`user_id`),
  ADD KEY `user_id_3` (`user_id`);

--
-- Индексы таблицы `users_vs_orders`
--
ALTER TABLE `users_vs_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Индексы таблицы `_log_orders`
--
ALTER TABLE `_log_orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `_log_order_status`
--
ALTER TABLE `_log_order_status`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT для таблицы `cat_vs_service`
--
ALTER TABLE `cat_vs_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;
--
-- AUTO_INCREMENT для таблицы `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT для таблицы `clients_vs_orders`
--
ALTER TABLE `clients_vs_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT для таблицы `orders_vs_service`
--
ALTER TABLE `orders_vs_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT для таблицы `order_events`
--
ALTER TABLE `order_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `services`
--
ALTER TABLE `services`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT для таблицы `serv_vs_materials`
--
ALTER TABLE `serv_vs_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `serv_vs_subserv`
--
ALTER TABLE `serv_vs_subserv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;
--
-- AUTO_INCREMENT для таблицы `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `subservices`
--
ALTER TABLE `subservices`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT для таблицы `subserv_vs_materials`
--
ALTER TABLE `subserv_vs_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT для таблицы `users_vs_groups`
--
ALTER TABLE `users_vs_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
--
-- AUTO_INCREMENT для таблицы `users_vs_orders`
--
ALTER TABLE `users_vs_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT для таблицы `_log_orders`
--
ALTER TABLE `_log_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `_log_order_status`
--
ALTER TABLE `_log_order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cat_vs_service`
--
ALTER TABLE `cat_vs_service`
  ADD CONSTRAINT `cat_vs_service_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cat_vs_service_ibfk_2` FOREIGN KEY (`serv_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `clients_vs_orders`
--
ALTER TABLE `clients_vs_orders`
  ADD CONSTRAINT `clients_vs_orders_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders_vs_service`
--
ALTER TABLE `orders_vs_service`
  ADD CONSTRAINT `orders_vs_service_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `serv_vs_subserv`
--
ALTER TABLE `serv_vs_subserv`
  ADD CONSTRAINT `serv_vs_subserv_ibfk_1` FOREIGN KEY (`serv_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `subserv_vs_materials`
--
ALTER TABLE `subserv_vs_materials`
  ADD CONSTRAINT `subserv_vs_materials_ibfk_2` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subserv_vs_materials_ibfk_1` FOREIGN KEY (`subserv_id`) REFERENCES `subservices` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users_vs_groups`
--
ALTER TABLE `users_vs_groups`
  ADD CONSTRAINT `users_vs_groups_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users_vs_orders`
--
ALTER TABLE `users_vs_orders`
  ADD CONSTRAINT `users_vs_orders_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
