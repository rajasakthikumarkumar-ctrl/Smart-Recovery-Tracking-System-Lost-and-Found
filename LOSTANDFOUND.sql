
-- LOSTANDFOUND schema for v2 (includes ai_category and messages)
CREATE DATABASE IF NOT EXISTS `LOSTANDFOUND` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `LOSTANDFOUND`;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  reg_no VARCHAR(50) UNIQUE,
  mobile VARCHAR(15),
  dept VARCHAR(50),
  year INT,
  password VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  item_name VARCHAR(100),
  description TEXT,
  status ENUM('lost','found') DEFAULT 'lost',
  contact VARCHAR(100),
  image VARCHAR(255),
  ai_category VARCHAR(100),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  item_id INT,
  sender VARCHAR(100),
  message TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- sample data
INSERT INTO items (item_name, description, status, contact, ai_category) VALUES
('Blue Water Bottle', 'Stainless steel blue bottle found near library', 'found', 'library@college.edu', 'water bottle'),
('Black Backpack', 'Lost backpack with textbooks', 'lost', 'sanjai@example.com', 'backpack');
