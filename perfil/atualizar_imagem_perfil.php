<?php
// Inclua a conexão com o banco de dados
require_once('../classes/Database.class.php'); // Ajuste o caminho conforme necessário

session_start(); // Certifique-se de que a sessão esteja iniciada, pois você está usando $_SESSION['user_id']

// Código de upload de imagem
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fileTmpPath = $_FILES['imagem']['tmp_name'];
    $fileName = $_FILES['imagem']['name'];
    $fileSize = $_FILES['imagem']['size'];
    $fileType = $_FILES['imagem']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
    $uploadFileDir = '../uploads/';
    $dest_path = $uploadFileDir . $newFileName;

    if (move_uploaded_file($fileTmpPath, $dest_path)) {
        // Atualizar a imagem de perfil no banco de dados
        $queryAtualizaImagem = $db->prepare("UPDATE usuarios SET foto_perfil = :foto_perfil WHERE id = :usuario_id");
        $queryAtualizaImagem->bindParam(':foto_perfil', $newFileName, PDO::PARAM_STR);
        $queryAtualizaImagem->bindParam(':usuario_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $queryAtualizaImagem->execute();

        // Redirecionar para o perfil com sucesso
        header("Location: perfil.php?sucesso=1");
    } else {
        // Falha no upload
        header("Location: perfil.php?erro=erro_upload");
    }
}
?>
