CREATE DATABASE IF NOT EXISTS Terra_User;
Use Terra_User;

CREATE TABLE IF NOT EXISTS users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE DATABASE IF NOT EXISTS Terra_Data;
Use Terra_Data;

CREATE TABLE IF NOT EXISTS archives(
    id VARCHAR(255) PRIMARY KEY,
    username VARCHAR(255),
    gender VARCHAR(255),
    race VARCHAR(255),
    is_secret BOOLEAN DEFAULT FALSE
);

CREATE TABLE IF NOT EXISTS secret(
    id VARCHAR(255) PRIMARY KEY,
    value VARCHAR (255),
    flag VARCHAR(255)
);

INSERT INTO archives (id, username, gender, race, is_secret) VALUES
('1', 'Amiya', 'Female', 'Chimera', 0),
('2', 'Kaltsit', 'Female', 'Film', 0),
('3', 'Doctor', 'Female', 'Unkonw', 0),
('4', 'Lappland', 'Female', 'Repert', 0),
('5', 'Texas', 'Female', 'Repert', 0),
('6', 'Mutsumi', 'Female', 'Unknow', 0),
('7', 'Uika', 'Female', 'Unkonw', 0),
('8', 'Lemuen', 'Female', 'Sakota', 0),
('9', 'Skadi', 'Female', 'Agol', 0);