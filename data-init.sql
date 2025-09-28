BEGIN;
CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, username TEXT, email TEXT, bio TEXT, secret_note TEXT);
CREATE TABLE comments (id INTEGER PRIMARY KEY AUTOINCREMENT, comment TEXT);

INSERT INTO users (username, email, bio, secret_note) VALUES
('alice','alice@example.com','I love tea','flag{thm_idor_01_secret_for_alice}'),
('bob','bob@example.com','I fix servers','flag{thm_idor_02_secret_for_bob}'),
('admin','admin@example.com','Site admin','flag{thm_admin_super_secret}');

INSERT INTO comments (comment) VALUES
('Welcome to VulnApp!'),
('Try posting something <script>alert(1)</script>');

-- Put the SQLi flag in a user bio so SQLi can leak it
INSERT INTO users (username, email, bio, secret_note) VALUES ('sqli_victim', 'sqli@local', 'FLAG: flag{thm_sqli_01}', 'n/a');

COMMIT;
