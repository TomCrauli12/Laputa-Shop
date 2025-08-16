-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 16 2025 г., 18:01
-- Версия сервера: 10.3.13-MariaDB
-- Версия PHP: 7.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `laputa`
--

-- --------------------------------------------------------

--
-- Структура таблицы `basket`
--

CREATE TABLE `basket` (
  `id` int(11) NOT NULL,
  `product_id` varchar(100) DEFAULT NULL,
  `user_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `basket`
--

INSERT INTO `basket` (`id`, `product_id`, `user_id`) VALUES
(15, '35', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `categoryName` varchar(250) NOT NULL,
  `categoryBDName` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `categoryName`, `categoryBDName`) VALUES
(1, 'Новые товары', 'newPoduct'),
(2, 'Манга', 'manga'),
(3, 'Скидки', 'sale');

-- --------------------------------------------------------

--
-- Структура таблицы `favourites`
--

CREATE TABLE `favourites` (
  `id` int(11) NOT NULL,
  `product_id` varchar(100) DEFAULT NULL,
  `user_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `favourites`
--

INSERT INTO `favourites` (`id`, `product_id`, `user_id`) VALUES
(12, '33', '3'),
(13, '35', '3'),
(27, '35', '1'),
(32, '40', '1'),
(33, '3', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `infoblock`
--

CREATE TABLE `infoblock` (
  `id` int(11) NOT NULL,
  `infoBlockName` varchar(250) NOT NULL,
  `infoBlockDBName` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `infoblock`
--

INSERT INTO `infoblock` (`id`, `infoBlockName`, `infoBlockDBName`) VALUES
(1, 'Новые товары', 'NewProduct'),
(2, 'Распродажа', 'sale'),
(3, 'Спецзаказы', 'SpecialOrders');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `descr` text DEFAULT NULL,
  `price` double DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `files` varchar(100) DEFAULT NULL,
  `categorytwo` varchar(100) DEFAULT NULL,
  `info_block` varchar(100) DEFAULT NULL,
  `files_2` varchar(100) DEFAULT NULL,
  `files_3` varchar(100) DEFAULT NULL,
  `files_4` varchar(100) DEFAULT NULL,
  `files_5` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `title`, `descr`, `price`, `category`, `files`, `categorytwo`, `info_block`, `files_2`, `files_3`, `files_4`, `files_5`) VALUES
(1, 'Новый товар', 'Описание нового товара', 1200, 'Новые товары', '6890c04c9324d5.17226150.jpg', '', 'Новые товары', '6890c04c934163.60925905.jpg', '6890c04c9357a1.11513182.jpg', '', ''),
(2, 'Манга (новый товар)', 'Манга описание', 800, 'manga', '6890c088e048e2.63108987.jpg', '', 'NewProduct', '6890c088e05bc5.74440025.jpg', '6890c088e06ab7.55591184.jpg', '', ''),
(3, 'манга(распродажа)', 'манга описание', 700, 'manga', '6890df155d40a5.10097430.jpg', '', 'sale', '6890df155d5c33.82655800.jpg', '6890df155d7519.50397276.jpg', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `sliders`
--

CREATE TABLE `sliders` (
  `id` int(11) NOT NULL,
  `imageslider` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `sliders`
--

INSERT INTO `sliders` (`id`, `imageslider`) VALUES
(1, '688d00234b2244.92775022.jpg'),
(2, '688d0329010dc8.26739713.jpg'),
(3, '688d032e448427.16128786.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(100) DEFAULT NULL,
  `name` varchar(250) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `name`, `password`, `role`) VALUES
(1, 'qw', 'qw', '006d2143154327a64d86a264aea225f3', 'admin'),
(2, 'user', 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'user');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `basket`
--
ALTER TABLE `basket`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `infoblock`
--
ALTER TABLE `infoblock`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `basket`
--
ALTER TABLE `basket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `favourites`
--
ALTER TABLE `favourites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT для таблицы `infoblock`
--
ALTER TABLE `infoblock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
