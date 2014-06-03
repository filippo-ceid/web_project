-- Not used
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- Database: FMC_DB (FixMyCity)
CREATE DATABASE FMC_DB COLLATE utf8_general_ci;
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
('admin@fixmycity.gr', '1', 'admin', 'Administrator', '', '11880');

UPDATE users SET user_level='admin' WHERE user_id = <number>;
UPDATE users SET email='ddfs@dfd.gr', firstname='Ηαα', lastname='Pdd', phone='1234567890'  WHERE user_id = 2;

SELECT * FROM users;
DELETE FROM users WHERE user_id  = <number>;
TRUNCATE TABLE users;
DROP DATABASE FMC_DB;
DROP TABLE users;
SHOW TABLES;

CREATE TABLE IF NOT EXISTS reports (
  report_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  category VARCHAR (40) NOT NULL,
  description VARCHAR (500) NOT NULL,
  datetime TIMESTAMP,
  lat FLOAT( 10, 6 ) NOT NULL,
  lng FLOAT( 10, 6 ) NOT NULL,
  user_id INT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(user_id)
  ON UPDATE CASCADE
  ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO reports (category, description, lat, lng, locked, user_id) VALUES
('road', 'lakouva', '38.371237', '21.431653', 'false', '2');

SELECT COUNT(*) FROM reports WHERE reports.user_id = <number>;
SELECT * FROM users,reports WHERE users.user_id = <number>;
SELECT category, description, datetime, lat, lng, firstname, lastname FROM reports INNER JOIN users on users.user_id = reports.user_id;

CREATE TABLE IF NOT EXISTS photos (
  photo_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  photo_name VARCHAR (40) NOT NULL,
  report_id INT NOT NULL,
  FOREIGN KEY (report_id) REFERENCES reports(report_id)
  ON UPDATE CASCADE
  ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS status (
  status_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  status ENUM('solved', 'unsolved') NOT NULL DEFAULT 'unsolved',
  comment VARCHAR (40),
  admin_id INT,
  update_datetime TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  report_id INT NOT NULL,
  FOREIGN KEY (admin_id) REFERENCES users(user_id),
  FOREIGN KEY (report_id) REFERENCES reports(report_id)
  ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS categories (
  categ_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  category VARCHAR (40) NOT NULL
) ENGINE=InnoDB;

INSERT INTO categories (category) VALUES ('Οδικά');
INSERT INTO categories (category) VALUES ('Ηλεκτρικά');
INSERT INTO categories (category) VALUES ('Υδραυλικά');
INSERT INTO categories (category) VALUES ('Περιβαλλοντικά');

UPDATE status SET status='solved' WHERE status_id = 1;
