CREATE TABLE posts (
	postsId int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
	userId int(11) NOT NULL,
	title varchar(255) NOT NULL,
	content text NOT NULL,
	created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	image varchar(255) DEFAULT NULL,
	FOREIGN KEY (userId) REFERENCES users(usersId)
);