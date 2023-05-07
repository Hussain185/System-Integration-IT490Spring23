CREATE TABLE `todolists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usersUid` varchar(128) NOT NULL,
  FOREIGN KEY (usersUid) REFERENCES users(usersUid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;