<?php
require_once('../classes/Marketplace.class.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}


// Captura os filtros do formulário
$precoMax = $_GET['preco'] ?? null;
$localizacao = $_GET['localizacao'] ?? null;
$categoria = $_GET['categoria'] ?? null;

// Cria uma instância da classe Marketplace com os filtros fornecidos
$marketplace = new Marketplace($precoMax, $localizacao, $categoria);

try {
    // Busca as mercadorias com os filtros aplicados
    $mercadorias = $marketplace->buscarMercadorias();
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Synergy - Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/market.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    .accordion-button {
        color: #000;
    }

    .accordion-button:not(.collapsed) {
        background-color: #f8f9fa;
        color: #13678A;
    }

    .accordion-body ul li a {
        text-decoration: none;
        color: #13678A;
    }

    .accordion-body ul li a:hover {
        text-decoration: underline;
    }
</style>

<body>
    <?php include('../menu.php'); ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar com filtros -->
            <div class="col-md-3 col-lg-2 bg-white sidebar py-4" id="side">
                <a class="logo" href="#">
                    <img src="../img/synergy2.png" class="logo" alt="Synergy Logo" draggable="false">
                </a>
                <h4 class="site-name">Synergy</h4><br>

                <!-- Filtros -->
                <h5>Filtros</h5>
                <form method="GET" action="">
                    <div class="mb-3">
                        <label for="preco" class="form-label">Preço Máximo:</label>
                        <input type="number" class="form-control" id="preco" name="preco" placeholder="Ex: 100.00"
                            value="<?= htmlspecialchars($_GET['preco'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="localizacao" class="form-label">Localização:</label>
                        <input type="text" class="form-control" id="localizacao" name="localizacao"
                            placeholder="Ex: São Paulo" value="<?= htmlspecialchars($_GET['localizacao'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoria:</label>
                        <select class="form-control" id="categoria" name="categoria">
                            <option value="">Selecione uma Categoria</option>
                            <option value="Eletrônicos" <?= (isset($_GET['categoria']) && $_GET['categoria'] == 'Eletrônicos') ? 'selected' : '' ?>>Eletrônicos</option>
                            <option value="Casa e Jardim" <?= (isset($_GET['categoria']) && $_GET['categoria'] == 'Casa e Jardim') ? 'selected' : '' ?>>Casa e Jardim</option>
                            <option value="Outros" <?= (isset($_GET['categoria']) && $_GET['categoria'] == 'Outros') ? 'selected' : '' ?>>Outros</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                </form>

            </div>

            <!-- Conteúdo principal -->
            <main class="col-md-7">
                <div class="d-flex justify-content-between align-items-center my-4">
                    <h2 style="color: black;">Marketplace</h2>
                    <a href="adicionar_produto.php" class="btn btn-primary">Vender algo</a>
                </div>

                <!-- Exibindo as mercadorias -->
                <div class="row">
                    <?php foreach ($mercadorias as $produto): ?>
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card">
                                <div class="position-relative">
                                    <img src="<?php echo $produto['imagem'] ? '../uploads/' . htmlspecialchars($produto['imagem']) : '../img/default.jpg'; ?>"
                                        class="card-img-top" alt="Imagem do Produto">

                                    <!-- Menu de opções aqui -->
                                    <?php if ($_SESSION['user_id'] == $produto['usuario_id']): ?>
                                    <div class="dropdown position-absolute" style="top: 10px; right: 10px;">
                                    
                                        <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Ver detalhes</a></li>
                                            
                                                <li><a class="dropdown-item"
                                                        href="editar_produto.php?id=<?= $produto['id'] ?>">Editar mercadoria</a>
                                                </li>
                                                <li><a class="dropdown-item"
                                                        href="editar_produto.php?id=<?= $produto['id'] ?>">Excluir</a>
                                                </li>
                                            
                                        </ul>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <!-- Informações do produto -->
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3 profile-info">
                                        <?php
                                        $fotoPerfil = !empty($produto['foto_perfil']) ? '../img/' . htmlspecialchars($produto['foto_perfil']) : '../img/default.jpg';
                                        ?>
                                        <img src="<?= $fotoPerfil ?>" alt="Profile" class="rounded-circle me-3" width="40"
                                            height="40">
                                        <h5 class="card-title mb-0"><?= htmlspecialchars($produto['username']) ?></h5>
                                    </div>
                                    <strong>
                                        <h class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($produto['nome']); ?>
                                            </h5>
                                    </strong>
                                    <p class="card-text">R$ <?= number_format($produto['preco'], 2, ',', '.'); ?></p>
                                    <p class="text-muted"><?= htmlspecialchars($produto['localizacao']); ?></p>

                                    <a href="#" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#produtoModal"
                                        onclick="carregarDetalhes(<?= htmlspecialchars(json_encode($produto), ENT_QUOTES, 'UTF-8'); ?>)">
                                        Mais Informações
                                    </a>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </main>
        </div>
    </div>

   <!-- Modal de Detalhes do Produto -->
<div class="modal fade" id="produtoModal" tabindex="-1" aria-labelledby="produtoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="produtoModalLabel">Detalhes do Produto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-body-content">
                <!-- Conteúdo do produto será carregado aqui via JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function carregarDetalhes(produto) {
        const modalBody = document.getElementById('modal-body-content');

        // Formata a data para o padrão brasileiro (DD/MM/AAAA HH:MM:SS)
        const dataCadastro = new Date(produto.data_cadastro).toLocaleString('pt-BR');

        // Monta o conteúdo com os detalhes do produto
        modalBody.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <img src="${produto.imagem ? '../uploads/' + produto.imagem : '../img/default.jpg'}" class="img-fluid" alt="Imagem do Produto">
                </div>
                <div class="col-md-6">
                    <h4>${produto.nome}</h4>
                    <p><strong>Preço:</strong> R$ ${parseFloat(produto.preco).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</p>
                    <p><strong>Localização:</strong> ${produto.localizacao}</p>
                    <p><strong>Categoria:</strong> ${produto.categoria}</p>
                    <p><strong>Data de Cadastro:</strong> ${dataCadastro}</p>
                    <p><strong>Descrição:</strong></p>
                    <p>${produto.descricao ? produto.descricao : 'Sem descrição fornecida.'}</p>
                    <hr>
                    <p><strong>Vendedor:</strong> ${produto.username}</p>
                </div>
            </div>
        `;
    }
</script>

</body>

</html>