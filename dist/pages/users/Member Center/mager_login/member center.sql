
create database membercenter;
use membercenter;
CREATE TABLE manager (
    id INT AUTO_INCREMENT PRIMARY KEY,
    manager_account VARCHAR(255) UNIQUE,
    manager_password VARCHAR(255),
    manager_privileges VARCHAR(255),
    UNIQUE KEY (manager_account) -- For better readability
);
CREATE TABLE users (
    users_id INT AUTO_INCREMENT PRIMARY KEY,
    user_email VARCHAR(255) UNIQUE NOT NULL,
    user_password VARCHAR(255) NOT NULL,
    user_name VARCHAR(255) NOT NULL,
    user_number VARCHAR(255) NOT NULL,
    user_address VARCHAR(255) NOT NULL,
    user_birthday DATE, 
    user_level VARCHAR(255),
    profile_picture VARCHAR(255), 
    user_status VARCHAR(255)
); 
CREATE TABLE user_sessions (
    user_id INT PRIMARY KEY,
    ip_address VARCHAR(255) NOT NULL,
    login_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    logout_time DATETIME,
    FOREIGN KEY (user_id) REFERENCES users(users_id)
);
