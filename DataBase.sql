Create DATABASE hw1;
USE hw1;

CREATE TABLE users (
    id integer primary key auto_increment,
    name varchar(255) not null,
    username varchar(16) not null unique,
    email varchar(255) not null unique,
    password varchar(255) not null
) Engine = InnoDB;

CREATE TABLE books (
    user_id int,
    book_isbn varchar(50) PRIMARY KEY,
    book_title varchar(100),
    book_author varchar(100),
    book_cover varchar(100),
    FOREIGN KEY (user_id) REFERENCES users(id)
)Engine = InnoDB;