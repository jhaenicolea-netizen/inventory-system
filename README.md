# 📦 Inventory Management System (PHP & MySQL)

A simple, secure, and modern Inventory Management System featuring a Login Dashboard and full CRUD (Create, Read, Update, Delete) capabilities. Built with **PHP** and **MySQL**, styled with **Bootstrap 5**.

---

## 🚀 Option 1: Run in GitHub Codespaces (Cloud)
*Best for quick testing without installing anything on your computer.*

### 1. Prepare the Environment
Open the terminal in your Codespace and run this single command to install the necessary database drivers and PHP tools:
```bash
sudo apt-get update && sudo apt-get install -y php-mysql php8.3-cli mariadb-server
2. Set Up the Database
Start the database service and create the tables by running these commands:

Bash

# Start the database service
sudo service mariadb start

# Create the database and admin user
sudo mariadb -e "CREATE DATABASE IF NOT EXISTS inventory_db; USE inventory_db; CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(50), password VARCHAR(255)); INSERT INTO users (username, password) VALUES ('admin', '1234'); CREATE TABLE IF NOT EXISTS items (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100), qty INT, price DECIMAL(10,2));"
3. Start the Server
Run this command to start the PHP server:

Bash

/usr/bin/php8.3 -S 0.0.0.0:8000
Note: If prompted, click "Open in Browser" in the popup.

💻 Option 2: Run Locally (XAMPP on Windows)
Best for permanent development using VS Code or Notepad++.

1. Install XAMPP
Download and install XAMPP. Make sure to check Apache and MySQL during installation.

2. Start Servers
Open the XAMPP Control Panel.

Click Start next to Apache and MySQL.

3. Setup the Database
Open your browser and go to http://localhost/phpmyadmin.

Click New on the left sidebar.

Create a database named inventory_db.

Click the SQL tab at the top and paste the code below:

SQL

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(255)
);
INSERT INTO users (username, password) VALUES ('admin', '1234');

CREATE TABLE items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    qty INT,
    price DECIMAL(10,2)
);
Click Go.

4. Install the Project
Go to your XAMPP installation folder (usually C:\xampp\htdocs).

Create a new folder named inventory.

Paste all your PHP files (index.php, dashboard.php, db.php, etc.) inside this folder. (You can edit these files using VS Code or Notepad++).

5. Run the App
Open your browser and visit: http://localhost/inventory

🔑 Login Credentials
Username: admin

Password: 1234

✨ Features
Secure Login: Session-based authentication.

Dashboard: Real-time overview of inventory stock.

Stock Alerts: Automatic "Low Stock" badges for items under 5 units.

CRUD Operations:

Create: Add new items with price and quantity.

Read: View all items in a responsive table.

Update: Edit existing item details.

Delete: Remove items from the database.