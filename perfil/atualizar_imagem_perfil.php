<?php
session_start();
require_once('../classes/Database.class.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}

// Obter a conexão com o banco de dados
$db = Database::getInstance();

// Processar o envio do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['novaImagemPerfil'])) {
    $userId = $_SESSION['user_id'];
    $imagem = $_FILES['novaImagemPerfil'];

    // Verifica se o upload foi bem-sucedido
    if ($imagem['error'] === UPLOAD_ERR_OK) {
        $pastaDestino = '../uploads/';
        $nomeArquivo = uniqid() . '-' . basename($imagem['name']);
        $caminhoArquivo = $pastaDestino . $nomeArquivo;

        if (move_uploaded_file($imagem['tmp_name'], $caminhoArquivo)) {
            // Atualiza o caminho da imagem no banco de dados
            $query = $db->prepare("UPDATE perfis SET foto_perfil = :foto_perfil WHERE usuario_id = :usuario_id");
            $query->bindParam(':foto_perfil', $caminhoArquivo, PDO::PARAM_STR);
            $query->bindParam(':usuario_id', $userId, PDO::PARAM_INT);

            if ($query->execute()) {
                header("Location: perfil.php?sucesso=1");
                exit();
            } else {
                header("Location: perfil.php?erro=1");
                exit();
            }
        } else {
            header("Location: perfil.php?erro=1");
            exit();
        }
    } else {
        header("Location: perfil.php?erro=1");
        exit();
    }
} else {
    header("Location: perfil.php");
    exit();
}
?>
