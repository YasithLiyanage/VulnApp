BEGIN;
CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, username TEXT, email TEXT, bio TEXT, secret_note TEXT);
CREATE TABLE comments (id INTEGER PRIMARY KEY AUTOINCREMENT, comment TEXT);

INSERT INTO users (username, email, bio, secret_note) VALUES
('alice','alice@example.com','I love tea','Good Luck finding my secret!'),
('bob','bob@example.com','I fix servers','Nope, not this'),
('admin','admin@example.com','Site admin','flag{thm_admin_super_secret}');

INSERT INTO comments (comment) VALUES
('Welcome to VulnApp!'),
('Try posting something');

-- Put the SQLi flag in a user bio so SQLi can leak it
INSERT INTO users (username, email, bio, secret_note) VALUES ('sqli_victim', 'sqli@local', 'FLAG: flag{thm_sqli_01}', 'n/a');

COMMIT;
