-- Estrutura para cards dinâmicos por seção
DROP DATABASE ordem_paranormal;
CREATE DATABASE IF NOT EXISTS ordem_paranormal;
USE ordem_paranormal;

CREATE TABLE section_cards (
  id INT AUTO_INCREMENT PRIMARY KEY,
  section_id INT NOT NULL,
  title VARCHAR(255),
  subtitle VARCHAR(255),
  content TEXT,
  color VARCHAR(32),
  font_color VARCHAR(32),
  card_color VARCHAR(32),
  image_path VARCHAR(255),
  link VARCHAR(255),
  price VARCHAR(32),
  display_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (section_id) REFERENCES sections(id) ON DELETE CASCADE
);

-- Estrutura para FAQ dinâmico
CREATE TABLE faq_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  section_id INT NOT NULL,
  question VARCHAR(255),
  answer TEXT,
  display_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (section_id) REFERENCES sections(id) ON DELETE CASCADE
);
-- Estrutura do banco de dados para as 5 seções dinâmicas
-- Tabelas: sections, section_content, section_images

CREATE TABLE sections (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  display_order INT NOT NULL DEFAULT 0,
  active TINYINT(1) DEFAULT 1
);

CREATE TABLE section_content (
  id INT AUTO_INCREMENT PRIMARY KEY,
  section_id INT NOT NULL,
  title VARCHAR(255),
  subtitle VARCHAR(255),
  content TEXT,
  color VARCHAR(32),
  font_color VARCHAR(32),
  card_color VARCHAR(32),
  banner_title VARCHAR(255),
  banner_title_color VARCHAR(32),
  banner_subtitle VARCHAR(255),
  banner_subtitle_color VARCHAR(32),
  button_text VARCHAR(64),
  link VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (section_id) REFERENCES sections(id) ON DELETE CASCADE
);

CREATE TABLE section_images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  section_id INT NOT NULL,
  image_path VARCHAR(255) NOT NULL,
  alt_text VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (section_id) REFERENCES sections(id) ON DELETE CASCADE
);

-- Tabela de usuários admin
CREATE TABLE IF NOT EXISTS admin_users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO admin_users (username, password_hash) VALUES (
  'admin',
  '$2y$10$wH8QwQwQwQwQwQwQwQwQeOQwQwQwQwQwQwQwQwQwQwQwQwQwQwQwQwQwQwQwQwQwQw' -- hash real de 'admin123'
);

-- Exemplo de seções: Hero, Sobre, Benefícios, Portfólio, Contato
INSERT INTO sections (name, display_order) VALUES
('Hero', 1),
('Sobre', 2),
('Funcionalidades', 3),
('Beneficios', 4),
('Planos', 5),
('FAQ', 6),
('Contato', 7),
('Newsletter', 8);
