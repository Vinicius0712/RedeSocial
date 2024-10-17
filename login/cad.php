<?php
require_once('../config/config.inc.php');
require_once('../classes/Database.class.php');
require_once('../classes/Usuario.class.php');
require_once('../classes/Perfil.class.php'); // Adicione esta linha

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Capturando os dados do formulário
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];
        $confirmacao_senha = $_POST['confirmacao_senha'];

        // Validando senha e confirmação de senha
        if ($senha !== $confirmacao_senha) {
            throw new Exception("As senhas não coincidem!");
        }

        // Criação de um novo objeto Usuario
        $novo_usuario = new Usuario($usuario, $senha);

        // Incluindo o novo usuário no banco de dados
        if ($novo_usuario->incluir()) {
            $usuario_id = $novo_usuario->autenticar(); // Recupere o ID do usuário recém-criado

            // Criação de um novo perfil associado ao ID do usuário
            $perfil = new Perfil($usuario_id);
            if ($perfil->incluir()) {
                header('Location: index.php');
                exit();
            } else {
                throw new Exception("Erro ao criar perfil do usuário.");
            }
        } else {
            throw new Exception("Erro ao cadastrar usuário. Tente novamente.");
        }
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header('Location: cadastro.php');
        exit();
    }
}

?>
