<?php
// Inclui a classe Database para conectar ao banco de dados
require_once('../classes/Database.class.php');

session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}

// Conecta ao banco de dados
$db = Database::getInstance();

if (!$db) {
    die("Erro ao conectar com o banco de dados.");
}

// Consulta para obter as mercadorias cadastradas
try {
    $query = $db->prepare("SELECT mercadorias.*, usuarios.usuario AS username, perfis.foto_perfil 
                           FROM mercadorias 
                           JOIN usuarios ON mercadorias.usuario_id = usuarios.id 
                           JOIN perfis ON usuarios.id = perfis.usuario_id 
                           ORDER BY mercadorias.data_cadastro DESC");
    $query->execute();
    $mercadorias = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar mercadorias: " . $e->getMessage();
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
    <link rel="stylesheet" href="../css/index.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include('../menu.php'); ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-none d-md-block bg-white sidebar py-4" id="side">
                <a class="logo" href="#">
                    <img src="../img/synergy2.png" class="logo" alt="Synergy Logo" draggable="false">
                </a>
                <h4 class="site-name" id="siteName">Synergy</h4><br>
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="fas fa-home"></i> Página Inicial</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../perfil/perfil.php"><i class="fas fa-user"></i> Meu Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-comments"></i> Mensagens</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-cog"></i> Configurações</a>
                    </li>
                    <li class="sair-link">
                        <a class="nav-link" href="../acao/logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
                    </li>
                </ul>
            </div>

            <!-- Área principal do Marketplace -->
            <main class="col-md-7 content-background">
                <div class="d-flex justify-content-between align-items-center my-4">
                    <h2>Marketplace</h2>
                    <a href="adicionar_produto.php" class="btn btn-primary">Vender algo</a>
                </div>

                <!-- Exibindo as mercadorias -->
                <div class="row">
                    <?php foreach ($mercadorias as $produto): ?>
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card">
                                <!-- Imagem do produto -->
                                <img src="<?php echo $produto['imagem'] ? '../uploads/' . htmlspecialchars($produto['imagem']) : '../img/default.jpg'; ?>" class="card-img-top" alt="Imagem do Produto">
                                
                                <!-- Informações do produto -->
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3 profile-info">
                                        <?php
                                        $fotoPerfil = !empty($produto['foto_perfil']) ? '../img/' . htmlspecialchars($produto['foto_perfil']) : '../img/default.jpg';
                                        ?>
                                        <img src="<?= $fotoPerfil ?>" alt="Profile" class="rounded-circle me-3" width="40" height="40">
                                        <h5 class="card-title mb-0"><?= htmlspecialchars($produto['username']) ?></h5>
                                    </div>
                                    <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($produto['nome']); ?></h6>
                                    <p class="card-text">R$ <?= number_format($produto['preco'], 2, ',', '.'); ?></p>
                                    <p class="text-muted"><?= htmlspecialchars($produto['localizacao']); ?></p>
                                    <a href="#" class="btn btn-outline-primary">Ver detalhes</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </main>

            <!-- Barra de sugestões -->
            <aside class="col-lg-3 d-none d-lg-block suggestions py-3">
                <h5>Categorias</h5>
                <ul class="list-group">
                    <li class="list-group-item"><a href="#">Eletrônicos</a></li>
                    <li class="list-group-item"><a href="#">Casa e Jardim</a></li>
                    <li class="list-group-item"><a href="#">Vestuário</a></li>
                    <li class="list-group-item"><a href="#">Esportes</a></li>
                    <li class="list-group-item"><a href="#">Veículos</a></li>
                    <li class="list-group-item"><a href="#">Serviços</a></li>
                    <li class="list-group-item"><a href="#">Outros</a></li>
                </ul>
            </aside>
        </div>
    </div>
</body>

</html>
