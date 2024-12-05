<?php
// Inclui o arquivo com os dados do perfil
require_once('perfil_dados.php');

// Conexão com o banco de dados (supondo que você já tenha isso configurado)
require_once('../classes/Database.class.php');
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
            <a href="#" class="edit-icon position-absolute" style="top: 10px; right: 10px;" data-bs-toggle="modal" data-bs-target="#editarImagemModal">
    <i class="fas fa-edit"></i>
</a>

            <!-- Imagem do perfil -->
            <img src="<?php echo htmlspecialchars($fotoPerfil); ?>" alt="Foto de Perfil" class="rounded-circle"
                width="150" height="150" draggable="false">

            <!-- Informações do perfil -->
            <div class="profile-info mt-3">
                <h3><?php echo htmlspecialchars($nomeUsuario); ?></h3>
                <p>@<?php echo htmlspecialchars($nomeUsuario); ?></p>
                <p>Seguidores: <strong><?php echo htmlspecialchars($seguidores); ?></strong> | Seguindo:
                    <strong><?php echo htmlspecialchars($seguindo); ?></strong></p>

                <?php
                // Contando as publicações do usuário
                $queryContagemPublicacoes = $db->prepare("SELECT COUNT(*) AS total FROM publicacoes WHERE usuario_id = :usuario_id");
                $queryContagemPublicacoes->bindParam(':usuario_id', $_SESSION['user_id'], PDO::PARAM_INT);
                $queryContagemPublicacoes->execute();
                $resultadoContagem = $queryContagemPublicacoes->fetch(PDO::FETCH_ASSOC);
                $totalPublicacoes = $resultadoContagem['total'];
                ?>

                <p>Publicações: <strong><?php echo htmlspecialchars($totalPublicacoes); ?></strong></p>
            </div>
        </div>
    </div>

    <!-- Postagens do Usuário -->
    <div class="profile-details mt-4">
        <div class="d-flex justify-content-center nav-blocks mb-0">
            <div class="nav-block">
                <a href="#" class="nav-link-custom">
                    <h5>Publicações</h5>
                </a>
            </div>
            <div class="nav-block">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#publicarModal">
                    Nova Publicação
                </button>
            </div>
        </div>

        <!-- Exibindo as publicações do usuário -->
        <div class="row ">
    <?php
    // Consulta para buscar as publicações do usuário
    $queryPublicacoes = $db->prepare("SELECT * FROM publicacoes WHERE usuario_id = :usuario_id");
    $queryPublicacoes->bindParam(':usuario_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $queryPublicacoes->execute();
    $publicacoes = $queryPublicacoes->fetchAll(PDO::FETCH_ASSOC);

    if ($publicacoes) {
        foreach ($publicacoes as $publicacao) {
            echo '<div class="col-6 col-md-4 mb-4">'; // Define o tamanho das colunas para serem responsivas
            echo '<div class="post">'; 
            echo '<img src="../uploads/' . htmlspecialchars($publicacao['imagem']) . '" alt="Publicação">';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>Você ainda não fez nenhuma publicação.</p>';
    }
    ?>
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
                        <textarea class="form-control" id="descricao" name="descricao" rows="3" placeholder="Escreva uma descrição..."></textarea>
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

<div class="modal fade" id="editarImagemModal" tabindex="-1" aria-labelledby="editarImagemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarImagemModalLabel">Editar Imagem de Perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="atualizar_imagem_perfil.php" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="novaImagemPerfil" class="form-label">Selecione uma nova imagem</label>
                        <input type="file" class="form-control" id="novaImagemPerfil" name="novaImagemPerfil" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
    <div class="alert alert-success text-center" role="alert">
        Imagem de perfil atualizada com sucesso!
    </div>
<?php endif; ?>
<?php if (isset($_GET['erro'])): ?>
    <div class="alert alert-danger text-center" role="alert">
        Erro ao atualizar a imagem de perfil. Por favor, tente novamente.
    </div>
<?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>