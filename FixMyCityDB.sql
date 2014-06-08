-- Database: FMC_DB (FixMyCity)
CREATE DATABASE FMC_DB COLLATE utf8_general_ci;

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
  status ENUM('Κλειστή', 'Ανοιχτή') NOT NULL DEFAULT 'Ανοιχτή',
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
  category VARCHAR (40) NOT NULL,
  pin_icon VARCHAR (20) NOT NULL
) ENGINE=InnoDB;

SELECT * FROM users;
DELETE FROM users WHERE user_id  = <number>;
SHOW DATABASES;
DROP DATABASE FMC_DB;
SHOW TABLES;
TRUNCATE TABLE users;
DROP TABLE users;

UPDATE users SET user_level='admin' WHERE user_id = <number>;

SELECT COUNT(*) FROM reports WHERE reports.user_id = <number>;
SELECT * FROM users,reports WHERE users.user_id = <number>;
SELECT category, description, datetime, lat, lng, firstname, lastname FROM reports INNER JOIN users on users.user_id = reports.user_id;

INSERT INTO categories (category, pin_icon) VALUES ('Οδικά', 'pin_grey');

UPDATE status SET status='solved' WHERE status_id = 1;
