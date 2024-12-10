<?php
session_start();
require_once('../classes/Database.class.php');

// Verifique se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}

// Verifique se os IDs de usuário estão disponíveis
if (!isset($_POST['seguido_id'])) {
    die("ID do usuário a ser seguido não especificado.");
}

$seguidor_id = $_SESSION['user_id'];
$seguido_id = intval($_POST['seguido_id']);

try {
    // Conexão com o banco de dados
    $db = new PDO('mysql:host=localhost;dbname=rede', 'Vinn', 'Vinn');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifique se o usuário já segue o outro
    $queryCheck = $db->prepare("SELECT COUNT(*) AS total FROM seguidores WHERE seguidor_id = :seguidor_id AND seguido_id = :seguido_id");
    $queryCheck->bindParam(':seguidor_id', $seguidor_id, PDO::PARAM_INT);
    $queryCheck->bindParam(':seguido_id', $seguido_id, PDO::PARAM_INT);
    $queryCheck->execute();

    $isFollowing = $queryCheck->fetch(PDO::FETCH_ASSOC)['total'] > 0;

    if ($isFollowing) {
        // Se já segue, então deixar de seguir
        $queryUnfollow = $db->prepare("DELETE FROM seguidores WHERE seguidor_id = :seguidor_id AND seguido_id = :seguido_id");
        $queryUnfollow->bindParam(':seguidor_id', $seguidor_id, PDO::PARAM_INT);
        $queryUnfollow->bindParam(':seguido_id', $seguido_id, PDO::PARAM_INT);
        $queryUnfollow->execute();

        // Atualizar contadores
        $db->exec("UPDATE perfis SET seguidores = seguidores - 1 WHERE usuario_id = $seguido_id");
        $db->exec("UPDATE perfis SET seguindo = seguindo - 1 WHERE usuario_id = $seguidor_id");
    } else {
        // Caso contrário, seguir o usuário
        $queryFollow = $db->prepare("INSERT INTO seguidores (seguidor_id, seguido_id) VALUES (:seguidor_id, :seguido_id)");
        $queryFollow->bindParam(':seguidor_id', $seguidor_id, PDO::PARAM_INT);
        $queryFollow->bindParam(':seguido_id', $seguido_id, PDO::PARAM_INT);
        $queryFollow->execute();

        // Atualizar contadores
        $db->exec("UPDATE perfis SET seguidores = seguidores + 1 WHERE usuario_id = $seguido_id");
        $db->exec("UPDATE perfis SET seguindo = seguindo + 1 WHERE usuario_id = $seguidor_id");
    }

    // Redirecionar para o perfil
    header("Location: perfil.php?user_id=$seguido_id");
    exit();
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
