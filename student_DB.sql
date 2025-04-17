CREATE DATABASE student_residence_DB;
USE student_residence_DB;

-- Drop tables
DROP TABLE IF EXISTS rooms;
DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS payments;
DROP TABLE IF EXISTS users;

-- Room table
CREATE TABLE rooms (
    room_id INT AUTO_INCREMENT PRIMARY KEY,
    room_number VARCHAR(10) NOT NULL UNIQUE
);

-- Students table
CREATE TABLE students (
    student_id VARCHAR(30) PRIMARY KEY, 
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    room_id INT,
    FOREIGN KEY (room_id) REFERENCES rooms(room_id) ON DELETE SET NULL
);

-- Payments table
CREATE TABLE payments (
    student_id VARCHAR(30) PRIMARY KEY, 
    amount DECIMAL(10, 2) NOT NULL,
    status ENUM('paid', 'unpaid', 'overdue') DEFAULT 'unpaid',
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE
);

-- Users table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- For access 
INSERT INTO users (email, password) VALUES 
('admin@newmail.com', 'adminpass');

-- Room numbes
INSERT INTO rooms (room_number) VALUES
('100'),
('101'),
('102'),
('103'),
('104'),
('105'),
('106'),
('107'),
('108'),
('109'),
('110'),
('111'),
('112'),
('113'),
('114'),
('115'),
('116'),
('117'),
('118'),
('119'),
('120'),
('121'),
('122'),
('123'),
('124'),
('125'),
('126'),
('127'),
('128'),
('129'),
('130'),
('131'),
('132'),
('133'),
('134'),
('135'),
('136'),
('137'),
('138'),
('139'),
('140'),
('141'),
('142'),
('143'),
('144'),
('145'),
('146'),
('147'),
('148'),
('149'),
('150'),
('151'),
('152'),
('153'),
('154'),
('155'),
('156'),
('157'),
('158'),
('159'),
('160'),
('161'),
('162'),
('163'),
('164'),
('165'),
('166'),
('167'),
('168'),
('169'),
('170'),
('171'),
('172'),
('173'),
('174'),
('175'),
('176'),
('177'),
('178'),
('179'),
('180'),
('181'),
('182'),
('183'),
('184'),
('185'),
('186'),
('187'),
('188'),
('189'),
('190'),
('191'),
('192'),
('193'),
('194'),
('195'),
('196'),
('197'),
('198'),
('199'),
('200');