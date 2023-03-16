ALTER TABLE user_session MODIFY loginTime BIGINT NOT NULL DEFAULT 0;
UPDATE user_session SET loginTime = UNIX_TIMESTAMP();

