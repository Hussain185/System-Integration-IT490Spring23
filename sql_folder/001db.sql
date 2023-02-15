CREATE DATABASE IT490Project;
USE IT490Project;
CREATE TABLE users (
	Id int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
	userName varchar(128) NOT NULL,
	userEmail varchar(128) NOT NULL,
	userId varchar(128) NOT NULL,
	userPass varchar(128) NOT NULL
);
