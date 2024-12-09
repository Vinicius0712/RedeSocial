<?php
require_once('../classes/Produto.class.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Captura os dados do formulário
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];
        $categoria = $_POST['categoria'];
        $localizacao = $_POST['localizacao'];
        $usuarioId = $_SESSION['user_id'];

        // Cria uma instância da classe Produto
        $produto = new Produto($nome, $descricao, $preco, $categoria, $localizacao, $usuarioId);

        // Realiza o upload da imagem, se houver
        if (isset($_FILES['imagem'])) {
            $produto->uploadImagem($_FILES['imagem']);
        }

        // Salva o produto no banco de dados
        $produto->salvar();

        // Redireciona após o cadastro bem-sucedido
        header("Location: marketplace.php");
        exit();
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto</title>
    <link rel="stylesheet" href="../css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<?php include('../menu.php'); ?>
<style>
   .btn-primary {
    background-color: #21695f;
    border-color: #185249;
}

.btn-primary:hover {
    background-color: #185249;
    border-color: #185249;
}

.btn-outline-primary {
    color: #21695f;
    border-color: #21695f;
}

.btn-outline-primary:hover {
    background-color: #2e7469;
    color: #fff;
}
</style>
    <div class="container">
        <h2 class="my-4">Cadastrar Novo Produto</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Produto:</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição:</label>
                <textarea class="form-control" id="descricao" name="descricao" required></textarea>
            </div>
            <div class="mb-3">
                <label for="preco" class="form-label">Preço:</label>
                <input type="number" step="0.01" class="form-control" id="preco" name="preco" required>
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria:</label>
                <input type="text" class="form-control" id="categoria" name="categoria" required>
            </div>
            <div class="mb-3">
                <label for="localizacao" class="form-label">Localização:</label>
                <input type="text" class="form-control" id="localizacao" name="localizacao" required>
            </div>
            <div class="mb-3">
                <label for="imagem" class="form-label">Imagem:</label>
                <input type="file" class="form-control" id="imagem" name="imagem">
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar Produto</button>
            <a href="marketplace.php" style="display: inline-block; padding: 8px 20px; background-color: #6c757d; color: #fff; text-decoration: none; border-radius: 5px; font-size: 15px;">Voltar</a>

        </form>
    </div>
</body>
</html>
