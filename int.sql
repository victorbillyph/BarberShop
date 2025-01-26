CREATE DATABASE IF NOT EXISTS barbearia;
USE barbearia;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'employee') NOT NULL
);

-- Inserir um admin inicial
-- Comente ou remova após a primeira execução
INSERT INTO users (name, email, password, role)
VALUES ('Admin', 'admin@barbearia.com', '$2y$10$DlxSggK.8vhMjmz75N3vze55BCOIgV6wbQUSzmQ3KT34rFkS6x9Vu', 'admin');
