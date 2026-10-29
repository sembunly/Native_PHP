INSERT INTO users (username, password, status)
VALUES ('admin', '1', 1);

-- This preserves the original local demo credentials. The first successful login
-- upgrades the legacy password to a password_hash() value automatically.
