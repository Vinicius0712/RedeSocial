CREATE DATABASE rede;
USE rede;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(250) unique,
    senha VARCHAR(250)
);

CREATE TABLE perfis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    foto_perfil VARCHAR(255) DEFAULT 'default.jpg',
    seguidores INT DEFAULT 0,
    seguindo INT DEFAULT 0,
    publicacoes INT DEFAULT 0,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE publicacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    imagem VARCHAR(255),
    descricao TEXT,
    data_publicacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);



create user 'Vinn'@'localhost' identified by 'Vinn'; -- cria o usuário para acessar ao banco de dados com o login fulano e senha 123
GRANT ALL PRIVILEGES ON rede.* TO 'Vinn'@'localhost';
grant all on rede.* to 'Vinn'@'localhost'; -- dá todas as permissões para o usuário fulano no banco contatosusuarios