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
    imagem VARCHAR(255) NOT NULL,
    descricao TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE mercadorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10, 2),
    categoria VARCHAR(50),
    localizacao VARCHAR(100),
    imagem VARCHAR(255),
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);





create user 'Vinn'@'localhost' identified by 'Vinn'; -- cria o usuário para acessar ao banco de dados com o login fulano e senha 123
GRANT ALL PRIVILEGES ON rede.* TO 'Vinn'@'localhost';
grant all on rede.* to 'Vinn'@'localhost'; -- dá todas as permissões para o usuário fulano no banco contatosusuarios