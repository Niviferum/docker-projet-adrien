CREATE DATABASE IF NOT EXISTS bandnames;
USE bandnames;

CREATE TABLE IF NOT EXISTS adjectives (
    id INT AUTO_INCREMENT PRIMARY KEY,
    word VARCHAR(50) NOT NULL,
    genre ENUM('metal', 'speedcore') NOT NULL,
    INDEX idx_genre (genre)
);

CREATE TABLE IF NOT EXISTS nouns (
    id INT AUTO_INCREMENT PRIMARY KEY,
    word VARCHAR(50) NOT NULL,
    genre ENUM('metal', 'speedcore') NOT NULL,
    INDEX idx_genre (genre)
);

INSERT INTO adjectives (word, genre) VALUES
    ('Eternal', 'metal'),
    ('Burning', 'metal'),
    ('Crimson', 'metal'),
    ('Blackened', 'metal'),
    ('Frozen', 'metal'),
    ('Ancient', 'metal'),
    ('Cursed', 'metal'),
    ('Unholy', 'metal'),
    ('Wicked', 'metal'),
    ('Vengeful', 'metal'),
    ('Doomed', 'metal'),
    ('Savage', 'metal'),
    ('Brutal', 'speedcore'),
    ('Distorted', 'speedcore'),
    ('Chaotic', 'speedcore'),
    ('Frantic', 'speedcore'),
    ('Manic', 'speedcore'),
    ('Violent', 'speedcore'),
    ('Broken', 'speedcore'),
    ('Extreme', 'speedcore'),
    ('Psychotic', 'speedcore'),
    ('Terminal', 'speedcore'),
    ('Corrupted', 'speedcore'),
    ('Relentless', 'speedcore');

INSERT INTO nouns (word, genre) VALUES
    ('Throne', 'metal'),
    ('Wolves', 'metal'),
    ('Serpents', 'metal'),
    ('Ravens', 'metal'),
    ('Winter', 'metal'),
    ('Shadows', 'metal'),
    ('Legion', 'metal'),
    ('Empire', 'metal'),
    ('Sacrifice', 'metal'),
    ('Dragons', 'metal'),
    ('Abyss', 'metal'),
    ('Warriors', 'metal'),
    ('Machines', 'speedcore'),
    ('Frequencies', 'speedcore'),
    ('Circuits', 'speedcore'),
    ('Overdrive', 'speedcore'),
    ('Feedback', 'speedcore'),
    ('Nightmare', 'speedcore'),
    ('Voltage', 'speedcore'),
    ('Assault', 'speedcore'),
    ('Mayhem', 'speedcore'),
    ('System', 'speedcore'),
    ('Noise', 'speedcore'),
    ('Terror', 'speedcore');