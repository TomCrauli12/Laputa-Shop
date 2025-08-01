-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 10 2025 г., 16:02
-- Версия сервера: 8.0.30
-- Версия PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `id` int NOT NULL,
  `product_id` varchar(100) DEFAULT NULL,
  `user_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `basket`
--

INSERT INTO `basket` (`id`, `product_id`, `user_id`) VALUES
(15, '35', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `favourites`
--

CREATE TABLE `favourites` (
  `id` int NOT NULL,
  `product_id` varchar(100) DEFAULT NULL,
  `user_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `favourites`
--

INSERT INTO `favourites` (`id`, `product_id`, `user_id`) VALUES
(12, '33', '3'),
(13, '35', '3'),
(27, '35', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `descr` text,
  `price` double DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `files` varchar(100) DEFAULT NULL,
  `categorytwo` varchar(100) DEFAULT NULL,
  `info_block` varchar(100) DEFAULT NULL,
  `files_2` varchar(100) DEFAULT NULL,
  `files_3` varchar(100) DEFAULT NULL,
  `files_4` varchar(100) DEFAULT NULL,
  `files_5` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `title`, `descr`, `price`, `category`, `files`, `categorytwo`, `info_block`, `files_2`, `files_3`, `files_4`, `files_5`) VALUES
(33, 'Новый товар манга', 'йцу', 1200, 'йцу', '_uq7wWEJAHwl8KAeZtXW2kWIqKvtHTErFlmjX7-8lMSo0aZCoWyq_fnDwELMYMjWG9JpTGePbVCiFl1H8Gu37Knf.jpg', 'йцу', 'Новые товары', '', '', '', ''),
(34, 'Скидка фигурка', 'манга ', 1000, '2133', 'pA6qR2sbP9w.jpg', 'йцу', 'Скидки', '', '', '', ''),
(35, 'Предзаказ брелка ', '123', 700, 'манга', 'Sb5YaG61mFxjt1vRw_0h5y-PErKyOgMSySg8Bq3Dr02QC9976Ili09uD-6Z0tikDNV8ciXskaBYqVtJlkk8mGbur.jpg', 'манга', 'Предзаказы', '', '', '', ''),
(36, 'Распродажа Хаори', 'хаори что то там ', 1800, 'Одежда ', 'UB5K6dStX1EtWs8dQLkA8xvLFTFGO1-5ma7p7sh5pVj4zkzVsTsG_ZvrzVrbF-Mw-Ye-x2v7B-Vc61JILt7RYs4t.jpg', 'Хаори', 'Распродажа', '', '', '', ''),
(37, 'Евангелион том 1', 'Манга Евангелион', 1200, 'Манга', 'UB5K6dStX1EtWs8dQLkA8xvLFTFGO1-5ma7p7sh5pVj4zkzVsTsG_ZvrzVrbF-Mw-Ye-x2v7B-Vc61JILt7RYs4t.jpg', 'Манга', NULL, '', '', '', ''),
(38, '123', '123', 123, NULL, '_uq7wWEJAHwl8KAeZtXW2kWIqKvtHTErFlmjX7-8lMSo0aZCoWyq_fnDwELMYMjWG9JpTGePbVCiFl1H8Gu37Knf.jpg', NULL, 'Распродажа', '', '', '', ''),
(39, '123123', '12312', 123321, NULL, 'Sb5YaG61mFxjt1vRw_0h5y-PErKyOgMSySg8Bq3Dr02QC9976Ili09uD-6Z0tikDNV8ciXskaBYqVtJlkk8mGbur.jpg', NULL, 'Распродажа', '', '', '', ''),
(40, 'йцуйц', 'йцуцйуйцу', 123, NULL, 'pA6qR2sbP9w.jpg', NULL, 'Распродажа', '', '', '', ''),
(41, 'asd', 'asd', 123, NULL, '_uq7wWEJAHwl8KAeZtXW2kWIqKvtHTErFlmjX7-8lMSo0aZCoWyq_fnDwELMYMjWG9JpTGePbVCiFl1H8Gu37Knf.jpg', NULL, 'Распродажа', '', '', '', ''),
(42, 'qweqwe', 'qweqwe', 123, NULL, '_uq7wWEJAHwl8KAeZtXW2kWIqKvtHTErFlmjX7-8lMSo0aZCoWyq_fnDwELMYMjWG9JpTGePbVCiFl1H8Gu37Knf.jpg', NULL, 'Распродажа', '', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `login` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `login`, `password`) VALUES
(1, 'qw', 'qw'),
(3, 'as', 'as');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `basket`
--
ALTER TABLE `basket`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `basket`
--
ALTER TABLE `basket`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `favourites`
--
ALTER TABLE `favourites`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
