CREATE DATABASE code;
USE code;


-- Drop existing tables if they exist
DROP TABLE IF EXISTS payments;
DROP TABLE IF EXISTS enrollments;
DROP TABLE IF EXISTS courses;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS teachers;
DROP TABLE IF EXISTS categories;

-- Create Categories Table
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    description TEXT
);

INSERT INTO categories (name, description) VALUES 
('Web Development', 'Courses related to building websites and web applications.'),
('Mobile Development', 'Courses focused on developing mobile applications for Android and iOS.'),
('Data Science', 'Courses covering data analysis, machine learning, and data visualization techniques.'),
('Game Development', 'Courses on creating video games using various platforms and languages.'),
('Database Management', 'Courses on managing databases, including SQL and NoSQL technologies.'),
('DevOps', 'Courses on practices for software development and IT operations collaboration.'),
('Software Development', 'Courses on software engineering principles and methodologies.'),
('Cybersecurity', 'Courses focused on protecting systems from cyber threats and attacks.'),
('Artificial Intelligence', 'Courses on AI concepts including machine learning and neural networks.');


-- Create Courses Table
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    category_id INT,
    start_date DATE,
    end_date DATE,
    is_open BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);
    ALTER TABLE courses ADD COLUMN image_path VARCHAR(255) NULL;
    ALTER TABLE courses ADD COLUMN pdf_path VARCHAR(255) NULL;
    ALTER TABLE courses ADD COLUMN video_path VARCHAR(255) NULL;


-- Create Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'instructor', 'admin') DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
ALTER TABLE users ADD COLUMN profile_image VARCHAR(255) DEFAULT NULL;






-- Create Teachers Table
CREATE TABLE teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    bio TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Create Enrollments Table
CREATE TABLE enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    course_id INT,
    enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (course_id) REFERENCES courses(id)
);

-- Create Payments Table
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    course_id INT,
    amount DECIMAL(10, 2),
    payment_method ENUM('credit_card', 'paypal') NOT NULL,
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('success', 'failed') DEFAULT 'success',
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (course_id) REFERENCES courses(id)
);


CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);


CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    site_name VARCHAR(255) NOT NULL,
    contact_email VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE chat_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_admin BOOLEAN DEFAULT FALSE
);
ALTER TABLE notifications
ADD COLUMN course_id INT NOT NULL AFTER id,
ADD FOREIGN KEY (course_id) REFERENCES courses(id);

SELECT u.id AS user_id, u.name AS student_name, c.title AS course_title
FROM enrollments e
JOIN users u ON e.user_id = u.id
JOIN courses c ON e.course_id = c.id
ORDER BY u.name;