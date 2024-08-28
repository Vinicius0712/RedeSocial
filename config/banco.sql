CREATE DATABASE rede;
USE rede;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(250),
    usuario VARCHAR(250),
    senha VARCHAR(250)
);

INSERT INTO usuarios (id, email, usuario, senha) VALUES (1, 'vinicius@gmail.com', 'Vini', '123');


create user 'Vinn'@'localhost' identified by 'Vinn'; -- cria o usuário para acessar ao banco de dados com o login fulano e senha 123
GRANT ALL PRIVILEGES ON rede.* TO 'Vinn'@'localhost';
grant all on rede.* to 'Vinn'@'localhost'; -- dá todas as permissões para o usuário fulano no banco contatos