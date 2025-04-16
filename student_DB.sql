CREATE DATABASE student_residence_DB;
USE student_residence_DB;

DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS payments;
DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS rooms;

-- Rooms table
CREATE TABLE rooms (
    room_id INT PRIMARY KEY,
    room_number VARCHAR(10) NOT NULL,
    status ENUM('available', 'occupied') DEFAULT 'available'
);

-- Students table
CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    room_id INT,
    FOREIGN KEY (room_id) REFERENCES rooms(room_id) ON DELETE SET NULL
);

-- Payments table
CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    payment_date DATE NOT NULL,
    amount INT NOT NULL,
    status ENUM('paid', 'unpaid', 'overdue') DEFAULT 'unpaid',
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE SET NULL
);

-- Users table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL,    
    password VARCHAR(255) NOT NULL
);

INSERT INTO users (username, email, password) VALUES 
('user1', 'user1@newmail.com', 'helloloser');