CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_nationality_assigned BOOLEAN DEFAULT FALSE
);

CREATE TABLE visas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    passport_number VARCHAR(50) NOT NULL,
    passport_validity DATE NOT NULL,
    nationality VARCHAR(100) NOT NULL,
    visa_status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    visa_pdf_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE lottery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    lottery_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    session_token VARCHAR(255),
    login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    logout_time TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE lottery_schedule (
    id INT PRIMARY KEY AUTO_INCREMENT,
    last_run TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO lottery_schedule (last_run) VALUES (NOW());
