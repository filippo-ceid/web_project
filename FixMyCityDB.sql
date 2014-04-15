-- Not used
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- Database: FMC_DB (FixMyCity)
CREATE database FMC_DB;
SHOW databases;
USE FMC_DB;

-- Table users for login
CREATE TABLE IF NOT EXISTS users (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(50) NOT NULL,
  password VARCHAR(128) NOT NULL,
  user_type ENUM('visitor','user','admin') NOT NULL
) ENGINE=InnoDB;

INSERT INTO users (email, password, user_type) VALUES
('admin@', 'admin', 'admin'),
('filippo@', '1234', 'user'),
('kalexio@', '1234', 'visitor');

SELECT * FROM users;

------------------------------------------------------

-- Table profiles
CREATE TABLE IF NOT EXISTS profiles (
  id INT(11) NOT NULL PRIMARY KEY,
  fname VARCHAR(100),
  lname VARCHAR(100),
  phone INT(10),
) ENGINE=InnoDB;

INSERT INTO profiles (id, fname, lname, phone) VALUES
(1, 'Admin', '', 2105478952),
(2, 'Filippos', 'F', 2631051452);
