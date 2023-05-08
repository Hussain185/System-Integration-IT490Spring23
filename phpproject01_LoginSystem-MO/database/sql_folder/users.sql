CREATE TABLE `users` (
	`usersId` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
	`usersName` varchar(128) NOT NULL,
	`usersEmail` varchar(128) NOT NULL,
	`usersUid` varchar(128) NOT NULL,
	`usersPwd` varchar(128) NOT NULL,
    `otp` varchar(6) DEFAULT NULL,
  	`otp_expiration` datetime DEFAULT NULL,
  	`date_created` datetime NOT NULL DEFAULT current_timestamp(),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
