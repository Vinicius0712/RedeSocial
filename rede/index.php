<?php
session_start();

// Verifica se o usuário está logado, caso contrário redireciona para o login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
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

                    <!-- Sair -->
                    <li class="sair-link">
                        <a class="nav-link" href="../acao/logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <main class="col-md-7 content-background">
                <!-- Stories -->
                <div class="d-flex align-items-center my-4 stories">
                    <img src="https://via.placeholder.com/60" alt="Story 1">
                    <img src="https://via.placeholder.com/60" alt="Story 2">
                    <img src="https://via.placeholder.com/60" alt="Story 3">
                    <img src="https://via.placeholder.com/60" alt="Story 4">
                </div>

                <div class="card mb-2 post">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3 profile-info">
                            <img src="https://via.placeholder.com/50" alt="Profile">
                            <div>
                                <h5 class="card-title mb-0">Nome do Usuário</h5>
                                <p class="card-text"><small class="text-muted">2 horas atrás</small></p>
                            </div>
                        </div>
                        <img src="../img/jantar.png" class="card-img-top" alt="Publicação">
                        <p class="card-text mt-3">Descrição da publicação aqui...</p>
                    </div>
                </div>

                <!-- Another Post -->
                <div class="card mb-2 post">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3 profile-info">
                            <img src="https://via.placeholder.com/50" alt="Profile">
                            <div>
                                <h5 class="card-title mb-0">Nome do Usuário</h5>
                                <p class="card-text"><small class="text-muted">4 horas atrás</small></p>
                            </div>
                        </div>
                        <img src="../img/parque.jpg" class="card-img-top" alt="Publicação">
                        <p class="card-text mt-3">Descrição da publicação aqui...</p>
                    </div>
                </div>

                <div class="card mb-2 post">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3 profile-info">
                            <img src="https://via.placeholder.com/50" alt="Profile">
                            <div>
                                <h5 class="card-title mb-0">Nome do Usuário</h5>
                                <p class="card-text"><small class="text-muted">4 horas atrás</small></p>
                            </div>
                        </div>
                        <img src="../img/casal.jpg" class="card-img-top" alt="Publicação">
                        <p class="card-text mt-3">Descrição da publicação aqui...</p>
                    </div>
                </div>
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
    window.addEventListener('scroll', function() {
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
