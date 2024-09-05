<?php
require_once('../config/config.inc.php');
require_once('../classes/Database.class.php');
require_once('../classes/Usuario.class.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Capturando os dados do formulário
        $usuario = $_POST['usuario'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $confirmacao_senha = $_POST['confirmacao_senha'];

        // Validando senha e confirmação de senha
        if ($senha !== $confirmacao_senha) {
            throw new Exception("As senhas não coincidem!");
        }

        // Criação de um novo objeto Usuario
        $novo_usuario = new Usuario($usuario, $senha); // Incluindo email no construtor

        // Incluindo o novo usuário no banco de dados
        if ($novo_usuario->incluir()) {
            // Redireciona para a página de login após o cadastro bem-sucedido
            header('Location: index.php');
            exit();
        } else {
            throw new Exception("Erro ao cadastrar usuário. Tente novamente.");
        }
    } catch (Exception $e) {
        // Armazena a mensagem de erro na sessão
        $_SESSION['error_message'] = $e->getMessage();
        header('Location: cadastro.php');
        exit();
    }
}
?>
