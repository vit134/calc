-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Время создания: Сен 06 2017 г., 19:00
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
(46, 'Потолки', 1, ''),
(47, 'test', 1, '');

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
(47, 39, 35),
(55, 40, 38),
(60, 39, 38),
(61, 44, 35),
(63, 46, 35),
(64, 46, 38),
(66, 47, 35),
(67, 47, 38),
(76, 40, 45),
(77, 45, 45),
(78, 39, 42);

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
  `phone` varchar(10) NOT NULL,
  `email` varchar(20) NOT NULL,
  `address` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `clients_vs_orders`
--

CREATE TABLE `clients_vs_orders` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `image` varchar(200) NOT NULL DEFAULT 'https://www.clker.com/cliparts/B/u/S/l/W/l/no-photo-available-hi.png',
  `price` varchar(20) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `publish` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `materials`
--

INSERT INTO `materials` (`id`, `name`, `image`, `price`, `unit`, `publish`) VALUES
(4, 'цемент', 'http://www.tk-sm.ru/photos/160542_040813cement.jpg', '250', 'мешок', 0),
(5, 'ламинат', 'http://budmaydan.kiev.ua/assets/images/laminat.png', '800', 'м. кв', 0),
(6, 'подложка для ламината', 'http://st19.stpulscen.ru/images/product/085/994/097_medium.png', '150', 'м. кв', 0),
(7, 'самовыравнивающаяся смесь', 'https://www.clker.com/cliparts/B/u/S/l/W/l/no-photo-available-hi.png', '300', 'мешок', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `manager_id` int(11) NOT NULL,
  `price_total` int(11) NOT NULL,
  `time_total` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_edit` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(35, 0, 'услуга 2', 1, 0),
(38, 0, 'Сухая стяжка пола', 1, 0),
(42, 0, 'тест услуги без категории', 1, 0),
(45, 0, 'проверка создания услуги', 1, 0);

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
(57, 42, 29),
(58, 42, 30),
(78, 38, 26),
(79, 38, 29),
(80, 38, 30),
(87, 45, 40),
(88, 45, 45),
(89, 45, 29),
(90, 45, 30),
(91, 35, 26),
(92, 35, 29),
(93, 35, 31),
(94, 35, 32),
(95, 38, 32),
(96, 42, 32),
(97, 45, 32),
(98, 38, 33);

-- --------------------------------------------------------

--
-- Структура таблицы `statuses`
--

CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(26, 'test', 100, 60, 0),
(29, 'Тест редактирования вида работ', 321, 123, 1),
(30, 'подъем материалов на этаж', 50, 5, 1),
(31, 'грунтовка стен', 150, 60, 1),
(32, 'тест создания вида работ', 123, 321, 1),
(33, 'тест создания вида работ 2', 12312, 321, 1),
(34, '123123', 123, 123, 0);

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
(8, 35, 27, 1),
(9, 27, 5, 1),
(10, 35, 29, 1),
(11, 38, 29, 1),
(14, 35, 32, 1),
(15, 38, 32, 1),
(16, 42, 32, 1),
(17, 45, 32, 1),
(18, 32, 4, 1),
(19, 32, 5, 1),
(20, 32, 6, 1),
(21, 32, 7, 1),
(22, 38, 33, 1),
(23, 33, 5, 1),
(31, 29, 4, 1),
(32, 29, 6, 1),
(33, 29, 7, 1),
(34, 31, 5, 1),
(35, 26, 7, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `second_name` varchar(20) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `login` varchar(30) NOT NULL,
  `pass` varchar(200) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(20) NOT NULL,
  `avatar` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `first_name`, `second_name`, `last_name`, `login`, `pass`, `phone`, `email`, `avatar`, `active`) VALUES
(1, 'Виталий', 'Игоревич', 'Андрюшков', 'admin', 'd41d8cd98f00b204e9800998ecf8427e', '9639947066', 'vit134@mail.ru', 'http://www.designshock.com/wp-content/uploads/2016/04/man-1-200.jpg', 1),
(2, 'Игорь', 'Иванович', 'Андрюшков', 'admin2', 'd41d8cd98f00b204e9800998ecf8427e', '9169900696', 'luber.igor@gmail.com', 'http://www.designshock.com/wp-content/uploads/2016/04/man-17-200.jpg', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users_vs_groups`
--

CREATE TABLE `users_vs_groups` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users_vs_groups`
--

INSERT INTO `users_vs_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 4),
(4, 1, 3),
(5, 2, 2);

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
  ADD PRIMARY KEY (`id`);

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
-- Индексы таблицы `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Индексы таблицы `serv_vs_subserv`
--
ALTER TABLE `serv_vs_subserv`
  ADD PRIMARY KEY (`id`),
  ADD KEY `serv_id` (`serv_id`);

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
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users_vs_groups`
--
ALTER TABLE `users_vs_groups`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users_vs_orders`
--
ALTER TABLE `users_vs_orders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT для таблицы `cat_vs_service`
--
ALTER TABLE `cat_vs_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT для таблицы `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `clients_vs_orders`
--
ALTER TABLE `clients_vs_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `services`
--
ALTER TABLE `services`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT для таблицы `serv_vs_subserv`
--
ALTER TABLE `serv_vs_subserv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;
--
-- AUTO_INCREMENT для таблицы `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `subservices`
--
ALTER TABLE `subservices`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT для таблицы `subserv_vs_materials`
--
ALTER TABLE `subserv_vs_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `users_vs_groups`
--
ALTER TABLE `users_vs_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `users_vs_orders`
--
ALTER TABLE `users_vs_orders`
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
-- Ограничения внешнего ключа таблицы `serv_vs_subserv`
--
ALTER TABLE `serv_vs_subserv`
  ADD CONSTRAINT `serv_vs_subserv_ibfk_1` FOREIGN KEY (`serv_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
