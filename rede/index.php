<?php
// Inclui a classe Database para conectar ao banco de dados
require_once('../classes/Database.class.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}

$db = Database::getInstance();

if (!$db) {
    die("Erro ao conectar com o banco de dados.");
}

try {
    // Consulta SQL para obter as publicações junto com os dados do usuário
    $query = $db->prepare("SELECT publicacoes.*, usuarios.usuario AS username, perfis.foto_perfil 
                           FROM publicacoes 
                           JOIN usuarios ON publicacoes.usuario_id = usuarios.id
                           JOIN perfis ON usuarios.id = perfis.usuario_id
                           ORDER BY publicacoes.created_at DESC");
    $query->execute();
    $publicacoes = $query->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erro ao buscar publicações: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Synergy - Página Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/index.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include('../menu.php'); ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-none d-md-block bg-white sidebar py-4" id="side">
                <a class="logo" href="#">
                    <img src="../img/synergy2.png" class="logo" alt="Synergy Logo">
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

            <main class="col-md-7 content-background">
                <div class="d-flex align-items-center my-4 stories">
                    <img src="https://via.placeholder.com/60" alt="Story 1">
                    <img src="https://via.placeholder.com/60" alt="Story 2">
                    <img src="https://via.placeholder.com/60" alt="Story 3">
                    <img src="https://via.placeholder.com/60" alt="Story 4">
                </div>

                <!-- Loop para exibir as publicações -->
                <?php foreach ($publicacoes as $publicacao): ?>
                    <div class="card mb-2 post">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3 profile-info">
                                <?php
                                $fotoPerfil = !empty($publicacao['foto_perfil']) ? '../img/' . htmlspecialchars($publicacao['foto_perfil']) : '../img/default.jpg' ;
                                ?>
                                <img src="<?= $fotoPerfil ?>" alt="Profile" class="rounded-circle" width="50" height="50">
                                <div>
                                    <h5 class="card-title mb-0"><?= htmlspecialchars($publicacao['username']) ?></h5>
                                    <p class="card-text"><small
                                            class="text-muted"><?= date('d M Y H:i', strtotime($publicacao['created_at'])) ?></small>
                                    </p>
                                </div>
                            </div>
                            <img src="../uploads/<?= htmlspecialchars($publicacao['imagem']) ?>" class="card-img-top" alt="Publicação">
                            <p class="card-text mt-3"><?= htmlspecialchars($publicacao['descricao']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </main>

            <!-- Suggestions -->
            <aside class="col-lg-3 d-none d-lg-block suggestions py-3">
                <h5>Seus Grupos</h5>
                <div class="d-flex align-items-center mb-3 suggestion">
                    <button class="sug"><img src="https://via.placeholder.com/40" alt="Sugestão 1"> Grupo 1</button>
                </div>
                <div class="d-flex align-items-center mb-3 suggestion">
                    <button class="sug"><img src="https://via.placeholder.com/40" alt="Sugestão 2"> Grupo 2</button>
                </div>
                <div class="d-flex align-items-center mb-3 suggestion">
                    <button class="sug"><img src="https://via.placeholder.com/40" alt="Sugestão 3"> Grupo 3</button>
                </div>
            </aside>
        </div>
    </div>
</body>

<script>
    window.addEventListener('scroll', function () {
        var logo = document.querySelector('.logo img');
        var siteName = document.getElementById('siteName');

        // Verifica se a página foi rolada mais de 100px
        if (window.scrollY > 90) {
            siteName.classList.add('show');
        } else {
            siteName.classList.remove('show');
        }
    });
</script>

</html>