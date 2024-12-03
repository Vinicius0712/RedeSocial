<?php
require_once('../classes/Database.class.php');
require_once('../vendor/autoload.php'); // Certifique-se de que o Cloudinary está instalado
use Cloudinary\Api\Upload\UploadApi;

header('Content-Type: application/json');

try {
    if (isset($_FILES['imagem']['tmp_name'])) {
        // Faz o upload da imagem no Cloudinary
        $upload = (new UploadApi())->upload($_FILES['imagem']['tmp_name'], [
            'folder' => 'synergy/perfil',
            'public_id' => 'usuario_' . $_SESSION['user_id'], 
            'overwrite' => true,
        ]);

        $urlImagem = $upload['secure_url'];

        // Atualiza o banco de dados
        require_once('../classes/Database.class.php');
        $db = new Database();
        $stmt = $db->prepare("UPDATE perfis SET foto_perfil = :foto WHERE usuario_id = :id");
        $stmt->bindParam(':foto', $urlImagem, PDO::PARAM_STR);
        $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(['sucesso' => true, 'url' => $urlImagem]);
    } else {
        throw new Exception('Nenhuma imagem foi enviada.');
    }
} catch (Exception $e) {
    echo json_encode(['sucesso' => false, 'erro' => $e->getMessage()]);
}
