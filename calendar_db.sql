SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `event` (
  `event_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `phone` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '0',
  `day` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `time` varchar(255) NOT NULL,
  `author_id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL
);

CREATE TABLE `group` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `author_id` int(11) NOT NULL,
  `img` int(11) DEFAULT NULL,
  `user_limit` int(11) NOT NULL DEFAULT '3',
  `user_count` int(11) NOT NULL DEFAULT '1',
  `link` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `is_private` tinyint(1) NOT NULL DEFAULT '1'
);

INSERT INTO `group` (`group_id`, `group_name`, `author_id`, `img`, `user_limit`, `user_count`, `link`, `code`, `is_private`) VALUES
(27, 'test2454443', 4, NULL, 3, 2, 'a2eca978c8c376d31e055ede18ef712e', '7ce6a8', 0);

DELIMITER $$
CREATE TRIGGER `Add Admin` AFTER INSERT ON `group` FOR EACH ROW INSERT INTO `group_user` VALUES(NULL, NEW.`group_id`, NEW.`author_id`, 4)
$$
DELIMITER ;

CREATE TABLE `group_user` (
  `group_user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_access` int(11) NOT NULL DEFAULT '1'
);

INSERT INTO `group_user` (`group_user_id`, `group_id`, `user_id`, `user_access`) VALUES
(1, 27, 4, 4),
(7, 27, 29, 1);

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
DELIMITER $$
CREATE TRIGGER `Remove user` BEFORE DELETE ON `group_user` FOR EACH ROW UPDATE `user` SET `group_id` = NULL WHERE `user_id` = OLD.`user_id`
$$
DELIMITER ;

CREATE TABLE `note` (
  `note_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `phone` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '0',
  `day` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL
);

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `session` varchar(255) NOT NULL,
  `psuid` varchar(255) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL
);

DELIMITER $$
CREATE TRIGGER `Create user info` AFTER INSERT ON `user` FOR EACH ROW INSERT INTO `user_info` (`user_info_id`, `first_name`, `last_name`, `birthday`, `avatar`, `user_id`) VALUES (NULL, NULL, NULL, NULL, NULL, NEW.`user_id`)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Delete user` BEFORE DELETE ON `user` FOR EACH ROW DELETE FROM `user_info` WHERE OLD.`user_id` = `user_id`
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Update group event` AFTER UPDATE ON `user` FOR EACH ROW UPDATE `event` SET `group_id` = NEW.`group_id` WHERE `author_id` = NEW.`user_id`
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Update group note` AFTER INSERT ON `user` FOR EACH ROW UPDATE `note` SET `group_id` = NEW.`group_id` WHERE `author_id` = NEW.`user_id`
$$
DELIMITER ;

CREATE TABLE `user_access` (
  `user_access_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL
);

INSERT INTO `user_access` (`user_access_id`, `type`) VALUES
(1, 'only_watch'),
(2, 'only_record'),
(3, 'record_event'),
(4, 'full');

CREATE TABLE `user_info` (
  `user_info_id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` int(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL
);

INSERT INTO `user_info` (`user_info_id`, `first_name`, `last_name`, `birthday`, `avatar`, `user_id`) VALUES
(24, NULL, NULL, NULL, NULL, 29);

ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `author_id` (`author_id`);

ALTER TABLE `group`
  ADD PRIMARY KEY (`group_id`),
  ADD KEY `user_id` (`author_id`);

ALTER TABLE `group_user`
  ADD PRIMARY KEY (`group_user_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_access` (`user_access`);

ALTER TABLE `note`
  ADD PRIMARY KEY (`note_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `author_id` (`author_id`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `group_id` (`group_id`);

ALTER TABLE `user_access`
  ADD PRIMARY KEY (`user_access_id`);

ALTER TABLE `user_info`
  ADD PRIMARY KEY (`user_info_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `group`
--
ALTER TABLE `group`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `group_user`
  MODIFY `group_user_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `note`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_access`
  MODIFY `user_access_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_info`
  MODIFY `user_info_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `group` (`group_id`),
  ADD CONSTRAINT `event_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `user` (`user_id`);

ALTER TABLE `group`
  ADD CONSTRAINT `group_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `user` (`user_id`);

ALTER TABLE `group_user`
  ADD CONSTRAINT `group_user_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `group` (`group_id`),
  ADD CONSTRAINT `group_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `group_user_ibfk_3` FOREIGN KEY (`user_access`) REFERENCES `user_access` (`user_access_id`);

ALTER TABLE `note`
  ADD CONSTRAINT `note_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `group` (`group_id`),
  ADD CONSTRAINT `note_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `user` (`user_id`);

ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `group` (`group_id`);

ALTER TABLE `user_info`
  ADD CONSTRAINT `user_info_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;