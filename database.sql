CREATE DATABASE bilder_grid;
USE bilder_grid;

CREATE TABLE bilder (
    id INT AUTO_INCREMENT PRIMARY KEY,
    feldnummer INT UNIQUE NOT NULL,
    bildpfad VARCHAR(255) NOT NULL
);