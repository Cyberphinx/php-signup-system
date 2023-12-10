# CREATE TABLES
CREATE TABLE users (
	id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(30) NOT NULL,
    pwd VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIME,
    PRIMARY KEY (id)
);

CREATE TABLE comments (
	id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(30) NOT NULL,
    comment_text TEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIME,
    users_id INT(11),
    PRIMARY KEY (id),
    FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE SET NULL
);

# INSERT
INSERT INTO users (username, pwd, email) VALUES ('Lily', '123456', 'lily@test.com');

INSERT INTO comments (username, comment_text, users_id) VALUES ('Lily', 'This is a comment on a website!', '3');

SELECT * FROM comments WHERE users_id = 3;

# INNER JOIN (select when both users and comments are not null)
SELECT * FROM users INNER JOIN comments ON users.id = comments.users_id;

# LEFT JOIN (select all users with comments)
SELECT * FROM users LEFT JOIN comments ON users.id = comments.users_id;

# RIGHT JOIN (select all comments with users)
SELECT * FROM users LEFT JOIN comments ON users.id = comments.users_id;
