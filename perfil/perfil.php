<?php
// Inclui o arquivo com os dados do perfil
require_once('perfil_dados.php');
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
            display: inline-block;
            margin: 10px;
            width: 30%;
        }

        .post img {
            width: 100%;
            border-radius: 10px;
        }

        .profile-details {
            text-align: center;
        }

        .btn-full {
            width: 100%;
            margin-bottom: 10px;
        }

        .edit-icon {
    font-size: 20px;
    color: #007bff;
    text-decoration: none;
    color: #27776b;
}

.edit-icon:hover {
    color: #0056b3;
}

    </style>
</head>

<body>
<?php include('../menu.php'); ?>

    <!-- Profile Header -->
    <div class="container mt-5">
    <div class="profile-header position-relative text-center">
        <!-- Ícone de edição no canto superior direito -->
        <a href="#" class="edit-icon position-absolute" style="top: 10px; right: 10px;">
            <i class="fas fa-edit"></i>
        </a>

        <!-- Imagem do perfil -->
        <img src="<?php echo htmlspecialchars($fotoPerfil); ?>" alt="Foto de Perfil" class="rounded-circle" width="150" height="150" draggable="false">
        
        <!-- Informações do perfil -->
        <div class="profile-info mt-3">
            <h3><?php echo htmlspecialchars($nomeUsuario); ?></h3>
            <p>@<?php echo htmlspecialchars($nomeUsuario); ?></p>
            <p>Seguidores: <strong><?php echo htmlspecialchars($seguidores); ?></strong> | Seguindo: <strong><?php echo htmlspecialchars($seguindo); ?></strong></p>
            <p>Publicações: <strong><?php echo htmlspecialchars($publicacoes); ?></strong></p>
        </div>
    </div>

   <!-- Postagens do Usuário -->
<div class="profile-details mt-4">
    <!-- Blocos de navegação para diferentes seções -->
    <div class="d-flex justify-content-center nav-blocks mb-3">
        <div class="nav-block">
            <a href="#" class="nav-link-custom">Publicações</a>
        </div>
        <div class="nav-block">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#publicarModal">
        Nova Publicação
    </button>
        </div>
    </div>


<!-- Modal do Formulário -->
<div class="modal fade" id="publicarModal" tabindex="-1" aria-labelledby="publicarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="publicarModalLabel">Nova Publicação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="adicionar_publicacao.php" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="imagem" class="form-label">Imagem da Publicação</label>
                        <input type="file" class="form-control" id="imagem" name="imagem" required>
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Publicar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
