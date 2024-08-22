<?php
session_start();
require_once('../config/config.inc.php');
require_once('../classes/Database.class.php'); // Incluindo a classe Database
require_once('../classes/Usuario.class.php');  // Incluindo a classe Usuario

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Armazenando a URL anterior (para onde o usuário será redirecionado após um erro)
        $previous_page = $_SERVER['HTTP_REFERER'] ?? 'index.php';

        // Criação de um objeto da classe Usuario
        $usuario = new Usuario($_POST['usuario'], $_POST['senha']);

        // Tenta autenticar o usuário
        $userId = $usuario->autenticar();

        if ($userId) {
            // Autenticação bem-sucedida
            $_SESSION['user_id'] = $userId; // Armazenando o ID do usuário na sessão
            header('Location: ../rede/index.php');
            exit(); // Certifique-se de que o script para aqui após o redirecionamento
        } else {
            // Redirecionamento para a página anterior ao invés de exibir erro
            $_SESSION['error_message'] = "Usuário ou senha incorretos";
            header('Location: ' . $previous_page); // Redirecionando para a página anterior
            exit();
        }
    } catch (Exception $e) {
        // Captura qualquer exceção e define a mensagem de erro
        $error_message = $e->getMessage();
    }
}
