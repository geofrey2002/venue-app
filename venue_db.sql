CREATE DATABASE venue_db;
USE venue_db;

CREATE TABLE venues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    capacity INT NOT NULL,
    features TEXT
);

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venue_id INT NOT NULL,
    date DATE NOT NULL,
    from_time TIME NOT NULL,
    to_time TIME NOT NULL,
    FOREIGN KEY (venue_id) REFERENCES venues(id) ON DELETE CASCADE
);

INSERT INTO venues (name, capacity, features) VALUES
('102 C', 100, 'Projector,camera'),
('Lab 1', 70, 'Computers, Internet ,projector ,camera'),
('NYERERE HALL', 200, 'Whiteboard,Stage, Sound System, Wi-Fi, Projectors,Camera'),
('D-005/D-006', 80, 'Microphone, Screen,camera ');
('LPII-GF-P2', 70, 'Projector, Wi-Fi,camera');