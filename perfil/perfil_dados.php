<?php
// Inclui a classe Database para conectar ao banco de dados
require_once('../classes/Database.class.php');

// Inicia a sessão para verificar se o usuário está logado
session_start();

// Verifica se o usuário está logado, caso contrário, redireciona para o login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}

// Conecta ao banco de dados
$db = Database::getInstance();

if (!$db) {
    die("Erro ao conectar com o banco de dados.");
}

try {
    // Consulta para buscar os dados do usuário logado
    $query = $db->prepare("SELECT * FROM usuarios WHERE id = :id");
    $query->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
    $query->execute();
    $usuario = $query->fetch(PDO::FETCH_ASSOC); // Obtém os dados do usuário

    // Verifica se o usuário foi encontrado
    if ($usuario) {
        $nomeUsuario = $usuario['usuario']; // Nome de usuário

        // Consulta para buscar os dados do perfil
        $queryPerfil = $db->prepare("SELECT * FROM perfis WHERE usuario_id = :usuario_id");
        $queryPerfil->bindParam(':usuario_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $queryPerfil->execute();
        $perfil = $queryPerfil->fetch(PDO::FETCH_ASSOC); // Obtém os dados do perfil

        // Verifica se o perfil foi encontrado e define as variáveis
        if ($perfil) {
            $fotoPerfil = $perfil['foto_perfil'] ? "../img/" . $perfil['foto_perfil'] : '../img/default.jpg';
            $seguidores = $perfil['seguidores'];
            $seguindo = $perfil['seguindo'];
            $publicacoes = $perfil['publicacoes'];
        } else {
            echo "Perfil não encontrado!";
            exit();
        }
    } else {
        echo "Usuário não encontrado!";
        exit();
    }
} catch (PDOException $e) {
    echo "Erro na consulta: " . $e->getMessage();
    exit();
}
?>
