CREATE TABLE user_session (
    id int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    user_session varchar(128) NOT NULL,
    user_id varchar(128) NOT NULL,
    loginTime timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);