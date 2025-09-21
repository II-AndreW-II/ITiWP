CREATE DATABASE IF NOT EXISTS task_manager CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE task_manager;

SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    phone VARCHAR(255),
    address TEXT,
    status ENUM('не активен', 'активен') DEFAULT 'не активен',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO contacts (title, description, phone, address, status) VALUES 
('Иван Иванов', 'Друг из школы', '+375(29)456-78-90', 'Минск, ул. Якуба Коласа 1', 'активен'),
('Мария Петрова', 'Коллега', '+375(33)654-32-10', 'Гродно, ул. Парниковая 3', 'не активен');
