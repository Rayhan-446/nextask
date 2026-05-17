# NexTask

NexTask is a task management web application developed for Cybersecurity Lab purposes.  
The project intentionally contains vulnerabilities for educational and penetration testing practice.

---

# Features

- User Registration & Login
- Dashboard
- Task Management
- Task Assignment
- Task Status Tracking
- Admin Panel
- Vulnerability Testing Environment

---

# Technologies Used

- PHP
- MariaDB / MySQL
- Apache2
- HTML
- CSS
- JavaScript
- Kali Linux

---

# Requirements

Install the following before running the project:

- Apache2
- PHP
- MariaDB/MySQL
- Git

---

# Installation Guide

---

## 1. Clone Repository

```bash
git clone https://github.com/Rayhan-446/nextask.git
```

---

## 2. Move Project to Apache Directory

```bash
sudo mv nextask /var/www/html/
```

---

## 3. Start Apache and MariaDB

Start services:

```bash
sudo systemctl start apache2
sudo systemctl start mariadb
```

Enable services:

```bash
sudo systemctl enable apache2
sudo systemctl enable mariadb
```

Check status:

```bash
sudo systemctl status apache2
sudo systemctl status mariadb
```

---

# Complete Database Setup

---

## 4. Login to MariaDB

```bash
sudo mysql
```

---

## 5. Create Database

```sql
CREATE DATABASE nextask;
```

Check database list:

```sql
SHOW DATABASES;
```

---

## 6. Use Database

```sql
USE nextask;
```

---

## 7. Create Users Table

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100),
    username VARCHAR(50) UNIQUE,
    email VARCHAR(100),
    password VARCHAR(255),
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## 8. Create Tasks Table

```sql
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    description TEXT,
    assigned_to INT,
    status ENUM('Pending', 'In Progress', 'Completed') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (assigned_to) REFERENCES users(id)
);
```

---

## 9. Insert Default Admin Account

```sql
INSERT INTO users (full_name, username, email, password, role)
VALUES (
    'Administrator',
    'admin',
    'admin@nextask.com',
    MD5('admin123'),
    'admin'
);
```

---

## 10. Verify Tables

```sql
SHOW TABLES;
```

---

## 11. Check Table Data

```sql
SELECT * FROM users;
SELECT * FROM tasks;
```

---

## 12. Exit MariaDB

```sql
exit;
```

---

# Database Configuration

Edit database connection file:

```bash
nano /var/www/html/nextask/includes/db.php
```

Example database configuration:

```php
<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "nextask";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
```

---

# Set Permissions

```bash
sudo chmod -R 755 /var/www/html/nextask
```

---

# Open Project

Visit in browser:

```text
http://localhost/nextask
```

---

# Default Admin Login

```text
Username: admin
Password: admin123
```

---

# GitHub Upload Guide

Initialize git:

```bash
git init
```

Add files:

```bash
git add .
```

Commit project:

```bash
git commit -m "Initial commit"
```

Connect GitHub repository:

```bash
git remote add origin https://github.com/Rayhan-446/nextask.git
```

Rename branch:

```bash
git branch -M main
```

Push project:

```bash
git push -u origin main
```

---

# Educational Warning

This project intentionally contains vulnerabilities for cybersecurity learning purposes.

Do NOT deploy this project on a public production server.

---

# Author

Rayhan  
CSE Student  
Bangladesh University of Business and Technology
