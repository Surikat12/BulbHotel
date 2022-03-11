-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Июн 04 2020 г., 01:39
-- Версия сервера: 5.6.43-84.3-log
-- Версия PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `surikat12y`
--
CREATE DATABASE IF NOT EXISTS `surikat12y` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `surikat12y`;

-- --------------------------------------------------------

--
-- Структура таблицы `Admins`
--

CREATE TABLE `Admins` (
  `nickname` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Admins`
--

INSERT INTO `Admins` (`nickname`, `password`) VALUES
('admin', 'admin'),
('admin2', 'admin2'),
('admin3', 'admin3');

-- --------------------------------------------------------

--
-- Структура таблицы `Reservations`
--

CREATE TABLE `Reservations` (
  `id` int(11) NOT NULL,
  `nickname` varchar(64) NOT NULL,
  `room_number` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Reservations`
--

INSERT INTO `Reservations` (`id`, `nickname`, `room_number`, `start_date`, `end_date`) VALUES
(2, 'aaa', 1, '2020-06-19', '2020-06-21'),
(3, 'aaa', 1, '2020-06-05', '2020-06-07'),
(4, 'bbb', 7, '2020-06-12', '2020-06-22'),
(5, 'ccc', 5, '2020-06-08', '2020-06-14'),
(6, 'aaa', 1, '2020-06-12', '2020-06-14'),
(7, 'aaa', 15, '2020-06-24', '2020-06-27');

-- --------------------------------------------------------

--
-- Структура таблицы `Rooms`
--

CREATE TABLE `Rooms` (
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Rooms`
--

INSERT INTO `Rooms` (`number`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14),
(15),
(16),
(17),
(18),
(19),
(20);

-- --------------------------------------------------------

--
-- Структура таблицы `Users`
--

CREATE TABLE `Users` (
  `nickname` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `patronymic` varchar(64) DEFAULT NULL,
  `birthday` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица с информацией о пользователях';

--
-- Дамп данных таблицы `Users`
--

INSERT INTO `Users` (`nickname`, `email`, `password`, `name`, `lastname`, `patronymic`, `birthday`) VALUES
('aaa', 'S12@yandex.ru', '123', 'Владислав', 'Калдин', 'Владимирович', '2001-01-18'),
('bbb', 'wolf322@mail.ru', '123', 'Иван', 'Иванов', 'Иванович', '2002-02-02'),
('ccc', 'helpme@yandex.ru', '123', 'Игорь', 'Петров', 'Степанович', '1998-06-05');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Admins`
--
ALTER TABLE `Admins`
  ADD PRIMARY KEY (`nickname`);

--
-- Индексы таблицы `Reservations`
--
ALTER TABLE `Reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nickname` (`nickname`),
  ADD KEY `room_number` (`room_number`);

--
-- Индексы таблицы `Rooms`
--
ALTER TABLE `Rooms`
  ADD PRIMARY KEY (`number`);

--
-- Индексы таблицы `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`nickname`),
  ADD UNIQUE KEY `email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Reservations`
--
ALTER TABLE `Reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `Reservations`
--
ALTER TABLE `Reservations`
  ADD CONSTRAINT `Reservations_ibfk_1` FOREIGN KEY (`nickname`) REFERENCES `Users` (`nickname`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Reservations_ibfk_2` FOREIGN KEY (`room_number`) REFERENCES `Rooms` (`number`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
