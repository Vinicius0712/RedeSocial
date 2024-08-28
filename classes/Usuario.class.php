<?php
class Usuario {
    private $usuario;
    private $senha;

    // Construtor para inicializar as propriedades
  
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
            $this->senha = $novaSenha; // Aqui mantemos a senha sem criptografar, pois a criptografia ocorre na inclusão.
        }
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function incluir() {
        try {
            $conexao = Database::getInstance();
            $sql = 'INSERT INTO usuarios (usuario, senha) VALUES (:usuario, :senha)';
            $comando = $conexao->prepare($sql);

            // Vinculação dos parâmetros
            $comando->bindValue(':usuario', $this->getUsuario(), PDO::PARAM_STR);
            $comando->bindValue(':senha', password_hash($this->getSenha(), PASSWORD_DEFAULT), PDO::PARAM_STR);

            // Execute o comando
            $comando->execute();
            return true;
        } catch (PDOException $e) {
            // Log de erro
            error_log($e->getMessage());
            throw new Exception("Erro ao incluir usuário!");
        }
    }

    public function autenticar() {
        try {
            $conexao = Database::getInstance();
            $sql = 'SELECT * FROM usuarios WHERE usuario = :usuario';
            $comando = $conexao->prepare($sql);
            $comando->bindValue(':usuario', $this->getUsuario(), PDO::PARAM_STR);
            $comando->execute();
            $user = $comando->fetch(PDO::FETCH_ASSOC);

            // Verifica se o usuário existe e a senha está correta
            if ($user) {
                if (password_verify($this->getSenha(), $user['senha'])) {
                    return $user['id']; // Retorna o ID do usuário se a autenticação for bem-sucedida
                } else {
                    throw new Exception("Senha incorreta!");
                }
            } else {
                throw new Exception("Usuário não encontrado!");
            }
        } catch (PDOException $e) {
            // Log de erro
            error_log($e->getMessage());
            throw new Exception("Erro ao autenticar usuário!");
        }
    }
}
?>
