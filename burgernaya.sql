-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 13 2018 г., 16:23
-- Версия сервера: 5.6.38
-- Версия PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `burgernaya`
--

-- --------------------------------------------------------

--
-- Структура таблицы `deliveries`
--

CREATE TABLE `deliveries` (
  `id` tinyint(4) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `deliveries`
--

INSERT INTO `deliveries` (`id`, `name`) VALUES
(1, 'Потребуется сдача'),
(2, 'Оплата по карте');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `street` varchar(150) NOT NULL,
  `home` varchar(50) NOT NULL,
  `part` varchar(50) DEFAULT NULL,
  `appt` varchar(50) DEFAULT NULL,
  `floor` varchar(50) DEFAULT NULL,
  `comment` text,
  `delivery_id` tinyint(4) DEFAULT NULL,
  `is_callback` tinyint(1) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `street`, `home`, `part`, `appt`, `floor`, `comment`, `delivery_id`, `is_callback`, `created`) VALUES
(1, 1, 'Федьковича', '12', NULL, NULL, NULL, NULL, 1, 0, '2018-06-13 14:35:30'),
(2, 2, 'Ахтырская', '4', '2', '1', NULL, 'Доставьте в течении часа', 2, 0, '2018-06-13 14:36:44'),
(3, 3, 'Ленина', '27', '3', '17', '7', 'Можно заказать 2 штуки?\r\nОплачу на месте', 1, 0, '2018-06-13 14:38:24'),
(4, 1, 'Федьковича', '12', NULL, NULL, NULL, NULL, 2, 1, '2018-06-13 14:39:03'),
(5, 1, 'Пушкина', '43', '2', '23', '3', 'Перезвоните мне', 2, 1, '2018-06-13 14:39:59');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(18) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `phone`, `created`) VALUES
(1, 'fedorenkos@mail.ru', 'Сергей Федоренко', '+7 (023) 242 42 44', '2018-06-13 14:35:30'),
(2, 'ribalchenko@gmail.com', 'Евгений Жыбальченко', '+7 (324) 235 23 55', '2018-06-13 14:36:44'),
(3, 'dudka.valya@yandex.ru', 'Валентина Дудка', '+7 (234) 235 23 53', '2018-06-13 14:38:24');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `delivery_id` (`delivery_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
