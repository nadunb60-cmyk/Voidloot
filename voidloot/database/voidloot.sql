CREATE DATABASE IF NOT EXISTS voidloot CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE voidloot;
SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS game_requirements;
DROP TABLE IF EXISTS game_sources;
DROP TABLE IF EXISTS game_screenshots;
DROP TABLE IF EXISTS games;
SET FOREIGN_KEY_CHECKS=1;
CREATE TABLE games (
 id INT AUTO_INCREMENT PRIMARY KEY, title VARCHAR(180) NOT NULL, tagline VARCHAR(255) DEFAULT '',
 description TEXT, cover_url TEXT, banner_url TEXT, trailer_url TEXT, developer VARCHAR(180), publisher VARCHAR(180),
 genre VARCHAR(100), release_date VARCHAR(40), featured TINYINT(1) DEFAULT 0, views INT DEFAULT 0,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
CREATE TABLE game_screenshots (
 id INT AUTO_INCREMENT PRIMARY KEY, game_id INT NOT NULL, image_url TEXT NOT NULL, sort_order INT DEFAULT 0,
 FOREIGN KEY(game_id) REFERENCES games(id) ON DELETE CASCADE
) ENGINE=InnoDB;
CREATE TABLE game_sources (
 id INT AUTO_INCREMENT PRIMARY KEY, game_id INT NOT NULL, source_name VARCHAR(120) NOT NULL, source_url TEXT NOT NULL, sort_order INT DEFAULT 0,
 FOREIGN KEY(game_id) REFERENCES games(id) ON DELETE CASCADE
) ENGINE=InnoDB;
CREATE TABLE game_requirements (
 id INT AUTO_INCREMENT PRIMARY KEY, game_id INT NOT NULL, kind ENUM('minimum','recommended') NOT NULL,
 os VARCHAR(255), processor VARCHAR(255), memory VARCHAR(255), graphics VARCHAR(255), directx VARCHAR(255), storage VARCHAR(255),
 UNIQUE KEY game_kind(game_id,kind), FOREIGN KEY(game_id) REFERENCES games(id) ON DELETE CASCADE
) ENGINE=InnoDB;
INSERT INTO games(title,tagline,description,cover_url,banner_url,developer,publisher,genre,release_date,featured) VALUES
('Cyberpunk 2077','Welcome to Night City.','An open-world action RPG set in Night City, a megalopolis obsessed with power, glamour and body modification. Verify current system requirements with the publisher.','https://cdn.cloudflare.steamstatic.com/steam/apps/1091500/library_600x900.jpg','https://cdn.cloudflare.steamstatic.com/steam/apps/1091500/library_hero.jpg','CD PROJEKT RED','CD PROJEKT RED','RPG','2020-12-10',1),
('Stardew Valley','A little place to call home.','Build the farm of your dreams, grow crops, raise animals, explore caves and become part of a welcoming community.','https://cdn.cloudflare.steamstatic.com/steam/apps/413150/library_600x900.jpg','https://cdn.cloudflare.steamstatic.com/steam/apps/413150/library_hero.jpg','ConcernedApe','ConcernedApe','Simulation','2016-02-26',0),
('0 A.D.','An open-source ancient warfare strategy game.','A free, open-source real-time strategy game about ancient warfare. Visit the official project for downloads and requirements.','https://play0ad.com/wp-content/gallery/screenshots/0ad-screenshot-001.jpg','https://play0ad.com/wp-content/gallery/screenshots/0ad-screenshot-001.jpg','Wildfire Games','Wildfire Games','Strategy','2010',0);
INSERT INTO game_sources(game_id,source_name,source_url) VALUES
(1,'Official CD PROJEKT RED','https://www.cyberpunk.net/'),
(1,'GOG','https://www.gog.com/game/cyberpunk_2077'),
(2,'Official Stardew Valley','https://www.stardewvalley.net/'),
(2,'GOG','https://www.gog.com/en/game/stardew_valley'),
(3,'Official 0 A.D. Downloads','https://play0ad.com/download/');
INSERT INTO game_requirements(game_id,kind,os,processor,memory,graphics,directx,storage) VALUES
(1,'minimum','Verify with publisher','Verify with publisher','Verify with publisher','Verify with publisher','Verify with publisher','Verify with publisher'),
(1,'recommended','Verify with publisher','Verify with publisher','Verify with publisher','Verify with publisher','Verify with publisher','Verify with publisher'),
(2,'minimum','Windows 7 or later','2 GHz','2 GB RAM','256 MB video memory','DirectX 10','500 MB'),
(2,'recommended','Windows 10','2 GHz','4 GB RAM','Dedicated GPU','DirectX 11','500 MB'),
(3,'minimum','Windows / Linux / macOS','Modern dual-core CPU','2 GB RAM','OpenGL 2.1 compatible','OpenGL 2.1','2 GB'),
(3,'recommended','Windows / Linux / macOS','Modern quad-core CPU','4 GB RAM','Dedicated GPU','OpenGL 2.1','2 GB');
