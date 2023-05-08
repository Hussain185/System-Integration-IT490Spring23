ALTER TABLE users
ADD COLUMN otp varchar(6) DEFAULT NULL AFTER usersPwd,
ADD COLUMN otp_expiration datetime DEFAULT NULL AFTER otp,
ADD COLUMN date_created datetime NOT NULL DEFAULT current_timestamp() AFTER usersPwd;
