<?php
require_once('../classes/Database.class.php');
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}

// Conexão com o banco de dados
$db = Database::getInstance();

// Verifica se o diretório de uploads existe, caso contrário, cria-o
if (!file_exists('../uploads')) {
    mkdir('../uploads', 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descricao = htmlspecialchars($_POST['descricao'], ENT_QUOTES, 'UTF-8');
    $usuario_id = $_SESSION['user_id'];

    // Verifica se a imagem foi enviada e não ocorreu erro no upload
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagemTmp = $_FILES['imagem']['tmp_name'];
        $imagemNome = basename($_FILES['imagem']['name']);
        $diretorioDestino = "../uploads/" . $imagemNome;

        // Move o arquivo para o diretório de destino
        if (move_uploaded_file($imagemTmp, $diretorioDestino)) {
            // Inserir a publicação no banco de dados
            try {
                $query = $db->prepare("INSERT INTO publicacoes (usuario_id, imagem, descricao) VALUES (:usuario_id, :imagem, :descricao)");
                $query->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
                $query->bindParam(':imagem', $imagemNome, PDO::PARAM_STR);
                $query->bindParam(':descricao', $descricao, PDO::PARAM_STR);

                if ($query->execute()) {
                    header("Location: perfil.php");
                    exit();
                } else {
                    echo "Erro ao salvar a publicação no banco de dados.";
                }
            } catch (PDOException $e) {
                echo "Erro na inserção da publicação: " . $e->getMessage();
            }
        } else {
            echo "Erro ao mover o arquivo para o diretório de uploads.";
        }
    } else {
        echo "Erro no upload da imagem: " . $_FILES['imagem']['error'];
    }
}
?>
