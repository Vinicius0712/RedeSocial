<?php
require_once("../classes/Database.class.php");

class Usuario {

    private $usuario;
    private $senha;

    public function __construct($usuario = null, $senha = null) {
        $this->setUsuario($usuario); 
        $this->setSenha($senha);
    }

    public function setUsuario($novoUsuario) {
        if (empty($novoUsuario)) {
            throw new Exception("Erro: Usuário inválido!");
        } else {
            $this->usuario = $novoUsuario;
        }
    }

    public function setSenha($novaSenha) {
        if (empty($novaSenha)) {
            throw new Exception("Erro: Senha inválida!");
        } else {
            $this->senha = $novaSenha;
        }
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function incluir() {
        $conexao = Database::getInstance();
        $sql = 'INSERT INTO usuarios (usuario, senha) VALUES (:usuario, :senha)';
        $comando = $conexao->prepare($sql); 
        $comando->bindValue(':usuario', $this->getUsuario());
        $comando->bindValue(':senha', $this->getSenha()); 
        $comando->execute();
        return true;
    }

    public function autenticar() {
        $conexao = Database::getInstance();
        $sql = 'SELECT * FROM usuarios WHERE usuario = :usuario';
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':usuario', $this->getUsuario());
        $comando->execute();
        $user = $comando->fetch();

        if ($user && $this->getSenha() === $user['senha']) {
            return $user['id']; // Retorna o ID do usuário se autenticação for bem-sucedida
        } else {
            return false; // Retorna falso se a autenticação falhar
        }
    }
}
?>
