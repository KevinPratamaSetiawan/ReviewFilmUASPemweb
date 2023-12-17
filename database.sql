-- Active: 1686408613400@@127.0.0.1@3306@data_film
CREATE DATABASE data_film

USE data_film

SHOW TABLES;

DROP TABLE film;

DROP TABLE genre;

DROP TABLE user_data;

DESC genre;

Select * FROM film;

SELECT * FROM genre;

SELECT * FROM user_data;

DELETE FROM film;

DELETE FROM genre;

DELETE FROM user_data;

SELECT film_id FROM film WHERE title = 'Title 1';

CREATE TABLE film(
    film_id integer NOT NULL AUTO_INCREMENT,
    title varchar(50) NOT NULL UNIQUE,
    synopsis varchar(500) NOT NULL,
    release_month varchar(15) NOT NULL,
    release_year integer(4) NOT NULL,
    score float(10) NOT NULL,
    PRIMARY KEY(film_id)
);

CREATE TABLE genre(
    genre_id int NOT NULL AUTO_INCREMENT,
    fk_film_id int(10) NOT NULL,
    genre varchar(20) NOT NULL,
    PRIMARY KEY(genre_id),
    CONSTRAINT fk_film_id FOREIGN KEY (fk_film_id) REFERENCES film(film_id) ON DELETE CASCADE
);

CREATE TABLE user_data(
    user_id int NOT NULL AUTO_INCREMENT,
    fk2_film_id int(10) NOT NULL,
    user_ip varchar(100) NOT NULL,
    user_browser varchar(1000) NOT NULL,
    PRIMARY KEY(user_id),
    CONSTRAINT fk2_film_id FOREIGN KEY (fk2_film_id) REFERENCES film(film_id) ON DELETE CASCADE
);