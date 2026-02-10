-- 1. Create the Database
CREATE DATABASE IF NOT EXISTS inventory_db;
USE inventory_db;

-- 2. Create the Users Table (Login System)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- 3. Insert Default Admin User
-- Username: admin
-- Password: 1234
INSERT INTO users (username, password) VALUES ('admin', '1234');

-- 4. Create the Items Table (Inventory Data)
CREATE TABLE IF NOT EXISTS items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    qty INT NOT NULL DEFAULT 0,
    price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
