# NexTask

NexTask is a task management web application developed for Cybersecurity Lab purposes.  
The project intentionally contains vulnerabilities for educational and penetration testing practice.

---

## Features

- User Registration & Login
- Task Management
- Dashboard
- Task Assignment
- Status Tracking
- Admin Panel
- Vulnerable Endpoints for Security Testing

---

## Technologies Used

- PHP
- MySQL / MariaDB
- HTML
- CSS
- JavaScript
- Apache2
- Kali Linux

---

## Requirements

Before running the project, make sure these are installed:

- Apache2
- PHP
- MariaDB/MySQL
- Git

---

## Installation Guide

### 1. Clone Repository

```bash
git clone https://github.com/Rayhan-446/nextask.git
```

---

### 2. Move Project to Apache Directory

```bash
sudo mv nextask /var/www/html/
```

---

### 3. Start Apache and MariaDB

```bash
sudo systemctl start apache2
sudo systemctl start mariadb
```

Enable services:

```bash
sudo systemctl enable apache2
sudo systemctl enable mariadb
```

---

### 4. Create Database

Login to MariaDB:

```bash
sudo mysql
```

Create database:

```sql
CREATE DATABASE nextask;
```

Exit:

```sql
exit;
```

---

### 5. Import Database

If SQL file exists:

```bash
mysql -u root -p nextask < database.sql
```

---

### 6. Configure Database Connection

Edit:

```bash
/var/www/html/nextask/includes/db.php
```

Example configuration:

```php
<?php
$conn = new mysqli("localhost", "root", "", "nextask");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
```

---

### 7. Set Permissions

```bash
sudo chmod -R 755 /var/www/html/nextask
```

---

### 8. Open in Browser

Visit:

```text
http://localhost/nextask
```

---

## Educational Warning

This project intentionally contains vulnerabilities for cybersecurity learning purposes.

Do NOT deploy this project on a public production server.

---

## Author

Rayhan
CSE Student
Bangladesh University of Business and Technology
