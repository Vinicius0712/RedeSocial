<?php
session_start();
require_once('../config/config.inc.php');
require_once('../classes/Database.class.php'); 
require_once('../classes/Usuario.class.php'); 

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // para onde o usuário será redirecionado após um erro
        $previous_page = $_SERVER['HTTP_REFERER'] ?? 'index.php';

        // Criação de um objeto da classe Usuario
        $usuario = new Usuario($_POST['usuario'], $_POST['senha']);

        $userId = $usuario->autenticar();

        if ($userId) {
            $_SESSION['user_id'] = $userId; // Armazenando o ID do usuário na sessão
            header('Location: ../rede/index.php');
            exit(); 
        } else {
            $_SESSION['error_message'] = "Usuário ou senha incorretos";
            header('Location: ' . $previous_page);
            exit();
        }
    } catch (Exception $e) { 
        $error_message = $e->getMessage();
    }
}
