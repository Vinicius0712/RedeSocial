<?php
require_once('../classes/Marketplace.class.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID da mercadoria não fornecido.";
    exit();
}

$marketplace = new Marketplace();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $categoria = $_POST['categoria'];
    $localizacao = $_POST['localizacao'];

    try {
        $marketplace->editarMercadoria($id, $nome, $descricao, $preco, $categoria, $localizacao);
        header("Location: marketplace.php");
        exit();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

$produto = $marketplace->buscarMercadoriaPorId($id);
?>

<form method="POST">
    <input type="text" name="nome" value="<?= htmlspecialchars($produto['nome']); ?>" required>
    <textarea name="descricao"><?= htmlspecialchars($produto['descricao']); ?></textarea>
    <input type="number" name="preco" value="<?= htmlspecialchars($produto['preco']); ?>" required>
    <input type="text" name="localizacao" value="<?= htmlspecialchars($produto['localizacao']); ?>" required>
    <select name="categoria">
        <option value="Eletrônicos" <?= $produto['categoria'] == 'Eletrônicos' ? 'selected' : ''; ?>>Eletrônicos</option>
        <option value="Casa e Jardim" <?= $produto['categoria'] == 'Casa e Jardim' ? 'selected' : ''; ?>>Casa e Jardim</option>
        <option value="Outros" <?= $produto['categoria'] == 'Outros' ? 'selected' : ''; ?>>Outros</option>
    </select>
    <button type="submit">Salvar Alterações</button>
</form>
