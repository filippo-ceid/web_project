-- Not used
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- Database: FMC_DB (FixMyCity)
CREATE DATABASE FMC_DB CHARACTER SET utf8 COLLATE utf8_general_ci;
SHOW DATABASES;
USE FMC_DB;

-- Table users for login
CREATE TABLE IF NOT EXISTS users  (
  user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(50) NOT NULL,
  password VARCHAR(128) NOT NULL,
  user_level ENUM('simple','admin') NOT NULL,
  firstname VARCHAR(20),
  lastname VARCHAR(20),
  phone VARCHAR(10)
) ENGINE=InnoDB;

INSERT INTO users (email, password, user_level, firstname, lastname, phone) VALUES
('admin@fixmycity.gr', 'admin', 'admin', 'Administrator', '', '2631012345');

UPDATE users SET user_level='admin' WHERE user_id = <number>;

SELECT * FROM users;
DELETE FROM users WHERE user_id  = <number>;
TRUNCATE TABLE users;
DROP DATABASE FMC_DB;
DROP TABLE users;
SHOW TABLES;
