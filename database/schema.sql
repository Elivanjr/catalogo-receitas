
CREATE DATABASE IF NOT EXISTS catalogo
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE catalogo;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS receitas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    categoria ENUM('Doce', 'Salgado', 'Bebida') NOT NULL,
    tempo_preparo INT NOT NULL,
    ingredientes TEXT NOT NULL,
    modo_preparo TEXT NOT NULL,

    CONSTRAINT fk_receitas_usuario
        FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;
