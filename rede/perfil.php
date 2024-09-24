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
    <title>Synergy - Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/perfil.css">
    <style>
        .post {
            display: inline-block; /* Faz as postagens ficarem lado a lado */
            margin: 10px; /* Margem entre as postagens */
            width: 30%; /* Define a largura de cada postagem */
        }

        .post img {
            width: 100%; /* Faz com que a imagem ocupe toda a largura do contêiner */
            border-radius: 10px; /* Bordas arredondadas para as imagens */
        }

        .profile-details {
            text-align: center; /* Centraliza o conteúdo */
        }

        .btn-full {
            width: 100%; /* Faz os botões ocuparem toda a largura da div */
            margin-bottom: 10px; /* Margem inferior para espaçamento */
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
        <div class="container-fluid">
            <h2 class="brand-name"><a href="index.php" style="text-decoration: none; color: inherit;">Synergy</a></h2>
            <div class="collapse navbar-collapse justify-content-center order-lg-2">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><i class="fas fa-home"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-user-friends"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-store"></i></a>
                    </li>
                </ul>
            </div>
            <div class="d-flex order-lg-3">
                <a href="#" class="nav-link"><i class="fas fa-bell"></i><span class="badge bg-danger">17</span></a>
                <a href="#" class="nav-link profile"><img src="https://via.placeholder.com/40" alt="Profile" class="profile-icon"></a>
            </div>
        </div>
    </nav>

    <!-- Profile Header -->
    <div class="container mt-5">
        <div class="profile-header text-center">
            <img src="https://via.placeholder.com/150" alt="Foto de Perfil" class="rounded-circle">
            <div class="profile-info mt-3">
                <h3>Nome do Usuário</h3>
                <p>@nome_de_usuario</p>
                <p>Seguidores: <strong>150</strong> | Seguindo: <strong>75</strong></p> <!-- Quantidade de seguidores e seguindo -->
            </div>
            <div class="mt-4 text-center">
                <button class="btn btn-primary">Editar Perfil</button>
            </div>
        </div>

        <!-- Postagens do Usuário -->
        <div class="profile-details mt-4">
            <button class="btn btn-secondary">Publicações</button>
            <button class="btn btn-secondary">Fotos</button>
            <button class="btn btn-secondary">Vídeos</button>
            <button class="btn btn-secondary">Outras Opções</button>

            <h4>Publicações</h4>
            <div class="post">
                <img src="https://via.placeholder.com/400x200" alt="Publicação 1">
            </div>
            <div class="post">
                <img src="https://via.placeholder.com/400x200" alt="Publicação 2">
            </div>
            <div class="post">
                <img src="https://via.placeholder.com/400x200" alt="Publicação 3">
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>