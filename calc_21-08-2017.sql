-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Время создания: Авг 21 2017 г., 14:23
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
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Полы'),
(6, 'Потолки'),
(2, 'Стены'),
(5, 'Электрика');

-- --------------------------------------------------------

--
-- Структура таблицы `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `subserv_id` int(100) NOT NULL,
  `image` varchar(200) NOT NULL,
  `price` varchar(20) NOT NULL,
  `unit` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `materials`
--

INSERT INTO `materials` (`id`, `name`, `subserv_id`, `image`, `price`, `unit`) VALUES
(1, 'кувалда', 5, 'http://placekitten.com/150/90', '1', 'шт'),
(2, 'перфоратор', 5, 'http://placekitten.com/150/90', '100', 'шт'),
(3, 'зубило', 5, 'http://placekitten.com/150/90', '4', 'шт');

-- --------------------------------------------------------

--
-- Структура таблицы `services`
--

CREATE TABLE `services` (
  `id` int(100) NOT NULL,
  `categoryId` int(100) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `services`
--

INSERT INTO `services` (`id`, `categoryId`, `name`) VALUES
(1, 2, 'Покраска стен'),
(2, 2, 'Оклейка обоями'),
(3, 1, 'Укладка ламината'),
(4, 1, 'Бетонная стяжка полов'),
(5, 1, 'Сухая стяжка полов'),
(6, 1, 'Укладка паркета'),
(7, 2, 'Декоративная штукатурка'),
(17, 5, 'Установка розеток'),
(18, 5, 'Замена электрики'),
(19, 5, 'Установка люстры'),
(20, 6, 'Натяжные потолки'),
(21, 6, 'Покраска потолков'),
(22, 5, 'штроба под кабель');

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
(1, 1, 13),
(2, 2, 12),
(3, 1, 12),
(4, 2, 13),
(7, 1, 1),
(8, 1, 3),
(9, 1, 4),
(10, 2, 1),
(11, 2, 6),
(12, 18, 1),
(13, 18, 5),
(14, 18, 9),
(15, 3, NULL),
(16, 3, NULL),
(17, 4, NULL),
(18, 5, NULL),
(19, 6, NULL),
(20, 7, NULL),
(21, 8, NULL),
(22, 9, NULL),
(23, 20, NULL),
(24, 21, NULL),
(25, 2, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `subservices`
--

CREATE TABLE `subservices` (
  `id` int(100) NOT NULL,
  `serviceId` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price_for_unit` int(11) NOT NULL,
  `minute_for_unit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `subservices`
--

INSERT INTO `subservices` (`id`, `serviceId`, `name`, `price_for_unit`, `minute_for_unit`) VALUES
(1, 1, 'Демонтаж старых обоев', 150, 60),
(3, 2, 'Финишная грунтовка стен', 200, 60),
(4, 4, 'Удаление старых лаг', 200, 60),
(5, 3, 'сломать все к чертям', 150, 150),
(6, 3, 'и еще раз все сломать', 150, 150),
(7, 5, 'снять страрый пол', 100, 100),
(8, 5, 'уложить подложку', 15, 15),
(9, 5, 'уложить ламинат', 100, 100),
(10, 5, 'закрепить плинтус', 15, 15),
(11, 2, 'Выравнивание стен', 1, 1),
(12, 2, 'Грунтовка стен', 1, 1),
(13, 2, 'шкурение стеныфы', 1, 1),
(14, 2, 'Шпатлевка стен', 1, 1),
(19, 18, 'штробление стен под кабель', 150, 112);

-- --------------------------------------------------------

--
-- Структура таблицы `subserv_vs_materials`
--

CREATE TABLE `subserv_vs_materials` (
  `id` int(11) NOT NULL,
  `subserv_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `subserv_vs_materials`
--

INSERT INTO `subserv_vs_materials` (`id`, `subserv_id`, `material_id`) VALUES
(1, 12, 1),
(2, 12, 2),
(3, 12, 3),
(4, 13, 1),
(5, 13, 3),
(6, 1, 2),
(7, 6, 3);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Индексы таблицы `materials`
--
ALTER TABLE `materials`
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
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT для таблицы `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `services`
--
ALTER TABLE `services`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT для таблицы `serv_vs_subserv`
--
ALTER TABLE `serv_vs_subserv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT для таблицы `subservices`
--
ALTER TABLE `subservices`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT для таблицы `subserv_vs_materials`
--
ALTER TABLE `subserv_vs_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
