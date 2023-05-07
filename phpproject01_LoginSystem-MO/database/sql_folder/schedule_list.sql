CREATE TABLE `schedule_list` (
  `id` int(30) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `usersUid` varchar(128) NOT NULL,
  FOREIGN KEY (usersUid) REFERENCES users(usersUid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;