-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 29 2022 г., 17:25
-- Версия сервера: 5.7.38
-- Версия PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `calendar_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `event`
--

CREATE TABLE `event` (
  `event_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `day` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `month` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `event`
--

INSERT INTO `event` (`event_id`, `title`, `description`, `phone`, `color`, `day`, `month`, `year`, `time`, `author_id`, `group_id`) VALUES
(1, '', '', '', '', '', '', '', '', 29, 27),
(2, '123', '213', '321', '231', '3', '523', '321', '321', 29, 27),
(3, '1321111123', '213', '321', '231', '3', '5', '321', '321', 4, 27);

-- --------------------------------------------------------

--
-- Структура таблицы `group`
--

CREATE TABLE `group` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` int(11) NOT NULL,
  `img` int(11) DEFAULT NULL,
  `user_limit` int(11) NOT NULL DEFAULT '3',
  `user_count` int(11) NOT NULL DEFAULT '1',
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_private` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `group`
--

INSERT INTO `group` (`group_id`, `group_name`, `author_id`, `img`, `user_limit`, `user_count`, `link`, `code`, `is_private`) VALUES
(27, 'test2454443', 4, NULL, 3, 2, 'a2eca978c8c376d31e055ede18ef712e', '7ce6a8', 0);

--
-- Триггеры `group`
--
DELIMITER $$
CREATE TRIGGER `Add Admin` AFTER INSERT ON `group` FOR EACH ROW INSERT INTO `group_user` VALUES(NULL, NEW.`group_id`, NEW.`author_id`, 4)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `group_user`
--

CREATE TABLE `group_user` (
  `group_user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_access` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `group_user`
--

INSERT INTO `group_user` (`group_user_id`, `group_id`, `user_id`, `user_access`) VALUES
(1, 27, 4, 4),
(5, 27, 29, 1);

--
-- Триггеры `group_user`
--
DELIMITER $$
CREATE TRIGGER `Add group to user` AFTER INSERT ON `group_user` FOR EACH ROW UPDATE `user` SET `group_id` = NEW.`group_id` WHERE `user_id` = NEW.`user_id`
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Decrement count` AFTER DELETE ON `group_user` FOR EACH ROW UPDATE `group` SET `user_count` = (SELECT COUNT(*) FROM `group_user` WHERE `group_user`.`group_id` = `group`.`group_id`) WHERE `group_id` = OLD.`group_id`
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Increment count` AFTER INSERT ON `group_user` FOR EACH ROW UPDATE `group` SET `user_count` = (SELECT COUNT(*) FROM `group_user` WHERE `group_user`.`group_id` = `group`.`group_id`) WHERE `group_id` = NEW.`group_id`
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `session` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `psuid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`user_id`, `login`, `email`, `password`, `session`, `psuid`, `group_id`) VALUES
(4, 'test', 'test@gmail.com', '$2y$10$iuy6AacWOviNcSuk0vNgmuxc6WWEibY3LUhpLvRmfD4mSJly3F5cS', '349c310b71ccdffda34bb4776f29b96b', '1653758966', 27),
(29, 'test1', 'test1@gmail.test', '$2y$10$pBQCFf3/9aD4g9CIDVAHBeTg4je8APmJiiPwVXP8ppdRzWGZ9t4rG', 'b9286e86a2de7ab5da45661ed73d89ff', '1653771164', 27);

--
-- Триггеры `user`
--
DELIMITER $$
CREATE TRIGGER `Add group event` AFTER UPDATE ON `user` FOR EACH ROW UPDATE `event` SET `group_id` = NEW.`group_id` WHERE `author_id` = NEW.`user_id`
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Create user info` AFTER INSERT ON `user` FOR EACH ROW INSERT INTO `user_info` (`user_info_id`, `first_name`, `last_name`, `birthday`, `avatar`, `user_id`) VALUES (NULL, NULL, NULL, NULL, NULL, NEW.`user_id`)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Delete user` BEFORE DELETE ON `user` FOR EACH ROW DELETE FROM `user_info` WHERE OLD.`user_id` = `user_id`
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `user_access`
--

CREATE TABLE `user_access` (
  `user_access_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_access`
--

INSERT INTO `user_access` (`user_access_id`, `type`) VALUES
(1, 'only_watch'),
(2, 'only_record'),
(3, 'record_event'),
(4, 'full');

-- --------------------------------------------------------

--
-- Структура таблицы `user_info`
--

CREATE TABLE `user_info` (
  `user_info_id` int(11) NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` int(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_info`
--

INSERT INTO `user_info` (`user_info_id`, `first_name`, `last_name`, `birthday`, `avatar`, `user_id`) VALUES
(24, NULL, NULL, NULL, NULL, 29);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Индексы таблицы `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`group_id`),
  ADD KEY `user_id` (`author_id`);

--
-- Индексы таблицы `group_user`
--
ALTER TABLE `group_user`
  ADD PRIMARY KEY (`group_user_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_access` (`user_access`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Индексы таблицы `user_access`
--
ALTER TABLE `user_access`
  ADD PRIMARY KEY (`user_access_id`);

--
-- Индексы таблицы `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`user_info_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `event`
--
ALTER TABLE `event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `group`
--
ALTER TABLE `group`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `group_user`
--
ALTER TABLE `group_user`
  MODIFY `group_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `user_access`
--
ALTER TABLE `user_access`
  MODIFY `user_access_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `user_info`
--
ALTER TABLE `user_info`
  MODIFY `user_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `group` (`group_id`),
  ADD CONSTRAINT `event_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `user` (`user_id`);

--
-- Ограничения внешнего ключа таблицы `group`
--
ALTER TABLE `group`
  ADD CONSTRAINT `group_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `user` (`user_id`);

--
-- Ограничения внешнего ключа таблицы `group_user`
--
ALTER TABLE `group_user`
  ADD CONSTRAINT `group_user_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `group` (`group_id`),
  ADD CONSTRAINT `group_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `group_user_ibfk_3` FOREIGN KEY (`user_access`) REFERENCES `user_access` (`user_access_id`);

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `group` (`group_id`);

--
-- Ограничения внешнего ключа таблицы `user_info`
--
ALTER TABLE `user_info`
  ADD CONSTRAINT `user_info_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
