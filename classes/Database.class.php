<?php
require_once('../config/config.inc.php');

class Database{

    /** Método para criar conexão com o banco de dados */
    public static function getInstance(){ 
        try{ 
            return new PDO(DSN, USUARIO, SENHA); // conectar com o banco 
        }catch(PDOException $e){ // se ocorrer algum erro - pega a exceção ocorrida 
            echo "Erro ao conectar ao banco de dados: ".$e->getMessage(); // ... e apresenta mensagem de erro para o usuário
        }
    }
}